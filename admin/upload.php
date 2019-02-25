<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
$id = $_SESSION['user_id'];
if (isset($_GET['adr'])) {
    $adr = $_GET['adr'];
    switch ($adr) {
        case 'site':
            $sql_table_name     = "site_config";
            $sql_columns_name   = "site_logo";
            $sql_columns_id     = "1";
            $sql_colimns_option = "site_id";
            $dirpath            = "../upload/image/site";
            break;
        case 'profile':
            $sql_table_name     = "manager";
            $sql_columns_name   = "admin_avatar";
            $sql_columns_id     = $id;
            $sql_colimns_option = "admin_id";
            $dirpath            = "../upload/image/profile";
            break;
    }
    //包含数据库文件
    require_once './include/conn.php';
    $sql = "UPDATE " . $sql_table_name . " SET " . $sql_columns_name . " = ? WHERE " . $sql_colimns_option . "= " . $sql_columns_id;
    //文件日期时间
    date_default_timezone_set("Asia/Shanghai");
    $year  = date("Y");
    $month = date("m");
    $day   = date("d");
    $hours = date("H");
    $min   = date("i");
    $sec   = date("s");
    $data  = array();
    //上传文件路径
    $file_path = $dirpath . '/' . date("Y") . '/' . date("m") . '/' . date("d");
    // 允许上传的图片后缀
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp        = explode(".", $_FILES["file"]["name"]);
    $extension   = end($temp); // 获取文件后缀名
    if (
        (
            ($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png")
        )
        && in_array($extension, $allowedExts)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            $data['status']   = 500;
            $data['movepath'] = $_FILES["file"]["error"];
            $data['msg']      = '错误：';
            $info             = new stdclass();
            foreach ($data as $key => $value) {
                $info->$key = $value;
            }
            $data = json_encode($info);
            print_r($data);
        } else {
            if (!is_dir($file_path)) {
                mkdir($file_path, 0755, true);
            }
            /**
             * 重命名格式
             * 上传文件名-年-月-日-时-分-秒 base64编码后md5编码确保不重复
             */
            $NewFileName = md5(base64_encode($_FILES["file"]["name"] . '-' . $year . '-' . $month . '-' . $day . '-' . $hours . '-' . $min . '-' . $sec)) . "." . $extension;
            //判断是否存在
            if (file_exists($file_path . '/' . $NewFileName)) {
                $data['status']   = 201;
                $data['movepath'] = $movedpath;
                $data['msg']      = '文件已存在！';
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $file_path . '/' . $NewFileName);
                $movedpath = $file_path . '/' . $NewFileName;
                $stmt      = $con->prepare($sql);
                $stmt->bind_param('s', $movedpath);
                $stmt->execute();
                $stmt->close();
                $data['status']   = 200;
                $data['movepath'] = $movedpath;
                $data['msg']      = '文件上传成功！';
            }
            //返回上传信息
            $info = new stdclass();
            foreach ($data as $key => $value) {
                $info->$key = $value;
            }
            $data = json_encode($info);
            print_r($data);
        }
    } else {
        $data['status']   = 400;
        $data['movepath'] = 'NULL';
        $data['msg']      = '文件格式非法！';
        $info             = new stdclass();
        foreach ($data as $key => $value) {
            $info->$key = $value;
        }

        $data = json_encode($info);
        print_r($data);
    }
}else{
    header("HTTP/1.1 404 NOT FOUND");
}