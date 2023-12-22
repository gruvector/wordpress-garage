<?php
/* Template Name:【ガレージ】タイムアウト
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/timeout/controller.php');
new Gm_Timeout_Controller();
?>