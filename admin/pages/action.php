<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测入口
CheckEntrance();
$user_level = $_SESSION['user_level'];
if (isset($_GET)) {
    $do   = $_GET['act'];
    $team = $_GET['t'];
    switch ($team) {
        case 'member':
            $team    = 'member';
            $id_name = 'mem_id';
            break;

        case 'edu':
            $team    = 'teaching';
            $id_name = 'edu_id';
            break;

        case 'pay':
            $team = 'pay';
            break;

        case 'manager':
            $team    = 'manager';
            $id_name = 'admin_id';
            break;

        case 'college':
            $team    = 'college';
            $id_name = 'college_id';
            break;

        default:
            break;
    }
    $id = intval(trim($_GET['id']));
    switch ($do) {
        case 'delete':
            /**
             * 只能删除 member 和 teaching
             * pay不可删
             */
            $delete_sql = "DELETE  FROM " . $team . " WHERE " . $id_name . " = ? ";

            switch ($team) {
                case 'member':
                    //预编译
                    $stmt = $con->prepare($delete_sql);
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        sweetalert('删除成功', 'ID:' . $id . '信息已删除', 'success', '0', '', '返回', 'mem_edit', 1, 5000);
                        $stmt->close();
                    }
                    break;

                case 'teaching':
                    //预编译
                    $stmt = $con->prepare($delete_sql);
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        sweetalert('删除成功', 'ID:' . $id . '信息已删除', 'success', '0', '', '返回', 'edu_edit', 1, 5000);
                        $stmt->close();
                    } else {
                        echo $con->error();
                    }
                    break;

                case 'manager':
                    if ($id == 1) {
                        sweetalert('删除失败！', '系统内置账户禁止删除！', 'warning', '0', '', '返回', 'manager_edit', 1, 5000);
                    } else {
                        if ($user_level == 1) {
                            $stmt = $con->prepare($delete_sql);
                            $stmt->bind_param('i', $id);
                            if ($stmt->execute()) {
                                sweetalert('删除成功', 'ID:' . $id . '信息已删除', 'success', '0', '', '返回', 'manager_edit', 1, 5000);
                                $stmt->close();
                            } else {
                                echo $con->error();
                            }
                        } else {
                            sweetalert('删除失败', '权限不足！', 'error', '0', '', '返回', 'manager_edit', 1, 5000);
                        }
                    }
                    break;

                case 'college':
                    //预编译
                    $stmt = $con->prepare($delete_sql);
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        sweetalert('删除成功', 'ID:' . $id . '信息已删除', 'success', '0', '', '返回', 'college_edit', 1, 5000);
                        $stmt->close();
                    } else {
                        echo $con->error();
                    }
                    break;
                default:
                    break;
            }
            break;
        case 'edit':
            /**
             * 三种都可以编辑
             */
            switch ($team) {
                case 'member':
                    //$_SESSION['member_info_id']=$id;
                    require_once 'member_info_edit.php';
                    break;

                case 'teaching':
                    //$_SESSION['edu_info_id']=$id;
                    require_once 'edu_info_edit.php';
                    break;

                case 'pay':
                    //$_SESSION['pay_info_id']=$id;
                    require_once 'pay_info_edit.php';
                    break;

                case 'manager':
                    //$_SESSION['manager_info_id']=$id;
                    require_once 'manager_info_edit.php';
                    break;

                case 'college':
                    //$_SESSION['college_info_id']=$id;
                    require_once 'college_info_edit.php';
                    break;

                default:
                    break;
            }
            break;
        case 'downloaddb':
            $filename      = $_GET['filename'];
            $download_path = "./db_backup/";
            if (preg_match("/\.\./i", $filename)) {
                header("HTTP/1.1 403 Forbidden");
                sweetalert('下载失败', '文件禁止下载', 'error', '0', '', '返回', 'backupdb', 1, 5000);
                exit();
            }
            $file = str_replace("/", "", $filename);
            $file = str_replace("..", "", $filename);
            if (preg_match("/\.ht.+/i", $filename)) {
                header("HTTP/1.1 403 Forbidden");
                sweetalert('下载失败', '文件禁止下载', 'error', '0', '', '返回', 'backupdb', 1, 5000);
                exit();
            }
            $file = $download_path.$file;
            if (!file_exists($file)) {
                header("HTTP/1.1 404 Not Found");
                sweetalert('下载失败', '文件不存在', 'error', '0', '', '返回', 'backupdb', 1, 5000);
                exit();
            }
            $type  = filetype($file);
            header('Location:'.$file,'','302');
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$filename);
            header("Content-Transfer-Encoding: binary");
            header('Pragma: no-cache');
            header('Expires: 0');
            set_time_limit(0);
            readfile($file);
            break;

        case 'backupdb':
            DBbackup('./db_backup/', '.sql');
            break;

        default:
            break;
    }

} else {
    header("HTTP/1.1 404 NOT FOUND");
}
?>