<?php
if (! defined('ABSPATH')) {
    exit;
}

?>
<style>
.gm-mypage-filter-raido-wrap{
    display: flex;
    gap:5px;
    align-items: center;
}
</style>
<div class="gm-custom-wrap">
    <form method="POST">
        <input type="text" style="display:none" palceholder="Enter対策">
        <input type="hidden" name="process" value="forget">

        <div class="gm-forget-input">
            <label class="width_100" for="user_id">メールアドレス<br>
                <input 
                    class="gm-input w-300" 
                    type="text" 
                    name="user_id" 
                    value="<?php echo $this->get_input_param('user_id') ?>" 
                    data-gm-required 
                />
            </label>
            <div class="forget_comment">
                パスワード再設定用のURLをメールで送信致しますので以下を入力してください。<br />
                メールアドレスは登録してあるメールアドレスを入力してください。
            </div>
        </div>

        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="送信">
        </div>
    </form>
</div>