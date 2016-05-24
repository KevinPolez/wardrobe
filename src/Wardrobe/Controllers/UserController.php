<?php

namespace Wardrobe\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\DisabledException;
use InvalidArgumentException;


/**
 * Wardrobe\Controllers\UserController
 *
 * @author kevin
 *
 */
class UserController
{
	/**
	 *
	 * @var boolean $isEmailConfirmationRequired
	 */
	private $isEmailConfirmationRequired = true;
	
	/**
	 *
	 * @var boolean $isPasswordResetEnabled
	 */
	private $isPasswordResetEnabled = true;

	/**
	 * Création d'un utilisateur
	 *
	 * @param Request $request
	 * @return User
	 * @throws InvalidArgumentException
	 */
	protected function createUserFromRequest(Application $app, Request $request)
	{
		if ($request->request->get('password') != $request->request->get('confirm_password')) {
			throw new InvalidArgumentException('Passwords don\'t match.');
		}
	
		$user = $app['user.manager']->createUser(
				$request->request->get('email'),
				$request->request->get('password'),
				$request->request->get('name') ?: null,
				array('ROLE_USER'));
	
		if ($username = $request->request->get('username')) {
			$user->setUsername($username);
		}
	
		$errors = $app['user.manager']->validate($user);
	
		if (!empty($errors)) {
			throw new InvalidArgumentException(implode("\n", $errors));
		}
	
		return $user;
	}
	
	/**
	 * Login
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function loginAction(Request $request, Application $app)
	{
		$authException = $app['user.last_auth_exception']($request);
		
		if ($authException instanceof DisabledException) {
			// This exception is thrown if (!$user->isEnabled())
			// Warning: Be careful not to disclose any user information besides the email address at this point.
			// The Security system throws this exception before actually checking if the password was valid.
			$user = $app['user.manager']->refreshUser($authException->getUser());
		
			return $app['twig']->render('public/user/login-confirmation-needed.twig', array(
					'email' => $user->getEmail(),
					'fromAddress' => $app['user.mailer']->getFromAddress(),
					'resendUrl' => $app['url_generator']->generate('user.resend-confirmation'),
			));
		}
		
		return $app['twig']->render('public/user/login.twig', array(
				'error' => $authException ? $authException->getMessageKey() : null,
				'last_username' => $app['session']->get('_security.last_username'),
				'allowRememberMe' => isset($app['security.remember_me.response_listener']),
		));
	}
	
	public function logoutAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/homepage.twig', array());
	}
	
	/**
	 * Register
	 * 
	 * @param Request $request
	 * @param Application $app
	 * @throws InvalidArgumentException
	 */
	public function registerAction(Request $request, Application $app)
	{
		if ($request->isMethod('POST')) {
			try {
				$user = $this->createUserFromRequest($app, $request);
				
				if ($error = $app['user.manager']->validatePasswordStrength($user, $request->request->get('password'))) {
					throw new InvalidArgumentException($error);
				}
				
				if ($this->isEmailConfirmationRequired) {
					$user->setEnabled(false);
					$user->setConfirmationToken($app['user.tokenGenerator']->generateToken());
				}
				
				$app['user.manager']->insert($user);
		
				if ($this->isEmailConfirmationRequired) {
					// Send email confirmation.
					$app['user.mailer']->sendConfirmationMessage($user);
		
					// Render the "go check your email" page.
					return $app['twig']->render('public/user/register-confirmation-sent.twig', array(
						'email' => $user->getEmail(),
					));
				} else {
					// Log the user in to the new account.
					$app['user.manager']->loginAsUser($user);
		
					$app['session']->getFlashBag()->set('success', 'Votre compte a été créé !');
		
					return $app->redirect($app['url_generator']->generate('homepage'));
				}
		
			} catch (InvalidArgumentException $e) {
				$error = $e->getMessage();
			}
		}
		
		return $app['twig']->render('public/user/register.twig', array(
				'error' => isset($error) ? $error : null,
				'name' => $request->request->get('name'),
				'email' => $request->request->get('email'),
				'username' => $request->request->get('username'),
		));
	}
	
	public function forgotPasswordAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/homepage.twig', array());
	}
	
	public function confirmEmailAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/homepage.twig', array());
	}
	
	public function resendConfirmationAction(Request $request, Application $app)
	{
		return $app['twig']->render('public/homepage.twig', array());
	}
	
	public function resetPassword(Request $request, Application $app)
	{
		return $app['twig']->render('public/homepage.twig', array());
	}
}