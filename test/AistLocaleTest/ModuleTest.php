<?php

/**
 * AistAliceFixtures (http://mateuszsitek.com/projects/aist-alice-fixtures)
 *
 * @link      http://github.com/ma-si/aist-alice-fixtures for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Aist Internet Technologies (http://aist.pl) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace AistLocaleTest;

use AistLocale\Module;
use PHPUnit_Framework_TestCase;
use Zend\I18n\View\Helper\Plural;
use Zend\Mvc\Service\ViewHelperManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /** @var Module */
    private $module;

    public function setUp()
    {
        $this->module = new Module();
    }

    public function testGetConfig()
    {
        $config = $this->module->getConfig();

        $expectedServiceManagerConfig = [
            'factories' => [
                'Zend\I18n\Translator\TranslatorInterface' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            ],
            'aliases' => [
                'translator' => 'Zend\I18n\Translator\TranslatorInterface',
            ],
        ];

        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('service_manager', $config);
        $this->assertSame($expectedServiceManagerConfig, $config['service_manager']);
        $this->assertSame($config, unserialize(serialize($config)));
    }

    public function testSetPluralViewHelper()
    {
        $serviceManager = $this->getMock(ServiceLocatorInterface::class);
        $viewHelperManager = $this->getMock(ViewHelperManagerFactory::class);
        $pluralHelper = $this->getMockBuilder(Plural::class)->getMock();

        $serviceManager
            ->expects(self::once())
            ->method('get')
            ->with('ViewHelperManager')
            ->willReturn($viewHelperManager)
        ;

        $viewHelperManager
            ->expects(self::once())
            ->method('get')
            ->with('Plural')
            ->willReturn($pluralHelper)
        ;
    }

    public function testGetAutoloaderConfig()
    {
        $config = $this->module->getAutoloaderConfig();

        $expectedAutoloaderConfig = [
            'Zend\Loader\ClassMapAutoloader' => [
                realpath(__DIR__ . '/../..') . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    'AistLocale' => realpath(__DIR__ . '/../..') . '/src/' . 'AistLocale',
                ],
            ],
        ];

        $this->assertSame($expectedAutoloaderConfig, $config);
    }
}
