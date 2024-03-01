<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Account_Controller extends Abstract_Template_Mypage_Controller

{
    public $account_attr_records = [];
    public $account_other = false;
    public $display_data = [];

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
        $this->account_attr_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_account_attr order by priority");
        $this->display_data = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_account WHERE ID = {$_SESSION['account_id']}");
        $this->render();
    }

    private function check($params)
    {
        // -----------------
        // 入力チェック
        // -----------------
        $validation = new Gm_Validation($params);
        $validation->required([
            ['key' => 'nm', 'name' => '名前',],
            ['key' => 'kana', 'name' => 'カナ',],
            ['key' => 'email', 'name' => 'メールアドレス',],
            ['key' => 'phone', 'name' => '電話番号',],
            ['key' => 'postal_code', 'name' => '郵便番号',],
            ['key' => 'address_1', 'name' => '都道府県',],
            ['key' => 'address_2', 'name' => '市区町村',],
            ['key' => 'address_3', 'name' => '地番',],
            ['key' => 'account_attr_id', 'name' => 'アカウント属性',],
         ]);
        $validation->length([
           ['key' => 'nm', 'name' => '名前', 'len' => 255],
           ['key' => 'kana', 'name' => 'カナ', 'len' => 255],
         ]);
        $validation->zen_katakana([
           ['key' => 'kana', 'name' => 'カナ',],
         ]);
        $validation->email([
           ['key' => 'email', 'name' => 'メールアドレス',],
         ]);
        $validation->phone([
          ['key' => 'phone', 'name' => '電話番号',],
        ]);

        $validation->numeric([
          ['key' => 'account_attr_id', 'name' => 'アカウント属性',],
        ]);

        if ($params['account_attr_id'] == '9') {
            $validation->required([
                ['key' => 'account_attr_other', 'name' => 'アカウント属性その他',],
            ]);
            $validation->length([
                ['key' => 'account_attr_other', 'name' => 'アカウント属性その他', 'len' => 255],
            ]);
            
            $this->account_other = true;
        }

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
            $url = $url . '?mode=confirm&attr_id='.$this->account_other.'&v=' . urlencode(Gm_Util::encrypt(json_encode($params, JSON_UNESCAPED_UNICODE)));
        }
        // 画面遷移
        header('Location: ' . $url);

    }

    private function regist($params)
    {
        // -----------------
        // データ登録
        // -----------------
        var_dump($params['account_attr_id']);
        $postal_code = $params['postal_code'];
        $this->wpdb->update(
            $this->wpdb->prefix.'gmt_account',
            [
                'nm' => $params['nm'],
                'kana' => $params['kana'],
                'email' => $params['email'],
                'phone' => $params['phone'],
                'postal_code' => $postal_code,
                'address_1' => $params['address_1'],
                'address_2' => $params['address_2'],
                'address_3' => $params['address_3'],
                'address_4' => $params['address_4'],
                'account_attr_id' => $params['account_attr_id'],
                'account_attr_other' => $params['account_attr_other'] ? $params['account_attr_other'] : null,
                'apply_memo' => $params['apply_memo'],
            ],
            [
                'ID' => $_SESSION['account_id']
            ]
        );


        // -----------------
        // 画面遷移
        // -----------------
        // 画面遷移
        $url = explode('?', Gm_Util::get_url())[0];
        header('Location: /mypage/?propertyFilter=1');
        
        exit();
    }
}
