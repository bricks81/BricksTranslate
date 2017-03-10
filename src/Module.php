<?php

/**
 * Bricks Framework & Bricks CMS
 * http://bricks-cms.org
 *
 * The MIT License (MIT)
 * Copyright (c) 2015 bricks-cms.org
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Bricks\Translate;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, BootstrapListenerInterface
{

    const VERSION = '0.1.1';

    public function getConfig(){
        return array_replace_recursive(
            require(__DIR__.'/../config/module.config.php'),
            require(__DIR__.'/../config/bricks.config.php')
        );
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__
                ]
            ]
        ];
    }

    public function onBootstrap(EventInterface $e){
        $sm = $e->getApplication()->getServiceManager();
        $loader = $sm->get('Bricks\Loader\Loader');
        $config = $loader->singleton('Bricks\Config\Config');
        $router = $loader->singleton('router');
        $backendPath = $config->get('backendPath');
        $translator = $loader->singleton('translator');
        // i don't know why i have to declare text domain twice =/
        $routes = array_merge(array('backend'=>$backendPath),$translator->getAllMessages('routes')->getArrayCopy());
        $translator->addMessages($routes,'routes');
        $router->setTranslator($translator);
        $router->setTranslatorTextDomain('routes');
    }

}

