<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Toppage_Controller extends Abstract_Template_Controller
{
    public $account_attr_records = [];
    public $wpgomap = [];

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
        $this->wpgomap = $this->wpdb->get_results("SELECT ID, nm, imgs, lat, lng, fee_monthly_rent  FROM {$this->wpdb->prefix}gmt_property");
        // -------------------
        // 画面描画
        // -------------------
        $this->render();
    }


}
