<?php 
if (! defined('ABSPATH')) {
    exit;
}
?>
<?php

class Gm_Validation
{
    // MEMO : テンプレートは $keyをキー名、$nameを日本語名に置換します。
    private const ERROR_MSG_REQUIRED = '「$name」は必須です。';
    private const ERROR_MSG_LENGTH = '「$name」は最大$len文字以下で入力してください。';
    private const ERROR_MSG_LENGTH_MIN = '「$name」は最低$len文字以上で入力してください。';
    private const ERROR_MSG_DATE = '「$name」は日付形式のみ有効です。';
    private const ERROR_MSG_URL = '「$name」のURL形式が不正です。';
    private const ERROR_MSG_NUMERIC = '「$name」は数値のみ有効です。';
    private const ERROR_MSG_PHONE = '「$name」の電話番号形式が不正です。';
    private const ERROR_MSG_POSTAL_CODE = '「$name」の郵便番号形式が不正です。';
    private const ERROR_MSG_EMAIL = '「$name」のメールアドレス形式が不正です。';
    private const ERROR_MSG_ZEN_KATAKANA = '「$name」は全角カタカナのみ有効です。';
    private const ERROR_MSG_PASSWORD = 'パスワードに設定できない文字が入力されています。';

    private $params = [];
    private $errors = [];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function errors()
    {
        return $this->errors;
    }

    // --------------------------
    // 個別チェック
    // --------------------------
    /**
     * 必須チェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->required([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1',],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2',],
     * ]);
    */
    public function required($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (empty($this->params[$key])) {
                $error = $template;
                if (empty($error)) {
                    $error = self::ERROR_MSG_REQUIRED;
                }
                $error = str_replace('$key', $key, $error);
                $error = str_replace('$name', $name, $error);
                $this->errors[] = $error;
            }
        }
        return $this->errors;
    }

    /**
     * 長さ（最大文字数）チェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->length([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1', 'len' => 4],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2', 'len' => 5],
     * ]);
    */
    public function length($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];
            $len = $key_info['len'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if ($len < mb_strlen($this->params[$key])) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_LENGTH;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $error = str_replace('$len', $len, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }


    /**
     * 長さ（最低文字数）チェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->length_min([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1', 'len' => 4],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2', 'len' => 5],
     * ]);
    */
    public function length_min($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];
            $len = $key_info['len'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (mb_strlen($this->params[$key]) < $len) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_LENGTH_MIN;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $error = str_replace('$len', $len, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }


    /**
     * 日付チェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->date([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
     * ]);
    */
    public function date($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (!strptime($this->params[$key], '%Y-%m-%d')) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_DATE;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }

    /**
      * urlチェック
      *
      * サンプル
      * $validation = new Gm_Validation($_SERVER);
      * $validation->url([
      *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
      *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
      * ]);
     */
    public function url($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (preg_match('/^https?:\/\/(?!.*\.{2})[\w\/:%#\$&\?\(\)~\.=\+\-]+$/', $this->params[$key]) !== 1) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_URL;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }
            }
        }
        return $this->errors;
    }


    /**
     * 数値チェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->numeric([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
     * ]);
    */
    public function numeric($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (!is_numeric($this->params[$key])) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_NUMERIC;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }

    /**
      * 電話番号チェック
      *
      * サンプル
      * $validation = new Gm_Validation($_SERVER);
      * $validation->phone([
      *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
      *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
      * ]);
     */
    public function phone($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (preg_match('/^0\d{1,4}-\d{1,4}-\d{3,4}$/', $this->params[$key]) !== 1) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_PHONE;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }

    /**
     * 郵便番号チェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->postal_code([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
     * ]);
    */
    public function postal_code($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (preg_match('/^[0-9]{3}-[0-9]{4}$/', $this->params[$key]) !== 1) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_POSTAL_CODE;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }


    /**
     * メールアドレスチェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->email([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
     * ]);
    */
    public function email($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (preg_match('/^[A-Za-z0-9]+(?:[._-][A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$/i', $this->params[$key]) !== 1) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_EMAIL;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }

    /**
     * 全角カナチェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->zen_katakana([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
     *   ['key' => 'key_name2', 'name' => 'キー名日本語2'],
     * ]);
    */
    public function zen_katakana($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (preg_match('/^[ァ-ンヴー]*$/u', $this->params[$key]) !== 1) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_ZEN_KATAKANA;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }

    /**
     * パスワードチェック
     *
     * サンプル
     * $validation = new Gm_Validation($_SERVER);
     * $validation->password([
     *   ['key' => 'key_name1', 'name' => 'キー名日本語1'],
     * ]);
    */
    public function password($key_list, $template = null)
    {
        foreach ($key_list as $key_info) {
            $key = $key_info['key'];
            $name = $key_info['name'];

            if (!isset($this->params[$key])) {
                throw new Exception('入力チェックでエラー発生。パラメータ項目未定義です：'. $key);
            }
            if (!empty($this->params[$key])) {
                if (preg_match('/^[A-Za-z0-9!"#\$%&\'\(\)\-\^\\\@\[;:\],\.\/=~\|`\{\+\*\}<>?_]+$/', $this->params[$key]) !== 1) {
                    $error = $template;
                    if (empty($error)) {
                        $error = self::ERROR_MSG_PASSWORD;
                    }
                    $error = str_replace('$key', $key, $error);
                    $error = str_replace('$name', $name, $error);
                    $this->errors[] = $error;
                }

            }
        }
        return $this->errors;
    }

}
