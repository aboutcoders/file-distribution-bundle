<?php

namespace Abc\FileDistributionBundle\Form;

use Abc\File\FilesystemType;
use Abc\FileDistributionBundle\Form\Filesystem\EmptyPropertiesType;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
            ->add('properties', new EmptyPropertiesType());

        $builder->add('type', new DynamicFormType(), array(
            'choices'     => array(FilesystemType::Filesystem => 'Filesystem', FilesystemType::FTP => 'FTP'),
            'empty_value' => 'Choose an option',
            'required'    => true,
        ));

        $formModifier = function (FormInterface $form, $type = null) {

            $formClassName = 'Abc\FileDistributionBundle\Form\Filesystem\\' . $type . 'Type';
            if (!class_exists($formClassName)) {
                $formClassName = 'Abc\FileDistributionBundle\Form\Filesystem\EmptyPropertiesType';
            }
            $form->add('properties', new $formClassName);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getType());
            }
        );

        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $locationType = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $locationType);
            }
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
            $event->stopPropagation();
        }, 900); // Always set a higher priority than ValidationListener

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