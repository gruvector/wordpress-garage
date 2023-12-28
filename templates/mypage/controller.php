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
        $records1 = $this->wpdb->get_results( "SELECT nm, availability_id, section_nm  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id");
        $records2 = $this->wpdb->get_results( "SELECT property_id, publish_from, publish_to  FROM {$this->wpdb->prefix}gmt_property_publish");
        // 画面描画
        $this->render();
    }
}
