<?php

namespace App\Custom;


use App\Callbacks\RestApiCallbacks;

class RestApi
{
    

    private static $prefix,$get,$post,$delete;
    private $routes,$callbacks;

    /**
     * Ejecuta la aplicacion
     */
    public function register()
    {

        self::$prefix = '/webapi/';
        self::$get = \WP_REST_Server::READABLE;
        self::$post = \WP_REST_Server::EDITABLE;
        self::$delete = \WP_REST_SERVER::DELETABLE;
        $this->callbacks = new RestApiCallbacks();

		add_action( 'rest_api_init', function () {
			$this->loadRoutes();
            $this->setRoutes();
		} );
    }
    /**
     * Carga todos los endpoints en el $routes
     * @return void
     */
    public function loadRoutes(){
        $this->routes = [
            [
                'name' => 'userIsRegistered',
                'methods' => self::$get,
                'callback' => array($this->callbacks , 'checkUserRegistered')
            ]
        ];
    }
    /**
     * Recorre las rutas y las registra
     * @return void
     */
    public function setRoutes()
    {
        foreach ($this->routes as $route) {
            register_rest_route( self::$prefix, $route['name'], array(
                'methods' => $route['methods'],
                'callback' => $route['callback'],
            ) );
        }
       
    }

}





