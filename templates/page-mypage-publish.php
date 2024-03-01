<?php
/* Template Name:【ガレージ】公開 / 非公開申請
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/mypage-publish/controller.php');
new Gm_MypagePublish_Controller();
?>

