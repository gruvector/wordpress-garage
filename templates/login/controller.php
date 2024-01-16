<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Login_Controller extends Abstract_Template_Controller
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
        // -------------------
        if (isset($_POST['process']) && $_POST['process'] == 'login') {
            $this->login($_POST);
        }
        // -------------------
        // 画面描画
        // -------------------
        $this->mode = isset($_GET['mode']) ? $_GET['mode'] : '';

        $this->render();
    }

    private function login($params)
    {
        // -----------------
        // 入力チェック
        // -----------------
        $validation = new Gm_Validation($params);
        $validation->required([
            ['key' => 'user_id', 'name' => 'ログインID',],
            ['key' => 'user_password', 'name' => 'パスワード',],
         ]);
        $validation->email([
            ['key' => 'user_id', 'name' => 'ログインID',],
         ]);
        $validation->password([
            ['key' => 'user_password', 'name' => 'パスワード',],
         ]);
        $errors = $validation->errors();
        if (!empty($errors)) {
            $this->set_input_params($params);
            $this->set_common_error('IDまたはパスワードが違います。'); // エラー内容を見せないために強制表示
            return;
        }

        // -----------------
        // ログイン情報チェック
        // -----------------
        $records = $this->wpdb->get_results(
            $this->wpdb->prepare("SELECT ID FROM {$this->wpdb->prefix}gmt_account WHERE email = %s AND password = %s", $params['user_id'], $params['user_password'])
        );
        if (empty($records)) {
            $this->set_common_error('IDまたはパスワードが違います。');
            return;
        }
        $record = $records[0];

        // -----------------
        // セッション情報保持
        // -----------------
        session_start();
        $_SESSION['account_id'] = $record->ID;

        // -----------------
        // 画面遷移
        // -----------------
        // 画面遷移
        header('Location: /mypage');
        exit();
    }

}
