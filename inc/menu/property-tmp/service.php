<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Property_Tmp_Menu_Service extends Gm_Abstract_Menu_Service
{
    public $show_mode;

    public function __construct()
    {
        $conf = new Gm_Menu_Service_Conf();
        $conf->set_main_table('gmt_property_tmp');
        $conf->set_main_table_alias('property_tmp');
        $conf->set_add_cond_search('property_tmp.nm like \'%$s%\' OR property_tmp.postal_code like \'%$s%\' OR property_tmp.address_1 like \'%$s%\' OR property_tmp.address_2 like \'%$s%\' OR property_tmp.address_3 like \'%$s%\' OR property_tmp.address_4 like \'%$s%\'');
        $conf->set_order_init('ID DESC');

        parent::__construct($conf);
    }
    // -----------------------------------------------
    // 更新系
    // -----------------------------------------------

    public function apply($ID)
    {
        if (empty($ID)) {
            return;
        }

        global $wpdb;
        $records = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmt_property_tmp WHERE ID = {$ID}");
        if (empty($records)){
            return;
        }
        $record = $records[0];

        $password = Gm_Util::get_rand_str(8);

        $wpdb->insert(
            $wpdb->prefix.'gmt_property',
            [
                // 'property_id' => $record->property_id,
                'nm' => $record->nm,
                'section_nm' => $record->section_nm,
                'imgs' => $record->imgs,
                'availability_id' => $record->availability_id,
                'handover_date' => $record->handover_date,
                'min_period' => $record->min_period,
                'min_period_unit' => $record->min_period_unit,
                'size_w' => $record->size_w,
                'size_h' => $record->size_h,
                'size_d' => $record->size_d,
                'fee_monthly_rent' => $record->fee_monthly_rent,
                'fee_monthly_common_service' => $record->fee_monthly_common_service,
                'fee_monthly_others' => $record->fee_monthly_others,
                'fee_contract_security' => $record->fee_contract_security,
                'fee_contract_security_amortization' => $record->fee_contract_security_amortization,
                'fee_contract_deposit' => $record->fee_contract_deposit,
                'fee_contract_deposit_amortization' => $record->fee_contract_deposit_amortization,
                'fee_contract_key_money' => $record->fee_contract_key_money,
                'fee_contract_guarantee_charge' => $record->fee_contract_guarantee_charge,
                'fee_contract_other' => $record->fee_contract_other,
                'facility_ids' => $record->facility_ids,
                'other_description' => $record->other_description,
                'appeal_description' => $record->appeal_description,
                'postal_code' => $record->postal_code,
                'address_1' => $record->address_1,
                'address_2' => $record->address_2,
                'address_3' => $record->address_3,
                'address_4' => $record->address_4,
            ]
        );

        $wpdb->delete(
            $wpdb->prefix.'gmt_property_tmp',
            ['ID' => $ID],
            ['%d'],
        );
    }

    public function deny($ID)
    {
        if (empty($ID)) {
            return;
        }

        global $wpdb;

        $wpdb->update(
            $wpdb->prefix . 'gmt_property_tmp',
            ['del_flg' => 1,],
            ['ID' => $ID],
            ['%d'],
            ['%d'],
        );

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

        $add_cond .= ' AND property_tmp.remand_flg = ' . (($this->show_mode == '9') ? '1' : 0);

        global $wpdb;
        $sql =
<<<EOM
SELECT
  	  property_tmp.ID
	, property_tmp.property_id
	, property_tmp.nm
	, property_tmp.section_nm
	, property_tmp.imgs
	, property_tmp.availability_id
	, property_tmp.handover_date
	, property_tmp.min_period
	, property_tmp.min_period_unit
	, property_tmp.size_w
	, property_tmp.size_h
	, property_tmp.size_d
	, property_tmp.fee_monthly_rent
	, property_tmp.fee_monthly_common_service
	, property_tmp.fee_monthly_others
	, property_tmp.fee_contract_security
	, property_tmp.fee_contract_security_amortization
	, property_tmp.fee_contract_deposit
	, property_tmp.fee_contract_deposit_amortization
	, property_tmp.fee_contract_key_money
	, property_tmp.fee_contract_guarantee_charge
	, property_tmp.fee_contract_other
	, property_tmp.facility_ids
	, property_tmp.other_description
	, property_tmp.appeal_description
	, property_tmp.postal_code
	, property_tmp.address_1
	, property_tmp.address_2
	, property_tmp.address_3
	, property_tmp.address_4
	, property_tmp.remand_flg
	, property_tmp.remand_comment
	, property_tmp.created_at
FROM
	{$wpdb->prefix}gmt_property_tmp AS property_tmp
WHERE 1 = 1 {$add_cond}
ORDER BY {$sql_order};
EOM;

        $records = $wpdb->get_results($sql);
        return $records;
    }

}
