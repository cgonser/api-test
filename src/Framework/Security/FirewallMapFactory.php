<?php

namespace Framework\Security;

use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Security\Http\FirewallMap;
use Symfony\Component\Yaml\Yaml;

class FirewallMapFactory
{
    public static function fromRoutes(string $configFile, FileLocator $fileLocator, AuthenticationListener $authenticationListener): FirewallMap
    {
        $configFilePath = $fileLocator->locate($configFile);

        $routes = Yaml::parseFile($configFilePath);

        $firewallMap = new FirewallMap();
        foreach ($routes['secure_routes'] as $route) {
            $requestMatcher = new RequestMatcher($route['path'], null, $route['methods']);

            $firewallMap->add($requestMatcher, [ $authenticationListener ]);
        }

        return $firewallMap;
    }
}