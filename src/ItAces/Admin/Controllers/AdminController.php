<?php

namespace ItAces\Admin\Controllers;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Illuminate\Http\Request;
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
    protected $adapters;
    
    /**
     *
     * @var array
     */
    protected $views;

    public function __construct()
    {
        $this->repository = new WithJoinsRepository(true, true);
        $this->adapters = config('admin.adapters');
        $this->views = config('admin.views');
    }
    
    public function index()
    {
        return view($this->views['index'] ?? 'itaces::admin.index');
    }
    
    /**
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass;
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

        $paginator = $this->paginate($this->repository->createQuery($className, $parameters, $alias))->appends($request->all());
        $container->buildMetaFields($classMetadata);
        $container->addCollection($paginator->items());

        return view($this->views[$classUrlName]['search'] ?? 'itaces::admin.entity.search', [
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
        $entity = $this->repository->findOrFail($className, $id);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass;
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

        return view($this->views[$classUrlName]['details'] ?? 'itaces::admin.entity.details', [
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
        $entity = $this->repository->findOrFail($className, $id);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass;
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

        return view($this->views[$classUrlName]['edit'] ?? 'itaces::admin.entity.edit', [
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
            $adapter = new $adapterClass;
            $response = $adapter->create($request);
            
            if ($response !== null) {
                return $response;
            }
        }

        $classMetadata = $this->repository->em()->getClassMetadata($className);
        $container = new FieldContainer($this->repository->em());
        $container->addEntity(new $className());
        //$container->buildMetaFields($classMetadata);
        
        $meta = [
            'class' => $className,
            'title' => __( Str::pluralCamelWords($classShortName, 1) ),
            'classUrlName' => $classUrlName
        ];

        return view($this->views[$classUrlName]['create'] ?? 'itaces::admin.entity.create', [
            'container' => $container,
            'meta' => $meta,
            'formAction' => route('admin.entity.store', [$classUrlName])
        ]);
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
            $adapter = new $adapterClass;
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
        
        $paginator = $this->paginate($this->repository->createQuery($className, $parameters, $alias))->appends($request->all());
        $container->buildMetaFields($classMetadata);
        $container->addCollection($paginator->items());
        
        return view($this->views[$classUrlName]['trash'] ?? 'itaces::admin.entity.trash', [
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
    public function update(Request $request, string $classUrlName, int $id)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass;
            $response = $adapter->update($request, $id);
            
            if ($response !== null) {
                return $response;
            }
        }

        $this->repository->saveFieldContainer($request->post(), $classUrlName);
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

        if ($adapterClass) {
            $adapter = new $adapterClass;
            $response = $adapter->store($request);
            
            if ($response !== null) {
                return $response;
            }
        }

        $this->repository->saveFieldContainer($request->post(), $classUrlName);
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
        $adapterClass = $this->adapters[$className] ?? null;
        
        if ($adapterClass) {
            $adapter = new $adapterClass;
            $response = $adapter->delete($request, $id);
            
            if ($response !== null) {
                return $response;
            }
        }
        
        $url = route('admin.entity.search', $classUrlName);
        $this->repository->delete($className, $id);
        
        try {
            $this->repository->em()->flush();
        } catch (ForeignKeyConstraintViolationException $e) {
            $message = config('app.debug') ? $e->getMessage() : __('Cannot delete or update a parent row');
            return redirect($url.'?order[]=-'.$alias.'.createdAt')->with('warning', $message);
        }
        
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
