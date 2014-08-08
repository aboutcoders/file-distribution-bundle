<?php

namespace Abc\Bundle\FileDistributionBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToOctalTransformer implements DataTransformerInterface
{

    /**
     * Transforms a Boolean into a string.
     *
     * @param bool $value Boolean value.
     *
     * @return string String value.
     *
     * @throws TransformationFailedException If the given value is not a Boolean.
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        return '0'.decoct($value);
    }

    /**
     * Transforms a string into a Boolean.
     *
     * @param string $value String value.
     *
     * @return bool Boolean value.
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

        return octdec($value);
    }
}