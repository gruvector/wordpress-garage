<?php

if (! defined('ABSPATH')) {
    exit;
}
abstract class Gm_Abstract_Menu_Controller
{
    public $messages = '';

    /** メッセージ追加 */
    public function set_message($message, $error = false)
    {
        if ($error) {
            $this->messages.= '<div class="error notice"><p>'.$message.'</p></div>';
        } else {
            $this->messages.= '<div class="updated notice"><p>'.$message.'</p></div>';
        }
    }
}
abstract class Gm_Abstract_List_Menu_Controller
{
    protected $service;
    public $table;
    public $list;
    protected $keys;
    public $keylist;

    /** コンストラクタ */
    public function __construct($service, $table, $keys)
    {
        $this->service = $service;
        $this->table = $table;
        $this->keys = $keys;
        $this->keylist = json_encode($this->get_keylist(), JSON_UNESCAPED_UNICODE);
    }

    /** 実行処理 */
    public function action()
    {
        $param_s = (isset($_REQUEST['s'])) ? $_REQUEST['s'] : '';
        $param_orderby = (isset($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : false;
        $param_order = (isset($_REQUEST['order'])) ? $_REQUEST['order'] : '';
        $records = $this->service->get_list($param_s, $param_orderby, $param_order);
        $this->table->prepare_items($records);
        $this->list = json_encode($this->parse_item_to_list($this->table->items), JSON_UNESCAPED_UNICODE);
        $this->render_view();
    }

    /** view表示 */
    abstract protected function render_view();

    /** キー一覧文字列生成 */
    protected function get_keylist()
    {
        $keylist = array();
        $keys = $this->keys;
        $records = $this->service->get_list_with_cond();
        foreach ($records as $record) {
            $inner = array();
            foreach ($keys as $key) {
                $inner[$key] = $record->$key;
            }
            $keylist[] = $inner;
        }
        return $keylist;
    }

    /** 一覧用アイテムからリスト生成 */
    protected function parse_item_to_list($items)
    {
        $list = array();
        foreach ($items as $i => $item) {
            $list[$i] = $item->getArray();
        }
        return $list;
    }
}
abstract class Gm_Abstract_Menu_Table extends WP_List_Table
{
    protected $keys;
    protected $per_page;

    /** コンストラクタ */
    public function __construct($keys, $per_page)
    {
        global $status, $page;
        parent::__construct(array(
            'singular'  => 'record',
            'plural'    => 'records',
            'ajax'      => true
        ));

        $this->keys = $keys;
        $this->per_page = $per_page;
    }
    /** 全体処理 */
    public function process_bulk_action()
    {
    }

    /** データ設定 */
    public function prepare_items($items = array())
    {
        $per_page = $this->per_page;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $info = $this->create_data($items);
        $data = $info->get_items();

        if (isset($_REQUEST['orderby'])) {
            function usort_reorder($a, $b)
            {
                $orderby = (isset($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : '';
                $order = (isset($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc';
                $result = strcmp($a->get($orderby), $b->get($orderby));
                return ($order==='asc') ? $result : -$result;
            }
            usort($data, 'usort_reorder');
        }

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data, (($current_page-1)*$per_page), $per_page);
        $this->items = $data;
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items/$per_page)
        ));
    }

    abstract protected function create_data($items);

    /** 行情報 */
    public function single_row($item)
    {
        $keys = $this->keys;
        $values = array();
        foreach ($keys as $key) {
            $values[] = $item->get($key);
        }
        echo sprintf(('<tr data-gm-tbl-id="%1$s">'), implode('|', $values));
        $this->single_row_columns($item);
        echo '</tr>';
    }

    /** 列情報 */
    public function column_default($item, $column_name)
    {
        return sprintf('<div data-gm-tbl-col="%1$s"></div>', $column_name);
    }
}
abstract class Gm_Abstract_Menu_Item
{
    public function get($column_name)
    {
        if (empty($column_name)) {
            return '';
        }
        return $this->$column_name;
    }

    public function getArray()
    {
        $ret = array();
        foreach ($this as $column => $value) {
            $ret[$column] = $value;
        }
        return $ret;
    }
}
abstract class Gm_Abstract_Menu_Info
{
    protected $type;
    protected $items;
    public function __construct($type, $items)
    {
        $this->type = $type;
        $this->items = $items;
    }
    public function get_items()
    {
        return $this->items;
    }
    abstract public static function create_data($records);
}
