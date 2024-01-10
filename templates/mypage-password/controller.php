<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Password_Controller extends Abstract_Template_Mypage_Controller
{
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
        if (isset($_POST['process']) && $_POST['process'] == 'check') {
            $this->check($_POST);
        }
        if (isset($_POST['process']) && $_POST['process'] == 'regist') {
            $this->regist($this->url_params());
        }

        // -------------------
        // 画面描画
        // -------------------
        $this->mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        // 確認
        if ($this->mode == 'confirm') {
            $this->set_input_params($this->url_params());
        }


        // 画面描画
        $this->render();
    }

    private function check($params)
    {
        // -----------------
        // 入力チェック
        // -----------------
        $validation = new Gm_Validation($params);
        $user = $_SESSION['account_id'];
        $old_pwd = $this->wpdb->get_results("SELECT password FROM {$this->wpdb->prefix}gmt_account WHERE ID = $user"); 
        $strOld_Pwd1 = json_encode($old_pwd[0]); // Assuming the key is 'password'
        $objOld_Pwd2 = json_decode($strOld_Pwd1);
        $password = $objOld_Pwd2->password;
        if ($params['new_pwd'] != $params['confirm'] || $params['old_pwd'] != $password) {
            $this->set_input_params($params);
            echo "<script>alert(\"以前のパスワードが間違っています。 新しいパスワードを再確認してください。\");</script>";
            return;
        }

        // -----------------
        // 画面遷移
        // -----------------
        $url = explode('?', Gm_Util::get_url())[0];
        if (!empty($params)) {
            if (isset($params['process'])) {
                unset($params['process']);
            }
            $url = $url . '?mode=confirm&v=' . urlencode(Gm_Util::encrypt(json_encode($params, JSON_UNESCAPED_UNICODE)));
        }
        // 画面遷移
        header('Location: ' . $url);
        exit();
    }


    private function regist($params)
    {
        // -----------------
        // データ登録
        // -----------------
        echo $params['new_pwd'];
        $this->wpdb->update(
            $this->wpdb->prefix.'gmt_account',
            [
                'password' => $params['new_pwd'],
            ], ['account_attr_id' => $_SESSION['account_id']]
        );

        header('Location:/mypage');
        exit();
    }

}
