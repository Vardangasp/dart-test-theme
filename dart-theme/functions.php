<?php
/**
 * dart-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dart-theme
 */

if ( ! function_exists( 'dart_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dart_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on dart-theme, use a find and replace
	 * to change 'dart-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dart-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'dart-theme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dart_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'dart_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dart_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dart_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'dart_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dart_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dart-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'dart-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dart_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dart_theme_scripts() {
	wp_enqueue_style( 'dart-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'dart-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'dart-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dart_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function more_post_ajax(){

    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 3;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
    header("Content-Type: text/html");
	$args = array(
	'posts_per_page'   => $ppp,
	'post_type'        => 'post',
	'post_status'      => 'publish',
	
);

   $loop = get_posts($args);
    $out = '';

     foreach($loop as $val){
		  
        $out .= '<div class="small-12 large-4 columns"><h1>'.$val->post_title.'</h1><p>'.$val->post_content.'</p></div>';

	 };
	
    echo $out;
	exit();
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');



/**
 * Theme Option Page Example
 */
function pu_theme_menu()
{
  add_theme_page( 'Theme Option', 'Theme Options', 'manage_options', 'pu_theme_options.php', 'pu_theme_page');  
}
add_action('admin_menu', 'pu_theme_menu');


// create custom plugin settings menu
add_action('admin_menu', 'theme_option_create_menu');

function theme_option_create_menu() {

	//create new top-level menu
	add_menu_page('Theme Option', 'Theme Option', 'administrator', __FILE__, 'theme_option_settings_page' , plugins_url('/images/icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'theme_option_plugin_settings' );
}


function theme_option_plugin_settings() {
	//register our settings
	register_setting( 'my-cool-plugin-settings-group', 'logo' );
	register_setting( 'my-cool-plugin-settings-group', 'color' );
}

function theme_option_settings_page() {
?>
<div class="wrap">
<h1>Theme Option</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Logo url</th>
        <td><input type="text" name="logo" value="<?php echo esc_attr( get_option('logo') ); ?>" placeholder="Copy and paste image url from media"/></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Color Code</th>
        <td><input type="text" name="color" value="<?php echo esc_attr( get_option('color') ); ?>" placeholder="#fffff"/></td>
        </tr>
       
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 

//add meta box for custom  field rating


add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add() {
    add_meta_box( 'my-meta-box-id', 'Rating', 'cd_meta_box_cb', 'page', 'normal', 'high' );
}
function cd_meta_box_cb( $post ) {
    $values = get_post_custom( $post->ID );
	$selected = isset( $post->rating ) ? esc_attr( $post->rating ) : '';
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <label for="rating">Rating : </label>
	<select name="rating" id="rating">
	<?php 
	for($i=1;$i<=5;$i++){?>
	<option value="<?php echo $i;?>" <?php selected( $selected, $i ); ?>><?php echo $i;?></option>	
	<?php }
?>	
	</select>
    <?php   
}
add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id ) {
	//echo '<pre>';print_r($_POST);die;
	
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) 
		return;
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchords can only have href attribute
        )
    );
    // Probably a good idea to make sure your data is set
    if( isset( $_POST['rating'] ) )
        update_post_meta( $post_id, 'rating', wp_kses( $_POST['rating'], $allowed ) );
}