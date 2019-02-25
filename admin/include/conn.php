<?php
define('DB_HOST', 'localhost'); //数据库地址
define('DB_USER', 'membersysuser'); //数据库用户
define('DB_PWD', 'hPP4XrydMD99cGSV*'); //数据库密码
define('DB_NAME', 'uamsystem'); //数据库名
// 连接MYSQL服务器,选择数据库
$con = new mysqli(DB_HOST, DB_USER, DB_PWD);
if ($con->connect_error) {
    die("连接失败: " . $con->connect_error);
}
if (!$con->select_db(DB_NAME)) {
	die("数据库选择失败: " . $con->connect_error);
}
// 设置字符集
if (!$con->set_charset("utf8")) {
    die("字符集设置错误: " . $con->connect_error);
}
// 设置中国时区
date_default_timezone_set('PRC');
?>