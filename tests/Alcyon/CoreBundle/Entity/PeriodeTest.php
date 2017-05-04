<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 20/03/2017
 * Time: 11:58
 */

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Periode;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class PeriodeTest extends TestCase
{
    public function testGetterSetter()
    {
        $periode = new Periode();

        $this->assertNull($periode->getStart());
        $this->assertNull($periode->getEnd());

        $dateStart = new \DateTime();
        $periode->setStart($dateStart);
        $dateEnd = new \DateTime();
        $periode->setEnd($dateEnd);
        $this->assertSame($dateStart, $periode->getStart());
        $this->assertSame($dateEnd, $periode->getEnd());
    }

    public function testPeriodeIsValide()
    {
        $periode = new Periode();
        $context = $this->getMockBuilder(ExecutionContextInterface::class)->getMock();

        $context->expects($this->never())->method($this->anything());

        // Start = date, End = null
        $periode->setStart(new \DateTime());
        $periode->validate($context);

        // Start = null, End = date
        $periode->setStart(null);
        $periode->setEnd(new \DateTime());
        $periode->validate($context);

        // Start = date, End = date, Stat < End
        $periode->setStart(new \DateTime());
        $periode->setEnd((new \DateTime())->add(new \DateInterval('PT1S'))); // Add 1 seconde
        $periode->validate($context);
    }
    public function testValidateStartAndNullMethod()
    {
        $periode = new Periode();

        $context = $this->getMockBuilder(ExecutionContextInterface::class)->getMock();
        $constraintBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)->getMock();

        $context->expects($this->once())
            ->method('buildViolation')
            ->with($this->equalTo("date_start_or_end_required"))
            ->will($this->returnValue($constraintBuilder));

        $constraintBuilder->expects($this->once())
            ->method('atPath')
            ->with($this->equalTo("start"))
            ->will($this->returnValue($constraintBuilder));

        $constraintBuilder->expects($this->once())
            ->method('addViolation');

        // Start && end is null : Add violation
        $periode->validate($context);
    }

    public function testValidateStartIsGreaterThanEnd()
    {
        $periode = new Periode();

        $periode->setEnd(new \DateTime());
        $periode->setStart((new \DateTime())->add(new \DateInterval('PT1S'))); // Add 1 seconde

        $context = $this->getMockBuilder(ExecutionContextInterface::class)->getMock();
        $constraintBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)->getMock();

        $context->expects($this->once())
            ->method('buildViolation')
            ->with($this->equalTo("date_start_or_end_required"))
            ->will($this->returnValue($constraintBuilder));

        $constraintBuilder->expects($this->once())
            ->method('atPath')
            ->with($this->equalTo("start"))
            ->will($this->returnValue($constraintBuilder));

        $constraintBuilder->expects($this->once())
            ->method('addViolation');

        // Start && end is null : Add violation
        $periode->validate($context);
    }
}