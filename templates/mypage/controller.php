<?php

require_once ABSPATH .'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';

class Gm_Mypage_Controller extends Abstract_Template_Mypage_Controller
{
    var $radio_value = "";
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

            if ($_POST['public_private'] == "public") {
                $this->wpdb->update(
                    $this->wpdb->prefix.'gmt_property',
                    [
                        'availability_id' => 1,
                    ],
                    [
                        'account_id' => $account_id,
                        'ID' => $_POST['property_id_num'],
                    ]
                
                );
            };
            
            if ($_POST['public_private'] == "private") {
                $this->wpdb->update(
                    $this->wpdb->prefix.'gmt_property',
                    [
                        'availability_id' => 0,
                    ],
                    [
                        'account_id' => $account_id,
                        'ID' => $_POST['property_id_num'],
                    ]
                
                );
            };
        }
        if(isset($_GET['pwd'])) {
            if($_GET['pwd'] == "ok") {
                echo "<script>alert('パスワードが正確に変更されました。');</script>";
            }
        }

        if(isset($_GET['propertyFilter'])){
        $this->radio_value = $_GET['propertyFilter'];
        switch($this->radio_value) {
            case "1"; default : $this->records1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id ");break;
            case "2" : $this->records1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND status1 = '1'");break;
            case "3" : $this->records1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND availability_id = '2'");break;
            case "4" : $this->records1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND status1 = '0'");break;
        }} else {
            $this->records1 = $this->wpdb->get_results( "SELECT ID, nm, status1, section_nm  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id ");
        }
        $this->records2 = $this->wpdb->get_results( "SELECT * FROM {$this->wpdb->prefix}gmt_property_publish");
        
        
        
        // 画面描画
        $this->render();
    }
}


