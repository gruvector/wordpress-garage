<?php

abstract class Abstract_Template_Controller
{
    public $mode = '';
    public $request_time = '';
    public $arrow_history_back = true;
    protected $wpdb;
    protected $input_params = [];
    protected $error_list = [
        'common_errors' => [],
        'contents_errors' => [],
    ];

    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
        $this->request_time = date("YmdHis");
        global $wpdb;
        $this->wpdb = $wpdb;
        $wpdb->query('START TRANSACTION');

        // 途中でexitした場合もcommitする。
        $is_clean_exit = false;
        register_shutdown_function(function () use (&$is_clean_exit, &$wpdb) {
            if (!$is_clean_exit) {
                $wpdb->query("COMMIT");
            }
        });

        try {
            $this->setting();
            $this->pre_action();
            $this->action();
            $this->post_action();
        } catch (Exception $e) {
            $wpdb->query("ROLLBACK");
            $is_clean_exit = true;
            // TODO
            header('Location: /');
            exit();
        }
        $wpdb->query("COMMIT");
        $is_clean_exit = true;
    }

    protected function setting()
    {
        $version = date('YmdHis');
        wp_enqueue_script('gm_jquery_plugin', get_stylesheet_directory_uri(). '/assets/lib/jquery.plugin/jquery.plugin.min.js', array('jquery-core', 'jquery-migrate'), $version);
        wp_enqueue_script('gm_validation', get_stylesheet_directory_uri(). '/assets/lib/jquery.validation/jquery.validate.min.js', array('jquery-core', 'jquery-migrate'));
        wp_enqueue_script('gm_jquery_tipsy', get_stylesheet_directory_uri(). '/assets/lib/jquery.tipsy/javascripts/jquery.tipsy.js', array('jquery-core', 'jquery-migrate'));
        wp_enqueue_script('gm_jquery_ui', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui/jquery-ui.min.js');
        wp_enqueue_script('gm_jquery_ui_timepicker', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui-timepicker/jquery-ui-timepicker-addon.js');
        wp_enqueue_script('gm_jquery_ui_timepicker_ja', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui-timepicker/jquery-ui-timepicker-ja.js');
        wp_enqueue_script('gm_jquery_toast', get_stylesheet_directory_uri(). '/assets/lib/jquery.toast/jquery.toast.js', array('jquery-core', 'jquery-migrate'));
        wp_enqueue_script('gm_ajaxzip3', get_stylesheet_directory_uri(). '/assets/lib/ajaxzip3/ajaxzip3.js', array('jquery-core', 'jquery-migrate'));
        wp_enqueue_script('gm_common', get_stylesheet_directory_uri(). '/assets/script/common.js', array('gm_jquery_plugin', 'gm_jquery_tipsy', 'gm_jquery_toast','jquery-core', 'jquery-migrate'), $version);

        wp_enqueue_style('gm_jquery_tipsy', get_stylesheet_directory_uri(). '/assets/lib/jquery.tipsy/stylesheets/tipsy.css', array());
        wp_enqueue_style('gm_jquery_ui', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui/jquery-ui.min.css');
        wp_enqueue_style('gm_jquery_ui_timepicker', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui-timepicker/jquery-ui-timepicker-addon.css');
        wp_enqueue_style('gm_jquery_toast', get_stylesheet_directory_uri(). '/assets/lib/jquery.toast/jquery.toast.css', array());
        wp_enqueue_style('gm_front', get_stylesheet_directory_uri(). '/assets/style/front.css', array(), $version);

    }

    abstract protected function action();

    // override用
    protected function pre_action() {}
    // override用
    protected function post_action() {}

    protected function set_input_params($list)
    {
        if (!empty($list)) {
            foreach($list as $key => $value) {
                if ($key != 'mode') {
                    $this->input_params[$key] = $value;
                }
            }
        }

    }

    public function get_input_param($key)
    {
        if (isset($this->input_params[$key]) && !empty($this->input_params[$key])) {
            return $this->input_params[$key];
        }
        return '';
    }

    public function set_common_error($error)
    {
        if (is_array($error)) {
            $this->error_list['common_errors'] = array_merge($this->error_list['common_errors'], $error);
            return;
        }
        $this->error_list['common_errors'][] = $error;
    }

    public function set_contents_error($key, $error)
    {
        $this->error_list['contents_errors'][$key] = $error;
    }

    protected function url_params()
    {
        if (isset($_GET['v'])) {
            $json = Gm_Util::decrypt($_GET['v']);
            if (!empty($json)) {
                return json_decode($json, JSON_UNESCAPED_UNICODE);
            }
        }
        return null;
    }


}
