<?php

require_once ABSPATH .'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';

class Gm_MypagePublish_Controller extends Abstract_Template_Mypage_Controller
{
    public $property_info1 ;
    public $property_info2 ;
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
        $accountid = $_SESSION['account_id'];
        $b = $_GET['id'] ;
        $this->property_info2 = $this->wpdb->get_results($this->wpdb->prepare("SELECT nm, ID, kana, phone, email FROM {$this->wpdb->prefix}gmt_account WHERE ID = %d", $accountid))[0];
        if ($b) {
            $this->property_info1 = $this->wpdb->get_results($this->wpdb->prepare("SELECT ID, nm FROM {$this->wpdb->prefix}gmt_property WHERE property_id=%d AND account_id=%d", $b, $accountid))[0];
            if (!(isset($this->property_info1))) {
                header('Location:/mypage');
            }
        } else {header('Location:/mypage');}

        $this->mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        if (isset($_POST['hidden']) && $_POST['hidden'] == 'hidden') {
            $this->mail_send($_POST);
            $this->mode = "completed";
        } else {
            // 
        }
                
        $this->render();
    }

    public function mail_send($params) {
        $to = 'info@ar-garage.com';
        $subject = '';
        $message = '
                物件公開申請がありました。: 
                 <br />〇情報
                 <br />&emsp;お名前: '. $this->property_info2->nm.
                '<br />&emsp;カナ: '. $this->property_info2->kana.
                '<br />&emsp;メールアドレス: '.$this->property_info2->email.
                '<br />&emsp;電話番号: '.$this->property_info2->phone.
                '<br />&emsp;物件番号: '.$this->property_info1->ID.
                '<br />&emsp;名称: '.$this->property_info1->nm.
                '<br />&emsp;掲載希望期間: '.$params['period'].
                '<br />&emsp;その他'.$params['apply_memo']
        ;
        $success = wp_mail($to, $subject, $message);
    }
}


