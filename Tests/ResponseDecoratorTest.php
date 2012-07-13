<?php

namespace FSC\P3PBundle\Tests;

use Symfony\Component\HttpFoundation\Response;

use FSC\P3PBundle\ResponseDecorator;

class ResponseDecoratorTest extends \PHPUnit_Framework_Testcase
{
    public function testDecorate1()
    {
        $response = new Response();

        $this->assertFalse($response->headers->has('P3P'));

        $decorator = new ResponseDecorator();
        $decorator->decorate($response);

        $this->assertTrue($response->headers->has('P3P'));
    }

    public function testDecorate2()
    {
        $response = new Response();
        $response->headers->set('P3P', 'FOO');

        $decorator = new ResponseDecorator();
        $decorator->decorate($response);

        $this->assertEquals('FOO', $response->headers->get('P3P'));
    }

    public function testDecorate3()
    {
        $response = new Response();

        $decorator = new ResponseDecorator('FOO');
        $decorator->decorate($response);

        $this->assertEquals('CP="FOO"', $response->headers->get('P3P'));
    }

    /**
     * @dataProvider getTestDecorate4
     */
    public function testDecorate4($requestPathInfo, $pattern, $shouldHaveHeader)
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request', array('getPathInfo'));
        $request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue($requestPathInfo));

        $response = new Response();

        $decorator = new ResponseDecorator(null, $pattern);
        $decorator->decorate($response, $request);

        $this->assertEquals($shouldHaveHeader, $response->headers->has('P3P'));
    }

    public function getTestDecorate4()
    {
        return array(
            array('/', '#/#', true),
            array('/', '#/admin#', false),
            array('/', '#/(?!admin)#', true),
            array('/admin', '#/admin#', true),
            array('/admin', '#/(?!admin)#', false),
        );
    }

    public function testDecorate5()
    {
        $decorator = new ResponseDecorator();
        $decorator2 = new ResponseDecorator(null, null);

        $decoratorReflectionClass = new \ReflectionClass($decorator);
        $valueProperty = $decoratorReflectionClass->getProperty('value');
        $valueProperty->setAccessible(true);
        $patternProperty = $decoratorReflectionClass->getProperty('pattern');
        $patternProperty->setAccessible(true);

        $this->assertTrue(null !== $valueProperty->getValue($decorator));
        $this->assertTrue(null !== $patternProperty->getValue($decorator));

        $this->assertEquals($valueProperty->getValue($decorator), $valueProperty->getValue($decorator2));
        $this->assertEquals($patternProperty->getValue($decorator), $patternProperty->getValue($decorator2));
    }

    public function testDecorate6()
    {
        $decorator = new ResponseDecorator('IDC DSP');
        $response = new Response();

        $decorator->decorate($response);

        $this->assertEquals('CP="IDC DSP"', $response->headers->get('P3P'));
    }

    public function testDecorate7()
    {
        $decorator = new ResponseDecorator();
        $response = new Response();

        $decorator->decorate($response);

        $this->assertRegExp('/^CP="[^"]*"$/', $response->headers->get('P3P'));
    }
}
