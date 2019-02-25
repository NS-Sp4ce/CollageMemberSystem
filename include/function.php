<?php
/**
 * CheckLogin
 * 检测是否登录
 */
function CheckLogin()
{
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location:./login.php", "", "302");
        exit();
    }
}
/**
 * CheckEntrance
 * 检测是否从入口进入
 */
function CheckEntrance()
{
    $Index_Filenane = 'index.php';
    $Url_Filename   = basename($_SERVER['SCRIPT_NAME']);
    if ($Url_Filename !== $Index_Filenane) {
        $New_Url_Filename = str_replace('.php', '', $Url_Filename);
        header("Location:./index.php?do=$New_Url_Filename", "", "302");
    }
}
/**
 * Windows服务器信息类
 */
class SystemInfoWindows
{
    /**
     * 删除2个信息文件
     * @return Ture/Fail
     */
    public function deleteInfoFile()
    {
        $file = array
            (
            "cpu_usage.vbs",
            "memory_usage.vbs",
        );
        foreach ($file as $deletefile) {
            unlink('./sysinfo/' . $deletefile);
        }
    }
}

/**
 * 获取IP
 * @return Vister IP
 */
function GetIP()
{
    if (getenv("REMOTE_ADDR")) {
        $Visterip = getenv("REMOTE_ADDR");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $Visterip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("HTTP_CLIENT_IP")) {
        $Visterip = getenv("HTTP_CLIENT_IP");
    } else if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
        $Visterip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if ($_SERVER["HTTP_CLIENT_IP"]) {
        $Visterip = $_SERVER["HTTP_CLIENT_IP"];
    } else if ($_SERVER["REMOTE_ADDR"]) {
        $Visterip = $_SERVER["REMOTE_ADDR"];
    } else {
        $Visterip = "Unknown";
    }
    return $Visterip;
}
/**
 * 设置新会话时间
 */
function SetNewSessionTime()
{
    session_start();
    $_SESSION['login_time'] = date('Y-m-d H:i:s');
}

/**
 * 检测会话是否过期
 */
function CheckSession()
{
    session_start();
    date_default_timezone_set('Asia/Shanghai');
    $delay_time     = '900'; //超时时间（秒）
    $session_time   = $_SESSION['login_time'];
    $timeout        = date('Y-m-d H:i:s');
    $logon_out_time = strtotime($timeout) - strtotime($session_time);
    if (empty($session_time) || $session_time == '' || $logon_out_time >= $delay_time) {
        $file = array
            (
            "cpu_usage.vbs",
            "memory_usage.vbs",
        );
        foreach ($file as $deletefile) {
            if (file_exists('./sysinfo/' . $deletefile)) {
                $info = new SystemInfoWindows();
                $info->deleteInfoFile();
            }
        }
        session_destroy();
        sweetalert('会话过期', '当前会话已超时[' . $delay_time . '(s)未操作]，请重新登录', 'warning', '0', '', '返回', 'login', '0', '');
        exit();
    }
}
/**
 * [FilterInput 过滤XSS]
 * @param [string] $string [传入值]
 */
function FilterInput($string)
{
    $ra     = array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '/scr/', '/javascript/', '/vbscript/', '/expression/', '/applet/', '/meta/', '/xml/', '/blink/', '/link/', '/style/', '/embed/', '/object/', '/frame/', '/layer/', '/title/', '/bgsound/', '/base/', '/onload/', '/onunload/', '/onchange/', '/onsubmit/', '/onreset/', '/onselect/', '/onblur/', '/onfocus/', '/onabort/', '/onkeydown/', '/onkeypress/', '/onkeyup/', '/onclick/', '/ondblclick/', '/onmousedown/', '/onmousemove/', '/onmouseout/', '/onmouseover/', '/onmouseup/', '/onunload/');
    $string = preg_replace($ra, '', $string);
    $string = str_replace('%20', '&nbsp;', $string);
    $string = str_replace("&", '&amp;', $string);
    $string = str_replace(";", '；', $string);
    $string = str_replace("<", '&lt;', $string);
    $string = str_replace(">", '&gt;', $string);
    $string = str_replace("'", '&#039;', $string);
    $string = str_replace('"', '&quot;', $string);
    return $string;
}
/**
 * [SQLFilter SQL过滤]
 * @param [string] $string [传入值]
 * @param [string] $type   [过滤模式]
 */
function SQLFilter2($string, $type = 1)
{
    $match   = array("/union/i", "/where/i", "/outfile/i", "/truncate/i", "/dumpfile/i", "/0x([a-f0-9]{2,})/i", "/select([\s\S]*?)from/i", "/select([\s\*\/\-\(\+@])/i", "/update([\s\*\/\-\(\+@])/i", "/replace([\s\*\/\-\(\+@])/i", "/delete([\s\*\/\-\(\+@])/i", "/drop([\s\*\/\-\(\+@])/i", "/load_file[\s]*\(/i", "/substring[\s]*\(/i", "/substr[\s]*\(/i", "/left[\s]*\(/i", "/concat[\s]*\(/i", "/concat_ws[\s]*\(/i", "/make_set[\s]*\(/i", "/ascii[\s]*\(/i", "/hex[\s]*\(/i", "/ord[\s]*\(/i", "/char[\s]*\(/i");
    $replace = array('unio&#110;', 'wher&#101;', 'outfil&#101;', 'dumpfil&#101;', '0&#120;\\1', 'selec&#116;\\1from', 'selec&#116;\\1', 'updat&#101;\\1', 'replac&#101;\\1', 'delet&#101;\\1', 'dro&#112;\\1', 'load_fil&#101;(', 'substrin&#103;(', 'subst&#114;(', 'lef&#116;(', 'conca&#116;(', 'concat_w&#115;(', 'make_se&#116;(', 'asci&#105;(', 'he&#120;(', 'or&#100;(', 'cha&#114;(');
    if ($type) {
        return is_array($string) ? array_map('strip_sql', $string) : preg_replace($match, $replace, $string);
    } else {
        return str_replace(array('&#100;', '&#101;', '&#103;', '&#105;', '&#110;', '&#112;', '&#114;', '&#115;', '&#116;', '&#120;'), array('d', 'e', 'g', 'i', 'n', 'p', 'r', 's', 't', 'x'), $string);
    }
}

function SQLFilter($string)
{
    $string = strtolower($string);
    $string = str_replace('from', '', $string);
    $string = str_replace('and', '', $string);
    $string = str_replace('execute', '', $string);
    $string = str_replace('update', '', $string);
    $string = str_replace('count', '', $string);
    $string = str_replace('chr', '', $string);
    $string = str_replace('mid', '', $string);
    $string = str_replace('master', '', $string);
    $string = str_replace('truncate', '', $string);
    $string = str_replace('char', '', $string);
    $string = str_replace('declare', '', $string);
    $string = str_replace('select', '', $string);
    $string = str_replace('create', '', $string);
    $string = str_replace('delete', '', $string);
    $string = str_replace('insert', '', $string);
    $string = str_replace('union', '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace(' ', '', $string);
    $string = str_replace('or', '', $string);
    $string = str_replace('=', '', $string);
    $string = str_replace('%20', '', $string);
    $string = str_replace('-', '', $string);
    $string = str_replace('/', '', $string);
    $string = str_replace('*', '', $string);
    return $string;

}
/**
 * [sweetalert Sweet2 Alert函数]
 * @param  [string]  $title             [弹框标题]
 * @param  [string]  $text              [弹框内容]
 * @param  [string]  $type              [弹框图标]
 * @var    $type                        [success、warning、error]
 * @param  integer $showCancelButton    [是否显示取消按钮 默认否]
 * @param  [string]  $cancelButtonText  [取消按钮内容]
 * @param  [string]  $confirmButtonText [确认按钮内容]
 * @param  [string]  $callback          [返回地址]
 * @param  integer $return              [是否开启倒计时返回 默认开启]
 * @param  [string]  $return_time       [倒计时时间 毫秒]
 * @return [string]                     [description]
 */
function sweetalert($title, $text, $type, $showCancelButton = 0, $cancelButtonText, $confirmButtonText, $callback, $return = 1, $return_time)
{
    echo "<script type=\"text/javascript\">
    swal({
        title: '" . $title . "',
        text: '" . $text . "',
        type: '" . $type . "',
        showCancelButton: " . $showCancelButton . ",
        cancelButtonText: '" . $cancelButtonText . "',
        confirmButtonText: '" . $confirmButtonText . "',
        allowOutsideClick: false,
        allowEscapeKey:false
        }).then(function() {
            self.location='?do=" . $callback . "'
        });
        </script>";
    if ($return == '1' || $return == 'true') {
        echo "
            <script type=\"text/javascript\">
            setTimeout(function() {window.location.href=\"?do=" . $callback . "\"}," . $return_time . ");
            </script>
";
    }
}

/*****************************************
 *           获取URL=后的参数相关函数      *
 * ***************************************
 *                 开始                  *
 * ***************************************
 */
//解析URL参数
function parseUrlParam($query)
{
    $queryArr = explode('&', $query);
    $params   = array();
    if ($queryArr[0] !== '') {
        foreach ($queryArr as $param) {
            list($name, $value)       = explode('=', $param);
            $params[urldecode($name)] = urldecode($value);
        }
    }
    return $params;
}

//设置URL参数数组
function setUrlParams($cparams, $url = '')
{
    $parse_url = $url === '' ? parse_url($_SERVER["REQUEST_URI"]) : parse_url($url);
    $query     = isset($parse_url['query']) ? $parse_url['query'] : '';
    $params    = parseUrlParam($query);
    foreach ($cparams as $key => $value) {
        $params[$key] = $value;
    }
    return $parse_url['path'] . '?' . http_build_query($params);
}

//获取URL参数
function getUrlParam($cparam, $url = '')
{
    $parse_url = $url === '' ? parse_url($_SERVER["REQUEST_URI"]) : parse_url($url);
    $query     = isset($parse_url['query']) ? $parse_url['query'] : '';
    $params    = parseUrlParam($query);
    return isset($params[$cparam]) ? $params[$cparam] : '';
}
/*****************************************
 *            获取URL参数相关函数         *
 * ***************************************
 *                 结束                  *
 * ***************************************
 */

/**
 * [CheckUserLevel 检查页面权限]
 * @param [type] $sulevel [所需权限]
 * Level 等级
 * 1     超管
 * 2     管理
 * 3     信息录入员
 */
function CheckUserLevel($sulevel)
{
    switch ($sulevel) {
        case 'suadmin':
            $sulevel = array(1);
            $allourl = array('main', 'dashboard', 'mem_list', 'mem_edit', 'pay_list', 'pay_edit', 'edu_list', 'edu_edit', 'login_log', 'manager_list', 'manager_edit', 'site_setting', 'profile');
            break;
        case 'admin':
            $sulevel = array(1, 2);
            $allourl = array('main', 'mem_list', 'mem_edit', 'login_log', 'profile');
            break;

        case 'all':
            $sulevel = array(1, 2, 3);
            $allourl = array('main', 'mem_list', 'mem_edit', 'login_log', 'profile');
            break;
    }
    //未来列表权限验证需要的
    $this_url        = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
    $url_level_check = getUrlParam('do', $this_url);

    //暂时先用着下面的……
    $user_level = $_SESSION['user_level'];
    if (!in_array($user_level, $sulevel)) {
        sweetalert('权限不足！', '您没有权限操作该板块', 'error', '0', '', '返回', 'main', 1, 2000);
    }
}
/**
 * 随机HEX颜色
 */
function RandColor()
{
    $colors = array();
    for ($i = 0; $i < 6; $i++) {
        $colors[] = dechex(rand(0, 15));
    }
    return '#' . implode('', $colors);
}

/**
 * 单位转换
 */
function byte_format($size, $dec = 2)
{
    $a   = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
    $pos = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    return round($size, $dec) . " " . $a[$pos];
}
/**
 * [DBbackup 数据库备份]
 * @param [type] $db_path [路径]
 * @param string $db_ext  [拓展名]
 */
function DBbackup($db_path, $db_ext = '.sql')
{
    $cfg_dbhost = DB_HOST;
    $cfg_dbname = DB_NAME;
    $cfg_dbuser = DB_USER;
    $cfg_dbpwd = DB_PWD;
    // END 配置
    //链接数据库
    $link = mysqli_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
    mysqli_select_db($link,$cfg_dbname);
    if (!is_dir($db_path)) {
        mkdir($db_path, 0755, true);
    }
    date_default_timezone_set('Asia/ShangHai');
    set_time_limit(0);
    //配置信息
    $year         = date("Y");
    $month        = date("m");
    $day          = date("d");
    $hours        = date("H");
    $min          = date("i");
    $sec          = date("s");
    $to_file_name = DB_NAME . '-'.'Backup' . '-' . $year  . $month . $day . $hours  . $min  . $sec . $db_ext;
    //数据库中有哪些表
    $tables = mysqli_query($link,"SHOW TABLES FROM " . DB_NAME);
    //将这些表记录到一个数组
    $tabList = array();
    while ($row = mysqli_fetch_row($tables)) {

        $tabList[] = $row[0];

    }

    $info = "-- ----------------------------\r\n";
    $info .= "-- 日期：" . date("Y-m-d H:i:s", time()) . "\r\n";
    $info .= "-- ----------------------------\r\n\r\n";
    file_put_contents($db_path . $to_file_name, $info, FILE_APPEND);

    //将每个表的表结构导出到文件
    foreach ($tabList as $val) {
        $sql  = "show create table " . $val . ";";
        $res  = mysqli_query($link, $sql);
        $row  = mysqli_fetch_array($res);
        $info = "-- ----------------------------\r\n";
        $info .= "-- Table structure for `" . $val . "`\r\n";
        $info .= "-- ----------------------------\r\n";
        $info .= "DROP TABLE IF EXISTS `" . $val . "`;\r\n";
        $sqlStr = $info . $row[1] . ";\r\n\r\n";

        //追加到文件
        file_put_contents($db_path . $to_file_name, $sqlStr, FILE_APPEND);

        //释放资源

        mysqli_free_result($res);

    }

    //将每个表的数据导出到文件
    foreach ($tabList as $val) {
        $sql = "select * from " . $val . ";";
        $res = mysqli_query($link, $sql);
        //如果表中没有数据，则继续下一张表
        if (mysqli_num_rows($res) < 1) {
            continue;
        }

        //
        $info = "-- ----------------------------\r\n";
        $info .= "-- Records for `" . $val . "`\r\n";
        $info .= "-- ----------------------------\r\n";
        file_put_contents($db_path . $to_file_name, $info, FILE_APPEND);

        //读取数据
        while ($row = mysqli_fetch_row($res)) {
            $sqlStr = "INSERT INTO `" . $val . "` VALUES (";
            foreach ($row as $zd) {
                $sqlStr .= "'" . $zd . "', ";
            }

            //去掉最后一个逗号和空格
            $sqlStr = substr($sqlStr, 0, strlen($sqlStr) - 2);
            $sqlStr .= ");\r\n";
            file_put_contents($db_path . $to_file_name, $sqlStr, FILE_APPEND);

        }

        //释放资源
        mysqli_free_result($res);

        file_put_contents($db_path . $to_file_name, "\r\n", FILE_APPEND);

    }

    sweetalert('备份完成', '数据库备份完成', 'success', '0', '', '返回', 'backupdb', 1, 5000);
}
