<?php

namespace Wardrobe\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * Wardrobe\Controllers\PublicController
 *
 * @author kevin
 *
 */
class PublicController
{
	/**
	 * Homepage
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function homepageAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/homepage.twig', array());
	}
	
	/**
	 * Donate page
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function donateAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/donate.twig', array());
	}
	
	/**
	 * Privacy page
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function privacyAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/privacy.twig', array());
	}
	
	/**
	 * Accounting page
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function accountingAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/accounting.twig', array());
	}
	
	/**
	 * FAQ page
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function faqAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/faq.twig', array());
	}
	
	/**
	 * Bug repport page
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function bugAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/bug.twig', array());
	}
	
	/**
	 * Contact page
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function contactAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/contact.twig', array());
	}
}