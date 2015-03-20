<?php
namespace spec\Unknown\Bundle\UserLightBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Unknown\Bundle\UserLightBundle\Entity\UserLightBaseInterface;

class UserManagerSpec extends ObjectBehavior
{
    public function let(
        EntityManager $entityManager,
        EncoderFactoryInterface $encoderFactory,
        EntityRepository $repository,
        PasswordEncoderInterface $encoder
    ) {
        $this->beConstructedWith($entityManager, $encoderFactory, 'UserEntity');
        $entityManager->getRepository('UserEntity')->willReturn($repository);
        $encoderFactory->getEncoder(Argument::any())->willReturn($encoder);
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Unknown\Bundle\UserLightBundle\Manager\UserManagerInterface');
    }

    public function it_refreshes_existing_user(
        UserInterface $user1,
        UserLightBaseInterface $user2,
        EntityRepository $repository
    ) {
        $user1->getUsername()->willReturn('username1');
        $user2->getActive()->willReturn(true);
        $repository->findBy(['username' => 'username1'])->willReturn([$user2]);
        $this->refreshUser($user1)->shouldReturn($user2);
    }

    public function it_loads_existing_user(
        UserLightBaseInterface $user,
        EntityRepository $repository
    ) {
        $user->getActive()->willReturn(true);
        $repository->findBy(['username' => 'username1'])->willReturn([$user]);
        $this->loadUserByUsername('username1')->shouldReturn($user);
    }

    public function it_throws_on_inactive_user(
        UserLightBaseInterface $user,
        EntityRepository $repository
    ) {
        $exception = 'Symfony\Component\Security\Core\Exception\UsernameNotFoundException';

        $user->getActive()->willReturn(false);
        $repository->findBy(['username' => 'username1'])->willReturn([$user]);
        $this->shouldThrow($exception)->duringLoadUserByUsername('username1');
    }

    public function it_throws_on_unknown_user(EntityRepository $repository)
    {
        $exception = 'Symfony\Component\Security\Core\Exception\UsernameNotFoundException';

        $repository->findBy(['username' => 'username1'])->willReturn([]);
        $this->shouldThrow($exception)->duringLoadUserByUsername('username1');
    }

    public function it_sets_new_password(
        UserLightBaseInterface $user,
        PasswordEncoderInterface $encoder
    ) {
        $user->getPlainPassword()->willReturn('new_pass');
        $user->getSalt()->willReturn('salt1');
        $encoder->encodePassword('new_pass', 'salt1')->willReturn('enc_pass');

        $user->setPassword('enc_pass')->shouldBeCalled();
        $user->eraseCredentials()->shouldBeCalled();

        $this->updatePassword($user);
    }

    public function it_ignores_empty_password(UserLightBaseInterface $user)
    {
        $user->getPlainPassword()->willReturn('');

        $user->setPassword(Argument::any())->shouldNotBeCalled();
        $user->eraseCredentials()->shouldNotBeCalled();

        $this->updatePassword($user);
    }

    public function it_supports_entity_class()
    {
        $this->supportsClass('UserEntity')->shouldBe(true);

        $this->supportsClass('')->shouldBe(false);
        $this->supportsClass(null)->shouldBe(false);
        $this->supportsClass('UserEntity2')->shouldBe(false);
    }

    public function it_updates_user(UserLightBaseInterface $user, EntityManager $entityManager)
    {
        $entityManager->persist($user)->shouldBeCalled();
        $entityManager->flush($user)->shouldBeCalled();

        $this->updateUser($user);
    }

    public function it_deletes_user(UserLightBaseInterface $user, EntityManager $entityManager)
    {
        $entityManager->remove($user)->shouldBeCalled();
        $entityManager->flush($user)->shouldBeCalled();

        $this->deleteUser($user);
    }
}
