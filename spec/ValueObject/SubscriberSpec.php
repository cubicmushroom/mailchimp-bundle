<?php

namespace spec\CubicMushroom\Symfony\MailchimpBundle\ValueObject;

use CubicMushroom\Symfony\MailchimpBundle\ValueObject\Subscriber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ValueObjects\Web\EmailAddress;

/**
 * Spec file for Mailchimp subscriber value object
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 *
 * @see     \CubicMushroom\Symfony\MailchimpBundle\ValueObject\Subscriber
 */
class SubscriberSpec extends ObjectBehavior
{
    // BEGIN: Constants
    const MERGE_FIELD_FNAME = 'FNAME';

    const MERGE_FIELD_LNAME = 'LNAME';

    const STATUS_SUBSCRIBE = 'subscribed';

    const VALUE_EMAIL = 'me@test.com';

    const VALUE_NAME_FIRST = 'Toby';

    const VALUE_NAME_LAST = 'Griffiths';
    // END: Constants


    // BEGIN: Public methods
    function it_is_initializable()
    {
        $this->shouldHaveType(Subscriber::class);
    }


    function it_should_store_basic_details()
    {
        /** @var self|Subscriber $this */

        $email = new EmailAddress(self::VALUE_EMAIL);

        $this->beConstructedThrough('create', [$email, Subscriber::STATUS_SUBSCRIBED]);

        /** @noinspection PhpUndefinedMethodInspection */
        $this->getEmail()->shouldReturn($email);
        /** @noinspection PhpUndefinedMethodInspection */
        $this->getStatus()->shouldReturn(Subscriber::STATUS_SUBSCRIBED);
    }


    /** @noinspection PhpMissingDocCommentInspection */
    function it_should_support_merge_fields()
    {
        /** @var self|Subscriber $this */

        $this->addMergeField(self::MERGE_FIELD_FNAME, self::VALUE_NAME_FIRST);
        $this->addMergeField(self::MERGE_FIELD_LNAME, self::VALUE_NAME_LAST);

        /** @noinspection PhpUndefinedMethodInspection */
        $this->getMergeFields()->shouldReturn(
            [
                self::MERGE_FIELD_FNAME => self::VALUE_NAME_FIRST,
                self::MERGE_FIELD_LNAME => self::VALUE_NAME_LAST,
            ]
        );;
    }


    /** @noinspection PhpMissingDocCommentInspection */
    function it_exports_properties_as_an_array()
    {
        /** @var self|Subscriber $this */

        $email = new EmailAddress(self::VALUE_EMAIL);

        $this->beConstructedThrough('create', [$email, Subscriber::STATUS_SUBSCRIBED]);

        /** @noinspection PhpUndefinedMethodInspection */
        $this->toArray()->shouldReturn(
            [
                'email_address' => self::VALUE_EMAIL,
                'status'        => 'subscribed',
            ]
        );
    }
    // END: Public methods
}
