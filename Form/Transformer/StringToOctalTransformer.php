<?php

namespace Abc\Bundle\FileDistributionBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToOctalTransformer implements DataTransformerInterface
{

    /**
     * Transforms a String into a octal number.
     *
     * @param string $value string value.
     *
     * @return string Octal string representation of number
     *
     * @throws TransformationFailedException If the given value is not a Boolean.
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        return str_pad($value, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Transforms a octal_string into a number.
     *
     * @param string $value octal_string value.
     *
     * @return number The decimal representation of octal_string
     *
     * @throws TransformationFailedException If the given value is not a string.
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw new TransformationFailedException('Expected a string.');
        }

        return $value;
    }
}