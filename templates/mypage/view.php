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
    <form class="gm-mypage-filter-raido-wrap" method="GET">
        <label><input type="radio" name="propertyFilter" value="1" checked>全て</label>
        <label><input type="radio" name="propertyFilter" value="2">公開済み</label>
        <label><input type="radio" name="propertyFilter" value="3">公開申請中</label>
        <label><input type="radio" name="propertyFilter" value="4">非公開</label>
    </form>
    <div class="gm-mypage-list-area">

        <?php 
            if(!empty($_GET['propertyFilter'])){ $selected = $_GET['property_filter'];}
            else{ $selected = '1';}
        ?>
        
        <?php  
            foreach ($this->records1 as $i => $record1) {?>
            <div class="gm-property-list">
            <div class="gm-property-list-header">ガレージ名: <?= $record1->nm ?></div>
                物件番号: <?= $i+1 ?> <br>
                掲載状況: <?php if($record1->availability_id == 1) {echo "公開済";} else {echo "非公開";}?> <br>
                区画名  : <?= $record1->section_nm ?> <br>
                <?php  
                    foreach ($this->records2 as $i => $record2) {
                        if($record2->property_id == $record1->ID) { echo "掲載期間: ".$record2->publish_from." - <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$record2->publish_to; }
                    } 
                ?>
            <form class="gm-property-list-button" method="post">
                <?php
                    $param = array('type'=>'edit', 'id'=>$record1->ID);
                    $link = add_query_arg($param, home_url('mypage-property'));
                ?>
                <a class="gm-property-list-editbutton" href="<?= esc_url($link) ?>">編集する</a>
                <?php 
                    if($record1->availability_id == 1) { ?>
                        <button class="gm-property-list-private_publicbutton" type="submit">>>非公開</button>
                        <input type="hidden" name="public_private" value="private">
                <?php
                    } else {
                ?>
                        <button class="gm-property-list-private_publicbutton" type="submit">>>公開申請</button>
                        <input type="hidden" name="public_private" value="public">
                <?php
                    }
                ?>
                
            </form>
            </div> <?php
            }
        ?>
        <span class="r-text"><?php echo $selected;?></span>

    </div>
    <div class="gm-mypage-add-button-wrap">
        <a class="gm-mypage-add-button" href="/mypage-property/?type=add">
            <div>物件を追加する</div>
        </a>
    </div>
</div>

<script>
    $('input[type=radio]').click(function(e) {//jQuery works on clicking radio box
        var value = $(this).val(); //Get the clicked checkbox value
        console.log(value);
        
        });
</script>