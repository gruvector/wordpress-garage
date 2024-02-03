<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Account_Menu_Service extends Gm_Abstract_Menu_Service
{
    public $show_mode;
    public $data_show;
    

    public function __construct()
    {
        $conf = new Gm_Menu_Service_Conf();
        $conf->set_main_table('gmt_account');
        $conf->set_main_table_alias('account');
        $conf->set_add_cond_search('account.nm like \'%$s%\' OR account.kana like \'%$s%\' OR account.email like \'%$s%\' OR account.phone like \'%$s%\' OR account.postal_code like \'%$s%\' OR account.address_1 like \'%$s%\' OR account.address_2 like \'%$s%\' OR account.address_3 like \'%$s%\' OR account.address_4 like \'%$s%\'');
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
        }
        $record = [];
        global $wpdb;
        $records1 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmt_account WHERE ID = {$ID}");
        $records2 = $wpdb->get_results("SELECT ID, nm FROM {$wpdb->prefix}gmm_account_attr order by priority");
        if (empty($records1) || empty($records2)){
            return;
        }
        $record[0] = $records1[0];
        $record[1] = $records2;
        return $record;

    }

    public function apply($ID)
    {
        if (empty($ID)) {
            return;
        }
        $this->data_show = $_POST;
        global $wpdb;

        $wpdb->update(
            $wpdb->prefix.'gmt_account',
            [
                'nm' => $this->data_show['nm'],
                'kana' => $this->data_show['kana'],
                'email' => $this->data_show['email'],
                'phone' => $this->data_show['phone'],
                'postal_code' => $this->data_show['postal_code'],
                'address_1' => $this->data_show['address_1'],
                'address_2' => $this->data_show['address_2'],
                'address_3' => $this->data_show['address_3'],
                'address_4' => $this->data_show['address_4'],
                'account_attr_id' => $this->data_show['account_attr_id'],
                'account_attr_other' => (isset($this->data_show['account_attr_other'])?$this->data_show['account_attr_other']:""),
                'apply_memo' => $this->data_show['apply_memo'],
                'password' => $this->data_show['password'],
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
            $wpdb->prefix . 'gmt_account',
            ['del_flg' => '1',],
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
            $wpdb->prefix . 'gmt_account',
            ['del_flg' => '0',],
            ['ID' => $ID],
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

        $add_cond .= ' AND account.del_flg = ' . (($this->show_mode == '9') ? '1' : '0');

        global $wpdb;
        $sql =
        <<<EOM
        SELECT
            account.ID
            , account.nm
            , account.kana
            , account.email
            , account.phone
            , account.postal_code
            , account.address_1
            , account.address_2
            , account.address_3
            , account.address_4
            , account.account_attr_id
            , account_attr.nm                AS account_attr_nm
            , account.account_attr_other
            , account.apply_memo
            , account.created_at
            , account.del_flg
        FROM
            {$wpdb->prefix}gmt_account AS account
            LEFT JOIN {$wpdb->prefix}gmm_account_attr AS account_attr
                ON account.account_attr_id = account_attr.ID
        WHERE 1 = 1 {$add_cond}
        ORDER BY {$sql_order};
        EOM;

        $records = $wpdb->get_results($sql);
        return $records;
    }

}
