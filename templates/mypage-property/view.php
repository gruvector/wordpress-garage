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
        <input type="hidden" name="process" value="regist">
        
        <?php if(!($this->edit_data_from_db == []))
            foreach ($this->edit_data_from_db as $i => $record_edit) { 
                if (isset($record_edit->handover_date)) {
                    $date = str_replace('-', '/', $record_edit->handover_date);
                    $newDate = date("Y/m/d", strtotime($date));
                }
            
        ?>
             <input type="hidden" name="property_id" value="<?= $record_edit->property_id ?>">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <td>
                        <?php 
                            $img_path_display = explode(',', $record_edit->imgs);
                            
                        ?>
                        <div class="item">
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapA">
                                    <label htmlFor="upload-photoAC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageA" id="upload-photoAC" class="file-upload-input inputA" onchange="readURLA(this);"  >
                                    <input type="hidden" name="hidden_photoA" value="<?= isset($img_path_display[0])?$img_path_display[0]:""  ?>"> 
                                </div>
                                <div class="file-upload-content1 upload-contentA" id="upload-image-content-divA">
                                    <img class="file-upload-image1" id="upload-imageA" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[0]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadA()" class="remove-image"><span class="image-title titleA">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapC">
                                    <label htmlFor="upload-photoBC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageC" id="upload-photoBC" class="file-upload-input inputC" onchange="readURLC(this);" value="" > 
                                    <input type="hidden" name="hidden_photoC" value="<?= isset($img_path_display[1])?$img_path_display[1]:""  ?>">
                                </div>
                                <div class="file-upload-content1 upload-contentC" id="upload-image-content-divC">
                                    <img class="file-upload-image1" id="upload-imageC" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[1]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadC()" class="remove-image"><span class="image-title titleC">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapB">
                                    <label htmlFor="upload-photoCC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageB" id="upload-photoCC" class="file-upload-input inputB" onchange="readURLB(this);" value="" > 
                                    <input type="hidden" name="hidden_photoB" value="<?= isset($img_path_display[2])?$img_path_display[2]:""  ?>">
                                </div>
                                <div class="file-upload-content1 upload-contentB" id="upload-image-content-divB">
                                        <img class="file-upload-image1" id="upload-imageB" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[2]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadB()" class="remove-image"><span class="image-title titleB">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapD">
                                    <label htmlFor="upload-photoDC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageD" id="upload-photoDC" class="file-upload-input inputD" onchange="readURLD(this);">
                                    <input type="hidden" name="hidden_photoD" value="<?= isset($img_path_display[3])?$img_path_display[3]:""  ?>"> 
                                </div>
                                <div class="file-upload-content1 upload-contentD" id="upload-image-content-divD">
                                    <img class="file-upload-image1" id="upload-imageD" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[3]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadD()" class="remove-image"><span class="image-title titleD">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapE">
                                    <label htmlFor="upload-photoEC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageE" id="upload-photoEC" class="file-upload-input inputE" onchange="readURLE(this);"> 
                                    <input type="hidden" name="hidden_photoE" value="<?= isset($img_path_display[4])?$img_path_display[4]:""  ?>">
                                </div>
                                <div class="file-upload-content1 upload-contentE" id="upload-image-content-divE">
                                    <img class="file-upload-image1" id="upload-imageE" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[4]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadE()" class="remove-image"><span class="image-title titleE">削除</span></button>
                                    </div>
                                </div>
                            </div>


                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapF">
                                    <label htmlFor="upload-photoFC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageF" id="upload-photoFC" class="file-upload-input inputF" onchange="readURLF(this);"  >
                                    <input type="hidden" name="hidden_photoF" value="<?= isset($img_path_display[5])?$img_path_display[5]:""  ?>"> 
                                </div>
                                <div class="file-upload-content1 upload-contentF" id="upload-image-content-divF">
                                    <img class="file-upload-image1" id="upload-imageF" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[5]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadF()" class="remove-image"><span class="image-title titleF">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapG">
                                    <label htmlFor="upload-photoGC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageG" id="upload-photoGC" class="file-upload-input inputG" onchange="readURLG(this);" value="" > 
                                    <input type="hidden" name="hidden_photoG" value="<?= isset($img_path_display[6])?$img_path_display[6]:""  ?>">
                                </div>
                                <div class="file-upload-content1 upload-contentG" id="upload-image-content-divG">
                                    <img class="file-upload-image1" id="upload-imageG" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[6]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadG()" class="remove-image"><span class="image-title titleG">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapH">
                                    <label htmlFor="upload-photoHC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageH" id="upload-photoHC" class="file-upload-input inputH" onchange="readURLH(this);" value="" > 
                                    <input type="hidden" name="hidden_photoH" value="<?= isset($img_path_display[7])?$img_path_display[7]:""  ?>">
                                </div>
                                <div class="file-upload-content1 upload-contentH" id="upload-image-content-divH">
                                    <img class="file-upload-image1" id="upload-imageH" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[7]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadH()" class="remove-image"><span class="image-title titleH">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapI">
                                    <label htmlFor="upload-photoIC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageI" id="upload-photoIC" class="file-upload-input inputI" onchange="readURLI(this);">
                                    <input type="hidden" name="hidden_photoI" value="<?= isset($img_path_display[8])?$img_path_display[8]:""  ?>"> 
                                </div>
                                <div class="file-upload-content1 upload-contentI" id="upload-image-content-divI">
                                    <img class="file-upload-image1" id="upload-imageI" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[8]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadI()" class="remove-image"><span class="image-title titleI">削除</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="item-upload">
                                <div class="image-upload-wrap1 upload-wrapJ">
                                    <label htmlFor="upload-photoJC" class="general__fileupload">画像を選ぶ</label>
                                    <input type="file" name="imageJ" id="upload-photoJC" class="file-upload-input inputJ" onchange="readURLJ(this);"> 
                                    <input type="hidden" name="hidden_photoJ" value="<?= isset($img_path_display[9])?$img_path_display[9]:""  ?>">
                                </div>
                                <div class="file-upload-content1 upload-contentJ" id="upload-image-content-divJ">
                                    <img class="file-upload-image1" id="upload-imageJ" src="<?= wp_get_upload_dir()['baseurl'].'/gm-property/'.$record_edit->property_id.'/'.$img_path_display[9]  ?>" alt="画像" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUploadJ()" class="remove-image"><span class="image-title titleJ">削除</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </td>
                </tr>
            </table>
            <div class="gm-desc">
                ※左端の写真が、地図上で料金ボタンをクリックした際に表示される写真となります。また、この写真の並び順通りに写真は掲載されます。<br> 
                ※写真のデータが大きすぎてアップロードできない方向はこちらのサイトをどうぞ 写真データサイズ圧縮ツール https://tinypng.com/ <br> 
            </div>
            <table class="gm-input-table">
                <tr>
                    <th><div>名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?= $record_edit->nm ?>" data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>区画名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="<?= $record_edit->section_nm ?>" data-gm-required data-gm-length="255">   
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
                            <input class="gm-input" type="text" name="handover_date" value="<?= $newDate ?>" 
                            data-gm-required data-gm-date="yyyy/MM/dd" data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>最低契約期間</div></th>
                    <td>
                        <div style="display:flex;gap:10px">
                            <input class="gm-input" style="width:150px;" type="text" name="min_period" value="<?= $record_edit->min_period ?>" 
                            data-gm-required data-gm-number data-max="999999999">

                            <select class="gm-select-year" style="width:100px;"  name="min_period_unit">
                                <option value="1">年</option>
                                <option value="2">ヵ月</option>
                                <option value="3">日</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>郵便番号</div></th>
                    <td>
                        <div class="gm-zipcode-part">
                            <input class="gm-input2" type="text" name="postal_code" value="<?= $record_edit->postal_code ?>"  
                            data-gm-required onkeyup="AjaxZip3.zip2addr(this,'','address_1','address_2','address_3');" data-gm-postal-code data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>都道府県</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_1" value="<?= $record_edit->address_1 ?>"  data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value="<?= $record_edit->address_2 ?>"  data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="<?= $record_edit->address_3 ?>"  data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value="<?= $record_edit->address_4 ?>"  data-gm-length="255" data-gm-required>
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
                            <input class="gm-input" type="text" name="size_w" value="<?= $record_edit->size_w ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：高さ</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_h" value="<?= $record_edit->size_h ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：奥行</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_d" value="<?= $record_edit->size_d ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;m
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
                            <textarea class="gm-input" name="fee_monthly_others" maxlength="255"><?= $record_edit->fee_monthly_others ?></textarea>
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
                            <textarea class="gm-input" name="fee_contract_other"  maxlength="255"><?= $record_edit->fee_contract_other ?></textarea>
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
                                $facility = explode(',', $record_edit->facility_ids);
                                for ($j = 0; $j < count($facility); $j++) { 
                                    if ($facility[$j] == $record->ID){
                                        $checked = 'checked';
                                    }
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
                            <textarea class="gm-input" name="other_description"  maxlength="255"><?= $record_edit->other_description ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>アピールポイント</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="appeal_description"  maxlength="255"><?= $record_edit->appeal_description ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php        
            } else {
        ?>
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <td>
                        <div>

                            <div class="item">
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapA">
                                        <label htmlFor="upload-photoAC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageA" class="file-upload-input inputA" id="upload-photoAC" onchange="readURLA(this);" data-gm-required> 
                                    </div>
                                    <div class="file-upload-content1 upload-contentA img-display-none">
                                        <img class="file-upload-image1" id="upload-imageA" src="#" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadA()" class="remove-image"><span class="image-title titleA">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapC">
                                        <label htmlFor="upload-photoCC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageC" id="upload-photoCC" class="file-upload-input inputC" onchange="readURLC(this);" > 
                                    </div>
                                    <div class="file-upload-content1 upload-contentC img-display-none">
                                        <img class="file-upload-image1" id="upload-imageC" src="#" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadC()" class="remove-image"><span class="image-title titleC">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapB ">
                                        <label htmlFor="upload-photoBC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageB" id="upload-photoBC" class="file-upload-input inputB" onchange="readURLB(this);" > 
                                    </div>
                                    <div class="file-upload-content1 upload-contentB img-display-none">
                                        <img class="file-upload-image1" id="upload-imageB" src="#" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadB()" class="remove-image"><span class="image-title titleB">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapD">
                                        <label htmlFor="upload-photoDC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageD" id="upload-photoDC" class="file-upload-input inputD" onchange="readURLD(this);" > 
                                    </div>
                                    <div class="file-upload-content1 upload-contentD img-display-none">
                                        <img class="file-upload-image1" id="upload-imageD" src="#" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadD()" class="remove-image"><span class="image-title titleD">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapE">
                                        <label htmlFor="upload-photoEC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageE" id="upload-photoEC" class="file-upload-input inputE" onchange="readURLE(this);" value="+" > 
                                    </div>
                                    <div class="file-upload-content1 upload-contentE img-display-none">
                                        <img class="file-upload-image1" id="upload-imageE" src="#" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadE()" class="remove-image"><span class="image-title titleE">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapF">
                                        <label htmlFor="upload-photoFC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageF" id="upload-photoFC" class="file-upload-input inputF" onchange="readURLF(this);"  >
                                    </div>
                                    <div class="file-upload-content1 upload-contentF img-display-none">
                                        <img class="file-upload-image1" id="upload-imageF" src="" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadF()" class="remove-image"><span class="image-title titleF">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapG">
                                        <label htmlFor="upload-photoGC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageG" id="upload-photoGC" class="file-upload-input inputG" onchange="readURLG(this);" value="" > 
                                    </div>
                                    <div class="file-upload-content1 upload-contentG img-display-none">
                                        <img class="file-upload-image1" id="upload-imageG" src="" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadG()" class="remove-image"><span class="image-title titleG">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapH">
                                        <label htmlFor="upload-photoHC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageH" id="upload-photoHC" class="file-upload-input inputH" onchange="readURLH(this);" value="" > 
                                    </div>
                                    <div class="file-upload-content1 upload-contentH img-display-none">
                                            <img class="file-upload-image1" id="upload-imageH" src="" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadH()" class="remove-image"><span class="image-title titleH">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapI">
                                        <label htmlFor="upload-photoIC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageI" id="upload-photoIC" class="file-upload-input inputI" onchange="readURLI(this);">
                                    </div>
                                    <div class="file-upload-content1 upload-contentI img-display-none">
                                        <img class="file-upload-image1" id="upload-imageI" src="" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadI()" class="remove-image"><span class="image-title titleI">削除</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-upload">
                                    <div class="image-upload-wrap1 upload-wrapJ">
                                        <label htmlFor="upload-photoJC" class="general__fileupload">画像を選ぶ</label>
                                        <input type="file" name="imageJ" id="upload-photoJC" class="file-upload-input inputJ" onchange="readURLJ(this);"> 
                                    </div>
                                    <div class="file-upload-content1 upload-contentJ img-display-none">
                                        <img class="file-upload-image1" id="upload-imageJ" src="" alt="画像" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUploadJ()" class="remove-image"><span class="image-title titleJ">削除</span></button>
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
                            <input class="gm-input" type="text" name="nm" value="" data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>区画名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="" data-gm-required data-gm-length="255">   
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
                            <input class="gm-input" style="width:150px;" type="text" name="min_period" value="" 
                            data-gm-required data-gm-number data-max="999999999">

                            <select class="gm-select-year" style="width:100px;"  name="min_period_unit">
                                <option value="1">年</option>
                                <option value="2">ヵ月</option>
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
                            data-gm-required onkeyup="AjaxZip3.zip2addr(this,'','address_1','address_2','address_3');" data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>都道府県</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_1" value=""  data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value=""  data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="" data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value=""  data-gm-length="255" data-gm-required>
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
                            <textarea class="gm-input" name="fee_monthly_others"  maxlength="255"></textarea>
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
                            <textarea class="gm-input" name="fee_contract_other"  maxlength="255"></textarea>
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
                            <textarea class="gm-input" name="other_description"  maxlength="255"></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="gm-input-table">
                <tr>
                    <th><div>アピールポイント</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="appeal_description"  maxlength="255"></textarea>
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

    $(document).ready(function(){
        var srcnameE = String($('#upload-imageE').attr('src'));
        if (srcnameE[srcnameE.length - 1] === ".") {
            $('#upload-image-content-divE').hide();
        }

        var srcnameD = String($('#upload-imageD').attr('src'));
        if (srcnameD[srcnameD.length - 1] === ".") {
            $('#upload-image-content-divD').hide();
        }

        var srcnameC = String($('#upload-imageC').attr('src'));
        if (srcnameC[srcnameC.length - 1] === ".") {
            $('#upload-image-content-divC').hide();
        }

        var srcnameB = String($('#upload-imageB').attr('src'));
        if (srcnameB[srcnameB.length - 1] === ".") {
            $('#upload-image-content-divB').hide();
        }

        var srcnameA = String($('#upload-imageA').attr('src'));
        if (srcnameA[srcnameA.length - 1] === ".") {
            $('#upload-image-content-divA').hide();
        }

        var srcnameF = String($('#upload-imageF').attr('src'));
        if (srcnameF[srcnameF.length - 1] === ".") {
            $('#upload-image-content-divF').hide();
        }

        var srcnameG = String($('#upload-imageG').attr('src'));
        if (srcnameG[srcnameG.length - 1] === ".") {
            $('#upload-image-content-divG').hide();
        }

        var srcnameH = String($('#upload-imageH').attr('src'));
        if (srcnameH[srcnameH.length - 1] === ".") {
            $('#upload-image-content-divH').hide();
        }

        var srcnameI = String($('#upload-imageI').attr('src'));
        if (srcnameI[srcnameI.length - 1] === ".") {
            $('#upload-image-content-divI').hide();
        }

        var srcnameJ = String($('#upload-imageJ').attr('src'));
        if (srcnameJ[srcnameJ.length - 1] === "." || "") {
            $('#upload-image-content-divJ').hide();
        }
    })

    function readURLA(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // $('.upload-wrapA').hide();
                $('#upload-imageA').attr('src', e.target.result);
                $('#upload-imageA').show();
                $('.upload-contentA').show();
                $('.upload-contentA').removeClass("img-display-none");

            };
            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadA();
        }
    }

    function removeUploadA() {
        console.log("efef");
        $('.inputA').replaceWith($('.inputA').clone());
        $('.upload-contentA').hide();
        $('.upload-wrapA').show();
    }

    function readURLB(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapB').hide();
            $('#upload-imageB').show();
            $('#upload-imageB').attr('src', e.target.result);
            $('.upload-contentB').show();
            $('.upload-contentB').removeClass("img-display-none");
            }

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
            // $('.upload-wrapC').hide();
            $('#upload-imageC').attr('src', e.target.result);
            $('.upload-contentC').show();
            $('#upload-imageC').show();
            $('.upload-contentC').removeClass("img-display-none");
            }

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

    function readURLD(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapD').hide();
            $('#upload-imageD').attr('src', e.target.result);
            $('.upload-contentD').show();
            $('#upload-imageD').show();
            $('.upload-contentD').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadD();
        }
    }

    function removeUploadD() {
        $('.inputD').replaceWith($('.inputD').clone());
        $('.upload-contentD').hide();
        $('.upload-wrapD').show();
    }

    function readURLE(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapE').hide();
            $('#upload-imageE').attr('src', e.target.result);
            $('.upload-contentE').show();
            $('#upload-imageE').show();
            $('.upload-contentE').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadE();
        }
    }

    function removeUploadF() {
        $('.inputF').replaceWith($('.inputF').clone());
        $('.upload-contentF').hide();
        $('.upload-wrapF').show();
    }

    function readURLF(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapE').hide();
            $('#upload-imageF').attr('src', e.target.result);
            $('.upload-contentF').show();
            $('#upload-imageF').show();
            $('.upload-contentF').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadF();
        }
    }

    function removeUploadF() {
        $('.inputF').replaceWith($('.inputF').clone());
        $('.upload-contentF').hide();
        $('.upload-wrapF').show();
    }

    function readURLG(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapE').hide();
            $('#upload-imageG').attr('src', e.target.result);
            $('.upload-contentG').show();
            $('#upload-imageG').show();
            $('.upload-contentG').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadG();
        }
    }

    function removeUploadG() {
        $('.inputG').replaceWith($('.inputG').clone());
        $('.upload-contentG').hide();
        $('.upload-wrapG').show();
    }

    function readURLH(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapE').hide();
            $('#upload-imageH').attr('src', e.target.result);
            $('.upload-contentH').show();
            $('#upload-imageH').show();
            $('.upload-contentH').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadH();
        }
    }

    function removeUploadH() {
        $('.inputH').replaceWith($('.inputH').clone());
        $('.upload-contentH').hide();
        $('.upload-wrapH').show();
    }

    function readURLI(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapE').hide();
            $('#upload-imageI').attr('src', e.target.result);
            $('.upload-contentI').show();
            $('#upload-imageI').show();
            $('.upload-contentI').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadI();
        }
    }

    function removeUploadI() {
        $('.inputI').replaceWith($('.inputI').clone());
        $('.upload-contentI').hide();
        $('.upload-wrapI').show();
    }

    function readURLJ(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            // $('.upload-wrapE').hide();
            $('#upload-imageJ').attr('src', e.target.result);
            $('.upload-contentJ').show();
            $('#upload-imageJ').show();
            $('.upload-contentJ').removeClass("img-display-none");
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUploadJ();
        }
    }

    function removeUploadJ() {
        $('.inputJ').replaceWith($('.inputJ').clone());
        $('.upload-contentJ').hide();
        $('.upload-wrapJ').show();
    }

    function autoFill() {
        let zip = document.querySelector("input[name='postal_code']").value;
        console.log(c);
    }
</script>