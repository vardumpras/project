<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 27/04/2017
 * Time: 09:46
 */

namespace Tests\Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Controller\ServiceController;
use PHPUnit\Framework\TestCase;

class ServiceControllerTest extends TestCase
{
    public function testLanguageAction()
    {
        $controller = new ServiceController();
    }
}