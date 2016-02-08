<?php

namespace CubicMushroom\Symfony\MailchimpBundle\Service;

use Mailchimp\Mailchimp;

/**
 * Main service class for interacting with the API
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 *
 * @see \spec\CubicMushroom\Symfony\MailchimpBundle\Service\MailchimpApiSpec for spec
 */
class MailchimpApi
{
    /**
     * @var Mailchimp
     */
    private $mc;


    public function __construct(Mailchimp $mc)
    {
        $this->mc = $mc;
    }
}
