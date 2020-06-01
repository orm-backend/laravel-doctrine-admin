<?php
namespace ItAces\Admin\Adapters;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use ItAces\Admin\Controllers\AdminControllerAdapter;
use ItAces\ORM\Entities\EntityBase;

/**
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
class UserAdapter extends AdminControllerAdapter
{
    
    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::create()
     */
    public function create(Request $request, string $classUrlName)
    {
        return view('itaces::admin.user.create', [
            'roles' => $this->repository->getQuery(Role::class)->getResult()
        ]);
    }
    
    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::edit()
     */
    public function edit(Request $request, EntityBase $entity)
    {
        return view('itaces::admin.user.edit', [
            'roles' => $this->repository->getQuery(Role::class)->getResult(),
            'user' => $entity
        ]);
    }
    
    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::details()
     */
    public function details(Request $request, EntityBase $entity)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::search()
     */
    public function search(Request $request, string $classUrlName)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::store()
     */
    public function store(Request $request, string $classUrlName)
    {
        $request->validate(User::getRequestValidationRules());
        $this->repository->createOrUpdate(User::class, $request->all());
        $this->repository->em()->flush();
        $url = route('admin.entity.search', 'app-model-user');
        
        return redirect($url.'?order[]=-user.createdAt')->with('success', __('User created successfully.'));
    }

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::update()
     */
    public function update(Request $request, string $classUrlName, $id)
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
        $url = route('admin.entity.search', 'app-model-user');
        
        return redirect($url.'?order[]=-user.updatedAt')->with('success', __('User updated successfully.'));
    }   

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::delete()
     */
    public function delete(Request $request, string $classUrlName, $id)
    {
        return null;
    }

}
