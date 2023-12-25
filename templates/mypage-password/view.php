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
<?php if($this->mode == '') :?>
    <form id="gm-page-form" method="POST">
        <input type="text" style="display:none" palceholder="Enter対策">
        <input type="hidden" name="process" value="check">
        <div class="gm-input-table-wrap">
            
            <table class="gm-input-table">
                <tr>
                    <th><div>旧パスワード</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="password" name="old_pwd" data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>新しいパスワード</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="password" name="new_pwd" data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>パスワードの確認</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="password" name="confirm" data-gm-required>
                        </div>
                    </td>
                </tr>

            </table>
            
        </div>
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="確認画面へ">
        </div>
    </form>
<?php elseif($this->mode == 'confirm') :?>
    <form id="gm-page-form" method="POST">
        <input type="text" style="display:none" placeholder="Enter対策">
        <input type="hidden" name="process" value="regist">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>旧パスワード</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?php echo $this->get_input_param('old_pwd') ?>" disabled
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>新しいパスワード</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="<?php echo $this->get_input_param('new_pwd') ?>" disabled
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>パスワードの確認</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="<?php echo $this->get_input_param('confirm') ?>" disabled
                            data-gm-required>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="申請する">
        </div>
    </form>
<?php elseif($this->mode == 'completed') :?>
    完了
<?php endif; ?>
</div>