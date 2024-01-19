<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<div class="gm-custom-wrap">
<?php if($this->mode == '') :?>
    <form id="gm-page-form" method="POST">
        <input type="text" style="display:none" placeholder="Enter対策">
        <input type="hidden" name="process" value="check">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>名前</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?php echo $this->get_input_param('nm') ?>" 
                            data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>カナ</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="kana" value="<?php echo $this->get_input_param('kana') ?>" 
                            data-gm-required data-gm-length="255" data-gm-zen-katakana>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>メールアドレス</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="email" value="<?php echo $this->get_input_param('email') ?>"  
                            data-gm-required data-gm-email>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>電話番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="phone" value="<?php echo $this->get_input_param('phone') ?>"  
                            data-gm-required data-gm-phone>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>郵便番号</div></th>
                    <td>
                        <div class="gm-zipcode-part">
                            <input class="gm-input2" type="text" name="postal_code" value="<?php echo $this->get_input_param('postal_code') ?>"  
                            data-gm-required onkeyup="AjaxZip3.zip2addr(this,'','address_1','address_2','address_3');">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>都道府県</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_1" value="<?php echo $this->get_input_param('address_1') ?>"  
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value="<?php echo $this->get_input_param('address_2') ?>"  
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="<?php echo $this->get_input_param('address_3') ?>"  
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value="<?php echo $this->get_input_param('address_4') ?>"  
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>アカウント属性</div></th>
                    <td>
                        <div class="gm-radio-wrap">
                            <?php
                                foreach ($this->account_attr_records as $i => $record) {
                                    $checked = '';
                                    if ($this->get_input_param('account_attr_id') == $record->ID || (empty($this->get_input_param('account_attr_id')) && $i == 0)){
                                        $checked = 'checked';
                                    }
                                    echo '<label><input type="radio" name="account_attr_id" onchange="account_add()" value="' . $record->ID . '" ' . $checked . ' >' . $record->nm . '</label>';
                                }
                            ?>
                            <div style="display: flex;">
                                <label><input type="radio" name="account_attr_id" value="9" id="account_attr_id_other" onchange="account_other(this)">その他</label>
                            </div>
                        </div>
                        <input class="gm-input-other" type="text" name="account_attr_other" id="account_attr_other" value="<?php echo $this->get_input_param('account_attr_other') ?>" disabled>

                    </td>
                </tr>
                <tr>
                    <th><div>連絡事項</div></th>
                    <td>
                        <div>
                        <textarea class="gm-input" name="apply_memo" 
                            ><?php echo $this->get_input_param('apply_memo') ?></textarea>
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
        <input type="text" style="display:none" palceholder="Enter対策">
        <input type="hidden" name="process" value="regist">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>名前</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?php echo $this->get_input_param('nm') ?>" disabled
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>カナ</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="kana" value="<?php echo $this->get_input_param('kana') ?>" disabled
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>メールアドレス</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="email" value="<?php echo $this->get_input_param('email') ?>" disabled
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>電話番号</div></th>
                    <td>
                        <div class="gm-zipcode-part">
                            <input class="gm-input" type="text" name="phone" value="<?php echo $this->get_input_param('phone') ?>"  
                            data-gm-required data-gm-phone>
                        </div>
                    </td>
                </tr>
                <tr>
                    
                    <th><div>郵便番号</div></th>
                    <td>
                        <div class="gm-zipcode-part">
                            <input class="gm-input2" type="text" name="postal_code" value="<?php echo $this->get_input_param('postal_code') ?>"  
                            data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>都道府県</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_1" value="<?php echo $this->get_input_param('address_1') ?>" disabled
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value="<?php echo $this->get_input_param('address_2') ?>" disabled
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="<?php echo $this->get_input_param('address_3') ?>" disabled 
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value="<?php echo $this->get_input_param('address_4') ?>" disabled
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>アカウント属性</div></th>
                    <td>
                    <div class="gm-radio-wrap">
                            <?php
                            foreach ($this->account_attr_records as $i => $record) {
                                $checked = '';
                                if ($this->get_input_param('account_attr_id') == $record->ID || (empty($this->get_input_param('account_attr_id')) && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="radio" name="account_attr_id" value="' . $record->ID . '" ' . $checked . '  disabled>' . $record->nm . '</label>';
                                }
                            ?>
                            <div style="display: flex;">
                                <label><input type="radio" name="account_attr_id" value="9" disabled checked=<?= $this->account_other; ?>>その他</label>
                            </div>

                        </div>
                        <input class="gm-input" type="text" name="account_attr_other" value="<?php echo $this->get_input_param('account_attr_other') ?>" disabled>

                    </td>
                </tr>
                <tr>
                    <th><div>連絡事項</div></th>
                    <td>
                        <div>
                        <textarea class="gm-input" name="apply_memo" disabled
                            ><?php echo $this->get_input_param('apply_memo') ?></textarea>
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
    <br /><br />

    <a href="<?= home_url('')?>" class="gm-input-button">トップページに行く >></a>
<?php endif; ?>
</div>

<script>
    function account_other() {
        document.getElementById("account_attr_other").disabled = false;
    }

    function account_add() {
        document.getElementById("account_attr_other").disabled = true;
    }
    
    
</script>