<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';

class Gm_Property_Controller extends Abstract_Template_Controller
{
    public $property_details = [];
    public $property_publish = [];

    protected function setting() {
        parent::setting();
    }

    private function render() {
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/header.php';
        require 'view.php';
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/footer.php';
    }

    public function action() {
        if (isset($_GET['id'])) {
            $param = (int) $_GET['id'];
        }
        
        $this->property_details = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE status1 = 1 AND ID = {$param}");
        $this->property_publish = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property_publish WHERE ID = {$param}");
        $this->render();
    }

    
    
}
