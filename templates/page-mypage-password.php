<?php
/* Template Name:【ガレージ】アカウントパスワード変更
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/mypage-password/controller.php');
new Gm_Mypage_Password_Controller();
?>