<?php

namespace CubicMushroom\Symfony\MailchimpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cm_mailchimp');

        $rootNode
            ->children()
                ->arrayNode('mailchimp_api')
                    ->isRequired()
                    ->children()
                        ->scalarNode('api_key')
                            ->info('Set to your Mailchimp API key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end() // 'api_key'
                    ->end()
                ->end() // 'mailchimp_api'
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
