<?php

namespace Asti\Api;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Asti\Api\IpCheck;

/**
 * A test controller to show off using a model.
 */
class RestApiController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * function checks if input is an ip address and if so, if it's PIv4 or Ipv6
     */
//    public function indexAction()
//    {

//    }

    public function checkActionPost()
    {
        $request = $this->di->get("request");
        $ip = $request->getPost("ipCheck");
        $ipCheck = new IpCheck();
        $res = json_encode($ipCheck->check($ip));
        return $res;
    }
}
