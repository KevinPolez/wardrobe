<?php

namespace Wardrobe\Services;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;

use Wardrobe\Entities\User;

/**
 * Wardrobe\WardrobeVoter
 * @author kevin
 *
 */
class WardrobeVoter implements VoterInterface
{
	/** @var RoleHierarchyVoter */
	protected $roleHierarchyVoter;
	
	/**
	 * Constructor
	 * 
	 * @param RoleHierarchyVoter $roleHierarchyVoter
	 */
	public function __construct(RoleHierarchyVoter $roleHierarchyVoter)
	{
		$this->roleHierarchyVoter = $roleHierarchyVoter;
	}
	
	/**
	 * Check if attribute is allowed
	 * 
	 * @param unknown $attribute
	 */
	public function supportsAttribute($attribute)
	{
		return in_array($attribute, array() );
	}
	
	/**
	 * Checks if the voter supports the given user token class.
	 *
	 * @param string $class A class name
	 *
	 * @return true if this Voter can process the class
	 */
	public function supportsClass($class)
	{
		return true;
	}
	
	/**
	 * Check user right
	 * 
	 * @param TokenInterface $token
	 * @param unknown $object
	 * @param array $attributes
	 */
	public function vote(TokenInterface $token, $object, array $attributes)
	{
		$user = $token->getUser();
	
		foreach ($attributes as $attribute) {
			if (!$this->supportsAttribute($attribute)) {
				continue;
			}
		}
		
		return VoterInterface::ACCESS_ABSTAIN;
	}
	
	/**
	 * Check if user own requeste  role
	 *
	 * @param Token $token
	 * @param string $role
	 */
	protected function hasRole($token, $role)
	{
		return VoterInterface::ACCESS_GRANTED == $this->roleHierarchyVoter->vote($token, null, array($role));
	}
}