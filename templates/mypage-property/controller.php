<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Property_Controller extends Abstract_Template_Mypage_Controller
{

    public $edit_data_from_db = [];
    public $param_id = "";
    public $param_type = "";
    public $check_box = [];
    public $image_folder = 0;
    public $bool_tmp = false;
    public $img_path = [];
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

        if ($this->param_type == "add") {} else {
            $this->edit_data_from_db = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE property_id = $this->param_id");
            if($this->edit_data_from_db == []) {
                $this->edit_data_from_db = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gmt_property_tmp WHERE property_id = $this->param_id");
                $this->bool_tmp = true;
            }
        }

        if (isset($_POST['process']) && $_POST['process'] == 'regist') {

            // File upload start
            if($_FILES["imageA"]["name"] || $_FILES["imageB"]["name"] || $_FILES["imageC"]["name"]) {
                $extensionA = pathinfo($_FILES["imageA"]["name"], PATHINFO_EXTENSION);
                $extensionB = pathinfo($_FILES["imageB"]["name"], PATHINFO_EXTENSION);
                $extensionC = pathinfo($_FILES["imageC"]["name"], PATHINFO_EXTENSION);

                $upload_dir = wp_upload_dir();
                $upload_dir_url = $upload_dir['baseurl'];
                
                $new_upload_dir = $upload_dir['baseurl'].'/image'; // Create a new directory with the current date
                if (!file_exists($new_upload_dir)) {
                    mkdir($new_upload_dir, 0777, true); // Create the directory if it doesn't exist
                }
                $imageA_path = $new_upload_dir. '/'. $_FILES["imageA"]["name"]; // Create the image path
                move_uploaded_file($_FILES["imageA"]['tmp_name'], $imageA_path);
                update_option('imageA_path', $imageA_path);

                $imageB_path = $new_upload_dir. '/'. $_FILES["imageB"]["name"]; // Create the image path
                move_uploaded_file($_FILES["imageB"]['tmp_name'], $imageB_path);
                update_option('imageB_path', $imageB_path);

                $imageC_path = $new_upload_dir. '/'. $_FILES["imageC"]["name"]; // Create the image path
                move_uploaded_file($_FILES["imageC"]['tmp_name'], $imageC_path);
                update_option('imageC_path', $imageC_path);

                // var_dump($imageA_path);
                // File Upload End
                array_push($this->img_path, $_FILES["imageA"]["name"], $_FILES["imageB"]["name"], $_FILES["imageC"]["name"]);
                $img_path_str = implode(',', $this->img_path);
            } else {
                $img_path_str = "";
            }

            // register the data
            $this->regist($_POST, $img_path_str);
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

    public function getLnt($zip){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false&key=AIzaSyAf5uy7WQJYPks2LCxQJLezYSA5m9XDHP8";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        return $result['results'][0]['geometry']['location'];
    }

    private function regist($params, $img_path_str)
    {
        // -----------------
        // start to get lat and long
        // -----------------
        $result_string = $this->getLnt($params['postal_code']);

        var_dump($result_string);
        
        // ---------------------
        // end to get lat and long
        // ----------------------
        // 
        var_dump($params);
        for ($i = 0; $i < 12 ; $i++) { 
            if(isset($params['facility_id'][$i])) {
                array_push($this->check_box, $params['facility_id'][$i]);
        }
        }
        $a = implode(",", $this->check_box);

        /***** 
         *
         *   start to get publish_to date.
         */

        
        $format_date = str_replace('/', '-', $params['handover_date']);
        var_dump(strtotime($format_date));

        switch($params['min_period_unit']) {
            case '1': $add_date = '+'.$params['min_period'].' years'; break;
            case '2': $add_date = '+'.$params['min_period'].' months'; break;
            case '3': $add_date = '+'.$params['min_period'].' days'; break;
            default: break;
        }
        $publish_date = date("Y-m-d", strtotime($add_date, strtotime($format_date)));
        var_dump($publish_date);
        /****
         * 
         * end to get publish_to date
         */

        if($this->param_type == "add") {
            $property_id_tmp = $this->wpdb->get_results( "SELECT property_id FROM {$this->wpdb->prefix}gmt_property_tmp ORDER BY property_id DESC")[0]->property_id;
            $property_id = (int) $property_id_tmp + 1;
            
            $this->wpdb->insert(
                $this->wpdb->prefix.'gmt_property_tmp',
                [
                    'nm' => $params['nm'],
                    'section_nm' => $params['section_nm'],
                    'availability_id' => $params['availability_id'],
                    'handover_date' => $params['handover_date'],
                    'min_period' => $params['min_period'],
                    'min_period_unit' => $params['min_period_unit'],
                    'property_id' => (string)$property_id,
                    'account_id' => $_SESSION['account_id'],
                    'imgs' => $img_path_str,
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
                    'postal_code' => $params['postal_code'],
                    'address_1' => $params['address_1'],
                    'address_2' => $params['address_2'],
                    'address_3' => $params['address_3'],
                    'address_4' => $params['address_4'],
                    'lat' => (string) $result_string['lat'],
                    'lng' => (string) $result_string['lng'],
                    'facility_ids' => $a,
                ]
            );

            $this->wpdb->insert(
                $this->wpdb->prefix.'gmt_property_publish',
                [
                    'property_id' => (string)$property_id,
                    'publish_from' => $params['handover_date'],
                    'publish_to' => $publish_date
                ]
            );
        }

        if ($this->param_type == "edit") {
            // var_dump($_GET['param']);
            
            $this->wpdb->update(
                $this->wpdb->prefix.'gmt_property_publish',
                [
                    'publish_from' => $params['handover_date'],
                    'publish_to' => $publish_date
                ],
                [
                    'property_id' => $this->param_id
                ]
            );

            if($this->bool_tmp) {
                $this->wpdb->update(
                    $this->wpdb->prefix.'gmt_property_tmp',
                    [
                        'nm' => $params['nm'],
                        'section_nm' => $params['section_nm'],
                        'availability_id' => $params['availability_id'],
                        'handover_date' => $params['handover_date'],
                        'min_period' => $params['min_period'],
                        'min_period_unit' => $params['min_period_unit'],
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
                        'postal_code' => $params['postal_code'],
                        'address_1' => $params['address_1'],
                        'address_2' => $params['address_2'],
                        'address_3' => $params['address_3'],
                        'address_4' => $params['address_4'],
                        'lat' => (string) $result_string['lat'],
                        'lng' => (string) $result_string['lng'],
                        'facility_ids' => $a,
                    ],
                    [
                        'property_id' => $_GET['id'],
                    ]
                );
            } else {
                $this->wpdb->update(
                    $this->wpdb->prefix.'gmt_property',
                    [
                        'nm' => $params['nm'],
                        'section_nm' => $params['section_nm'],
                        'availability_id' => $params['availability_id'],
                        'handover_date' => $params['handover_date'],
                        'min_period' => $params['min_period'],
                        'min_period_unit' => $params['min_period_unit'],
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
                        'postal_code' => $params['postal_code'],
                        'address_1' => $params['address_1'],
                        'address_2' => $params['address_2'],
                        'address_3' => $params['address_3'],
                        'address_4' => $params['address_4'],
                        'lat' => (string) $result_string['lat'],
                        'lng' => (string) $result_string['lng'],
                        'facility_ids' => $a,
                    ],
                    [
                        'property_id' => $_GET['id'],
                    ]
                );
            }
        }
        header('Location: /mypage');
        exit();
    }

}
