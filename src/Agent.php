<?php

declare(strict_types=1);

namespace Bleuren\Agent;

use Exception;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class Agent
{
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
        foreach ($this->detector->getBrowsers() as $browserName => $browserRegex) {
            if ($this->detector->is($browserName)) {
                return $browserName;
            }
        }

        return 'Unknown Browser';
    }

    public function platform()
    {
        foreach ($this->detector->getOperatingSystems() as $platformName => $platformRegex) {
            if ($this->detector->is($platformName)) {
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
