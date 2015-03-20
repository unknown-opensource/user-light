<?php
namespace Unknown\Bundle\UserLightBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Unknown\Bundle\UserLightBundle\Entity\UserLightBase;
use Unknown\Bundle\UserLightBundle\Entity\UserLightBaseInterface;

class UserManager implements UserManagerInterface
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $userClass;

    /**
     * Constructor.
     * @param EntityManager           $entityManager
     * @param EncoderFactoryInterface $encoderFactory
     * @param string                  $userClass
     */
    public function __construct(EntityManager $entityManager, EncoderFactoryInterface $encoderFactory, $userClass)
    {
        $this->em             = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->userClass      = $userClass;
    }

    /**
     * @inheritdoc
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username)
    {
        $users = $this->em->getRepository($this->userClass)->findBy(['username' => $username]);
        /* @var $users UserLightBase[] */
        if (count($users) == 0 || !$users[0]->getActive()) {
            throw new UsernameNotFoundException(sprintf('No user with name "%s" was found.', $username));
        }
        return $users[0];
    }

    /**
     * @inheritdoc
     */
    public function updatePassword(UserLightBaseInterface $user)
    {
        if ($password = $user->getPlainPassword()) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }

    /**
     * @inheritdoc
     */
    public function supportsClass($class)
    {
        return ($class == $this->userClass);
    }

    /**
     * @inheritdoc
     */
    public function updateUser(UserLightBaseInterface $user)
    {
        if ($user->getPlainPassword() != '') {
            $this->updatePassword($user);
        }
        $this->em->persist($user);
        $this->em->flush($user);
    }

    /**
     * @inheritdoc
     */
    public function deleteUser(UserLightBaseInterface $user)
    {
        $this->em->remove($user);
        $this->em->flush($user);
    }
}
