<?php
/* Template Name:【ガレージ】お気に入り
 * Template Post Type: page
 */
?>
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
require_once locate_template('templates/favorite/controller.php');
new Gm_Favorite_Controller();
?>