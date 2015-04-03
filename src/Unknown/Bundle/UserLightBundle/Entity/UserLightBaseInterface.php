<?php
namespace Unknown\Bundle\UserLightBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserLightBaseInterface extends UserInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set username.
     *
     * @param string $username Username used in authentication.
     *
     * @return UserLightBase
     */
    public function setUsername($username);

    /**
     * Set password.
     *
     * @param string $password Password used in authentication.
     *
     * @return UserLightBase
     */
    public function setPassword($password);

    /**
     * Set salt used in password hashing.
     *
     * @param string $salt Salt.
     *
     * @return UserLightBase
     */
    public function setSalt($salt);

    /**
     * Set activeness.
     *
     * @param boolean $active True, if active.
     *
     * @return UserLightBase
     */
    public function setActive($active);

    /**
     * Get activeness.
     *
     * @return boolean True, if active.
     */
    public function getActive();

    /**
     * Plain password used for hashing (not persisted).
     *
     * @param string $password Plain password.
     *
     * @return UserLightBase
     */
    public function setPlainPassword($password);

    /**
     * Returns plain password for hashing (not persisted).
     *
     * @return string
     */
    public function getPlainPassword();
}
