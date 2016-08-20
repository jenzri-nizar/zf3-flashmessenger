<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zf3\Flashmessenger;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
return array(
    'router' => array(
        'routes' => array(
           
            'FlashMessenger' => array(
                'type'    => Segment::class,
                'options' => array(
                    'route'    => '/flashmessenger[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => Controller\FlashmessengerController::class,
                        'action'        => 'index',
                    ),
                ),
              
            ),
        ),
    ),

    'controllers' => array(
        'factories' => [
            Controller\FlashmessengerController::class => InvokableFactory::class,
        ],
    ),
    'view_manager' => array(
        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
