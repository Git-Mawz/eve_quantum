<?php

namespace App\Security;

use App\Service\EveOauth2;
use App\Service\UserChecker;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class EveOnlineAuthenticator extends AbstractGuardAuthenticator
{   
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $userChecker;
    private $eveOauth2;
    private $session;
    private $urlGenerator;

    public function __construct(UserChecker $userChecker, SessionInterface $session, EveOauth2 $eveOauth2, UrlGeneratorInterface $urlGenerator)
    {
        $this->session = $session;
        $this->userChecker = $userChecker;
        $this->eveOauth2 = $eveOauth2;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request)
    {
        // Si le nom de la route "app_login" (/login défini dans le MaincController)
        // est dans la requête, alors supports return True et déclenche l'authentification
        return self::LOGIN_ROUTE === $request->attributes->get('_route');
    }

    public function getCredentials(Request $request)
    {
        return $this->eveOauth2->authenticate();
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {   
        $user = $this->userChecker->checkUser($credentials);
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($user->getBanned() == false) {
            return true;
        }
        else {
            return false;
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // $data = [
        //     // you may want to customize or obfuscate the message first
        //     'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

        //     // or to translate this message
        //     // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        // ];

        // // return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
        // return new Response();
        $request->getSession()->getFlashBag()->add('warning', 'Vous avez été temporairement bannis de Eve Quantum');
        return new RedirectResponse($this->urlGenerator->generate('main_home'));

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // On stock les tokens (access token et refresh token) en session
        // $this->session->set('resourceOwner', $this->eveOauth2->getResourceOwner());
        $this->session->set('accessToken', $this->eveOauth2->getAccessToken());
        // Si l'utilisateur se connecte avec succès, il est rediriger vers sa page de profil
        return new RedirectResponse($this->urlGenerator->generate('character_profile'));

    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $request->getSession()->getFlashBag()->add('notice', 'Vous devez être connecté pour accéder à cette partie de Eve Quantum');
        return new RedirectResponse($this->urlGenerator->generate('main_home'));
    }

    public function supportsRememberMe()
    {
        // todo
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

}
