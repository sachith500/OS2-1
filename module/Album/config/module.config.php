<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
            'Album\Controller\Business' => 'Album\Controller\BusinessController',
            'Album\Controller\Customer' => 'Album\Controller\CustomerController',
            'Album\Controller\Item' => 'Album\Controller\ItemController',
            'Album\Controller\Order' => 'Album\Controller\OrderController',
            'Album\Controller\Chart'=>'Album\Controller\ChartController',
            'Album\Controller\Psr'=>'Album\Controller\PsrController',

        ),
    ),

    'router' => array(
        'routes' => array(

            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
                    ),
                ),
            ),

            'business' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/business[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Business',
                        'action'     => 'index',
                    ),
                ),
            ),

            'customer' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/customer[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Customer',
                        'action'     => 'index',
                    ),
                ),
            ),

            'item' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/item[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Item',
                        'action'     => 'index',
                    ),
                ),
            ),

            'order' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/order[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Order',
                        'action'     => 'index',
                    ),
                ),
            ),

            'chart' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/chart[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Chart',
                        'action'     => 'index',
                    ),
                ),
            ),

            'psr' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/psr[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Psr',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
            'business' => __DIR__ . '/../view',
            'customer' => __DIR__ . '/../view',
            'item' => __DIR__ . '/../view',
            'order' => __DIR__ . '/../view',
            'psr' => __DIR__ . '/../view',
        ),
    ),
);