<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测入口
CheckEntrance();
//检测权限
CheckUserLevel('admin');
//$id     = $_SESSION['member_info_id'];
$sql = "
SELECT college_name
FROM college
WHERE college_id = ?";
$result = $con->prepare($sql);
$result->bind_param("i", $id);
$result->execute();
$result->bind_result($college_name);
if ($result->fetch()) {
    ?>
    <div class="content__inner">
        <header class="content__title">
            <h1>修改学院信息</h1>
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
                <h2 class="card-title">修改学院信息</h2>
            </div>
            <div class="card-block">
                <form action="" method="post" role="form">
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $college_name; ?>" name="college_name" required>
                        <label>学院名</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <button type="submit" class="btn btn-primary waves-effect" name="submit"><i class="zmdi zmdi-check"></i>提交</button>
                </form>
            </div>
        </div>
    </div>
    <?php }
    $result->close();
    ?>
    <?php
//处理表单
if (isset($_POST['submit'])) {
    $college_name = FilterInput($_POST['college_name']);
    $sql         = "UPDATE college 
    SET college_name =?
    WHERE
    college_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('si', $college_name, $id);
    if ($stmt->execute()) {
        sweetalert('编辑成功', '学院:'.$college_name.'已更改', 'success','0' ,'' , '返回', 'college_edit',1, 5000);
        $stmt->close();
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error.'</br>请将错误信息发给开发者获取帮助', 'error','0' ,'' , '返回', 'college_edit',1, 5000);
    }
}

?>