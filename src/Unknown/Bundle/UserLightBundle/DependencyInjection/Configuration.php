<?php
namespace Unknown\Bundle\UserLightBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('unknown_user_light');
        $children = $rootNode->children();
        $children->scalarNode('user_entity_class')->defaultValue('Unknown\Bundle\UserLightBundle\Entity\UserLightBase');
        $children->scalarNode('login_record_class')->defaultValue(null);
        $children->scalarNode('login_template')->defaultValue('::login.html.twig');

        return $treeBuilder;
    }
}
