<?php

namespace Abc\Bundle\FileDistributionBundle\Entity;

use Abc\Bundle\FileDistributionBundle\Doctrine\DefinitionManager as BaseDefinitionManager;
use Abc\Filesystem\FilesystemType;
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
        $qb = $this->em->getRepository('\Abc\Bundle\FileDistributionBundle\Entity\Definition')
            ->createQueryBuilder('d');
        $qb->where($qb->expr()->isNotNull('d.url'))
            ->andWhere("d.url <> ''");

        $items = $qb->getQuery()->getResult();
        $ret   = $this->buildArray($items);

        return $ret;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilesystemsByType(FilesystemType $type)
    {
        $qb = $this->em->getRepository('\Abc\Bundle\FileDistributionBundle\Entity\Definition')
            ->createQueryBuilder('d');
        $qb->where("d.type = ?1")
            ->setParameter(1, $type);

        $items = $qb->getQuery()->getResult();
        $ret   = $this->buildArray($items);

        return $ret;
    }

    /**
     * @param $items
     * @return mixed
     */
    private function buildArray($items)
    {
        $ret = array();
        foreach ($items as $item) {
            $ret[$item->getId()] = $item->getName();
        }
        return $ret;
    }
}