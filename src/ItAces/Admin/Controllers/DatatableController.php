<?php

namespace ItAces\Admin\Controllers;

use Illuminate\Http\Request;
use ItAces\Controllers\WebController;
use ItAces\Json\DatatableSerializer;
use ItAces\Repositories\WithJoinsRepository;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;
use ItAces\View\FieldContainer;

/**
 * 
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
class DatatableController extends WebController
{
    
    public function __construct()
    {
        $this->repository = new WithJoinsRepository(false, true);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function metadata(Request $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classMetadata = $this->repository->em()->getClassMetadata($className);
        $container = new FieldContainer($this->repository->em());
        $container->buildMetaFields($classMetadata);

        return response()->json( $container->fields(), 200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request  $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
        $alias = lcfirst($classShortName);

        $order = $request->get('order');
        $parameters = [];
        
        if (!$order) {
            $parameters = [
                'order' => ['-'.$alias.'.'.$className::getIdentifierName()]
            ];
        }
        
        $paginator = $this->paginate($this->repository->createQuery($className, $parameters, $alias))->appends($request->all());
        $serializer = new DatatableSerializer($this->repository->em(), $paginator);
        
        return response()->json( $serializer, 200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $classUrlName
     * @return \Illuminate\Http\Response
     */
    public function search(Request  $request, string $classUrlName)
    {
        $className = Helper::classFromUlr($classUrlName);
        $classShortName = (new \ReflectionClass($className))->getShortName();
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
                'order' => ['-'.$alias.'.'.$className::getIdentifierName()]
            ];
        }
        
        $paginator = $this->paginate($this->repository->createQuery($className, $parameters, $alias))->appends($request->all());
        $container->buildMetaFields($classMetadata);
        $container->addCollection($paginator->items());
        
        return view('itaces::admin.entity.datatable', [
            'paginator' => $paginator,
            'container' => $container,
            'meta' => $meta
        ]);
    }
}

