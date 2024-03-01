<?php
if (! defined('ABSPATH')) {
    exit;
}
if (!$_SESSION['account_id']) {  
    exit; // header("Location: login.php"); would also be an option 
} 
?>
<div class="gm-custom-wrap">
<?php if($this->mode == '') :?>
    
    <form id="gm-page-form" method="POST">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div class="pl-3">物件番号</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" value="<?= $this->property_info1->ID; ?>" disabled>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">名称</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" value="<?= $this->property_info1->nm; ?>" disabled>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">掲載希望期間<small>(必須)</small></div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="period" data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">その他</div></th>
                    <td>
                        <div>
                        <textarea class="gm-input" name="apply_memo" value=""></textarea>
                        </div>
                    </td>
                </tr>
                <input type="hidden" name="hidden" value="hidden">
            </table>
        </div>
        <div class="gm-input-button-wrap">
            <input type="submit" class="gm-input-button" value="この内容で問い合わせる">
        </div>
    </form>
<?php elseif($this->mode == 'completed') :?>
    <div class="gm-completed">
        <div>
        お問合せを受け付けました。
        info@ar-garage.comより、メールにてご回答いたします。
        お問合せ後2日以内にメールが届かない場合、迷惑メールフォルダをご確認いただ
        くか、お手数をおかけしますが再度お申し込みをお願いいたします。
        </div>
    </div>
    <a href="<?= home_url('mypage')?>" class="gm-input-button mt-5">マイペッジに行く >></a>
<?php endif; ?>
</div>

<script>
    $(document).ready(function() {

        $(function(){
            var requiredCheckboxes = $('.options :checkbox[required]');
            requiredCheckboxes.change(function(){
                if(requiredCheckboxes.is(':checked')) {
                    requiredCheckboxes.removeAttr('required');
                } else {
                    requiredCheckboxes.attr('required', 'required');
                }
            });
        });
    })
</script>