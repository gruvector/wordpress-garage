<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-controller.php';
class Gm_Property_Tmp_Menu_Controller extends Gm_Abstract_List_Menu_Controller
{
    public $area_list = [];
    public $service;
    public $show_mode;

    /** コンストラクタ */
    public function __construct()
    {
        require_once plugin_dir_path(__FILE__) . 'service.php';
        $this->service = new Gm_Property_Tmp_Menu_Service();
        $table = new Gm_Property_Tmp_Menu_Table();
        $keys = array('ID');
        parent::__construct($this->service, $table, $keys);
    }

    /**
     * 実行処理
     * @override
     */
    public function action()
    {
        if (isset($_POST['process'])) {
            if ($_POST['process'] == 'apply') {
                $this->service->apply(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
            } elseif ($_POST['process'] == 'deny') {
                $this->service->deny(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
            }
        }

        $param_s = (isset($_REQUEST['s'])) ? $_REQUEST['s'] : '';
        $param_orderby = (isset($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : false;
        $param_order = (isset($_REQUEST['order'])) ? $_REQUEST['order'] : '';
        $this->show_mode = $this->service->show_mode = (isset($_REQUEST['show_mode'])) ? $_REQUEST['show_mode'] : '';

        $records = $this->service->get_list($param_s, $param_orderby, $param_order);
        $this->table->prepare_items($records);
        $list = $this->parse_item_to_list($this->table->items);
        $this->list = json_encode($list, JSON_UNESCAPED_UNICODE);
        $this->render_view();
    }

    /** view表示 */
    protected function render_view()
    {
        require plugin_dir_path(__FILE__) . '/view.php';
    }
}

/****************************************************
/ 以下、テーブル用
*****************************************************/
class Gm_Property_Tmp_Menu_Table extends Gm_Abstract_Menu_Table
{
    /** コンストラクタ */
    public function __construct()
    {
        $keys = array('ID');
        $per_page = 40;
        parent::__construct($keys, $per_page);
    }

    /** 列名 */
    public function get_columns()
    {
        $columns = array(
            'ID' => 'ID',
            'nm' => '名前',
            'imgs' => '画像',
            'property' => '物件',
            'size' => 'サイズ',
            'fee_monthly' => '月額費用',
            'fee_contract' => '契約費用',
            'other' => 'その他',
            'created_at' => '申請日時',
        );
        return $columns;
    }

    /** ソート対象 */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            // MEMO 列名 => array(カラム名, 初期ソート可否)
            'ID' => array('ID',false),
        );
        return $sortable_columns;
    }

    /** データ生成 */
    protected function create_data($items)
    {
        return Gm_Property_Tmp_Menu_Info::create_data($items);
    }

    /*******************
    / 列情報
    ********************/
    public function column_ID($item)
    {
        return <<<EOM
            <div>{$item->get_ID()}</div>
            <div class="gm-admin-button-wrap">
            <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='apply';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">承認</button>
            <button type="button" class="gm-admin-button-deny" onClick="document.getElementsByName('process')[0].value='deny';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">否認</button>
            </div>
            EOM;
    }

    public function column_nm($item)
    {
        return $item->get_nm();
    }


}

class Gm_Property_Tmp_Menu_Item extends Gm_Abstract_Menu_Item
{
    public function __construct($record)
    {
        $this->ID = $record->ID;
        $this->property_id = $record->property_id;
        $this->nm = $record->nm;
        $this->section_nm = $record->section_nm;
        $this->imgs = $record->imgs;
        $this->availability_id = $record->availability_id;
        $this->handover_date = $record->handover_date;
        $this->min_period = $record->min_period;
        $this->min_period_unit = $record->min_period_unit;
        $this->size_w = $record->size_w;
        $this->size_h = $record->size_h;
        $this->size_d = $record->size_d;
        $this->fee_monthly_rent = $record->fee_monthly_rent;
        $this->fee_monthly_common_service = $record->fee_monthly_common_service;
        $this->fee_monthly_others = $record->fee_monthly_others;
        $this->fee_contract_security = $record->fee_contract_security;
        $this->fee_contract_security_amortization = $record->fee_contract_security_amortization;
        $this->fee_contract_deposit = $record->fee_contract_deposit;
        $this->fee_contract_deposit_amortization = $record->fee_contract_deposit_amortization;
        $this->fee_contract_key_money = $record->fee_contract_key_money;
        $this->fee_contract_guarantee_charge = $record->fee_contract_guarantee_charge;
        $this->fee_contract_other = $record->fee_contract_other;
        $this->facility_ids = $record->facility_ids;
        $this->other_description = $record->other_description;
        $this->appeal_description = $record->appeal_description;
        $this->postal_code = $record->postal_code;
        $this->address_1 = $record->address_1;
        $this->address_2 = $record->address_2;
        $this->address_3 = $record->address_3;
        $this->address_4 = $record->address_4;
        $this->remand_flg = $record->remand_flg;
        $this->remand_comment = $record->remand_comment;
        
    }

    protected $ID;
    protected $property_id;
    protected $nm;
    protected $section_nm;
    protected $imgs;
    protected $availability_id;
    protected $handover_date;
    protected $min_period;
    protected $min_period_unit;
    protected $size_w;
    protected $size_h;
    protected $size_d;
    protected $fee_monthly_rent;
    protected $fee_monthly_common_service;
    protected $fee_monthly_others;
    protected $fee_contract_security;
    protected $fee_contract_security_amortization;
    protected $fee_contract_deposit;
    protected $fee_contract_deposit_amortization;
    protected $fee_contract_key_money;
    protected $fee_contract_guarantee_charge;
    protected $fee_contract_other;
    protected $facility_ids;
    protected $other_description;
    protected $appeal_description;
    protected $postal_code;
    protected $address_1;
    protected $address_2;
    protected $address_3;
    protected $address_4;
    protected $remand_flg;
    protected $remand_comment;
    

    public function get_ID(){return $this->ID;}
    public function get_property_id(){return $this->property_id;}
    public function get_nm(){return $this->nm;}
    public function get_section_nm(){return $this->section_nm;}
    public function get_imgs(){return $this->imgs;}
    public function get_availability_id(){return $this->availability_id;}
    public function get_handover_date(){return $this->handover_date;}
    public function get_min_period(){return $this->min_period;}
    public function get_min_period_unit(){return $this->min_period_unit;}
    public function get_size_w(){return $this->size_w;}
    public function get_size_h(){return $this->size_h;}
    public function get_size_d(){return $this->size_d;}
    public function get_fee_monthly_rent(){return $this->fee_monthly_rent;}
    public function get_fee_monthly_common_service(){return $this->fee_monthly_common_service;}
    public function get_fee_monthly_others(){return $this->fee_monthly_others;}
    public function get_fee_contract_security(){return $this->fee_contract_security;}
    public function get_fee_contract_security_amortization(){return $this->fee_contract_security_amortization;}
    public function get_fee_contract_deposit(){return $this->fee_contract_deposit;}
    public function get_fee_contract_deposit_amortization(){return $this->fee_contract_deposit_amortization;}
    public function get_fee_contract_key_money(){return $this->fee_contract_key_money;}
    public function get_fee_contract_guarantee_charge(){return $this->fee_contract_guarantee_charge;}
    public function get_fee_contract_other(){return $this->fee_contract_other;}
    public function get_facility_ids(){return $this->facility_ids;}
    public function get_other_description(){return $this->other_description;}
    public function get_appeal_description(){return $this->appeal_description;}
    public function get_postal_code(){return $this->postal_code;}
    public function get_address_1(){return $this->address_1;}
    public function get_address_2(){return $this->address_2;}
    public function get_address_3(){return $this->address_3;}
    public function get_address_4(){return $this->address_4;}
    public function get_remand_flg(){return $this->remand_flg;}
    public function get_remand_comment(){return $this->remand_comment;}


}

class Gm_Property_Tmp_Menu_Info extends Gm_Abstract_Menu_Info
{
    public static function create_data($records)
    {
        $items = [];
        if (is_array($records)) {
            foreach ($records as $record) {
                $items[] = new Gm_Property_Tmp_Menu_Item($record);
            }
        }
        return new Gm_Property_Tmp_Menu_Info($GLOBALS['title'], $items);
    }
}
