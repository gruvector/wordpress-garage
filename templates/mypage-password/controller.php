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

        if (isset($_POST['process']) && $_POST['process'] == 'regist') {
            $this->regist($_POST);
        }

        // -------------------
        // 画面描画
        // -------------------
  
        // 画面描画
        $this->render();
    }

    private function regist($params)
    {

        $user = $_SESSION['account_id'];
        $old_pwd = $this->wpdb->get_results("SELECT password FROM {$this->wpdb->prefix}gmt_account WHERE ID = $user"); 
        $strOld_Pwd1 = json_encode($old_pwd[0]); // Assuming the key is 'password'
        $objOld_Pwd2 = json_decode($strOld_Pwd1);
        $password = $objOld_Pwd2->password;
        if ($params['new_pwd'] != $params['confirm'] || $params['old_pwd'] != $password) {
            $this->set_input_params($params);
            echo "<script>alert('以前のパスワードが間違っています。 新しいパスワードを再確認してください。');</script>";
            return;
        }
        // -----------------
        // データ登録
        // -----------------
        $this->wpdb->update(
            $this->wpdb->prefix.'gmt_account',
            [
                'password' => $params['new_pwd'],
            ], 
            [
                'account_attr_id' => $_SESSION['account_id'],
                'password' => $params['old_pwd']
            ]
        );


        header('Location:/mypage/?pwd=ok');
        exit();
    }

}
