<?php
namespace spec\Unknown\Bundle\UserLightBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UnknownUserLightExtensionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Extension\Extension');
    }

    public function it_should_add_report_configuration_to_container(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->setParameter('unknown_user_light.user_entity_class', 'UserEntity')->shouldBeCalled();
        $containerBuilder->setParameter('unknown_user_light.login_record_class', 'LoginEntity')->shouldBeCalled();
        $containerBuilder->setParameter('unknown_user_light.login_template', 'template.html.twig')->shouldBeCalled();

        // building services
        $containerBuilder->addResource(Argument::any())->shouldBeCalled();
        $containerBuilder->setParameter('unknown.user_light_manager.class', Argument::any())->shouldBeCalled();
        $containerBuilder->setParameter('unknown.user_light_logger.class', Argument::any())->shouldBeCalled();
        $containerBuilder->setDefinition('unknown.user_light_manager', Argument::any())->shouldBeCalled();
        $containerBuilder->setDefinition('unknown.user_light_logger', Argument::any())->shouldBeCalled();

        $config = [
            [
                'user_entity_class'  => 'UserEntity',
                'login_record_class' => 'LoginEntity',
                'login_template'     => 'template.html.twig',
            ]
        ];
        $this->load($config, $containerBuilder);
    }
}
