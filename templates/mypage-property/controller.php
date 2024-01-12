<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Property_Controller extends Abstract_Template_Mypage_Controller
{

    public $edit_data_from_db = [];
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

        if (isset($_GET['id'])) {
            $param_id = sanitize_key($_GET['id']);
        }

        if (isset($_GET['type'])) {
            $param_type = sanitize_key($_GET['type']);
        }       
        
        // -------------------
        // メイン処理
        // -------------------

        if ($param_type == "add") {
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
            };
    
            $this->availability_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_availability order by priority");
            $this->facility_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_facility order by priority");
    
            // 画面描画
            $this->render();
        } else if ($param_type == "edit") {
            $this->edit_data_from_db = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE ID = $param_id");

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
            };
    
            $this->availability_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_availability order by priority");
            $this->facility_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_facility order by priority");
    
            // 画面描画
            $this->render();
        }
        
    }

    private function objectToObject($instance, $className) {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
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
            $this->wpdb->prefix.'gmt_property_tmp',
            [
                // 'property_id' => $params['property_id'],
                'nm' => $params['nm'],
                'section_nm' => $params['section_nm'],
                'imgs' => $params['imgs'],
                'availability_id' => $params['availability_id'],
                'handover_date' => $params['handover_date'],
                'min_period' => $params['min_period'],
                'min_period_unit' => $params['min_period_unit'],
                'account_id' => $_SESSION['account_id'],
            ]
        );

        
        $url = explode('?', Gm_Util::get_url())[0];
        header('Location: ' . $url . '?mode=completed');
        exit();
    }

}
