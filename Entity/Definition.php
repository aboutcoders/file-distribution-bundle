<?php

namespace Abc\Bundle\FileDistributionBundle\Entity;

use Abc\Bundle\FileDistributionBundle\Model\Definition as BaseDefinition;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class Definition extends BaseDefinition
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}