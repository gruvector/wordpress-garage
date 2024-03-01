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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<div class="gm-custom-wrap">
    <div id="mySidenav" class="sidenav">
        <a href="<?= home_url('mypage-account') ?>" id="account">アカウント変更</a>
        <a href="<?= home_url('mypage-password') ?>" id="password">パスワード変更</a>
    </div>
    <h2>登録済みの物件一覧</h2>
    
    <form class="gm-mypage-filter-raido-wrap" method="get" id="radio_form">
        <label><input type="radio" name="propertyFilter" value="1" checked>全て</label>
        <label><input type="radio" name="propertyFilter" value="2">公開済み</label>
        <label><input type="radio" name="propertyFilter" value="3">承認済み</label>
        <label><input type="radio" name="propertyFilter" value="4">承認待ち</label>
        <label><input type="radio" name="propertyFilter" value="5">非公開</label>
        <label><input type="radio" name="propertyFilter" value="6">削除</label>
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
            $today = new DateTime();
            foreach ($this->records1_1 as $i => $record1_1) { $real_i = $i+1;
                if($record1_1->status1 == "1") {
                if ($today >= new DateTime($record1_1->publish_from) && $today <= new DateTime($record1_1->publish_to)) {
                    $hiretype = "公開済み";
            ?>
                    <div class="gm-property-list1_1">
            <?php
                } else {  $hiretype = "非公開";
            ?>
                    <div class="gm-property-list1_3">
            <?php } ?>
            <?php } elseif ($record1_1->status1 == "9") { $hiretype = "削除";?>
            <div class="gm-property-list1_2">
            <?php } ?>
            <div class="gm-property-list-header">ガレージ名: <?= $record1_1->nm ?></div>
                物件番号: <?= $record1_1->property_id ?> <br>
                掲載状況: <?= $hiretype ?> <br>
                区画名  : <?= $record1_1->section_nm ?> <br>
                掲載期間:<?php  
                    foreach ($this->records2 as $i => $record2) {
                        if($record2->property_id == $record1_1->property_id) { echo " ".substr($record2->publish_from,0,10)." ~ ".substr($record2->publish_to,0,10); }
                    } 
                ?>
                
            <form class="gm-property-list-button" method="post">
                <?php
                    $info = base64_encode((string)$record1_1->property_id);
                    $param = array('type'=>'edit', 'id'=>$info);
                    $link = add_query_arg($param, home_url('mypage-property'));
                    $param1 = array('id'=>$info);
                    $link1 = add_query_arg($param1, home_url('mypage-publish'));
                ?>
                <a class="gm-property-list-editbutton" href="<?= esc_url($link) ?>">編集する</a>

                <input type="hidden" name="property_id_num" value="<?= $record1_1->property_id ?>">
                <a class="gm-property-list-private_publicbutton" href="<?= esc_url($link1) ?>"><?= $record1_1->status1 == '9' ? ">>公開申請" : ">>非公開" ?></a>

            </form>
            </div> 
        <?php
            }
        ?>

        <?php  
            foreach ($this->records1_2 as $i => $record1_2) {?>
            <?php if($record1_2->remand_flg == "1") { $status = "承認待ち"; ?>
            <div class="gm-property-list2_1">
            <?php } else { $status = "承認済み"; $comment="";?>
            <div class="gm-property-list2_2">
            <?php } ?>
            <div class="gm-property-list-header">ガレージ名: <?= $record1_2->nm ?></div>
                物件番号: <?= $record1_2->property_id ?> <br>
                掲載状況: <?= $status ?><br>
                区画名  : <?= $record1_2->section_nm ?> <br>
                掲載期間: <?php  
                    foreach ($this->records2 as $i => $record2) {
                        if($record2->property_id == $record1_2->property_id) { echo " ".substr($record2->publish_from,0,10)." ~ ".substr($record2->publish_to,0,10); }
                    } 
                ?> <br />
            <form class="gm-property-list-button" method="post">
                <?php
                    $info = base64_encode((string)$record1_2->property_id);
                    $param = array('type'=>'edit', 'id'=>$info);
                    $link = add_query_arg($param, home_url('mypage-property'));
                    $param1 = array('id'=>$info);
                    $link1 = add_query_arg($param1, home_url('mypage-publish'));
                ?>
                <a class="gm-property-list-editbutton" href="<?= esc_url($link) ?>">編集する</a>

                <input type="hidden" name="property_id_num" value="<?= $record1_2->property_id ?>">
                <a class="gm-property-list-private_publicbutton" href="<?= esc_url($link1) ?>">>>公開申請</a>

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

    function setPropertyCookie(id) {
        document.cookie = "property_id_mypage="+id;
        console.log(document.cookie);
    }
</script>