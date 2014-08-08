<?php


namespace Abc\Bundle\FileDistributionBundle\Form\Provider;

namespace Abc\Bundle\FileDistributionBundle\Form\Provider;

use Abc\Bundle\FileDistributionBundle\Form\Type\ModeType;
use Abc\Filesystem\FilesystemType;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class LocalProvider implements ProviderInterface
{

    /**
     * @param Form $form Provider data form.
     */
    public function buildForm(Form $form)
    {
        $form
            ->add('create', 'checkbox', array('required' => false, 'constraints' => array(new Type(array('type' => 'bool')))))
            ->add(
                'mode',
                new ModeType(),
                array(
                    'required' => false,
                )
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return FilesystemType::LOCAL;
    }
}