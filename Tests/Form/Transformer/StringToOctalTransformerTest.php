<?php
namespace Abc\Bundle\FileDistributionBundle\Tests\Form\Transformer;

use Abc\Bundle\FileDistributionBundle\Form\Transformer\StringToOctalTransformer;

class StringToOctalTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var StringToOctalTransformer */
    protected $subject;

    /**
     * @before
     */
    public function setupSubject()
    {
        $this->subject = new StringToOctalTransformer();
    }

    public function testTransformWithValidValue()
    {
        $value  = '775';
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
        $this->assertEquals('775', $result);
    }


    public function testReverseTransformWithNullValue()
    {
        $result = $this->subject->reverseTransform(null);
        $this->assertNull($result);
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected a string.
     */
    public function testReverseTransformWithNonStringValueThrowsAnException()
    {
        $this->subject->reverseTransform(123);
    }

}
 