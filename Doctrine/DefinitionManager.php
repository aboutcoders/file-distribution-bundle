<?php

namespace Abc\Bundle\FileDistributionBundle\Doctrine;

use Abc\Bundle\FileDistributionBundle\Model\DefinitionInterface;
use Abc\Bundle\FileDistributionBundle\Model\DefinitionManager as BaseDefinitionManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class DefinitionManager extends BaseDefinitionManager
{
    /** @var ObjectManager */
    protected $objectManager;
    /** @var string */
    protected $class;
    /** @var ObjectRepository */
    protected $repository;


    /**
     * @param ObjectManager $om
     * @param string        $class
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
     * {@inheritDoc}
     */
    public function update(DefinitionInterface $definition, $andFlush = true)
    {
        $this->objectManager->persist($definition);
        if($andFlush)
        {
            $this->objectManager->flush();
        }
    }


    /**
     * {@inheritDoc}
     */
    public function delete(DefinitionInterface $definition)
    {
        $this->objectManager->remove($definition);
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