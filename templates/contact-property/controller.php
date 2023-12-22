<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Contact_Property_Controller extends Abstract_Template_Controller
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
        $this->mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        if (isset($_POST['hidden']) && $_POST['hidden'] == 'hidden') {
            $this->mode = "completed";

            $to = 'info@ar-garage.com';

            $subject = 'Hello, I wanna ask you some questions';

            $message = 'These are my name, email and quiz: ';

            $message .= $_POST['nm'].", ".$_POST['email'].", ".$_POST['account_attr_id'].", ".$_POST['apply_memo'];
            
            $success = wp_mail($to, $subject, $message);
        }
        
        $this->account_attr_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_account_attr order by priority");

        $this->render();
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
