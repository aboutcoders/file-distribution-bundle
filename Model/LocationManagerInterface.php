<?php

namespace Abc\FileDistributionBundle\Model;

use Abc\File\LocationInterface;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
interface LocationManagerInterface
{

    /**
     * Returns an empty location instance.
     *
     * @return LocationInterface
     */
    public function create();


    /**
     * Updates a location.
     *
     * @param LocationInterface $location
     * @return void
     */
    public function update(LocationInterface $location);


    /**
     * Deletes a location.
     *
     * @param LocationInterface $contract
     * @return void
     */
    public function delete(LocationInterface $contract);


    /**
     * Finds a location by the given criteria.
     *
     * @param array $criteria
     * @return LocationInterface
     */
    public function findBy(array $criteria);


    /**
     * Returns a collection with all instances.
     *
     * @return \Traversable
     */
    public function findAll();


    /**
     * Returns the locations fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}