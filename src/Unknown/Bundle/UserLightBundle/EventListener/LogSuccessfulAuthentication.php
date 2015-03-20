<?php
namespace Unknown\Bundle\UserLightBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Unknown\Bundle\UserLightBundle\Entity\LoginRecordInterface;

class LogSuccessfulAuthentication // implements EventSubscriberInterface
{
    protected $ip;

    protected $entityManager;

    protected $loginRecordClass;

    public function __construct(RequestStack $requestStack, EntityManager $entityManager, $loginRecordClass)
    {
        if ($requestStack && ($masterRequest = $requestStack->getMasterRequest())) {
            $this->ip = $masterRequest->getClientIp();
        } else {
            $this->ip = '127.0.0.1';
        }

        $this->entityManager    = $entityManager;
        $this->loginRecordClass = $loginRecordClass;
    }

    public function onSuccess(AuthenticationEvent $event)
    {
        if (!$this->loginRecordClass) {
            return;
        }

        $token = $event->getAuthenticationToken();
        $user = $token->getUser();

        $loginRecord = new $this->loginRecordClass(); /* @var $loginRecord LoginRecordInterface */
        $loginRecord->setUser($user);
        $loginRecord->setDateTime(new \DateTime());
        $loginRecord->setIp($this->ip);
        $this->entityManager->persist($loginRecord);
        $this->entityManager->flush($loginRecord);
    }

    /*public static function getSubscribedEvents()
    {
        return array(
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onSuccess',
        );
    }*/
}
