<?php

namespace Abc\Bundle\FileDistributionBundle\Model;

use Abc\Bundle\FileDistributionBundle\Entity\Filesystem;
use Abc\File\FilesystemInterface;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
interface FilesystemManagerInterface
{

    /**
     * @return Filesystem
     */
    public function create();


    /**
     * @param Filesystem $filesystem
     * @return void
     */
    public function update(Filesystem $filesystem);


    /**
     * @param Filesystem $contract
     * @return void
     */
    public function delete(Filesystem $contract);


    /**
     * Finds an entity by the given criteria.
     *
     * @param array $criteria
     * @return Filesystem
     */
    public function findBy(array $criteria);


    /**
     * Returns a collection with all instances.
     *
     * @return \Traversable
     */
    public function findAll();


    /**
     * Returns the entity fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}