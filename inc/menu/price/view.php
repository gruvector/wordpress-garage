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
      <div class="gm-table-radio-wrap gm-admin-button-wrap">
      <button type="button" class="gm-admin-button-apply" onClick="document.getElementsByName('process')[0].value='show'; document.getElementById('gm-admin-form').submit();">新規作成</button>
      </div>
      <?php $this->table->display(); ?>
    </div>

    <div id="myModal" class="modal" style="display: <?= $this->show_modal; ?>;">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>編集ウィンドウ</h2>
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
                                <input class="gm-input" type="text" name="nm" value="<?= $this->show_data[0]->nm ?>" data-gm-required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>区画名称</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="description" value="<?= $this->show_data[0]->description ?>" data-gm-required>   
                            </div>
                        </td>
                    </tr>            
                    <tr>
                        <th><div>都道府県</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="expiry_days" value="<?= $this->show_data[0]->expiry_days ?>"  data-gm-required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>市区町村</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="price" value="<?= $this->show_data[0]->price ?>"  data-gm-required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>地番</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="campaign_price" value="<?= $this->show_data[0]->campaign_price ?>"  data-gm-required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>建物名・部屋番号</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="campaign_from" value="<?= $this->show_data[0]->campaign_from ?>"  >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>サイズ：横幅</div></th>
                        <td>
                            <div class="gm-meter">
                                <input class="gm-input" type="text" name="campaign_to" value="<?= $this->show_data[0]->campaign_to ?> " >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>サイズ：横幅</div></th>
                        <td>
                            <div class="gm-meter">
                                <input class="gm-input" type="text" name="recommend_flg" value="<?= $this->show_data[0]->recommend_flg ?> " >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>サイズ：横幅</div></th>
                        <td>
                            <div class="gm-meter">
                                <input class="gm-input" type="text" name="priority" value="<?= $this->show_data[0]->priority ?> " >
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
</script>

