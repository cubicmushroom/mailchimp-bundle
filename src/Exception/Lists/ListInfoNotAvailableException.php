<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/02/2016
 * Time: 18:21
 */

namespace CubicMushroom\Symfony\MailchimpBundle\Exception\Lists;

use CubicMushroom\Symfony\MailchimpBundle\Exception\Exception;

/**
 * Exception thrown when requested information cannot be found
 *
 * @package CubicMushroom\Symfony\MailchimpBundle
 */
class ListInfoNotAvailableException extends Exception
{

    /**
     * @param string $informationKey
     *
     * @return ListInfoNotAvailableException
     */
    public static function create($informationKey)
    {
        /** @var ListInfoNotAvailableException $e */
        $e = new self();
        $e->setInformationKey($informationKey);

        return $e;
    }


    /**
     * @var string
     */
    protected $informationKey;


    /**
     * @return string
     */
    public function getInformationKey()
    {
        return $this->informationKey;
    }


    /**
     * @param string $informationKey
     *
     * @return ListInfoNotAvailableException
     */
    public function setInformationKey($informationKey)
    {
        $this->informationKey = $informationKey;

        return $this;
    }
}