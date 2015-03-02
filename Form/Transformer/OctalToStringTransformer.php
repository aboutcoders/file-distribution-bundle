<?php

namespace Abc\Bundle\FileDistributionBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class OctalToStringTransformer implements DataTransformerInterface
{

    /**
     * Transforms a decimal representation of octal_string to an octal string.
     *
     * @param number $value The decimal representation of octal_string
     * @return string The octal string
     *
     * @throws TransformationFailedException If the given value is not a Boolean.
     */
    public function transform($value)
    {
        if(null === $value)
        {
            return null;
        }

        return str_pad(decoct($value), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Transforms an octal string to the decimal representation of an octal_string
     *
     * @param string $value The octal string
     * @return number The decimal representation of octal_string
     * @throws TransformationFailedException If the given value is not a string.
     */
    public function reverseTransform($value)
    {
        if(null == $value)
        {
            return null;
        }

        if(!is_string($value))
        {
            throw new TransformationFailedException('Expected a string.');
        }

        return octdec($value);
    }
}