<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-04-28 10:39:26.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace Wardrobe\Entities;

/**
 * Wardrobe\Entities\User
 *
 * @Entity()
 * @Table(name="`user`", uniqueConstraints={@UniqueConstraint(name="id_UNIQUE", columns={"id"}), @UniqueConstraint(name="email_UNIQUE", columns={"email"}), @UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseUser", "extended":"User"})
 */
class BaseUser
{
    /**
     * @Id
     * @Column(type="integer", options={"unsigned":true})
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=100)
     */
    protected $email;

    /**
     * @Column(name="`password`", type="string", length=255)
     */
    protected $password;

    /**
     * @Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @Column(type="string", length=255)
     */
    protected $rights;

    /**
     * @Column(type="datetime")
     */
    protected $creation_date;

    /**
     * @Column(type="datetime")
     */
    protected $update_date;

    /**
     * @Column(type="string", length=255)
     */
    protected $username;

    /**
     * @Column(type="boolean")
     */
    protected $is_enabled;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    protected $confirmation_token;

    /**
     * @Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $time_password_reset_requested;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \Wardrobe\Entities\User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of email.
     *
     * @param string $email
     * @return \Wardrobe\Entities\User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of password.
     *
     * @param string $password
     * @return \Wardrobe\Entities\User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of salt.
     *
     * @param string $salt
     * @return \Wardrobe\Entities\User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get the value of salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the value of rights.
     *
     * @param string $rights
     * @return \Wardrobe\Entities\User
     */
    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * Get the value of rights.
     *
     * @return string
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * Set the value of creation_date.
     *
     * @param \DateTime $creation_date
     * @return \Wardrobe\Entities\User
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * Get the value of creation_date.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set the value of update_date.
     *
     * @param \DateTime $update_date
     * @return \Wardrobe\Entities\User
     */
    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;

        return $this;
    }

    /**
     * Get the value of update_date.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * Set the value of username.
     *
     * @param string $username
     * @return \Wardrobe\Entities\User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of is_enabled.
     *
     * @param boolean $is_enabled
     * @return \Wardrobe\Entities\User
     */
    public function setIsEnabled($is_enabled)
    {
        $this->is_enabled = $is_enabled;

        return $this;
    }

    /**
     * Get the value of is_enabled.
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->is_enabled;
    }

    /**
     * Set the value of confirmation_token.
     *
     * @param string $confirmation_token
     * @return \Wardrobe\Entities\User
     */
    public function setConfirmationToken($confirmation_token)
    {
        $this->confirmation_token = $confirmation_token;

        return $this;
    }

    /**
     * Get the value of confirmation_token.
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmation_token;
    }

    /**
     * Set the value of time_password_reset_requested.
     *
     * @param integer $time_password_reset_requested
     * @return \Wardrobe\Entities\User
     */
    public function setTimePasswordResetRequested($time_password_reset_requested)
    {
        $this->time_password_reset_requested = $time_password_reset_requested;

        return $this;
    }

    /**
     * Get the value of time_password_reset_requested.
     *
     * @return integer
     */
    public function getTimePasswordResetRequested()
    {
        return $this->time_password_reset_requested;
    }

    public function __sleep()
    {
        return array('id', 'email', 'password', 'salt', 'rights', 'creation_date', 'update_date', 'username', 'is_enabled', 'confirmation_token', 'time_password_reset_requested');
    }
}