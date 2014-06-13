<?php

namespace Abc\FileDistributionBundle\Form;

class EntityDynamicFormType extends DynamicFormType
{

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'entity_dynamic_form';
    }
} 