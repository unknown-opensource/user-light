<?php
namespace spec\Unknown\Bundle\UserLightBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserLightBaseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Unknown\Bundle\UserLightBundle\Entity\UserLightBaseInterface');
    }

    public function it_stores_username()
    {
        $this->getUsername()->shouldBe(null);
        $this->setUsername('username1');
        $this->getUsername()->shouldBe('username1');
    }

    public function it_stores_password()
    {
        $this->getPassword()->shouldBe(null);
        $this->setPassword('password1');
        $this->getPassword()->shouldBe('password1');
    }

    public function it_has_initial_salt()
    {
        $this->getSalt()->shouldNotBeLike(null);
    }

    public function it_stores_salt()
    {
        $this->setSalt('salt1');
        $this->getSalt()->shouldBe('salt1');
    }

    public function it_stores_activeness()
    {
        $this->getActive()->shouldBe(true);
        $this->setActive(false);
        $this->getActive()->shouldBe(false);
    }

    public function it_stores_plain_password()
    {
        $this->getPlainPassword()->shouldBe(null);
        $this->setPlainPassword('plain_pass');
        $this->getPlainPassword()->shouldBe('plain_pass');
    }
}
