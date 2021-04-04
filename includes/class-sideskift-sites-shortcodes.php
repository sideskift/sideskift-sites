<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://sideskift.dk
 * @since      1.0.0
 *
 * @package    Sideskift_Sites
 * @subpackage Sideskift_Sites/includes
 */

/**
 * Registers the sideskift shortcode.
 *
 * @package    Sideskift_Sites
 * @subpackage Sideskift_Sites/includes
 * @author     Henrik Gregersen <henrik@sideskift.dk>
 */

class Sideskift_Sites_Shortcodes {




    //TODO: Ryd op i de her shorcode metoder.

    function __construct()
    {
        $this->registerShortcodes();

        /*
        //Register toolset shortcodes
        // Gammel kode fra gammel plugin.
        if (function_exists('wpv_custom_inner_shortcodes')) {
            add_filter('wpv_custom_inner_shortcodes', array(__CLASS__, 'registerToolsetShortcodes'));
        }
        */
    }


    protected function registerShortcodes() {

        // Generic shortcode
        add_shortcode('dk_sideskift_condition'                  , array(__CLASS__, 'renderCondition'));

        // Regular shortcodes
        add_shortcode('dk_sideskift_forgot_password_url'        , array(__CLASS__, 'forgotPasswordUrl'));
        add_shortcode('dk_sideskift_log_out_url'                , array(__CLASS__, 'logOutUrl'));
        add_shortcode('dk_sideskift_current_url'                , array(__CLASS__, 'currentUrl'));
        add_shortcode('dk_sideskift_login_redirect_back_url'    , array(__CLASS__, 'loginRedirectBackUrl'));

    }

    static public function renderCondition($atts, $content = null) {
        return \sideskift_sites\includes\ConditionShortCode::newConditionShortCode($atts, $content);
    }

    static public function forgotPasswordUrl($atts, $content, $name) {
        return wp_lostpassword_url();
    }

    static public function logOutUrl($atts, $content, $name) {
        return wp_logout_url(get_permalink());
    }

    static public function currentUrl($atts, $content, $name) {
        return get_permalink();
    }

    static public function loginRedirectBackUrl($atts, $content, $name) {

        global $wp;
        $current_url = home_url(add_query_arg(array(),$wp->request));

        return wp_login_url($current_url);
    }
}