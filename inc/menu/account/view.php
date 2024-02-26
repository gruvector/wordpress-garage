<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php echo $GLOBALS['title'] ?></h1>
  <hr class="wp-header-end">
  <form id="gm-admin-form" method="post">
    <input type="text" style="display:none" palceholder="Enter対策">
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
          <h2>アカウント編集</h2>
        </div>
        <div class="modal-body">
          
        <form id="gm-page-form" method="POST">
          <input type="hidden" name="process1" value="apply">
          <input type="hidden" name="ID1" value="<?= $this->show_data[0]->ID ?>">
          <div class="gm-input-table-wrap">
              <table class="gm-input-table">
                  <tr>
                      <th><div class="table_label">名前</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="nm" value="<?= $this->show_data[0]->nm?>" 
                              data-gm-required data-gm-length="255">
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>カナ</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="kana" value="<?= $this->show_data[0]->kana?>" 
                              data-gm-required data-gm-length="255" data-gm-zen-katakana>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>メールアドレス</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="email" value="<?= $this->show_data[0]->email?>"  
                              data-gm-required data-gm-email>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>電話番号</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="phone" value="<?= $this->show_data[0]->phone?>"  
                              data-gm-required data-gm-phone>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>郵便番号</div></th>
                      <td>
                          <div class="gm-zipcode-part">
                              <input class="gm-input2" type="text" name="postal_code" value="<?= $this->show_data[0]->postal_code?>"  
                              data-gm-required onkeyup="AjaxZip3.zip2addr(this,'','address_1','address_2','address_3');">
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>都道府県</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="address_1" value="<?= $this->show_data[0]->address_1?>"  
                              data-gm-required>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>市区町村</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="address_2" value="<?= $this->show_data[0]->address_2?>"  
                              data-gm-required>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>地番</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="address_3" value="<?= $this->show_data[0]->address_3?>"  
                              data-gm-required>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>建物名・部屋番号</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="address_4" value="<?= $this->show_data[0]->address_4?>"  
                              >
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>アカウント属性</div></th>
                      <td>
                          <div class="gm-radio-wrap">
                            <?php
                              // var_dump($this->show_data[1]);
                              for ($i = 0; $i < 3; $i++) {
                                $checked = '';
                                if ($this->show_data[0]->account_attr_id == $this->show_data[1][$i]->ID || ($this->show_data[0]->account_attr_id && $i == 0)){
                                    $checked = 'checked';
                                }
                                echo '<label><input type="radio" name="account_attr_id" onchange="account_add()" value="' . $this->show_data[1][$i]->ID . '" ' . $checked . ' >' . $this->show_data[1][$i]->nm . '</label>';
                              }
                            ?>
                            <label><input type="radio" name="account_attr_id" value="9" id="account_attr_id_other1" onchange="account_other(this)">その他</label>
                          </div>
                          <input class="gm-input-other gm-input" type="text" name="account_attr_other" id="account_attr_other1" value="<?= isset($this->show_data[0]->account_attr_other) ? $this->show_data[0]->account_attr_other : ''  ?>" disabled>
                      </td>
                  </tr>
                  <tr>
                      <th><div>パスワード</div></th>
                      <td>
                          <div>
                              <input class="gm-input" type="text" name="password" value="<?= $this->show_data[0]->password ?>"  
                              >
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <th><div>連絡事項</div></th>
                      <td>
                          <div>
                          <textarea class="gm-input gm-width-80" name="apply_memo" 
                              ><?= $this->show_data[0]->apply_memo; ?></textarea>
                          </div>
                      </td>
                  </tr>
                  
              </table>
          </div>
          <div class="gm-input-button-wrap">
              <input type="submit" class="gm-input-button" value="確認" onclick="confirmData()">
          </div>
        </form>
            
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
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

    function confirmData() {
        var txt;
        if (confirm("本気ですか？")) {
            
        } else {
            return
        }
        document.getElementById("demo").innerHTML = txt;
    }
</script>

