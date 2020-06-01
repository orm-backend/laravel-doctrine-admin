<?php
namespace ItAces\Admin;

use Doctrine\ORM\EntityManager;
use Illuminate\Support\Facades\Gate;
use ItAces\SoftDeleteable;
use ItAces\Publishable;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;
use ItAces\Web\Events\BeforMenu;
use ItAces\Web\Menu\Menu;
use ItAces\Web\Menu\MenuFactory;

class AdminMenuListener
{
    
    /**
     * 
     * @var \ItAces\Web\Menu\MenuFactory
     */
    protected $factory;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    public function __construct(MenuFactory $factory, EntityManager $em)
    {
        $this->factory = $factory;
        $this->em = $em;
    }
    
    public function handle(BeforMenu $event)
    {
        $currentRoute = request()->route()->action['as'];
        
        $dashboard = new Menu([
            'url' => route('admin.index', [], false),
            'name' => __('Dashboard'),
            'title' => __('Administrator Dashboard'),
            'active' => $currentRoute == 'admin.index',
            'icon' => config('admin.icons.dashboard')
        ]);
        
        $isActive = Str::startsWith($currentRoute, 'admin.entity');
        
        $publishable = new Menu([
            'url' => 'javascript:;',
            'name' => __('Publishable'),
            'title' => __('Entity List'),
            'active' => $isActive,
            'icon' => config('admin.icons.entities'),
            'open' => $isActive
        ]);

        foreach ($this->getEntitiesItems($currentRoute) as $key => $menu) {
            $publishable->addSubmenuElement($key, $menu);
        }
        
        $admin = new Menu();
        $admin->addSubmenuElement('dashboard', $dashboard);
        $admin->addSubmenuElement('entities', $publishable);

        $this->factory->addMenu('admin', $admin);
        //dd($this->factory->getMenuValue('admin'));
    }
    
    /**
     * 
     * @param string $currentRoute
     * @return \ItAces\Web\Menu\Menu[]
     */
    protected function getEntitiesItems(string $currentRoute)
    {
        $elements = [];
        $activeModel = request()->route()->parameters['model'] ?? null;
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        
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
            
            if (!$reflectionClass->implementsInterface(Publishable::class)) {
                continue;
            }
            
            $menu = new Menu([
                'url' => 'javascript:;',
                'name' => __( Str::pluralCamelWords($className) ),
                'title' => $metadataInfo->name,
                'active' => $activeModel == $classUrlName
            ]);
            
            if (Gate::inspect('read', $classUrlName)->allowed()) {
                $menu->addSubmenuElement('search', new Menu([
                    'url' => route('admin.entity.search', $classUrlName, false),
                    'name' => __('Search'),
                    'title' => __('Element List'),
                    'active' => $activeModel == $classUrlName && $currentRoute == 'admin.entity.search'
                ]));
            }
            
            if (Gate::inspect('create', $classUrlName)->allowed()) {
                $menu->addSubmenuElement('create', new Menu([
                    'url' => route('admin.entity.create', $classUrlName, false),
                    'name' => __('Create'),
                    'title' => __('Add New Element'),
                    'active' => $activeModel == $classUrlName && $currentRoute == 'admin.entity.create'
                ]));
            }
            
            if ($isDeleteable && Gate::inspect('restore', $classUrlName)->allowed()) {
                $menu->addSubmenuElement('trash', new Menu([
                    'url' => route('admin.entity.trash', $classUrlName, false),
                    'name' => __('Trash'),
                    'title' => __('Removed Elements'),
                    'active' => $activeModel == $classUrlName && $currentRoute == 'admin.entity.trash'
                ]));
            }
            
            if (Gate::inspect('settings')->allowed()) {
                $menu->addSubmenuElement('settings', new Menu([
                    'url' => route('admin.entity.settings', $classUrlName, false),
                    'name' => __('Settings'),
                    'title' => __('Entity Settings'),
                    'active' => $activeModel == $classUrlName && Str::startsWith($currentRoute, 'admin.entity.settings')
                ]));
            }
            
            $elements[$classUrlName] = $menu;
        }
        
        uasort($elements, function($a, $b) {
            if ($a->getLinkValue('name') == $b->getLinkValue('name')) {
                return 0;
            }
            
            return ($a->getLinkValue('name') < $b->getLinkValue('name')) ? -1 : 1;
        });
        
        return $elements;
    }
}
