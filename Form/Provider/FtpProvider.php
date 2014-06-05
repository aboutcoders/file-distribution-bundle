<?php
namespace Abc\FileDistributionBundle\Form\Provider;

use Abc\File\FilesystemType;
use Symfony\Component\Form\Form;

class FtpProvider implements ProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(Form $form)
    {
        $form
            ->add('host', 'text', array('required' => true,))
            ->add('username', 'text', array('required' => true,))
            ->add('password', 'password', array('required' => true,));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return FilesystemType::FTP;
    }
} 