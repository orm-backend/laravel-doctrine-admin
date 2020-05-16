<?php

namespace ItAces\Admin\Adapters;

use App\Model\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use ItAces\Admin\Controllers\AdminControllerAdapter;
use ItAces\ORM\Entities\EntityBase;
use ItAces\View\FieldContainer;

class ImageAdapter extends AdminControllerAdapter
{
    
    public function details(Request $request, int $id)
    {
        return null;
    }
    
    public function search(Request $request)
    {
        return null;
    }

    public function edit(Request $request, EntityBase $entity)
    {
        $container = new FieldContainer($this->repository->em());
        $container->addEntity($entity);
        
        return view('itaces::admin.image.edit', [
            'container' => $container,
            'meta' => [
                'class' => Image::class,
                'title' => __('Image'),
                'classUrlName' => 'app-model-image'
            ],
            'formAction' => route('admin.entity.update', ['app-model-image', $entity->getId()])
        ]);
    }

    public function create(Request $request)
    {
        return view('itaces::admin.image.create', [
            'action' => route('admin.entity.store', 'app-model-image'),
        ]);
    }

    public function update(Request $request, int $id)
    {
        // Example with FieldContainer
        /**
         * 
         * @var \App\Model\Image $old
         */
        $old = $this->repository->findOrFail(Image::class, $id);
        $stored = $old->getPath();
        $data = $request->post();
        $rules = Image::getRequestValidationRules();
        
        if ($request->file('image')) { // There was an attempt to upload a file
            if ($request->file('image')->getError() === UPLOAD_ERR_INI_SIZE) { // Fix Laravel Validation
                throw ValidationException::withMessages([
                    'image' => [__('File size too large.')],
                ]);
            }

            $request->validate(['image' => $rules['image']]); // Validate only file
            $data['app-model-image_name'] = $request->filled('app-model-image_name') ? $request->post('app-model-image_name') : $request->file('image')->getClientOriginalName();
            $data['app-model-image_path'] = $request->file('image')->store(config('itaces.upload.img'));
            
            if (!$data['app-model-image_path']) {
                throw ValidationException::withMessages([
                    'image' => [__('Failed to store file.')],
                ]);
            }
        }

        unset($rules['image']); // Unset allways (uploaded or not)
        
        try {
            $map = FieldContainer::readRequest($data);
            Validator::make($map[Image::class], $rules)->validate(); // Validate other fields
            $this->repository->createOrUpdate(Image::class, $map[Image::class], $id); // TODO: ID must be on entity
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

    public function store(Request $request)
    {
        // Without FieldContainer
        $data = $request->post();
        
        if ($request->file('image') && $request->file('image')->getError() === UPLOAD_ERR_INI_SIZE) { // Fix Laravel Validation
            throw ValidationException::withMessages([
                'image' => [__('File size too large.')],
            ]);
        }
        
        $request->validate(Image::getRequestValidationRules());
        $data['name'] = $request->filled('name') ? $request->post('name') : $request->file('image')->getClientOriginalName();
        $data['path'] = $request->file('image')->store(config('itaces.upload.img'));
        
        if (!$data['path']) {
            throw ValidationException::withMessages([
                'image' => [__('Failed to store file.')],
            ]);
        }
        
        $this->repository->createOrUpdate(Image::class, $data);
        $this->repository->em()->flush();
        $url = route('admin.entity.search', 'app-model-image');
        
        return redirect($url.'?order[]=-image.createdAt')->with('success', __('Image created successfully.'));
    }

    public function delete(Request $request, int $id)
    {
        return null;
    }

}
