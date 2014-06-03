<?php

namespace Abc\FileDistributionBundle\Model;

use Abc\File\LocationInterface;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
interface LocationManagerInterface
{

    /**
     * Returns an empty contract instance.
     *
     * @return LocationInterface
     */
    public function create();


    /**
     * Updates a contract.
     *
     * @param LocationInterface $location
     * @return void
     */
    public function update(LocationInterface $location);


    /**
     * Deletes a contract.
     *
     * @param LocationInterface $contract
     * @return void
     */
    public function delete(LocationInterface $contract);


    /**
     * Finds a contract by the given criteria.
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
     * Returns the contract's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}