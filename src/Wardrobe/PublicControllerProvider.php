<?php

namespace Wardrobe;

use Silex\Application;
use Silex\ControllerProviderInterface;


/**
 * Wardrobe\PublicControllerProvider
 * 
 * @author kevin
 *
 */
class PublicControllerProvider implements ControllerProviderInterface
{
	
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];
		
		/** Homepage */
		$controllers->match('/','Wardrobe\Controllers\PublicController::homepageAction')
			->method('GET')
			->bind('homepage');

		/** 
		 * Donate 
		 */
		$controllers->match('/donate','Wardrobe\Controllers\PublicController::donateAction')
			->method('GET')
			->bind('donate');

		/**
		 * Privacy
		 */
		$controllers->match('/privacy','Wardrobe\Controllers\PublicController::privacyAction')
			->method('GET')
			->bind('privacy');

		/**
		 * Accounting
		 */
		$controllers->match('/accounting','Wardrobe\Controllers\PublicController::accountingAction')
			->method('GET')
			->bind('accounting');
		
		/**
		 * Accounting
		 */
		$controllers->match('/faq','Wardrobe\Controllers\PublicController::faqAction')
			->method('GET')
			->bind('faq');
		
		/**
		 * Bug report
		 */
		$controllers->match('/bug','Wardrobe\Controllers\PublicController::bugAction')
			->method('GET')
			->bind('bug');	
		
		/**
		 * Bug report
		 */
		$controllers->match('/contact','Wardrobe\Controllers\PublicController::contactAction')
			->method('GET')
			->bind('contact');
			
		/**
		 * Login
		 */
		$controllers->match('/login','Wardrobe\Controllers\UserController::loginAction')
			->bind("user.login")
			->method('GET');
		
		/**
		 * Logout
		 */
		$controllers->match('/logout','Wardrobe\Controllers\UserController::logoutAction')
			->bind("user.logout")
			->method('GET');
			
		/**
		 * Register
		 */
		$controllers->match('/register','Wardrobe\Controllers\UserController::registerAction')
			->bind("user.register")
			->method('GET|POST');
			
		/**
		 * Forgot password
		 */
		$controllers->match('/forgot-password', 'Wardrobe\Controllers\UserController::forgotPasswordAction')
			->bind('user.forgot-password')
			->method('GET|POST');
		
		/**
		 * Confirm email
		 */
		$controllers->match('/confirm-email/{token}', 'Wardrobe\Controllers\UserController::confirmEmailAction')
			->bind('user.confirm-email')
			->method('GET');
			
		/**
		 * Resend confirmation email
		 */
		$controllers->match('/resend-confirmation', 'Wardrobe\Controllers\UserController::resendConfirmationAction')
			->bind('user.resend-confirmation')
			->method('GET|POST');
			
		/**
		 * Reset password
		 */
		$controllers->match('/reset-password/{token}', 'Wardrobe\Controllers\UserController::resetPasswordAction')
			->bind('user.reset-password')
			->method('GET|POST');			
			
		// login_check and logout are dummy routes so we can use the names.
		// The security provider should intercept these, so no controller is needed.
		$controllers->match('/login_check', function() {})
			->bind('user.login_check')
			->method('GET|POST');
			
		$controllers->get('/logout', function() {})
			->bind('user.logout');			
		
		return $controllers;
	}
}