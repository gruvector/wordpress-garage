<?php
if (! defined('ABSPATH')) {
    exit;
}
if (!$_SESSION['account_id']) {  
    echo "sadfsafd";
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
<div class="gm-custom-wrap">
    <h2>登録済みの物件一覧</h2>
    <div class="gm-mypage-filter-raido-wrap">
        <label><input type="radio" name="property_filter" value="1" checked>全て</label>
        <label><input type="radio" name="property_filter" value="2">公開済み</label>
        <label><input type="radio" name="property_filter" value="3">公開申請中</label>
        <label><input type="radio" name="property_filter" value="4">非公開</label>
    </div>
    <div class="gm-mypage-list-area">
        
    </div>
    <div class="gm-mypage-add-button-wrap">
        <a class="gm-mypage-add-button" href="/mypage-property/?type=add">
            <div>物件を追加する</div>
        </a>
    </div>
</div>