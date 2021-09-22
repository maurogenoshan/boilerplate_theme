<?php

namespace App\Custom;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Admin
 * use it to write your admin related methods by tapping the settings api class.
 */
class Admin
{
	public function register(){
		add_action( 'carbon_fields_register_fields', array($this,'set_custom_fields') );
	}

	public function set_custom_fields() {
		$this->theme_options();
	}

	private function theme_options()
	{
		Container::make( 'theme_options', __( 'Sarandi' ) )
			->add_fields( array(
				Field::make( 'text', 'crb_text', 'Text Field' ),
			) );

		return $this;
	}
}