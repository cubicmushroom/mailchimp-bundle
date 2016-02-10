<?php

namespace CubicMushroom\Symfony\MailchimpBundle\Service;

use CubicMushroom\Symfony\MailchimpBundle\Exception\Lists\ListInfoNotAvailableException;
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
    const LIST_INFO_SUBSCRIBE_URL_LONG = 'subscribe_url_long';

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


    /**
     * @param string $mailchimpListId
     *
     * @return string
     *
     * @throws ListInfoNotAvailableException
     *
     * @todo Write spec for this method
     *
     */
    public function getListSubscribeUri($mailchimpListId)
    {
        $listInfo = $this->getListInfo($mailchimpListId);

        $subscribeUrlKey = self::LIST_INFO_SUBSCRIBE_URL_LONG;

        if (!$listInfo->has($subscribeUrlKey)) {
            throw ListInfoNotAvailableException::create($subscribeUrlKey);
        }

        return $listInfo->get($subscribeUrlKey);
    }


    /**
     * @param string $mailchimpListId
     *
     * @return string
     *
     * @throws ListInfoNotAvailableException
     *
     * @todo Write spec for this method
     */
    public function getListUnsubscribeUri($mailchimpListId)
    {
        $subscribeUri = $this->getListSubscribeUri($mailchimpListId);

        $unsubscribeUri = str_replace('/subscribe?', '/unsubscribe?', $subscribeUri);

        return $unsubscribeUri;
    }
    // END: Public methods


    // BEGIN: Protected methods
    /**
     * @param $mailchimpListId
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getListInfo($mailchimpListId)
    {
        return $this->mc->get("/lists/{$mailchimpListId}");
    }
    // END: Protected methods
}
