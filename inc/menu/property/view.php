<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php echo $GLOBALS['title'] ?></h1>
  <hr class="wp-header-end">
  <form id="gm-admin-form" method="post">
    <input type="hidden" name="page" value="<?php echo esc_attr(isset($_GET['page']) ? (string)$_GET['page'] : '');?>" />

    <input type="hidden" name="process"/>
    <input type="hidden" name="execute_id"/>

    <div class="gm-table-wrap">
      <div class="gm-table-radio-wrap">
        <label><a href="/wp-admin/admin.php?show_mode=1&page=<?php echo esc_attr(isset($_GET['page']) ? (string)$_GET['page'] : '');?>"><input type="radio" name="show_mode" <?php echo $this->show_mode == '9' ? '': 'checked' ?>>編集</a></label>
        <label><a href="/wp-admin/admin.php?show_mode=9&page=<?php echo esc_attr(isset($_GET['page']) ? (string)$_GET['page'] : '');?>"><input type="radio" name="show_mode" <?php echo $this->show_mode == '9' ? 'checked': '' ?>>BAN</a></label>
      </div>
      <?php $this->table->display(); ?>
    </div>

    <div id="myModal" class="modal" style="display: <?= $this->show_modal; ?>;">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>物件編集</h2>
        </div>
        <div class="modal-body">
          
        <form id="gm-page-form" method="POST">
          <input type="hidden" name="process1" value="apply">
          <input type="hidden" name="ID1" value="<?= $this->show_data[0]->ID ?>">
          <div class="gm-input-table-wrap">
              <table class="gm-input-table">
                <tr>
                    <th><div>名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?= $this->show_data[0]->nm || "" ?>" data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>区画名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="<?= $this->show_data[0]->section_nm ?>" data-gm-required>   
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>空き状況</div></th>
                    <td>
                        <div class="gm-radio-wrap">
                            <?php
                            for ($i = 0; $i < 4; $i++) {
                                $checked = '';
                                if ($this->show_data[0]->availability_id == $this->show_data[1][$i]->ID || ($this->show_data[0]->availability_id && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="radio" name="availability_id" value="' . $this->show_data[1][$i]->ID . '" ' . $checked . ' >' . $this->show_data[1][$i]->nm . '</label>';
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>引き渡し可能日</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="date" name="handover_date" value="<?= $this->show_data[0]->handover_date ?>" data-gm-required data-gm-date="yyyy/MM/dd">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>最低契約期間</div></th>
                    <td>
                        <div style="display:flex;gap:10px">
                            <input class="gm-input" style="width:150px;" type="text" name="min_period" value="<?= $this->show_data[0]->min_period ?>" data-gm-required data-gm-number>

                            <select class="gm-select-year" style="width:100px;"  name="min_period_unit">
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
                            <input class="gm-input2" type="text" name="postal_code" value="<?= $this->show_data[0]->postal_code ?>"  
                            data-gm-required onkeyup="AjaxZip3.zip2addr(this,'','address_1','address_2','address_3');">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>都道府県</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_1" value="<?= $this->show_data[0]->address_1 ?>"  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>市区町村</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_2" value="<?= $this->show_data[0]->address_2 ?>"  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>地番</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_3" value="<?= $this->show_data[0]->address_3 ?>"  data-gm-required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>建物名・部屋番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="address_4" value="<?= $this->show_data[0]->address_4 ?>"  >
                        </div>
                    </td>
                </tr>
              </table>
            ------------------------------------------------------------------------------------------------------------------
            <table class="gm-input-table">

                <tr>
                    <th><div>サイズ：横幅</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_w" value="<?= $this->show_data[0]->size_w ?> " 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：高さ</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_h" value="<?= $this->show_data[0]->size_h ?> " 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>サイズ：奥行</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="size_d" value="<?= $this->show_data[0]->size_d ?> " 
                            data-gm-required data-gm-number data-min="0" data-max="999999999">m
                        </div>
                    </td>
                </tr>
            </table>
            ------------------------------------------------------------------------------------------------------------------
            <table class="gm-input-table">

                <tr>
                    <th><div>月額費用：賃料</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_monthly_rent" value="<?= $this->show_data[0]->fee_monthly_rent ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>月額費用：共益費</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_monthly_common_service" value="<?= $this->show_data[0]->fee_monthly_common_service ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>月額費用：その他</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input gm-width-80" name="fee_monthly_others" ><?= $this->show_data[0]->fee_monthly_others ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            ------------------------------------------------------------------------------------------------------------------
            <table class="gm-input-table">

                <tr>
                    <th><div>契約費用：敷金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_security" value="<?= $this->show_data[0]->fee_contract_security ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：敷金償却</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_security_amortization" value="<?= $this->show_data[0]->fee_contract_security_amortization ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_deposit" value="<?= $this->show_data[0]->fee_contract_deposit ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証金償却</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_deposit_amortization" value="<?= $this->show_data[0]->fee_contract_deposit_amortization ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：礼金</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_key_money" value="<?= $this->show_data[0]->fee_contract_key_money ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：保証料</div></th>
                    <td>
                        <div class="gm-meter">
                            <input class="gm-input" type="text" name="fee_contract_guarantee_charge" value="<?= $this->show_data[0]->fee_contract_guarantee_charge ?>" 
                            data-gm-required data-gm-number data-min="0" data-max="999999999"> &nbsp;&nbsp;円
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>契約費用：その他</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input" name="fee_contract_other" ><?= $this->show_data[0]->fee_contract_other ?></textarea>
                        </div>
                    </td>
                </tr>

            </table>
            ------------------------------------------------------------------------------------------------------------------
            <table class="gm-input-table">
                <tr>
                    <th><div>設備情報</div></th>
                    <td>
                        <div class="gm-checkbox-group-wrap">
                            <?php
                            for ($i = 0; $i < 12; $i++) {
                                $checked = '';
                                $facility = explode(',', $this->show_data[0]->facility_ids);
                                for ($j = 0; $j < count($facility); $j++) { 
                                    if ($facility[$j] == $this->show_data[2][$i]->ID){
                                        $checked = 'checked';
                                    }
                                }
                                echo '<label><input type="checkbox" name="facility_id['.$i.']" value="' . $this->show_data[2][$i]->ID . '" ' . $checked . ' >' . $this->show_data[2][$i]->nm . '</label>';
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>その他紹介</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input gm-width-80" name="other_description" ><?= $this->show_data[0]->other_description ?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div>アピールポイント</div></th>
                    <td>
                        <div>
                            <textarea class="gm-input gm-width-80" name="appeal_description" ><?= $this->show_data[0]->appeal_description ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>

          </div>
          <div class="gm-input-button-wrap">
              <input type="submit" class="gm-input-button" value="確認">
          </div>
        </form>
            
        </div>
      </div>
    </div>

    <div id="myModal2" class="modal" style="display: <?= $this->show_publish_modal; ?>;">
        <div class="modal-content">
            <div class="modal-header">
            <span class="close">&times;</span>
            <h2>物件編集</h2>
            </div>
            <div class="modal-body">
            
                <form id="gm-page-form" method="POST">
                    <input type="hidden" name="process1" value="apply_publish">
                    <input type="hidden" name="ID2" value="<?= $this->show_data1[0]->property_id; ?>">
                    <?php
                        if (isset($this->show_data1[0]->publish_from) && isset($this->show_data1[0]->publish_to)) {
                            $date1 = str_replace('-', '/', $this->show_data1[0]->publish_from);
                            $date2 = str_replace('-', '/', $this->show_data1[0]->publish_to);
                            $newDate1 = date("Y/m/d", strtotime($date1));
                            $newDate2 = date("Y/m/d", strtotime($date2));
                        }
                    ?>
                    <div class="calendar">
                        <input class="gm-input" type="text" name="publish_from" value="<?= $newDate1 ?>" data-gm-required data-gm-date="yyyy/MM/dd">
                        <input class="gm-input" type="text" name="publish_to" value="<?= $newDate2 ?>" data-gm-required data-gm-date="yyyy/MM/dd">
                    </div>
                    <div class="gm-input-button-wrap">
                        <input type="submit" class="gm-input-button" value="確認">
                    </div>
                </form>
                
            </div>
        </div>
    </div>
  </form>
</div>

<script>
  // Get the modal

    var modal1 = document.getElementById("myModal");
    var modal2 = document.getElementById('myModal2');
    // Get the <span> element that closes the modal
    var span1 = document.getElementsByClassName("close")[0];
    var span2 = document.getElementsByClassName("close")[1];

    // When the user clicks on <span> (x), close the modal
    span1.onclick = function() {
        modal1.style.display = "none";
    }

    span2.onclick = function() {
        modal2.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal1) {
        modal1.style.display = "none";
        }
    }

    window.onclick = function(event) {
        if (event.target == modal2) {
        modal2.style.display = "none";
        }
    }

    function account_other() {
        document.getElementById("account_attr_other1").disabled = false;
        document.getElementById("account_attr_other1").style.backgroundColor = "#fff";
        document.getElementById("account_attr_other1").style.border = "0.5px solid lightgray";
    }

    function account_add() {
        document.getElementById("account_attr_other1").disabled = true;
        document.getElementById("account_attr_other1").style.backgroundColor = "#eee";
        document.getElementById("account_attr_other1").style.border = "none";
    }
</script>

