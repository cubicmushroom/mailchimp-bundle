<?php

namespace CubicMushroom\Symfony\MailchimpBundle\Service;

use CubicMushroom\Symfony\MailchimpBundle\Exception\UnableToAddSubscriberException;
use CubicMushroom\Symfony\MailchimpBundle\ValueObject\Subscriber;
use Mailchimp\Mailchimp;

/**
 * Main service class for interacting with the API
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 *
 * @see     \spec\CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApiSpec for spec
 */
class MailchimpApi
{

    // BEGIN: Properties
    /**
     * @var Mailchimp
     */
    private $mc;

    // END: Properties


    // BEGIN: Constructor
    /**
     * MailchimpApi constructor.
     *
     * @param Mailchimp $mc
     */
    public function __construct(Mailchimp $mc)
    {
        $this->mc = $mc;
    }
    // END: Constructor


    // BEGIN: Public methods
    /**
     * @param Subscriber $subscriber
     * @param string     $listId
     *
     * @throws UnableToAddSubscriberException
     */
    public function addSubscriberToList(Subscriber $subscriber, $listId)
    {
        try {
            $getUri = sprintf("/lists/%s/members/%s", $listId, md5(strtolower($subscriber->getEmail()->toNative())));
            $this->mc->get($getUri);

            // User already exists, therefore don't do anything
            return;
        } catch (\Exception $e) {
        }

        try {
            $postURI = sprintf("/lists/%s/members", $listId);
            $this->mc->post($postURI, $subscriber->toArray());
        } catch (\Exception $e) {
            throw new UnableToAddSubscriberException(
                sprintf(
                    'Unable to add subscriber %s to the Mailchimp list (%s)',
                    $subscriber->getEmailString(),
                    $listId
                )
            );
        }
    }
    // END: Public methods
}
