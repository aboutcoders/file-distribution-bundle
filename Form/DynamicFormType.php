<?php

namespace Abc\FileDistributionBundle\Form;

use Symfony\Component\Form\AbstractType;

class DynamicFormType extends AbstractType
{

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'dynamic_form';
    }
} 