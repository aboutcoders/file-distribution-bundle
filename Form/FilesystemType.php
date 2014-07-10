<?php

namespace Abc\Bundle\FileDistributionBundle\Form;

use Abc\File\FilesystemType as Type;
use Abc\Bundle\FileDistributionBundle\Form\Provider\FtpProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilesystemType extends AbstractType
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
            Type::FTP => new FtpProvider()
        );
        $builder->addEventSubscriber(new FieldValueChangeSubscriber($providers))
            ->add(
                'type',
                new DynamicFormType(),
                array(
                    'choices'     => array(Type::Filesystem => 'Filesystem', Type::FTP => 'FTP'),
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
            'data_class' => 'Abc\Bundle\FileDistributionBundle\Entity\Filesystem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abc_file_distribution_bundle_filesystem';
    }
}