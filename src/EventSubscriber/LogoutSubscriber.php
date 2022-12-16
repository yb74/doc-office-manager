<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        // get the security token of the session that is about to be logged out
        $token = $event->getToken();

        // get the current request
        $request = $event->getRequest();

        // get the current response, if it is already set by another listener
        $response = $event->getResponse();

        // configure a custom logout response to make it empty (no redirection and no content)
        $response = new JsonResponse(null, Response::HTTP_NO_CONTENT);
        $event->setResponse($response);

        // configure a custom logout response to the homepage
//        $response = new RedirectResponse(
//            $this->urlGenerator->generate('homepage'),
//            RedirectResponse::HTTP_SEE_OTHER
//        );
//        $event->setResponse($response);
    }
}
