<!DOCTYPE html>
<html>
<?php
ob_start();
include './recourse/header.php';
include './include/function.php';
date_default_timezone_set('Asia/Shanghai');
?>
<body>
<script language="javascript" type="text/javascript">
var i = 2;
var intervalid;
intervalid = setInterval("fun()", 1000);
function fun() {
if (i == 0) {
window.location.href = "./index.php";
clearInterval(intervalid);
}else{
document.getElementById("time").innerHTML = i;
i--;
}
}
</script>
<section id="main"class="m-5">
<div class="container">
    <div class="card icons-demo">
    <div class="card-header">
        <h2>提示</h2>
    </div>
<div class="card-body card-padding p-5">
<?php
if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $hide  = 'none';
    if ($login !== "") {
        include './include/conn.php';
        $username = FilterInput($_POST['username']);
        $password = MD5($_POST['password']);
        $sql      = "SELECT a.*,b.* from manager a,manager_level b where admin_name='$username' and admin_pwd='$password' and a.admin_level=b.level_id limit 1";
        $result   = $con->query($sql);
        if ($row = $result->fetch_array()) {
            session_start();
            $user_level_id                 = $row['admin_level'];
            $user_level_name               = $row['level_name'];
            $_SESSION['username']          = $username;
            $_SESSION['user_id']           = $row['admin_id'];
            $_SESSION['useremail']         = $row['admin_email'];
            $_SESSION['useravatar']        = $row['admin_avatar'];
            $time                          = date('Y-m-d H:i:s');
            $_SESSION['login_time']        = $time;
            $logip                         = $_SERVER['REMOTE_ADDR'];
            $ua                            = FilterInput($_SERVER['HTTP_USER_AGENT']);
            $_SESSION['user_level']        = $user_level_id;
            $color                         = 'success';
            $text                          = '用户: ' . $username . ' 登录成功<p>当前级别：<span class="badge badge-primary">' . $user_level_name . '</span></p>即将跳转后台<p>页面将在<span id="time">3</span>秒后<a href="index.php" class="alert-link"> 进入用户中心</a></p>';
            $hide                          = '';
            $insert_sql                    = "INSERT INTO sign_in_log (sign_in_name,sign_in_ip,sign_in_ua,sign_in_time)VALUES (?,?,?,?)";
            $stmt                          = $con->prepare($insert_sql);
            $stmt->bind_param('ssss', $username, $logip, $ua, $time);
            $stmt->execute();
            $stmt->close();
        } else {
            $color = 'danger';
            $text  = '登录失败 请检查用户名或密码 <p>页面将在<code id="time">3</code>秒后<a href="login.php" class="alert-link"> 返回登录</a></p>';
            $hide  = '';
        }
        echo "<div class=\"alert alert-" . $color . "\" role=\"alert\" style=\"display:" . $hide . "\"><i class=\"him-icon zmdi zmdi-alert-triangle\"></i> " . $text . "</div>";
        $result->free();
        $con->close();
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    echo "<div class=\"alert alert-danger\"><i class=\"him-icon zmdi zmdi-alert-triangle\"></i> 禁止非法访问 </ br> <code id=\"time\">3</code>秒后<a href=\"login.php\" class=\"alert-link\"> 返回登录</a></p></div>";
    ob_end_flush();
}
?>
</div>
</div>
</div>
</section>
</body>
</html>