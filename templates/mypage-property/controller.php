<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Property_Controller extends Abstract_Template_Mypage_Controller
{

    public $edit_data_from_db = [];
    public $param_id = "";
    public $param_type = "";
    public $check_box = [];
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
        session_start();
        if (isset($_GET['id'])) {
            $this->param_id = sanitize_key($_GET['id']);
        }

        if (isset($_GET['type'])) {
            $this->param_type = sanitize_key($_GET['type']);
        }       
        
        // -------------------
        // メイン処理
        // -------------------

        if ($this->param_type == "add") {
            if (isset($_POST['process']) && $_POST['process'] == 'check') {
                
                $_SESSION['checkbox'] = $_POST['facility_id'];
                // var_dump($_SESSION['checkbox']);
                
                $this->check($_POST);
                exit();
            }
        } else {
            $this->edit_data_from_db = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE ID = $this->param_id");
            if (isset($_POST['process']) && $_POST['process'] == 'check') {
            
                $this->check($_POST);
            }
        }

        if (isset($_POST['process']) && $_POST['process'] == 'regist') {

            // File upload start

            $extensionA = pathinfo($_FILES["imageA"]["name"], PATHINFO_EXTENSION);
            $extensionB = pathinfo($_FILES["imageB"]["name"], PATHINFO_EXTENSION);
            $extensionC = pathinfo($_FILES["imageC"]["name"], PATHINFO_EXTENSION);

            $upload_dir = wp_upload_dir();
            $upload_dir_url = $upload_dir['url'];
            
            $current_date = date('d'); 
            $new_upload_dir = $upload_dir['path'].'/'.$current_date.'/'.'image'; // Create a new directory with the current date
            var_dump($new_upload_dir);
            if (!file_exists($new_upload_dir)) {
                mkdir($new_upload_dir, 0777, true); // Create the directory if it doesn't exist
            }
            
            $imageA_path = $new_upload_dir. '/'. $_FILES["imageA"]["name"] .'.'. $extensionA; // Create the image path
            move_uploaded_file($_FILES["imageA"]['tmp_name'], $imageA_path);
            update_option('imageA_path', $imageA_path);

            $imageB_path = $new_upload_dir. '/'. $_FILES["imageB"]["name"] .'.'. $extensionB; // Create the image path
            move_uploaded_file($_FILES["imageB"]['tmp_name'], $imageB_path);
            update_option('imageB_path', $imageB_path);

            $imageC_path = $new_upload_dir. '/'. $_FILES["imageC"]["name"] .'.'. $extensionC; // Create the image path
            move_uploaded_file($_FILES["imageC"]['tmp_name'], $imageC_path);
            update_option('imageC_path', $imageC_path);

             // File Upload End

            $this->regist($this->url_params());
            exit();
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

    private function check($params)
    {
        // -----------------
        // 入力チェック
        // -----------------
        // 
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


            $url = $url . '?mode=confirm&type=edit&v=' . urlencode(Gm_Util::encrypt(json_encode($params, JSON_UNESCAPED_UNICODE)));
        }

        
        // 画面遷移
        header('Location: ' . $url);
        exit();
    }

    private function regist($params)
    {
        // -----------------
        // start to get lat and long
        // -----------------

        // $lnt_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($params['postal_code'])."&key=AIzaSyAb8pareaW9BgBJF52KiPbsyoljqKO9_C0";
        // $result_string = file_get_contents($lnt_url);
        // var_dump($result_string);

        // $result = json_decode($result_string, true);
        // $result1[]=$result['results'][0];
        // $result2[]=$result1[0]['geometry'];
        // $result3[]=$result2[0]['location'];
        
        // ---------------------
        // end to get lat and long
        // ----------------------
        // 
        $postal_code = $params['postal_code1'] ."-". $params['postal_code2'];

        $this->wpdb->insert(
            $this->wpdb->prefix.'gmt_property_tmp',
            [
                'nm' => $params['nm'],
                'section_nm' => $params['section_nm'],
                'availability_id' => $params['availability_id'],
                'handover_date' => $params['handover_date'],
                'min_period' => $params['min_period'],
                'min_period_unit' => $params['min_period_unit'],
                'account_id' => $_SESSION['account_id'],
                'size_w' => (int) $params['size_w'],
                'size_h' => (int) $params['size_h'],
                'size_d' => (int) $params['size_d'],
                'fee_monthly_rent' => (int) $params['fee_monthly_rent'],
                'fee_monthly_common_service' => (int) $params['fee_monthly_common_service'],
                'fee_monthly_others' => $params['fee_monthly_others'],
                'fee_contract_security' => (int) $params['fee_contract_security'],
                'fee_contract_security_amortization' => (int) $params['fee_contract_security_amortization'],
                'fee_contract_deposit' => (int) $params['fee_contract_deposit'],
                'fee_contract_deposit_amortization' => (int) $params['fee_contract_deposit_amortization'],
                'fee_contract_key_money' => (int) $params['fee_contract_key_money'],
                'fee_contract_guarantee_charge' => (int) $params['fee_contract_guarantee_charge'],
                'fee_contract_other' => (int) $params['fee_contract_other'],
                'other_description' => $params['other_description'],
                'appeal_description' => $params['appeal_description'],
                'postal_code' => $postal_code,
                'address_1' => $params['address_1'],
                'address_2' => $params['address_2'],
                'address_3' => $params['address_3'],
                'address_4' => $params['address_4'],
            ]
        );
        $url = explode('?', Gm_Util::get_url())[0];
        header('Location: ' . $url . '?mode=completed');
        exit();
    }

}
