<?php

namespace ItAces\Admin\Controllers;

use Illuminate\Http\Request;
use ItAces\ORM\Entities\EntityBase;
use ItAces\Publishable;
use ItAces\Repositories\Repository;

/**
 * 
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
abstract class AdminControllerAdapter implements Publishable
{
    
    /**
     * 
     * @var \ItAces\Repositories\Repository
     */
    protected $repository;
    
    /**
     * 
     * @param array $menu
     */
    public function __construct() {
        $this->repository = new Repository();
    }
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function search(Request $request, string $classUrlName);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \ItAces\ORM\Entities\EntityBase $entity
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function details(Request $request, EntityBase $entity);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \ItAces\ORM\Entities\EntityBase $entity
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function edit(Request $request, EntityBase $entity);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function create(Request $request, string $classUrlName);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param mixed $id
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function update(Request $request, string $classUrlName, $id);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function store(Request $request, string $classUrlName);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param mixed $id
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function delete(Request $request, string $classUrlName, $id);
    
}
