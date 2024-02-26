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
require_once locate_template('templates/pubprirequest/controller.php');
new Gm_PubPriRequest_Controller();
?>

