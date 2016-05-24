<?php

namespace Wardrobe\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * Wardrobe\Controllers\AdminController
 *
 * @author kevin
 *
 */
class AdminController
{
	public function homepageAction(Request $request, Application $app)
	{
		return $app['twig']->render('admin/homepage.twig', array());
	}
}