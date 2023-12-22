/// <reference path="../lib/jquery/jquery.d.ts"/>
/// <reference path="../lib/jquery-ui/jqueryui.d.ts"/>
/// <reference path="../lib/jquery.tipsy/jquery.tipsy.d.ts"/>
/// <reference path="../lib/jquery.validation/jquery.validation.d.ts"/>
/// <reference path="../lib/chart.js/index.d.ts"/>

interface Window {
    args: any;
}
interface HTMLElement {
    getContext: Function;
    herf: string;
    submit: Function;
}
interface JQueryStatic {
    toast: any;
}
interface IntersectionObserver {
    observe(target: Element, option?: any): void;
}
declare var wp: any;
declare var AjaxZip3: any;
declare var tinyMCE: any;
declare var gmBaseUrl: string;

namespace gm {
    export const ROOT_SELECTOR: string = location.pathname.indexOf('/wp-admin/') >= 0 ? '#wpbody' : 'body';
    export const COVER_SELECTOR: string = location.pathname.indexOf('/wp-admin/') >= 0 ? '#wpwrap' : 'body';

    export var applications: AbstractApplication<any>[] = [];

    export abstract class AbstractApplication<T> {
        public abstract init(args: T);
    }
    export function ready(app: AbstractApplication<any>) {
        applications.push(app);
    }
    // --------------------------------------------
    // 型
    // --------------------------------------------

    // --------------------------------------------
    // メニュー
    // --------------------------------------------
    export interface AbstractMenuParam {
    }
    export interface AbstractMenuRequestParam {
        /** モード */
        ajax_process: string,

        /** メニューパラメータ */
        mode: 'regist' | 'update' | 'delete',

        /** プライマリーキーの配列 */
        keys: string[],

        /** リクエストパラメータ */
        params: AbstractMenuParam
    }

    export interface AbstractMenuResponceParam {
        /** ステータス */
        status: string,

        /** エラーメッセージ */
        message: string,

        /** 変更後データ */
        data: AbstractMenuParam
    }

    export class MenuUtil {
        constructor() {
            throw new Error('MenuUtilはnewできません。');
        }

        /** リクエストエラーリロード */
        public static errorReload(message: string = '') {
            if (!message) {
                message = 'エラーが発生しました。\n恐れ入りますが、しばらく待って再度お試しください。'
            }
            alert(message);
            location.reload();
        }


        /** 必須マーク設定 */
        public static setRequiredMark($el: JQuery) {
            const $targets = $el.find('[data-gm-required-th]');
            for (let i = 0, len = $targets.length; i < len; i++) {
                $targets.eq(i).removeAttr('data-gm-required-th').append('<span class="gm-input-required">*</span>')
            }
        }

        /** 2固定用sticky設定 */
        public static setStickyTh($el: JQuery) {
            const $targets = $el.find('[data-gm-sticky-th]');
            for (let i = 0, len = $targets.length; i < len; i++) {
                const $target = $targets.eq(i);
                const height = jQuery($target.attr('data-gm-sticky-th')).outerHeight() - 1; // border分
                $target.find('thead th').css({ 'position': 'sticky', 'z-index': 20, 'top': height + 'px' });
            }
        }

        /** ?マーク設定 */
        public static setMenuQuestion($el: JQuery) {
            const $targets = $el.find('[data-gm-menu-question]');
            $targets.on('click', (event) => {
                const $explanation = jQuery(jQuery(event.delegateTarget).attr('data-gm-menu-question'));
                gm.DomUtil.hidden($explanation, $explanation.is(':visible'));
            });
            $targets.attr('original-title', 'ヘルプ');
            $targets.tipsy({
                trigger: 'hover',
                opacity: 1.0
            });
        }

        /** オプション未設定時のメッセージ表示 */
        public static setNoOptMessage($el: JQuery) {
            const $targets = $el.find('[data-gm-no-opt-show]');
            for (let i = 0, len = $targets.length; i < len; i++) {
                const $target = $targets.eq(i);
                const $select = jQuery($target.attr('data-gm-no-opt-show'));
                const noOpt = $select.find('option:not([value=""])').length ? true : false;

                gm.DomUtil.hidden($target, noOpt);
            }
        }
        /** モード別設定 */
        public static modeSetting($modal: JQuery, mode: 'regist' | 'update') {
            if (mode == 'update') {
                gm.DomUtil.disabled($modal.find('[data-gm-key],[data-gm-no-change]'), true);
            }
        }

        /** 配列から対象IDの値を取得 */
        public static getTargetData<T, V>(list: T[], value: V, keyId: string, keyValue: string) {
            for (let i = 0, len = list.length; i < len; i++) {
                const model: T = list[i];
                if (model[keyId] == value) {
                    return model[keyValue];
                }
            }
            return null;
        }

        /** 一覧と主キー情報から、対象のレコードを取得 */
        public static getTargetModel<T>(list: T[], keys: string[], ids: (string | number)[]): T {
            const lenList = list.length;
            const lenKeys = keys.length;
            let keyObj = {};
            for (let i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            for (let i = 0; i < lenList; i++) {
                const ret: T = list[i];

                let cnt = 0;
                Object.keys(keyObj).forEach((key) => {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    return ret;
                }
            }
            return null;
        }

        /** 一覧と主キー情報から、キーが一致する一覧を取得 */
        public static getTargetList<T>(list: T[], keys: string[], ids: (string | number)[]): T[] {
            const lenList = list.length;
            const lenKeys = keys.length;
            let keyObj = {};
            let retList: T[] = [];
            for (let i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            for (let i = 0; i < lenList; i++) {
                const ret: T = list[i];

                let cnt = 0;
                Object.keys(keyObj).forEach((key) => {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    retList.push(ret);
                }
            }
            return retList;
        }



        /** 一覧情報にデータを追加する */
        public static addListModel<T>(list: T[], model: T, callback: Function = jQuery.noop) {
            location.reload();
            // TODO trを追加する必要アリ。0行の時にどうやって追加するか検討が必要。また、unshiftの場合、レコードが逆で追加される
            // list.unshift(model);
            // callback();
        }

        /** 一覧情報にデータを追加する */
        public static addListModels<T>(list: T[], models: T[], callback: Function = jQuery.noop) {
            for (let i = 0, len = models.length; i < len; i++) {
                const model = models[i];
                list.push(model);
            }
            callback();
        }

        /** 一覧と主キー情報から、対象のレコードを更新 */
        public static updateListModel<T>(list: T[], keys: string[], model: T, callback: Function = jQuery.noop) {
            const lenList = list.length;
            const lenKeys = keys.length;
            let keyObj = {};
            for (let i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = model[keys[i]];
            }
            for (let i = 0; i < lenList; i++) {
                const ret: T = list[i];

                let cnt = 0;
                Object.keys(keyObj).forEach((key) => {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    list[i] = model;
                    callback();
                    return;
                }
            }
        }

        /** 一覧と主キー情報から、対象のレコードを削除 */
        public static removeListModel<T>(list: T[], keys: string[], ids: (string | number)[], callback: Function = jQuery.noop) {
            const lenList = list.length;
            const lenKeys = keys.length;
            let keyObj = {};
            for (let i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            // 削除対象は１つだけのため前から回す
            for (let i = 0; i < lenList; i++) {
                const ret: T = list[i];

                let cnt = 0;
                Object.keys(keyObj).forEach((key) => {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    list.splice(i, 1);
                    callback();
                    break;
                }
            }
        }

        /** 一覧と主キー情報から、対象のレコードを削除（複数削除可能） */
        public static removeListModels<T>(list: T[], keys: string[], ids: (string | number)[], callback: Function = jQuery.noop) {
            const lenList = list.length;
            const lenKeys = keys.length;
            let keyObj = {};
            for (let i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            // 削除のため後ろから回す
            for (let i = lenList - 1; 0 <= i; i--) {
                const ret: T = list[i];

                let cnt = 0;
                Object.keys(keyObj).forEach((key) => {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    list.splice(i, 1);
                }
            }
            callback();
        }

        /** アンカーIDの取得 */
        public static createAnchorId(prod_id: string, cv_type: number, no: number = 0, cv_id: string = '') {
            if (gm.DataUtil.isEmpty(cv_type)) {
                return '';
            }
            if (gm.DataUtil.isEmpty(prod_id) && gm.DataUtil.isEmpty(cv_id)) {
                return '';
            }

            return 'gm-cv-' + prod_id + '-' + cv_type + '-' + no + '-' + cv_id;
        }

    }

    // --------------------------------------------
    // データ操作共通
    // --------------------------------------------
    export class DataUtil {
        private static htmlSpecialCharsPlaceHolders: string[][] = [
            ['&', '&amp;'],
            ['<', '&lt;'],
            ['>', '&gt;'],
            ['\r', '&#13;'],
            ['\n', '&#10;'],
            ['"', '&quot;'],
            ['\'', '&#39;']
        ];

        constructor() {
            throw new Error('DataUtilはnewできません。');
        }

        public static isUndefined(obj): boolean {
            return jQuery.type(obj) === 'undefined';
        }

        public static isNull(obj): boolean {
            return jQuery.type(obj) === 'null';
        }

        public static isDefined(obj): boolean {
            const type = jQuery.type(obj);
            return (type !== 'null' && type !== 'undefined');
        }

        public static isBoolean(obj): boolean {
            return jQuery.type(obj) === 'boolean';
        }

        public static isNumber(obj): boolean {
            return jQuery.type(obj) === 'number';
        }

        public static isString(obj): boolean {
            return jQuery.type(obj) === 'string';
        }

        public static isObject(obj): boolean {
            return jQuery.isPlainObject(obj);
        }

        public static isFunction(obj): boolean {
            return jQuery.type(obj) === 'function';
        }

        public static isArray(obj): boolean {
            return jQuery.type(obj) === 'array';
        }

        public static isDate(obj): boolean {
            return jQuery.type(obj) === 'date';
        }

        public static isRegExp(obj): boolean {
            return jQuery.type(obj) === 'regexp';
        }

        public static isFormData(obj: Object): boolean {
            return obj.toString() === '[object FormData]';
        }

        public static isEmpty(obj): boolean {
            if (obj == null) {
                return true;
            } else if (this.isString(obj) && obj.length == 0) {
                return true;
            }

            return false;
        }

        public static isNumeric(value): boolean {
            const regexp = new RegExp(/^[-]?([1-9]\d*|0)(\.\d+)?$/);
            return regexp.test(value);
        }

        public static isJQueryObject(obj): boolean {
            return obj instanceof jQuery;
        }

        public static hasElements(obj: Object[]): boolean {
            return (this.isDefined(obj) && obj.length > 0);
        }

        public static hasAnElement(obj: Object[]): boolean {
            return (this.isDefined(obj) && obj.length == 1);
        }

        public static getExtention(filename) {
            return filename.slice((filename.lastIndexOf('.') - 1 >>> 0) + 2);
        }

        public static format(format: string, ...args: any[]): string {
            const argsLen = args.length;

            if (DataUtil.isEmpty(format) || argsLen <= 0) {
                return format;
            }

            let text: string = format;

            if (argsLen == 1 && this.isObject(args[0])) {
                jQuery.each(args[0], function (key, value) {
                    const regexp = new RegExp('\\{' + key + '\\}', 'g');
                    if (gm.DataUtil.isDefined(value)) {
                        text = text.replace(regexp, value);
                    } else {
                        text = text.replace(regexp, '');
                    }
                });
            } else if (argsLen == 1 && this.isArray(args[0])) {
                jQuery.each(args[0], function (index, value) {
                    const regexp = new RegExp('\\{' + index + '\\}', 'g');
                    if (gm.DataUtil.isDefined(value)) {
                        text = text.replace(regexp, value);
                    } else {
                        text = text.replace(regexp, '');
                    }
                });
            } else {
                for (let i = 0; i < argsLen; i++) {
                    const regexp = new RegExp('\\{' + i + '\\}', 'g');
                    if (gm.DataUtil.isDefined(args[i])) {
                        text = text.replace(regexp, args[i]);
                    } else {
                        text = text.replace(regexp, '');
                    }
                }
            }

            return text;
        }

        /**
         * キャメルケースへ変換 sampleString
         * @param string
         * @return string
         */
        public static camelCase(str: string) {
            str = str.charAt(0).toLowerCase() + str.slice(1);
            return str.replace(/[-_](.)/g, function (match, group1) {
                return group1.toUpperCase();
            });
        }

        /**
         * スネークケースへ変換 sample_string
         * @param string
         * @return string
         */
        public static snakeCase(str: string): string {
            const camel = this.camelCase(str);
            return camel.replace(/[A-Z]/g, function (s) {
                return "_" + s.charAt(0).toLowerCase();
            });
        }

        /**
         * パスカルケースへ変換 SampleString
         * @param string
         * @return string
         */
        public static pascalCase(str: string): string {
            const camel = this.camelCase(str);
            return camel.charAt(0).toUpperCase() + camel.slice(1);
        }

        public static htmlEncode(text: any): string {
            if (this.isEmpty(text)) return '';
            text += '';

            const holders = this.htmlSpecialCharsPlaceHolders;

            for (let i = 0, len = holders.length; i < len; i++) {
                const holder = holders[i];
                const regexp = new RegExp(holder[0], 'g');
                text = text.replace(regexp, holder[1]);
            }

            return text;
        }

        public static htmlDecode(text: any): string {
            if (this.isEmpty(text)) return '';
            text += '';

            const holders = this.htmlSpecialCharsPlaceHolders;

            for (let i = holders.length - 1; 0 <= i; i--) {
                const holder = holders[i];
                const regexp = new RegExp(holder[1], 'g');
                text = text.replace(regexp, holder[0]);
            }

            return text;
        }

        public static nl2br(value: string): string {
            if (this.isEmpty(value)) return '';

            return value.replace(/\r?\n/g, '<br/>');
        }

        public static trim(value: string): string {
            return jQuery.trim(value);
        }

        public static singleByteCharacters(text: string): number {
            let length: number = 0;
            for (let i = 0; i < text.length; i++) {
                const c = text.charCodeAt(i);
                if ((c >= 0x0 && c < 0x81) || (c === 0xf8f0) || (c >= 0xff61 && c < 0xffa0) || (c >= 0xf8f1 && c < 0xf8f4)) {
                    length += 1;
                } else {
                    length += 2;
                }
            }
            return length;
        }

        public static truncateChars(value: string, length: number, rightPad: boolean): string {
            if (this.isEmpty(value)) {
                return value;
            }
            let ret = '';
            for (let i = 0; i < value.length; i++) {
                const str = value[i];
                if (length - this.singleByteCharacters(ret) - this.singleByteCharacters(str) < 0) {
                    break;
                }
                ret += str;
            }
            if (rightPad) {
                for (let i = 0; i < length - this.singleByteCharacters(ret); i++) {
                    ret += ' ';
                }
            }
            return ret;
        }

        public static splitChars(value: string, length: number, position: number): string {
            if (this.isEmpty(value)) {
                return '';
            }
            let ret = '';
            let str = value;
            for (let i = 1; i <= position; i++) {
                ret = this.truncateChars(str, length, false);
                str = str.substring(ret.length);
            }
            return ret;
        }

        /**
         * 文字列の末尾の連続する「半角空白・タブ文字・全角空白」を削除する
         */
        public static rtrim(value: string): string {
            return value.replace(/[\s　]+$/g, "");
        }

        /**
         * 半角スペースにて右埋めする処理
         * 指定桁数になるまで対象文字列の右側に
         * 半角スペースを埋めます。
         *
         * @param val 右埋め対象文字列
         * @param num 指定桁数
         * @return 右埋めした文字列
         */
        public static paddingRightOfSpace(val: string, num: number) {
            for (; val.length < num; val += ' ');
            return val;
        }

        public static zeroPad(num: string | number, len: number): string {
            return (Array(len).join('0') + num).slice(-len);
        }

        /**
         * nullかundefindならBLANKに変換する
         * @param val 対象文字列
         */
        public static convertNullToBlank(val: string): string {
            return (val !== null && val !== undefined) ? val : ''
        }

        public static formatDate(val: string | Date, format): string {
            if (!val) {
                return '';
            }
            const date = new Date(val);
            if (format.match(/yyyy/)) {
                const year = date.getFullYear();
                if (isNaN(year)) {
                    return '';
                }
                format = format.replace(/yyyy/, year);
            }
            if (format.match(/MM/)) {
                const month = date.getMonth() + 1;
                if (isNaN(month)) {
                    return '';
                }
                format = format.replace(/MM/, this.zeroPad(month, 2));
            }
            if (format.match(/dd/)) {
                const day = date.getDate();
                if (isNaN(day)) {
                    return '';
                }
                format = format.replace(/dd/, this.zeroPad(day, 2));
            }

            if (format.match(/hh/)) {
                const hours = date.getHours();
                if (isNaN(hours)) {
                    return '';
                }
                format = format.replace(/hh/, this.zeroPad(hours, 2));
            }

            if (format.match(/mm/)) {
                const minutes = date.getMinutes();
                if (isNaN(minutes)) {
                    return '';
                }
                format = format.replace(/mm/, this.zeroPad(minutes, 2));
            }

            if (format.match(/ss/)) {
                const secounds = date.getSeconds();
                if (isNaN(secounds)) {
                    return '';
                }
                format = format.replace(/ss/, this.zeroPad(secounds, 2));
            }
            return format;
        }

        public static strTimestamp(): string {
            const d = new Date();
            const year = d.getFullYear();
            const month = gm.DataUtil.zeroPad(d.getMonth() + 1, 2);
            const date = gm.DataUtil.zeroPad(d.getDate(), 2);
            const hour = gm.DataUtil.zeroPad(d.getHours(), 2);
            const minute = gm.DataUtil.zeroPad(d.getMinutes(), 2);
            const second = gm.DataUtil.zeroPad(d.getSeconds(), 2);
            return year + month + date + hour + minute + second;
        }

        public static formatAmt(val: string | number): string {
            if (!val && val != 0) {
                return '';
            }
            return Number(val).toLocaleString();
        }

        public static arrayChunk = ([...array], size = 1) => {
            return array.reduce((acc, value, index) => index % size ? acc : [...acc, array.slice(index, index + size)], []);
        }

        /** 税接尾語 */
        public static getTaxNm(taxType) {
            if (taxType == 1) {
                return '(税抜)';
            }
            if (taxType == 2) {
                return '(税込)';
            }
            return '';
        }

        /** 数字フォーマット */
        public static formatNum(int: number | string, kanji = true) {
            if (gm.DataUtil.isNumeric(int)) {
                if (kanji) {
                    const digit = ['', '万', '億', '兆', '京'];
                    let ret = '';
                    if (int) {
                        const nums = String(int).replace(/(\d)(?=(\d\d\d\d)+$)/g, "$1,").split(",").reverse();
                        for (let i = 0, len = nums.length; i < len; i++) {
                            if (!nums[i].match(/^[0]+$/)) {
                                nums[i] = nums[i].replace(/^[0]+/g, "");
                                if (nums[i].length == 4) {
                                    nums[i] = nums[i].replace(/(\d)(?=(\d\d\d)+)/g, '$1,');
                                }
                                ret = nums[i] + digit[i] + ret;
                            }
                        }
                    }
                    return ret;
                }
                else {
                    return Number(int).toLocaleString();
                }
            } else {
                return '';
            }
            return '';
        }
    }

    // --------------------------------------------
    // DOM操作共通
    // --------------------------------------------
    export class DomUtil {
        constructor() {
            throw new Error('DomUtilはnewできません。');
        }

        public static disabled(element: JQuery | string, disabled: boolean) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }

            if ($el.length <= 0) {
                return;
            }

            for (let i = 0, len = $el.length; i < len; i++) {
                const $target: JQuery = $el.eq(i);
                if (disabled) {
                    $target.attr('disabled', 'disabled');
                } else {
                    $target.removeAttr('disabled');
                }
            }
        }

        public static hidden(element: JQuery | string, hidden: boolean) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }

            if ($el.length <= 0) {
                return;
            }

            for (let i = 0, len = $el.length; i < len; i++) {
                const $target: JQuery = $el.eq(i);
                if (hidden) {
                    $target.stop(false, true).hide(200);
                } else {
                    $target.stop(false, true).show(200);
                }
            }
        }
        public static scrollForShow($scroll: JQuery, $show: JQuery, height: number = 50) {
            if ($scroll.length) {
                const element = $scroll[0];
                if ((element.scrollHeight - $show.height()) - (element.clientHeight + $scroll.scrollTop()) < height) {
                    $scroll.animate({ scrollTop: $scroll.scrollTop() + $show.height() });
                }
            }
        }

        /** DOMパラメータ設定 */
        public static setParam(element: JQuery | string, value: any, withoutTrigger: boolean = false): JQuery {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }

            if ($el.length <= 0 || !gm.DataUtil.isDefined(value)) {
                return;
            }
            if ($el.is('span') || $el.is('h1') || $el.is('h2') || $el.is('h3') || $el.is('h4') || $el.is('h5') || $el.is('h6')) {
                $el.html(String(value));
            } else if ($el.is('[data-gm-date]')) {
                $el.val(gm.DataUtil.formatDate(value, $el.attr('data-gm-date')));
            } else if ($el.is('[data-gm-html]')) {
                $el.val(String(value));
            } else if ($el.is('[data-gm-color]') || $el.is('[data-gm-range]')
                || $el.is('input[type=text]') || $el.is('input[type=hidden]') || $el.is('input[type=password]') || $el.is('select') || $el.is('textarea')) {
                $el.val(String(value));
                if (!withoutTrigger) $el.change();
            } else if ($el.is('input[type=radio]')) {
                $el.closest('[value=' + String(value) + ']').prop('checked', true);
                if (!withoutTrigger) $el.change();
            } else if ($el.is('input[type=checkbox]')) {
                $el.prop('checked', value == true || value == '1');
                if (!withoutTrigger) $el.change();
            }
            $el.attr('data-cl', gm.DataUtil.htmlEncode(value));

            return $el;
        }

        /** DOMパラメータ取得 */
        public static domParam(element: JQuery | string) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }
            if ($el.length <= 0) {
                return null;
            }

            if ($el.is('input[type=radio]')) {
                return $el.closest(':checked').val()
            } else if ($el.is('span')) {
                return $el.text();
            } else if ($el.is('input[type=checkbox]')) {
                return $el.is(':checked') ? '1' : '0';
            } else if ($el.is('input[type=hidden]')) {
                return $el.val() == 'null' ? '' : $el.val();
            } else if ($el.is('[data-gm-html]')) {
                if ($el.parents('.tmce-active').length) {
                    return tinyMCE.get($el.attr('id')).getContent({ format: 'raw' });
                } else {
                    return $el.val();
                }
            } else {
                return $el.val();
            }
        }

        /** 画像タグ取得 */
        public static imgTag(value: string, movie: boolean = false, youtube: boolean = false, imgWidth: number | string = null) {
            const extentiton = gm.DataUtil.getExtention(value).toLowerCase();
            const patternMovie = new RegExp("mp4|mov");
            if (youtube && value.indexOf('https://www.youtube.com/') === 0) {
                const src = value.replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/');
                return '<iframe class="gm-prod-tbl-video" width="200" src="' + src + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>';
            }
            else if (movie && patternMovie.test(extentiton)) {
                return '<video class="gm-prod-tbl-video" src="' + value + '" autoplay="" loop="" preload="none" playsinline="playsinline" muted></video>';
            }

            let styleWidth = '';
            if (imgWidth) {
                styleWidth = 'max-width:' + imgWidth + 'px;';
            }
            return '<img src="' + value + '" style="' + styleWidth + '" />';
        }

        public static clear(element: JQuery | string) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }
            for (let i = 0, len = $el.length; i < len; i++) {
                const $target: JQuery = $el.eq(i);
                if ($target.is('input[type=radio]')) {
                    const bool = ($target.attr('data-cl') === $target.val() ? true : false);
                    $target.prop('checked', bool).change();
                } else if ($target.is('input[type=checkbox]')) {
                    $target.prop('checked', $target.attr('data-cl') === '1').change();
                } else if ($target.is('input[type=text]') || $target.is('input[type=password]') || $target.is('select') || $target.is('textarea')) {
                    const decodeVal = gm.DataUtil.htmlDecode($target.attr('data-cl'));
                    if ($target.val() != decodeVal) {
                        $target.val(decodeVal);
                        $target.change();
                    }
                } else if ($target.is('span')) {
                    $target.html($target.attr('data-cl'));
                }
            }
        }

        public static clearAll($el?: JQuery) {
            if (!gm.DataUtil.isDefined($el)) {
                $el = jQuery();
            }
            const $targets = $el.find('[data-cl]');
            for (let i = 0, len = $targets.length; i < len; i++) {
                gm.DomUtil.clear(jQuery($targets[i]));
            }
        }

        /** オブジェクトからプルダウンを生成する */
        public static objToOption<T>(modelList: T[], keyValue: string, keyText: string, selectedValue: string = ''): string {
            let ret = '';
            if (modelList) {
                for (let i = 0, len = modelList.length; i < len; i++) {
                    const model: T = modelList[i];
                    const value = model[keyValue];
                    const text = model[keyText];
                    let selected = '';
                    if (selectedValue && selectedValue == value) {
                        selected = 'selected="selected"';
                    }

                    ret += '<option value="' + value + '" ' + selected + '>' + text + '</option>';
                }
            }
            return ret;
        }


        /** オブジェクトからチェックボックスリストを生成する */
        public static objToCheckbox<T>(modelList: T[], keyValue: string, keyText: string, name: string, checkedValues: string[] = []): string {
            let ret = '';
            if (modelList) {
                for (let i = 0, len = modelList.length; i < len; i++) {
                    const model: T = modelList[i];
                    const value = model[keyValue];
                    const text = model[keyText];
                    let checked = '';

                    for (let j = 0, len2 = checkedValues.length; j < len2; j++) {
                        const checkedValue = checkedValues[j];
                        if (checkedValue && checkedValue == value) {
                            checked = 'checked="checked"';
                            break;
                        }
                    }
                    ret += '<div><label><input type="checkbox" name="' + name + '" value="' + value + '" ' + checked + '>' + text + '</label></div>';
                }
            }
            return ret;
        }
    }
    // --------------------------------------------
    // メッセージ
    // --------------------------------------------
    /**
     * メッセージオブジェクト定義
     */
    export interface Message {
        /** メッセージID */
        id: string;

        /** メッセージ */
        message: string;
    }

    /**
     * メッセージ管理抽象クラス
     */
    export abstract class AbstractMessages {
        protected static messageList: Message[];

        constructor() {
            throw new Error("このクラスはインスタンス生成できません。");
        }

        /**
         * メッセージ取得
         */
        public static getMessage(messageId: string, ...args: (string | number)[]): string {
            const messageList: Message[] = this.messageList;
            let message: string = null;

            for (let tmpMessage of messageList) {
                if (tmpMessage.id == messageId) {
                    message = tmpMessage.message;
                }
            }

            if (!gm.DataUtil.isEmpty(message)) {
                if (args.length >= 1) {
                    message = gm.DataUtil.format(message, args);
                }
            }

            return message;
        }
    }

    // --------------------------------------------
    // テーブル
    // --------------------------------------------
    export class Table {
        constructor() {
            throw new Error('Tableはnewできません。');
        }

        public static create($table: JQuery, opt: Object) {
            const optBase = {
                language: {
                    "emptyTable": "テーブルにデータがありません",
                    "info": " _TOTAL_ 件中 _START_ から _END_ まで表示",
                    "infoEmpty": " 0 件中 0 から 0 まで表示",
                    "infoFiltered": "（全 _MAX_ 件より抽出）",
                    "infoThousands": ",",
                    "lengthMenu": "_MENU_ 件表示",
                    "loadingRecords": "読み込み中...",
                    "processing": "処理中...",
                    "search": "検索:",
                    "zeroRecords": "一致するレコードがありません",
                    "paginate": {
                        "first": "先頭",
                        "last": "最終",
                        "next": "次",
                        "previous": "前"
                    },
                    "aria": {
                        "sortAscending": ": 列を昇順に並べ替えるにはアクティブにする",
                        "sortDescending": ": 列を降順に並べ替えるにはアクティブにする"
                    }
                },
                pageLength: -1,
                destroy: true,
                stateSave: false,
                dom: 'tip',

            };

            return $table.DataTable(jQuery.extend(optBase, opt));
        }
    }

    // --------------------------------------------
    // モーダル
    // --------------------------------------------
    export class Modal {
        private static BASE = `
        <form class="gm-modal" data-gm-modal="{modalCnt}">
            <input type="text" style="display:none" palceholder="Enter対策">
            <div class="gm-modal-header">
                <div class="gm-modal-header-left">
                    <h2 class="gm-modal-title">{title}</h2>
                </div>
                <div class="gm-modal-header-right">
                    <a class="button-secondary gm-modal-close" data-gm-modal-close>×</a>
                </div>
            </div>
            <div class="gm-modal-body" data-gm-modal-body>{body}</div>
            <div class="gm-modal-footer">{btns}</div>
        </form>`;

        static modalCnt = 0;

        private $modal: JQuery = null;

        constructor($modal: JQuery) {
            const me = this;
            me.$modal = $modal;
            Modal.modalCnt++;
        }

        /** Moal生成 */
        public static createModal(title: string, btns: string, body: string, selector: string = gm.COVER_SELECTOR): JQuery {
            const base = gm.DataUtil.format(Modal.BASE, {
                title: title,
                btns: btns,
                body: body,
                modalCnt: Modal.modalCnt
            });

            const $modal: JQuery = jQuery(selector).append(base).find('[data-gm-modal="' + Modal.modalCnt + '"]');
            $modal.find('[data-gm-modal-close]').on('click', this, function (event: JQueryEventObject) {
                gm.Modal.remove($modal);
            });
            $modal.find('[data-gm-modal-close]').attr('original-title', '閉じる').tipsy({
                trigger: 'hover',
                opacity: 1.0,
            });

            jQuery(document).on('keydown.modalEsc', function (event) {
                if (event.keyCode === 27) {
                    gm.Modal.remove($modal);
                }
            });
            return $modal;
        }

        /** Moal表示 */
        public show(needsValidator: boolean = true) {
            const me = this;
            const $modal = me.$modal;

            // バリデーター
            if (needsValidator) {
                gm.Validation.initValidator('[data-gm-modal]');
                gm.Validation.setValidator($modal);
            }

            jQuery(':focus').blur();
            //背景のカバーを追加
            $modal.wrap('<div class="gm-modal-cover" style="display:none;" data-gm-modal-count="' + Modal.modalCnt + '"></div>');
            $modal.closest('.gm-modal-cover').prepend('<a class="gm-modal-coverbase"></a>');

            gm.MenuUtil.setNoOptMessage($modal);
            gm.MenuUtil.setRequiredMark($modal);
            gm.MenuUtil.setMenuQuestion($modal.find('[data-gm-modal-body]'));

            //スクロール禁止処理
            jQuery('html').css('overflow-y', 'hidden');

            //モーダルを表示
            $modal.show();
            $modal.closest('.gm-modal-cover').stop().fadeIn(200);
            //topとleftで表示位置を調整
            $modal.css({
                'position': 'relative',
            });
            let $notFocusObj = jQuery('#pagewrap');
            if (Modal.modalCnt > 1) {
                $notFocusObj = jQuery('[data-gm-modal-count=' + String(Modal.modalCnt - 1) + ']');
            }
            $notFocusObj.find('input, select, a').each(function () {
                const $target = jQuery(this);
                $target.attr('tabindex', '-1');
            });
            gm.MenuUtil.setStickyTh($modal);
        }

        /** Moal閉じる */
        public hide(me: Modal = this, callback: () => void = jQuery.noop) {
            gm.Modal.remove(me.$modal);
            callback();
        }

        private static remove($modal: JQuery) {
            Modal.modalCnt--;
            $modal.closest('.gm-modal-cover').stop().fadeOut(200, function () {
                //スクロール禁止処理解除
                jQuery('html').css('overflow-y', 'auto');
                $modal.unwrap().prev().remove();
                $modal.remove();
            });
            jQuery(document).off('keydown.modalEsc');
            jQuery('.tipsy').remove();
        }
    }



    // --------------------------------------------
    // ローディングマスク
    // --------------------------------------------
    export class Mask {
        private static openTime: number;

        constructor() {
            throw new Error('Maskはnewできません。');
        }
        public static show(selector: string = gm.ROOT_SELECTOR) {
            if (jQuery('.gm-loading-mask').length == 0) {
                // jQuery(selector).append('<div class="gm-loading-mask"><img class="loading-icon" src="'+gmCommonAssetsPath+'/images/loading.svg" width="100" height="100"></div>');
                jQuery(selector).append(`
                <div class="gm-loading-mask">
                    <div class="gm-loading-mask-icon">
                        <div class="gm-loading-mask-icon-balls">
                            <span></span>
                            <span></span>
                        
                            <span></span>
                        </div>
                        <div class="gm-loading-mask-icon-shadows">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="gm-loading-mask-icon-label">Loading</div>
                    </div>
                </div>
                `);
                Mask.openTime = Date.now();
            }
        }

        public static hide() {
            setTimeout(function () {
                if (Date.now() - Mask.openTime < 500) {
                    setTimeout(function () {
                        Mask.hide();
                    }, 250);
                    return;
                }
                jQuery('.gm-loading-mask').fadeOut(200).queue(function () {
                    this.remove();
                });
            }, 0);
        }
    }

    // --------------------------------------------
    // スピナー
    // --------------------------------------------
    export class Spinner {

        constructor() {
            throw new Error('Spinnerはnewできません。');
        }

        public static create(size: number = 20, color: string = '') {
            let styleSize = '';
            if (size) {
                styleSize = 'height:' + size + 'px;width:' + size + 'px;border-width: ' + Math.round(size / 5) + 'px;';
            }
            let styleColor = '';
            if (color) {
                styleColor = 'border-color:' + color + ';border-top-color: transparent;';
            }
            return '<div class="gm-spinner" style="' + styleSize + styleColor + '"></div>';
        }

        public static show(element: JQuery | string, size: number = 25, color: string = '') {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }
            $el.append(Spinner.create(size, color));
        }

        public static remove(element: JQuery | string) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }

            $el.find('.gm-spinner').remove();
        }
    }

    // --------------------------------------------
    // トースト
    // --------------------------------------------
    export class Toast {
        constructor() {
            throw new Error('Toastはnewできません。');
        }
        public static info(text, heading = '') {
            jQuery.toast({
                text: text,
                heading: heading,
                showHideTransition: 'slide',
                allowToastClose: true,
                progressBar: false,
                loader: false,
                hideAfter: 4000,
                stack: false,
                position: 'bottom-right',
                bgColor: '#0071a1',
                textColor: '#fff',
                textAlign: 'left',
            });
        }
        public static success(text, heading = '') {
            jQuery.toast({
                text: text,
                heading: heading,
                showHideTransition: 'slide',
                allowToastClose: true,
                progressBar: false,
                loader: false,
                hideAfter: 6000,
                stack: false,
                position: 'bottom-right',
                bgColor: '#393',
                textColor: '#fff',
                textAlign: 'left',
            });
        }
        public static error(text, heading = 'エラー') {
            jQuery.toast({
                text: text,
                heading: heading,
                showHideTransition: 'slide',
                allowToastClose: true,
                progressBar: false,
                loader: false,
                hideAfter: 6000,
                stack: false,
                position: 'bottom-right',
                bgColor: '#e22',
                textColor: '#fff',
                textAlign: 'left',
            });
        }
    }

    // --------------------------------------------
    // パーツ
    // --------------------------------------------
    export class Parts {
        constructor() {
            throw new Error('Partsはnewできません。');
        }

        public static setDatePicker($parent: JQuery) {
            const $targets: JQuery = $parent.find('[data-gm-date]:not([data-gm-prepared-date-picker=true])');
            const option = {
                changeMonth: true,
                changeYear: true,
                buttonImageOnly: true,
                showMonthAfterYear: true,
                showButtonPanel: true,
                isRTL: false,
                showOn: "both",
                currentText: '今日',
                closeText: '閉じる',
                buttonImage: '/wp-content/themes/sango-theme-child-garage/assets/images/calendar.svg',
                buttonText: 'カレンダー',
                showAnim: 'fadeIn',
                monthNamesShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
                dayNamesMin: ["日", "月", "火", "水", "木", "金", "土"],
                prevText: "&#x3C;前",
                nextText: "次&#x3E;",
                dateFormat: 'yy/mm/dd',
                onClose: function (dateText: string, inst: any) {
                    jQuery(this).blur();
                },
                beforeShowDay: function (date: Date) {
                    let result;
                    switch (date.getDay()) {
                        case 0: // 日曜日
                            result = [true, "date-sunday"];
                            break;
                        case 6: // 土曜日
                            result = [true, "date-saturday"];
                            break;
                        default:
                            result = [true, ""];
                            break;
                    }
                    return result;
                }
            };

            for (let i = 0, len = $targets.length; i < len; i++) {
                const $target: JQuery = $targets.eq(i);
                $target.wrap('<div class="gm-input-datepicker-wrap">');
                const type = $target.attr('data-gm-date');
                if (type == 'yyyy/MM/dd') {
                    $target.datepicker(option);
                } else if (type == 'yyyy/MM/dd hh:mm') {
                    $target.datetimepicker(option);
                }
                
                $target.attr('autocomplete', 'off');
                $target.attr('data-gm-prepared-date-picker', 'true');
            }
        }

        static htmlEditorCnt = 0;
        public static setHtmlEditor($parent: JQuery) {
            const $inputs: JQuery = $parent.find('[data-gm-html]:not([data-gm-prepared-html-editor=true])');
            for (let i = 0, len = $inputs.length; i < len; i++) {
                const $input: JQuery = $inputs.eq(i);
                if (!$input.attr('id')) {
                    $input.attr('id', 'gm-html-editor' + Parts.htmlEditorCnt);
                }

                $input.ready(function () {
                    wp.editor.initialize($input.attr('id'), {
                        mediaButtons: true,
                        tinymce: true,
                        quicktags: true
                    });
                });

                $input.attr('data-gm-prepared-html-editor', 'true');

                Parts.htmlEditorCnt++
            }

        }


        public static setImgPicker($parent: JQuery) {
            const $inputs: JQuery = $parent.find('[data-gm-img]:not([data-gm-prepared-img-picker=true])');
            for (let i = 0, len = $inputs.length; i < len; i++) {
                const $input: JQuery = $inputs.eq(i);

                let styleWidth = '';
                const imgWidth = $inputs.attr('data-gm-img-width');
                if (imgWidth) {
                    styleWidth = 'max-width:' + imgWidth + 'px;';
                }

                $input.wrap('<div class="gm-input-img-wrap">');
                const $add: JQuery = jQuery('<input type="button" class="gm-text-button gm-secondary-button" value="選択"/>');
                const $clear: JQuery = jQuery('<input type="button" class="gm-text-button gm-negative-button" value="クリア" />');
                const $thumbnail: JQuery = jQuery('<div class="gm-img-area" style="' + styleWidth + '"></div>');
                $input.after($add);
                $add.after($clear);
                $clear.after($thumbnail);

                const showImg = !$input.is('[data-gm-img="0"]');
                if (showImg) {
                    $input.on('change', this, function (event: JQueryEventObject) {
                        $thumbnail.empty();
                        if (!$input.find('.gm-has-error').length) {
                            const value = $input.val();
                            $thumbnail.append(gm.DomUtil.imgTag(value, $input.is('[data-gm-movie]'), $input.is('[data-gm-youtube]'), imgWidth));
                        }
                    });
                }

                $add.on('click', this, function (event: JQueryEventObject) {
                    const $uploader: JQuery = wp.media({
                        title: "画像を選択してください",
                        library: {
                            type: "image"
                        },
                        button: {
                            text: "画像の選択"
                        },
                        multiple: false
                    });

                    $uploader.on("select", function (event: JQueryEventObject) {
                        const images = $uploader.state().get("selection");
                        images.each(function (file) {
                            const url = file.attributes.sizes.full.url;
                            $input.val('');
                            $thumbnail.empty();
                            $input.val(url).change();
                        });
                    });

                    $uploader.open();
                });

                $clear.on('click', this, function (event: JQueryEventObject) {
                    $input.val('');
                    $thumbnail.empty();
                    $input.change();
                });

                $input.attr('data-gm-prepared-img-picker', 'true');
            }
        }


        public static setColorPicker($parent: JQuery) {
            const $inputs: JQuery = $parent.find('[data-gm-color]:not([data-gm-prepared-color-picker=true])');
            for (let i = 0, len = $inputs.length; i < len; i++) {
                const $input: JQuery = $inputs.eq(i);
                $input.wpColorPicker();
                $input.attr('data-gm-prepared-color-picker', 'true');
            }
        }

        public static setNumPicker($parent: JQuery) {
            const $inputs: JQuery = $parent.find('[data-gm-number]:not([data-gm-prepared-num-picker=true])');
            for (let i = 0, len = $inputs.length; i < len; i++) {
                const $input: JQuery = $inputs.eq(i);
                if ($input.attr('readonly') || $input.attr('disabled')) {
                    continue;
                }
                $input.wrap('<div class="gm-input-num-wrap">');
                $input.attr('data-gm-prepared-num-picker', 'true');
            }
        }


        public static setRangePicker($parent: JQuery) {
            const $inputs: JQuery = $parent.find('[data-gm-range]:not([data-gm-prepared-range-picker=true])');
            for (let i = 0, len = $inputs.length; i < len; i++) {
                const $input: JQuery = $inputs.eq(i);
                $input.wrap('<div class="gm-input-range-wrap">');
                const $point: JQuery = jQuery('<div class="gm-input-range-point"></div>');
                $input.before($point);

                $input.on('change', this, function (event: JQueryEventObject) {
                    $point.text(jQuery(this).val());
                });

                $input.change();

                $input.attr('data-gm-prepared-range-picker', 'true');
            }
        }

        public static setParts(element: JQuery | string) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }

            gm.Parts.setDatePicker($el);
            gm.Parts.setHtmlEditor($el);
            gm.Parts.setImgPicker($el);
            gm.Parts.setColorPicker($el);
            gm.Parts.setNumPicker($el);
            gm.Parts.setRangePicker($el);
        }
    }

    // --------------------------------------------
    // バリデーション
    // --------------------------------------------
    export class Validation {
        constructor() {
            throw new Error("このクラスはインスタンス生成できません。");
        }
        // --------------------------------------
        // バリデーション処理
        // --------------------------------------
        /** 入力チェック */
        public static isValid($el?: JQuery, $scroll: JQuery = jQuery(), ignoreMethods?: string[]) {
            if (!gm.DataUtil.isDefined($el)) {
                $el = jQuery(gm.ROOT_SELECTOR);
            }
            if ($el.length <= 0) {
                return;
            }

            let valid: boolean = true;

            // 引数の要素が複数件ある場合
            if ($el.length > 1) {
                for (let i = 0, len = $el.length; i < len; i++) {
                    if (!gm.Validation.isValid($el.eq(i))) {
                        valid = false;
                    }
                }
            } else {
                let validator: JQueryValidation.Validator = this.validator($el);
                if (gm.DataUtil.isDefined(validator)) {
                    // 対象が入力チェック対象の場合
                    if ($el.is('[data-gm-prepared-validator=true]')) {
                        valid = gm.Validation.isValidWithIgnoreMethods(validator, $el, ignoreMethods);
                    }

                    // 対象の小孫要素の入力チェック
                    let $targets = $el.find('[data-gm-prepared-validator=true]');
                    for (let i = 0, len = $targets.length; i < len; i++) {
                        let $target = $targets.eq(i);
                        if (!gm.Validation.isValidWithIgnoreMethods(validator, $target, ignoreMethods)) {
                            valid = false;
                        }
                    }
                }
            }

            if ($scroll.find('.gm-has-error').length) {
                const $error = $scroll.find('.gm-has-error');
                $scroll.animate({ scrollTop: $error.position().top + $scroll.scrollTop() - jQuery('.gm-modal-header').height() - jQuery('#wpadminbar').height() - jQuery('.gm-input-table-heading-row').eq(0).height() });
            }

            return valid;
        }

        // ---------------------
        // バリデーション処理共通
        // ---------------------
        /**
         * 対象の入力チェックを行う
         * ignoreMethodsに指定のvalidationはエラー表示にはなるが、戻り値のエラー対象とはならない
         */
        private static isValidWithIgnoreMethods(validator: JQueryValidation.Validator, $el: JQuery, ignoreMethods?: string[]): boolean {
            let valid = validator.element($el);

            if (!valid && gm.DataUtil.isDefined(ignoreMethods) && ignoreMethods.length > 0) {
                for (let error of validator.errorList) {
                    // 無視リストに存在しないmethodが含まれる場合はそのままエラーとする
                    if (ignoreMethods.indexOf(error.method) < 0) {
                        return false;
                    }
                }
                valid = true;
            }

            return valid;
        }

        private static validator($el: JQuery = jQuery(gm.ROOT_SELECTOR)): JQueryValidation.Validator {
            if ($el.length > 0) {
                return $el.data('validator');
            }
            return null;
        }


        private static registValidate($el: JQuery) {
            $el = $el.filter(':not([data-gm-prepared-validator])');
            $el.filter(':not([type=checkbox]):not([type=radio])').on('blur.validator', function (event: JQueryEventObject, $target: JQuery, oldValue: any, newValue: any) {
                gm.Validation.kickValidate(jQuery(this));
            });
            $el.filter('input[type=checkbox],input[type=radio]').on('change.validator', function (event: JQueryEventObject) {
                gm.Validation.kickValidate(jQuery(this));
            });
            $el.attr('data-gm-prepared-validator', 'true')
        }

        private static kickValidate($el: JQuery) {
            const validator: JQueryValidation.Validator = this.validator($el);
            if (gm.DataUtil.isDefined(validator)) {
                validator.element($el);
            }
        }

        private static addRules($el: JQuery, name: string, suffix: string = '') {
            name = gm.DataUtil.camelCase(name) + suffix;
            $el.data("rule" + name.charAt(0).toUpperCase() + name.substring(1).toLowerCase(), {});
        }

        private static removeRules($el: JQuery, name: string, suffix: string = '') {
            name = gm.DataUtil.camelCase(name) + suffix;
            $el.removeData("rule" + name.charAt(0).toUpperCase() + name.substring(1).toLowerCase());
        }

        // --------------------------------------
        // バリデーション設定
        // --------------------------------------
        /** 必須 */
        public static setRequired($parent: JQuery, selector: string = '[data-gm-required]:not([data-gm-prepared-required])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmRequired', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-required', 'true');
        }

        /** 文字数（最大） */
        public static setLength($parent: JQuery, selector: string = '[data-gm-length]:not([data-gm-prepared-length])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmLength', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-length', 'true');
        }

        /** 文字数（最低） */
        public static setLengthMin($parent: JQuery, selector: string = '[data-gm-length-min]:not([data-gm-prepared-length-min])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmLengthMin', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-length-min', 'true');
        }

        /** 日付 */
        public static setDate($parent: JQuery, selector: string = '[data-gm-date]:not([data-gm-prepared-date])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmDate', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-date', 'true');
        }

        /** URL */
        public static setUrl($parent: JQuery, selector: string = '[data-gm-url]:not([data-gm-prepared-url])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmUrl', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-url', 'true');
        }

        /** 数値 */
        public static setNumber($parent: JQuery, selector: string = '[data-gm-number]:not([data-gm-prepared-number]),[data-gm-post-select="0"]:not([data-gm-prepared-number]),[data-gm-page-select="0"]:not([data-gm-prepared-number]),[data-gm-cat-select="0"]:not([data-gm-prepared-number]),[data-gm-tag-select="0"]:not([data-gm-prepared-number]),[data-gm-user-select="0"]:not([data-gm-prepared-number])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmNumber', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-number', 'true');
        }

        /** 郵便番号 */
        public static setPostalCode($parent: JQuery, selector: string = '[data-gm-postal-code]:not([data-gm-prepared-postal-code])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmPostalCode', '');
            this.registValidate($el);

            if ($el.attr('data-gm-postal-code')){
                $el.keyup(function(){
                    AjaxZip3.zip2addr(this,'',$el.attr('data-gm-postal-code').split(',')[0],$el.attr('data-gm-postal-code').split(',')[1]);
                })
            }
            $el.attr('data-gm-prepared-postal-code', 'true');
        }

        /** 電話番号 */
        public static setPhone($parent: JQuery, selector: string = '[data-gm-phone]:not([data-gm-prepared-phone])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmPhone', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-phone', 'true');
        }

        /** メールアドレス */
        public static setEmail($parent: JQuery, selector: string = '[data-gm-email]:not([data-gm-prepared-email])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmEmail', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-email', 'true');
        }

        /** 全角カナ */
        public static setZenKatakana($parent: JQuery, selector: string = '[data-gm-zen-katakana]:not([data-gm-prepared-zen-katakana])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmZenKatakana', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-zen-katakana', 'true');
        }
        
        /** パスワード */
        public static setPassword($parent: JQuery, selector: string = '[data-gm-password]:not([data-gm-prepared-password])') {
            const $el = $parent.find(selector);
            this.addRules($el, 'gmPassword', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-password', 'true');
        }

        // ---------------------
        // バリデーション設定共通
        // ---------------------
        /** 必須チェック内部処理 */
        private static requiredInner(value: any, required: boolean = true): boolean {
            let ret = true;
            if (required) {
                if (value == null) {
                    ret = false;
                } else {
                    if (gm.DataUtil.isString(value)) {
                        if (DataUtil.isEmpty(value as string)) {
                            ret = false;
                        }
                    }
                }
            }
            return ret;
        }

        /** 日付のフォーマット */
        public static isValidDate(value: string, format: string, required: boolean = true): boolean {
            if (!this.requiredInner(value, required)) {
                return false;
            } else if (!gm.DataUtil.isEmpty(value)) {
                if (!value.match(/^\d{4}\/\d{2}\/\d{2}$/) && !value.match(/^\d{4}\/\d{2}\/\d{2} \d{2}\:\d{2}$/)) {
                    return false;
                }
                if (!gm.DataUtil.formatDate(value, format)) {
                    return false;
                }
                return true;
            }
            return false;
        }


        // --------------------------------------
        // バリデーション初期化
        // --------------------------------------
        public static initValidator(element: JQuery | string) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }

            // jquery.validate.js をオーバーライドしています。
            // メソッド内のコメントアウトは jquery.validate.js に記載されてある記述です。
            jQuery.extend(jQuery.fn, {
                // http://jqueryvalidation.org/rules/
                rules: function (command, argument) {
                    var element = this[0],
                        settings, staticRules, existingRules, data, param, filtered;

                    var validator: any = jQuery.validator;
                    if (command) {
                        settings = jQuery.data(element.form, 'validator').settings;
                        staticRules = settings.rules;
                        existingRules = validator.staticRules(element);
                        switch (command) {
                            case 'add':
                                jQuery.extend(existingRules, validator.normalizeRule(argument));
                                // remove messages from rules, but allow them to be set separately
                                delete existingRules.messages;
                                staticRules[element.name] = existingRules;
                                if (argument.messages) {
                                    settings.messages[element.name] = $.extend(settings.messages[element.name], argument.messages);
                                }
                                break;
                            case 'remove':
                                if (!argument) {
                                    delete staticRules[element.name];
                                    return existingRules;
                                }
                                filtered = {};
                                jQuery.each(argument.split(/\s/), function (index, method) {
                                    filtered[method] = existingRules[method];
                                    delete existingRules[method];
                                    if (method === 'required') {
                                        jQuery(element).removeAttr('aria-required');
                                    }
                                });
                                return filtered;
                        }
                    }

                    data = validator.normalizeRules(
                        jQuery.extend(
                            {},
                            validator.classRules(element),
                            validator.attributeRules(element),
                            validator.dataRules(element),
                        ), element);

                    // 日付の前後比較を行うために、requiredの必須チェックを強制的に最初に行う処理は省略する
                    // make sure required is at front
                    //              if ( data.required ) {
                    //                  param = data.required;
                    //                  delete data.required;
                    //                  data = $.extend( { required: param }, data );
                    //                  jQuery( element ).attr( 'aria-required', 'true' );
                    //              }

                    // make sure remote is at back
                    if (data.remote) {
                        param = data.remote;
                        delete data.remote;
                        data = jQuery.extend(data, { remote: param });
                    }

                    return data;
                }
            });

            jQuery.validator.setDefaults({
                errorClass: 'gm-has-error',
                success: function ($label: JQuery, element: HTMLElement) {
                    const $el: JQuery = jQuery(element);

                    if (gm.DataUtil.isDefined($el) && $el.length > 0) {
                        $el.tipsy('hide');
                        $el.off('mouseenter mouseleave');
                        $el.removeData('tipsy');
                    }
                },
                errorPlacement: function ($error: JQuery, $el: JQuery) {
                    const errorText: string = $error.text();
                    if (gm.DataUtil.isDefined($el) && $el.length > 0) {
                        $el.tipsy('hide');
                        $el.off('mouseenter mouseleave');
                        $el.removeData('tipsy');
                        if (errorText) {
                            $el.attr('original-title', errorText);
                            let tipsyGravity = $el.attr('data-gm-tipsy-gravity');
                            if (!gm.DataUtil.isDefined(tipsyGravity)) {
                                tipsyGravity = 'w';
                            }
                            $el.tipsy({
                                trigger: 'hover',
                                gravity: tipsyGravity,
                                opacity: 1.0,
                                className: 'validation-error'
                            });
                        }
                    }
                }
            });

            $el.validate();
            this.setValidator($el);

            // --------------------
            // バリデーション定義
            // --------------------
            /** 必須 */
            jQuery.validator.addMethod('gmRequired', function (value, element: HTMLElement, params): boolean {
                const $el = jQuery(element);
                if ($el.is('input[type=radio]')) {
                    return $el.closest(':checked').length != 0;
                } else {
                    return !gm.DataUtil.isEmpty(value);
                }
            }, '必須入力です。');

            /** 文字数 */
            jQuery.validator.addMethod('gmLength', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const $el = jQuery(element).closest('[data-gm-length]');
                    const length = Number($el.attr('data-gm-length'));
                    const len = value.length;
                    return (len <= length);
                }
            }, function (params, element) {
                const $el = jQuery(element).closest('[data-gm-length]');
                const placeHolder = Number($el.attr('data-gm-length'));
                return placeHolder + '文字以下で入力してください。';
            });

            /** 文字数 */
            jQuery.validator.addMethod('gmLengthMin', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const $el = jQuery(element).closest('[data-gm-length-min]');
                    const length = Number($el.attr('data-gm-length-min'));
                    const len = value.length;
                    return (length <= len);
                }
            }, function (params, element) {
                const $el = jQuery(element).closest('[data-gm-length-min]');
                const placeHolder = Number($el.attr('data-gm-length-min'));
                return placeHolder + '文字以上で入力してください。';
            });

            /** 日付 */
            jQuery.validator.addMethod('gmDate', function (value, element: HTMLElement, params): boolean {
                const format = jQuery(element).attr('data-gm-date');
                const result = this.optional(element) || gm.Validation.isValidDate(value, format ? format : 'yyyy/MM/dd');
                return result ? true : false;
            }, '日付が正しくありません。');

            /** URL */
            jQuery.validator.addMethod('gmUrl', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    // URLの形式チェック（日本語URLも許可）
                    const pattern = new RegExp('^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$', 'i');
                    const patternJP = new RegExp('^(https?:\\/\\/[\\w\\-\\.\\/\\?\\,\\#\\:\\u3000-\\u30FE\\u4E00-\\u9FA0\\uFF01-\\uFFE3]+)/');
                    return pattern.test(value) || patternJP.test(value) ? true : false;
                }
            }, 'URLが正しくありません。');

            /** 数値 */
            jQuery.validator.addMethod('gmNumber', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    if (gm.DataUtil.isNumeric(value)) {
                        const $el: JQuery = jQuery(element);
                        const min = $el.attr('data-min');
                        if (gm.DataUtil.isDefined(min) && Number(value) < Number(min)) {
                            return false;
                        }
                        const max = $el.attr('data-max');
                        if (gm.DataUtil.isDefined(max) && Number(max) < Number(value)) {
                            return false;
                        }
                        return true;
                    } else {
                        return false;
                    }
                }
            }, function (params, element: HTMLElement) {
                const $el: JQuery = jQuery(element).closest('[data-gm-number]');
                const value: string = $el.val();
                const min = $el.attr('data-min');
                if (gm.DataUtil.isDefined(min) && Number(value) < Number(min)) {
                    return min + '以上で入力してください。';
                }
                const max = $el.attr('data-max');
                if (gm.DataUtil.isDefined(max) && Number(max) < Number(value)) {
                    return max + '以下で入力してください。';
                }
                return '数値で入力してください。';
            });



            /** 郵便番号 */
            jQuery.validator.addMethod('gmPostalCode', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const pattern = new RegExp(/^[0-9]{3}-[0-9]{4}$/);
                    return pattern.test(value);
                }
            }, '「-」を含む郵便番号形式で入力してください。');

            /** 電話番号 */
            jQuery.validator.addMethod('gmPhone', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const pattern = new RegExp(/^0\d{1,4}-\d{1,4}-\d{3,4}$/);
                    return pattern.test(value);
                }
            }, '「-」を含む電話番号形式で入力してください。');

            /** メールアドレス */
            jQuery.validator.addMethod('gmEmail', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const pattern = new RegExp(/^[A-Za-z0-9]+(?:[._-][A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$/i);
                    return pattern.test(value);
                }
            }, 'Eメールアドレス形式で入力してください。');


            /** 全角カタカナ */
            jQuery.validator.addMethod('gmZenKatakana', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const pattern = new RegExp(/^[ァ-ンヴー]*$/);
                    return pattern.test(value);
                }
            }, '全角カタカナで入力してください。');

            /** パスワード */
            jQuery.validator.addMethod('gmPassword', function (value, element: HTMLElement, params): boolean {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    const pattern = new RegExp(/^[A-Za-z0-9!"#\$%&'\(\)\-\^\\\@\[;:\],\.\/=~\|`\{\+\*\}<>?_]+$/);
                    return pattern.test(value);
                }
            }, 'パスワードに使用できない文字が入力されています。');




        }

        /** バリデーション設定 */
        public static setValidator(element: JQuery | string) {
            let $el: JQuery = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            } else {
                $el = element as JQuery;
            }
            gm.Validation.setRequired($el);
            gm.Validation.setLength($el);
            gm.Validation.setLengthMin($el);
            gm.Validation.setDate($el);
            gm.Validation.setUrl($el);
            gm.Validation.setNumber($el);
            gm.Validation.setPostalCode($el);
            gm.Validation.setPhone($el);
            gm.Validation.setEmail($el);
            gm.Validation.setZenKatakana($el);
            gm.Validation.setPassword($el);
        }
    }

    // --------------------------------------------
    // その他
    // --------------------------------------------
    export function submit(element: JQuery | string) {
        let $el: JQuery = null;
        if (gm.DataUtil.isString(element)) {
            $el = jQuery(element);
        } else {
            $el = element as JQuery;
        }

        if ($el.length <= 0) {
            return;
        }
        $el.submit();
    }

}

// エントリーポイント
jQuery(function () {
    if (gm.DataUtil.isDefined(jQuery.fn.tipsy)) {
        jQuery.extend(jQuery.fn.tipsy.defaults, {
            fade: true,
            html: false
        });
    }

    if (jQuery('#gm-page-form').length){
        gm.Parts.setParts('#gm-page-form');
        gm.Validation.initValidator('#gm-page-form');
    }

    // 各画面初期処理
    const applications = gm.applications;
    if (gm.DataUtil.isDefined(applications)) {
        for (let i = 0, len = applications.length; i < len; i++) {
            applications[i].init(window.args);
        }
    }

    delete window.args;
});