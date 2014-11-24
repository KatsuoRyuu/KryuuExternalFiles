<?php

namespace KryuuExternalFiles;

/**
 * @encoding UTF-8
 * @note *
 * @todo *
 * @package PackageName
 * @author Anders Blenstrup-Pedersen - KatsuoRyuu <anders-github@drake-development.org>
 * @license *
 * The Ryuu Technology License
 *
 * Copyright 2014 Ryuu Technology by 
 * KatsuoRyuu <anders-github@drake-development.org>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * Ryuu Technology shall be visible and readable to anyone using the software 
 * and shall be written in one of the following ways: Ryuu Technology 
 * or by using the company logo.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @version 20140730 
 * @link https://github.com/KatsuoRyuu/
 */

defined('__AUTHORIZE__') or define('__AUTHORIZE__','bjyauthorize');
defined('__THEME__') or define('__THEME__', '');

$mainRoute = 'kryuu-js-object-share';

$router     = include(__DIR__.'/router.config.php');
$service    = include(__DIR__.'/services.config.php');
$authorize  = include(__DIR__.'/authorize.config.php');
$navigation = include(__DIR__.'/navigation.config.php');

return array(
    __NAMESPACE__ => array(
        'rootFilePath' => getcwd() . '/../views/designs/' . __THEME__ . '/',
        'active' => TRUE,
    ),
    
    __AUTHORIZE__       => $authorize,
    
    'router'            => $router,
    
    'navigation'        => $navigation,
    
    'service_manager'   => $service,
    
    'controllers' => array(
        'invokables' => array(
            'KryuuExternalFiles\Files'   => 'KryuuExternalFiles\Controller\FilesController',
        ),
    ),
    
    'doctrine'=> array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
	
    'view_manager' => array(
        'template_path_stack' => array(
            'kryuuexternalfiles' => __DIR__ . '/../view',
        ),
    ),
    'module_layouts' => array(
        __NAMESPACE__ => __THEME__.'/layout/account',
    ),
);