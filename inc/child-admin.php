<?php

if (! defined('ABSPATH')) {
    exit;
}
final class Gm_Admin
{
    // ----------------------------
    // インストール
    // ----------------------------
    /** <<注意>> バージョンを上げる時は必ずテーブルの更新が合った時のみ */
    private const DB_VERSION = '1.0.13';
    private const DB_VERSION_INIT = '0.0.1';
    private const DB_VERSION_KEY = 'gm_db_version';

    public static function install()
    {
        if (is_admin()) {
            global $wpdb;
            if (get_site_option(self::DB_VERSION_KEY) != self::DB_VERSION) {
                $sql = self::create_sql($wpdb);
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);

                $ret = add_option(self::DB_VERSION_KEY, self::DB_VERSION);
                if (!$ret) {
                    update_option(self::DB_VERSION_KEY, self::DB_VERSION);
                }
            }
        }
    }
    public static function db_check()
    {
        if (get_option(self::DB_VERSION_KEY) != self::DB_VERSION) {
            self::install();
        }
    }
    public static function install_data()
    {
        global $wpdb;
        if (get_option(self::DB_VERSION_KEY) != self::DB_VERSION) {
            self::insert_init_data($wpdb);
        }
    }

    // ----------------------------
    // メイン処理
    // ----------------------------
    private function __construct()
    {
        // NOOP
    }

    public function echo_admin_scripts()
    {
        $admin_url = admin_url();
        echo <<<EOM
<script>
var gmBaseUrl = `{$admin_url}`;
</script>
EOM;

    }

    public static function enqueue_admin_scripts()
    {
        $version = date('YmdHis');
        wp_enqueue_script('gm_common', get_stylesheet_directory_uri(). '/assets/script/common.js', array(), $version);
        wp_enqueue_script('gm_jquery_validation', get_stylesheet_directory_uri(). '/assets/lib/jquery.validation/jquery.validate.js');
        wp_enqueue_script('gm_jquery_tipsy', get_stylesheet_directory_uri(). '/assets/lib/jquery.tipsy/javascripts/jquery.tipsy.js');
        wp_enqueue_script('gm_jquery_ui', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui/jquery-ui.min.js');
        wp_enqueue_script('gm_jquery_ui_timepicker', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui-timepicker/jquery-ui-timepicker-addon.js');
        wp_enqueue_script('gm_jquery_ui_timepicker_ja', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui-timepicker/jquery-ui-timepicker-ja.js');
        wp_enqueue_script('gm_jquery_toast', get_stylesheet_directory_uri(). '/assets/lib/jquery.toast/jquery.toast.js');
        wp_enqueue_script('gm_jquery_columns', get_stylesheet_directory_uri(). '/assets/lib/datatables/datatables.min.js');
        wp_enqueue_script('gm_jstree', get_stylesheet_directory_uri(). '/assets/lib/jstree/jstree.min.js');

        wp_enqueue_style('gm_admin', get_stylesheet_directory_uri(). '/assets/style/admin.css', array(), $version);
        wp_enqueue_style('gm_jquery_tipsy', get_stylesheet_directory_uri(). '/assets/lib/jquery.tipsy/stylesheets/tipsy.css');
        wp_enqueue_style('gm_jquery_ui', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui/jquery-ui.min.css');
        wp_enqueue_style('gm_jquery_ui_timepicker', get_stylesheet_directory_uri(). '/assets/lib/jquery-ui-timepicker/jquery-ui-timepicker-addon.css');
        wp_enqueue_style('gm_jquery_toast', get_stylesheet_directory_uri(). '/assets/lib/jquery.toast/jquery.toast.css');
        wp_enqueue_style('gm_jquery_columns', get_stylesheet_directory_uri(). '/assets/lib/datatables/datatables.min.css');
    }

    // ----------------------------
    // SQL
    // ----------------------------
    private static function create_sql(&$wpdb)
    {
        $prefix = $wpdb->prefix;
        $charset_collate = $wpdb->get_charset_collate();
        $ret = <<<EOM
        CREATE TABLE {$prefix}gmt_account (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm varchar(255) NOT NULL,
            kana varchar(255) NOT NULL,
            email text NOT NULL,
            phone varchar(14) NOT NULL,
            postal_code varchar(8) NOT NULL,
            address_1 text NOT NULL,
            address_2 text NOT NULL,
            address_3 text NOT NULL,
            address_4 text,
            account_attr_id tinyint(1) UNSIGNED NOT NULL,
            account_attr_other varchar(255),
            apply_memo text,
            password varchar(255) NOT NULL,
            del_flg tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            primary key(ID)
          ) {$charset_collate};

          CREATE TABLE {$prefix}gmt_account_tmp (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm varchar(255) NOT NULL,
            kana varchar(255) NOT NULL,
            email text NOT NULL,
            phone varchar(14) NOT NULL,
            postal_code varchar(8) NOT NULL,
            address_1 text NOT NULL,
            address_2 text NOT NULL,
            address_3 text NOT NULL,
            address_4 text,
            account_attr_id tinyint(1) UNSIGNED NOT NULL,
            account_attr_other varchar(255),
            apply_memo text,
            del_flg tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            primary key(ID)
          ) {$charset_collate};

          CREATE TABLE {$prefix}gmt_property (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm text,
            section_nm text,
            imgs text,
            availability_id tinyint(1) UNSIGNED,
            handover_date date,
            min_period int(9) UNSIGNED,
            min_period_unit tinyint(1) UNSIGNED,
            size_w int(9) UNSIGNED,
            size_h int(9) UNSIGNED,
            size_d int(9) UNSIGNED,
            fee_monthly_rent int(9) UNSIGNED,
            fee_monthly_common_service int(9) UNSIGNED,
            fee_monthly_others text,
            fee_contract_security int(9) UNSIGNED,
            fee_contract_security_amortization int(9) UNSIGNED,
            fee_contract_deposit int(9) UNSIGNED,
            fee_contract_deposit_amortization int(9) UNSIGNED,
            fee_contract_key_money int(9) UNSIGNED,
            fee_contract_guarantee_charge int(9) UNSIGNED,
            fee_contract_other int(9) UNSIGNED,
            facility_ids text,
            other_description text,
            appeal_description text,
            postal_code varchar(8),
            address_1 text,
            address_2 text,
            address_3 text,
            address_4 text,
            status tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            primary key(ID)
          ) {$charset_collate};
          

          CREATE TABLE {$prefix}gmt_property_tmp (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            property_id bigint(20) UNSIGNED,
            nm text,
            section_nm text,
            imgs text,
            availability_id tinyint(1) UNSIGNED,
            handover_date date,
            min_period int(9) UNSIGNED,
            min_period_unit tinyint(1) UNSIGNED,
            size_w int(9) UNSIGNED,
            size_h int(9) UNSIGNED,
            size_d int(9) UNSIGNED,
            fee_monthly_rent int(9) UNSIGNED,
            fee_monthly_common_service int(9) UNSIGNED,
            fee_monthly_others text,
            fee_contract_security int(9) UNSIGNED,
            fee_contract_security_amortization int(9) UNSIGNED,
            fee_contract_deposit int(9) UNSIGNED,
            fee_contract_deposit_amortization int(9) UNSIGNED,
            fee_contract_key_money int(9) UNSIGNED,
            fee_contract_guarantee_charge int(9) UNSIGNED,
            fee_contract_other int(9) UNSIGNED,
            facility_ids text,
            other_description text,
            appeal_description text,
            postal_code varchar(8),
            address_1 text,
            address_2 text,
            address_3 text,
            address_4 text,
            remand_flg tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
            remand_comment text,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            primary key(ID)
          ) {$charset_collate};



          CREATE TABLE {$prefix}gmt_property_publish (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            property_id bigint(20) UNSIGNED,
            publish_from timestamp,
            publish_to timestamp,
            created_at timestamp NOT NULL,
            updated_at timestamp NOT NULL,
            primary key(ID)
          ) {$charset_collate};
          
          CREATE TABLE {$prefix}gmm_availability (
            ID tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm varchar(50) NOT NULL,
            priority tinyint(1) UNSIGNED NOT NULL,
            primary key(ID)
          ) {$charset_collate};
          
          CREATE TABLE {$prefix}gmm_facility (
            ID tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm varchar(50) NOT NULL,
            priority tinyint(2) UNSIGNED NOT NULL,
            primary key(ID)
          ) {$charset_collate};
          
          CREATE TABLE {$prefix}gmm_account_attr (
            ID tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm varchar(50) NOT NULL,
            priority tinyint(1) UNSIGNED NOT NULL,
            primary key(ID)
          ) {$charset_collate};
          
          CREATE TABLE {$prefix}gmm_price (
            ID tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
            nm varchar(50) NOT NULL,
            description text NOT NULL,
            expiry_days int(3) UNSIGNED,
            price int(9) UNSIGNED NOT NULL,
            campaign_price int(9) UNSIGNED,
            campaign_from timestamp,
            campaign_to timestamp,
            recommend_flg tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
            priority tinyint(2) UNSIGNED NOT NULL,
            primary key(ID)
          ) {$charset_collate};
          
          
EOM;
        return $ret;
    }

    public static function get_tables()
    {
        return array(
            'gmt_account',
            'gmt_account_tmp',
            'gmt_property',
            'gmt_property_tmp',
            'gmt_property_publish',
            'gmm_availability',
            'gmm_facility',
            'gmm_account_attr',
            'gmm_price',
        );
    }

    private static function drop_tables(&$wpdb)
    {
        $prefix = $wpdb->prefix;
        $tables = self::get_tables();

        $table_list = array();
        foreach ($tables as $table) {
            $table_list[] = $prefix.$table;
        }
        if (!empty($table_list)) {
            $wpdb->query('DROP TABLE '.implode(',', $table_list));
        }
    }

    private static function insert_init_data(&$wpdb)
    {
    }
}
add_action('after_switch_theme', 'Gm_Admin::install');
add_action('after_switch_theme', 'Gm_Admin::install_data');
add_action('after_setup_theme', 'Gm_Admin::db_check');
add_action('admin_enqueue_scripts', 'Gm_Admin::enqueue_admin_scripts');
