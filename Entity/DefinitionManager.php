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
}