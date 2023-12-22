<?php
/* Template Name:【ガレージ】お問い合わせ
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/contact-property/controller.php');
new Gm_Contact_Property_Controller();
?>