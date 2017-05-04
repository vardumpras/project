<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 16/03/2017
 * Time: 15:36
 */

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Alcyon\CoreBundle\Entity\Theme;
use Alcyon\CoreBundle\Entity\Entity as BaseEntity;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    /**
     * @dataProvider dataForTestGetterSetterProvider
     */
    public function testGetterSetter($data)
    {
        $theme = new Theme();

        $theme->setTemplate($data);
        $this->assertSame($data, $theme->getTemplate());
    }

    public function dataForTestGetterSetterProvider()
    {
        return [
          ['test template name'],
        ];
    }

    public function testExtendsClass()
    {
        $theme = new Theme();

        $this->assertInstanceOf(BaseEntity::class, $theme);
        $this->assertInstanceOf(MappedSuperclass\AuthorInterface::class, $theme);
        $this->assertInstanceOf(MappedSuperclass\SoftDeleteInterface::class, $theme);
    }
}