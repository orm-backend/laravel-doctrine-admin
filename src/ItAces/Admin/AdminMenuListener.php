<?php
namespace ItAces\Admin;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\Facades\Gate;
use ItAces\SoftDeleteable;
use ItAces\Publishable;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;
use ItAces\Web\Events\BeforMenu;
use ItAces\Web\Menu\Menu;
use ItAces\Web\Menu\MenuFactory;
use ItAces\Types\FileType;
use ItAces\ORM\Entities\User;
use ItAces\ORM\Entities\Role;

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
    
    /**
     * 
     * @var \Doctrine\ORM\Mapping\ClassMetadata[]
     */
    protected $classMetadataMap;
    
    /**
     * 
     * @var string
     */
    protected $activeModel;
    
    /**
     *
     * @var string
     */
    protected $currentRoute;
    
    public function __construct(MenuFactory $factory, EntityManager $em)
    {
        $this->factory = $factory;
        $this->em = $em;
        $this->activeModel = request()->route()->parameters['model'] ?? null;
        $this->currentRoute = request()->route()->action['as'];
        $this->classMetadataMap = $this->initClassMetadataMap();
    }
    
    public function handle(BeforMenu $event)
    {
        $admin = new Menu();
        $isActive = $this->currentRoute == 'admin.index';

        $dashboard = new Menu([
            'url' => route('admin.index', [], false),
            'name' => __('Dashboard'),
            'title' => __('Administrator Dashboard'),
            'active' => $isActive,
            'icon' => config('admin.icons.dashboard', 'flaticon2-architecture-and-city')
        ]);
        
        $admin->addSubmenuElement('dashboard', $dashboard);
        $group = $this->getGroupMenu('user');
        
        if ($group) {
            $isActive = Str::startsWith($this->currentRoute, 'admin.user');
            
            $publishable = new Menu([
                'url' => 'javascript:;',
                'name' => __('Users'),
                'title' => __('Entity List'),
                'active' => $isActive,
                'icon' => config('admin.icons.user', 'flaticon2-user'),
                'open' => $isActive
            ]);

            foreach ($group as $key => $menu) {
                $publishable->addSubmenuElement($key, $menu);
            }
            
            $admin->addSubmenuElement('users', $publishable);
        }

        $group = $this->getGroupMenu('entity');
        
        if ($group) {
            $isActive = Str::startsWith($this->currentRoute, 'admin.entity');
            
            $publishable = new Menu([
                'url' => 'javascript:;',
                'name' => __('Entities'),
                'title' => __('Entity List'),
                'active' => $isActive,
                'icon' => config('admin.icons.entity', 'flaticon2-menu-4'),
                'open' => $isActive
            ]);
            
            foreach ($group as $key => $menu) {
                $publishable->addSubmenuElement($key, $menu);
            }
            
            $admin->addSubmenuElement('entities', $publishable);
        }
        
       $group = $this->getGroupMenu('file');
        
        if ($group) {
            $isActive = Str::startsWith($this->currentRoute, 'admin.file');
            
            $publishable = new Menu([
                'url' => 'javascript:;',
                'name' => __('Files'),
                'title' => __('Entity List'),
                'active' => $isActive,
                'icon' => config('admin.icons.file', 'flaticon2-file'),
                'open' => $isActive
            ]);
            
            foreach ($group as $key => $menu) {
                $publishable->addSubmenuElement($key, $menu);
            }
            
            $admin->addSubmenuElement('files', $publishable);
        }
        
        $this->factory->addMenu('admin', $admin);
    }
    
    /**
     * 
     * @return \ItAces\Web\Menu\Menu[]|NULL
     */
    protected function getGroupMenu(string $group)
    {
        if (!array_key_exists($group, $this->classMetadataMap)) {
            return null;
        }
        
        $elements = [];
        
        foreach ($this->classMetadataMap[$group] as $classMetadata) {
            $classUrlName = Helper::classToUrl($classMetadata->name);
            $elements[$classUrlName] = $this->getEntityMenu($classMetadata, $classUrlName, $group);
        }
        
        uasort($elements, function($a, $b) {
            if ($a->getLinkValue('name') == $b->getLinkValue('name')) {
                return 0;
            }
            
            return ($a->getLinkValue('name') < $b->getLinkValue('name')) ? -1 : 1;
        });
        
        return $elements;
    }
    
    protected function getEntityMenu(ClassMetadata $classMetadata, string $classUrlName, string $group) : Menu
    {
        $classShortName = Helper::classShortFromUrl($classUrlName);
        $isDeleteable = is_subclass_of($classMetadata->name, SoftDeleteable::class);
        
        $menu = new Menu([
            'url' => 'javascript:;',
            'name' => __( Str::pluralCamelWords($classShortName) ),
            'title' => $classMetadata->name,
            'active' => $this->activeModel == $classUrlName
        ]);
        
        if (Gate::inspect('read', $classUrlName)->allowed()) {
            $routeName = 'admin.'.$group.'.search';
            $menu->addSubmenuElement('search', new Menu([
                'url' => route($routeName, [$classUrlName], false),
                'name' => __('Search'),
                'title' => __('Element List'),
                'active' => $this->activeModel == $classUrlName && $this->currentRoute == $routeName
            ]));
        }
        
        if (Gate::inspect('create', $classUrlName)->allowed()) {
            $routeName = 'admin.'.$group.'.create';
            $menu->addSubmenuElement('create', new Menu([
                'url' => route($routeName, [$classUrlName], false),
                'name' => __('Create'),
                'title' => __('Add New Element'),
                'active' => $this->activeModel == $classUrlName && $this->currentRoute == $routeName
            ]));
        }
        
        if ($isDeleteable && Gate::inspect('restore', $classUrlName)->allowed()) {
            $routeName = 'admin.'.$group.'.trash';
            $menu->addSubmenuElement('trash', new Menu([
                'url' => route($routeName, [$classUrlName], false),
                'name' => __('Trash'),
                'title' => __('Removed Elements'),
                'active' => $this->activeModel == $classUrlName && $this->currentRoute == $routeName
            ]));
        }
        
        if (Gate::inspect('settings')->allowed()) {
            $routeName = 'admin.'.$group.'.settings';
            $menu->addSubmenuElement('settings', new Menu([
                'url' => route($routeName, [$classUrlName], false),
                'name' => __('Settings'),
                'title' => __('Entity Settings'),
                'active' => $this->activeModel == $classUrlName && Str::startsWith($this->currentRoute, $routeName)
            ]));
        }
        
        return $menu;
    }
    
    /**
     * 
     * @return \Doctrine\ORM\Mapping\ClassMetadata[]
     */
    protected function initClassMetadataMap()
    {
        $classMetadataMap = [];
        /**
         * 
         * @var \Doctrine\ORM\Mapping\ClassMetadata[] $classMetadata
         */
        $allMetadata = $this->em->getMetadataFactory()->getAllMetadata();

        foreach ($allMetadata as $classMetadata) {
            $classUrlName = Helper::classToUrl($classMetadata->name);
            
            if ($classMetadata->isMappedSuperclass) {
                continue;
            }
            
            if (!Gate::inspect('read', $classUrlName)->allowed()) {
                continue;
            }

            if (!is_subclass_of($classMetadata->name, Publishable::class)) {
                continue;
            }

            if (is_subclass_of($classMetadata->name, FileType::class)) {
                if (!array_key_exists('file', $classMetadataMap)) {
                    $classMetadataMap['file'] = [];
                }
                
                $classMetadataMap['file'][] = $classMetadata;
                
                continue;
            }
            
            if (is_subclass_of($classMetadata->name, User::class) || is_subclass_of($classMetadata->name, Role::class)) {
                if (!array_key_exists('user', $classMetadataMap)) {
                    $classMetadataMap['user'] = [];
                }
                
                $classMetadataMap['user'][] = $classMetadata;
                
                continue;
            }
            
            if (!array_key_exists('entity', $classMetadataMap)) {
                $classMetadataMap['entity'] = [];
            }
            
            $classMetadataMap['entity'][] = $classMetadata;
        }
        
        return $classMetadataMap;
    }

}
