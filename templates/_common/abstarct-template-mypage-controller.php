<?php
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
abstract class Abstract_Template_Mypage_Controller extends Abstract_Template_Controller
{
    protected $_account_record = [];

    protected function pre_action()
    {
        parent::pre_action();

        session_start();
        if (!isset($_SESSION['account_id'])) {
            header('Location: /timeout/');
            exit();
        }

        // -----------------
        // 企業情報保存
        // -----------------
        $account_records = $this->wpdb->get_results(
            $this->wpdb->prepare("SELECT * FROM {$this->wpdb->prefix}gmt_account WHERE ID = %d ", $_SESSION['account_id'])
        );
        if (empty($account_records)) {
            header('Location: /timeout/');
            exit();
        }
        $this->_account_record = $account_records[0];

    }

    protected function post_action()
    {
        parent::post_action();
    }
}
