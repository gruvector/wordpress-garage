<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Toppage_Controller extends Abstract_Template_Controller
{
    public $account_attr_records = [];
    public $wpgomap = [];
    public $filteredArray = [];
    public $filterDataArray = [];
    public $newGarageList = [];
    public $recentList = [];
    public $facility_records = [];
    public $apikey = "";

    protected function setting()
    {
        parent::setting();
    }

    private function render()
    {
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/header.php';
        require 'view.php';
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/footer.php';
    }

    public function action()
    {

        $period = $this->wpdb->get_results("SELECT publish_from, publish_to, property_id  FROM {$this->wpdb->prefix}gmt_property_publish");
        $account = $this->wpdb->get_results("SELECT ID  FROM {$this->wpdb->prefix}gmt_account WHERE del_flg = '0'");
        $wpgomap1 = $this->wpdb->get_results("SELECT ID, nm, imgs, lat, lng, fee_monthly_rent, facility_ids, property_id, account_id  FROM {$this->wpdb->prefix}gmt_property WHERE status1 = 1");
        // var_dump($wpgomap1);
        $this->facility_records = $this->wpdb->get_results("SELECT ID, nm FROM {$this->wpdb->prefix}gmm_facility order by priority")  ;
        $this->recentList = $this->wpdb->get_results($this->wpdb->prepare("SELECT *  FROM {$this->wpdb->prefix}gmt_property WHERE status1 = 1 AND availability_id = %d", 3));
        $this->apikey = $this->wpdb->get_results("SELECT group_map_title FROM {$this->wpdb->prefix}group_map WHERE group_map_id = 1")[0]->group_map_title;
        function stringToArray($string) {
            $c = [];
            strlen((string)$string) == 1 ?  array_push($c, $string) : $c = explode(",", (string)$string);
            return $c;
        }

        function validatingProperty($mapdata, $account, $period) {
            $account_array = [];
            for ($i=0; $i < count($account); $i++) { 
                array_push($account_array, $account[$i]->ID);
            }
            
            $mapdata1 = [];
            $mapdata2 = [];
            for ($i = 0; $i < count($mapdata) ; $i++) { 
                
                if(array_search($mapdata[$i]->account_id,$account_array) >= 0) {
                    array_push($mapdata1, $mapdata[$i], true);
                }
                // var_dump($mapdata1);
            }
            
            $today = date('Y-m-d');
            for ($i = 0; $i < count($mapdata1) ; $i++) {
                for ($j = 0; $j < count($period); $j++) { 
                    if (isset($period[$j]->property_id) && isset($mapdata1[$i]->property_id)) {
                        // var_dump($mapdata1[$i]->property_id);
                        if ($period[$j]->property_id == $mapdata1[$i]->property_id) {
                            // var_dump($mapdata1[$i]->property_id);
                            $diff1 = date_diff(date_create($period[$j]->publish_from), date_create($today))->format("%R%a")[0];
                            $diff2 = date_diff(date_create($today), date_create($period[$j]->publish_to))->format("%R%a")[0];
                            
                            if ($diff1 == '+' && $diff2 == '+') {
                                array_push($mapdata2, $mapdata1[$i]);
                            }
                        }
                    }
                }      
            }
            return $mapdata2;
        }

        $wpgomap = validatingProperty($wpgomap1, $account, $period);

        if (isset($_GET['filterList'])) {
            $filterArray = stringToArray((string)$_GET['filterList']);
            array_push($this->filterDataArray, $filterArray);
        }

        // var_dump($this->filterDataArray);

        if (isset($_GET['filterList'])) {
            for ($i=0; $i < count($wpgomap); $i++) { 
                $a = stringToArray($wpgomap[$i]->facility_ids);
                
                $result = array_intersect($a, $filterArray);                
                // var_dump($result);
                if ($result == $filterArray) {
                    array_push($this->filteredArray, $wpgomap[$i]);
                }
                // var_dump($this->filteredArray);
            }
        } else {
            $this->filteredArray = $wpgomap;
        }
        
        // var_dump($this->recentList);
        // -------------------
        // 画面描画
        // -------------------
        $this->render();
    }


}
