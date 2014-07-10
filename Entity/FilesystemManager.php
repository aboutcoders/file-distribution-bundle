<?php

namespace Abc\Bundle\FileDistributionBundle\Entity;

use Abc\Bundle\FileDistributionBundle\Doctrine\FilesystemManager as BaseFilesystemManager;
use Doctrine\ORM\EntityManager;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class FilesystemManager extends BaseFilesystemManager
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
}