<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测入口
CheckEntrance();
//$id     = $_SESSION['member_info_id'];
//检测权限
CheckUserLevel('admin');
$sql = "
SELECT mem_name,mem_gender,mem_stunum,mem_phone,mem_pay_check
FROM member
WHERE mem_id = ?";
$result = $con->prepare($sql);
$result->bind_param("i", $id);
$result->execute();
$result->bind_result($mem_name, $mem_gender, $mem_stunum, $mem_phone, $mem_pay_check);
if ($result->fetch()) {
    ?>
<div class="content__inner">
    <header class="content__title">
        <h1>修改缴费情况</h1>
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
            <h2 class="card-title">修改缴费情况</h2>
        </div>
        <div class="card-block">
            <form action="" method="post" role="form">
                <div class="form-group form-group--float">
                    <input type="text" class="form-control" value="<?php echo $mem_name; ?>" readonly>
                    <label>会员名</label>
                    <i class="form-group__bar"></i>
                </div>
                <div class="clearfix mb-2"></div>
                <div class="form-group">
                    <p>性别</p>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="gender" class="custom-control-input" <?php if ($mem_gender == 1) {echo "checked";}?> readonly>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">男</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="gender" class="custom-control-input" <?php if ($mem_gender != 1) {echo "checked";}?> readonly>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">女</span>
                    </label>
                </div>
                <div class="clearfix mb-2"></div>
                <div class="form-group form-group--float">
                    <input type="text" class="form-control" value="<?php echo $mem_stunum; ?>" readonly>
                    <label>学号</label>
                    <i class="form-group__bar"></i>
                </div>
                <div class="clearfix mb-2"></div>
                <div class="form-group form-group--float">
                    <input type="text" class="form-control" value="<?php echo $mem_phone; ?>" readonly>
                    <label>联系方式</label>
                    <i class="form-group__bar"></i>
                </div>
                <div class="clearfix mb-2"></div>
                <div class="form-group">
                    <p>缴费情况</p>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="pay_check" class="custom-control-input" value="1" <?php if ($mem_pay_check == 1) {echo "checked";}?> >
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">已缴费</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="pay_check" class="custom-control-input" value="0" <?php if ($mem_pay_check != 1) {echo "checked";}?> >
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">未缴费</span>
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
    $pay_status = intval(trim($_POST['pay_check']));
    $sql        = "UPDATE member SET mem_pay_check=? WHERE mem_id = ?";
    $stmt       = $con->prepare($sql);
    $stmt->bind_param('ii', $pay_status, $id);
    if ($stmt->execute()) {
        sweetalert('编辑成功', '会员:'.$mem_name.'缴费状态已更改', 'success','0' ,'' , '返回', 'pay_edit',1, 5000);
        $stmt->close();
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error.'</br>请将错误信息发给开发者获取帮助', 'error','0' ,'' , '返回', 'pay_edit',1, 5000);
    }
}

?>