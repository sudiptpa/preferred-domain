<?php

namespace Sujip\PreferredDomain;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class Domain\PreferredDomain
 * @package Sujip
 */
class Domain
{
    const FORCE_HTTP = 'http://';
    const FORCE_HTTPS = 'https://';

    const FORCE_WWW = '//www.';
    const FORCE_NOWWW = '//';

    const REGEX_FILTER_WWW = "/(\/\/www\.|\/\/)/";
    const REGEX_FILTER_HTTPS = "/^(http:\/\/|https:\/\/)/";

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $translated;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Request $request, Repository $config = null)
    {
        $this->request = $request;
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function isEqual()
    {
        return $this->request->fullUrl() !== $this->getTranslated();
    }

    /**
     * Determines if the original url differs with translated.
     *
     * @return bool
     */
    public function diff()
    {
        $this->translated = $this->translate();

        return $this->isEqual();
    }

    /**
     * @return string
     */
    public function getTranslated()
    {
        if (!$this->translated) {
            $this->translated = $this->translate();
        }

        return $this->translated;
    }

    /**
     * @return mixed
     */
    public function translate()
    {
        $url = $this->request->fullUrl();

        $protocol = $this->getProtocol();

        $filtered = preg_replace(self::REGEX_FILTER_HTTPS, $protocol, $url);

        $preferred = $this->getPreferred();

        return preg_replace(self::REGEX_FILTER_WWW, $preferred, $filtered);
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->config->get('domain.protocol') ?? self::FORCE_HTTP;
    }

    /**
     * @return string
     */
    public function getPreferred()
    {
        return $this->config->get('domain.preferred') ?? self::FORCE_NOWWW;
    }
}
