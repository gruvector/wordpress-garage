<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Property_Tmp_Menu_Service extends Gm_Abstract_Menu_Service
{
    public $lat;
    public $lng;
    public $show_mode;
    public $name;
    public $apikey="";

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

    public function apply($ID, $mode)
    {
        if (empty($ID)) {
            return;
        }

        global $wpdb;

            $records = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmt_property_tmp WHERE ID = {$ID}");
            $this->apikey = $wpdb->get_results("SELECT group_map_title FROM {$wpdb->prefix}group_map WHERE group_map_id = '1'")[0]->group_map_title;
            if (empty($records)){
                return;
            }
            $record = $records[0];
            
            // get lat and lng from google api key

                // Google Maps API Key 
                $GOOGLE_API_KEY = (string)$this->apikey; 
                
                // Address from which the latitude and longitude will be retrieved 
                $address = '〒'.$record->postal_code.' '.$record->address_1.$record->address_2.$record->address_3.$record->address_4; 
                // var_dump($address);
                // Formatted address 
                $formatted_address = str_replace(' ', '+', $address); 
                
                // Get geo data from Google Maps API by address 
                $geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$formatted_address}&key={$GOOGLE_API_KEY}"); 
                
                // Decode JSON data returned by API 
                $apiResponse = json_decode($geocodeFromAddr); 
                
                // Retrieve latitude and longitude from API data 
                $latitude  = $apiResponse->results[0]->geometry->location->lat;  
                $longitude = $apiResponse->results[0]->geometry->location->lng; 

            //  end 
            if ($record->public_edit !== '1') {
                $wpdb->insert(
                    $wpdb->prefix.'gmt_property',
                    [
                        'property_id' => $record->property_id,
                        'nm' => $record->nm,
                        'imgs'=>$record->imgs,
                        'section_nm' => $record->section_nm,
                        'availability_id' => $record->availability_id,
                        'account_id' => $record->account_id,
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
                        'special_term' => $record->special_term,
                        'lat' => $latitude,
                        'lng' => $longitude,
                        'address_1' => $record->address_1,
                        'address_2' => $record->address_2,
                        'address_3' => $record->address_3,
                        'address_4' => $record->address_4,
                    ]
                );
                // $time = strtotime('01/01/1970');
                // $newformat = date('Y-m-d',$time);
                // $wpdb->insert(
                //     $wpdb->prefix.'gmt_property_publish',
                //     [
                //         'property_id' => $record->property_id,
                //         'publish_from' => $newformat,
                //         'publish_to' => $newformat
                //     ]
                // );

            } else {
                $wpdb->update(
                    $wpdb->prefix.'gmt_property',
                    [
                        'nm' => $record->nm,
                        'imgs'=>$record->imgs,
                        'section_nm' => $record->section_nm,
                        'availability_id' => $record->availability_id,
                        'account_id' => $record->account_id,
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
                        'special_term' => $record->special_term,
                        'lat' => $latitude,
                        'lng' => $longitude,
                        'address_1' => $record->address_1,
                        'address_2' => $record->address_2,
                        'address_3' => $record->address_3,
                        'address_4' => $record->address_4,
                    ], 
                    [
                        'property_id' => $record->property_id
                    ]
                );
            }

            $wpdb->delete(
                $wpdb->prefix.'gmt_property_tmp',
                ['ID' => $ID],
                ['%d'],
            );
            

        

    }

    public function deny($ID, $userInput)
    {
        // $reason = "";
        // if(isset($_COOKIE['userInput'])) {
        //     $reason = $_COOKIE['userInput'];
        //     echo $reason;  
        // }

        // var_dump($userInput);
        if (empty($ID)) {
            return;
        }

        global $wpdb;

        $wpdb->update(
            $wpdb->prefix . 'gmt_property_tmp',
            [
                'remand_flg' => 1,
                'remand_comment' => $userInput
            ],
            ['ID' => $ID],
        );

        setcookie("userInput", "", time() - 3600); 

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
        $this->show_mode == '9' ?
        $sql =
        <<<EOM
        SELECT
            property_tmp.ID
            , property_tmp.account_id
            , property_tmp.property_id
            , property_tmp.nm
            , property_tmp.imgs
            , property_tmp.section_nm
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
            , property_tmp.special_term
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
        EOM :
        $sql =
        <<<EOM
        SELECT
            property_tmp.ID
            , property_tmp.account_id
            , property_tmp.property_id
            , property_tmp.nm
            , property_tmp.section_nm
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
            , property_tmp.special_term
            , property_tmp.remand_flg
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
