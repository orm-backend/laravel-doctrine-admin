<?php

namespace ItAces\Admin\Adapters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use ItAces\Admin\Controllers\AdminControllerAdapter;
use ItAces\ORM\Entities\EntityBase;
use ItAces\Utility\Helper;
use ItAces\Web\Fields\FieldContainer;

/**
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
class ImageAdapter extends AdminControllerAdapter
{
    
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
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::edit()
     */
    public function edit(Request $request, EntityBase $entity)
    {
        $container = new FieldContainer($this->repository->em());
        $container->addEntity($entity);
        
        return view('itaces::admin.image.edit', [
            'container' => $container,
            'meta' => [
                'class' => get_class($entity),
                'title' => __('Image'),
                'classUrlName' => 'app-model-image'
            ],
            'formAction' => route('admin.entity.update', ['app-model-image', $entity->getPrimary()])
        ]);
    }

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::create()
     */
    public function create(Request $request, string $classUrlName)
    {
        return view('itaces::admin.image.create', [
            'action' => route('admin.entity.store', 'app-model-image'),
        ]);
    }

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::update()
     */
    public function update(Request $request, string $classUrlName, $id)
    {
        // Example with FieldContainer
        $className = Helper::classFromUlr($classUrlName);
        $old = $this->repository->findOrFail($className, $id);
        $stored = $old->getPath();
        $data = $request->post();
        $rules = $className::getRequestValidationRules();
        
        if ($request->file('image')) { // There was an attempt to upload a file
            if ($request->file('image')->getError() === UPLOAD_ERR_INI_SIZE) { // Fix Laravel Validation
                throw ValidationException::withMessages([
                    'image' => [__('File size too large.')],
                ]);
            }

            $request->validate(['image' => $rules['image']]); // Validate only file
            $data['app-model-image']['name'] = $data['app-model-image']['name'] ?? $request->file('image')->getClientOriginalName();
            $data['app-model-image']['path'] = $request->file('image')->store(config('itaces.upload.img'));
            
            if (!$data['app-model-image']['path']) {
                throw ValidationException::withMessages([
                    'image' => [__('Failed to store file.')],
                ]);
            }
        }

        unset($rules['image']); // Unset allways (uploaded or not)
        
        try {
            $map = FieldContainer::readRequest($data);
            Validator::make($map[$className], $rules)->validate(); // Validate other fields
            $this->repository->createOrUpdate($className, $map[$className]);
            $this->repository->em()->flush();
            
            if ($stored) {
                Storage::delete($stored);
            }
        } catch (ValidationException $e) {
            $messages = FieldContainer::exceptionToMessages($e, 'app-model-image');
            
            throw ValidationException::withMessages($messages);
        }
        
        $url = route('admin.entity.search', 'app-model-image');
        
        return redirect($url.'?order[]=-image.updatedAt')->with('success', __('Record updated successfully.'));
    }

    /**
     * {@inheritDoc}
     * @see \ItAces\Admin\Controllers\AdminControllerAdapter::store()
     */
    public function store(Request $request, string $classUrlName)
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
        $data['path'] = $request->file('image')->store(config('itaces.upload.img'));

        if (!$data['path']) {
            throw ValidationException::withMessages([
                'image' => [__('Failed to store file.')],
            ]);
        }
        
        $this->repository->createOrUpdate($className, $data);
        $this->repository->em()->flush();
        $url = route('admin.entity.search', 'app-model-image');
        
        return redirect($url.'?order[]=-image.createdAt')->with('success', __('Image created successfully.'));
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
