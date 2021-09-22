<?php

namespace App\Setup;

/**
 * Enqueue.
 */



class Enqueue
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    private $admin_scripts, $public_scripts, $script_datas;
    public function register()
    {
        add_action('wp_enqueue_scripts', array(
            $this,
            'load_public_scripts'
        ));
        
        add_filter('script_loader_tag', array(
            $this,
            'add_type_module_attribute'
        ), 10, 3);

        add_action('admin_enqueue_scripts', array(
            $this,
            'load_admin_scripts'
        ));
    }

    public function load_admin_scripts()
    {
        global $pagenow;

        $this->admin_scripts = array(
            array(
                'name' => 'admin-css',
                'url' => mix('css/admin/admin.min.css'),
                'dependencies' => array(),
                'version' => $this->get_version(),
                'print' => 'all',
                'conditional' => true,
                'type' => 'style'
            )
        );

        $this->set_scripts($this->admin_scripts);
    }
    public function load_public_scripts()
    {
        global $pagenow;

        $this->public_scripts = array(
            //CSS
            array(
                'name' => 'register-css',
                'url' => mix('register/app.css'),
                'dependencies' => array(),
                'version' => $this->get_version(),
                'print' => 'all',
                'conditional' => true,
                'type' => 'style'
            ),
            //JS
            array(
                'name' => 'register-js',
                'url' => mix('register/app.js'),
                'dependencies' => array(),
                'version' => $this->get_version('1.1.1'),
                'conditional' => true,
                'type' => 'script',
                'in_footer' => true
            ),
         
        );

        $this->set_scripts($this->public_scripts);
        $this->load_jsdata();
        $this->config_scripts();
    }

    private function config_scripts()
    {
       
        // Deregister the built-in version of jQuery from WordPress
        if ( ! is_customize_preview() ) {
            wp_deregister_script( 'jquery' );
        }

        // Activate browser-sync on development environment
        if ( getenv( 'APP_ENV' ) === 'development' ) :
            wp_enqueue_script( '__bs_script__', getenv('WP_SITEURL') . ':3000/browser-sync/browser-sync-client.js', array(), null, true );
        endif;

        // Extra
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }   
        
    }
    private function set_scripts($scripts)
    {

        foreach ($scripts as $script) {

            if ($script['conditional']) {
                if ($script['type'] == 'style') {
                    wp_enqueue_style($script['name'], $script['url'], $script['dependencies'], $script['version'], $script['print']);
                } else {
                    wp_enqueue_script($script['name'], $script['url'], $script['dependencies'], $script['version'], $script['in_footer']);
                }
            }
        }
    }
    private function comment_js()
    {
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
    private function load_jsdata()
    {
        $this->script_datas = array(
            array(
                'data' => array(
                    'image_path' => get_template_directory_uri() . '/assets/images/'
                ),
                'script' => 'register-js',
                'key' => 'wpa_data'
            )


        );

        $this->set_jsdata();
    }

    private function set_jsdata()
    {

        foreach ($this->script_datas as $script_data) {
            wp_localize_script($script_data['script'], $script_data['key'], $script_data['data']);
        }
    }

    private function get_version($version = null)
    {
        $ver = ($version) ? $version : '1.0.0';
        return (getenv( 'APP_ENV' ) === 'development') ? time() : $ver;
    }

    public function add_type_module_attribute($tag, $handle, $src)
    {

        $keys = ['register-js'];

        if(in_array($handle,$keys)){
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }
}
