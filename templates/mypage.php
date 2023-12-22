<?php
/* Template Name:【ガレージ】マイページ
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/mypage/controller.php');
new Gm_Mypage_Controller();
?>