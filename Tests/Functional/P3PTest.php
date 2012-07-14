<?php

namespace FSC\P3PBundle\Tests\Functional;

class P3PTest extends BaseTestCase
{
    /**
     * @dataProvider getTestData
     */
    public function test($uri, $hasP3PHeader, $expectedP3PHeader = null)
    {
        $client = static::createClient();

        $client->request('GET', $uri);
        $headerBag = $client->getResponse()->headers;

        $this->assertEquals($hasP3PHeader, $headerBag->has('P3P'));

        if (null !== $expectedP3PHeader) {
            $this->assertEquals($expectedP3PHeader, $headerBag->get('P3P'));
        }
    }

    public function getTestData()
    {
        return array(
            array('/', true, 'CP="IDC DSP"'),
            array('/admin', false),
            array('/contact', true, 'CP="IDC DSP"'),
        );
    }
}
