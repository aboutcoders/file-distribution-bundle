<?php


namespace Abc\Bundle\FileDistributionBundle\Form\Type;


use Abc\Bundle\FileDistributionBundle\Form\Transformer\OctalToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ModeType extends TextType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new OctalToStringTransformer());
    }
} 