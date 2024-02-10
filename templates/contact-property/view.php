<?php
if (! defined('ABSPATH')) {
    exit;
}
?>

<div class="gm-custom-wrap">
<?php if($this->mode == '') :?>
    <form id="gm-page-form" method="POST">
        <div class="gm-input-table-wrap">
            <table class="gm-input-table">
                <tr>
                    <th><div class="pl-3">ガレージ名</div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="section_nm" disabled value="<?= $this->property_section_nm->section_nm; ?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">住所</div></th>
                    <td>
                        <div>
                            <?php 
                                $this->address = $this->property_section_nm->address_1.' '.$this->property_section_nm->address_2.' '.$this->property_section_nm->address_3.' '.$this->property_section_nm->address_4;
                            ?>
                            <input class="gm-input" type="text" name="address" value="<?= $this->address ?>" disabled >
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">お名前 <small>(必須)</small></div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="nm" data-gm-required data-gm-length="255">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">メールアドレス <small>(必須)</small></div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="email" data-gm-required data-gm-email>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3">電話番号 <small>(必須)</small></div></th>
                    <td>
                        <div>
                            <input class="gm-input" type="text" name="phone" data-gm-required data-gm-phone>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3 mt-2">ご希望の連絡方法 <small>(必須)</small></div></th>
                    <td>
                        <input type="checkbox" name="contact_way[]" value="電話" class="ml-2 mt-2" data-gm-required>電話
                        <input type="checkbox" name="contact_way[]" value="メール" class="ml-5" data-gm-required>メール
                    </td>
                </tr>
                <tr>
                    <th><div class="pl-3 mt-2">お問合せ内容 <small>(必須)</small></div></th>
                    <td>
                        <input type="checkbox" name="contact_content[]" value="借りたい" class="ml-2 mt-2" data-gm-required>借りたい
                        <input type="checkbox" name="contact_content[]" value="内覧したい" class="ml-3" data-gm-required>内覧したい
                        <input type="checkbox" name="contact_content[]" value="質問したい" class="ml-3" data-gm-required>質問したい
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
    <a href="<?= home_url('favorite')?>" class="gm-input-button mt-5">マイペッジに行く >></a>
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