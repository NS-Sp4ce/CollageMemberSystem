<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测入口
CheckEntrance();
$college_sql="SELECT college_name FROM college";
$result=$con->query($college_sql);
$year=date("Y");
    ?>
    <div class="content__inner">
        <header class="content__title">
            <h1>添加会员</h1>
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
                <h2 class="card-title">添加会员</h2>
            </div>
            <div class="card-block">
                <form action="" method="post" role="form">
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $mem_name; ?>" name="mem_name" maxlength="4" required>
                        <label>会员名</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group">
                        <p>性别</p>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="mem_gender" class="custom-control-input" value="1" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">男</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input type="radio" name="mem_gender" class="custom-control-input" value="0">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">女</span>
                        </label>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" name="mem_stunum" required>
                        <label>学号</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" name="mem_phone" required>
                        <label>联系方式</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" name="mem_qq" required>
                        <label>QQ</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" name="mem_class" required>
                        <label>班级</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label>学院</label>
                        <select class="select2" data-placeholder="选择一项" name="mem_college">
                            <?php 
                                if ($result->num_rows>0) {
                                    echo "<option> </option>";
                                    while ($row=$result->fetch_array()) {
                                        echo "<option value=\"".$row['college_name']."\">".$row['college_name']."</option>". PHP_EOL;
                                    }
                                } 
                                $result->free(); ?>
                        </select>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group">
                        <label>加入时间（默认为当前年份）</label>
                        <input type="text" class="form-control" maxlength="4" value="<?php echo $year; ?>" name="mem_join_time" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <button type="submit" class="btn btn-primary waves-effect" name="submit"><i class="zmdi zmdi-check"></i>提交</button>
                </form>
            </div>
        </div>
    </div>
    <?php
//处理表单
if (isset($_POST['submit'])) {
    $mem_name    = FilterInput($_POST['mem_name']);
    $mem_gender  = intval(FilterInput($_POST['mem_gender']));
    $mem_stunum  = FilterInput($_POST['mem_stunum']);
    $mem_phone   = FilterInput($_POST['mem_phone']);
    $mem_qq      = FilterInput($_POST['mem_qq']);
    $mem_class   = FilterInput($_POST['mem_class']);
    $mem_college = FilterInput($_POST['mem_college']);
    if (empty($mem_college)) {
        sweetalert('未选择二级学院', '会员:' . $mem_name . ' 未选择二级学院', 'warning', '0', '', '返回', 'mem_add'.$id, 1, 5000);
        exit();
    }
    $pay_default='0';
    if (empty(FilterInput($_POST['mem_join_time']))) {
        $mem_join_time=date("Y");
    }else{
        $mem_join_time=intval(FilterInput($_POST['mem_join_time']));
    }
    $sql         = "INSERT INTO member(mem_name, mem_gender, mem_stunum, mem_phone, mem_qq, mem_class, mem_college,mem_pay_check,mem_join_time) 
                                VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssssssii', $mem_name, $mem_gender, $mem_stunum, $mem_phone, $mem_qq, $mem_class, $mem_college,$pay_default,$mem_join_time);
    if ($stmt->execute()) {
       sweetalert('添加成功', '会员:'.$mem_name.'信息已添加', 'success','0' ,'' , '返回', 'mem_add',1, 5000);
        $stmt->close();
    } else {
        sweetalert('添加失败', '错误信息：' . $con->error.'</br>请将错误信息发给开发者获取帮助', 'error','0' ,'' , '返回', 'mem_add',1, 5000);
    }
}

?>