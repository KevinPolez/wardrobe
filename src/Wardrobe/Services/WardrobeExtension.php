<?php

namespace Wardrobe\Services;

use Doctrine\ORM\PersistentCollection;
use Silex\Application;

/**
 *  Wardrobe\Service\WardrobeExtension
 */
class WardrobeExtension extends \Twig_Extension
{

	protected $app;

	/**
	 * Constructeur. Initialise le gestionnaire de droit du forum
	 *
	 * @param Application $app
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Définition des nouvelles extensions de twig
	 */
	public function getFilters()
	{
		return array(
				new \Twig_SimpleFilter('time_diff', array($this, 'time_diff')),
				new \Twig_SimpleFilter('reverse', array($this, 'reverse')),
		);
	}

	/**
	 * Nom de l'extension
	 *
	 * @return string
	 */
	public function getName()
	{
		return 'wardrobe_extension';
	}


	/**
	 * Calcul l'interval de temps entre maintenant et une date
	 *
	 * @param \Datetime $date
	 */
	public function time_diff(\Datetime $date)
	{
		$interval = $date->diff(new \Datetime('NOW'));
		if ( $interval->days == 0 )	return "aujourd'hui";
		 
		return $interval->format('il y a %a jours');
	}

	/**
	 * Renverse un tableau
	 *
	 * @param Array $array
	 */
	public function reverse(PersistentCollection $object)
	{
		$array = $object->toArray();
		return array_reverse($array);
	}
}