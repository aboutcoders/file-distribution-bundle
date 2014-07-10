<?php

namespace Abc\Bundle\FileDistributionBundle\Doctrine;

use Abc\Bundle\FileDistributionBundle\Entity\Filesystem;
use Abc\Bundle\FileDistributionBundle\Model\FilesystemManager as BaseFilesystemManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class FilesystemManager extends BaseFilesystemManager
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
     * Updates a contract
     *
     * @param Filesystem $filesystem
     * @param Boolean             $andFlush Whether to flush the changes (default true)
     */
    public function update(Filesystem $filesystem, $andFlush = true)
    {
        $this->objectManager->persist($filesystem);
        if($andFlush)
        {
            $this->objectManager->flush();
        }
    }


    /**
     * {@inheritDoc}
     */
    public function delete(Filesystem $filesystem)
    {
        $this->objectManager->remove($filesystem);
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