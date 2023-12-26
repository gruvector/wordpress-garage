<?php
/* Template Name:【ガレージ】トップページ
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/toppage/controller.php');
new Gm_Toppage_Controller();
?>
