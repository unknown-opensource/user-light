<?php
namespace spec\Unknown\Bundle\UserLightBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;

class ConfigurationSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Symfony\Component\Config\Definition\ConfigurationInterface');
    }

    public function it_should_build_configuration_tree()
    {
        $root = $this->getConfigTreeBuilder()->buildTree();
        $root->shouldHaveType('Symfony\Component\Config\Definition\ArrayNode');

        $children = $root->getChildren();
        $children->shouldHaveKey('user_entity_class');
        $children->shouldHaveKey('login_record_class');
        $children->shouldHaveKey('login_template');
    }
}
