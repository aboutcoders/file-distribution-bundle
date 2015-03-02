<?php

namespace Abc\Bundle\FileDistributionBundle\Tests\Form\Transformer;


use Abc\Bundle\FileDistributionBundle\Form\Transformer\OctalToStringTransformer;

class OctalToStringTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var OctalToStringTransformer */
    protected $subject;

    /**
     * @before
     */
    public function setupSubject()
    {
        $this->subject = new OctalToStringTransformer();
    }

    public function testTransformWithValidValue()
    {
        $value  = 0775;
        $result = $this->subject->transform($value);
        $this->assertEquals('0775', $result);
    }


    public function testTransformWithNullValue()
    {
        $result = $this->subject->transform(null);
        $this->assertNull($result);
    }

    public function testReverseTransform()
    {
        $value  = '0775';
        $result = $this->subject->reverseTransform($value);
        $this->assertEquals(0775, $result);
    }

    /**
     * @param $value
     * @dataProvider getReversTransformNullValues
     */
    public function testReverseTransformReturnsNull($value)
    {
        $this->assertNull($this->subject->reverseTransform($value));
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected a string.
     */
    public function testReverseTransformWithNonStringValueThrowsAnException()
    {
        $this->subject->reverseTransform(123);
    }


    public function getReversTransformNullValues()
    {
        return array(
            array(null),
            array('')
        );
    }
}