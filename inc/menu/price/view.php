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
            <input type="hidden" name="process1" value="<?= $this->add_edit; ?>">
            <input type="hidden" name="ID1" value="<?= isset($this->show_data[0]->ID) ? $this->show_data[0]->ID : "" ?>" onchange="show_date()">
            <div class="gm-input-table-wrap">
                <table class="gm-input-table">
                    <tr>
                        <th><div>名称</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="nm" value="<?= isset($this->show_data[0]->nm) ? $this->show_data[0]->nm : null ?>" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>説明</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="description" value="<?= isset($this->show_data[0]->description) ? $this->show_data[0]->description : null ?>" required>   
                            </div>
                        </td>
                    </tr>            
                    <tr>
                        <th><div>有効期限日</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="number" name="expiry_days" value="<?= isset($this->show_data[0]->expiry_days) ? $this->show_data[0]->expiry_days : null ?>"  required min="0" max="999999999">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>価格</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="number" name="price" value="<?= isset($this->show_data[0]->price) ? $this->show_data[0]->price : null ?>"  required min="0" max="999999999">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>キャンペーン価格</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="number" name="campaign_price" value="<?= isset($this->show_data[0]->campaign_price) ? $this->show_data[0]->campaign_price : null ?>"  required min="0" max="999999999">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>からのキャンペーン</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="date" name="campaign_from" id="campaign_from" value="<?= isset($this->show_data[0]->campaign_from) ? $this->show_data[0]->campaign_from : null ?>"  required >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>へのキャンペーン</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="date" name="campaign_to" id="campaign_to" value="<?= isset($this->show_data[0]->campaign_to) ? $this->show_data[0]->campaign_to : null ?> " required >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>推奨フラグ</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="recommend_flg" value="<?= isset($this->show_data[0]->recommend_flg) ? $this->show_data[0]->recommend_flg : null ?> " required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>優先度</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="priority" value="<?= isset($this->show_data[0]->priority) ? $this->show_data[0]->priority : null ?> " required >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><div>APIkey</div></th>
                        <td>
                            <div>
                                <input class="gm-input" type="text" name="apikey" value="" >
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

    // function show_date() {
        // document.getElementById("campaign_from").value("<?= isset($this->show_data[0]->campaign_from) ? $this->show_data[0]->campaign_from : null ?>");
    //     console.log('ffef');
    // }

    
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

