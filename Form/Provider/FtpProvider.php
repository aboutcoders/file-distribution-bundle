<?php
namespace Abc\Bundle\FileDistributionBundle\Form\Provider;

use Abc\Bundle\FileDistributionBundle\Form\Type\FtpType;
use Abc\Filesystem\FilesystemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Form;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class FtpProvider implements ProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(Form $form)
    {
        $form
            ->add(
                'host',
                'text',
                array(
                    'constraints' => array(
                        new Type(array('type' => 'string')),
                    )
                )
            )

            ->add('username', 'text', array('required' => false))
            ->add('password', 'text', array('required' => false))
            ->add(
                'create',
                new CheckboxType(),
                array(
                    'required' => false,
                    'constraints' => array(
                        new Type(array('type' => 'bool')),
                    )
                )
            )
            ->add(
                'mode',
                'choice',
                array(
                    'required' => false,
                    'choices' => array(

                        1 => 'ASCII',
                        2 => 'Binary',
                    )
                )
            )
            ->add(
                'passive',
                new CheckboxType(),
                array(
                    'required' => false,
                    'constraints' => array(
                        new Type(array('type' => 'bool')),
                    )
                )
            )
            ->add(
                'ssl',
                new CheckboxType(),
                array(
                    'required' => false,
                    'constraints' => array(
                        new Type(array('type' => 'bool')),
                    )
                )
            );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return FilesystemType::FTP;
    }
}