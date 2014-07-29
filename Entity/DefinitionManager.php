<?php

namespace Abc\Bundle\FileDistributionBundle\Entity;

use Abc\Bundle\FileDistributionBundle\Doctrine\DefinitionManager as BaseDefinitionManager;
use Doctrine\ORM\EntityManager;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class DefinitionManager extends BaseDefinitionManager
{
    /** @var EntityManager */
    protected $em;


    /**
     * @param EntityManager $em
     * @param string        $class
     */
    public function __construct(EntityManager $em, $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    /**
     * Returns the filesystems that have public url as key value array
     *
     * @return array
     */
    public function getFilesystemsWithPublicUrl()
    {
        $ret = array();

        $qb = $this->em->getRepository('\Abc\Bundle\FileDistributionBundle\Entity\Definition')
            ->createQueryBuilder('d');
        $qb->where($qb->expr()->isNotNull('d.url'))
            ->andWhere("d.url <> ''");

        $items = $qb->getQuery()->getResult();

        foreach ($items as $item) {
            $ret[$item->getId()] = $item->getName();
        }

        return $ret;
    }
}