<?php

namespace Framework\Security;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AuthenticationListener implements ListenerInterface
{
    const USER = 'user';
    const PASS = 'pass';

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $authHeader = $request->headers->get('Authorization');

        list($username,$password) = explode(':', base64_decode(substr($authHeader, 6)));

        if ($username != self::USER || $password != self::PASS) {
            throw new AccessDeniedHttpException("Access denied");
        }
    }
}