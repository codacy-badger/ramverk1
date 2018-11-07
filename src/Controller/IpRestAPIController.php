<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpRestAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";

    public function indexActionGet($value) : string
    {
        if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $json = [
                "message" => "Valid Ipv4.",
                "ip" => $value,
                "host" => gethostbyaddr($value)
            ];
        } else if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $json = [
                "message" => "Valid Ipv6.",
                "ip" => $value,
                "host" => gethostbyaddr($value)
            ];
        } else {
            $json = [
                "message" => "Not valid ip.",
                "ip" => $value
            ];
        }
        return json_encode($json, JSON_PRETTY_PRINT);
    }

    public function defaultIndexActionGet($value = "default") : string
    {
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }
}
