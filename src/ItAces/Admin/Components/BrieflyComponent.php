<?php
namespace ItAces\Admin\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\Component;
use ItAces\Publishable;

class BrieflyComponent extends Component
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
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $total = 0;
        $controlled = 0;
        $registered = 0;
        $confirmed = 0;
        $userClassName = null;
        
        foreach ($metadata as $classMetadata) {
            if ($classMetadata->isMappedSuperclass) {
                continue;
            }
            
            $total ++;
            $reflectionClass = new \ReflectionClass($classMetadata->name);
            
            if ($reflectionClass->implementsInterface(Publishable::class)) {
                $controlled ++;
            }
            
            if (!$userClassName && $reflectionClass->implementsInterface(Authenticatable::class)) {
                $userClassName = $classMetadata->name;
            }
        }
        
        $qb = $this->em->createQueryBuilder();
        $qb->from($userClassName,'u');
        $qb->select($qb->expr()->countDistinct('u.'.$userClassName::getIdentifierName()));
        $registered = $qb->getQuery()
            ->enableResultCache(config('itaces.caches.result_ttl'))
            ->getSingleScalarResult();

        $qb->where($qb->expr()->isNotNull('u.emailVerifiedAt'));
        $confirmed = $qb->getQuery()
            ->enableResultCache(config('itaces.caches.result_ttl'))
            ->getSingleScalarResult();

        return view($this->template, [
            'entities' => $total,
            'controlled' => $controlled,
            'registered' => $registered,
            'confirmed' => $confirmed
        ]);
    }
}
