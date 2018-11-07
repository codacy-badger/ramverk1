<?php
/**
 * Internal routes that deal with error situations when pages are not found,
 * forbidden or internal error happens.
 */
return [
    "routes" => [
        [
            "info" => "ip validator.",
            "mount" => "ip",
            "handler" => "\Anax\Controller\IpValidatorController",
        ],
        [
            "info" => "ip validator REST-API.",
            "mount" => "rest",
            "handler" => "\Anax\Controller\IpRestAPIController",
        ],
    ]
];
