<?php
namespace OrmBackend\Admin\Components;

use Illuminate\View\Component;

class AboutComponent extends Component
{

    /**
     * 
     * @var string
     */
    protected $template;
    
    public function __construct(string $template)
    {
        $this->template = $template;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Illuminate\View\Component::render()
     */
    public function render()
    {
        $packages = json_decode(file_get_contents(base_path('vendor/composer/installed.json')));
        $map = array_column($packages, 'name');
        $doctrine = array_search('doctrine/orm', $map);
        $laravel = array_search('laravel/framework', $map);
        $admin = array_search('vvk/laravel-doctrine-admin', $map);

        return view($this->template, [
            'laravel' => $packages[$laravel]->version,
            'doctrine' => $packages[$doctrine]->version,
            'admin' => $packages[$admin]->version
        ]);
    }
    
}
