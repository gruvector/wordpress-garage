<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-controller.php';
class Gm_Property_Menu_Controller extends Gm_Abstract_List_Menu_Controller
{
    public $area_list = [];
    public $service;
    public $show_mode;
    public $show_modal = 'none';
    public $show_publish_modal = 'none';
    public $show_data;
    public $show_data1;
    public $publish_id;

    /** コンストラクタ */
    public function __construct()
    {
        require_once plugin_dir_path(__FILE__) . 'service.php';
        $this->service = new Gm_Property_Menu_Service();
        $table = new Gm_Property_Menu_Table();
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

            switch ($_POST['process']) {
                case 'edit':$this->show_data = $this->service->edit(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
                            $this->show_modal = 'block';
                            break;
                case 'ban':$this->service->deny(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
                            break;
                case 'recover':$this->service->recover(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
                            break;
                case 'publish_date':$this->show_publish_modal = 'block';
                                    $this->show_data1 = $this->service->edit_publish(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
                                    break;
            }
        }

        if (isset($_POST['process1'])) {
            if ($_POST['process1'] == 'apply') {
                $this->service->apply(isset($_POST) ? $_POST : null);
            } else {
                $this->service->apply_publish(isset($_POST) ? $_POST : null);
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
class Gm_Property_Menu_Table extends Gm_Abstract_Menu_Table
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
            'account_id' => 'アカウントID',
            'property_id' => '物件ID',
            'nm' => '名前',
            'section_nm' => '区画名称',
            'availability_id' => '空き状況',
            'handover_date' => '引き渡し可能日',
            'min_period' => '最低契約期間',
            'min_period_unit' => '最低契約期間単位',
            'size_w' => '横幅',
            'size_h' => '高さ',
            'size_d' => '奥行',
            'fee_monthly_rent' => '賃料',
            'fee_monthly_common_service' => '共益費',
            'fee_monthly_others' => 'その他',
            'fee_contract_security' => '敷金',
            'fee_contract_security_amortization' => '敷金償却',
            'fee_contract_deposit' => '保証金',
            'fee_contract_deposit_amortization' => '保証金償却',
            'fee_contract_key_money' => '礼金',
            'fee_contract_guarantee_charge' => '保証料',
            'fee_contract_other' => 'その他',
            'facility_ids' => '設備情報',
            'other_description' => 'その他紹介',
            'appeal_description' => 'アピールポイント',
            'appeal_description' => '特約事項',
            'address_1' => '都道府県',
            'address_2' => '市区町村',
            'address_3' => '地番',
            'address_4' => '建物名',
            'created_at' => '登録日時',
            'updated_at' => '更新日時',

        );
        return $columns;
    }

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
        return Gm_Property_Menu_Info::create_data($items);
    }

    /*******************
    / 列情報
    ********************/
    public function column_ID($item)
    {
        if ( $item->get_status1() == '1' ) {
            return <<<EOM
                <div>{$item->get_ID()}</div>
                <div class="gm-admin-button-wrap">
                    <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='edit';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">編集</button>
                    <button type="button" class="gm-admin-button-deny" onClick="document.getElementsByName('process')[0].value='ban';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">BAN</button>
                    <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='publish_date';document.getElementsByName('execute_id')[0].value='{$item->get_property_id()}'; document.getElementById('gm-admin-form').submit();">公開期間設定</button>
                </div>
                EOM;
        } else {
            return <<<EOM
                <div>{$item->get_ID()}</div>
                <div class="gm-admin-button-wrap">
                    <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='edit';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">編集</button>
                    <button type="button" class="gm-admin-button-deny" onClick="document.getElementsByName('process')[0].value='recover';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">RECOVER</button>
                    <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='publish_date';document.getElementsByName('execute_id')[0].value='{$item->get_property_id()}'; document.getElementById('gm-admin-form').submit();">公開期間設定</button>
                </div>
                EOM;
        }
    }

    public function column_property_id($item)
    {
        return $item->get_property_id();
    }

    public function column_account_id($item)
    {
        return $item->get_account_id();
    }
    
    public function column_nm($item)
    {
        return $item->get_nm();
    }

    public function column_section_nm($item)
    {
        return $item->get_section_nm();
    }

    public function column_availability_id($item)
    {
        return $item->get_availability_id();
    }
    
    public function column_handover_date($item)
    {
        return $item->get_handover_date();
    }
    
    public function column_min_period($item)
    {
        return $item->get_min_period();
    }
    
    public function column_min_period_unit($item)
    {
        return $item->get_min_period_unit();
    }
    
    public function column_size_w($item)
    {
        return $item->get_size_w();
    }
    
    public function column_size_h($item)
    {
        return $item->get_size_h();
    }
    
    public function column_size_d($item)
    {
        return $item->get_size_d();
    }
    
    public function column_fee_monthly_rent($item)
    {
        return $item->get_fee_monthly_rent();
    }
 
    public function column_fee_monthly_common_service($item)
    {
        return $item->get_fee_monthly_common_service();
    }
 
    public function column_fee_monthly_others($item)
    {
        return $item->get_fee_monthly_others();
    }
 
    public function column_fee_contract_security($item)
    {
        return $item->get_fee_contract_security();
    }

    public function column_fee_contract_deposit($item)
    {
        return $item->get_fee_contract_deposit();
    }
 
    public function column_fee_contract_security_amortization($item)
    {
        return $item->get_fee_contract_security_amortization();
    }

    public function column_fee_contract_deposit_amortization($item)
    {
        return $item->get_fee_contract_deposit_amortization();
    }
 
    public function column_fee_contract_key_money($item)
    {
        return $item->get_fee_contract_key_money();
    }

    public function column_fee_contract_guarantee_charge($item)
    {
        return $item->get_fee_contract_guarantee_charge();
    }

    public function column_fee_contract_other($item)
    {
        return $item->get_fee_contract_other();
    }

    public function column_facility_ids($item)
    {
        return $item->get_facility_ids();
    }

    public function column_other_description($item)
    {
        return $item->get_other_description();
    }

    public function column_appeal_description($item)
    {
        return $item->get_appeal_description();
    }

    public function column_postal_code($item)
    {
        return $item->get_postal_code();
    }

    public function column_address_1($item)
    {
        return $item->get_address_1();
    }

    public function column_address_2($item)
    {
        return $item->get_address_2();
    }

    public function column_address_3($item)
    {
        return $item->get_address_3();
    }

    public function column_address_4($item)
    {
        return $item->get_address_4();
    }

    public function column_created_at($item)
    {
        return $item->get_created_at();
    }

    public function column_special_term($item)
    {
        return $item->get_special_term();
    }

}

class Gm_Property_Menu_Item extends Gm_Abstract_Menu_Item
{
    public function __construct($record)
    {
        $this->ID = $record->ID;
        $this->property_id = $record->property_id;
        $this->account_id = $record->account_id;
        $this->nm = $record->nm;
        $this->section_nm = $record->section_nm;
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
        $this->status1 = $record->status1;
        $this->created_at = $record->created_at;
        $this->special_term = $record->special_term;
    }

    protected $ID;
    protected $property_id;
    protected $account_id;
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
    protected $status1;
    protected $created_at;
    protected $special_term;


    public function get_ID(){return $this->ID;}
    public function get_property_id(){return $this->property_id;}
    public function get_account_id() {return $this->account_id;}
    public function get_nm(){return $this->nm;}
    public function get_section_nm(){return $this->section_nm;}
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
    public function get_status1(){return $this->status1;}
    public function get_created_at () {return $this->created_at;}
    public function get_special_term () {return $this->special_term;}


}

class Gm_Property_Menu_Info extends Gm_Abstract_Menu_Info
{
    public static function create_data($records)
    {
        $items = [];
        if (is_array($records)) {
            foreach ($records as $record) {
                $items[] = new Gm_Property_Menu_Item($record);
            }
        }
        return new Gm_Property_Menu_Info($GLOBALS['title'], $items);
    }
}
