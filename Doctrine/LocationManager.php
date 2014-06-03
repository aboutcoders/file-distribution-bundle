<?php

namespace Abc\FileDistributionBundle\Doctrine;

use Abc\File\LocationInterface;
use Abc\FileDistributionBundle\Model\LocationManager as BaseLocationManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class LocationManager extends BaseLocationManager
{
    /** @var ObjectManager */
    protected $objectManager;
    /** @var string */
    protected $class;
    /** @var ObjectRepository */
    protected $repository;


    /**
     * @param ObjectManager $om
     * @param               $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository    = $om->getRepository($class);

        $metadata    = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }


    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }


    /**
     * Updates a contract
     *
     * @param LocationInterface $location
     * @param Boolean           $andFlush Whether to flush the changes (default true)
     */
    public function update(LocationInterface $location, $andFlush = true)
    {
        $this->objectManager->persist($location);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }


    /**
     * {@inheritDoc}
     */
    public function delete(LocationInterface $contract)
    {
        $this->objectManager->remove($contract);
        $this->objectManager->flush();
    }


    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }


    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}