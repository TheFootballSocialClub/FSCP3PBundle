<?php

namespace FSC\P3PBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use FSC\P3PBundle\DependencyInjection\FSCP3PExtension;

class FSCP3PExtensionTest extends \PHPUnit_Framework_Testcase
{
    public function testExtension()
    {
        $extension = new FSCP3PExtension();
        $containerBuilder = new ContainerBuilder();

        $p3pConfig = array(
            'value' => null,
            'pattern' => null,
        );
        $extension->load(array('fscp3_p' => $p3pConfig), $containerBuilder);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testExtensionWithNoConfig()
    {
        $extension = new FSCP3PExtension();
        $containerBuilder = new ContainerBuilder();

        $p3pConfig = array();
        $extension->load(array('fscp3_p' => $p3pConfig), $containerBuilder);
    }

    public function testExtensionWithConfig()
    {
        $extension = new FSCP3PExtension();
        $containerBuilder = new ContainerBuilder();

        $p3pConfig = array(
            'value' => 'ABCD',
            'pattern' => '#/#',
        );
        $extension->load(array('fscp3_p' => $p3pConfig), $containerBuilder);

        $containerBuilder->compile();

        $this->assertEquals('ABCD', $containerBuilder->getParameter('fsc.p3p.decorator.value'));
        $this->assertEquals('#/#', $containerBuilder->getParameter('fsc.p3p.decorator.pattern'));
    }
}
