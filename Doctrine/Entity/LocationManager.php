<?php

namespace Abc\FileDistributionBundle\Entity;

use Abc\FileDistributionBundle\Doctrine\LocationManager as BaseLocationManager;
use Doctrine\ORM\EntityManager;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class ContractManager extends BaseLocationManager
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