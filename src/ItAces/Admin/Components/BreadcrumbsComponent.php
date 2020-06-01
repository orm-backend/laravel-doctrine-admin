<?php
namespace ItAces\Admin\Components;

use Illuminate\View\Component;
use ItAces\Utility\Helper;
use ItAces\Utility\Str;

class BreadcrumbsComponent extends Component
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
        $activeGroup = request()->route()->parameters['group'] ?? 'entity';
        $activeModel = request()->route()->parameters['model'] ?? null;
        $currentRoute = request()->route()->action['as'];
        
        if ($currentRoute == 'admin.index') {
            $this->menu[] = [
                'url' => route('admin.index', [$activeGroup], false),
                'name' => __('Dashboard'),
                'title' => __('Administrator Dashboard'),
                'icon' => config('admin.icons.dashboard')
            ];
        } else {
            $this->menu[] = [
                'url' => 'javascript:;', // TODO: route('admin.entity', [], false)
                'name' => __(ucfirst(Str::plural($activeGroup))),
                'title' => __('Entity List'),
                'icon' => config('admin.icons.entities')
            ];
            
            if ($activeModel) {
                $className = Helper::classFromUlr($activeModel);
                $reflectionClass = new \ReflectionClass($className);
                $classShortName = $reflectionClass->getShortName();
                
                $this->menu[] = [
                    'url' => route('admin.'.$activeGroup.'.search', [$activeModel], false),
                    'name' => __( Str::pluralCamelWords($classShortName) ),
                    'title' => $className
                ];
                
                switch ($currentRoute) {
                    case 'admin.'.$activeGroup.'.search':
                        $this->menu[] = [
                            'name' => __( 'Search' )
                        ];
                        break;
                    case 'admin.'.$activeGroup.'.trash':
                        $this->menu[] = [
                            'name' => __( 'Trash' )
                        ];
                        break;
                    case 'admin.'.$activeGroup.'.settings':
                        $this->menu[] = [
                            'name' => __( 'Settings' )
                        ];
                        break;
                    case 'admin.'.$activeGroup.'.create':
                        $this->menu[] = [
                            'name' => __( 'Create' )
                        ];
                        break;
                    case 'admin.'.$activeGroup.'.edit':
                        $this->menu[] = [
                            'name' => __( 'Edit' )
                        ];
                        break;
                    case 'admin.'.$activeGroup.'.details':
                        $this->menu[] = [
                            'name' => __( 'Details' )
                        ];
                        break;
                }
            }
        }
        
        return view($this->template, [
            'menu' => $this->menu
        ]);
    }
    
}
