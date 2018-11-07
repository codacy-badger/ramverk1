<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpValidatorController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function checkActionPost() : object
    {
        $title = "ip result";
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $ip = $request->getPost("ip");
        function validateIP($ip){
            return inet_pton($ip) !== false;
        }

        $hostname = gethostbyaddr($ip);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $session->set("flashmessage", "Valid ipv4:${ip} with hostname: ${hostname}");
        } else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $session->set("flashmessage", "Valid ipv6:${ip} with hostname: ${hostname}");
        } else {
            $session->set("flashmessage", "This ip is NOT valid.");
        }

        return $response->redirect("ip");
    }

    public function indexAction() : object
    {
        $title = "Stylechooser";
        $page = $this->di->get("page");

        $page->add("anax/v2/ip/validator", []);

        return $page->render([
            "title" => $title,
        ]);
    }
}
