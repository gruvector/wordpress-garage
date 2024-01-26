<?php
if (! defined('ABSPATH')) {
    exit;
}
if (!$_SESSION['account_id']) {  
    exit; // header("Location: login.php"); would also be an option 
} 
?>
<style>
.gm-mypage-filter-raido-wrap{
    display: flex;
    gap:5px;
    align-items: center;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div class="gm-custom-wrap">
    <div id="mySidenav" class="sidenav">
        <a href="<?= home_url('mypage-account') ?>" id="account">アカウント変更</a>
        <a href="<?= home_url('mypage-password') ?>" id="password">パスワード変更</a>
    </div>
    <h2>登録済みの物件一覧</h2>
    
    <form class="gm-mypage-filter-raido-wrap" method="get" id="radio_form">
        <label><input type="radio" name="propertyFilter" value="1" checked>全て</label>
        <label><input type="radio" name="propertyFilter" value="2">公開済み</label>
        <label><input type="radio" name="propertyFilter" value="3">公開申請中</label>
        <label><input type="radio" name="propertyFilter" value="4">非公開</label>
        <input type="submit" class="submit_hidden" />
    </form>
    <script>
        var radio_form1 = document.getElementById("radio_form");
        var check_num = parseInt(<?php echo $this->radio_value ?>);
        radio_form1[check_num-1].checked = true;
    </script>
    <div class="gm-mypage-list-area">

        <?php  
            $real_i = 0;
            foreach ($this->records1_1 as $i => $record1_1) { $real_i = $i+1;?>
            <div class="gm-property-list">
            <div class="gm-property-list-header">ガレージ名: <?= $record1_1->nm ?></div>
                物件番号: <?= $i+1 ?> <br>
                掲載状況: <?php if($record1_1->status1 == "1") {echo "公開済";} else {echo "非公開";}?> <br>
                区画名  : <?= $record1_1->section_nm ?> <br>
                <?php  
                    foreach ($this->records2 as $i => $record2) {
                        if($record2->property_id == $record1_1->property_id) { echo "掲載期間: ".$record2->publish_from." - <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$record2->publish_to; }
                    } 
                ?>
            <form class="gm-property-list-button" method="post">
                <?php
                    $param = array('type'=>'edit', 'id'=>$record1_1->property_id);
                    $link = add_query_arg($param, home_url('mypage-property'));
                ?>
                <a class="gm-property-list-editbutton" href="<?= esc_url($link) ?>">編集する</a>

                <input type="hidden" name="public_private" value="<?= $record1_1->status1 == '9' ? "public" : "private" ?>">
                <input type="hidden" name="property_id_num" value="<?= $record1_1->ID ?>">
                <button class="gm-property-list-private_publicbutton" type="submit"><?= $record1_1->status1 == '9' ? ">>公開申請" : ">>非公開" ?></button>

            </form>
            </div> 
        <?php
            }
        ?>

        <?php  
            foreach ($this->records1_2 as $i => $record1_2) {?>
            <div class="gm-property-list">
            <div class="gm-property-list-header">ガレージ名: <?= $record1_2->nm ?></div>
                物件番号: <?= $real_i+$i ?> <br>
                掲載状況:  <br>
                区画名  : <?= $record1_1->section_nm ?> <br>
                <?php  
                    foreach ($this->records2 as $i => $record2) {
                        if($record2->property_id == $record1_2->property_id) { echo "掲載期間: ".$record2->publish_from." - <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$record2->publish_to; }
                    } 
                ?>
            <form class="gm-property-list-button" method="post">
                <?php
                    $param = array('type'=>'edit', 'id'=>$record1_2->property_id);
                    $link = add_query_arg($param, home_url('mypage-property'));
                ?>
                <a class="gm-property-list-editbutton" href="<?= esc_url($link) ?>">編集する</a>

                <input type="hidden" name="property_id_num" value="<?= $record1_1->property_id ?>">
                <button class="gm-property-list-private_publicbutton" type="submit" disabled>公開申請</button>

            </form>
            </div> 
        <?php
            }
        ?>
    </div>
    <div class="gm-mypage-add-button-wrap">
        <a class="gm-mypage-add-button" href="/mypage-property/?type=add">
            物件を追加する
        </a>
    </div>
</div>

<script>
    $('input[type=radio]').click(function(e) {//jQuery works on clicking radio box
        var value = $(this).val(); //Get the clicked checkbox value
        var radio_form = document.getElementById("radio_form");
        console.log(radio_form);
        radio_form.querySelector("input[type='submit']").click();
        
    });
</script>