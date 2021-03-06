<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://stefan-reichert.com
 * @since      1.0.0
 *
 * @package    sr_theme_functionality
 * @subpackage sr_theme_functionality/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    sr_theme_functionality
 * @subpackage sr_theme_functionality/public
 * @author     Stefan Reichert <reichert@qu-int.com>
 */
class sr_theme_functionality_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	
	/**
     * 12. Remove WP generated content from the head
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
	public function clean_up() {

//		remove_action( 'wp_head', 'feed_links_extra', 3 );																										// Category feeds
//		remove_action( 'wp_head', 'feed_links', 2 );																											// Post and comment feeds
		remove_action( 'wp_head', 'rsd_link' );																													// EditURI link
		remove_action( 'wp_head', 'wlwmanifest_link' );																											// Windows live writer
		remove_action( 'wp_head', 'index_rel_link' );																											// Index link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );																								// Previous link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );																								// Start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );																					// Links for adjacent posts
		remove_action( 'wp_head', 'wp_generator' );																												// WP version
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );																								// Shortlink
		remove_action( 'wp_head', 'rel_canonical');																												// Canonical links
		remove_action( 'set_comment_cookies', 'wp_set_comment_cookies');																						// Remove comment cookie
			    
	    add_filter( 'the_generator', '__return_false');																											// Remove WP version from RSS
		add_filter( 'style_loader_src',  array( $this, 'remove_wp_ver_css_js'), 9999 );																			// Remove WP version from css
		add_filter( 'script_loader_src',  array( $this, 'remove_wp_ver_css_js'), 9999 );																		// Remove WP version from scripts
	    add_filter( 'wp_head',  array( $this, 'remove_wp_widget_recent_comments_style'), 1 );																	// Remove pesky injected css for recent comments widget
	    add_action( 'wp_head',  array( $this, 'remove_recent_comments_style'), 1 );																				// Clean up comment styles in the head
		add_action( 'wp_head',  array( $this, 'remove_emojicons'), 1 );																							// Remove emojicons
		add_action( 'wp_footer', array( $this, 'remove_wp_embedded_script'), 10);																				// Removes wp-embedded.js

		// Remove some WPML stuff
		if ( function_exists('icl_object_id') ) {																												// WPML exists
			global $sitepress;

			remove_action( 'wp_head', array($sitepress, 'meta_generator_tag'));																					// WPML information 
			remove_action( 'wp_head', array($sitepress, 'head_langs'));																							// WPML information
		
			define( 'ICL_DONT_LOAD_NAVIGATION_CSS', true);																										// WPML Navigation stylesheets
//			define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);																								// WPML Drop-down language selector stylesheet
			define( 'ICL_DONT_LOAD_LANGUAGES_JS', true);																										// WPML Drop-down language selector Javascript
		}
	}
	
	/**
     * Disable Emojicons
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
	public function remove_emojicons() 
	{
	    // Remove from comment feed and RSS
	    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	
	    // Remove from emails
	    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	
	    // Remove from head tag
	    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

		// filter to remove TinyMCE emojis
		add_filter( 'tiny_mce_plugins', 'disable_emoji_tinymce' );     
	
	    // Remove from print related styling
	    remove_action( 'wp_print_styles', 'print_emoji_styles' );
	
	    // Remove from admin area
	    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	    remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}	
	
	/**
     * Remove WP version from js and css files
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
	public function remove_wp_ver_css_js( $src ) {
	    if ( strpos( $src, 'ver=' ) )
	        $src = remove_query_arg( 'ver', $src );
	    return $src;
	}
	
	/**
     * Remove injected CSS for recent comments widget
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
	public function remove_wp_widget_recent_comments_style() {
		if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
			remove_filter('wp_head', 'wp_widget_recent_comments_style' );
		}
	}

	/**
     * Remove injected CSS from recent comments widget
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
	public function remove_recent_comments_style() {
		global $wp_widget_factory;
		if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
			remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
		}
	}
	
	
	/**
     * Remove injected CSS from recent comments widget
     *
     * @since  2.7.3
     * @access public
     * @return void
     */
	public function remove_wp_embedded_script(){
		wp_deregister_script( 'wp-embed' );
	}
	
	
	/**
     * Add various favicons and logos for iOS, Android, Windows
     * NEW: Check if WP-Core function 'has_site_icon()' is supported, since 4.3.x
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
	public function meta_icons(){
		
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { 																						// Check for new core function with 4.3

			$stylesheet_directory_uri = get_stylesheet_directory_uri();																							// URL
			$stylesheet_directory = get_stylesheet_directory();																									// File
			$get_bloginfo = get_bloginfo('name');																												// Blogname

			$touch_icon_url_192 = $stylesheet_directory_uri.'/apple-touch-icon.png?v='.$this->version;															// URL 180x180
			$touch_icon_192 		= $stylesheet_directory.'/apple-touch-icon.png';																					// File 180x180

			$touch_icon_url_180 = $stylesheet_directory_uri.'/apple-touch-icon-180x180-precomposed.png?v='.$this->version;										// URL 180x180
			$touch_icon_180 		= $stylesheet_directory.'/apple-touch-icon-180x180-precomposed.png';																//  File 180x180

			$touch_icon_url_152 = $stylesheet_directory_uri.'/apple-touch-icon-152x152-precomposed.png?v='.$this->version;										// URL 152x152
			$touch_icon_152 		= $stylesheet_directory.'/apple-touch-icon-152x152-precomposed.png';																// File 152x152

			$touch_icon_url_120 = $stylesheet_directory_uri.'/apple-touch-icon-120x120-precomposed.png?v='.$this->version;										// URL 120x120
			$touch_icon_120 		= $stylesheet_directory.'/apple-touch-icon-120x120-precomposed.png';																// File 120x120

			$touch_icon_url_76  = $stylesheet_directory_uri.'/apple-touch-icon-76x76-precomposed.png?v='.$this->version;											// URL 76x76
			$touch_icon_76  		= $stylesheet_directory.'/apple-touch-icon-76x76-precomposed.png';																// File 76x76

			$touch_icon_url_57  = $stylesheet_directory_uri.'/apple-touch-icon-precomposed.png?v='.$this->version;												// URL 57x57
			$touch_icon_57  		= $stylesheet_directory.'/apple-touch-icon-precomposed.png';																		// File 57x57

			$browserconfig_url  = $stylesheet_directory_uri.'/browserconfig.xml?v='.$this->version;																// URL Microsoft 270x270
			$browserconfig 	 	= $stylesheet_directory.'/browserconfig.xml';																					// File Microsoft 270x270

			$android_manifest_url = $stylesheet_directory_uri.'/manifest.json?v='.$this->version;																// URL Android JSON Manifest
			$android_manifest 	  = $stylesheet_directory.'/manifest.json';																						// File Android JSON Manifest

			$safari_pinned_tab_url 	= $stylesheet_directory_uri.'/safari-pinned-tab.svg?v='.$this->version;														// URL safari pinned tab svg
			$safari_pinned_tab 		= $stylesheet_directory.'/safari-pinned-tab.svg';																			// File safari pinned tab svg

			$favicon_url  	= $stylesheet_directory_uri.'/favicon.ico?v='.$this->version;																		// URL Classic Favicon 16x16 + 32x32	 + 48x48	
			$favicon  		= $stylesheet_directory.'/favicon.ico';																								// File Classic Favicon 16x16 + 32x32 + 48x48

			$favicon_url_16 = $stylesheet_directory_uri.'/favicon-16x16.png?v='.$this->version;																	// URL 16x16 PNG Favicon
			$favicon_16 	= $stylesheet_directory.'/favicon-16x16.png';																							// File 16x16 PNG Favicon

			$favicon_url_32 = $stylesheet_directory_uri.'/favicon-32x32.png?v='.$this->version;																	// URL 32x32 PNG Favicon
			$favicon_32 	= $stylesheet_directory.'/favicon-32x32.png';																							// File 32x32 PNG Favicon
	
			echo '<!-- Favicons from sr-theme-functionality plugin -->
				<meta name="apple-mobile-web-app-title" content="'.$get_bloginfo.'" />
				<meta name="application-name" content="'.$get_bloginfo.'" />';
			
			// General Icon
			if( is_file($touch_icon_192) ){
				echo '<link rel="apple-touch-icon" sizes="180x180" href="'.$touch_icon_url_192.'" />';
			}
			// Apple icons
			if( is_file($touch_icon_180) ){
				echo '<link rel="apple-touch-icon" sizes="180x180" href="'.$touch_icon_url_180.'" /><!-- For iPhone 6 Plus with @3× display: 180x180 -->';
			}
			if( is_file($touch_icon_152) ){
				echo '<link rel="apple-touch-icon" sizes="152x152" href="'.$touch_icon_url_152.'" /><!-- For iPad with @2× display running iOS ≥ 7: 152x152 -->';
			}
			if( is_file($touch_icon_120) ){
				echo '<link rel="apple-touch-icon" sizes="120x120" href="'.$touch_icon_url_120.'" /><!-- For iPhone with @2× display running iOS ≥ 7: 120x120 -->';
			}
			if( is_file($touch_icon_76) ){
				echo '<link rel="apple-touch-icon" sizes="76x76" href="'.$touch_icon_url_76.'" /><!-- For the iPad mini and the first- and second-generation iPad (@1× display) on iOS ≥ 7: 76x76 -->';
			}
			if( is_file($touch_icon_57) ){
				echo '<link rel="apple-touch-icon-precomposed" href="'.$touch_icon_url_57.'" /><!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: 57×57px -->';
			}
			// Microsoft Icons
			if( is_file($browserconfig) ){
				echo '<meta name="msapplication-config" content="'.$browserconfig_url.'" />';	
			}
			// Android Manifest
			if( is_file($android_manifest) ){
				echo '<link rel="manifest" href="'.$android_manifest_url.'" />';
			}
			// Android Manifest
			if( is_file($safari_pinned_tab) ){
				echo '<link rel="mask-icon" href="'.$safari_pinned_tab_url.'" color="#ffffff" />';
			}
			// Favicon
			if( is_file($favicon_16) ){
				echo '<link rel=icon type="image/png" sizes=16x16 href="'.$favicon_url_16.'" />';
			}			
			if( is_file($favicon_32) ){
				echo '<link rel=icon type="image/png" sizes=32x32 href="'.$favicon_url_32.'" />';
			}			

			if( is_file($favicon) ){
				echo '<link rel="shortcut icon" href="'.$favicon_url.'" />';
			}
			
		} // END if !has_site_icon
	}
		
	/**
     * Removes invalid rel attribute values in the categorylist
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
	public function remove_category_rel_from_category_list( $list ) {
		return str_replace( 'rel="category tag"', 'rel="tag"', $list );
	}
	
	/**
     * Add page slug to body class - Credit: Starkers Wordpress Theme
     *
     * @since  1.0.0
     * @access public
     * @return array
     */
	public function add_slug_to_body_class( $classes )
	{
	    global $post;
	    if (is_home()) {
	        $key = array_search( 'blog', $classes );
	        if ($key > -1) {
	            unset($classes[$key]);
	        }
	    } elseif (is_page()) {
	        $classes[] = sanitize_html_class( 'page-slug-'.$post->post_name );
	    } elseif (is_singular()) {
	        $classes[] = sanitize_html_class( 'page-slug-'.$post->post_name );
	    }
	
	    return $classes;
	}
	
	
	/**
     * Add page slug to navigation class with prefix 'menu-item'
     *
     * @since  2.8.1
     * @access public
     * @return array
     */
	function add_slug_to_navigation_class( $classes, $item ) { 
		if( 'page' == $item->object ){ 
			$page = get_post( $item->object_id ); 
			$classes[] = sanitize_html_class( 'menu-item-'.$page->post_name );
		} 
		return $classes; 
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in sr_theme_functionality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The sr_theme_functionality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sr-theme-functionality-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in sr_theme_functionality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The sr_theme_functionality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sr-theme-functionality-public.js', array( 'jquery' ), $this->version, false );

	}

}
