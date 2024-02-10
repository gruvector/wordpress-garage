<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Price_Menu_Service extends Gm_Abstract_Menu_Service
{
    public $show_mode;
    public $data_show;
    public $check_box = [];
    

    public function __construct()
    {
        $conf = new Gm_Menu_Service_Conf();
        $conf->set_main_table('gmm_price');
        $conf->set_main_table_alias('price');
        $conf->set_add_cond_search('price.nm like \'%$s%\' OR price.description like \'%$s%\'');
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
        $record = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gmm_price WHERE ID = {$ID}");

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
            $wpdb->prefix.'gmm_price',
            [
                'nm' => $this->data_show['nm'],
                'description' => $this->data_show['description'],
                'expiry_days' => $this->data_show['expiry_days'],
                'price' => $this->data_show['price'],
                'campaign_price' => $this->data_show['campaign_price'],
                'campaign_from' => $this->data_show['campaign_from'],
                'campaign_to' => $this->data_show['campaign_to'],
                'recommend_flg' => $this->data_show['recommend_flg'],
                'priority' => $this->data_show['priority'],             
            ],
            [
                'ID' => $this->data_show['ID1'],
            ]
        );

    }

    public function add()
    {

        $this->data_show = $_POST;
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix.'gmm_price',
            [
                'nm' => $this->data_show['nm'],
                'description' => $this->data_show['description'],
                'expiry_days' => $this->data_show['expiry_days'],
                'price' => $this->data_show['price'],
                'campaign_price' => $this->data_show['campaign_price'],
                'campaign_from' => $this->data_show['campaign_from'],
                'campaign_to' => $this->data_show['campaign_to'],
                'recommend_flg' => $this->data_show['recommend_flg'],
                'priority' => $this->data_show['priority'], 
            ]
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


        global $wpdb;
        $sql =
        <<<EOM
        SELECT
            price.ID
            , price.nm
            , price.description
            , price.expiry_days
            , price.price
            , price.campaign_price
            , price.campaign_from
            , price.campaign_to
            , price.recommend_flg
            , price.priority

        FROM
            {$wpdb->prefix}gmm_price AS price

        ORDER BY {$sql_order};
        EOM;

        $records = $wpdb->get_results($sql);
        return $records;
  
    
    }

}
