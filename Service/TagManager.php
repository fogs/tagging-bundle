<?php

namespace Fogs\TaggingBundle\Service;

use DoctrineExtensions\Taggable\Taggable;
use FPN\TagBundle\Entity\TagManager as BaseTagManager;
use Doctrine\ORM\Query;

class TagManager extends BaseTagManager
{
    protected $dirtyResources = array();

    public function markDirty(Taggable $resource)
    {
        if (!in_array($resource, $this->dirtyResources)) {
            $this->dirtyResources[] = $resource;
        }
    }

    public function getDirtyRessources()
    {
        $dirtyResources = $this->dirtyResources;
        $this->dirtyResources = array();
        return $dirtyResources;
    }

    /**
     * Search for tags
     *
     * @param string  $search
     */
    public function findTags($search)
    {
        return $this->em
            ->createQueryBuilder()
            ->select('t.name')
            ->from($this->tagClass, 't')
            ->where('t.slug LIKE :search')
            ->setParameter('search', strtolower('%' . $search . '%'))
            ->setMaxResults(5)
            ->orderBy('t.name')
            ->getQuery()
            ->getResult(Query::HYDRATE_SCALAR)
        ;
    }
}
