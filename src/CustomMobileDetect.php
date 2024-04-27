<?php

declare(strict_types=1);

namespace Bleuren\Agent;

use Detection\MobileDetect;

class CustomMobileDetect extends MobileDetect
{
    public function __construct()
    {
        parent::__construct();
        self::setBrowsers();
        self::setOperationSystems();
        self::setProperties();
    }

    protected static function setBrowsers()
    {
        self::appendOrNew('browsers', [
            'Edge' => 'Edg|Edge/[.0-9]+',
            'Chrome' => 'Chrome',
            'Opera' => 'OPR',
            'Coc Coc' => 'coc_coc_browser',
            'IE' => 'MSIE|IEMobile|MSIEMobile|Trident/[.0-9]+',
            'WeChat' => 'MicroMessenger',
            'Mozilla' => 'Mozilla',
            'Netscape' => 'Netscape',
            'Safari' => 'Safari',
            'Firefox' => 'Firefox',
            'Vivaldi' => 'Vivaldi',
            'UCBrowser' => 'UCBrowser',
            'Opera Mini' => 'Opera Mini',
        ]);

        $chrome = static::$browsers['Chrome'];
        unset(static::$browsers['Chrome']);
        static::$browsers['Chrome'] = $chrome;
    }

    protected static function setOperationSystems()
    {
        self::appendOrNew('operatingSystems', [
            'Windows' => 'Windows',
            'Windows NT' => 'Windows NT',
            'OS X' => 'Mac OS X',
            'Debian' => 'Debian',
            'Ubuntu' => 'Ubuntu',
            'Macintosh' => 'PPC',
            'OpenBSD' => 'OpenBSD',
            'Linux' => 'Linux',
            'ChromeOS' => 'CrOS',
        ]);
    }

    protected static function setProperties()
    {
        static::$properties['Windows'] = 'Windows NT [VER]';
        static::$properties['Windows NT'] = 'Windows NT [VER]';
        static::$properties['OS X'] = 'OS X [VER]';
        static::$properties['BlackBerryOS'] = ['BlackBerry[\w]+/[VER]', 'BlackBerry.*Version/[VER]', 'Version/[VER]'];
        static::$properties['AndroidOS'] = 'Android [VER]';
        static::$properties['ChromeOS'] = 'CrOS x86_64 [VER]';
        static::$properties['Opera Mini'] = 'Opera Mini/[VER]';
        static::$properties['Opera'] = [' OPR/[VER]', 'Opera Mini/[VER]', 'Version/[VER]', 'Opera [VER]'];
        static::$properties['Netscape'] = 'Netscape/[VER]';
        static::$properties['Mozilla'] = 'rv:[VER]';
        static::$properties['IE'] = ['IEMobile/[VER];', 'IEMobile [VER]', 'MSIE [VER];', 'rv:[VER]'];
        static::$properties['Edge'] = ['Edge/[VER]', 'Edg/[VER]'];
        static::$properties['Vivaldi'] = 'Vivaldi/[VER]';
        static::$properties['Coc Coc'] = 'coc_coc_browser/[VER]';
    }

    private static function appendOrNew($arrayName, $newElements)
    {
        foreach ($newElements as $key => $value) {
            if (isset(static::${$arrayName}[$key])) {
                static::${$arrayName}[$key] .= '|'.$value;
            } else {
                static::${$arrayName}[$key] = $value;
            }
        }
    }
}
