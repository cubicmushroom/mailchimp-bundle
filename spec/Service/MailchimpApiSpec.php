<?php

namespace spec\CubicMushroom\Symfony\MailchimpBundle\Service;

use CubicMushroom\Symfony\MailchimpBundle\Exception\UnableToAddSubscriberException;
use CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApi;
use CubicMushroom\Symfony\MailchimpBundle\ValueObject\Subscriber;
use Illuminate\Support\Collection;
use Mailchimp\Mailchimp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ValueObjects\Web\EmailAddress;

/**
 * Class MailchimpApiSpec
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 *
 * @see     \CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApi
 */
class MailchimpApiSpec extends ObjectBehavior
{
    // BEGIN: Constants
    const MC_LIST = 123;

    const VALUE_EMAIL = 'toby@example.com';
    // END: Constants


    // BEGIN: PHPSpec setup & teardown
    /**
     * @see \CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApi::__construct()
     */
    function let(
        /** @noinspection PhpDocSignatureInspection */
        Mailchimp $mc
    ) {
        $this->beConstructedWith($mc);
    }
    // END: PHPSpec setup & teardown


    // BEGIN: Public methods
    function it_is_initializable()
    {
        $this->shouldHaveType(MailchimpApi::class);
    }


    /** @noinspection PhpMissingDocCommentInspection */
    function it_should_be_able_to_add_subscriber_to_list(
        /** @noinspection PhpDocSignatureInspection */
        Subscriber $subscriber,
        Mailchimp $mc,
        Collection $subsscribeResult
    ) {
        /** @var self|MailchimpApi $this */

        /** @noinspection PhpUndefinedMethodInspection */
        $subscriber->getEmail()->willReturn(new EmailAddress(self::VALUE_EMAIL));
        /** @noinspection PhpUndefinedMethodInspection */
        $subscriber->toArray()->willReturn(
            ['email_address' => self::VALUE_EMAIL, 'status' => Subscriber::STATUS_SUBSCRIBED]
        );

        /** @noinspection PhpUndefinedMethodInspection */
        $mc->get(sprintf('/lists/%s/members/%s', self::MC_LIST, md5(strtolower(self::VALUE_EMAIL))))
           ->willThrow(new \Exception());
        /** @noinspection PhpUndefinedMethodInspection */
        $mc
            ->post(
                sprintf(
                    '/lists/%s/members',
                    self::MC_LIST,
                    ['email_address' => self::VALUE_EMAIL, 'status' => Subscriber::STATUS_SUBSCRIBED]
                ),
                ['email_address' => self::VALUE_EMAIL, 'status' => Subscriber::STATUS_SUBSCRIBED]
            )
            ->shouldBeCalled()
            ->willReturn($subsscribeResult);

        $this->addSubscriberToList($subscriber, self::MC_LIST);
    }


    /** @noinspection PhpMissingDocCommentInspection */
    function it_should_throw_an_exception_when_unable_to_add_member_to_list(
        /** @noinspection PhpDocSignatureInspection */
        Subscriber $subscriber,
        Mailchimp $mc,
        Collection $subsscribeResult
    ) {
        /** @var self|MailchimpApi $this */

        /** @noinspection PhpUndefinedMethodInspection */
        $subscriber->getEmail()->willReturn(new EmailAddress(self::VALUE_EMAIL));
        /** @noinspection PhpUndefinedMethodInspection */
        $subscriber->getEmailString()->willReturn(self::VALUE_EMAIL);

        /** @noinspection PhpUndefinedMethodInspection */
        $mc->get(sprintf('/lists/%s/members/%s', self::MC_LIST, md5(strtolower(self::VALUE_EMAIL))))
           ->willThrow(new \Exception());
        /** @noinspection PhpUndefinedMethodInspection */
        $mc
            ->post(
                sprintf(
                    '/lists/%s/members',
                    self::MC_LIST,
                    ['email_address' => self::VALUE_EMAIL, 'status' => Subscriber::STATUS_SUBSCRIBED]
                )
            )
            ->willThrow(new \Exception());

        $this->shouldThrow(UnableToAddSubscriberException::class)
             ->during('addSubscriberToList', [$subscriber, self::MC_LIST]);
    }
    // END: Public methods
}
