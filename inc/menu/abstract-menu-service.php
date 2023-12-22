<?php

if (! defined('ABSPATH')) {
    exit;
}
class Gm_Menu_Service_Conf
{
    private $main_table = '';
    private $main_table_alias = '';
    private $auto_increment = false;
    private $add_cond_search = '';
    private $order_init = '';
    private $exclude_params = array();
    private $related_prod_cache = false;
    private $has_created = false;
    private $has_updated = false;

    public function set_main_table($value)
    {
        $this->main_table = $value;
    }
    public function set_main_table_alias($value)
    {
        $this->main_table_alias = $value;
    }
    public function set_auto_increment($value)
    {
        $this->auto_increment = $value;
    }
    public function set_add_cond_search($value)
    {
        $this->add_cond_search = $value;
    }
    public function set_order_init($value)
    {
        $this->order_init = $value;
    }
    public function set_exclude_params($value)
    {
        $this->exclude_params = $value;
    }
    public function set_related_prod_cache($value)
    {
        $this->related_prod_cache = $value;
    }
    public function set_has_created($value)
    {
        $this->has_created = $value;
    }
    public function set_has_updated($value)
    {
        $this->has_updated = $value;
    }

    public function get_main_table()
    {
        return $this->main_table;
    }
    public function get_main_table_alias()
    {
        return $this->main_table_alias;
    }
    public function get_auto_increment()
    {
        return $this->auto_increment;
    }
    public function get_add_cond_search()
    {
        return ' AND (' .$this->add_cond_search. ') ';
    }
    public function get_order_init()
    {
        return $this->order_init;
    }
    public function get_exclude_params()
    {
        return $this->exclude_params;
    }
    public function get_related_prod_cache()
    {
        return $this->related_prod_cache;
    }
    public function get_has_created()
    {
        return $this->has_created;
    }
    public function get_has_updated()
    {
        return $this->has_updated;
    }
}
abstract class Gm_Abstract_Menu_Service
{
    // -----------------------------------------------
    // プロパティ
    // -----------------------------------------------
    // 初期プロパティ
    protected $main_table;
    protected $main_table_alias;
    protected $auto_increment;
    protected $add_cond_search;
    protected $order_init;
    protected $exclude_params;
    protected $related_prod_cache;
    protected $has_created;
    protected $has_updated;

    // メンバ変数
    protected $last_insert_id;
    public function __construct($conf)
    {
        $this->main_table = $conf->get_main_table();
        $this->main_table_alias = $conf->get_main_table_alias();
        $this->auto_increment = $conf->get_auto_increment();
        $this->add_cond_search = $conf->get_add_cond_search();
        $this->order_init = $conf->get_order_init();
        $this->exclude_params = $conf->get_exclude_params();
        $this->related_prod_cache = $conf->get_related_prod_cache();
        $this->has_created = $conf->get_has_created();
        $this->has_updated = $conf->get_has_updated();
    }

    // -----------------------------------------------
    // 更新系
    // -----------------------------------------------
    /** SQL実行 */
    public function execute($mode, $keys, $params)
    {
        global $wpdb;
        $data_keys = array();
        $data_params_upd = array();
        $data_params_ins = array();
        $add_cond = '';
        $this->parse_text($params, true);
        foreach ($params as $col => $data) {
            if (!in_array($col, $this->exclude_params)) {
                if (in_array($col, $keys)) {
                    $data_keys[$col] = $this->parse_id($data);
                } else {
                    $data_params_upd[$col] = $data;
                }
                $data_params_ins[$col] = $data;
            }
        }

        $message = '';
        $cnt_after = 1;
        $wpdb->query('START TRANSACTION');
        $message = $this->pre_query($wpdb, $mode, $keys, $params);
        if ($message) {
            $this->error_log($wpdb, $message);
            $wpdb->query("ROLLBACK");
            return $message;
        }

        $message = '';
        switch ($mode) {
            case 'delete':
                $cnt_after = 0;
                $wpdb->delete($wpdb->prefix.$this->main_table, $data_keys, array('%s'));
                $add_cond = $this->get_execute_add_cond($wpdb, $data_keys, false);
                if ($wpdb->last_error) {
                    $message = 'データの削除に失敗しました。しばらくしてから再度お試しください。';
                }
            break;
            case 'update':
                $date = current_time('mysql');
                if ($this->has_updated){
                    $data_params_upd['updated'] = $date;
                }

                $wpdb->update($wpdb->prefix.$this->main_table, $data_params_upd, $data_keys);
                $add_cond = $this->get_execute_add_cond($wpdb, $data_keys, false);
                if ($wpdb->last_error) {
                    $message = 'データの更新に失敗しました。内容を確認のうえ再度お試しください。';
                }
            break;
            case 'regist':
                $date = current_time('mysql');
                if ($this->has_created){
                    $data_params_ins['created'] = $date;
                }
                if ($this->has_updated){
                    $data_params_ins['updated'] = $date;
                }

                $wpdb->insert($wpdb->prefix.$this->main_table, $data_params_ins);
                $this->set_last_insert_id($wpdb);
                $add_cond = $this->get_execute_add_cond($wpdb, $data_keys, true);
                if ($wpdb->last_error) {
                    $message = 'データの登録に失敗しました。内容を確認のうえ再度お試しください。';
                }
                break;
        }
        if ($message) {
            $this->error_log($wpdb, $message);
            $wpdb->query("ROLLBACK");
            return $message;
        }

        $message = $this->post_query($wpdb, $mode, $keys, $params);
        if ($message) {
            $this->error_log($wpdb, $message);
            $wpdb->query("ROLLBACK");
            return $message;
        }
        $wpdb->query("COMMIT");

        $records = $this->get_list_with_cond($add_cond);
        if (count($records) != $cnt_after) {
            return '不正なエラーを検知しました。';
        }

        $record = $this->formatRecord($mode, $keys, $params, $records);
        return $record;
    }

    /** メインテーブル更新前の処理（拡張時はOVERRIDE） */
    protected function pre_query(&$wpdb, $mode, $keys, $params)
    {
        return '';
    }

    /** メインテーブル更新後の処理（拡張時はOVERRIDE） */
    protected function post_query(&$wpdb, $mode, $keys, $params)
    {
        return '';
    }

    /** レコード整形（拡張時はOVERRIDE） */
    protected function formatRecord($mode, $keys, $params, $records)
    {
        return $records[0];
    }

    // -----------------------------------------------
    // 参照系
    // -----------------------------------------------
    /** 一覧取得 */
    public function get_list($s = '', $orderby = '', $order = '', $ex = null)
    {
        $add_cond = empty($s) ? '' : preg_replace('/\$s/', $s, $this->add_cond_search);
        $add_cond.= $this->get_add_cond_ex($ex);
        
        $order = $orderby.' '.$order;
        if (empty($orderby)) {
            $order = $this->order_init;
        }

        $records = $this->get_list_with_cond($add_cond, $order);
        return $records;
    }
    
    /** 追加の検索条件（拡張時はOVERRIDE） */
    public function get_add_cond_ex($ex)
    {
        return '';
    }

    /** 一覧取得（メイン処理） */
    abstract public function get_list_with_cond($add_cond = '', $order = '');

    // -----------------------------------------------
    // 共通
    // -----------------------------------------------
    /** ajaxでエスケープされた\"を通常の値に戻す */
    protected function parse_text(&$params, $encode)
    {
        // 変換対象が無ければリターン
        foreach ($params as $col => $data) {
            $parse = str_replace('\"', '"', $data);
            $parse = str_replace("\'", "'", $parse);
            $params[$col] = $parse;
        }
    }
    /** ID値の変換 */
    protected function parse_id($id)
    {
        if ($this->auto_increment && empty($id)) {
            return null;
        }
        return $id;
    }

    /** 更新系実行後の検索条件取得 */
    protected function set_last_insert_id(&$wpdb)
    {
        $records = $wpdb->get_results('SELECT LAST_INSERT_ID() AS LAST_INSERT_ID;');
        // AUTO_INCREMENTの場合は、キーは必ず１つ。LAST_INSERT_ID()は必ず返却される。
        $this->last_insert_id = $records[0]->LAST_INSERT_ID;
    }

    /** 更新系実行後の検索条件取得 */
    protected function get_execute_add_cond(&$wpdb, $data_keys, $regist)
    {
        $ret = '';
        $flg = $regist && $this->auto_increment;

        $alias = empty($this->main_table_alias) ? '' : $this->main_table_alias . '.';

        foreach ($data_keys as $col => $data) {
            if ($flg) {
                $ret = ' AND '.$alias.$col . ' = ' . $this->last_insert_id .' ';
                break;
            } else {
                $ret .= ' AND '.$alias.$col . ' = \'' . $data .'\' ';
            }
        }
        return $ret;
    }

    /** メインテーブル更新前の処理 */
    protected function error_log(&$wpdb, $message = '')
    {
        error_log('★★★★★★★★★★★★');
        error_log($message);
        error_log($wpdb->last_query);
        error_log($wpdb->last_error);
        error_log('★★★★★★★★★★★★');
    }
}
