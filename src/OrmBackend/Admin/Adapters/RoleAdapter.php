<?php
namespace OrmBackend\Admin\Adapters;

use App\Model\Role;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use OrmBackend\Admin\Controllers\AdminControllerAdapter;
use OrmBackend\ORM\Entities\Entity;
use OrmBackend\Web\Fields\FieldContainer;

class RoleAdapter extends AdminControllerAdapter
{
    
    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::search()
     */
    public function search(Request $request, string $classUrlName, string $group)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::edit()
     */
    public function edit(Request $request, Entity $entity, string $group)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::create()
     */
    public function create(Request $request, string $classUrlName, string $group)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::update()
     */
    public function update(Request $request, string $classUrlName, $id, string $group)
    {
        [$url, $alias] = $this->saveOrUpdate($request, $classUrlName, $group);
        
        return redirect($url.'?order[]=-'.$alias.'.updatedAt')->with('success', __('Record updated successfully.'));
    }

    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::details()
     */
    public function details(Request $request, Entity $entity, string $group)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::store()
     */
    public function store(Request $request, string $classUrlName, string $group)
    {
        [$url, $alias] = $this->saveOrUpdate($request, $classUrlName, $group);
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Record created successfully.'));
    }

    /**
     * 
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::delete()
     */
    public function delete(Request $request, string $classUrlName, $id, string $group)
    {
        $classShortName = (new \ReflectionClass(Role::class))->getShortName();
        $alias = lcfirst($classShortName);
        $url = route('admin.'.$group.'.search', $classUrlName);
        
        /**
         * 
         * @var \App\Model\Role $role
         */
        $role = $this->repository->findOrFail(Role::class, $id);
        
        if ($role->isSystem()) {
            throw ValidationException::withMessages([ __('Unable to remove the system role.')]);
        }
        
        $this->repository->delete(Role::class, $id);
        
        try {
            $this->repository->em()->flush();
        } catch (ForeignKeyConstraintViolationException $e) {
            $message = config('app.debug') ? $e->getMessage() : __('Cannot delete or update a parent row');
            return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('warning', $message);
        }
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Record deleted successfully.'));
    }

    
    private function saveOrUpdate(Request $request, string $classUrlName, string $group)
    {
        $classShortName = (new \ReflectionClass(Role::class))->getShortName();
        $alias = lcfirst($classShortName);
        $data = $request->post($classUrlName);
        $permissions = $request->post('permissions', []);
        $data['permission'] = 0;
        
        if (!isset($data['system'])) {
            $data['system'] = 0;
        }
        
        foreach ($permissions as $permission) {
            $data['permission'] = $data['permission'] | (int) $permission;
        }
        
        try {
            $map = FieldContainer::readRequest([$classUrlName => $data]);

            foreach ($map as $className => $data) {
                Validator::make($data, $className::getRequestValidationRules())->validate();
                $this->repository->createOrUpdate($className, $data);
            }
            
            $this->repository->em()->flush();
        } catch (ValidationException $e) {
            $messages = FieldContainer::exceptionToMessages($e, $classUrlName);
            
            throw ValidationException::withMessages($messages);
        }
        
        $url = route('admin.'.$group.'.search', $classUrlName);
        
        return [$url, $alias];
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::trash()
     */
    public function trash(Request $request, string $classUrlName, string $group)
    {
        return null;
    }

}
