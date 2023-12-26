<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<style>

</style>
<div class="gm-custom-wrap">
<?php if($this->mode == '') :?>
    <form id="gm-page-form" method="POST">
        <input type="text" style="display:none" palceholder="Enter対策">
        <input type="hidden" name="process" value="check">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>お名前</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="account_nm" value="<?php echo $this->get_input_param('account_nm') ?>" 
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>住所</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="account_address" value="<?php echo $this->get_input_param('account_address') ?>"  
                            data-gm-required >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>電話番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="tel" name="account_tel" value="<?php echo $this->get_input_param('account_tel') ?>"  
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>メールアドレス</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="email" name="account_email" value="<?php echo $this->get_input_param('account_email') ?>"  
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>ご利用者様の属性</div></th>
                    <td>
                        <div class="gm-radio-wrap">
                            <?php
                            foreach ($this->availability_records as $i => $record) {
                                $checked = '';
                                if ($this->get_input_param('availability_id') == $record->ID || (empty($this->get_input_param('availability_id')) && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="radio" name="availability_id" value="' . $record->ID . '" ' . $checked . ' >' . $record->nm . '</label>';
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>ご不明な点など</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" type="text" name="account_quiz" value="<?php echo $this->get_input_param('account_quiz') ?>"   
                             data-gm-required><?php echo $this->get_input_param('account_quiz') ?></textarea>
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
                    <th><div>お名前</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="account_nm" value="<?php echo $this->get_input_param('account_nm') ?>" disabled
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>住所</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="account_address" value="<?php echo $this->get_input_param('account_address') ?>"  disabled
                            data-gm-required >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>電話番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="tel" name="account_tel" value="<?php echo $this->get_input_param('account_tel') ?>"  disabled
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>メールアドレス</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="email" name="account_email" value="<?php echo $this->get_input_param('account_email') ?>"  disabled
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>ご利用者様の属性</div></th>
                    <td>
                        <div class="gm-radio-wrap">
                            <?php
                            foreach ($this->availability_records as $i => $record) {
                                $checked = '';
                                if ($this->get_input_param('availability_id') == $record->ID || (empty($this->get_input_param('availability_id')) && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="radio" name="availability_id" value="' . $record->ID . '" ' . $checked . ' disabled>' . $record->nm . '</label>';
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>ご不明な点など</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" type="text" name="account_quiz" value="<?php echo $this->get_input_param('account_quiz') ?>"  disabled
                            data-gm-required><?= $this->get_input_param('account_quiz') ?></textarea>
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
    <div class="gm-completed">
        <div>
            お申込みありがとうございました。
            info@ar-garage.comより、料金お支払いおよび物件登録のご案内を送付させて頂きます。<br >
            お申し込み後2日以内にメールが届かない場合、迷惑メールフォルダをご確認いた
            だくか、お手数をおかけしますが再度お申し込みをお願いいたします。
        </div>
    </div>
<?php endif; ?>
</div>