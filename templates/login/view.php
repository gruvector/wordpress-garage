<?php
if (! defined('ABSPATH')) {
    exit;
}

?>
<div class="gm-custom-wrap">
    <form id="gm-page-form" method="POST">
        <input type="text" style="display:none" palceholder="Enter対策">
        <input type="hidden" name="process" value="login">

        <div class="gm-input-login-wrap">
			<label for="user_id">名またはメール</label>
            <input class="gm-input" type="text" name="user_id" value="<?php echo $this->get_input_param('user_id') ?>" 
                placeholder="ユーザーID"
                data-gm-required> <br>
			<label for="user_id">パスワード</label>
            <input class="gm-input" type="password" name="user_password" value="<?php echo $this->get_input_param('user_password') ?>" 
                placeholder="パスワード"
                data-gm-required>
			<a href="<?= home_url('forget')?>" >パスワードを忘れましたか？</a>
        </div>
		
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="ログイン">
        </div>
    </form>
</div>