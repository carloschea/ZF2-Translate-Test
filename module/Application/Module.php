<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);


       //$locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        //     
        //or 
        //
	//$locale = 'zh_TW';
	//$locale = 'pt_BR';
        //$locale = 'en_US';
	//$locale = 'zh_TW';
        
        
        $locale = 'zh_TW';
		
		
		
        $fallbackLocale = 'en_US';

        $sm = $e->getApplication()->getServiceManager();
        $sm->get('translator')
                ->setLocale($locale)
                ->setFallbackLocale($fallbackLocale);
        

        $type = 'phpArray';
        $pattern = './vendor/zendframework/zendframework/resources/languages/%s/Zend_Validate.php';
        $textDomain = 'default';

        $translator = $e->getApplication()->getServiceManager()->get('translator');

        if (file_exists(sprintf($pattern, $locale))) {
            $translator->addTranslationFile($type, sprintf($pattern, $locale), $textDomain);
        } else if (file_exists(sprintf($pattern, preg_replace('/_(.*)/', '', $locale)))) {
            $translator->addTranslationFile($type, sprintf($pattern, preg_replace('/_(.*)/', '', $locale)), $textDomain);
        } else {
            $pattern = sprintf($pattern, preg_replace('/_(.*)/', '', $fallbackLocale));
            $translator->addTranslationFile($type, $pattern, $textDomain);
        }
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
        
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
