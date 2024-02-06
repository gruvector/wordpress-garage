<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Contact_Property_Controller extends Abstract_Template_Controller
{
    public $property_section_nm = [];
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
        $this->property_section_nm = $this->wpdb->get_results("SELECT section_nm, address_1, address_2, address_3, address_4 FROM {$this->wpdb->prefix}gmt_property WHERE ID = $b")[0];

        $this->mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        if (isset($_POST['hidden']) && $_POST['hidden'] == 'hidden') {
            $this->mail_send($_POST, $this->property_section_nm);
            $this->mode = "completed";
        }
                
        $this->render();
    }

    public function mail_send($params, $property) {
        $contact_way = implode(',', $params['contact_way']);
        $contact_content = implode(',', $params['contact_content']);
        $to = 'info@ar-garage.com';
        $subject = 'ガレージ物件の家賃をリクエストする';
        $message = '
            ガレージとユーザーの情報です: 
                 <br />&emsp;ガレージ名: '. $property->section_nm.
                '<br />&emsp;住所: '. $this->address.
                '<br />&emsp;お名前: '.$params['nm'].
                '<br />&emsp;メールアドレス: '.$params['email'].
                '<br />&emsp;電話番号: '.$params['phone'].
                '<br />&emsp;ご希望の連絡方法: '.$contact_way.
                '<br />&emsp;お問合せ内容: '.$contact_content.
                '<br />&emsp;その他'.$params['apply_memo']
        ;
        $success = wp_mail($to, $subject, $message);
    }
    // private function check($params)
    // {
    //     // -----------------
    //     // 入力チェック
    //     // -----------------
    //     $validation = new Gm_Validation($params);
    //     $validation->required([
    //         ['key' => 'nm', 'name' => '名前',],
    //         ['key' => 'email', 'name' => 'メールアドレス',],
    //         ['key' => 'account_attr_id', 'name' => 'アカウント属性',],
    //      ]);
    //     $validation->length([
    //        ['key' => 'nm', 'name' => '名前', 'len' => 255],
    //      ]);
    //     $validation->email([
    //        ['key' => 'email', 'name' => 'メールアドレス',],
    //      ]);
    //     $validation->numeric([
    //       ['key' => 'account_attr_id', 'name' => 'アカウント属性',],
    //     ]);

    //     if ($params['account_attr_id'] == '9') {
    //         $validation->required([
    //             ['key' => 'account_attr_other', 'name' => 'アカウント属性その他',],
    //          ]);
    //         $validation->length([
    //             ['key' => 'account_attr_other', 'name' => 'アカウント属性その他', 'len' => 255],
    //           ]);
    //     }

    //     $errors = $validation->errors();
    //     if (!empty($errors)) {
    //         $this->set_input_params($params);
    //         $this->set_common_error($errors);
    //         return;
    //     }

    //     // -----------------
    //     // 画面遷移
    //     // -----------------
    //     $url = explode('?', Gm_Util::get_url())[0];
    //     if (!empty($params)) {
    //         if (isset($params['process'])) {
    //             unset($params['process']);
    //         }
    //         $url = $url . '?mode=complete';
    //     }
    //     // 画面遷移
    //     header('Location: ' . $url);
    //     exit();
    // }

    
}
