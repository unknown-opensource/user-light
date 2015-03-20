<?php
namespace spec\Unknown\Bundle\UserLightBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnknownUserLightBundleSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_has_correct_type()
    {
        $this->shouldHaveType('Unknown\Bundle\UserLightBundle\UnknownUserLightBundle');
    }
}
