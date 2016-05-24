<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use DerAlex\Silex\YamlConfigServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Neutron\Silex\Provider\ImagineServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Silex\Provider\DoctrineOrmManagerRegistryProvider;
use Rg\Silex\Provider\Markdown\MarkdownServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Response;

use Wardrobe\Services\UserServiceProvider;
use Wardrobe\Services\WardrobeServiceProvider;


$loader = require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// read config file
$app->register(new YamlConfigServiceProvider(__DIR__ . '/config/settings.yml'));

// set up Monolog
switch ($app['config']['env'])
{
	case 'prod':
		$app['debug'] = false;
		
		$monologConfig = array(
			'monolog.logfile' => __DIR__.'/logs/production.log',
			'monolog.level' => \Monolog\Logger::CRITICAL
		);
		break;
	case 'dev':
		$app['debug'] = true;
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		
		$monologConfig = array(
				'monolog.logfile' => __DIR__.'/logs/development.log',
				'monolog.level' => \Monolog\Logger::DEBUG
		);
		break;
	default:
		// unknown env
}

$app->register(new MonologServiceProvider(), $monologConfig);

// Http cache service
$app->register(new HttpCacheServiceProvider(), array(
		'http_cache.cache_dir' => __DIR__.'/cache/http/',
		'http_cache.esi'       => null,
));

// Forms
$app->register(new FormServiceProvider());

// Add entity type on forms
$app->register(new DoctrineOrmManagerRegistryProvider());

// Form validation
$app->register(new ValidatorServiceProvider());

// traduction
$app->register(new TranslationServiceProvider(), array(
		'translator.domains' => array(),
));

// imagine
$app->register(new ImagineServiceProvider());

// http fragment
$app->register(new HttpFragmentServiceProvider());

// Twig
$app->register(new TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/../src/Wardrobe/Views',
		'twig.options'    => array(
				'cache' => __DIR__ . '/cache/twig/',
		),
));

// Email
$app->register(new SwiftmailerServiceProvider());

$app['swiftmailer.options'] = $app['config']['swiftmailer']; //voir les settings yaml
$app['swiftmailer.transport'] =  new \Swift_Transport_SendmailTransport(
		$app['swiftmailer.transport.buffer'],
		$app['swiftmailer.transport.eventdispatcher']
		);

// Doctrine DBAL
$app->register(new DoctrineServiceProvider(), array(
		'db.options' => $app['config']['database'] //voir les settings yaml
));

// Doctrine ORM
$app->register(new DoctrineOrmServiceProvider(), array(
		"orm.proxies_dir" => __DIR__."/cache/doctrine",
		"orm.em.options" => array(
				"mappings" => array(
						array(
								"type" => "annotation",
								"namespace" => "Wardrobe\Entities",
								"path" => __DIR__."/../src/Wardrobe/Entities",
						),
				),
		),
));


// Urls
$app->register(new UrlGeneratorServiceProvider());

// Sessions
$app->register(new SessionServiceProvider());

// Security
$app->register(new SecurityServiceProvider());

// User management
$app->register(new ServiceControllerServiceProvider());
$app->register(new RememberMeServiceProvider());
$app->register(new UserServiceProvider());


// Markdown
$app->register(new MarkdownServiceProvider());

// Custom services
$app->register(new WardrobeServiceProvider());


// Define firewall
$app['security.firewalls'] = array(
	'public_area' => array(
		'pattern' => '^.*$',
		'anonymous' => true,
		'remember_me' => array(),
		'form' => array(
				'login_path' => '/user/login',
				'check_path' => '/user/login_check',
		),
		'logout' => array(
				'logout_path' => '/user/logout',
		),
		'users' => $app->share(function($app) {
			return $app['user.manager'];
		}),
	),
	'secured_area' => array(	// le reste necessite d'être connecté
		'pattern' => '^/[private|admin]/.*$',
			'anonymous' => false,
			'remember_me' => array(),
			'form' => array(
				'login_path' => '/user/login',
				'check_path' => '/user/login_check',
			),
			'logout' => array(
				'logout_path' => '/user/logout',
			),
			'users' => $app->share(function($app) {
				return $app['user.manager'];
			}),
		),
	);


$app->mount('/', new Wardrobe\PublicControllerProvider());
$app->mount('/admin', new Wardrobe\AdminControllerProvider());
$app->mount('/private', new Wardrobe\PrivateControllerProvider());

/**
 * Definition des rôles
 */
$app['security.role_hierarchy'] = array(
	'ROLE_USER' => array('ROLE_USER'),
	'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ADMIN'),
);

/**
 * Gestion des droits d'accés
 */
$app['security.access_rules'] = array(
	array('^/admin/.*$', 'ROLE_ADMIN'),
	array('^/private/.*$', 'ROLE_USER'),
);

// Translator
$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
	$translator->addLoader('yaml', new YamlFileLoader());

	$translator->addResource('yaml', __DIR__.'/../src/Wardrobe/Locales/en.yml', 'en');
	$translator->addResource('yaml', __DIR__.'/../src/Wardrobe/Locales/fr.yml', 'fr');

	return $translator;
}));

// error management
$app->error(function (\Exception $e, $code) use ($app) {
	switch ($code) {
		case 404:
			return $app['twig']->render('public/error/404.twig', array(
				'code' => $code,
				'exception' => $e));
			break;			
	}
	return $app['twig']->render('public/error/500.twig', array(
				'code' => $code,
				'exception' => $e));
});





return $app;