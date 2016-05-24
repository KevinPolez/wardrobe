<?php

namespace Wardrobe;

use Silex\Application;
use Silex\ControllerProviderInterface;


/**
 * Wardrobe\PrivateControllerProvider
 * 
 * @author kevin
 *
 */
class PrivateControllerProvider implements ControllerProviderInterface
{
	
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];
		
		/** Private homepage */
		$controllers->match('/','Wardrobe\Controllers\PrivateController::homepageAction')
			->method('GET')
			->bind('private.homepage');
		
		return $controllers;
	}
}