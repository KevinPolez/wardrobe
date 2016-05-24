<?php

namespace Wardrobe;

use Silex\Application;
use Silex\ControllerProviderInterface;


/**
 * Wardrobe\AdminControllerProvider
 * 
 * @author kevin
 *
 */
class AdminControllerProvider implements ControllerProviderInterface
{
	
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];
		
		/** Public homepage */
		$controllers->match('/','Wardrobe\Controllers\AdminController::homepageAction')
			->method('GET')
			->bind('admin.homepage');
		
		return $controllers;
	}
}