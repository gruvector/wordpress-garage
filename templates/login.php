<?php
/* Template Name:【ガレージ】ログイン
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/login/controller.php');
new Gm_Login_Controller();
?>