<?php

namespace Abc\FileDistributionBundle\Form\Filesystem;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmptyPropertiesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => function (FormInterface $form) {
                return $form->getData();
            },
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abc_filedistributionbundle_filesystem';
    }
}
