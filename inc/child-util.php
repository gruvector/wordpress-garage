<?php

if (! defined('ABSPATH')) {
    exit;
}
final class Gm_Util
{
    private function __construct()
    {
        // NOOP
    }

    private const BOTS = array(
        'Googlebot',
        'msnbot',
        'bingbot',
        'Yahoo! Slurp',
        'Y!J',
        'facebookexternalhit',
        'Twitterbot',
        'Applebot',
        'Linespider',
        'Adsbot',
        'Baidu',
        'YandexBot',
        'Yeti',
        'dotbot',
        'rogerbot',
        'AhrefsBot',
        'MJ12bot',
        'SMTBot',
        'BLEXBot',
        'linkdexbot',
        'SemrushBot',
        '360Spider',
        'spider',
        'YoudaoBot',
        'DuckDuckGo',
        'Daum',
        'Exabot',
        'SeznamBot',
        'Steeler',
        'Sonic',
        'BUbiNG',
        'Barkrowler',
        'GrapeshotCrawler',
        'MegaIndex.ru',
        'archive.org_bot',
        'TweetmemeBot',
        'PaperLiBot',
        'admantx-apacas',
        'SafeDNSBot',
        'TurnitinBot',
        'proximic',
        'ICC-Crawler',
        'Mappy',
        'YaK',
        'CCBot',
        'Pockey',
        'psbot',
        'Feedly',
        'Superfeedr bot',
        'ltx71',
        'FeedFetcher-Google',
        'blogmuraBot',
        'ping.blo.gs',
        'AhrefsSiteAudit',
        'Chatwork LinkPreview',
    );

    private const MOBILES = array(
        'iPhone',
        'Android',
        'iPod',
        'dream',
        'CUPCAKE',
        'blackberry',
        'webOS',
        'incognito',
        'webmate'
    );

    public static function is_bot()
    {
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (empty($ua)) {
            return false;
        }
        return preg_match('/'.implode('|', self::BOTS).'/i', $ua);
    }

    public static function is_mobile()
    {
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (empty($ua)) {
            return false;
        }
        return preg_match('/'.implode('|', self::MOBILES).'/i', $ua);
    }

    public static function is_iphone()
    {
        if (stripos($_SERVER['HTTP_USER_AGENT'], 'iPhone') === false) {
            return false;
        }
        return true;
    }

    public static function is_android()
    {
        if (stripos($_SERVER['HTTP_USER_AGENT'], 'Android') === false) {
            return false;
        }
        return true;
    }

    public static function server_value($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : '';
    }

    public static function get_url()
    {
        return self::server_value('REQUEST_SCHEME').'://'.self::server_value('HTTP_HOST').self::server_value('REQUEST_URI');
    }

    /** href属性の置換 */
    public static function replace_href($dom, $href)
    {
        if (empty($dom) || empty($href)) {
            return '';
        }
        return preg_replace('/href="(.+?)"/', 'href="'.$href.'"', $dom);
    }

    public static function within_the_period($from, $to, $double_check = true)
    {
        // 両方未記載の場合、対象
        if ($double_check && self::is_date_empty($from) && self::is_date_empty($to)) {
            return false;
        }
        $today = date_i18n('Y-m-d H:i:s');

        $ret = true;
        // FROM評価
        if (!self::is_date_empty($from)) {
            if (strtotime($today) < strtotime($from)) {
                $ret = false;
            }
        }
        // TO評価
        if (!self::is_date_empty($to)) {
            if (strtotime($to) < strtotime($today)) {
                $ret = false;
            }
        }
        return $ret;
    }
    public static function is_date_empty($date)
    {
        return empty($date) || $date == '0000-00-00 00:00:00' || $date == '0000-00-00';
    }

    /** 数字フォーマット */
    public static function format_num($int, $kanji = true)
    {
        if (is_numeric($int)) {
            if ($kanji) {
                $unit = array('万','億','兆','京');
                krsort($unit);
                $tmp = '';
                $count = strlen($int);
                foreach ($unit as $k => $v) {
                    if ($count > (4 * ($k + 1))) {
                        if ($int!==0) {
                            $tmp .= number_format(floor($int /pow(10000, $k+1))).$v;
                        }
                        $int = $int % pow(10000, $k+1);
                    }
                }
                if ($int!==0) {
                    $tmp .= number_format($int % pow(10000, $k+1));
                }
                return $tmp;
            } else {
                return number_format($int);
            }
        } else {
            return '';
        }
    }

    /** 日付フォーマット */
    public static function format_date($date, $format = 'Y年n月j日')
    {
        if (!empty($date) && $date != '0000-00-00 00:00:00') {
            $date = explode(' ', $date)[0];
            $date = str_replace('/', '-', $date);
            list($Y, $m, $d) = explode('-', $date);
            if (checkdate($m, $d, $Y) === true) {
                return date_i18n($format, strtotime($date));
            }
        }
        return '';
    }


    public static function get_srcset($url_img, $size = 'clip200')
    {
        if (!empty($url_img)) {
            $id = self::get_attachment_id_from_url($url_img);
            if (!empty($id)) {
                $srcset = wp_get_attachment_image_srcset($id, $size);
                if (!empty($srcset)) {
                    return $srcset;
                }
            }
        }
        return '';
    }


    public static function set_option($key, $value)
    {
        $ret = add_option($key, $value);
        if (!$ret) {
            update_option($key, $value);
        }
    }


    /** 簡易レコード作成 */
    public static function create_record($key_id, $key_value, $id, $value)
    {
        $record = new stdClass();
        $record->$key_id = $id;
        $record->$key_value = $value;
        return $record;
    }
    /** レコード値取得 */
    public static function get_record_value($records, $value, $key_id, $key_value)
    {
        foreach ($records as $record) {
            if ($record->$key_id == $value) {
                return $record->$key_value;
            }
        }
        return '';
    }

    public static function get_rand_str($len, $num = true, $en_l = true, $en_u = true)
    {
        $list = [];
        if ($num){
            $list = array_merge($list, range('0', '9'));
        }
        if ($en_l){
            $list = array_merge($list, range('a', 'z'));
        }
        if ($en_u){
            $list = array_merge($list, range('A', 'Z'));
        }

        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $list[rand(0, count($list) - 1)];
        }
        return $str;
    }

    public static function encrypt($value)
    {
        return openssl_encrypt(
            $value,
            'AES-128-CBC',
            'K7yYqXklf7suBWXjia4M',
            0,
            8456266702032726
        );
    }
    public static function decrypt($value)
    {
        return openssl_decrypt(
            $value,
            'AES-128-CBC',
            'K7yYqXklf7suBWXjia4M',
            0,
            8456266702032726
        );
    }

}
