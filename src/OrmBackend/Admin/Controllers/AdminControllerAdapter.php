<?php

namespace OrmBackend\Admin\Controllers;

use Illuminate\Http\Request;
use OrmBackend\ORM\Entities\Entity;
use OrmBackend\Repositories\Repository;

/**
 * 
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
abstract class AdminControllerAdapter
{
    
    /**
     * 
     * @var \OrmBackend\Repositories\Repository
     */
    protected $repository;
    
    /**
     *
     * @var array
     */
    protected $views;
    
    /**
     * 
     * @param array $menu
     */
    public function __construct(array $views = []) {
        $this->repository = new Repository();
        $this->views = $views;
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
     * @param \OrmBackend\ORM\Entities\Entity $entity
     * @param string $group
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function details(Request $request, Entity $entity, string $group);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \OrmBackend\ORM\Entities\Entity $entity
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
