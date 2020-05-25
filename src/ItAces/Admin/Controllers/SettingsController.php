<?php
namespace ItAces\Admin\Controllers;

use App\Model\EntityPermission;
use App\Model\Role;
use Illuminate\Http\Request;
use ItAces\Controllers\WebController;
use ItAces\Repositories\WithJoinsRepository;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;
use ItAces\View\EntityContainer;

class SettingsController extends WebController
{
    
    public function __construct()
    {
        $this->repository = new WithJoinsRepository(true);
    }
    
    /**
     *
     * @param \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request, string $classUrlName)
    {
        $alias = Helper::aliasFromClass(EntityPermission::class);
        
        /**
         * 
         * @var \App\Model\EntityPermission[] $entityPermissions
         */
        $entityPermissions = $this->repository->getQuery(EntityPermission::class, [
            'filter' => [
                [$alias.'.model', 'eq', $classUrlName]
            ]
        ], $alias)->getResult();
        
        /**
         *
         * @var \App\Model\EntityPermission[] $permissions
         */
        $permissions = [];
        $guestId = 0;
        
        foreach ($entityPermissions as $entityPermission) {
            $roleId = $entityPermission->getRole()->getId();
            $permissions[$roleId] = $entityPermission;
        }

        /**
         * 
         * @var \App\Model\Role[] $roles
         */
        $roles = $this->repository->getQuery(Role::class)->getResult();
        
        foreach ($roles as $role) {
            if ($role->getCode() === config('itaces.roles.guest', 'guest')) {
                $guestId = $role->getId();
            }
            
            if (!array_key_exists($role->getId(), $permissions)) {
                $entityPermission = new EntityPermission();
                $entityPermission->setModel($classUrlName);
                $entityPermission->setRole($role);
                $entityPermission->setPermission($role->getPermission());
                $permissions[$role->getId()] = $entityPermission;
            }
        }
        
        ksort($permissions);
        $permissions = array_values($permissions);
        $container = new EntityContainer($this->repository->em());
        $container->addCollection($permissions);
        
        $meta = [
            'class' => Helper::classFromUlr($classUrlName),
            'title' => __( Str::pluralCamelWords(Helper::classShortFromUrl($classUrlName)) ),
            'classUrlName' => $classUrlName
        ];
        
        return view($this->views[$classUrlName]['settings']['permissions'] ?? 'itaces::admin.settings.permissions', [
            'container' => $container,
            'meta' => $meta,
            'formAction' => route('admin.entity.settings.permissions.update', [$classUrlName]),
            'guestId' => $guestId
        ]);
    }
    
    public function updatePermissions(Request $request, string $classUrlName)
    {
        $model = Helper::classToUlr(EntityPermission::class);
        $data = $request->post($model);
        $permissions = $request->post('permissions');
        $reset = $request->post('reset');
        $delete = [];
        $save = [];
        $default = [];
        
        /**
         *
         * @var \App\Model\Role[] $roles
         */
        $roles = $this->repository->getQuery(Role::class)->getResult();
            
        foreach ($roles as $role) {
            $default[$role->getId()] = $role->getPermission();
        }

        foreach ($data as $index => $value) {
            $data[$index]['permission'] = 0;
            $role = $value['role'];
            
            /**
             * If a reset is set, do not save the permission; instead, set it to delete
             */
            if ($reset && $value['id'] && in_array($value['id'], $reset)) {
                $delete[] = $value['id'];
                
                continue;
            }
            
            /**
             * When nothing is checked, the permission field is missing on request
             */
            if (!$permissions || !array_key_exists($role, $permissions)) {
                
                /**
                 * Do not save permission if it is the same as default
                 */
                if ($data[$index]['permission'] !== $default[$role]) {
                    $save[$index] = $data[$index];
                }
                
                continue;
            }
            
            if ($permissions) {
                /**
                 * Calculating a bitmask and store it in the data array
                 */
                foreach ($permissions[$role] as $permission) {
                    $data[$index]['permission'] |= (int) $permission;
                }

                /**
                 * Do not save permission if it is the same as default
                 */
                if ($data[$index]['permission'] !== $default[$role]) {
                    $save[$index] = $data[$index];
                }
            }
        }

        /**
         * Flashing the data per session for correct the old function support
         */
        $request->merge([$model => $data]);
        $this->repository->saveEntityContainer([$model => $save], [EntityPermission::class => $delete]);
        $url = route('admin.entity.search', $classUrlName);
        
        return redirect($url)->with('success', __('Settings updated successfully.'));
    }

}
