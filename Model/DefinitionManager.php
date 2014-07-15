<?php

namespace Abc\Bundle\FileDistributionBundle\Model;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
abstract class DefinitionManager implements DefinitionManagerInterface
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