var __spreadArray = (this && this.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};
var gm;
(function (gm) {
    gm.ROOT_SELECTOR = location.pathname.indexOf('/wp-admin/') >= 0 ? '#wpbody' : 'body';
    gm.COVER_SELECTOR = location.pathname.indexOf('/wp-admin/') >= 0 ? '#wpwrap' : 'body';
    gm.applications = [];
    var AbstractApplication = (function () {
        function AbstractApplication() {
        }
        return AbstractApplication;
    }());
    gm.AbstractApplication = AbstractApplication;
    function ready(app) {
        gm.applications.push(app);
    }
    gm.ready = ready;
    var MenuUtil = (function () {
        function MenuUtil() {
            throw new Error('MenuUtilはnewできません。');
        }
        MenuUtil.errorReload = function (message) {
            if (message === void 0) { message = ''; }
            if (!message) {
                message = 'エラーが発生しました。\n恐れ入りますが、しばらく待って再度お試しください。';
            }
            alert(message);
            location.reload();
        };
        MenuUtil.setRequiredMark = function ($el) {
            var $targets = $el.find('[data-gm-required-th]');
            for (var i = 0, len = $targets.length; i < len; i++) {
                $targets.eq(i).removeAttr('data-gm-required-th').append('<span class="gm-input-required">*</span>');
            }
        };
        MenuUtil.setStickyTh = function ($el) {
            var $targets = $el.find('[data-gm-sticky-th]');
            for (var i = 0, len = $targets.length; i < len; i++) {
                var $target = $targets.eq(i);
                var height = jQuery($target.attr('data-gm-sticky-th')).outerHeight() - 1;
                $target.find('thead th').css({ 'position': 'sticky', 'z-index': 20, 'top': height + 'px' });
            }
        };
        MenuUtil.setMenuQuestion = function ($el) {
            var $targets = $el.find('[data-gm-menu-question]');
            $targets.on('click', function (event) {
                var $explanation = jQuery(jQuery(event.delegateTarget).attr('data-gm-menu-question'));
                gm.DomUtil.hidden($explanation, $explanation.is(':visible'));
            });
            $targets.attr('original-title', 'ヘルプ');
            $targets.tipsy({
                trigger: 'hover',
                opacity: 1.0
            });
        };
        MenuUtil.setNoOptMessage = function ($el) {
            var $targets = $el.find('[data-gm-no-opt-show]');
            for (var i = 0, len = $targets.length; i < len; i++) {
                var $target = $targets.eq(i);
                var $select = jQuery($target.attr('data-gm-no-opt-show'));
                var noOpt = $select.find('option:not([value=""])').length ? true : false;
                gm.DomUtil.hidden($target, noOpt);
            }
        };
        MenuUtil.modeSetting = function ($modal, mode) {
            if (mode == 'update') {
                gm.DomUtil.disabled($modal.find('[data-gm-key],[data-gm-no-change]'), true);
            }
        };
        MenuUtil.getTargetData = function (list, value, keyId, keyValue) {
            for (var i = 0, len = list.length; i < len; i++) {
                var model = list[i];
                if (model[keyId] == value) {
                    return model[keyValue];
                }
            }
            return null;
        };
        MenuUtil.getTargetModel = function (list, keys, ids) {
            var lenList = list.length;
            var lenKeys = keys.length;
            var keyObj = {};
            for (var i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            var _loop_1 = function (i) {
                var ret = list[i];
                var cnt = 0;
                Object.keys(keyObj).forEach(function (key) {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    return { value: ret };
                }
            };
            for (var i = 0; i < lenList; i++) {
                var state_1 = _loop_1(i);
                if (typeof state_1 === "object")
                    return state_1.value;
            }
            return null;
        };
        MenuUtil.getTargetList = function (list, keys, ids) {
            var lenList = list.length;
            var lenKeys = keys.length;
            var keyObj = {};
            var retList = [];
            for (var i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            var _loop_2 = function (i) {
                var ret = list[i];
                var cnt = 0;
                Object.keys(keyObj).forEach(function (key) {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    retList.push(ret);
                }
            };
            for (var i = 0; i < lenList; i++) {
                _loop_2(i);
            }
            return retList;
        };
        MenuUtil.addListModel = function (list, model, callback) {
            if (callback === void 0) { callback = jQuery.noop; }
            location.reload();
        };
        MenuUtil.addListModels = function (list, models, callback) {
            if (callback === void 0) { callback = jQuery.noop; }
            for (var i = 0, len = models.length; i < len; i++) {
                var model = models[i];
                list.push(model);
            }
            callback();
        };
        MenuUtil.updateListModel = function (list, keys, model, callback) {
            if (callback === void 0) { callback = jQuery.noop; }
            var lenList = list.length;
            var lenKeys = keys.length;
            var keyObj = {};
            for (var i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = model[keys[i]];
            }
            var _loop_3 = function (i) {
                var ret = list[i];
                var cnt = 0;
                Object.keys(keyObj).forEach(function (key) {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    list[i] = model;
                    callback();
                    return { value: void 0 };
                }
            };
            for (var i = 0; i < lenList; i++) {
                var state_2 = _loop_3(i);
                if (typeof state_2 === "object")
                    return state_2.value;
            }
        };
        MenuUtil.removeListModel = function (list, keys, ids, callback) {
            if (callback === void 0) { callback = jQuery.noop; }
            var lenList = list.length;
            var lenKeys = keys.length;
            var keyObj = {};
            for (var i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            var _loop_4 = function (i) {
                var ret = list[i];
                var cnt = 0;
                Object.keys(keyObj).forEach(function (key) {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    list.splice(i, 1);
                    callback();
                    return "break";
                }
            };
            for (var i = 0; i < lenList; i++) {
                var state_3 = _loop_4(i);
                if (state_3 === "break")
                    break;
            }
        };
        MenuUtil.removeListModels = function (list, keys, ids, callback) {
            if (callback === void 0) { callback = jQuery.noop; }
            var lenList = list.length;
            var lenKeys = keys.length;
            var keyObj = {};
            for (var i = 0; i < lenKeys; i++) {
                keyObj[keys[i]] = ids[i];
            }
            var _loop_5 = function (i) {
                var ret = list[i];
                var cnt = 0;
                Object.keys(keyObj).forEach(function (key) {
                    if (keyObj[key] == ret[key]) {
                        cnt++;
                    }
                });
                if (cnt == lenKeys) {
                    list.splice(i, 1);
                }
            };
            for (var i = lenList - 1; 0 <= i; i--) {
                _loop_5(i);
            }
            callback();
        };
        MenuUtil.createAnchorId = function (prod_id, cv_type, no, cv_id) {
            if (no === void 0) { no = 0; }
            if (cv_id === void 0) { cv_id = ''; }
            if (gm.DataUtil.isEmpty(cv_type)) {
                return '';
            }
            if (gm.DataUtil.isEmpty(prod_id) && gm.DataUtil.isEmpty(cv_id)) {
                return '';
            }
            return 'gm-cv-' + prod_id + '-' + cv_type + '-' + no + '-' + cv_id;
        };
        return MenuUtil;
    }());
    gm.MenuUtil = MenuUtil;
    var DataUtil = (function () {
        function DataUtil() {
            throw new Error('DataUtilはnewできません。');
        }
        DataUtil.isUndefined = function (obj) {
            return jQuery.type(obj) === 'undefined';
        };
        DataUtil.isNull = function (obj) {
            return jQuery.type(obj) === 'null';
        };
        DataUtil.isDefined = function (obj) {
            var type = jQuery.type(obj);
            return (type !== 'null' && type !== 'undefined');
        };
        DataUtil.isBoolean = function (obj) {
            return jQuery.type(obj) === 'boolean';
        };
        DataUtil.isNumber = function (obj) {
            return jQuery.type(obj) === 'number';
        };
        DataUtil.isString = function (obj) {
            return jQuery.type(obj) === 'string';
        };
        DataUtil.isObject = function (obj) {
            return jQuery.isPlainObject(obj);
        };
        DataUtil.isFunction = function (obj) {
            return jQuery.type(obj) === 'function';
        };
        DataUtil.isArray = function (obj) {
            return jQuery.type(obj) === 'array';
        };
        DataUtil.isDate = function (obj) {
            return jQuery.type(obj) === 'date';
        };
        DataUtil.isRegExp = function (obj) {
            return jQuery.type(obj) === 'regexp';
        };
        DataUtil.isFormData = function (obj) {
            return obj.toString() === '[object FormData]';
        };
        DataUtil.isEmpty = function (obj) {
            if (obj == null) {
                return true;
            }
            else if (this.isString(obj) && obj.length == 0) {
                return true;
            }
            return false;
        };
        DataUtil.isNumeric = function (value) {
            var regexp = new RegExp(/^[-]?([1-9]\d*|0)(\.\d+)?$/);
            return regexp.test(value);
        };
        DataUtil.isJQueryObject = function (obj) {
            return obj instanceof jQuery;
        };
        DataUtil.hasElements = function (obj) {
            return (this.isDefined(obj) && obj.length > 0);
        };
        DataUtil.hasAnElement = function (obj) {
            return (this.isDefined(obj) && obj.length == 1);
        };
        DataUtil.getExtention = function (filename) {
            return filename.slice((filename.lastIndexOf('.') - 1 >>> 0) + 2);
        };
        DataUtil.format = function (format) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            var argsLen = args.length;
            if (DataUtil.isEmpty(format) || argsLen <= 0) {
                return format;
            }
            var text = format;
            if (argsLen == 1 && this.isObject(args[0])) {
                jQuery.each(args[0], function (key, value) {
                    var regexp = new RegExp('\\{' + key + '\\}', 'g');
                    if (gm.DataUtil.isDefined(value)) {
                        text = text.replace(regexp, value);
                    }
                    else {
                        text = text.replace(regexp, '');
                    }
                });
            }
            else if (argsLen == 1 && this.isArray(args[0])) {
                jQuery.each(args[0], function (index, value) {
                    var regexp = new RegExp('\\{' + index + '\\}', 'g');
                    if (gm.DataUtil.isDefined(value)) {
                        text = text.replace(regexp, value);
                    }
                    else {
                        text = text.replace(regexp, '');
                    }
                });
            }
            else {
                for (var i = 0; i < argsLen; i++) {
                    var regexp = new RegExp('\\{' + i + '\\}', 'g');
                    if (gm.DataUtil.isDefined(args[i])) {
                        text = text.replace(regexp, args[i]);
                    }
                    else {
                        text = text.replace(regexp, '');
                    }
                }
            }
            return text;
        };
        DataUtil.camelCase = function (str) {
            str = str.charAt(0).toLowerCase() + str.slice(1);
            return str.replace(/[-_](.)/g, function (match, group1) {
                return group1.toUpperCase();
            });
        };
        DataUtil.snakeCase = function (str) {
            var camel = this.camelCase(str);
            return camel.replace(/[A-Z]/g, function (s) {
                return "_" + s.charAt(0).toLowerCase();
            });
        };
        DataUtil.pascalCase = function (str) {
            var camel = this.camelCase(str);
            return camel.charAt(0).toUpperCase() + camel.slice(1);
        };
        DataUtil.htmlEncode = function (text) {
            if (this.isEmpty(text))
                return '';
            text += '';
            var holders = this.htmlSpecialCharsPlaceHolders;
            for (var i = 0, len = holders.length; i < len; i++) {
                var holder = holders[i];
                var regexp = new RegExp(holder[0], 'g');
                text = text.replace(regexp, holder[1]);
            }
            return text;
        };
        DataUtil.htmlDecode = function (text) {
            if (this.isEmpty(text))
                return '';
            text += '';
            var holders = this.htmlSpecialCharsPlaceHolders;
            for (var i = holders.length - 1; 0 <= i; i--) {
                var holder = holders[i];
                var regexp = new RegExp(holder[1], 'g');
                text = text.replace(regexp, holder[0]);
            }
            return text;
        };
        DataUtil.nl2br = function (value) {
            if (this.isEmpty(value))
                return '';
            return value.replace(/\r?\n/g, '<br/>');
        };
        DataUtil.trim = function (value) {
            return jQuery.trim(value);
        };
        DataUtil.singleByteCharacters = function (text) {
            var length = 0;
            for (var i = 0; i < text.length; i++) {
                var c = text.charCodeAt(i);
                if ((c >= 0x0 && c < 0x81) || (c === 0xf8f0) || (c >= 0xff61 && c < 0xffa0) || (c >= 0xf8f1 && c < 0xf8f4)) {
                    length += 1;
                }
                else {
                    length += 2;
                }
            }
            return length;
        };
        DataUtil.truncateChars = function (value, length, rightPad) {
            if (this.isEmpty(value)) {
                return value;
            }
            var ret = '';
            for (var i = 0; i < value.length; i++) {
                var str = value[i];
                if (length - this.singleByteCharacters(ret) - this.singleByteCharacters(str) < 0) {
                    break;
                }
                ret += str;
            }
            if (rightPad) {
                for (var i = 0; i < length - this.singleByteCharacters(ret); i++) {
                    ret += ' ';
                }
            }
            return ret;
        };
        DataUtil.splitChars = function (value, length, position) {
            if (this.isEmpty(value)) {
                return '';
            }
            var ret = '';
            var str = value;
            for (var i = 1; i <= position; i++) {
                ret = this.truncateChars(str, length, false);
                str = str.substring(ret.length);
            }
            return ret;
        };
        DataUtil.rtrim = function (value) {
            return value.replace(/[\s　]+$/g, "");
        };
        DataUtil.paddingRightOfSpace = function (val, num) {
            for (; val.length < num; val += ' ')
                ;
            return val;
        };
        DataUtil.zeroPad = function (num, len) {
            return (Array(len).join('0') + num).slice(-len);
        };
        DataUtil.convertNullToBlank = function (val) {
            return (val !== null && val !== undefined) ? val : '';
        };
        DataUtil.formatDate = function (val, format) {
            if (!val) {
                return '';
            }
            var date = new Date(val);
            if (format.match(/yyyy/)) {
                var year = date.getFullYear();
                if (isNaN(year)) {
                    return '';
                }
                format = format.replace(/yyyy/, year);
            }
            if (format.match(/MM/)) {
                var month = date.getMonth() + 1;
                if (isNaN(month)) {
                    return '';
                }
                format = format.replace(/MM/, this.zeroPad(month, 2));
            }
            if (format.match(/dd/)) {
                var day = date.getDate();
                if (isNaN(day)) {
                    return '';
                }
                format = format.replace(/dd/, this.zeroPad(day, 2));
            }
            if (format.match(/hh/)) {
                var hours = date.getHours();
                if (isNaN(hours)) {
                    return '';
                }
                format = format.replace(/hh/, this.zeroPad(hours, 2));
            }
            if (format.match(/mm/)) {
                var minutes = date.getMinutes();
                if (isNaN(minutes)) {
                    return '';
                }
                format = format.replace(/mm/, this.zeroPad(minutes, 2));
            }
            if (format.match(/ss/)) {
                var secounds = date.getSeconds();
                if (isNaN(secounds)) {
                    return '';
                }
                format = format.replace(/ss/, this.zeroPad(secounds, 2));
            }
            return format;
        };
        DataUtil.strTimestamp = function () {
            var d = new Date();
            var year = d.getFullYear();
            var month = gm.DataUtil.zeroPad(d.getMonth() + 1, 2);
            var date = gm.DataUtil.zeroPad(d.getDate(), 2);
            var hour = gm.DataUtil.zeroPad(d.getHours(), 2);
            var minute = gm.DataUtil.zeroPad(d.getMinutes(), 2);
            var second = gm.DataUtil.zeroPad(d.getSeconds(), 2);
            return year + month + date + hour + minute + second;
        };
        DataUtil.formatAmt = function (val) {
            if (!val && val != 0) {
                return '';
            }
            return Number(val).toLocaleString();
        };
        DataUtil.getTaxNm = function (taxType) {
            if (taxType == 1) {
                return '(税抜)';
            }
            if (taxType == 2) {
                return '(税込)';
            }
            return '';
        };
        DataUtil.formatNum = function (int, kanji) {
            if (kanji === void 0) { kanji = true; }
            if (gm.DataUtil.isNumeric(int)) {
                if (kanji) {
                    var digit = ['', '万', '億', '兆', '京'];
                    var ret = '';
                    if (int) {
                        var nums = String(int).replace(/(\d)(?=(\d\d\d\d)+$)/g, "$1,").split(",").reverse();
                        for (var i = 0, len = nums.length; i < len; i++) {
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
            }
            else {
                return '';
            }
            return '';
        };
        DataUtil.htmlSpecialCharsPlaceHolders = [
            ['&', '&amp;'],
            ['<', '&lt;'],
            ['>', '&gt;'],
            ['\r', '&#13;'],
            ['\n', '&#10;'],
            ['"', '&quot;'],
            ['\'', '&#39;']
        ];
        DataUtil.arrayChunk = function (_a, size) {
            var array = _a.slice(0);
            if (size === void 0) { size = 1; }
            return array.reduce(function (acc, value, index) { return index % size ? acc : __spreadArray(__spreadArray([], acc, true), [array.slice(index, index + size)], false); }, []);
        };
        return DataUtil;
    }());
    gm.DataUtil = DataUtil;
    var DomUtil = (function () {
        function DomUtil() {
            throw new Error('DomUtilはnewできません。');
        }
        DomUtil.disabled = function (element, disabled) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            if ($el.length <= 0) {
                return;
            }
            for (var i = 0, len = $el.length; i < len; i++) {
                var $target = $el.eq(i);
                if (disabled) {
                    $target.attr('disabled', 'disabled');
                }
                else {
                    $target.removeAttr('disabled');
                }
            }
        };
        DomUtil.hidden = function (element, hidden) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            if ($el.length <= 0) {
                return;
            }
            for (var i = 0, len = $el.length; i < len; i++) {
                var $target = $el.eq(i);
                if (hidden) {
                    $target.stop(false, true).hide(200);
                }
                else {
                    $target.stop(false, true).show(200);
                }
            }
        };
        DomUtil.scrollForShow = function ($scroll, $show, height) {
            if (height === void 0) { height = 50; }
            if ($scroll.length) {
                var element = $scroll[0];
                if ((element.scrollHeight - $show.height()) - (element.clientHeight + $scroll.scrollTop()) < height) {
                    $scroll.animate({ scrollTop: $scroll.scrollTop() + $show.height() });
                }
            }
        };
        DomUtil.setParam = function (element, value, withoutTrigger) {
            if (withoutTrigger === void 0) { withoutTrigger = false; }
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            if ($el.length <= 0 || !gm.DataUtil.isDefined(value)) {
                return;
            }
            if ($el.is('span') || $el.is('h1') || $el.is('h2') || $el.is('h3') || $el.is('h4') || $el.is('h5') || $el.is('h6')) {
                $el.html(String(value));
            }
            else if ($el.is('[data-gm-date]')) {
                $el.val(gm.DataUtil.formatDate(value, $el.attr('data-gm-date')));
            }
            else if ($el.is('[data-gm-html]')) {
                $el.val(String(value));
            }
            else if ($el.is('[data-gm-color]') || $el.is('[data-gm-range]')
                || $el.is('input[type=text]') || $el.is('input[type=hidden]') || $el.is('input[type=password]') || $el.is('select') || $el.is('textarea')) {
                $el.val(String(value));
                if (!withoutTrigger)
                    $el.change();
            }
            else if ($el.is('input[type=radio]')) {
                $el.closest('[value=' + String(value) + ']').prop('checked', true);
                if (!withoutTrigger)
                    $el.change();
            }
            else if ($el.is('input[type=checkbox]')) {
                $el.prop('checked', value == true || value == '1');
                if (!withoutTrigger)
                    $el.change();
            }
            $el.attr('data-cl', gm.DataUtil.htmlEncode(value));
            return $el;
        };
        DomUtil.domParam = function (element) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            if ($el.length <= 0) {
                return null;
            }
            if ($el.is('input[type=radio]')) {
                return $el.closest(':checked').val();
            }
            else if ($el.is('span')) {
                return $el.text();
            }
            else if ($el.is('input[type=checkbox]')) {
                return $el.is(':checked') ? '1' : '0';
            }
            else if ($el.is('input[type=hidden]')) {
                return $el.val() == 'null' ? '' : $el.val();
            }
            else if ($el.is('[data-gm-html]')) {
                if ($el.parents('.tmce-active').length) {
                    return tinyMCE.get($el.attr('id')).getContent({ format: 'raw' });
                }
                else {
                    return $el.val();
                }
            }
            else {
                return $el.val();
            }
        };
        DomUtil.imgTag = function (value, movie, youtube, imgWidth) {
            if (movie === void 0) { movie = false; }
            if (youtube === void 0) { youtube = false; }
            if (imgWidth === void 0) { imgWidth = null; }
            var extentiton = gm.DataUtil.getExtention(value).toLowerCase();
            var patternMovie = new RegExp("mp4|mov");
            if (youtube && value.indexOf('https://www.youtube.com/') === 0) {
                var src = value.replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/');
                return '<iframe class="gm-prod-tbl-video" width="200" src="' + src + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>';
            }
            else if (movie && patternMovie.test(extentiton)) {
                return '<video class="gm-prod-tbl-video" src="' + value + '" autoplay="" loop="" preload="none" playsinline="playsinline" muted></video>';
            }
            var styleWidth = '';
            if (imgWidth) {
                styleWidth = 'max-width:' + imgWidth + 'px;';
            }
            return '<img src="' + value + '" style="' + styleWidth + '" />';
        };
        DomUtil.clear = function (element) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            for (var i = 0, len = $el.length; i < len; i++) {
                var $target = $el.eq(i);
                if ($target.is('input[type=radio]')) {
                    var bool = ($target.attr('data-cl') === $target.val() ? true : false);
                    $target.prop('checked', bool).change();
                }
                else if ($target.is('input[type=checkbox]')) {
                    $target.prop('checked', $target.attr('data-cl') === '1').change();
                }
                else if ($target.is('input[type=text]') || $target.is('input[type=password]') || $target.is('select') || $target.is('textarea')) {
                    var decodeVal = gm.DataUtil.htmlDecode($target.attr('data-cl'));
                    if ($target.val() != decodeVal) {
                        $target.val(decodeVal);
                        $target.change();
                    }
                }
                else if ($target.is('span')) {
                    $target.html($target.attr('data-cl'));
                }
            }
        };
        DomUtil.clearAll = function ($el) {
            if (!gm.DataUtil.isDefined($el)) {
                $el = jQuery();
            }
            var $targets = $el.find('[data-cl]');
            for (var i = 0, len = $targets.length; i < len; i++) {
                gm.DomUtil.clear(jQuery($targets[i]));
            }
        };
        DomUtil.objToOption = function (modelList, keyValue, keyText, selectedValue) {
            if (selectedValue === void 0) { selectedValue = ''; }
            var ret = '';
            if (modelList) {
                for (var i = 0, len = modelList.length; i < len; i++) {
                    var model = modelList[i];
                    var value = model[keyValue];
                    var text = model[keyText];
                    var selected = '';
                    if (selectedValue && selectedValue == value) {
                        selected = 'selected="selected"';
                    }
                    ret += '<option value="' + value + '" ' + selected + '>' + text + '</option>';
                }
            }
            return ret;
        };
        DomUtil.objToCheckbox = function (modelList, keyValue, keyText, name, checkedValues) {
            if (checkedValues === void 0) { checkedValues = []; }
            var ret = '';
            if (modelList) {
                for (var i = 0, len = modelList.length; i < len; i++) {
                    var model = modelList[i];
                    var value = model[keyValue];
                    var text = model[keyText];
                    var checked = '';
                    for (var j = 0, len2 = checkedValues.length; j < len2; j++) {
                        var checkedValue = checkedValues[j];
                        if (checkedValue && checkedValue == value) {
                            checked = 'checked="checked"';
                            break;
                        }
                    }
                    ret += '<div><label><input type="checkbox" name="' + name + '" value="' + value + '" ' + checked + '>' + text + '</label></div>';
                }
            }
            return ret;
        };
        return DomUtil;
    }());
    gm.DomUtil = DomUtil;
    var AbstractMessages = (function () {
        function AbstractMessages() {
            throw new Error("このクラスはインスタンス生成できません。");
        }
        AbstractMessages.getMessage = function (messageId) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            var messageList = this.messageList;
            var message = null;
            for (var _a = 0, messageList_1 = messageList; _a < messageList_1.length; _a++) {
                var tmpMessage = messageList_1[_a];
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
        };
        return AbstractMessages;
    }());
    gm.AbstractMessages = AbstractMessages;
    var Table = (function () {
        function Table() {
            throw new Error('Tableはnewできません。');
        }
        Table.create = function ($table, opt) {
            var optBase = {
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
        };
        return Table;
    }());
    gm.Table = Table;
    var Modal = (function () {
        function Modal($modal) {
            this.$modal = null;
            var me = this;
            me.$modal = $modal;
            Modal.modalCnt++;
        }
        Modal.createModal = function (title, btns, body, selector) {
            if (selector === void 0) { selector = gm.COVER_SELECTOR; }
            var base = gm.DataUtil.format(Modal.BASE, {
                title: title,
                btns: btns,
                body: body,
                modalCnt: Modal.modalCnt
            });
            var $modal = jQuery(selector).append(base).find('[data-gm-modal="' + Modal.modalCnt + '"]');
            $modal.find('[data-gm-modal-close]').on('click', this, function (event) {
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
        };
        Modal.prototype.show = function (needsValidator) {
            if (needsValidator === void 0) { needsValidator = true; }
            var me = this;
            var $modal = me.$modal;
            if (needsValidator) {
                gm.Validation.initValidator('[data-gm-modal]');
                gm.Validation.setValidator($modal);
            }
            jQuery(':focus').blur();
            $modal.wrap('<div class="gm-modal-cover" style="display:none;" data-gm-modal-count="' + Modal.modalCnt + '"></div>');
            $modal.closest('.gm-modal-cover').prepend('<a class="gm-modal-coverbase"></a>');
            gm.MenuUtil.setNoOptMessage($modal);
            gm.MenuUtil.setRequiredMark($modal);
            gm.MenuUtil.setMenuQuestion($modal.find('[data-gm-modal-body]'));
            jQuery('html').css('overflow-y', 'hidden');
            $modal.show();
            $modal.closest('.gm-modal-cover').stop().fadeIn(200);
            $modal.css({
                'position': 'relative',
            });
            var $notFocusObj = jQuery('#pagewrap');
            if (Modal.modalCnt > 1) {
                $notFocusObj = jQuery('[data-gm-modal-count=' + String(Modal.modalCnt - 1) + ']');
            }
            $notFocusObj.find('input, select, a').each(function () {
                var $target = jQuery(this);
                $target.attr('tabindex', '-1');
            });
            gm.MenuUtil.setStickyTh($modal);
        };
        Modal.prototype.hide = function (me, callback) {
            if (me === void 0) { me = this; }
            if (callback === void 0) { callback = jQuery.noop; }
            gm.Modal.remove(me.$modal);
            callback();
        };
        Modal.remove = function ($modal) {
            Modal.modalCnt--;
            $modal.closest('.gm-modal-cover').stop().fadeOut(200, function () {
                jQuery('html').css('overflow-y', 'auto');
                $modal.unwrap().prev().remove();
                $modal.remove();
            });
            jQuery(document).off('keydown.modalEsc');
            jQuery('.tipsy').remove();
        };
        Modal.BASE = "\n        <form class=\"gm-modal\" data-gm-modal=\"{modalCnt}\">\n            <input type=\"text\" style=\"display:none\" palceholder=\"Enter\u5BFE\u7B56\">\n            <div class=\"gm-modal-header\">\n                <div class=\"gm-modal-header-left\">\n                    <h2 class=\"gm-modal-title\">{title}</h2>\n                </div>\n                <div class=\"gm-modal-header-right\">\n                    <a class=\"button-secondary gm-modal-close\" data-gm-modal-close>\u00D7</a>\n                </div>\n            </div>\n            <div class=\"gm-modal-body\" data-gm-modal-body>{body}</div>\n            <div class=\"gm-modal-footer\">{btns}</div>\n        </form>";
        Modal.modalCnt = 0;
        return Modal;
    }());
    gm.Modal = Modal;
    var Mask = (function () {
        function Mask() {
            throw new Error('Maskはnewできません。');
        }
        Mask.show = function (selector) {
            if (selector === void 0) { selector = gm.ROOT_SELECTOR; }
            if (jQuery('.gm-loading-mask').length == 0) {
                jQuery(selector).append("\n                <div class=\"gm-loading-mask\">\n                    <div class=\"gm-loading-mask-icon\">\n                        <div class=\"gm-loading-mask-icon-balls\">\n                            <span></span>\n                            <span></span>\n                        \n                            <span></span>\n                        </div>\n                        <div class=\"gm-loading-mask-icon-shadows\">\n                            <span></span>\n                            <span></span>\n                            <span></span>\n                        </div>\n                        <div class=\"gm-loading-mask-icon-label\">Loading</div>\n                    </div>\n                </div>\n                ");
                Mask.openTime = Date.now();
            }
        };
        Mask.hide = function () {
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
        };
        return Mask;
    }());
    gm.Mask = Mask;
    var Spinner = (function () {
        function Spinner() {
            throw new Error('Spinnerはnewできません。');
        }
        Spinner.create = function (size, color) {
            if (size === void 0) { size = 20; }
            if (color === void 0) { color = ''; }
            var styleSize = '';
            if (size) {
                styleSize = 'height:' + size + 'px;width:' + size + 'px;border-width: ' + Math.round(size / 5) + 'px;';
            }
            var styleColor = '';
            if (color) {
                styleColor = 'border-color:' + color + ';border-top-color: transparent;';
            }
            return '<div class="gm-spinner" style="' + styleSize + styleColor + '"></div>';
        };
        Spinner.show = function (element, size, color) {
            if (size === void 0) { size = 25; }
            if (color === void 0) { color = ''; }
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            $el.append(Spinner.create(size, color));
        };
        Spinner.remove = function (element) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            $el.find('.gm-spinner').remove();
        };
        return Spinner;
    }());
    gm.Spinner = Spinner;
    var Toast = (function () {
        function Toast() {
            throw new Error('Toastはnewできません。');
        }
        Toast.info = function (text, heading) {
            if (heading === void 0) { heading = ''; }
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
        };
        Toast.success = function (text, heading) {
            if (heading === void 0) { heading = ''; }
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
        };
        Toast.error = function (text, heading) {
            if (heading === void 0) { heading = 'エラー'; }
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
        };
        return Toast;
    }());
    gm.Toast = Toast;
    var Parts = (function () {
        function Parts() {
            throw new Error('Partsはnewできません。');
        }
        Parts.setDatePicker = function ($parent) {
            var $targets = $parent.find('[data-gm-date]:not([data-gm-prepared-date-picker=true])');
            var option = {
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
                onClose: function (dateText, inst) {
                    jQuery(this).blur();
                },
                beforeShowDay: function (date) {
                    var result;
                    switch (date.getDay()) {
                        case 0:
                            result = [true, "date-sunday"];
                            break;
                        case 6:
                            result = [true, "date-saturday"];
                            break;
                        default:
                            result = [true, ""];
                            break;
                    }
                    return result;
                }
            };
            for (var i = 0, len = $targets.length; i < len; i++) {
                var $target = $targets.eq(i);
                $target.wrap('<div class="gm-input-datepicker-wrap">');
                var type = $target.attr('data-gm-date');
                if (type == 'yyyy/MM/dd') {
                    $target.datepicker(option);
                }
                else if (type == 'yyyy/MM/dd hh:mm') {
                    $target.datetimepicker(option);
                }
                $target.attr('autocomplete', 'off');
                $target.attr('data-gm-prepared-date-picker', 'true');
            }
        };
        Parts.setHtmlEditor = function ($parent) {
            var $inputs = $parent.find('[data-gm-html]:not([data-gm-prepared-html-editor=true])');
            var _loop_6 = function (i, len) {
                var $input = $inputs.eq(i);
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
                Parts.htmlEditorCnt++;
            };
            for (var i = 0, len = $inputs.length; i < len; i++) {
                _loop_6(i, len);
            }
        };
        Parts.setImgPicker = function ($parent) {
            var $inputs = $parent.find('[data-gm-img]:not([data-gm-prepared-img-picker=true])');
            var _loop_7 = function (i, len) {
                var $input = $inputs.eq(i);
                var styleWidth = '';
                var imgWidth = $inputs.attr('data-gm-img-width');
                if (imgWidth) {
                    styleWidth = 'max-width:' + imgWidth + 'px;';
                }
                $input.wrap('<div class="gm-input-img-wrap">');
                var $add = jQuery('<input type="button" class="gm-text-button gm-secondary-button" value="選択"/>');
                var $clear = jQuery('<input type="button" class="gm-text-button gm-negative-button" value="クリア" />');
                var $thumbnail = jQuery('<div class="gm-img-area" style="' + styleWidth + '"></div>');
                $input.after($add);
                $add.after($clear);
                $clear.after($thumbnail);
                var showImg = !$input.is('[data-gm-img="0"]');
                if (showImg) {
                    $input.on('change', this_1, function (event) {
                        $thumbnail.empty();
                        if (!$input.find('.gm-has-error').length) {
                            var value = $input.val();
                            $thumbnail.append(gm.DomUtil.imgTag(value, $input.is('[data-gm-movie]'), $input.is('[data-gm-youtube]'), imgWidth));
                        }
                    });
                }
                $add.on('click', this_1, function (event) {
                    var $uploader = wp.media({
                        title: "画像を選択してください",
                        library: {
                            type: "image"
                        },
                        button: {
                            text: "画像の選択"
                        },
                        multiple: false
                    });
                    $uploader.on("select", function (event) {
                        var images = $uploader.state().get("selection");
                        images.each(function (file) {
                            var url = file.attributes.sizes.full.url;
                            $input.val('');
                            $thumbnail.empty();
                            $input.val(url).change();
                        });
                    });
                    $uploader.open();
                });
                $clear.on('click', this_1, function (event) {
                    $input.val('');
                    $thumbnail.empty();
                    $input.change();
                });
                $input.attr('data-gm-prepared-img-picker', 'true');
            };
            var this_1 = this;
            for (var i = 0, len = $inputs.length; i < len; i++) {
                _loop_7(i, len);
            }
        };
        Parts.setColorPicker = function ($parent) {
            var $inputs = $parent.find('[data-gm-color]:not([data-gm-prepared-color-picker=true])');
            for (var i = 0, len = $inputs.length; i < len; i++) {
                var $input = $inputs.eq(i);
                $input.wpColorPicker();
                $input.attr('data-gm-prepared-color-picker', 'true');
            }
        };
        Parts.setNumPicker = function ($parent) {
            var $inputs = $parent.find('[data-gm-number]:not([data-gm-prepared-num-picker=true])');
            for (var i = 0, len = $inputs.length; i < len; i++) {
                var $input = $inputs.eq(i);
                if ($input.attr('readonly') || $input.attr('disabled')) {
                    continue;
                }
                $input.wrap('<div class="gm-input-num-wrap">');
                $input.attr('data-gm-prepared-num-picker', 'true');
            }
        };
        Parts.setRangePicker = function ($parent) {
            var $inputs = $parent.find('[data-gm-range]:not([data-gm-prepared-range-picker=true])');
            var _loop_8 = function (i, len) {
                var $input = $inputs.eq(i);
                $input.wrap('<div class="gm-input-range-wrap">');
                var $point = jQuery('<div class="gm-input-range-point"></div>');
                $input.before($point);
                $input.on('change', this_2, function (event) {
                    $point.text(jQuery(this).val());
                });
                $input.change();
                $input.attr('data-gm-prepared-range-picker', 'true');
            };
            var this_2 = this;
            for (var i = 0, len = $inputs.length; i < len; i++) {
                _loop_8(i, len);
            }
        };
        Parts.setParts = function (element) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            gm.Parts.setDatePicker($el);
            gm.Parts.setHtmlEditor($el);
            gm.Parts.setImgPicker($el);
            gm.Parts.setColorPicker($el);
            gm.Parts.setNumPicker($el);
            gm.Parts.setRangePicker($el);
        };
        Parts.htmlEditorCnt = 0;
        return Parts;
    }());
    gm.Parts = Parts;
    var Validation = (function () {
        function Validation() {
            throw new Error("このクラスはインスタンス生成できません。");
        }
        Validation.isValid = function ($el, $scroll, ignoreMethods) {
            if ($scroll === void 0) { $scroll = jQuery(); }
            if (!gm.DataUtil.isDefined($el)) {
                $el = jQuery(gm.ROOT_SELECTOR);
            }
            if ($el.length <= 0) {
                return;
            }
            var valid = true;
            if ($el.length > 1) {
                for (var i = 0, len = $el.length; i < len; i++) {
                    if (!gm.Validation.isValid($el.eq(i))) {
                        valid = false;
                    }
                }
            }
            else {
                var validator_1 = this.validator($el);
                if (gm.DataUtil.isDefined(validator_1)) {
                    if ($el.is('[data-gm-prepared-validator=true]')) {
                        valid = gm.Validation.isValidWithIgnoreMethods(validator_1, $el, ignoreMethods);
                    }
                    var $targets = $el.find('[data-gm-prepared-validator=true]');
                    for (var i = 0, len = $targets.length; i < len; i++) {
                        var $target = $targets.eq(i);
                        if (!gm.Validation.isValidWithIgnoreMethods(validator_1, $target, ignoreMethods)) {
                            valid = false;
                        }
                    }
                }
            }
            if ($scroll.find('.gm-has-error').length) {
                var $error = $scroll.find('.gm-has-error');
                $scroll.animate({ scrollTop: $error.position().top + $scroll.scrollTop() - jQuery('.gm-modal-header').height() - jQuery('#wpadminbar').height() - jQuery('.gm-input-table-heading-row').eq(0).height() });
            }
            return valid;
        };
        Validation.isValidWithIgnoreMethods = function (validator, $el, ignoreMethods) {
            var valid = validator.element($el);
            if (!valid && gm.DataUtil.isDefined(ignoreMethods) && ignoreMethods.length > 0) {
                for (var _i = 0, _a = validator.errorList; _i < _a.length; _i++) {
                    var error = _a[_i];
                    if (ignoreMethods.indexOf(error.method) < 0) {
                        return false;
                    }
                }
                valid = true;
            }
            return valid;
        };
        Validation.validator = function ($el) {
            if ($el === void 0) { $el = jQuery(gm.ROOT_SELECTOR); }
            if ($el.length > 0) {
                return $el.data('validator');
            }
            return null;
        };
        Validation.registValidate = function ($el) {
            $el = $el.filter(':not([data-gm-prepared-validator])');
            $el.filter(':not([type=checkbox]):not([type=radio])').on('blur.validator', function (event, $target, oldValue, newValue) {
                gm.Validation.kickValidate(jQuery(this));
            });
            $el.filter('input[type=checkbox],input[type=radio]').on('change.validator', function (event) {
                gm.Validation.kickValidate(jQuery(this));
            });
            $el.attr('data-gm-prepared-validator', 'true');
        };
        Validation.kickValidate = function ($el) {
            var validator = this.validator($el);
            if (gm.DataUtil.isDefined(validator)) {
                validator.element($el);
            }
        };
        Validation.addRules = function ($el, name, suffix) {
            if (suffix === void 0) { suffix = ''; }
            name = gm.DataUtil.camelCase(name) + suffix;
            $el.data("rule" + name.charAt(0).toUpperCase() + name.substring(1).toLowerCase(), {});
        };
        Validation.removeRules = function ($el, name, suffix) {
            if (suffix === void 0) { suffix = ''; }
            name = gm.DataUtil.camelCase(name) + suffix;
            $el.removeData("rule" + name.charAt(0).toUpperCase() + name.substring(1).toLowerCase());
        };
        Validation.setRequired = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-required]:not([data-gm-prepared-required])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmRequired', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-required', 'true');
        };
        Validation.setLength = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-length]:not([data-gm-prepared-length])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmLength', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-length', 'true');
        };
        Validation.setLengthMin = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-length-min]:not([data-gm-prepared-length-min])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmLengthMin', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-length-min', 'true');
        };
        Validation.setDate = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-date]:not([data-gm-prepared-date])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmDate', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-date', 'true');
        };
        Validation.setUrl = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-url]:not([data-gm-prepared-url])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmUrl', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-url', 'true');
        };
        Validation.setNumber = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-number]:not([data-gm-prepared-number]),[data-gm-post-select="0"]:not([data-gm-prepared-number]),[data-gm-page-select="0"]:not([data-gm-prepared-number]),[data-gm-cat-select="0"]:not([data-gm-prepared-number]),[data-gm-tag-select="0"]:not([data-gm-prepared-number]),[data-gm-user-select="0"]:not([data-gm-prepared-number])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmNumber', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-number', 'true');
        };
        Validation.setPostalCode = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-postal-code]:not([data-gm-prepared-postal-code])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmPostalCode', '');
            this.registValidate($el);
            if ($el.attr('data-gm-postal-code')) {
                $el.keyup(function () {
                    AjaxZip3.zip2addr(this, '', $el.attr('data-gm-postal-code').split(',')[0], $el.attr('data-gm-postal-code').split(',')[1]);
                });
            }
            $el.attr('data-gm-prepared-postal-code', 'true');
        };
        Validation.setPhone = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-phone]:not([data-gm-prepared-phone])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmPhone', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-phone', 'true');
        };
        Validation.setEmail = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-email]:not([data-gm-prepared-email])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmEmail', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-email', 'true');
        };
        Validation.setZenKatakana = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-zen-katakana]:not([data-gm-prepared-zen-katakana])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmZenKatakana', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-zen-katakana', 'true');
        };
        Validation.setPassword = function ($parent, selector) {
            if (selector === void 0) { selector = '[data-gm-password]:not([data-gm-prepared-password])'; }
            var $el = $parent.find(selector);
            this.addRules($el, 'gmPassword', '');
            this.registValidate($el);
            $el.attr('data-gm-prepared-password', 'true');
        };
        Validation.requiredInner = function (value, required) {
            if (required === void 0) { required = true; }
            var ret = true;
            if (required) {
                if (value == null) {
                    ret = false;
                }
                else {
                    if (gm.DataUtil.isString(value)) {
                        if (DataUtil.isEmpty(value)) {
                            ret = false;
                        }
                    }
                }
            }
            return ret;
        };
        Validation.isValidDate = function (value, format, required) {
            if (required === void 0) { required = true; }
            if (!this.requiredInner(value, required)) {
                return false;
            }
            else if (!gm.DataUtil.isEmpty(value)) {
                if (!value.match(/^\d{4}\/\d{2}\/\d{2}$/) && !value.match(/^\d{4}\/\d{2}\/\d{2} \d{2}\:\d{2}$/)) {
                    return false;
                }
                if (!gm.DataUtil.formatDate(value, format)) {
                    return false;
                }
                return true;
            }
            return false;
        };
        Validation.initValidator = function (element) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
            }
            jQuery.extend(jQuery.fn, {
                rules: function (command, argument) {
                    var element = this[0], settings, staticRules, existingRules, data, param, filtered;
                    var validator = jQuery.validator;
                    if (command) {
                        settings = jQuery.data(element.form, 'validator').settings;
                        staticRules = settings.rules;
                        existingRules = validator.staticRules(element);
                        switch (command) {
                            case 'add':
                                jQuery.extend(existingRules, validator.normalizeRule(argument));
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
                    data = validator.normalizeRules(jQuery.extend({}, validator.classRules(element), validator.attributeRules(element), validator.dataRules(element)), element);
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
                success: function ($label, element) {
                    var $el = jQuery(element);
                    if (gm.DataUtil.isDefined($el) && $el.length > 0) {
                        $el.tipsy('hide');
                        $el.off('mouseenter mouseleave');
                        $el.removeData('tipsy');
                    }
                },
                errorPlacement: function ($error, $el) {
                    var errorText = $error.text();
                    if (gm.DataUtil.isDefined($el) && $el.length > 0) {
                        $el.tipsy('hide');
                        $el.off('mouseenter mouseleave');
                        $el.removeData('tipsy');
                        if (errorText) {
                            $el.attr('original-title', errorText);
                            var tipsyGravity = $el.attr('data-gm-tipsy-gravity');
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
            jQuery.validator.addMethod('gmRequired', function (value, element, params) {
                var $el = jQuery(element);
                if ($el.is('input[type=radio]')) {
                    return $el.closest(':checked').length != 0;
                }
                else {
                    return !gm.DataUtil.isEmpty(value);
                }
            }, '必須入力です。');
            jQuery.validator.addMethod('gmLength', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var $el_1 = jQuery(element).closest('[data-gm-length]');
                    var length_1 = Number($el_1.attr('data-gm-length'));
                    var len = value.length;
                    return (len <= length_1);
                }
            }, function (params, element) {
                var $el = jQuery(element).closest('[data-gm-length]');
                var placeHolder = Number($el.attr('data-gm-length'));
                return placeHolder + '文字以下で入力してください。';
            });
            jQuery.validator.addMethod('gmLengthMin', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var $el_2 = jQuery(element).closest('[data-gm-length-min]');
                    var length_2 = Number($el_2.attr('data-gm-length-min'));
                    var len = value.length;
                    return (length_2 <= len);
                }
            }, function (params, element) {
                var $el = jQuery(element).closest('[data-gm-length-min]');
                var placeHolder = Number($el.attr('data-gm-length-min'));
                return placeHolder + '文字以上で入力してください。';
            });
            jQuery.validator.addMethod('gmDate', function (value, element, params) {
                var format = jQuery(element).attr('data-gm-date');
                var result = this.optional(element) || gm.Validation.isValidDate(value, format ? format : 'yyyy/MM/dd');
                return result ? true : false;
            }, '日付が正しくありません。');
            jQuery.validator.addMethod('gmUrl', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var pattern = new RegExp('^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$', 'i');
                    var patternJP = new RegExp('^(https?:\\/\\/[\\w\\-\\.\\/\\?\\,\\#\\:\\u3000-\\u30FE\\u4E00-\\u9FA0\\uFF01-\\uFFE3]+)/');
                    return pattern.test(value) || patternJP.test(value) ? true : false;
                }
            }, 'URLが正しくありません。');
            jQuery.validator.addMethod('gmNumber', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    if (gm.DataUtil.isNumeric(value)) {
                        var $el_3 = jQuery(element);
                        var min = $el_3.attr('data-min');
                        if (gm.DataUtil.isDefined(min) && Number(value) < Number(min)) {
                            return false;
                        }
                        var max = $el_3.attr('data-max');
                        if (gm.DataUtil.isDefined(max) && Number(max) < Number(value)) {
                            return false;
                        }
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }, function (params, element) {
                var $el = jQuery(element).closest('[data-gm-number]');
                var value = $el.val();
                var min = $el.attr('data-min');
                if (gm.DataUtil.isDefined(min) && Number(value) < Number(min)) {
                    return min + '以上で入力してください。';
                }
                var max = $el.attr('data-max');
                if (gm.DataUtil.isDefined(max) && Number(max) < Number(value)) {
                    return max + '以下で入力してください。';
                }
                return '数値で入力してください。';
            });
            jQuery.validator.addMethod('gmPostalCode', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var pattern = new RegExp(/^[0-9]{3}-[0-9]{4}$/);
                    return pattern.test(value);
                }
            }, '「-」を含む郵便番号形式で入力してください。');
            jQuery.validator.addMethod('gmPhone', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var pattern = new RegExp(/^0\d{1,4}-\d{1,4}-\d{3,4}$/);
                    return pattern.test(value);
                }
            }, '「-」を含む電話番号形式で入力してください。');
            jQuery.validator.addMethod('gmEmail', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var pattern = new RegExp(/^[A-Za-z0-9]+(?:[._-][A-Za-z0-9]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$/i);
                    return pattern.test(value);
                }
            }, 'Eメールアドレス形式で入力してください。');
            jQuery.validator.addMethod('gmZenKatakana', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var pattern = new RegExp(/^[ァ-ンヴー]*$/);
                    return pattern.test(value);
                }
            }, '全角カタカナで入力してください。');
            jQuery.validator.addMethod('gmPassword', function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                else {
                    var pattern = new RegExp(/^[A-Za-z0-9!"#\$%&'\(\)\-\^\\\@\[;:\],\.\/=~\|`\{\+\*\}<>?_]+$/);
                    return pattern.test(value);
                }
            }, 'パスワードに使用できない文字が入力されています。');
        };
        Validation.setValidator = function (element) {
            var $el = null;
            if (gm.DataUtil.isString(element)) {
                $el = jQuery(element);
            }
            else {
                $el = element;
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
        };
        return Validation;
    }());
    gm.Validation = Validation;
    function submit(element) {
        var $el = null;
        if (gm.DataUtil.isString(element)) {
            $el = jQuery(element);
        }
        else {
            $el = element;
        }
        if ($el.length <= 0) {
            return;
        }
        $el.submit();
    }
    gm.submit = submit;
})(gm || (gm = {}));
jQuery(function () {
    if (gm.DataUtil.isDefined(jQuery.fn.tipsy)) {
        jQuery.extend(jQuery.fn.tipsy.defaults, {
            fade: true,
            html: false
        });
    }
    if (jQuery('#gm-page-form').length) {
        gm.Validation.initValidator('#gm-page-form');
        gm.Parts.setParts('#gm-page-form');
    }
    var applications = gm.applications;
    if (gm.DataUtil.isDefined(applications)) {
        for (var i = 0, len = applications.length; i < len; i++) {
            applications[i].init(window.args);
        }
    }
    delete window.args;
});
//# sourceMappingURL=common.js.map