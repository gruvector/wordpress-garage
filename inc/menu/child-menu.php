<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
final class Gm_Menu
{
    private function __construct()
    {
        // NOOP
    }
    public static function add()
    {
        add_menu_page(
            'アカウント管理[申請中]',
            '[G]アカウント',
            'manage_options',
            'menu_gm_account_tmp',
            'Gm_Menu::show_account_tmp',
            'dashicons-admin-users',
            100
        );
        add_submenu_page(
            'menu_gm_account_tmp',
            'アカウント管理[申請中]',
            '申請中',
            'manage_options',
            'menu_gm_account_tmp',
            'Gm_Menu::show_account_tmp'
        );

        add_submenu_page(
            'menu_gm_account_tmp',
            'アカウント管理[承認済]',
            '承認済',
            'manage_options',
            'menu_gm_account',
            'Gm_Menu::show_account_tmp'
        );


        add_menu_page(
            '物件管理[申請中]',
            '[G]物件',
            'manage_options',
            'menu_gm_property_tmp',
            'Gm_Menu::show_property_tmp',
            'dashicons-admin-users',
            100
        );
        add_submenu_page(
            'menu_gm_property_tmp',
            '物件管理[申請中]',
            '申請中',
            'manage_options',
            'menu_gm_property_tmp',
            'Gm_Menu::show_property_tmp'
        );

        add_submenu_page(
            'menu_gm_property_tmp',
            '物件管理[承認済]',
            '承認済',
            'manage_options',
            'menu_gm_property',
            'Gm_Menu::show_property_tmp'
        );

    }

    /** アカウント管理 */
    public static function show_account_tmp()
    {
        require_once plugin_dir_path(__FILE__) . '/account-tmp/controller.php';
        $contoroller = new Gm_Account_Tmp_Menu_Controller();
        $contoroller->action();
    }


    /** 物件管理 */
    public static function show_property_tmp()
    {
        require_once plugin_dir_path(__FILE__) . '/property-tmp/controller.php';
        $contoroller = new Gm_Property_Tmp_Menu_Controller();
        $contoroller->action();
    }


    public static function request_ajax()
    {
        $result = false;
        $process = $_POST['ajax_process'];

        switch ($process) {
            // ジャンルトップ集計
            // case 'uy_admin_aggregate':
                // require_once plugin_dir_path(__FILE__) . '/aggregate/service.php';
                // $service = new Gm_Aggregate_Service();
                // $data = $service->execute($_POST['mode'], $_POST['keys'], $_POST['params']);
                // break;
            default:
                break;
        }

        header('Content-Type: application/json; charset=utf-8');
        if (is_string($data)) {
            echo json_encode(array( 'status' => 'NG', 'message' => $data));
        } elseif (is_Object($data) || $data == null) {
            echo json_encode(array( 'status' => 'OK', 'data' => $data));
        } else {
            echo json_encode(array( 'status' => 'NG', 'data' => $data));
        }
        die();
    }
}
add_action('wp_ajax_uy_child_admin', 'Gm_Menu::request_ajax');
add_action('admin_menu', 'Gm_Menu::add');
