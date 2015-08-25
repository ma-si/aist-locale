<?php

/**
 * AistLocale (http://mateuszsitek.com/projects/aist-locale)
 *
 * @link      http://github.com/ma-si/aist-locale for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Aist Internet Technologies (http://aist.pl) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace AistLocale;

use Locale;
use Zend\Mvc\MvcEvent;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\AbstractValidator;
use Zend\Filter\Word\DashToUnderscore;

class Module
{
    /**
     * On Bootstrap
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $serviceManager = $app->getServiceManager();
        $request = $app->getRequest();
        $translator = $serviceManager->get('translator');
        $config = $serviceManager->get('config');
        $settings = $config['translator'];
        $default_locale = $settings['locale'];
        $locale = $default_locale;
        $check_agent = $settings['check_agent'];
        $plural_rule = $settings['plural_rule'];
        $supported_locale = $settings['supported'];

        /**
         * Find witch locale to use.
         * Get default & supported languages from config.
         * Match against user agent prioritized languages.
         */
        if (!($request instanceof ConsoleRequest) && $check_agent) {
            $headers = $request->getHeaders();
            if ($headers->has('Accept-Language')) {
                $locales = $headers->get('Accept-Language')->getPrioritized();

                // Loop through all locales, highest priority first
                foreach ($locales as $localeElement) {
                    $filter = new DashToUnderscore();
                    if (!!($match = Locale::lookup($supported_locale, $localeElement->typeString))) {
                        // The locale is one of our supported_locale list
                        $locale = $filter->filter($match);
                        break;
                    }
                }
            }
        }

        // Set locale
        Locale::setDefault($locale);
        $translator->setLocale(Locale::getDefault());
        $translator->setFallbackLocale($default_locale);

        // Set plural view helper
        $this->setPluralViewHelper($serviceManager, $plural_rule);

        // Set default translator for validator messages
        AbstractValidator::setDefaultTranslator(new Translator($translator));
    }

    /**
     * Set plural view helper
     *
     * @param $serviceManager
     * @param $pluralRule
     */
    private function setPluralViewHelper(ServiceLocatorInterface $serviceManager, $pluralRule)
    {
        $viewHelperManager = $serviceManager->get('ViewHelperManager');
        $pluralHelper = $viewHelperManager->get('Plural');
        $pluralHelper->setPluralRule($pluralRule);
    }

    /**
     * Get Config
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * An array for Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
