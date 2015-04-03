<?php
namespace Unknown\Bundle\UserLightBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class UnknownUserLightExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);
        $container->setParameter('unknown_user_light.user_entity_class', $config['user_entity_class']);
        $container->setParameter('unknown_user_light.login_record_class', $config['login_record_class']);
        $container->setParameter('unknown_user_light.login_template', $config['login_template']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/'));
        $loader->load("services.yml");
    }
}
