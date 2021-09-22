<?php
namespace App\Api;
/**
 * Build Gutenberg Blocks
 *
 * @package genosha
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use App\Callbacks\GutenbergCallbacks;

/**
 * Gutenberg clase
 */
class Gutenberg
{
	/**
	 * Register default hooks and actions for WordPress
	 *
	 * @return WordPress add_action()
	 */

	private $styles,$callbacks;

	public function register() 
	{
		$this->callbacks = new GutenbergCallbacks();
		add_action( 'init', array( $this, 'gutenberg_config' ) );
		
		
		add_action( 'wp_enqueue_scripts', array($this,'load_styles') );

		$this->gutenberg_setup_block();

	}

	/**
	 * Custom Gutenberg settings
	 * @return
	 */
	public function gutenberg_config()
	{
		add_theme_support( 'gutenberg', array(
			// Theme supports responsive video embeds
			'responsive-embeds' => true,
            // Theme supports wide images, galleries and videos.
            'wide-images' => true,
		) );
		
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => __( 'White', 'awps' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => __( 'Black', 'awps' ),
				'slug'  => 'black',
				'color' => '#333333',
			),
			array(
				'name'  => __( 'Gold', 'awps' ),
				'slug'  => 'gold',
				'color' => '#FCBB6D',
			),
			array(
				'name'  => __( 'Pink', 'awps' ),
				'slug'  => 'pink',
				'color' => '#FF4444',
			),
			array(
				'name'  => __( 'Grey', 'awps' ),
				'slug'  => 'grey',
				'color' => '#b8c2cc',
			),
		) );

		
	}

	public function load_styles()
	{
		$this->styles = [
			[
				'key' => 'crb-my-shiny-gutenberg-block-stylesheet',
				'url' => get_stylesheet_directory_uri() . '/css/gutenberg/my-shiny-gutenberg-block.css',
				'type'=> 'front'
			],
			[
				'key' => 'crb-my-shiny-gutenberg-block-stylesheet-admin',
				'url' => get_stylesheet_directory_uri() . '/css/gutenberg/my-shiny-gutenberg-block.css',
				'type'=> 'admin'
			]
		];
		$this->register_styles();
	}

	private function register_styles()
	{
		foreach($this->styles as $style){
			wp_register_style(
				$style['key'],
				$style['url']
			);
		}
	}


	/**
	 * Enqueue scripts and styles of your Gutenberg blocks in the editor
	 * @return
	 */
	public function gutenberg_setup_block()
	{
		
		Block::make( __( 'My Shiny Gutenberg Block' ) )
		->add_fields( array(
			Field::make( 'text', 'heading', __( 'Block Heading' ) ),
			Field::make( 'image', 'image', __( 'Block Image' ) ),
			Field::make( 'rich_text', 'content', __( 'Block Content' ) ),
		) )->set_render_callback( array($this->callbacks,'block_default_callback') );


	}


}

