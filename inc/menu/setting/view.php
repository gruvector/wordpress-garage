<?php
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php echo $GLOBALS['title'] ?></h1>
  <hr class="wp-header-end">
  <form id="" method="post">
    <div>
      <label for="apikey">API Key : </label>
      <input type="text" name="apikey" class="gm-input" placeholder="xxxxxxxx" style="width: 300px;"/>
      <input type="submit" class="gm-admin-button-apply" value="確認">
    </div>
  </form>
</div>