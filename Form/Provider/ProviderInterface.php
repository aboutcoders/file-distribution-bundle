<?php

namespace Abc\FileDistributionBundle\Form\Provider;

use Symfony\Component\Form\Form;

interface ProviderInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @param Form $form Provider data form.
     */
    public function buildForm(Form $form);
} 