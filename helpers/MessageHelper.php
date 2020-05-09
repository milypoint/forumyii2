<?php

namespace app\helpers;

use app\helpers\clients\NotValidDataException;
use app\helpers\clients\UrlClientException;
use app\helpers\clients\UrlShortenerClient;

class MessageHelper
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $errors;

    public function __construct($message)
    {
        $this->message = $message;
        $this->errors = [];
    }

    /**
     * Replaces all urls
     * @return $this
     */
    public function urlsToShort()
    {
        $indx_offset = 0;
        $url_pattern = '~(?<url>https?:\/\/[\w/\-?=%.]+\.[\w/\-?=%.@]+(?<!\.))~';
        preg_match_all($url_pattern, $this->message, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches['url'] as $item) {
            $url = $item[0];
            $indx = $item[1];
            try {
                $short_url = UrlShortenerClient::action($url);
                $this->message =
                    substr($this->message, 0, $indx + $indx_offset) .
                    $short_url .
                    substr($this->message, $indx + $indx_offset + strlen($url));
                $indx_offset += strlen($short_url) - strlen($url);
            } catch (NotValidDataException $e) {
                $this->errors['422'] = 'Some of urls was not converted because they not valid.';
            } catch (UrlClientException $e) {
                $this->errors['500'] = 'Some of urls was not converted because of server issues.';
            }
        }
        return $this;
    }
}