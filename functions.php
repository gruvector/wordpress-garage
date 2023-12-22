<?php

//子テーマのCSSの読み込み
add_action('wp_enqueue_scripts', 'enqueue_my_child_styles');
function enqueue_my_child_styles()
{
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('sng-stylesheet','sng-option')
    );
}
/************************
 *functions.phpへの追記は以下に
 *************************/

require_once locate_template('inc/child-constants.php');
require_once locate_template('inc/child-util.php');
require_once locate_template('inc/child-validation.php');

/** 管理画面 */
if (is_admin()) {
    require_once locate_template('inc/child-admin.php');
    require_once locate_template('inc/menu/child-menu.php');
}
/** フロント */
else {
	require_once locate_template('inc/child-front.php');
}



/************************
 *functions.phpへの追記はこの上に
 *************************/
