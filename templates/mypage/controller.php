<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Controller extends Abstract_Template_Mypage_Controller
{
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

        // switch($clarify) {
        //     case 0:$this->records1 = $this->wpdb->get_results( "SELECT ID, nm, availability_id, section_nm  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id ");
        //     case 1:$this->records1 = $this->wpdb->get_results( "SELECT ID, nm, availability_id, section_nm  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND availability_id");

        // }
        $this->records1 = $this->wpdb->get_results( "SELECT ID, nm, availability_id, section_nm  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id");
        $this->records2 = $this->wpdb->get_results( "SELECT * FROM {$this->wpdb->prefix}gmt_property_publish");
        // 画面描画
        $this->render();
    }
}


