<?php

/**
 * Register and Enqueue Styles.
 */

/*
 * Функции для добавления версии к подключаемым стилям и скриптам С помощью данной функции нет необходимости очищать кеш браузера
 */
function enqueue_versioned_script( $handle, $src = false, $deps = array(), $in_footer = true ) {
	wp_enqueue_script( $handle, get_stylesheet_directory_uri() . $src, $deps, filemtime( get_stylesheet_directory() . $src ), $in_footer );
}
function enqueue_versioned_style( $handle, $src = false, $deps = array(), $media = 'all' ) {
	wp_enqueue_style( $handle, get_stylesheet_directory_uri() . $src, $deps = array(), filemtime( get_stylesheet_directory() . $src ), $media );
}

function niko_register_styles() {
    //получть версию Темы
    $theme_version = wp_get_theme()->get( 'Version' );
    // Подключить стили и фон (важен порядок для стилей!!??)  
    wp_enqueue_script('webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js', array(), null, true);
    wp_enqueue_script('fonts', get_template_directory_uri().'/assets/js/fonts.js', array(), null, true);
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.css',array(), null );
    wp_enqueue_style('aos', get_template_directory_uri().'/assets/css/aos.css',array(),null );
    enqueue_versioned_style('custom','/assets/css/custom.css');
    wp_enqueue_style('icons', get_template_directory_uri().'/assets/css/icons.css' ,array(),null);
    wp_enqueue_style('magnific', get_template_directory_uri().'/assets/css/magnific-popup.css',array(),null );
    enqueue_versioned_style('niko-basic-style', '/style.css');
}
add_action( 'wp_enqueue_scripts', 'niko_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function niko_register_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    //Подключение стилей
    wp_deregister_script('jquery');
    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', array(), null, true );
    wp_enqueue_script( 'aos', get_template_directory_uri() . '/assets/js/aos.js', array('jquery'), $theme_version, true );

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() . '/assets/js/jquery.smooth-scroll.min.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'valid-ajax', get_template_directory_uri() . '/assets/js/valid-ajax.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'jquery-maskedinput', get_template_directory_uri() . '/assets/js/jquery.maskedinput.min.js', array('jquery'), $theme_version, true );
    wp_enqueue_script( 'goodshare', 'https://cdn.jsdelivr.net/jquery.goodshare.js/3.2.8/goodshare.min.js', array('jquery'), $theme_version, true );
}
add_action( 'wp_enqueue_scripts', 'niko_register_scripts' );


/**
 * Подключение FancyBox для страниц каталога
 */
add_action( 'wp_enqueue_scripts', 'niko_register_fancy' );
function niko_register_fancy () {
    if(is_page_template('foto-items.php')){
        wp_enqueue_style('fancy', "https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" ,array(),null);
        wp_enqueue_script( 'fancy2', "https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js", array('jquery'), '', true );
    }
}

/**
* Подключение скиптов для старницы О нас
 */
add_action( 'wp_enqueue_scripts', 'niko_register_count' );
function niko_register_count () {
    if (is_page('about')) {
        wp_enqueue_script('waypoints', get_template_directory_uri() ."/assets/js/jquery.waypoints.min.js", array('jquery'), null, true );
        wp_enqueue_script( 'countUp', get_template_directory_uri() ."/assets/js/countUp-jquery.js", array('jquery'), null, true );
        wp_enqueue_script( 'about', get_template_directory_uri() ."/assets/js/about.js", array('jquery'), null, true );
    }
}


/**
 * Register Menu
 */
if (function_exists('register_nav_menu')) {
      register_nav_menus(array(
            'main_menu' => 'Главное меню',
            'sidebar_menu' => 'Меню Сайдбар',
      ));
}
//Кастомизация элементов меню
add_filter( 'nav_menu_css_class', 'change_menu_item_css_classes', 10, 4 );
function change_menu_item_css_classes($classes) {
	return $classes[] ='';
}
add_filter( 'nav_menu_item_id', '__return_empty_string' );

// Подключение необходимых элементов управления темой
function atlas_theme_support(){
        add_theme_support('custom-logo');
        add_theme_support('post-thumbnails');
}
add_action( 'after_setup_theme', 'atlas_theme_support' );

//Функция добавляения шорткода в любое поле ACF
function root_acf_format_value( $value, $post_id, $field ) {
	
	$value = do_shortcode($value);
	
	return $value;
}
add_filter('acf/format_value', 'root_acf_format_value', 10, 3);

//Отключить пагинацию
function custom_redirect_pagination_page() {
   if(is_paged() && !is_category()) {
      wp_redirect(get_permalink(), 301);
   }
}
add_action('template_redirect', 'custom_redirect_pagination_page');

//Функция от дублей страниц с числами в конце URL
    global $posts, $numpages;
    $request_uri = $_SERVER['REQUEST_URI'];
    $result = preg_match('%\/(\d)+(\/)?$%', $request_uri, $matches);
    $ordinal = $result ? intval($matches[1]) : FALSE;
    if(is_numeric($ordinal)) {
        setup_postdata($posts[0]); // yes, hack
        $redirect_to = ($ordinal < 2) ? '/': (($ordinal > $numpages) ? "/$numpages/" : FALSE);
        if(is_string($redirect_to)) {

            // we got us a phantom
            $redirect_url = get_option('home') . preg_replace('%'.$matches[0].'%', $redirect_to, $request_uri);
            $redirect_url = rtrim($redirect_url, '/');
            // if page = 0 or 1, redirect permanently
            if($ordinal < 2) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . ' 302 Found');
            }
                header("Location: $redirect_url");
                exit();
        }
    }
// END function

    
