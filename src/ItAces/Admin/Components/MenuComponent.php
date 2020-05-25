<?php
namespace ItAces\Admin\Components;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;
use ItAces\SoftDeleteable;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;
use ItAces\UnderAdminControl;

class MenuComponent extends Component
{
    /**
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * 
     * @var string
     */
    protected $template;
    
    /**
     * 
     * @var array
     */
    protected $menu = [];
    
    public function __construct(string $template)
    {
        $this->em = app('em');
        $this->template = $template;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \Illuminate\View\Component::render()
     */
    public function render()
    {
        $currentRoute = request()->route()->action['as'];
        
        $this->menu[] = [
            'url' => route('admin.index', [], false),
            'name' => __('Dashboard'),
            'title' => __('Administrator Dashboard'),
            'active' => $currentRoute == 'admin.index',
            'icon' => config('admin.icons.dashboard')
        ];
        
        $this->menu[] = [
            'url' => 'javascript:;', // TODO: route('admin.entity', [], false)
            'name' => __('Entities'),
            'title' => __('Entity List'),
            'active' => Str::startsWith($currentRoute, 'admin.entity'),
            'icon' => config('admin.icons.entities'),
            'submenu' => $this->getEntitiesItems($currentRoute),
            'open' => true
        ];
        
        return view($this->template, [
            'menu' => $this->menu
        ]);
    }

    protected function getEntitiesItems(string $currentRoute)
    {
        $items = [];
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
            
            if (!$reflectionClass->implementsInterface(UnderAdminControl::class)) {
                continue;
            }
            
            $submenu = [];
            
            if (Gate::inspect('read', $classUrlName)->allowed()) {
                $submenu[] = [
                    'url' => route('admin.entity.search', $classUrlName, false),
                    'name' => __('Search'),
                    'title' => __('Element List'),
                    'active' => $activeModel == $classUrlName && $currentRoute == 'admin.entity.search'
                ];
            }
            
            if (Gate::inspect('create', $classUrlName)->allowed()) {
                $submenu[] = [
                    'url' => route('admin.entity.create', $classUrlName, false),
                    'name' => __('Create'),
                    'title' => __('Add New Element'),
                    'active' => $activeModel == $classUrlName && $currentRoute == 'admin.entity.create'
                ];
            }
            
            if ($isDeleteable && Gate::inspect('restore', $classUrlName)->allowed()) {
                $submenu[] = [
                    'url' => route('admin.entity.trash', $classUrlName, false),
                    'name' => __('Trash'),
                    'title' => __('Removed Elements'),
                    'active' => $activeModel == $classUrlName && $currentRoute == 'admin.entity.trash'
                ]; 
            }
            
            if (Gate::inspect('settings')->allowed()) {
                $submenu[] = [
                    'url' => route('admin.entity.settings', $classUrlName, false),
                    'name' => __('Settings'),
                    'title' => __('Entity Settings'),
                    'active' => $activeModel == $classUrlName && Str::startsWith($currentRoute, 'admin.entity.settings')
                ];
            }
            
            $items[] = [
                'url' => 'javascript:;',
                'name' => __( Str::pluralCamelWords($className) ),
                'title' => $metadataInfo->name,
                'active' => $activeModel == $classUrlName,
                'submenu' => $submenu
            ];

            usort($items, function($a, $b) {
                if ($a['name'] == $b['name']) {
                    return 0;
                }
                
                return ($a['name'] < $b['name']) ? -1 : 1;
            });
        }
        
        return $items;
    }
    
}
