# bleuren/agent

The `bleuren/agent` package is an enhanced user agent parser for Laravel applications. It provides functionality to detect various types of devices, browsers, operating systems, and crawlers, which enables developers to tailor user experiences based on the detected environment.

## Features

- **Device Detection**: Identify whether the user's device is a desktop, tablet, or mobile.
- **Browser Detection**: Detect and return the browser type being used.
- **Platform Detection**: Determine the operating system of the device.
- **Crawler Detection**: Identify bots and crawlers, distinguishing them from regular user traffic.
- **HTTP Headers Analysis**: Manage and analyze HTTP headers related to mobile devices and user-agents.

## Installation

To install the package, run the following command in your Laravel project:

```bash
composer require bleuren/agent
```

## Usage

### Device Detection

```php
$isDesktop = Agent::isDesktop();
$isMobile = Agent::isMobile();
$isTablet = Agent::isTablet();
```

### Browser and Platform Detection

```php
$browser = Agent::browser();
$platform = Agent::platform();
```

### Crawler Detection

```php
// Check if the current user agent is a robot.
$isRobot = Agent::isRobot();

// Alternatively, the same result can be achieved with isCrawler()
$isCrawler = Agent::isCrawler();

// You can also check for a specific crawler by passing a user agent string.
$isSpecificCrawler = Agent::isCrawler('specific-user-agent-string');

// Retrieve the name of the detected robot/crawler, if any.
$robot = Agent::robot();
```

### HTTP Headers and User-Agent Management

```php
Agent::setHttpHeaders(['User-Agent' => $_SERVER['HTTP_USER_AGENT']]);
$httpHeaders = Agent::getHttpHeaders();
$mobileHeaders = Agent::getMobileHeaders();
$cloudFrontHeaders = Agent::getCloudFrontHttpHeaders();

Agent::setUserAgent('specific-user-agent-string');
$userAgent = Agent::getUserAgent();
```

## Examples

```php
// Determine the device type: 'desktop', 'mobile', 'tablet', or 'robot'.
$deviceType = Agent::deviceType();

// Browser and platform detection
$browser = Agent::browser();
$platform = Agent::platform();

// Detailed robot detection
if (Agent::isRobot()) {
    $robot = Agent::robot();
}
```
