<?php
namespace spec\Unknown\Bundle\UserLightBundle\Controller;

use PhpSpec\ObjectBehavior;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;

class SecurityControllerSpec extends ObjectBehavior
{
    public function let(
        ContainerInterface $container,
        Request $request,
        Session $session,
        ParameterBag $attributes,
        TwigEngine $template
    ) {
        $this->beConstructedWith();

        $container->getParameter('unknown_user_light.login_template')->willReturn('template1.html.twig');
        $container->get('templating')->willReturn($template);
        $this->setContainer($container);

        $request->getSession()->willReturn($session);
        $request->attributes = $attributes;
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Unknown\Bundle\UserLightBundle\Controller\SecurityController');
    }

    public function it_builds_initial_view(
        ContainerInterface $container,
        Request $request,
        ParameterBag $attributes,
        Session $session,
        TwigEngine $template
    ) {
        $attributes->has(Security::AUTHENTICATION_ERROR)->willReturn(false);
        $session->has(Security::AUTHENTICATION_ERROR)->willReturn(false);
        $session->get(Security::LAST_USERNAME)->willReturn('username1');

        $template->renderResponse(
            'template1.html.twig',
            ['last_username' => 'username1', 'error' => null],
            null
        )->shouldBeCalled();
        $this->loginAction($request);
    }

    public function it_builds_request_error_view(
        ContainerInterface $container,
        Request $request,
        ParameterBag $attributes,
        Session $session,
        TwigEngine $template
    ) {
        $attributes->has(Security::AUTHENTICATION_ERROR)->willReturn(true);
        $attributes->get(Security::AUTHENTICATION_ERROR)->willReturn('error1');
        $session->has(Security::AUTHENTICATION_ERROR)->willReturn(false);
        $session->get(Security::LAST_USERNAME)->willReturn('username1');


        $template->renderResponse(
            'template1.html.twig',
            ['last_username' => 'username1', 'error' => 'error1'],
            null
        )->shouldBeCalled();
        $this->loginAction($request);
    }

    public function it_builds_session_error_view(
        ContainerInterface $container,
        Request $request,
        ParameterBag $attributes,
        Session $session,
        TwigEngine $template
    ) {
        $attributes->has(Security::AUTHENTICATION_ERROR)->willReturn(false);
        $session->has(Security::AUTHENTICATION_ERROR)->willReturn(true);
        $session->get(Security::AUTHENTICATION_ERROR)->willReturn('error1');
        $session->remove(Security::AUTHENTICATION_ERROR)->willReturn(null);
        $session->get(Security::LAST_USERNAME)->willReturn('username1');

        $template->renderResponse(
            'template1.html.twig',
            ['last_username' => 'username1', 'error' => 'error1'],
            null
        )->shouldBeCalled();
        $this->loginAction($request);
    }
}
