<?php

require_once ABSPATH .'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';

class Gm_Mypage_Controller extends Abstract_Template_Mypage_Controller
{
    var $radio_value = "";
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


        $account_id = $_SESSION['account_id'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if ($_POST['public_private'] == "public" && isset($_POST['public_private'])) {
                $hello = $this->wpdb->get_results( "SELECT * FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND property_id = {$_POST['property_id_num']} ");
                if($hello == []) {}
                else
                $this->wpdb->insert(
                    $this->wpdb->prefix.'gmt_property_tmp',
                    [
                        'nm' => $hello[0]->nm,
                        'section_nm' => $hello[0]->section_nm,
                        'availability_id' => $hello[0]->availability_id,
                        'handover_date' => $hello[0]->handover_date,
                        'min_period' => $hello[0]->min_period,
                        'min_period_unit' => $hello[0]->min_period_unit,
                        'property_id' => (string)$hello[0]->property_id,
                        'account_id' => $_SESSION['account_id'],
                        'size_w' => (int) $hello[0]->size_w,
                        'size_h' => (int) $hello[0]->size_h,
                        'size_d' => (int) $hello[0]->size_d,
                        'fee_monthly_rent' => (int) $hello[0]->fee_monthly_rent,
                        'fee_monthly_common_service' => (int) $hello[0]->fee_monthly_common_service,
                        'fee_monthly_others' => $hello[0]->fee_monthly_others,
                        'fee_contract_security' => (int) $hello[0]->fee_contract_security,
                        'fee_contract_security_amortization' => (int) $hello[0]->fee_contract_security_amortization,
                        'fee_contract_deposit' => (int) $hello[0]->fee_contract_deposit,
                        'fee_contract_deposit_amortization' => (int) $hello[0]->fee_contract_deposit_amortization,
                        'fee_contract_key_money' => (int) $hello[0]->fee_contract_key_money,
                        'fee_contract_guarantee_charge' => (int) $hello[0]->fee_contract_guarantee_charge,
                        'fee_contract_other' => (int) $hello[0]->fee_contract_other,
                        'other_description' => $hello[0]->other_description,
                        'appeal_description' => $hello[0]->appeal_description,
                        'postal_code' => $hello[0]->postal_code,
                        'address_1' => $hello[0]->address_1,
                        'address_2' => $hello[0]->address_2,
                        'address_3' => $hello[0]->address_3,
                        'address_4' => $hello[0]->address_4,
                    ],
                );
                $this->wpdb->get_results("DELETE FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND property_id = {$_POST['property_id_num']}");
            };
            
            if ($_POST['public_private'] == "private") {
                $this->wpdb->update(
                    $this->wpdb->prefix.'gmt_property',
                    [
                        'status1' => "9",
                    ],
                    [
                        'account_id' => $account_id,
                        'property_id' => $_POST['property_id_num'],
                    ]
                
                );
            };
        }
        

        if(isset($_GET['propertyFilter'])){
        $this->radio_value = $_GET['propertyFilter'];
        switch($this->radio_value) {
            case "1"; default : $this->records1_1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1, property_id  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id ");$this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id");break;
            case "2" : $this->records1_1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1, property_id  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND status1 = '1'");break;
            case "3" : $this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id");break;
            case "4" : $this->records1_1 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, status1, property_id  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id AND status1 = '9'");break;
        }} else {
            $this->records1_1 = $this->wpdb->get_results( "SELECT ID, nm, status1, section_nm, property_id  FROM {$this->wpdb->prefix}gmt_property WHERE account_id = $account_id ");
            $this->records1_2 = $this->wpdb->get_results( "SELECT ID, nm, section_nm, property_id, remand_flg  FROM {$this->wpdb->prefix}gmt_property_tmp WHERE account_id = $account_id");
        }
        $this->records2 = $this->wpdb->get_results( "SELECT * FROM {$this->wpdb->prefix}gmt_property_publish");
        
        
        
        // 画面描画
        $this->render();
    }
}


