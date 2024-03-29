<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Forget_Controller extends Abstract_Template_Controller
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
        // -------------------
        // メイン処理
        // -------------------.
        if (isset($_GET['forget'])) {
            if ($_GET['forget'] == "wrong") {
                echo("<script>alert('申し訳ありませんが、メールが正確に配信されていません。もう一度お試しください。')</script>");
            }
        }
        if (isset($_POST['process']) && $_POST['process'] == 'forget') {
            $this->forget($_POST);
        }
        // -------------------
        // 画面描画
        // -------------------

        $this->render();
    }

    function gdpr_delay_script_execution( $ms ) {
        return 5000; 
    }
    private function forget($params)
    {
        // -----------------
        // 入力チェック
        // -----------------
        $validation = new Gm_Validation($params);
        $validation->required([
            ['key' => 'user_id', 'name' => 'ログインID',],
         ]);
        $validation->email([
            ['key' => 'user_id', 'name' => 'ログインID',],
         ]);

        $errors = $validation->errors();
        if (!empty($errors)) {
            $this->set_input_params($params);
            $this->set_common_error('IDが違います。'); // エラー内容を見せないために強制表示
            echo("<script>alert(\"IDが違います。\")</script>");
            return;
        }

        // -----------------
        // ログイン情報チェック
        // -----------------
        $records = $this->wpdb->get_results(
            $this->wpdb->prepare("SELECT ID FROM {$this->wpdb->prefix}gmt_account WHERE email = %s", $params['user_id'])
        );
        if (empty($records)) {
            $this->set_common_error('IDが違います。');
            echo("<script>alert('入力された電子メールは存在しません。メールを正確に入力してください。')</script>");
            return;
        }

        // -----------------
        // セッション情報保持
        // ----------------


        $to = 'info@ar-garage.com';

        $subject = 'Hello,  I forgot my password';

        $message = 'This is my email';

        $message .= $params['user_id'];
        
        $success = wp_mail($to, $subject, $message);


        if ($success) {
            
            header('Location: /login?forget=ok');
        } else {
            header('Location: /forget?forget=wrong');
            
        };

        // -----------------
        // 画面遷移
        // -----------------
        // 画面遷移
        

        exit();
    }

}
