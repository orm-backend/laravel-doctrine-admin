<?php

namespace OrmBackend\Admin\Adapters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use OrmBackend\Admin\Controllers\AdminControllerAdapter;
use OrmBackend\ORM\Entities\Entity;
use OrmBackend\Utility\Helper;
use OrmBackend\Web\Fields\FieldContainer;
use OrmBackend\Uploader;

/**
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
class ImageAdapter extends AdminControllerAdapter
{
    
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
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::edit()
     */
    public function edit(Request $request, Entity $entity, string $group)
    {
        $classUrlName = Helper::classToUrl(get_class($entity));
        $container = new FieldContainer($this->repository->em());
        $container->addEntity($entity);
        
        return view('itaces::admin.image.edit', [
            'container' => $container,
            'meta' => [
                'group' => $group,
                'class' => get_class($entity),
                'title' => __('Image'),
                'classUrlName' => $classUrlName
            ],
            'formAction' => route('admin.'.$group.'.update', [$classUrlName, $entity->getPrimary()])
        ]);
    }

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::create()
     */
    public function create(Request $request, string $classUrlName, string $group)
    {
        return view('itaces::admin.image.create', [
            'action' => route('admin.'.$group.'.store', $classUrlName),
        ]);
    }

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::update()
     */
    public function update(Request $request, string $classUrlName, $id, string $group)
    {
        // Example with FieldContainer
        $className = Helper::classFromUlr($classUrlName);
        $old = $this->repository->findOrFail($className, $id);
        $replaced = null;
        $data = $request->post();
        $rules = $className::getRequestValidationRules();
        
        if ($request->file('image')) { // There was an attempt to upload a file
            if ($request->file('image')->getError() === UPLOAD_ERR_INI_SIZE) { // Fix Laravel Validation
                throw ValidationException::withMessages([
                    'image' => [__('File size too large.')],
                ]);
            }

            $request->validate(['image' => $rules['image']]); // Validate only file
            $data[$classUrlName]['name'] = $data[$classUrlName]['name'] ?? $request->file('image')->getClientOriginalName();
            $data[$classUrlName]['path'] = Uploader::storeImage($request->file('image'), 'image');
            
            if (!$data[$classUrlName]['path']) {
                throw ValidationException::withMessages([
                    'image' => [__('Failed to store file.')],
                ]);
            }
            
            if ($data[$classUrlName]['path'] != $old->getPath()) {
                $replaced = $old->getPath();
            }
        }

        unset($rules['image']); // Unset allways (uploaded or not)
        
        try {
            $map = FieldContainer::readRequest($data);
            Validator::make($map[$className], $rules)->validate(); // Validate other fields
            $this->repository->createOrUpdate($className, $map[$className]);
            $this->repository->em()->flush();
            
            if ($replaced) {
                Storage::delete($replaced);
            }
        } catch (ValidationException $e) {
            $messages = FieldContainer::exceptionToMessages($e, $classUrlName);
            
            throw ValidationException::withMessages($messages);
        }
        
        $url = route('admin.'.$group.'.search', $classUrlName);
        
        return redirect($url.'?order[]=-image.updatedAt')->with('success', __('Record updated successfully.'));
    }

    /**
     * {@inheritDoc}
     * @see \OrmBackend\Admin\Controllers\AdminControllerAdapter::store()
     */
    public function store(Request $request, string $classUrlName, string $group)
    {
        // Without FieldContainer
        $className = Helper::classFromUlr($classUrlName);
        $data = $request->post();
        
        if ($request->file('image') && $request->file('image')->getError() === UPLOAD_ERR_INI_SIZE) { // Fix Laravel Validation
            throw ValidationException::withMessages([
                'image' => [__('File size too large.')],
            ]);
        }
        
        $request->validate($className::getRequestValidationRules());
        $data['name'] = $request->filled('name') ? $request->post('name') : $request->file('image')->getClientOriginalName();
        $data['path'] = Uploader::storeImage($request->file('image'), 'image');

        if (!$data['path']) {
            throw ValidationException::withMessages([
                'image' => [__('Failed to store file.')],
            ]);
        }
        
        $this->repository->createOrUpdate($className, $data);
        $this->repository->em()->flush();
        $url = route('admin.'.$group.'.search', $classUrlName);
        
        return redirect($url.'?order[]=-image.createdAt')->with('success', __('Image created successfully.'));
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
