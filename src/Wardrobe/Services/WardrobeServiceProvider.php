<?php

namespace Wardrobe\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;

use Wardrobe\Services\WardrobeVoter;

/**
 * Wardrobe\WardrobeServiceProvider
 * 
 * @author kevin
 *
 */
class WardrobeServiceProvider implements ServiceProviderInterface
{
	/**
	 * Register services
	 * 
	 * @param Application $app
	 */
	public function register(Application $app)
	{
		$app['security.voters'] = $app->extend('security.voters', function($voters) use ($app) {
			foreach ($voters as $voter) {
				if ($voter instanceof RoleHierarchyVoter) {
					$roleHierarchyVoter = $voter;
					break;
				}
			}
			$voters[] = new WardrobeVoter($roleHierarchyVoter);
			return $voters;
		});
	}
	
	/**
	 * Add twig custom extension
	 *
	 * @param Application $app
	 */
	public function boot(Application $app)
	{
		$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
			$twig->addExtension(new WardrobeExtension($app));
			return $twig;
		}));
	}
}