<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JwtSubscriber implements EventSubscriberInterface
{
    public function onLexikJwtAuthenticationOnJwtCreated(JWTCreatedEvent $event): void
    {
        $data = $event->getData();

        $user = $event->getUser();
        if($user instanceof User) {
            $data['login'] = $user->getLogin();
            $data['exp'] = 1671478548;
//            $data['secretary'] = $user->getSecretary();
//            $data['doctor'] = $user->getDoctor();
        }

        // $data['username'] = $event->getUser()->getUsername();

        $event->setData($data);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onLexikJwtAuthenticationOnJwtCreated',
        ];
    }
}
