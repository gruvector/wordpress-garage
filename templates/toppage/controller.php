<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Toppage_Controller extends Abstract_Template_Controller
{
    public $account_attr_records = [];

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
        $wpgomap = $this->wpdb->get_results("SELECT ID, address_1 FROM {$this->wpdb->prefix}gmt_property");
        // $this->wpdb->insert(
        //     $this->wpdb->prefix.'wpgmza',
        //     [
        //         // 'property_id' => $params['property_id'],
        //         'address' => $wpgomap['address_1']
        //     ]
        // );

        // -------------------
        // 画面描画
        // -------------------

        $this->render();
    }


}
