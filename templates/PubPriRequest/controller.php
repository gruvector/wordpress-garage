<?php

require_once ABSPATH .'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';

class Gm_PubPriRequest_Controller extends Abstract_Template_Mypage_Controller
{
    public $property_info = [];
    public $address = "";

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
        $b = (string) $_GET['id'];
        $req = (string) $_GET['req'];
        $this->property_info = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE property_id = $b")[0];

        if ($_SESSION['account_id'] == $this->property_info->account_id) {
            switch($req) {
                case "private": $reqname = "非公開";break;
                case "public": $reqname = "公開申請";break;
                case "apply" : $reqname = "申請";break;
                case "deny" : $reqname = "否認";break;
            }
            $this->address = [$b, $reqname];
        } else {
            header('Location:/mypage');
        }   

        $this->mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        if (isset($_POST['hidden']) && $_POST['hidden'] == 'hidden') {
            $this->mail_send($_POST, $this->address);
            $this->mode = "completed";
        } else {
            // 
        }
                
        $this->render();
    }

    public function mail_send($params, $property) {
        $contact_way = implode(',', $params['contact_way']);
        $contact_content = implode(',', $params['contact_content']);
        $to = 'info@ar-garage.com';
        $subject = 'ガレージ不動産申請';
        $message = '
            ガレージ不動産の申請内容は下位と同じです。: 
                 <br />&emsp;物件番号: '. $property[0].
                '<br />&emsp;リクエストタイプ: '. $property[1].
                '<br />&emsp;お名前: '.$params['nm'].
                '<br />&emsp;メールアドレス: '.$params['email'].
                '<br />&emsp;電話番号: '.$params['phone'].
                '<br />&emsp;ご希望の連絡方法: '.$contact_way.
                '<br />&emsp;お問合せ内容: '.$contact_content.
                '<br />&emsp;その他'.$params['apply_memo']
        ;
        $success = wp_mail($to, $subject, $message);
    }
}


