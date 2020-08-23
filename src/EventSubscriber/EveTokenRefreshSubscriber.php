<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class EveTokenRefreshSubscriber implements EventSubscriberInterface
{   
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function onKernelRequest(RequestEvent $event)
    {   
        $provider = new \Killmails\OAuth2\Client\Provider\EveOnline([
            'clientId'          => $_ENV["CLIENT_ID"],
            'clientSecret'      => $_ENV["SECRET_KEY"],
            'redirectUri'       => $_ENV["CALLBACK_URL"],
            ]);

        $existingAccessToken = $this->session->get('accessToken');
        
        if ($existingAccessToken != null && $existingAccessToken->hasExpired()) {
            $newAccessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $existingAccessToken->getRefreshToken()
                ]);
                
            $this->session->set('accessToken', $newAccessToken);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
