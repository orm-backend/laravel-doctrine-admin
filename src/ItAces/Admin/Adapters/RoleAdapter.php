<?php
namespace ItAces\Admin\Adapters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use ItAces\Admin\Controllers\AdminControllerAdapter;
use ItAces\ORM\Entities\EntityBase;
use ItAces\Utility\Helper;
use ItAces\View\FieldContainer;
use App\Model\Role;

class RoleAdapter extends AdminControllerAdapter
{
    
    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::search()
     */
    public function search(Request $request)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::edit()
     */
    public function edit(Request $request, EntityBase $entity)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::create()
     */
    public function create(Request $request)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::update()
     */
    public function update(Request $request, int $id)
    {
        $classUrlName = Helper::classToUlr(Role::class);
        $classShortName = (new \ReflectionClass(Role::class))->getShortName();
        $alias = lcfirst($classShortName);
        $data = $request->post();
        $inputPermission = $classUrlName . '_permission';
        $inputSystem = $classUrlName . '_system';
        $data[$inputPermission] = 0;
        
        if (!isset($data[$inputSystem])) {
            $data[$inputSystem] = 0;
        }
        
        if (!empty($data['permissions'])) {
            foreach ($data['permissions'] as $permission) {
                $data[$inputPermission] = $data[$inputPermission] | (int) $permission;
            }
            
            unset($data['permissions']);
        }
        
        try {
            $map = FieldContainer::readRequest($data);

            foreach ($map as $className => $data) {
                Validator::make($data, $className::getRequestValidationRules())->validate();
                $this->repository->createOrUpdate($className, $data, $id); // TODO: ID must be on entity
            }
            
            $this->repository->em()->flush();
        } catch (ValidationException $e) {
            $messages = FieldContainer::exceptionToMessages($e, $classUrlName);
            
            throw ValidationException::withMessages($messages);
        }
        
        $url = route('admin.entity.search', $classUrlName);
        
        return redirect($url.'?order[]=-'.$alias.'.updatedAt')->with('success', __('Record updated successfully.'));
    }

    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::details()
     */
    public function details(Request $request, int $id)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::store()
     */
    public function store(Request $request)
    {
        return null;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::delete()
     */
    public function delete(Request $request, int $id)
    {
        return null;
    }

}
