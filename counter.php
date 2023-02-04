<?php
/**
 * @package Word Counter
 * @version 1.7.2
 */
/*
	Plugin Name: word counter
	Plugin URI: http://example.com
	Description: This plugin is used for matching excel given word with target page word and show how many times correspondence word
	exist in that page content
	Author: Hridoy Rehemen
	Version: 1.0.0
	Author URI: http://example.com
*/

class App {
	
	// plugin versions
	protected const PLUGIN_VERSIONS   = '1.0.0';

	// to be enqueued style for this plugin
	protected const TO_ENQUEUE_STYLES = [
		'filter' => 'assets/css/filter.css',
	];

	// to be enqueued scripts for this plugin
	protected const TO_ENQUEUE_SCRIPTS = [
		'filter' => 'assets/js/filter.js',
	];


	// application instance
	protected App $app;

	public function __construct(  protected ?string $base_dir = null ) 
	{
		if ( is_null ( $base_dir ) ) {
			$this->base_dir = plugin_dir_path(__FILE__);
		}

		$this->boot();
	}

	/**
	 * boot the whole application
	 * @param null no params
	 * @return void nothing to return
	 */
	private function boot ( ) : void
	{
		// save application instance
		$this->app = $this;

		register_activation_hook(__FILE__,[$this,'activate']);
		register_deactivation_hook(__FILE__,[$this,'deactivated']);
		add_action('wp_enqueue_scripts',[ $this,'enqueue' ]);
	}

	/**
	 * when plugin active
	 * @param null no params
	 * @return void nothing to return
	 */
	public function activate ( ) : void  
	{
		flush_rewrite_rules( );
	}
	
	/**
	 * when plugin deactivate
	 * @param null no params
	 * @return void nothing to return
	 */
	public function deactivated ( ) : void  
	{
		flush_rewrite_rules( );
	}
	
	/**
	 * Enqueue styles and scripts
	 * @param null no params
	 * @return void nothing to return
	 */
	public function enqueue ( ) : void  
	{	
		$styles  = self::TO_ENQUEUE_STYLES;
		$scripts = self::TO_ENQUEUE_SCRIPTS; 
		
		array_walk ( $styles , function ( $path,$name ) {
			wp_enqueue_style($name,plugins_url( $path,__FILE__),[],self::PLUGIN_VERSIONS);
		});

		array_walk ( $scripts , function ( $path,$name ) {
			wp_enqueue_script($name,plugins_url( $path,__FILE__),[],self::PLUGIN_VERSIONS,true);
		});
	}
	
}

$app = new App();