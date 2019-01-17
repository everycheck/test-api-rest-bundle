<?php
namespace EveryCheck\TestApiRestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('test_api_rest');

		$rootNode
			->children()
				->arrayNode('dir')
					->children()
						->scalarNode('payloads')
							->isRequired()
							->defaultValue('Payloads')
						->end()
						->scalarNode('expected_responses')
							->isRequired()
							->defaultValue('Responses\Expected')
						->end()
					->end()
				->end()
			->end()
		;

		return $treeBuilder;
	}				
}

?>