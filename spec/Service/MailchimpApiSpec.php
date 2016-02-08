<?php

namespace spec\CubicMushroom\Symfony\MailchimpBundle\Service;

use CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApi;
use Mailchimp\Mailchimp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class MailchimpApiSpec
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 *
 * @see     \CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApi
 */
class MailchimpApiSpec extends ObjectBehavior
{
    /**
     * @see \CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApi::__construct()
     */
    function let(
        /** @noinspection PhpDocSignatureInspection */
        Mailchimp $mc
    ) {
        $this->beConstructedWith($mc);
    }


    function it_is_initializable()
    {
        $this->shouldHaveType(MailchimpApi::class);
    }
}
