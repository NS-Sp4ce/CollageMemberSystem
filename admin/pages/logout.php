<?php
//包含函数文件
require_once './include/function.php';
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
sweetalert('注销成功！', '返回登录页面', 'success', '0', '', '返回', 'login', 1, 3000);
exit();
