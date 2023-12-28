<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Property_Menu_Service extends Gm_Abstract_Menu_Service
{
    public $show_mode;

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

    public function apply($ID)
    {
        if (empty($ID)) {
            return;
        }

        global $wpdb;
        $records = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmt_property WHERE ID = {$ID}");
        if (empty($records)){
            return;
        }
        $record = $records[0];

        $password = Gm_Util::get_rand_str(8);

        $wpdb->update(
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
            $wpdb->prefix.'gmt_property',
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
            $wpdb->prefix . 'gmt_property',
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

        $add_cond .= ' AND property.remand_flg = ' . (($this->show_mode == '9') ? '1' : 0);

        global $wpdb;
        $sql =
        <<<EOM
        SELECT
            property.ID
            , property.property_id
            , property.nm
            , property.section_nm
            , property.imgs
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
            , property.remand_flg
            , property.remand_comment
            , property.created_at
        FROM
            {$wpdb->prefix}gmt_property AS property
        WHERE 1 = 1 {$add_cond}
        ORDER BY {$sql_order};
        EOM;

        $records = $wpdb->get_results($sql);
        return $records;
    }

}
