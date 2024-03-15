<?php

if (!defined('ABSPATH')) {
    exit;
}
require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/inc/menu/abstract-menu-service.php';
class Gm_Setting_Menu_Service extends Gm_Abstract_Menu_Service
{


    public function __construct()
    {
        $conf = new Gm_Menu_Service_Conf();

        parent::__construct($conf);
    }
    // -----------------------------------------------
    // 更新系
    // -----------------------------------------------

    public function apply($apikey)
    {
        global $wpdb;
        $wpdb->update(
            $wpdb->prefix.'group_map',
            [
                'group_map_title' => $apikey,
            ],
            [
                'group_map_id' => 1
            ]
        );
    }

    
    public function get_list_with_cond($add_cond = '', $order = '')
    {
        
    }

}
