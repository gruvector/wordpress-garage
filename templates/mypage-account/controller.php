<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-mypage-controller.php';
class Gm_Mypage_Property_Controller extends Abstract_Template_Mypage_Controller
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
                'size_w' => $params['size_w'],
                'size_h' => $params['size_h'],
                'size_d' => $params['size_d'],
                'fee_monthly_rent' => $params['fee_monthly_rent'],
                'fee_monthly_common_service' => $params['fee_monthly_common_service'],
                'fee_monthly_others' => $params['fee_monthly_others'],
                'fee_contract_security' => $params['fee_contract_security'],
                'fee_contract_security_amortization' => $params['fee_contract_security_amortization'],
                'fee_contract_deposit' => $params['fee_contract_deposit'],
                'fee_contract_deposit_amortization' => $params['fee_contract_deposit_amortization'],
                'fee_contract_key_money' => $params['fee_contract_key_money'],
                'fee_contract_guarantee_charge' => $params['fee_contract_guarantee_charge'],
                'fee_contract_other' => $params['fee_contract_other'],
                'facility_ids' => $params['facility_ids'],
                'other_description' => $params['other_description'],
                'appeal_description' => $params['appeal_description'],
                'postal_code' => $params['postal_code'],
                'address_1' => $params['address_1'],
                'address_2' => $params['address_2'],
                'address_3' => $params['address_3'],
                'address_4' => $params['address_4'],
            ]
        );


        // -----------------
        // 画面遷移
        // -----------------
        // 画面遷移
        $url = explode('?', Gm_Util::get_url())[0];
        header('Location: ' . $url . '?mode=completed');
        exit();
    }

}
