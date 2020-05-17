<?php

namespace ItAces\Admin\Adapters;

use ItAces\ORM\Entities\Role;
use ItAces\ORM\Entities\User;
use Illuminate\Http\Request;
use ItAces\Admin\Controllers\AdminControllerAdapter;
use ItAces\ORM\Entities\EntityBase;

class UserAdapter extends AdminControllerAdapter
{

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(Request $request)
    {
        return view('itaces::admin.user.create', [
            'roles' => $this->repository->getQuery(Role::class)->getResult()
        ]);
    }
    
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param \ItAces\ORM\Entities\EntityBase $entity
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, EntityBase $entity)
    {
        return view('itaces::admin.user.edit', [
            'roles' => $this->repository->getQuery(Role::class)->getResult(),
            'user' => $entity
        ]);
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return NULL
     */
    public function details(Request $request, int $id)
    {
        return null;
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return NULL
     */
    public function search(Request $request)
    {
        return null;
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(User::getRequestValidationRules());
        $this->repository->createOrUpdate(User::class, $request->all());
        $this->repository->em()->flush();
        $url = route('admin.entity.search', 'app-model-user');
        
        return redirect($url.'?order[]=-user.createdAt')->with('success', __('User created successfully.'));
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
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
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return NULL
     */
    public function delete(Request $request, int $id)
    {
        return null;
    }

}
