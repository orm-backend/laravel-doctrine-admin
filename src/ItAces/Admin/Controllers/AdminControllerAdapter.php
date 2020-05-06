<?php

namespace ItAces\Admin\Controllers;

use Illuminate\Http\Request;
use ItAces\ORM\Entities\EntityBase;
use ItAces\UnderAdminControl;
use ItAces\Repositories\Repository;

/**
 * 
 * @author Vitaliy Kovalenko vvk@kola.cloud
 *
 */
abstract class AdminControllerAdapter implements UnderAdminControl
{
    
    /**
     * 
     * @var array
     */
    protected $menu;
    
    /**
     * 
     * @var \ItAces\Repositories\Repository
     */
    protected $repository;
    
    /**
     * 
     * @param array $menu
     */
    public function __construct(array $menu) {
        $this->menu = $menu;
        $this->repository = new Repository();
    }
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function search(Request $request);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function details(Request $request, int $id);
    
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
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function create(Request $request);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function update(Request $request, int $id);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function store(Request $request);
    
    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function delete(Request $request, int $id);
    
}
