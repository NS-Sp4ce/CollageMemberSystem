<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测入口
CheckEntrance();
//检查权限
CheckUserLevel('suadmin');
//$id     = $_SESSION['member_info_id'];
$level_sql    = "SELECT * FROM manager_level";
$level_result = $con->query($level_sql);
$sql          = "
SELECT admin_name,admin_pwd,admin_email,admin_phone,admin_qq,admin_level
FROM manager
WHERE admin_id = ?";
$result = $con->prepare($sql);
$result->bind_param("i", $id);
$result->execute();
$result->bind_result($admin_name, $admin_pwd, $admin_email, $admin_phone,$admin_qq, $admin_level);
if ($result->fetch()) {
    ?>
    <div class="content__inner">
        <header class="content__title">
            <h1>修改管理员信息</h1>
            <div class="actions">
                <div class="dropdown actions__item">
                    <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="" class="dropdown-item">刷新</a>
                    </div>
                </div>
            </div>
        </header>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">修改管理员信息</h2>
            </div>
            <div class="card-block">
                <form action="" method="post" role="form">
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_name; ?>" name="admin_name" required>
                        <label>管理员</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group">
                        <p>级别</p>
                        <?php 
                        if ($level_result->num_rows > 0) {
                            while ($row = $level_result->fetch_array()) {
                                echo '
                                <label class="custom-control custom-radio">
                                <input type="radio" name="admin_level" class="custom-control-input" value="' . $row['level_id'] . '"';
                                if ($admin_level == $row['level_id']) {
                                    echo "checked";
                                    
                                }
                                echo ' required><span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">' . $row['level_name'] . '</span>
                                    </label>';
                                }
                            }
                        ?>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" name="admin_pwd" required>
                        <label>密码</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_email; ?>" name="admin_email" required>
                        <label>邮箱</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_qq; ?>" name="admin_qq" required>
                        <label>QQ</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_phone; ?>" name="admin_phone" required>
                        <label>联系方式</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <button type="submit" class="btn btn-primary waves-effect" name="submit"><i class="zmdi zmdi-check"></i>提交</button>
                </form>
            </div>
        </div>
    </div>
    <?php
}
$result->close();
?>
    <?php
//处理表单
if (isset($_POST['submit'])) {
    $admin_name      = FilterInput($_POST['admin_name']);
    $admin_level    = intval(FilterInput($_POST['admin_level']));
    $admin_pwd    = MD5(FilterInput($_POST['admin_pwd']));
    $admin_email     = FilterInput($_POST['admin_email']);
    $admin_qq        = FilterInput($_POST['admin_qq']);
    $admin_phone     = FilterInput($_POST['admin_phone']);
    $sql           = "UPDATE manager
    SET admin_name =?,
    admin_level =?,
    admin_pwd =?,
    admin_email =?,
    admin_qq =?,
    admin_phone =?
    WHERE
    admin_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sissssi', $admin_name, $admin_level, $admin_pwd, $admin_email, $admin_qq, $admin_phone,$id);
    if ($stmt->execute()) {
        sweetalert('编辑成功', '管理员:' . $admin_name . '信息已更改', 'success', '0', '', '返回', 'manager_edit', 1, 5000);
        $stmt->close();
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error . '</br>请将错误信息发给开发者获取帮助', 'error', '0', '', '返回', 'manager_edit', 1, 5000);
    }
}

?>