<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';

class Gm_Property_Controller extends Abstract_Template_Controller
{
    public $property_details = [];
    public $property_publish = [];
    public $property_special = [];
    public $availability_records = [];
    public $apikey;

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
        
        $this->property_details = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE status1 = 1 AND property_id = {$param}");
        $this->property_special = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmm_facility");
        $this->property_publish = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property_publish WHERE property_id = {$param}");
        $this->apikey = $this->wpdb->get_results("SELECT group_map_title FROM {$this->wpdb->prefix}group_map WHERE group_map_id = 1")[0]->group_map_title;
        $this->availability_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_availability order by priority");
        $this->render();
    }

    
    
}
