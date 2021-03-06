<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Router::scope('/', function ($routes) {
    $routes->extensions(['json']);
    
    $routes->resources('Infos', [
        'map' => [
            'getMany' => [
                'action' => 'getMany',
                'method' => 'POST'
            ],
            'indexAdmin' => [
                'action' => 'indexAdmin',
                'method' => 'POST'
            ],
            'previewImagen' => [
                'action' => 'previewImagen',
                'method' => 'POST'
            ],
            'previewVideo' => [
                'action' => 'previewVideo',
                'method' => 'POST'
            ],
            'send' => [
                'action' => 'send',
                'method' => 'POST'
            ],
            'upload' => [
                'action' => 'upload',
                'method' => 'POST'
            ],
            'prueba' => [
                'action' => 'prueba',
                'method' => 'POST'
            ]
        ]
    ]);
    $routes->resources('links', [
        'map' => [
            'getHeader' => [
                'action' => 'getHeader',
                'method' => 'GET'
            ],
            'getFooter' => [
                'action' => 'getFooter',
                'method' => 'GET'
            ]
        ]
    ]);
    $routes->resources('Categories', [
        'map' => [
            'getAdmin' => [
                'action' => 'getAdmin',
                'method' => 'GET'
            ],
            'getTreeList/:spacer' => [
                'action' => 'getTreeList',
                'method' => 'GET'
            ],
            'previewPortada' => [
                'action' => 'previewPortada',
                'method' => 'POST'
            ],
            'search/:textSearch' => [
                'action' => 'search',
                'method' => 'GET'
            ]
        ]
    ]);
    $routes->resources('Productos', [
        'map' => [
            'previewImagen' => [
                'action' => 'previewImagen',
                'method' => 'POST'
            ],
            'previewFichaTecnica' => [
                'action' => 'previewFichaTecnica',
                'method' => 'POST'
            ],
            'getRelacionados/:producto_id' => [
                'action' => 'getRelacionados',
                'method' => 'GET'
            ],
            'search/:textSearch' => [
                'action' => 'search',
                'method' => 'GET'
            ]
        ]
    ]);
    $routes->resources('Roles', [
        'map' => [
            'getAdmin' => [
                'action' => 'getAdmin',
                'method' => 'GET'
            ]
        ]
    ]);
    $routes->resources('Users', [
        'map' => [
            'getAdmin' => [
                'action' => 'getAdmin',
                'method' => 'GET'
            ],
            'login' => [
                'action' => 'login',
                'method' => 'POST'
            ],
            'token' => [
                'action' => 'token',
                'method' => 'POST'
            ]
        ]
    ]);
    $routes->resources('Slides', [
        'map' => [
            'previewImagen' => [
                'action' => 'previewImagen',
                'method' => 'POST'
            ],
            'getAdmin' => [
                'action' => 'getAdmin',
                'method' => 'GET'
            ],
            'saveMany' => [
                'action' => 'saveMany',
                'method' => 'POST'
            ]
        ]
    ]);
    $routes->resources('Controllers');
    $routes->resources('links', [
        'map' => [
            'previewImagen' => [
                'action' => 'previewImagen',
                'method' => 'POST'
            ]
        ]
    ]);
});

Plugin::routes();
