<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php echo $GLOBALS['title'] ?></h1>
  <hr class="wp-header-end">
  <form id="gm-admin-form" method="post">
    <input type="text" style="display:none" palceholder="Enter対策">
    <input type="hidden" name="page" value="<?php echo esc_attr(isset($_GET['page']) ? (string)$_GET['page'] : '');?>" />

    <input type="hidden" name="process"/>
    <input type="hidden" name="execute_id"/>

    <div class="gm-table-wrap">
      <div class="gm-table-radio-wrap">
        <label><a href="/wp-admin/admin.php?show_mode=1&page=<?php echo esc_attr(isset($_GET['page']) ? (string)$_GET['page'] : '');?>"><input type="radio" name="show_mode" <?php echo $this->show_mode == '9' ? '': 'checked' ?>>未承認</a></label>
        <label><a href="/wp-admin/admin.php?show_mode=9&page=<?php echo esc_attr(isset($_GET['page']) ? (string)$_GET['page'] : '');?>"><input type="radio" name="show_mode" <?php echo $this->show_mode == '9' ? 'checked': '' ?>>否認済</a></label>
      </div>
      <?php $this->table->display(); ?>
    </div>
  </form>
</div>

