<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 21/03/2017
 * Time: 11:08
 */

namespace Tests\Alcyon\CoreBundle\Form;

use Alcyon\CoreBundle\Entity\Periode;
use Alcyon\CoreBundle\Form\Form;
use Alcyon\CoreBundle\Form\PeriodeType;
use Symfony\Component\Form\Test\TypeTestCase;

class PeriodeTypeTest extends TypeTestCase
{
    private $formData = [ 'start' => '11-11-2001', 'end' => 'test'];

    public function testExtendClass()
    {
        $this->assertTrue(is_subclass_of(PeriodeType::class, Form::class));
    }

    public function testSubmitValidData()
    {
        $periode = new Periode();

        $form = $this->factory->create(PeriodeType::class, $periode);

        $this->assertEquals($periode, $form->getData());
        // submit the data to the form directly
        $form->submit($this->formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertInstanceof(\DateTime::class, $periode->getStart());
        $this->assertNull($periode->getEnd());

        $date = \DateTime::createFromFormat('d-m-Y', $this->formData['start'])->setTime(0,0,0);
        $this->assertEquals($date, $periode->getStart());
    }

    public function testFormView()
    {

        $form = $this->factory->create(PeriodeType::class);
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($this->formData) as $key) {
            $this->assertArrayHasKey($key, $children);

            $attr = [
                'readonly' => 'readonly',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy',
                'placeholder' => 'placeholder_date_' . $key,
                'data-date-week-start' => '1',
                'data-date-language' => 'fr'];

            $this->assertSame($attr, $view->children[$key]->vars['attr']);
        }

    }
}