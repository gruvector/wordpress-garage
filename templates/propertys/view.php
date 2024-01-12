<?php
if (! defined('ABSPATH')) {
    exit;
}
?>

<div class="gm-custom-wrap">
    <div class="">
        <?php foreach ($this->property_details as $i => $record) { ?>
            <div class="gm-img-slide">

            </div>
            <div class="gm-grid">
                <div class="gm-map">
                    
                </div>
                <div class="gm-basic-table">
                    <div class="gm-basic-table-section1">ガレージ名</div>
                    <div class="gm-basic-table-section2"><?= $record->nm ?></div>
                    <div class="gm-basic-table-section1">区画</div>
                    <div class="gm-basic-table-section2"><?= $record->section_nm ?></div>
                    <div class="gm-basic-table-section1">現況</div>
                    <div class="gm-basic-table-section2"><?php if ($record->availability_id) {echo "空き予定";} else {echo "使用中";}; ?></div>
                    <div class="gm-basic-table-section1">使用開始可能日</div>
                    <div class="gm-basic-table-section2"><?= $record->min_period ?></div>
                    <div class="gm-basic-table-section1">最低契約期間</div>
                    <div class="gm-basic-table-section2"><?= $record->min_period_unit ?></div>
                    <div class="gm-basic-table-section1">サイズ</div>
                    <div class="gm-basic-table-section2"><?= "横幅".$record->size_w."m x 高さ".$record->size_h."m x 奥行".$record->size_d."m" ?></div>
                    <div class="gm-basic-table-section1">住所</div>
                    <div class="gm-basic-table-section2"><?= $record->address_1." ".$record->address_2." ".$record->address_3 ?></div>
                </div>
            </div>
            <div class="gm-character-table">
                <div class="gm-basic-table-section1">特徴</div>
                <div class="gm-basic-table-section2"><?= $record->nm ?></div>
            </div>
            <div class="gm-fee-month">
                <div class="gm-basic-table-section1 gm-border-right">毎月支払うもの</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section2">賃料</div>
                <div class="gm-basic-table-section2">￥ <?= $record->fee_monthly_rent ?></div>
                <div class="gm-basic-table-section2">共益費</div>
                <div class="gm-basic-table-section2">￥ <?= $record->fee_monthly_common_service ?></div>
                <div class="gm-basic-table-section2">その他<br>毎月支払う料金</div>
                <div class="gm-basic-table-section2">-電気代 <?= $record->fee_monthly_others ?>円<br>-振替手数料 <?= $record->fee_monthly_others ?>円</div>
            </div>
            <div class="gm-fee-month">
                <div class="gm-basic-table-section1 gm-border-right">特徴</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section2">敷金<br>※基本的に解約時に返金される</div>
                <div class="gm-basic-table-section3">￥ <?= $record->fee_contract_security ?></div>
                <div class="gm-basic-table-section2">敷金償却<br>※支払う敷金のうち解約時に返金されない金額</div>
                <div class="gm-basic-table-section3">￥ <?= $record->fee_contract_security_amortization ?></div>
                <div class="gm-basic-table-section2">保証金<br>※基本的に解約時に返金される</div>
                <div class="gm-basic-table-section3">￥ <?= $record->fee_contract_deposit ?></div>
                <div class="gm-basic-table-section2">保証金償却<br>※解約時に返金されない保証金の金額</div>
                <div class="gm-basic-table-section3">￥ <?= $record->fee_contract_deposit_amortization ?></div>
                <div class="gm-basic-table-section2">礼金<br>※返金されない金額</div>
                <div class="gm-basic-table-section3">￥ <?= $record->fee_contract_key_money ?></div>
                <div class="gm-basic-table-section2">保証料<br>[保証会社加入料]</div>
                <div class="gm-basic-table-section3">￥ <?= $record->fee_contract_guarantee_charge ?></div>
                <div class="gm-basic-table-section2">その他<br>契約時のみ支払うもの</div>
                <div class="gm-basic-table-section3">契約手数料 <?= $record->fee_contract_other ?>円</div>
            </div>

            <div class="gm-special-term">
                <div class="gm-basic-table-section1 gm-border-right">特約事項</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section4"></div>
            </div>
            <div class="gm-special-term2">
                <div class="gm-basic-table-section1 gm-border-right">アピールポイント、他の空き区画の紹介</div>
                <div class="gm-border-left"></div>
                <div class="gm-basic-table-section4"></div>
            </div>
                    
        <?php        
            }
        ?>
    </div>
</div>