<?php

namespace Abc\Bundle\FileDistributionBundle\Form;

use Abc\Bundle\FileDistributionBundle\Form\Provider\LocalProvider;
use Abc\Filesystem\FilesystemType;
use Abc\Bundle\FileDistributionBundle\Form\Provider\FtpProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefinitionType extends AbstractType
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
            ->add('url', 'url', array('required' => false));

        $providers = array(
            FilesystemType::FTP => new FtpProvider(),
            FilesystemType::LOCAL => new LocalProvider()
        );

        $builder->addEventSubscriber(new FieldValueChangeSubscriber($providers))
            ->add(
                'type',
                new DynamicFormType(),
                array(
                    'choices' => array(FilesystemType::LOCAL => 'Filesystem', FilesystemType::FTP => 'FTP'),
                    'empty_value' => 'Choose an option',
                    'required' => true,
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Abc\Bundle\FileDistributionBundle\Entity\Definition'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abc_file_distribution_definition';
    }
}