AistLocale
==========
A Zend Framework 2 Module.

[![Build Status](https://travis-ci.org/ma-si/aist-locale.svg?branch=master)](https://travis-ci.org/ma-si/aist-locale)
[![Total Downloads](https://poser.pugx.org/aist/aist-locale/downloads)](https://packagist.org/packages/aist/aist-locale)
[![Dependency Status](https://www.versioneye.com/user/projects/55db26bc8d9c4b00180005b5/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55db26bc8d9c4b00180005b5)
[![Code Climate](https://codeclimate.com/github/ma-si/aist-locale/badges/gpa.svg)](https://codeclimate.com/github/ma-si/aist-locale)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ma-si/aist-locale/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ma-si/aist-locale/?branch=master)
[![Stories in Ready](https://badge.waffle.io/ma-si/aist-locale.svg?label=ready&title=Ready)](http://waffle.io/ma-si/aist-locale)
[![License](https://poser.pugx.org/aist/aist-locale/license)](https://packagist.org/packages/aist/aist-locale)


## Installation
Installation of this module uses composer.
For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

1. Install the module via composer by running:
    ```sh
    php composer.phar require aist/aist-locale
    ```
   or download it directly from github and place it in your application's `module/` directory.
2. Add the `AistLocale` module to the module section of your `config/application.config.php`
3. Copy `aist-locale.global.php.dist` to `./config/autoload/aist-locale.global.php`

## Configuration
This module provides additional formatters extending faker. Here is a list of the bundled formatters.

* `locale` - Default language.
* `plural_rule` - Plural rules.
* `check_agent` - Match against user agent prioritized languages.
* `supported` - Supported languages.
* `translation_file_patterns` - 

        'locale' => 'pl_PL',
        'plural_rule' => 'nplurals=3; plural=(n==1 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2)',
        'check_agent' => false,
        'supported' => ['pl', 'pl-PL', 'en'],
        'translation_file_patterns' => [
            'gettext' => [
                'type' => 'gettext',
                'base_dir' => './data/language',
                'pattern' => '%s.mo',
            ],
        ],


## Checklist
- [ ] Add an automatic set `plural_rule` option depending on the selected `locale`
- [ ] Add config installation script
- [ ] Add setting up new parameters
- [ ] Add tests
- [ ] Refactor `Module.php`
