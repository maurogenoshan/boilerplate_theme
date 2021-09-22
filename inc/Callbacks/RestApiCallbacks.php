<?php 
namespace App\Callbacks;

class RestApiCallbacks
{
    /**
     * Chequea si existe un usuario en Wordpress registrado
     *
     * @param $request
     *
     * @return bool
     */
    public function checkUserRegistered( $request )
    {
        return wp_send_json_success( array( 
            'name' => 'Andrew', 
            'call' => 'From some API/trigger', 
            'variable' => 'Hola',
        ), 200 );
    }
       
       
}