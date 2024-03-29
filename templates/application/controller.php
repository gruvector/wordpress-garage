<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Application_Controller extends Abstract_Template_Controller
{
    public $account_attr_records = [];
    public $account_other1 = false;

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
        if (isset($_GET['email_double'])) {
            if ($_GET['email_double'] == "ok") {
                echo '<script>alert("入力したメールアドレスは、既に申請済みもしくは登録済みです。")</script>';
            }
        }

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
           ['key' => 'email', 'name' => 'メールアドレス', 'len' => 255],
           ['key' => 'phone', 'name' => '電話番号', 'len' => 255],
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
            $this->account_other1 = true;
        }
        $errors = $validation->errors();
        if (!empty($errors)) {
            $this->set_input_params($params);
            $this->set_common_error($errors);
            return;
        }
        // var_dump()
        // -----------------
        // 画面遷移
        // -----------------
        $email_object1 = $this->wpdb->get_results("SELECT email FROM {$this->wpdb->prefix}gmt_account");
        $email_object2 = $this->wpdb->get_results("SELECT email FROM {$this->wpdb->prefix}gmt_account_tmp");

        $email_array = [];
        for ($i=0; $i < count($email_object1); $i++) { 
            array_push($email_array, $email_object1[$i]->email);
            // echo ($email_array);
        }
        for ($i=0; $i < count($email_object2); $i++) { 
            array_push($email_array, $email_object2[$i]->email);
            // echo ($email_array);
        }
        if(array_search($params['email'], $email_array)) {
            // var_dump($this->double_url);
            header('Location: /application?email_double=ok&v='.urlencode(Gm_Util::encrypt(json_encode($params, JSON_UNESCAPED_UNICODE))));
            exit();
        }

        $url = explode('?', Gm_Util::get_url())[0];
        if (!empty($params)) {
            if (isset($params['process'])) {
                unset($params['process']);
            }
            $url = $url . '?mode=confirm&attr_id='.$this->account_other1.'&v=' . urlencode(Gm_Util::encrypt(json_encode($params, JSON_UNESCAPED_UNICODE)));
            
        }
        // 画面遷移
        header('Location: ' . $url);

    }

    public function regist($params)
    {
        // -----------------
        // データ登録
        // -----------------
        $postal_code = $params['postal_code'];
        $email_object = $this->wpdb->get_results("SELECT email FROM {$this->wpdb->prefix}gmt_account");
        $email_array = [];
        for ($i=0; $i < count($email_object); $i++) { 
            array_push($email_array, $email_object[$i]->email);
            // echo ($email_array);
        }
        if(array_search($params['email'], $email_array)) {
            // var_dump($this->double_url);
            header('Location: /application?email_double=ok&v='.urlencode(Gm_Util::encrypt(json_encode($params, JSON_UNESCAPED_UNICODE))));
            exit();
        }
        $this->wpdb->insert(
            $this->wpdb->prefix.'gmt_account_tmp',
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
                'account_attr_other' => isset($params['account_attr_other']) ? $params['account_attr_other'] : null,
                'apply_memo' => $params['apply_memo'],
            ]
        );

        $to = 'info@ar-garage.com';
        $subject = 'アカウント申請リクエスト';
        $body = '名前が'.$params['nm'].'、メールアドレスが'.$params['email'].'のユーザーがアカウント申請をリクエストします。';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail( $to, $subject, $body, $headers );

        // -----------------
        // 画面遷移
        // -----------------
        // 画面遷移
        
        $url = explode('?', Gm_Util::get_url())[0];
        if (!empty($params)) {
            if (isset($params['process'])) {
                unset($params['process']);
            }
            $url = $url . '?mode=completed';
        }
        // 画面遷移
        header('Location: ' .$url);
        exit();
        // $url = explode('?', Gm_Util::get_url())[0];
        // header('Location: /');
        // exit();
    }
}
