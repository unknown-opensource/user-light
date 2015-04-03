<?php
namespace Unknown\Bundle\UserLightBundle\Entity;

class UserLightBase implements UserLightBaseInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $active = false;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
    }

    /**
     * @inheritdoc
     */
    public function getRoles()
    {
        return [
            'ROLE_USER',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritdoc
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @inheritdoc
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @inheritdoc
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
