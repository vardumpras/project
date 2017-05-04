<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\Mailer;
use Tests\Resources\Tools;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{


    /**
     * @var Mailer
     */
    private $mailer;
    private $sendService;

    public function setUp()
    {
        $this->sendService = $this->getMockBuilder(\Swift_Mailer ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailer = new Mailer($this->sendService);
    }

    public function testConstruct()
    {
        $this->assertSame($this->sendService, $this->mailer->getMailer());
    }

    public function testSend()
    {
        $this->sendService->expects($this->once())
            ->method('send')
            ->with($this->callback(
                function ($input) {
                    return $input instanceof \Swift_Mime_Message;
                }))
            ->will($this->returnValue(true));

        $message = $this->mailer->send('subject',
            'from@email.com',
            'to@email.com',
            'body');

        $this->assertInstanceOf(\Swift_Message::class, $message);
        $this->assertSame('subject', $message->getSubject());
        $this->assertSame(['from@email.com' => null], $message->getFrom());
        $this->assertSame(['to@email.com' => null], $message->getTo());
        $this->assertSame('body', $message->getBody());

    }

    public function testSendError()
    {
        $this->sendService->expects($this->once())
            ->method('send')
            ->will($this->returnValue(false));

        $this->assertNull($this->mailer->send('subject',
            'from@email.com',
            'to@email.com',
            'body'));
    }

    public function testSendWithFacultativeProperty()
    {
        $this->sendService->expects($this->once())
            ->method('send')
            ->will($this->returnValue(true));

        $message = $this->mailer->send('subject',
            'from@email.com',
            'to@email.com',
            'body',
            'copy@email.com',
            null,
            'hidden@email.com');

        $this->assertInstanceOf(\Swift_Message::class, $message);
        $this->assertSame(['copy@email.com' => null], $message->getCc());
        $this->assertSame(['hidden@email.com' => null], $message->getBcc());

    }

    public function testSendWithAttachements()
    {
        $this->sendService->expects($this->exactly(2))
            ->method('send')
            ->will($this->returnValue(true));

        $message = $this->mailer->send('subject',
            'from@email.com',
            'to@email.com',
            'body',
            null,
            Tools::folderImagePath . 'test.jpg');

        $this->assertInstanceOf(\Swift_Message::class, $message);
        $this->assertTrue(strpos($message->toString(), 'Content-Disposition: attachment; filename=test.jpg') > 0);

        $message = $this->mailer->send('subject',
            'from@email.com',
            'to@email.com',
            'body',
            null,
            [
                Tools::folderImagePath . 'test.jpg',
                Tools::folderImagePath . 'test.png',
                Tools::folderImagePath . 'test.gif'
            ]);

        $this->assertInstanceOf(\Swift_Message::class, $message);
        $this->assertTrue(strpos($message->toString(), 'Content-Disposition: attachment; filename=test.jpg') > 0);
        $this->assertTrue(strpos($message->toString(), 'Content-Disposition: attachment; filename=test.png') > 0);
        $this->assertTrue(strpos($message->toString(), 'Content-Disposition: attachment; filename=test.gif') > 0);
    }
}