<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Account_Controller extends Abstract_Template_Mypage_Controller
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
        $this->availability_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_account_attr order by priority");
        // 画面描画
        $this->render();
    }

    private function check($params)
    {
        // -----------------
        // 入力チェック
        // -----------------
        $validation = new Gm_Validation($params);

        $errors = $validation->errors();
        if (!empty($errors)) {
            $this->set_input_params($params);
            $this->set_common_error($errors);
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
        $this->wpdb->insert(
            $this->wpdb->prefix.'gmt_account_tmp',
            [
                'nm' => $params['account_nm'],
                'email' => $params['account_email'],
                'phone' => $params['account_tel'],
                'address' => $params['account_'],
                'nm' => $params['account_nm'],
                'nm' => $params['account_nm'],
            ]
        );

        

        // -----------------
        // 画面遷移

        $url = explode('?', Gm_Util::get_url())[0];
        header('Location: ' . $url . '?mode=completed');
        exit();
    }

}
