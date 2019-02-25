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
SELECT edu_teacher,edu_time,edu_content,edu_phone,edu_status
FROM teaching
WHERE edu_id = ?";
$result = $con->prepare($sql);
$result->bind_param("i", $id);
$result->execute();
$result->bind_result($edu_teacher, $edu_time, $edu_content, $edu_phone, $edu_status);
if ($result->fetch()) {
    ?>
    <div class="content__inner">
        <header class="content__title">
            <h1>修改授课信息</h1>
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
                <h2 class="card-title">修改授课信息</h2>
            </div>
            <div class="card-block">
                <form action="" method="post" role="form">
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $edu_teacher; ?>" name="edu_teacher" required>
                        <label>讲师名</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group">
                        <label>时间</label>
                        <input type="text" class="form-control input-mask date-picker flatpickr-input active" data-mask="0000/00/00" placeholder="<?php echo $edu_time; ?>" autocomplete="off" maxlength="10" name="edu_time" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $edu_content; ?>" name="edu_content" required>
                        <label>内容</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group">
                        <label>联系方式</label>
                        <input type="text" class="form-control input-mask" data-mask="(86) 000-0000-0000" name="edu_phone" maxlength="11" value="<?php echo $edu_phone; ?>" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group">
                        <p>当前状态</p>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="edu_status" class="custom-control-input" value="正常" <?php if ($edu_content == '正常') {echo "checked";}?> required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">正常</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="edu_status" class="custom-control-input" value="延期" <?php if ($edu_content != '延期') {echo "checked";}?> >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">延期</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="edu_status" class="custom-control-input" value="取消" <?php if ($edu_content != '取消') {echo "checked";}?> >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">取消</span>
                        </label>
                    </div>
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
    $edu_teacher = FilterInput($_POST['edu_teacher']);
    $edu_time    = FilterInput($_POST['edu_time']);
    $edu_content = FilterInput($_POST['edu_content']);
    $edu_phone   = FilterInput($_POST['edu_phone']);
    $edu_status  = FilterInput($_POST['edu_status']);
    $sql         = "UPDATE teaching 
    SET edu_teacher =?,
    edu_time =?,
    edu_content =?,
    edu_phone =?,
    edu_status =? 
    WHERE
    edu_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssssi', $edu_teacher, $edu_time, $edu_content, $edu_phone, $edu_status, $id);
    if ($stmt->execute()) {
        sweetalert('编辑成功', '授课信息:'.$edu_content.'已更改', 'success','0' ,'' , '返回', 'edu_edit',1, 5000);
        $stmt->close();
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error.'</br>请将错误信息发给开发者获取帮助', 'error','0' ,'' , '返回', 'edu_edit',1, 5000);
    }
}

?>