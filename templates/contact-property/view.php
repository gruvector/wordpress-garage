<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
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
                        <textarea class="gm-input" name="apply_memo" value=></textarea>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="この内容で問い合わせる">
        </div>
    </form>
<?php elseif($this->mode == 'completed') :?>
    完了asfasfasfsafasdfsaf
<?php endif; ?>
</div>