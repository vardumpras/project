<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 15/02/2017
 * Time: 12:20
 */

namespace Alcyon\CoreBundle\Service;


class Mailer
{
    private $mailer;

    /**
     * @return mixed
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Mailer constructor.
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($subjet, $from, $to, $body, $copy = null, $attachements = null, $hiddenCopy = null)
    {
        $message = \Swift_Message::newInstance()
            // Give the message a subject
            ->setSubject($subjet)
            // Set the From address with an associative array
            ->setFrom($from)
            // Set the To addresses with an associative array
            ->setTo($to)
            // Give it a body
            ->setBody($body)
            ->addPart($body, 'text/html');

        // copy email
        if ($copy)
            $message->setCc($copy);

        // hidden copy email
        if ($hiddenCopy)
            $message->setBcc($hiddenCopy);

        if ($attachements) {
            if (is_array($attachements)) {
                foreach ($attachements as $attachement)
                    $message->attach(\Swift_Attachment::fromPath($attachement));
            } else {
                $message->attach(\Swift_Attachment::fromPath($attachements));
            }

        }

        if($this->mailer->send($message)) {
            return $message;
        }

        return null;
    }
}