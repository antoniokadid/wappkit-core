# WAPPKit Core

The core of Web Application Kit (WAPPKit)

Powers WAPPKit, a privately owned CMS.

*Project under development and may be subject to a lot of changes. Use at your own risk.*

[![CI](https://github.com/antoniokadid/wappkit-core/actions/workflows/ci.yml/badge.svg)](https://github.com/antoniokadid/wappkit-core/actions/workflows/ci.yml)

## Installation

composer require antoniokadid/wappkit-core:dev-main

## Requirements

* PHP 8

### VSCode Extensions

* [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
* [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug)
* [PHPUnit](https://marketplace.visualstudio.com/items?itemName=emallin.phpunit)
* [PHP Mess Detector](https://marketplace.visualstudio.com/items?itemName=ecodes.vscode-phpmd)
* [PHP Sniffer](https://marketplace.visualstudio.com/items?itemName=wongjn.php-sniffer)
* [php cs fixer](https://marketplace.visualstudio.com/items?itemName=junstyle.php-cs-fixer)
* [GitLens](https://marketplace.visualstudio.com/items?itemName=eamodio.gitlens)
* [Composer](https://marketplace.visualstudio.com/items?itemName=ikappas.composer)
* [Version Lens](https://marketplace.visualstudio.com/items?itemName=pflannery.vscode-versionlens)
* [Markdown All in One](https://marketplace.visualstudio.com/items?itemName=yzhang.markdown-all-in-one)
* [markdownlint](https://marketplace.visualstudio.com/items?itemName=DavidAnson.vscode-markdownlint)
* [Bracket Pair Colorizer](https://marketplace.visualstudio.com/items?itemName=CoenraadS.bracket-pair-colorizer)

### Debug (using PHP Debug extension)

To be able to debug PHP you need to install the XDebug extension for your PHP installation and make sure you have the following added to *php.ini*

```ini
zend_extension="xdebug.so"

# Configuration for XDebug with version up to 2.9.8
xdebug.default_enable=1
xdebug.remote_enable=1
xdebug.remote_port=9000      # Change port accordingly.
xdebug.remote_handler=dbgp
xdebug.remote_connect_back=0
xdebug.remote_host=127.0.0.1 # Change IP accordingly.
xdebug.remote_autostart=1
xdebug.remote_mode=req
xdebug.idekey=VSCODE
```

Then in *.vscode* folder add a *launch.json* file with the following configuration making sure that the port number matches the one in *php.ini*

```json
{
    "name": "XDebug",
    "type": "php",
    "request": "launch",
    "port": 9000,
    "ignore": [
        "**/vendor/**/*.php"
    ]
}
```

## LICENSE

MIT license.
