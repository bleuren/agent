<?php

declare(strict_types=1);

namespace Bleuren\Agent;

use Exception;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class Agent
{
    protected $desktopBrowsers = [
        'Edge' => 'Edg|Edge[.0-9]+',
        'Chrome' => 'Chrome',
        'Opera' => 'OPR',
        'Coc Coc' => 'coc_coc_browser',
        'IE' => 'MSIE|IEMobile|MSIEMobile|Trident[.0-9]+',
        'WeChat' => 'MicroMessenger',
        'Mozilla' => 'Mozilla',
        'Netscape' => 'Netscape',
        'Safari' => 'Safari',
        'Firefox' => 'Firefox',
        'Vivaldi' => 'Vivaldi',
        'UCBrowser' => 'UCBrowser',
        'Opera Mini' => 'Opera Mini',
    ];

    protected $desktopOperatingSystems = [
        'Windows' => 'Windows',
        'Windows NT' => 'Windows NT',
        'OS X' => 'Mac OS X',
        'Debian' => 'Debian',
        'Ubuntu' => 'Ubuntu',
        'Macintosh' => 'PPC',
        'OpenBSD' => 'OpenBSD',
        'Linux' => 'Linux',
        'ChromeOS' => 'CrOS',
    ];

    public function __construct(
        protected CustomMobileDetect $detector,
        protected CrawlerDetect $crawlerDetector,
    ) {
    }

    public function isDesktop()
    {
        return ! $this->detector->isMobile() && ! $this->detector->isTablet();
    }

    public function isRobot()
    {
        return $this->crawlerDetector->isCrawler();
    }

    public function deviceType()
    {
        if ($this->isDesktop()) {
            return 'desktop';
        }
        if ($this->isMobile()) {
            return 'mobile';
        }
        if ($this->isTablet()) {
            return 'tablet';
        }
        if ($this->isRobot()) {
            return 'robot';
        }

        return 'other';
    }

    public function browser()
    {
        $mobileBrowsers = $this->detector->getBrowsers();
        $desktopBrowsers = $this->desktopBrowsers;
        foreach ($mobileBrowsers as $browserName => $browserRegex) {
            if ($this->detector->is($browserName)) {
                return $browserName;
            }
        }
        foreach ($desktopBrowsers as $browserName => $browserRegex) {
            if (preg_match("/{$browserRegex}/i", $this->detector->getUserAgent())) {
                return $browserName;
            }
        }

        return 'Unknown Browser';
    }

    public function platform()
    {
        $mobileOperatingSystems = $this->detector->getOperatingSystems();
        $desktopOperatingSystems = $this->desktopOperatingSystems;

        foreach ($mobileOperatingSystems as $platformName => $platformRegex) {
            if ($this->detector->is($platformName)) {
                return $platformName;
            }
        }

        foreach ($desktopOperatingSystems as $platformName => $platformRegex) {
            if (preg_match("/{$platformRegex}/i", $this->detector->getUserAgent())) {
                return $platformName;
            }
        }

        return 'Unknown Platform';
    }

    public function robot()
    {
        return $this->crawlerDetector->getMatches();
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this->detector, $method)) {
            return $this->detector->$method(...$arguments);
        } elseif (method_exists($this->crawlerDetector, $method)) {
            return $this->crawlerDetector->$method(...$arguments);
        }

        throw new Exception("Method {$method} does not exist on any of the detectors");
    }
}
