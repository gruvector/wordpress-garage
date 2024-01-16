<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Favorite_Controller extends Abstract_Template_Controller
{
    public $favorite_list = [];

    protected function setting() {
        parent::setting();
    }

    private function render() {
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/header.php';
        require 'view.php';
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/footer.php';
    }

    public function action() {

        $cookie_name = "favorite";
        if(!isset($_COOKIE[$cookie_name])) {
            echo "Cookie named '" . $cookie_name . "' is not set!";
        } else {
            $a = explode(",", $_COOKIE[$cookie_name]);
        }
        for($i = 1; $i < count($a); $i++) {
            $b = (int) $a[$i];
            array_push($this->favorite_list, $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE ID = $b"));
        }
        $this->render();
    }

 
}
