<?php
namespace spec\Unknown\Bundle\UserLightBundle\EventListener;

use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Unknown\Bundle\UserLightBundle\Entity\LoginRecordInterface;
use Unknown\Bundle\UserLightBundle\Entity\UserLightBaseInterface;

class LogSuccessfulAuthenticationSpec extends ObjectBehavior
{
    public function let(RequestStack $requestStack, Request $request, EntityManager $entityManager)
    {
        $requestStack->getMasterRequest()->willReturn($request);
        $request->getClientIp()->willReturn('123.456.789.012');
        $loginEntityClass = 'spec\Unknown\Bundle\UserLightBundle\EventListener\LoginEntity';
        $this->beConstructedWith($requestStack, $entityManager, $loginEntityClass);
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Unknown\Bundle\UserLightBundle\EventListener\LogSuccessfulAuthentication');
    }

    public function it_logs_successful_event(
        AuthenticationEvent $event,
        TokenInterface $token,
        UserLightBaseInterface $user,
        EntityManager $entityManager
    ) {
        $user->getUsername()->willReturn('user@name');
        $event->getAuthenticationToken()->willReturn($token);
        $token->getUser()->willReturn($user);
        $entityManager->persist(Argument::any())->shouldBeCalled();
        $entityManager->flush(Argument::any())->shouldBeCalled();

        $this->onSuccess($event);
    }

}

class LoginEntity implements LoginRecordInterface
{
    protected $user;
    protected $dateTime;
    protected $ip;

    public function setUser(UserLightBaseInterface $user)
    {
        if ($user->getUsername() != 'user@name') {
            throw new \Exception("Unexpected argument");
        }
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setDateTime(\DateTime $dateTime)
    {
        if ($dateTime->format('Y-m-d H:i:s') != date('Y-m-d H:i:s')) {
            throw new \Exception("Unexpected argument");
        }
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setIp($ip)
    {
        if ($ip != date('123.456.789.012')) {
            throw new \Exception("Unexpected argument");
        }
        $this->ip = $ip;
        return $this;
    }

    public function getIp()
    {
        return $this->ip;
    }
}
