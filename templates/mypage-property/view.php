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
    <form id="gm-page-form" method="POST" enctype="multipart/form-data">
        <input type="text" style="display:none" placeholder="Enter対策">
        <input type="hidden" name="process" value="check">
        <?php if(!($this->edit_data_from_db == []))
             foreach ($this->edit_data_from_db as $i => $record_edit) { ?>

        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>画像リスト <br/>TODO 画像選択</div></th>
                    <td>
                        <div>
                            <!-- <input class="gm-input" type="file" name="imgs0" value="" >
                            <input class="gm-input" type="file" name="imgs1" value="" >
                            <input class="gm-input" type="file" name="imgs2" value="" > -->

                            <div class="item">
                                <div class="item-upload">
                                        <div class="image-upload-wrap upload-wrapA">
                                            <input type="file" name="imageA" class="file-upload-input inputA" onchange="readURLA(this);" > 
                                        </div>
                                        <div class="file-upload-content upload-contentA">
                                            <img class="file-upload-image" id="upload-imageA" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadA()" class="remove-image"><span class="image-title titleA"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                        <div class="image-upload-wrap upload-wrapC">
                                            <input type="file" name="imageC" class="file-upload-input inputC" onchange="readURLC(this);" value="+" > 
                                        </div>
                                        <div class="file-upload-content upload-contentC">
                                            <img class="file-upload-image" id="upload-imageC" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadC()" class="remove-image"><span class="image-title titleC"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                        <div class="image-upload-wrap upload-wrapB">
                                            <input type="file" name="imageB" class="file-upload-input inputB" onchange="readURLB(this);" > 
                                        </div>
                                        <div class="file-upload-content upload-contentB">
                                            <img class="file-upload-image" id="upload-imageB" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadB()" class="remove-image"><span class="image-title titleB"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </td>
                </tr>
            </table>
            <div>
                ※左端の写真が、地図上で料金ボタンをクリックした際に表示される写真となります。また、この写真の並び順通りに写真は掲載されます。<br> <br>
                ※写真のデータが大きすぎてアップロードできない方向はこちらのサイトをどうぞ 写真データサイズ圧縮ツール https://tinypng.com/ <br> <br>
            </div>
            <table class="gm-input-table">
                <tr>
                    <th><div>名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?= $record_edit->nm || "" ?>" data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>区画名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="<?= $record_edit->section_nm ?>" data-gm-required>   
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>空き状況</div></th>
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
                    <th><div>引き渡し可能日</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="handover_date" value="<?= $record_edit->handover_date ?>" data-gm-required data-gm-date="yyyy/MM/dd">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>最低契約期間</div></th>
                    <td>
                        <div style="display:flex;gap:10px">
                            <input class="gm-input" style="width:150px;" type="text" name="min_period" value="<?= $record_edit->min_period ?>" data-gm-required data-gm-number>

                            <select class="gm-select-input" style="width:100px;"  name="min_period_unit">
                                <option value="1">年</option>
                                <option value="2">月</option>
                                <option value="3">日</option>
                            </select>
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
                            <input class="gm-input" type="text" name="address_1" value="<?= $record_edit->address_1 ?>"  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value="<?= $record_edit->address_2 ?>"  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="<?= $record_edit->address_3 ?>"  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value="<?= $record_edit->address_4 ?>"  >
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>ガレージサイズ</div></th>
                    <td></td>
                </tr>
                <tr>
                    <th><div>サイズ：横幅</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_w" value="<?= $record_edit->size_w ?> m" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：高さ</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_h" value="<?= $record_edit->size_h ?> m" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：奥行</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_d" value="<?= $record_edit->size_d ?> m" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>毎月支払うもの</div></th>
                    <td></td>
                </tr>
                <tr>
                    <th><div>月額費用：賃料</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_monthly_rent" value="<?= $record_edit->fee_monthly_rent ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>月額費用：共益費</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_monthly_common_service" value="<?= $record_edit->fee_monthly_common_service ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>月額費用：その他</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="fee_monthly_others" ><?= $record_edit->fee_monthly_others ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>契約時のみ支払うもの</div></th>
                    <td></td>
                </tr>
                <tr>
                    <th><div>契約費用：敷金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_security" value="<?= $record_edit->fee_contract_security ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：敷金償却</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_security_amortization" value="<?= $record_edit->fee_contract_security_amortization ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_deposit" value="<?= $record_edit->fee_contract_deposit ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証金償却</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_deposit_amortization" value="<?= $record_edit->fee_contract_deposit_amortization ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：礼金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_key_money" value="<?= $record_edit->fee_contract_key_money ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証料</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_guarantee_charge" value="<?= $record_edit->fee_contract_guarantee_charge ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：その他</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="fee_contract_other" ><?= $record_edit->fee_contract_other ?></textarea>
                        </div>
                    </td>
                </tr>

            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>設備情報</div></th>
                    <td>
                        <div class="gm-checkbox-group-wrap">
                            <?php
                            foreach ($this->facility_records as $i => $record) {
                                $checked = '';
                                if ($this->get_input_param('facility_id['.$i.']') == $record->ID || (empty($this->get_input_param('facility_id')) && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="checkbox" name="facility_id['.$i.']" value="' . $record->ID . '" ' . $checked . ' >' . $record->nm . '</label>';
                                }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>その他紹介</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="other_description" ><?= $record_edit->other_description ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>アピールポイント</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="appeal_description" ><?= $record_edit->appeal_description ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php        
            }
        else {
        ?>
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div>画像リスト <br/>TODO 画像選択</div></th>
                    <td>
                        <div>
                            <!-- <input class="gm-input" type="file" name="imgs0" value="" >
                            <input class="gm-input" type="file" name="imgs1" value="" >
                            <input class="gm-input" type="file" name="imgs2" value="" > -->

                            <div class="item">
                                <div class="item-upload">
                                        <div class="image-upload-wrap upload-wrapA">
                                            <input type="file" name="imageA" class="file-upload-input inputA" onchange="readURLA(this);" > 
                                        </div>
                                        <div class="file-upload-content upload-contentA">
                                            <img class="file-upload-image" id="upload-imageA" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadA()" class="remove-image"><span class="image-title titleA"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                        <div class="image-upload-wrap upload-wrapC">
                                            <input type="file" name="imageC" class="file-upload-input inputC" onchange="readURLC(this);" value="+" > 
                                        </div>
                                        <div class="file-upload-content upload-contentC">
                                            <img class="file-upload-image" id="upload-imageC" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadC()" class="remove-image"><span class="image-title titleC"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                        <div class="image-upload-wrap upload-wrapB">
                                            <input type="file" name="imageB" class="file-upload-input inputB" onchange="readURLB(this);" > 
                                        </div>
                                        <div class="file-upload-content upload-contentB">
                                            <img class="file-upload-image" id="upload-imageB" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadB()" class="remove-image"><span class="image-title titleB"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div>
                ※左端の写真が、地図上で料金ボタンをクリックした際に表示される写真となります。また、この写真の並び順通りに写真は掲載されます。<br> <br>
                ※写真のデータが大きすぎてアップロードできない方向はこちらのサイトをどうぞ 写真データサイズ圧縮ツール https://tinypng.com/ <br> <br>
            </div>
            <table class="gm-input-table">
                <tr>
                    <th><div>名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="" data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>区画名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="" data-gm-required>   
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>空き状況</div></th>
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
                    <th><div>引き渡し可能日</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="handover_date" value="" data-gm-required data-gm-date="yyyy/MM/dd">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>最低契約期間</div></th>
                    <td>
                        <div style="display:flex;gap:10px">
                            <input class="gm-input" style="width:150px;" type="text" name="min_period" value="" data-gm-required data-gm-number>

                            <select class="gm-select-input" style="width:100px;"  name="min_period_unit">
                                <option value="1">年</option>
                                <option value="2">月</option>
                                <option value="3">日</option>
                            </select>
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
                            <input class="gm-input" type="text" name="address_1" value=""  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value=""  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="" data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value=""  >
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>ガレージサイズ</div></th>
                    <td></td>
                </tr>
                <tr>
                    <th><div>サイズ：横幅</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input gm-input-short" type="text" name="size_w" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：高さ</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input gm-input-short" type="text" name="size_h" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：奥行</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input gm-input-short" type="text" name="size_d" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>毎月支払うもの</div></th>
                    <td></td>
                </tr>
                <tr>
                    <th><div>月額費用：賃料</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_monthly_rent" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>月額費用：共益費</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_monthly_common_service" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>月額費用：その他</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="fee_monthly_others" ></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>契約時のみ支払うもの</div></th>
                    <td></td>
                </tr>
                <tr>
                    <th><div>契約費用：敷金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_security" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：敷金償却</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_security_amortization" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_deposit" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証金償却</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_deposit_amortization" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：礼金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_key_money" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証料</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_guarantee_charge" value="" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：その他</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="fee_contract_other" ></textarea>
                        </div>
                    </td>
                </tr>

            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>設備情報</div></th>
                    <td>
                        <div class="gm-checkbox-group-wrap">
                            <?php
                            foreach ($this->facility_records as $i => $record) {
                                $checked = '';
                                if ($this->get_input_param('facility_id') == $record->ID || (empty($this->get_input_param('facility_id')) && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="checkbox" name="facility_id['.$i.']" value="' . $record->ID . '" ' . $checked . ' >' . $record->nm . '</label>';
                                }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>その他紹介</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="other_description" ></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>アピールポイント</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="appeal_description" ></textarea>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php } ?>
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="確認画面へ">
        </div>
    </form>
<?php elseif($this->mode == 'completed') :?>
    完了 <br /><br />
    <a href="<?= home_url('mypage')?>" class="gm-input-button">マイペッジに行く >></a>
<?php endif; ?>
</div>

<!-- <script>
    const fileInput_add = [];
    const fileInput = [];
    const myFile = [];
    // Get a reference to our file input
    function confirm_click() {
        let type = "<?= $this->param_type ?>";
        console.log(type);
    

        for (let add = 0; add < 3; add++) {
            fileInput_add[add] = document.querySelector('input[type="file"][name="imgs'+add+'"]');
            fileInput[add] = document.querySelector('input[type="file"][name="imgs'+add+'_'+type+'"]');
            myFile[add] = new File(['Hello World!'], fileInput[add].value, {
                type: 'text/plain',
                lastModified: new Date(),
            });
            
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(myFile[add]);
            fileInput_add[add].files = dataTransfer.files;
            console.log(fileInput_add[add]);
        }
        
    }   
  
    

    // Now let's create a DataTransfer to get a FileList
    
</script> -->

<script>
    function readURLA(input) {
	  if (input.files && input.files[0]) {
		  var reader = new FileReader();
		  reader.onload = function(e) {
			  $('.upload-wrapA').hide();
			  $('#upload-imageA').attr('src', e.target.result);
			  $('#upload-imageA').show();
			  $('.upload-contentA').show();
			  var fileName = input.files[0].name;
			  var fileExtension = fileName.split('.').pop();
			  $('.titleA').html("Remove A." + fileExtension);
		  };
		reader.readAsDataURL(input.files[0]);

	  } else {
		removeUploadA();
	  }
  }

  function removeUploadA() {
	  $('.inputA').replaceWith($('.inputA').clone());
	  $('.upload-contentA').hide();
	  $('.upload-wrapA').show();
  }

  function readURLB(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
		  $('.upload-wrapB').hide();
          $('#upload-imageB').show();
		  $('#upload-imageB').attr('src', e.target.result);
		  $('.upload-contentB').show();
		  var fileName = input.files[0].name;
		  var fileExtension = fileName.split('.').pop();
		  $('.titleB').html("Remove C." + fileExtension);
		};

		reader.readAsDataURL(input.files[0]);

	  } else {
		removeUploadB();
	  }
  }

  function removeUploadB() {
	  $('.inputB').replaceWith($('.inputB').clone());
	  $('.upload-contentB').hide();
	  $('.upload-wrapB').show();
  }


    function readURLC(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
		  $('.upload-wrapC').hide();
		  $('#upload-imageC').attr('src', e.target.result);
		  $('.upload-contentC').show();
          $('#upload-imageC').show();
	      var fileName = input.files[0].name;
		  var fileExtension = fileName.split('.').pop();
		  $('.titleC').html("Remove B." + fileExtension);
		};

		reader.readAsDataURL(input.files[0]);

	  } else {
		removeUploadC();
	  }
    }

    function removeUploadC() {
        $('.inputC').replaceWith($('.inputC').clone());
        $('.upload-contentC').hide();
        $('.upload-wrapC').show();
    }

    function autoFill() {
        let zip = document.querySelector("input[name='postal_code']").value;
        
        let c = 
        console.log(c);
    }
</script>