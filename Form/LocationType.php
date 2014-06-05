<?php

namespace Abc\FileDistributionBundle\Form;

use Abc\File\FilesystemType;
use Abc\FileDistributionBundle\Form\Filesystem\EmptyPropertiesType;
use Abc\FileDistributionBundle\Form\Provider\FtpProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('path')
            ->add('url')
            ->add('properties', new EmptyPropertiesType(), array('label' => false));

        $providers = array(
            FilesystemType::FTP => new FtpProvider()
        );
        $builder->addEventSubscriber(new FieldValueChangeSubscriber($providers))
            ->add(
                'type',
                new DynamicFormType(),
                array(
                    'choices'     => array(FilesystemType::Filesystem => 'Filesystem', FilesystemType::FTP => 'FTP'),
                    'empty_value' => 'Choose an option',
                    'required'    => true,
                )
            );

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Abc\FileDistributionBundle\Entity\Location'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abc_filedistributionbundle_location';
    }
}