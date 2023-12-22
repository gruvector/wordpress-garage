<?php
/* Template Name:【ガレージ】物件詳細
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/propertys/controller.php');
new Gm_Property_Controller();
?>

