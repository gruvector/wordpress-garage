<?php
/* Template Name:【ガレージ】物件追加[マイページ]
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/mypage-property/controller.php');
new Gm_Mypage_Property_Controller();
?>