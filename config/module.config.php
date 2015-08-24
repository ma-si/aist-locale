<?php

/**
 * AistLocale (http://mateuszsitek.com/projects/aist-locale)
 *
 * @link      http://github.com/ma-si/aist-locale for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Aist Internet Technologies (http://aist.pl) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace AistLocale;

return [
    'controllers' => [
        'invokables' => [
            __NAMESPACE__ . '\Controller\Locale' => __NAMESPACE__ . '\Controller\LocaleController',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'Zend\I18n\Translator\TranslatorInterface' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ],
        'aliases' => [
            'translator' => 'Zend\I18n\Translator\TranslatorInterface',
        ],
    ],

    'diagnostics' => [
        __NAMESPACE__ => [
            'Check if intl is loaded' => ['ExtensionLoaded', 'intl'],
            'Check if language dir is writable' => [
                'DirWritable',
                [
                    __DIR__ . '/../language',
                ],
            ],
            'Check if language dir is readable' => [
                'DirReadable',
                [
                    __DIR__ . '/../language',
                ],
            ],
        ],
    ],
];
