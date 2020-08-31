<?php
namespace OrmBackend\Admin\Adapters;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use OrmBackend\Admin\Controllers\AdminControllerAdapter;
use OrmBackend\ORM\Entities\Entity;
use OrmBackend\Utility\Helper;

/**
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
class UserAdapter extends AdminControllerAdapter
{
    
    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::create()
     */
    public function create(Request $request, string $classUrlName, string $group)
    {
        return view($this->views[$classUrlName]['create'] ?? 'itaces::admin.user.create', [
            'roles' => $this->repository->getQuery(Role::class)->getResult()
        ]);
    }
    
    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::edit()
     */
    public function edit(Request $request, Entity $entity, string $group)
    {
        $classUrlName = Helper::classToUrl(get_class($entity));
        
        return view($this->views[$classUrlName]['edit'] ?? 'itaces::admin.user.edit', [
            'roles' => $this->repository->getQuery(Role::class)->getResult(),
            'user' => $entity
        ]);
    }
    
    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::details()
     */
    public function details(Request $request, Entity $entity, string $group)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::search()
     */
    public function search(Request $request, string $classUrlName, string $group)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::store()
     */
    public function store(Request $request, string $classUrlName, string $group)
    {
        $request->validate(User::getRequestValidationRules());
        $this->repository->createOrUpdate(User::class, $request->all());
        $this->repository->em()->flush();
        $url = route('admin.'.$group.'.search', 'app-model-user');
        
        return redirect($url.'?order[]=-user.createdAt')->with('success', __('User created successfully.'));
    }

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::update()
     */
    public function update(Request $request, string $classUrlName, $id, string $group)
    {
        $rules = User::getRequestValidationRules();
        $data = $request->post();
        
        if (!$request->input('password')) {
            unset($rules['password']);
            unset($data['password']);
        }
        
        $request->validate($rules);
        $this->repository->createOrUpdate(User::class, $data, $id);
        $this->repository->em()->flush();
        $url = route('admin.'.$group.'.search', 'app-model-user');
        
        return redirect($url.'?order[]=-user.updatedAt')->with('success', __('User updated successfully.'));
    }   

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::delete()
     */
    public function delete(Request $request, string $classUrlName, $id, string $group)
    {
        return null;
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
