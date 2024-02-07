<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-controller.php';
class Gm_Price_Menu_Controller extends Gm_Abstract_List_Menu_Controller
{
    public $area_list = [];
    public $service;
    public $show_mode;
    public $show_modal = 'none';
    public $show_data;

    /** コンストラクタ */
    public function __construct()
    {
        require_once plugin_dir_path(__FILE__) . 'service.php';
        $this->service = new Gm_Price_Menu_Service();
        $table = new Gm_Price_Menu_Table();
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
            if ($_POST['process'] == 'edit') {
                $this->show_data = $this->service->edit(isset($_POST['execute_id']) ? $_POST['execute_id'] : null);
                $this->show_modal = 'block';
            } elseif ($_POST['process'] == 'show') {
                $this->show_modal = 'block';
            } elseif ($_POST['process'] == 'add') {
                $this->service->add();
            } elseif ($_POST['process1'] == 'apply') {
                $this->service->apply(isset($_POST) ? $_POST : null);
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
class Gm_Price_Menu_Table extends Gm_Abstract_Menu_Table
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
            'nm' => 'アカウントID',
            'description' => '物件ID',
            'expiry_days' => '名前',
            'price' => '区画名称',
            'campaign_price' => '空き状況',
            'campaign_from' => '引き渡し可能日',
            'campaign_to' => '最低契約期間',
            'recommend_flg' => '最低契約期間単位',
            'priority' => '横幅',
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
        return Gm_Price_Menu_Info::create_data($items);
    }

    /*******************
    / 列情報
    ********************/
    public function column_ID($item)
    {
        return <<<EOM
            <div>{$item->get_ID()}</div>
            <div class="gm-admin-button-wrap">
            <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='edit';document.getElementsByName('execute_id')[0].value='{$item->get_ID()}'; document.getElementById('gm-admin-form').submit();">編集</button>
            </div>
            EOM;

    }
    
    public function column_nm($item)
    {
        return $item->get_nm();
    }

    public function column_description($item)
    {
        return $item->get_description();
    }

    public function column_expiry_days($item)
    {
        return $item->get_expiry_days();
    }
    
    public function column_price($item)
    {
        return $item->get_price();
    }
    
    public function column_campaign_price($item)
    {
        return $item->get_campaign_price();
    }
    
    public function column_campaign_from($item)
    {
        return $item->get_campaign_from();
    }
    
    public function column_campaign_to($item)
    {
        return $item->get_campaign_to();
    }
    
    public function column_recommend_flg($item)
    {
        return $item->get_recommend_flg();
    }
    
    public function column_priority($item)
    {
        return $item->get_priority();
    }
    
    
}

class Gm_Price_Menu_Item extends Gm_Abstract_Menu_Item
{
    public function __construct($record)
    {
        $this->ID = $record->ID;
        $this->nm = $record->nm;
        $this->description = $record->description;
        $this->expiry_days = $record->expiry_days;
        $this->price = $record->price;
        $this->campaign_price = $record->campaign_price;
        $this->campaign_from = $record->campaign_from;
        $this->campaign_to = $record->campaign_to;
        $this->recommend_flg = $record->recommend_flg;
        $this->priority = $record->priority;
    }

    protected $ID;
    protected $nm;
    protected $description;
    protected $expiry_days;
    protected $price;
    protected $campaign_price;
    protected $campaign_from;
    protected $campaign_to;
    protected $recommend_flg;
    protected $priority;



    public function get_ID(){return $this->ID;}
    public function get_nm(){return $this->nm;}
    public function get_description(){return $this->description;}
    public function get_expiry_days(){return $this->expiry_days;}
    public function get_price(){return $this->price;}
    public function get_campaign_price(){return $this->campaign_price;}
    public function get_campaign_from(){return $this->campaign_from;}
    public function get_campaign_to(){return $this->campaign_to;}
    public function get_recommend_flg(){return $this->recommend_flg;}
    public function get_priority(){return $this->priority;}
    }

class Gm_Price_Menu_Info extends Gm_Abstract_Menu_Info
{
    public static function create_data($records)
    {
        $items = [];
        if (is_array($records)) {
            foreach ($records as $record) {
                $items[] = new Gm_Price_Menu_Item($record);
            }
        }
        return new Gm_Price_Menu_Info($GLOBALS['title'], $items);
    }
}
