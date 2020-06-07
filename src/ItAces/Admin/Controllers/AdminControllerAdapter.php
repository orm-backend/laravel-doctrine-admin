<?php

namespace ItAces\Admin\Controllers;

use Illuminate\Http\Request;
use ItAces\ORM\Entities\Entity;
use ItAces\Repositories\Repository;

/**
 * 
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
abstract class AdminControllerAdapter
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
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function search(Request $request, string $classUrlName, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function trash(Request $request, string $classUrlName, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \ItAces\ORM\Entities\Entity $entity
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function details(Request $request, Entity $entity, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \ItAces\ORM\Entities\Entity $entity
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function edit(Request $request, Entity $entity, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function create(Request $request, string $classUrlName, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param mixed $id
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function update(Request $request, string $classUrlName, $id, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function store(Request $request, string $classUrlName, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $classUrlName
     * @param mixed $id
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function delete(Request $request, string $classUrlName, $id, string $group);
    
}
