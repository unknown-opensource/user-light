<?php
namespace Unknown\Bundle\UserLightBundle\Manager;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Unknown\Bundle\UserLightBundle\Entity\UserLightBaseInterface;

interface UserManagerInterface extends UserProviderInterface
{
    /**
     * Persist new password.
     *
     * @param UserLightBaseInterface $user User whose password to update.
     *
     */
    public function updatePassword(UserLightBaseInterface $user);

    /**
     * Updates given User instance in persistent storage.
     *
     * @param UserLightBaseInterface $user User entity.
     *
     */
    public function updateUser(UserLightBaseInterface $user);

    /**
     * Removes user from persistent storage.
     *
     * @param UserLightBaseInterface $user User entity.
     *
     * @return void
     */
    public function deleteUser(UserLightBaseInterface $user);
}
