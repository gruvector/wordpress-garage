<?php
/* Template Name:【ガレージ】アカウント
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/mypage-account/controller.php');
new Gm_Mypage_Account_Controller();
?>