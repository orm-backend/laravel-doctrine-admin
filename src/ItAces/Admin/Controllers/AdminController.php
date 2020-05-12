<?php

namespace ItAces\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use ItAces\SoftDeleteable;
use ItAces\Controllers\WebController;
use ItAces\Repositories\WithJoinsRepository;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;
use ItAces\View\FieldContainer;

class AdminController extends WebController
{
    
    /**
     * 
     * @var array
     */
    protected $menu = [];
    
    /**
     * 
     * @var array
     */
    protected $adapters;
    
    /**
     *
     * @var \ItAces\Repositories\WithJoinsRepository
     */
    protected $withJoins;

    public function __construct()
    {
        parent::__construct();
        $this->withJoins = new WithJoinsRepository();
        $this->adapters = config('admin.adapters');
        $metadata = $this->repository->em()->getMetadataFactory()->getAllMetadata();

        foreach ($metadata as $classMetadata) {
            /**
             * 
             * @var \Doctrine\ORM\Mapping\ClassMetadata $metadataInfo
             */
            $metadataInfo = $classMetadata;
            $classUrlName = Helper::classToUlr($metadataInfo->name);
            
            if ($metadataInfo->isMappedSuperclass) {
                continue;
            }
            
            if (!Gate::inspect('read', $classUrlName)->allowed()) {
                continue;
            }
            
            $reflectionClass = new \ReflectionClass($metadataInfo->name);
            $className = $reflectionClass->getShortName();
            $isDeleteable = $reflectionClass->implementsInterface(SoftDeleteable::class);

            $this->menu[] = [
                'name' => __( Str::pluralCamelWords($className) ),
                'link' => route('admin.entity.search', $classUrlName, false) . '/',
                'trash' => $isDeleteable ? route('admin.entity.trash', $classUrlName, false) . '/' : null,
                'title' => $metadataInfo->name
            ];
            
            usort($this->menu, function($a, $b) {
                if ($a['name'] == $b['name']) {
                    return 0;
                }
                
                return ($a['name'] < $b['name']) ? -1 : 1;
            });
        }
    }
    
    public function index()
    {
        $metadata = $this->repository->em()->getMetadataFactory()->getAllMetadata();
        
        return view('itaces::admin.index', [
            'menu' => $this->menu
        ]);
    }
    
    /**
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function search(Request  $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->search($request);
            
            if ($response !== null) {
                return $response;
            }
        }
        
        $classMetadata = $this->repository->em()->getClassMetadata($className);
        $alias = lcfirst($classShortName);
        $container = new FieldContainer($this->repository->em());
        
        $meta = [
            'class' => $className,
            'title' => __( Str::pluralCamelWords($classShortName) ),
            'classUrlName' => $classUrlName
        ];

        $order = $request->get('order');
        $parameters = [];
        
        if (!$order) {
            $parameters = [
                'order' => ['-'.$alias.'.id']
            ];
        }

        $paginator = $this->paginate($this->withJoins->createQuery($className, $parameters, $alias))->appends($request->all());
        $container->buildMetaFields($classMetadata);
        $container->addCollection($paginator->items());

        return view('itaces::admin.entity.search', [
            'menu' => $this->menu,
            'paginator' => $paginator,
            'container' => $container,
            'meta' => $meta
        ]);
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, string $classUrlName, int $id)
    {
        $className = Helper::classFromUlr($classUrlName);
        $entity = $this->withJoins->findOrFail($className, $id);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->details($request, $id);
            
            if ($response !== null) {
                return $response;
            }
        }

        $container = new FieldContainer($this->repository->em());
        $container->addEntity($entity);
        
        $meta = [
            'class' => $className,
            'title' => __( Str::pluralCamelWords($classShortName, 1) ),
            'classUrlName' => $classUrlName
        ];

        return view('itaces::admin.entity.details', [
            'menu' => $this->menu,
            'container' => $container,
            'meta' => $meta,
            'formAction' => route('admin.entity.update', [$classUrlName, $id])
        ]);
    }
    
    /**
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, string $classUrlName, int $id)
    {
        $className = Helper::classFromUlr($classUrlName);
        $entity = $this->withJoins->findOrFail($className, $id);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->edit($request, $entity);
            
            if ($response !== null) {
                return $response;
            }
        }

        $container = new FieldContainer($this->repository->em());
        $container->addEntity($entity);
        
        $meta = [
            'class' => $className,
            'title' => __( Str::pluralCamelWords($classShortName, 1) ),
            'classUrlName' => $classUrlName
        ];

        return view('itaces::admin.entity.edit', [
            'menu' => $this->menu,
            'container' => $container,
            'meta' => $meta,
            'formAction' => route('admin.entity.update', [$classUrlName, $id])
        ]);
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->create($request);
            
            if ($response !== null) {
                return $response;
            }
        }

        $classMetadata = $this->repository->em()->getClassMetadata($className);
        $container = new FieldContainer($this->repository->em());
        $container->buildMetaFields($classMetadata);
        
        $meta = [
            'class' => $className,
            'title' => __( Str::pluralCamelWords($classShortName, 1) ),
            'classUrlName' => $classUrlName
        ];
        
        return view('itaces::admin.entity.create', [
            'menu' => $this->menu,
            'container' => $container,
            'meta' => $meta,
            'formAction' => route('admin.entity.store', [$classUrlName])
        ]);
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $classUrlName, int $id)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $adapterClass = $this->adapters[$className] ?? null;
        $map = [];
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->update($request, $id);
            
            if ($response !== null) {
                return $response;
            }
        }

        try {
            $map = FieldContainer::readRequest($request->post());
            
            foreach ($map as $className => $data) {
                Validator::make($data, $className::getRequestValidationRules())->validate();
                $this->withJoins->createOrUpdate($className, $data, $id); // TODO: ID must be on entity
            }
            
            $this->withJoins->em()->flush();
        } catch (ValidationException $e) {
            $messages = FieldContainer::exceptionToMessages($e, $classUrlName);
            
            throw ValidationException::withMessages($messages);
        }
        
        $url = route('admin.entity.search', $classUrlName);
        
        return redirect($url.'?order[]=-'.$alias.'.updatedAt')->with('success', __('Record updated successfully.'));
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $adapterClass = $this->adapters[$className] ?? null;
        $map = [];
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->store($request);
            
            if ($response !== null) {
                return $response;
            }
        }

        try {
            $map = FieldContainer::readRequest($request->post());

            foreach ($map as $className => $data) {
                Validator::make($data, $className::getRequestValidationRules())->validate();
                $this->withJoins->createOrUpdate($className, $data);
            }
            
            $this->withJoins->em()->flush();
        } catch (ValidationException $e) {
            $messages = FieldContainer::exceptionToMessages($e, $classUrlName);
            
            throw ValidationException::withMessages($messages);
        }

        $url = route('admin.entity.search', $classUrlName);
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Record created successfully.'));
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, string $classUrlName, int $id)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $url = route('admin.entity.search', $classUrlName);
        $this->repository->delete($className, $id);
        $this->repository->em()->flush();
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Record deleted successfully.'));
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, string $classUrlName, int $id)
    {
        $this->repository->em()->getFilters()->disable('softdelete');
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $url = route('admin.entity.trash', $classUrlName);
        $this->repository->restore($className, $id);
        $this->repository->em()->flush();
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Record was successfully restored.'));
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request, string $classUrlName)
    {
        $this->repository->em()->getFilters()->disable('softdelete');
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass($this->menu);
            $response = $adapter->search($request);
            
            if ($response !== null) {
                return $response;
            }
        }
        
        $classMetadata = $this->repository->em()->getClassMetadata($className);
        $container = new FieldContainer($this->repository->em());
        
        $meta = [
            'class' => $className,
            'title' => __( Str::pluralCamelWords($classShortName) ),
            'classUrlName' => $classUrlName
        ];

        $parameters = [
            'filter' => [
                [$alias.'.deletedAt', 'isNotNull']
            ]
        ];
        
        $order = $request->get('order');
        
        if (!$order) {
            $parameters['order'] = ['-'.$alias.'.id'];
        }

        $paginator = $this->paginate($this->withJoins->createQuery($className, $parameters, $alias))->appends($request->all());
        $container->buildMetaFields($classMetadata);
        $container->addCollection($paginator->items());
        
        return view('itaces::admin.entity.trash', [
            'menu' => $this->menu,
            'paginator' => $paginator,
            'container' => $container,
            'meta' => $meta
        ]);
        
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request  $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $url = route('admin.entity.search', $classUrlName);
        $selected = $request->post('selected');
        
        if ($selected) {
            $ids = explode(',', $selected);
            
            foreach ($ids as $id) {
                $this->repository->delete($className, $id);
            }
            
            $this->repository->em()->flush();
        }
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Records were successfully deleted.'));
    }
    
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function batchRestore(Request $request, string $classUrlName)
    {
        $this->repository->em()->getFilters()->disable('softdelete');
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $url = route('admin.entity.trash', $classUrlName);
        $selected = $request->post('selected');
        
        if ($selected) {
            $ids = explode(',', $selected);
            
            foreach ($ids as $id) {
                $this->repository->restore($className, $id);
            }
            
            $this->repository->em()->flush();
        }
        
        return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('success', __('Records were successfully restored.'));
    }

}
