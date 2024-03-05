<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Property_Menu_Service extends Gm_Abstract_Menu_Service
{
    public $show_mode;
    public $data_show;
    public $check_box = [];
    public $data_show1;

    

    public function __construct()
    {
        $conf = new Gm_Menu_Service_Conf();
        $conf->set_main_table('gmt_property');
        $conf->set_main_table_alias('property');
        $conf->set_add_cond_search('property.nm like \'%$s%\' OR property.postal_code like \'%$s%\' OR property.address_1 like \'%$s%\' OR property.address_2 like \'%$s%\' OR property.address_3 like \'%$s%\' OR property.address_4 like \'%$s%\'');
        $conf->set_order_init('ID DESC');

        parent::__construct($conf);
    }
    // -----------------------------------------------
    // 更新系
    // -----------------------------------------------

    public function edit($ID)
    {
        if (empty($ID)) {
            return;
        };
        $record = [];
        global $wpdb;
        $records1 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmt_property WHERE ID = {$ID}");
        $records2 = $wpdb->get_results("SELECT ID, nm FROM {$wpdb->prefix}gmm_availability order by priority");
        $records3 = $wpdb->get_results("SELECT ID, nm FROM {$wpdb->prefix}gmm_facility order by priority");
        if (empty($records1) || empty($records2)){
            return;
        }
        $record[0] = $records1[0];
        $record[1] = $records2;
        $record[2] = $records3;
        return $record;
    }

    public function edit_publish($ID) {
        if (empty($ID)) {
            return;
        };
        global $wpdb;
        $record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmt_property_publish WHERE property_id = {$ID}");
        array_push($record, $ID); 
        // var_dump($record);      
        return $record;
    }

    public function apply($ID)
    {
        if (empty($ID)) {
            return;
        }
        $this->data_show = $_POST;
        global $wpdb;
        for ($i = 0; $i < 12 ; $i++) { 
            if(isset($this->data_show['facility_id'][$i])) {
                array_push($this->check_box, $this->data_show['facility_id'][$i]);
           }
        }

        // $format_date = str_replace('/', '-', $this->data_show['handover_date']);

        // switch($this->data_show['min_period_unit']) {
        //     case '1': $add_date = '+'.$this->data_show['min_period'].' years'; break;
        //     case '2': $add_date = '+'.$this->data_show['min_period'].' months'; break;
        //     case '3': $add_date = '+'.$this->data_show['min_period'].' days'; break;
        //     default: break;
        // }
        // $publish_date = date("Y-m-d", strtotime($add_date, strtotime($format_date)));

        // $wpdb->update(
        //     $wpdb->prefix.'gmt_property_publish',
        //     [
        //         'publish_from' => $this->data_show['handover_date'],
        //         'publish_to' => $publish_date
        //     ],
        //     [
        //         'property_id' => $this->data_show['property_id']
        //     ]
        // );
        $a = implode(",", $this->check_box);
        $wpdb->update(
            $wpdb->prefix.'gmt_property',
            [
                'nm' => $this->data_show['nm'],
                'section_nm' => $this->data_show['section_nm'],
                'availability_id' => $this->data_show['availability_id'],
                'handover_date' => $this->data_show['handover_date'],
                'min_period' => $this->data_show['min_period'],
                'min_period_unit' => $this->data_show['min_period_unit'],
                'size_w' => $this->data_show['size_w'],
                'size_h' => $this->data_show['size_h'],
                'size_d' => $this->data_show['size_d'],
                'fee_monthly_rent' => $this->data_show['fee_monthly_rent'],
                'fee_monthly_common_service' => $this->data_show['fee_monthly_common_service'],
                'fee_monthly_others' => $this->data_show['fee_monthly_others'],
                'fee_contract_security' => $this->data_show['fee_contract_security'],
                'fee_contract_security_amortization' => $this->data_show['fee_contract_security_amortization'],
                'fee_contract_deposit' => $this->data_show['fee_contract_deposit'],
                'fee_contract_deposit_amortization' => $this->data_show['fee_contract_deposit_amortization'],
                'fee_contract_key_money' => $this->data_show['fee_contract_key_money'],
                'fee_contract_guarantee_charge' => $this->data_show['fee_contract_guarantee_charge'],
                'fee_contract_other' => $this->data_show['fee_contract_other'],
                'facility_ids' => $a,
                'other_description' => $this->data_show['other_description'],
                'appeal_description' => $this->data_show['appeal_description'],
                'postal_code' => $this->data_show['postal_code'],
                'address_1' => $this->data_show['address_1'],
                'address_2' => $this->data_show['address_2'],
                'address_3' => $this->data_show['address_3'],
                'address_4' => $this->data_show['address_4'],
            ],
            [
                'ID' => $this->data_show['ID1'],
            ]
        );

    }

    public function deny($ID)
    {
        if (empty($ID)) {
            return;
        }
        global $wpdb;
        $wpdb->update(
            $wpdb->prefix . 'gmt_property',
            ['status1' => '9',],
            ['ID' => $ID],
            ['%d'],
        );
    }

    public function recover($ID)
    {
        if (empty($ID)) {
            return;
        }
        
        global $wpdb;
        $wpdb->update(
            $wpdb->prefix . 'gmt_property',
            ['status1' => '1',],
            ['ID' => $ID],
            ['%d'],
        );
    }

    public function apply_publish($data) {
        if (empty($data)) {
            return;
        }
        global $wpdb;
        $this->data_show1 = $_POST;
        if ($this->data_show1['TYPE2'] == "insert") {
            $wpdb->insert(
                $wpdb->prefix.'gmt_property_publish',
                [
                    'publish_from' => $this->data_show1['publish_from'],
                    'publish_to' => $this->data_show1['publish_to'],
                    'property_id' => $this->data_show1['ID2']
                ]
            );
        } else {
            $wpdb->update(
                $wpdb->prefix . 'gmt_property_publish',
                [
                    'publish_from' => $this->data_show1['publish_from'],
                    'publish_to' => $this->data_show1['publish_to'],
                ],
                [
                    'property_id' => $this->data_show1['ID2']
                ],
            );
        }
    }

    // -----------------------------------------------
    // 参照系
    // -----------------------------------------------
    /** 一覧取得（メイン処理） */
    public function get_list_with_cond($add_cond = '', $order = '')
    {
        $sql_order = $this->order_init;
        if (!empty($order)) {
            $sql_order = $order;
        }

        $add_cond .= ' AND property.status1 = ' . (($this->show_mode == '9') ? '9' : '1');

        global $wpdb;
        $sql =
        <<<EOM
        SELECT
            property.ID
            , property.account_id
            , property.property_id
            , property.nm
            , property.section_nm
            , property.availability_id
            , property.handover_date
            , property.min_period
            , property.min_period_unit
            , property.size_w
            , property.size_h
            , property.size_d
            , property.fee_monthly_rent
            , property.fee_monthly_common_service
            , property.fee_monthly_others
            , property.fee_contract_security
            , property.fee_contract_security_amortization
            , property.fee_contract_deposit
            , property.fee_contract_deposit_amortization
            , property.fee_contract_key_money
            , property.fee_contract_guarantee_charge
            , property.fee_contract_other
            , property.facility_ids
            , property.other_description
            , property.appeal_description
            , property.postal_code
            , property.address_1
            , property.address_2
            , property.address_3
            , property.address_4
            , property.status1
            , property.created_at
        FROM
            {$wpdb->prefix}gmt_property AS property
            LEFT JOIN {$wpdb->prefix}gmm_availability AS availability
                ON property.availability_id = availability.ID
            LEFT JOIN {$wpdb->prefix}gmm_facility AS facility
                ON property.facility_ids = facility.ID
        WHERE 1 = 1 {$add_cond}
        ORDER BY {$sql_order};
        EOM;

        $records = $wpdb->get_results($sql);
        return $records;
  
    
    }

}
