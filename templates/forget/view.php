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
                    class="gm-input" 
                    type="text" 
                    name="user_id" 
                    value="<?php echo $this->get_input_param('user_id') ?>" 
                    placeholder="ユーザーID"
                    data-gm-required 
                />
            </label>
        </div>

        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="リクエスト送信">
        </div>
    </form>
</div>