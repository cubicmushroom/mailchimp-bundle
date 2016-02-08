<?php

namespace CubicMushroom\Symfony\MailchimpBundle\ValueObject;

use Doctrine\Common\Collections\ArrayCollection;
use ValueObjects\Web\EmailAddress;

/**
 * Value object to store Mailchimp subscriber details in
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 *
 * @see     \spec\CubicMushroom\Symfony\MailchimpBundle\ValueObject\SubscriberSpec for spec
 */
class Subscriber
{
    // BEGIN: Constants
    const STATUS_SUBSCRIBED = 'subscribed';
    // END: Constants


    // BEGIN: Static methods
    /**
     * Creates a new subscriber with basic details
     *
     * @param EmailAddress $email
     * @param string       $status
     *
     * @return Subscriber
     */
    public static function create(EmailAddress $email, $status)
    {
        /** @var Subscriber $subscriber */
        $subscriber = new static();

        $subscriber
            ->setEmail($email)
            ->setStatus($status);

        return $subscriber;
    }
    // END: Static methods

    // BEGIN: Properties
    /**
     * @var EmailAddress
     */
    protected $email;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var ArrayCollection
     */
    protected $mergeFields;

    // END: Properties

    // BEGIN: Constructor
    /**
     * Subscriber constructor.
     */
    public function __construct()
    {
        $this->mergeFields = new ArrayCollection();
    }
    // END: Constructor


    // BEGIN: Public methods
    /**
     * Adds items to the $mergeFields collection
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function addMergeField($name, $value)
    {
        $this->mergeFields->set($name, $value);

        return $this;
    }


    /**
     * @return EmailAddress
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @return ArrayCollection
     */
    public function getMergeFields()
    {
        return $this->mergeFields->toArray();
    }


    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * @param EmailAddress $email
     *
     * @return $this
     */
    public function setEmail(EmailAddress $email)
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Exports the properties of the subscriber as an array
     */
    public function toArray()
    {
        return [
            'email_address' => $this->getEmailString(),
            'status' => $this->status,
        ];
    }
    // END: Public methods

    /**
     * @return null|string
     */
    protected function getEmailString()
    {
        if (is_null($this->email)) {
            return null;
        }

        return $this->email->toNative();
    }
}
