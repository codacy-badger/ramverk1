<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class IpRestAPIControllerTest extends TestCase
{

    // Create the di container.
    protected $di;
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $di = $this->di;
        $this->controller = new IpRestAPIController();
    }



    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        $test = "127.0.0.1";
        $res = $this->controller->indexActionGet($test);
        $js = [
                "message" => "Valid Ipv4.",
                "ip" => $test,
                "host" => gethostbyaddr($test)
            ];

        $this->assertEquals($res, json_encode($js, JSON_PRETTY_PRINT));
    }


}
