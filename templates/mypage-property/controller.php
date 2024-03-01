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
        // session_start();

        if (isset($_GET['type'])) {
            $this->param_type = sanitize_key($_GET['type']);
            if ($this->param_type == "edit") {
                $this->param_id = base64_decode($_GET['id']);
            }

            // var_dump($this->param_id);
        }       

        $accountid = $_SESSION['account_id'];

        
        // -------------------
        // メイン処理
        // -------------------

        if ($this->param_type == "add") {} else {
            $this->edit_data_from_db = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE property_id=%d AND account_id=%d", $this->param_id, $accountid));
            if($this->edit_data_from_db == []) {
                $this->edit_data_from_db = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM {$this->wpdb->prefix}gmt_property_tmp WHERE property_id=%d AND account_id=%d", $this->param_id, $accountid));
                $this->bool_tmp = true;
                if ($this->edit_data_from_db == []) {
                    header('Location:/mypage');
                }
            }
        }

        if (isset($_POST['process']) && $_POST['process'] == 'regist') {
            // $property_id_mypage = "property_id_mypage";
            // $this->param_id = $_COOKIE[$property_id_mypage];
            // File upload start
            // if($_FILES["imageA"]["name"] || $_FILES["imageB"]["name"] || $_FILES["imageC"]["name"] || $_FILES["imageD"]["name"] || $_FILES["imageE"]["name"]) {
                $extensionA = pathinfo($_FILES["imageA"]["name"], PATHINFO_EXTENSION);
                $extensionB = pathinfo($_FILES["imageB"]["name"], PATHINFO_EXTENSION);
                $extensionC = pathinfo($_FILES["imageC"]["name"], PATHINFO_EXTENSION);
                $extensionD = pathinfo($_FILES["imageD"]["name"], PATHINFO_EXTENSION);
                $extensionE = pathinfo($_FILES["imageE"]["name"], PATHINFO_EXTENSION);
                $extensionF = pathinfo($_FILES["imageF"]["name"], PATHINFO_EXTENSION);
                $extensionG = pathinfo($_FILES["imageG"]["name"], PATHINFO_EXTENSION);
                $extensionH = pathinfo($_FILES["imageH"]["name"], PATHINFO_EXTENSION);
                $extensionI = pathinfo($_FILES["imageI"]["name"], PATHINFO_EXTENSION);
                $extensionJ = pathinfo($_FILES["imageJ"]["name"], PATHINFO_EXTENSION);

                if ($this->param_type == "add") {
                    $property_id_tmp_1 = $this->wpdb->get_results( "SELECT property_id FROM {$this->wpdb->prefix}gmt_property_tmp ORDER BY property_id DESC")[0]->property_id;
                    $property_id_1 = (int) $property_id_tmp_1 + 1;
                } else {
                    $property_id_1 = $_POST['property_id'];
                }

                $fileNameA = base64_encode($_FILES["imageA"]["name"]).'.'.$extensionA;
                $fileNameB = base64_encode($_FILES["imageB"]["name"]).'.'.$extensionB;
                $fileNameC = base64_encode($_FILES["imageC"]["name"]).'.'.$extensionC;
                $fileNameD = base64_encode($_FILES["imageD"]["name"]).'.'.$extensionD;
                $fileNameE = base64_encode($_FILES["imageE"]["name"]).'.'.$extensionE;
                $fileNameF = base64_encode($_FILES["imageF"]["name"]).'.'.$extensionF;
                $fileNameG = base64_encode($_FILES["imageG"]["name"]).'.'.$extensionG;
                $fileNameH = base64_encode($_FILES["imageH"]["name"]).'.'.$extensionH;
                $fileNameI = base64_encode($_FILES["imageI"]["name"]).'.'.$extensionI;
                $fileNameJ = base64_encode($_FILES["imageJ"]["name"]).'.'.$extensionJ;

                $upload_dir_url = $_SERVER['DOCUMENT_ROOT'];
                $new_upload_dir = $upload_dir_url.'/wp-content/uploads/gm-property/'.$property_id_1.'/'; // Create a new directory with the current date
                if (!file_exists($new_upload_dir)) {
                    mkdir($new_upload_dir, 0777, true); // Create the directory if it doesn't exist
                }
                $imageA_path = $new_upload_dir. $fileNameA; // Create the image path
                move_uploaded_file($_FILES["imageA"]['tmp_name'], $imageA_path);
                update_option('imageA_path', $imageA_path);

                $imageB_path = $new_upload_dir. $fileNameB; // Create the image path
                move_uploaded_file($_FILES["imageB"]['tmp_name'], $imageB_path);
                update_option('imageB_path', $imageB_path);

                $imageC_path = $new_upload_dir. $fileNameC; // Create the image path
                move_uploaded_file($_FILES["imageC"]['tmp_name'], $imageC_path);
                update_option('imageC_path', $imageC_path);

                $imageD_path = $new_upload_dir. $fileNameD; // Create the image path
                move_uploaded_file($_FILES["imageD"]['tmp_name'], $imageD_path);
                update_option('imageD_path', $imageD_path);

                $imageE_path = $new_upload_dir. $fileNameE; // Create the image path
                move_uploaded_file($_FILES["imageE"]['tmp_name'], $imageE_path);
                update_option('imageE_path', $imageE_path);

                $imageF_path = $new_upload_dir. $fileNameF; // Create the image path
                move_uploaded_file($_FILES["imageF"]['tmp_name'], $imageF_path);
                update_option('imageF_path', $imageF_path);

                $imageG_path = $new_upload_dir. $fileNameG; // Create the image path
                move_uploaded_file($_FILES["imageG"]['tmp_name'], $imageG_path);
                update_option('imageG_path', $imageG_path);

                $imageH_path = $new_upload_dir. $fileNameH; // Create the image path
                move_uploaded_file($_FILES["imageH"]['tmp_name'], $imageH_path);
                update_option('imageH_path', $imageH_path);

                $imageI_path = $new_upload_dir. $fileNameI; // Create the image path
                move_uploaded_file($_FILES["imageI"]['tmp_name'], $imageI_path);
                update_option('imageI_path', $imageI_path);

                $imageJ_path = $new_upload_dir. $fileNameJ; // Create the image path
                move_uploaded_file($_FILES["imageJ"]['tmp_name'], $imageJ_path);
                update_option('imageJ_path', $imageJ_path);

                // var_dump($imageA_path);
                // File Upload End
                // $img_path_array = explode(',', $this->edit_data_from_db[0]->imgs);
                // var_dump($img_path_array);
                $hidden_photoA = $fileNameA != "." ? $fileNameA : $_POST['hidden_photoA'];
                $hidden_photoB = $fileNameB != "." ? $fileNameB : $_POST['hidden_photoB'];
                $hidden_photoC = $fileNameC != "." ? $fileNameC : $_POST['hidden_photoC'];
                $hidden_photoD = $fileNameD != "." ? $fileNameD : $_POST['hidden_photoD'];
                $hidden_photoE = $fileNameE != "." ? $fileNameE : $_POST['hidden_photoE'];
                $hidden_photoF = $fileNameF != "." ? $fileNameF : $_POST['hidden_photoF'];
                $hidden_photoG = $fileNameG != "." ? $fileNameG : $_POST['hidden_photoG'];
                $hidden_photoH = $fileNameH != "." ? $fileNameH : $_POST['hidden_photoH'];
                $hidden_photoI = $fileNameI != "." ? $fileNameI : $_POST['hidden_photoI'];
                $hidden_photoJ = $fileNameJ != "." ? $fileNameJ : $_POST['hidden_photoJ'];
                array_push($this->img_path, 
                    $hidden_photoA, 
                    $hidden_photoB, 
                    $hidden_photoC, 
                    $hidden_photoD, 
                    $hidden_photoE,
                    $hidden_photoF, 
                    $hidden_photoG, 
                    $hidden_photoH, 
                    $hidden_photoI, 
                    $hidden_photoJ,
                );
                $img_path_str = implode(',', $this->img_path);

            // }

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

    private function regist($params, $img_path_str)
    {
        // -----------------
        // start to get lat and long
        // -----------------
        // $result_string = $this->getLnt($params['postal_code']);

        var_dump($img_path_str);
        
        // ---------------------
        // end to get lat and long
        // ----------------------
        // 
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

        

        switch($params['min_period_unit']) {
            case '1': $add_date = '+'.$params['min_period'].' years'; break;
            case '2': $add_date = '+'.$params['min_period'].' months'; break;
            case '3': $add_date = '+'.$params['min_period'].' days'; break;
            default: break;
        }
        $publish_date = date("Y/m/d", strtotime($add_date, strtotime($format_date)));
        /****
         * 
         * end to get publish_to date
         */


        if($this->param_type == "add") {
            $property_id_tmp1 = $this->wpdb->get_results( "SELECT property_id FROM {$this->wpdb->prefix}gmt_property_tmp ORDER BY property_id DESC")[0]->property_id;
            $property_id_tmp2 = $this->wpdb->get_results( "SELECT property_id FROM {$this->wpdb->prefix}gmt_property ORDER BY property_id DESC")[0]->property_id;
            
            $property_id = (int)$property_id_tmp1 > (int)$property_id_tmp2 ? (int) $property_id_tmp1 + 1 : $property_id_tmp2+1;

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
                    'fee_contract_other' =>  $params['fee_contract_other'],
                    'other_description' => $params['other_description'],
                    'appeal_description' => $params['appeal_description'],
                    'postal_code' => $params['postal_code'],
                    'address_1' => $params['address_1'],
                    'address_2' => $params['address_2'],
                    'address_3' => $params['address_3'],
                    'address_4' => $params['address_4'],
                    // 'lat' => (string) $result_string['lat'],
                    // 'lng' => (string) $result_string['lng'],
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
                        'imgs' => $img_path_str,
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
                        'fee_contract_other' => $params['fee_contract_other'],
                        'other_description' => $params['other_description'],
                        'appeal_description' => $params['appeal_description'],
                        'postal_code' => $params['postal_code'],
                        'address_1' => $params['address_1'],
                        'address_2' => $params['address_2'],
                        'address_3' => $params['address_3'],
                        'address_4' => $params['address_4'],
                        // 'lat' => (string) $result_string['lat'],
                        // 'lng' => (string) $result_string['lng'],
                        'facility_ids' => $a,
                    ],
                    [
                        'property_id' => $this->param_id,
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
                        'fee_contract_other' => $params['fee_contract_other'],
                        'other_description' => $params['other_description'],
                        'appeal_description' => $params['appeal_description'],
                        'postal_code' => $params['postal_code'],
                        'address_1' => $params['address_1'],
                        'address_2' => $params['address_2'],
                        'address_3' => $params['address_3'],
                        'address_4' => $params['address_4'],
                        // 'lat' => (string) $result_string['lat'],
                        // 'lng' => (string) $result_string['lng'],
                        'facility_ids' => $a,
                    ],
                    [
                        'property_id' => $this->param_id,
                    ]
                );
            }
        }
        header('Location: /mypage/?propertyFilter=1');
        exit();
    }

}
