<?php

require_once ABSPATH .'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';

class Gm_Mypage_Controller extends Abstract_Template_Mypage_Controller
{
    var $radio_value = "";
    public $req_type = -1;
    protected function setting()
    {
        parent::setting();
    }

    private function render()
    {
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/header.php';
        require 'view.php';
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/footer.php';
    }

    public function action()
    {


        $account_id = $_SESSION['account_id'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }
        

        if(isset($_GET['propertyFilter'])){
        $this->radio_value = $_GET['propertyFilter'];
        switch($this->radio_value) {
            case "1"; default : $this->records1_1 = $this->wpdb->get_results( "SELECT {$this->wpdb->prefix}gmt_property.property_id, nm, section_nm, status1, {$this->wpdb->prefix}gmt_property_publish.publish_from, publish_to FROM {$this->wpdb->prefix}gmt_property LEFT JOIN {$this->wpdb->prefix}gmt_property_publish ON {$this->wpdb->prefix}gmt_property.property_id = {$this->wpdb->prefix}gmt_property_publish.property_id WHERE account_id = $account_id");
                                $this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg, remand_comment  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id");break;
            case "2" : $this->records1_1 = $this->wpdb->get_results( "SELECT {$this->wpdb->prefix}gmt_property.property_id, nm, section_nm, status1, {$this->wpdb->prefix}gmt_property_publish.publish_from, publish_to FROM {$this->wpdb->prefix}gmt_property LEFT JOIN {$this->wpdb->prefix}gmt_property_publish ON {$this->wpdb->prefix}gmt_property.property_id = {$this->wpdb->prefix}gmt_property_publish.property_id WHERE {$this->wpdb->prefix}gmt_property.status1 = '1' AND account_id = $account_id AND CURDATE() BETWEEN {$this->wpdb->prefix}gmt_property_publish.publish_from AND {$this->wpdb->prefix}gmt_property_publish.publish_to;");$this->req_type=0;break;
            case "4" : $this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg, remand_comment  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id AND remand_flg='0'");break;
            case "5" : $this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg, remand_comment  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id AND remand_flg='1'");break;
            case "3" : $this->records1_1 = $this->wpdb->get_results( "SELECT {$this->wpdb->prefix}gmt_property.property_id, nm, section_nm, status1, {$this->wpdb->prefix}gmt_property_publish.publish_from, publish_to FROM {$this->wpdb->prefix}gmt_property LEFT JOIN {$this->wpdb->prefix}gmt_property_publish ON {$this->wpdb->prefix}gmt_property.property_id = {$this->wpdb->prefix}gmt_property_publish.property_id WHERE account_id = $account_id");
            case "6" : $this->records1_1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1, property_id  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND status1 = '9'");$this->req_type=6;break;

        }} else {
            $this->records1_1 = $this->wpdb->get_results( "SELECT {$this->wpdb->prefix}gmt_property.property_id, nm, section_nm, status1, {$this->wpdb->prefix}gmt_property_publish.publish_from, publish_to FROM {$this->wpdb->prefix}gmt_property LEFT JOIN {$this->wpdb->prefix}gmt_property_publish ON {$this->wpdb->prefix}gmt_property.property_id = {$this->wpdb->prefix}gmt_property_publish.property_id WHERE account_id = $account_id");
            $this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg, remand_comment  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id");
        }
               
        // 画面描画
        $this->render();
    }
}


