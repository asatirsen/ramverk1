<?php

namespace Asti\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * function checks if input is an ip address and if so, if it's PIv4 or Ipv6
     */
    public function checkWhichTypeOfIp(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $hostname = gethostbyaddr($ip);
            return "That is an IPv6 address with the domain name: " . $hostname;
        } else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $hostname = gethostbyaddr($ip);
            return "That is an IPv4 address with the domain name: " . $hostname;
        } else {
            var_dump($ip);
            return "That is not a valid IP-adress";
        }
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     *
     */
    public function indexAction(): object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $getParams = $request->getGet();

        if ($getParams) {
            $ip = $getParams["ipCheck"];
            $data = [
                "ipAdress" => $this->checkWhichTypeOfIp($ip),
            ];
            $page->add("ip_view/ip-check-result", $data);
            return $page->render($data);
        }
        $page->add("ip_view/ip_check");
        return $page->render();
    }
}
