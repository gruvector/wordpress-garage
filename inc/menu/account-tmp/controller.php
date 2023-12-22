<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-controller.php';
class Gm_Account_Tmp_Menu_Controller extends Gm_Abstract_List_Menu_Controller
{
    public $area_list = [];
    public $service;
    public $show_mode;

    /** コンストラクタ */
    public function __construct()
    {
        require_once plugin_dir_path(__FILE__) . 'service.php';
        $this->service = new Gm_Account_Tmp_Menu_Service();
        $table = new Gm_Account_Tmp_Menu_Table();
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
class Gm_Account_Tmp_Menu_Table extends Gm_Abstract_Menu_Table
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
            'kana' => 'カナ',
            'email' => 'メールアドレス',
            'phone' => '電話番号',
            'postal_code' => '郵便番号',
            'address_1' => '都道府県',
            'address_2' => '市区町村',
            'address_3' => '地番',
            'address_4' => '建物名・部屋番号',
            'account_attr_id' => 'アカウント属性',
            'apply_memo' => '申請時メモ',
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
        return Gm_Account_Tmp_Menu_Info::create_data($items);
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
    public function column_kana($item)
    {
        return $item->get_kana();
    }
    public function column_email($item)
    {
        return $item->get_email();
    }
    public function column_phone($item)
    {
        return $item->get_phone();
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
    public function column_account_attr_id($item)
    {
        $value = $item->get_account_attr_nm();
        if ($item->get_account_attr_id() == '9') {
            $value .= '（' . $item->get_account_attr_other() . '）';
        }
        return $value;
    }
    public function column_apply_memo($item)
    {
        return $item->get_apply_memo();
    }
    public function column_created_at($item)
    {
        return $item->get_created_at();
    }


}

class Gm_Account_Tmp_Menu_Item extends Gm_Abstract_Menu_Item
{
    public function __construct($record)
    {
        $this->ID = $record->ID;
        $this->nm = $record->nm;
        $this->kana = $record->kana;
        $this->email = $record->email;
        $this->phone = $record->phone;
        $this->postal_code = $record->postal_code;
        $this->address_1 = $record->address_1;
        $this->address_2 = $record->address_2;
        $this->address_3 = $record->address_3;
        $this->address_4 = $record->address_4;
        $this->account_attr_id = $record->account_attr_id;
        $this->account_attr_nm = $record->account_attr_nm;
        $this->account_attr_other = $record->account_attr_other;
        $this->apply_memo = $record->apply_memo;
        $this->created_at = $record->created_at;
    }

    protected $ID;
    protected $nm;
    protected $kana;
    protected $email;
    protected $phone;
    protected $postal_code;
    protected $address_1;
    protected $address_2;
    protected $address_3;
    protected $address_4;
    protected $account_attr_id;
    protected $account_attr_nm;
    protected $account_attr_other;
    protected $apply_memo;
    protected $created_at;


    public function get_ID()
    {
        return $this->ID;
    }
    public function get_nm()
    {
        return $this->nm;
    }
    public function get_kana()
    {
        return $this->kana;
    }
    public function get_email()
    {
        return $this->email;
    }
    public function get_phone()
    {
        return $this->phone;
    }
    public function get_postal_code()
    {
        return $this->postal_code;
    }
    public function get_address_1()
    {
        return $this->address_1;
    }
    public function get_address_2()
    {
        return $this->address_2;
    }
    public function get_address_3()
    {
        return $this->address_3;
    }
    public function get_address_4()
    {
        return $this->address_4;
    }
    public function get_account_attr_id()
    {
        return $this->account_attr_id;
    }
    public function get_account_attr_nm()
    {
        return $this->account_attr_nm;
    }
    public function get_account_attr_other()
    {
        return $this->account_attr_other;
    }
    public function get_apply_memo()
    {
        return $this->apply_memo;
    }
    public function get_created_at()
    {
        return $this->created_at;
    }

}

class Gm_Account_Tmp_Menu_Info extends Gm_Abstract_Menu_Info
{
    public static function create_data($records)
    {
        $items = [];
        if (is_array($records)) {
            foreach ($records as $record) {
                $items[] = new Gm_Account_Tmp_Menu_Item($record);
            }
        }
        return new Gm_Account_Tmp_Menu_Info($GLOBALS['title'], $items);
    }
}
