<?php

namespace Abc\FileDistributionBundle\Model;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
abstract class LocationManager implements LocationManagerInterface
{

    /**
     * {@inheritDoc}
     */
    public function create()
    {
        $class = $this->getClass();
        $user = new $class;

        return $user;
    }
}