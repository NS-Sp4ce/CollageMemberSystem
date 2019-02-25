<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//上次登录
$user_level = $_SESSION['user_level'];
$sql        = "SELECT * from sign_in_log ORDER BY sign_in_id DESC limit 1,1";
$result     = $con->query($sql);
if ($row = $result->fetch_array()) {
    $login_ip   = $row['sign_in_ip'];
    $login_time = $row['sign_in_time'];
} else {
    $login_ip   = '未知';
    $login_time = '未知';
}
$result->free();
$sql    = "SELECT program_version FROM site_config";
$result = $con->query($sql);
$row    = $result->fetch_array();
//更新授课数据
$update_edu_sql = "UPDATE teaching SET edu_status = '结束' WHERE edu_time < DATE_FORMAT(NOW(),'%y-%m-%d') AND edu_status ='正常' AND edu_status!='取消'";
?>
    <header class="content__title">
        <h1>

        主页
    </h1>
        <small>
        服务器基本信息
    </small>
        <div class="actions">
            <div class="dropdown actions__item">
                <i class="zmdi zmdi-more-vert" data-toggle="dropdown">
            </i>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="">
                    刷新
                </a>
                </div>
            </div>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <div class="card p-3">
                <div class="card-header">
                    <h2>
                    服务器基本信息
                    <small>
                        信息概览
                    </small>
                </h2>
                </div>
                <div class="table-responsive text-center">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="cen">
                                <th>
                                    服务器地址
                                </th>
                                <th>
                                    当前登陆用户IP地址
                                </th>
                                <th>
                                    当前登录用户
                                </th>
                                <th>
                                    上次登录IP
                                </th>
                                <th>
                                    上次登录时间
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $_SERVER["HTTP_HOST"]; ?>
                                </td>
                                <td>
                                    <?php echo $_SERVER['REMOTE_ADDR']; ?>
                                </td>
                                <td>
                                    <?php echo $_SESSION['username']; ?>
                                </td>
                                <td>
                                    <?php echo $login_ip; ?>
                                </td>
                                <td>
                                    <?php echo $login_time; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="cen">
                                <th>
                                    服务器系统
                                </th>
                                <th>
                                    PHP运行方式
                                </th>
                                <th>
                                    PHP版本
                                </th>
                                <th>
                                    最大执行时间
                                </th>
                                <th>
                                    服务器时间
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo php_uname('s'); ?>
                                </td>
                                <td>
                                    <?php echo php_sapi_name(); ?>
                                </td>
                                <td>
                                    <?php echo phpversion(); ?>
                                </td>
                                <td>
                                    <?php echo get_cfg_var("max_execution_time") . "秒 "; ?>
                                </td>
                                <td>
                                    <?php
echo date("Y-m-d G:i:s");
?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="cen">
                                <th>
                                    MySQL版本
                                </th>
                                <th>
                                    允许占用最大内存
                                </th>
                                <th>
                                    最大上传限制
                                </th>
                                <th>
                                    服务器端信息
                                </th>
                                <th>
                                    MYSQL支持
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo mysqli_get_server_info($con); ?>
                                </td>
                                <td>
                                    <?php echo get_cfg_var("memory_limit") ? get_cfg_var("memory_limit") : "无" ?>
                                </td>
                                <td>
                                    <?php echo get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许上传附件"; ?>
                                </td>
                                <td>
                                    <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
                                </td>
                                <td>
                                    <?php echo function_exists(mysqli_close) ? "是" : "否"; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="cen">
                                <th>
                                    程序版本
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php
echo $row['program_version'];
$result->free();
?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    function notify(from, align, icon, type, animIn, animOut,title,msg) {
        var notify = $.notify({
            icon: icon,
            title: title,
            message: msg,
            url: ''
        }, {
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 20,
                y: 20
            },
            spacing: 10,
            z_index: 1031,
            delay: 2500,
            timer: 1000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: animIn,
                exit: animOut
            },
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-dismissible alert-{0}" role="alert">'
            + '<span data-notify="icon"></span> '
            + '<span data-notify="title">{1}</span> '
            + '<span data-notify="message">{2}</span>'
            + '<div class="progress" data-notify="progressbar">'
            + '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>'
            + '</div>'
            + '<a href="{3}" target="{4}" data-notify="url"></a>'
            + '<button type="button" aria-hidden="true" data-notify="dismiss" class="alert--notify__close text-white">×</button>'
            + '</div>'
        });
    }

        notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','success', 'animated fadeIn', 'animated fadeOutDown','提示','用户： <?php echo $u_name; ?> 欢迎您');
        <?php
if ($user_level == 1) {
    if ($con->query($update_edu_sql)) {
        echo "notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','warning', 'animated fadeIn', 'animated fadeOutDown','提示','授课数据已更新！');";
    } else {
        echo "notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','danger', 'animated fadeIn', 'animated fadeOutDown','提示','授课数据更新失败！" . $con->error . "');";
    }

}
?>
    </script>