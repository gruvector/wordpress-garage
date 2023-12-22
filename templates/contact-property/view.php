<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<div class="gm-custom-wrap">
<?php if($this->mode == '') :?>
    <form id="gm-page-form" method="POST">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>お名前</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>メールアドレス</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="email" data-gm-required data-gm-email>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>ご利用者様の属性</div></th>
                    <td>
                        <div class="gm-radio-wrap">
                            <?php
                            foreach ($this->account_attr_records as $i => $record) {
                                $checked = '';
                                if ($this->get_input_param('account_attr_id') == $record->ID || (empty($this->get_input_param('account_attr_id')) && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="radio" name="account_attr_id" value="' . $record->ID . '" ' . $checked . ' >' . $record->nm . '</label>';
                                }
                            ?>
                            <label><input type="radio" name="account_attr_id" value="9" >その他</label>
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>ご不明な点</div></th>
                    <td>
                        <div>
                        <textarea class="gm-input" name="apply_memo" value=""></textarea>
                        </div>
                    </td>
                </tr>
                <input type="hidden" name="hidden" value="hidden">
            </table>
        </div>
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="この内容で問い合わせる">
        </div>
    </form>
<?php elseif($this->mode == 'completed') :?>
    <div class="gm-completed">
        <div>
        お問合せを受け付けました。
        info@ar-garage.comより、メールにてご回答いたします。
        お問合せ後2日以内にメールが届かない場合、迷惑メールフォルダをご確認いただ
        くか、お手数をおかけしますが再度お申し込みをお願いいたします。
        </div>
    </div>
<?php endif; ?>
</div>