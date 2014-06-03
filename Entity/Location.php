<?php

namespace Abc\FileDistributionBundle\Entity;

use Abc\File\Location as BaseLocation;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class Location extends BaseLocation
{
    /** @var string */
    protected $path;
    /** @var string */
    protected $name;
    /** @var string */
    protected $description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


}