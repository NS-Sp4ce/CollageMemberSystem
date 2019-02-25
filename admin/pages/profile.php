<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测入口
CheckEntrance();
$id           = $_SESSION['user_id'];
$level_sql    = "SELECT * FROM manager_level";
$level_result = $con->query($level_sql);
$sql          = "
SELECT admin_name,admin_pwd,admin_email,admin_phone,admin_qq,admin_level,admin_avatar
FROM manager
WHERE admin_id = ?";
$result = $con->prepare($sql);
$result->bind_param("i", $id);
$result->execute();
$result->bind_result($admin_name, $admin_pwd, $admin_email, $admin_phone, $admin_qq, $admin_level, $admin_avatar);
if ($result->fetch()) {
    ?>
    <div class="content__inner">
        <header class="content__title">
            <h1>修改信息</h1>
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
                <h2 class="card-title">修改信息</h2>
            </div>
            <div class="card-block">
                <form action="" method="post" role="form">
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_name; ?>" name="admin_name" required>
                        <label>ID</label>
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
            if ($admin_level != 1) {
                echo ' readonly';
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
                        <input type="text" class="form-control" value="<?php echo $admin_email; ?>" name="admin_email">
                        <label>邮箱</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_qq; ?>" name="admin_qq">
                        <label>QQ</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $admin_phone; ?>" name="admin_phone">
                        <label>联系方式</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float col-md-6">
                        <input type="text" class="form-control" value="<?php echo $admin_avatar; ?>" name="admin_upload_avatar" id="logo" readonly>
                        <label>头像</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="dropzone col-md-6 form-group" id="dropzone-upload"></div>
                    <div class="clearfix mb-2"></div>
                    <span id="upload-status"></span>
                    <div class="clearfix mb-2"></div>
                    <button type="submit" class="btn btn-primary waves-effect" name="submit"><i class="zmdi zmdi-check"></i>提交</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    //提示
    function notify(from, align, icon, type, animIn, animOut, title, msg) {
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
            template: '<div data-notify="container" class="col-md-auto alert alert-dismissible alert-{0}" role="alert">' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '<button type="button" aria-hidden="true" data-notify="dismiss" class="alert--notify__close text-white">×</button>' +
            '</div>'
        });
    }

    //上传处理
    Dropzone.autoDiscover = false;
    $("div#dropzone-upload").dropzone({
        url: "./upload.php?adr=profile", //文件提交地址
        method: "post", //方法
        paramName: "file", //默认为file
        maxFiles:1,//一次性上传的文件数量上限
        maxFilesize: 2, //文件大小，单位：MB
        acceptedFiles: ".jpg,.gif,.png,.jpeg", //上传的类型
        addRemoveLinks:true,
        parallelUploads: 1,//一次上传的文件数量
        //previewsContainer:"#preview",//上传图片的预览窗口
        dictDefaultMessage: '拖动文件至此或者点击上传',
        dictMaxFilesExceeded: "您最多只能上传1个文件！",
        dictResponseError: '文件上传失败!',
        dictInvalidFileType: "文件类型只能是*.jpg,*.gif,*.png,*.jpeg。",
        dictFallbackMessage: "浏览器不受支持",
        dictFileTooBig: "文件过大，上传文件最大支持2M.",
        dictRemoveLinks: "删除",
        dictCancelUpload: "取消",
        init: function() {
            this.on("success", function(file, res) {
                //console.log(res);
                var obj = JSON.parse(res);
                //console.log(obj.status);
                if (obj.status == 200) {
                    $("#upload-status").removeClass();
                    $("#upload-status").addClass('text-success');
                    $("#upload-status").html('文件:' + file.name + '上传成功');
                    notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','success', 'animated fadeIn', 'animated fadeOutDown','文件：'+file.name+'上传成功，头像更改成功','');
                    $('#logo').val(obj.movepath);
                    $("#user_avatar").attr('src',obj.movepath);
                } else if (obj.status == 201) {
                    $("#upload-status").removeClass();
                    $("#upload-status").addClass('text-warning');
                    $("#upload-status").html('文件:' + file.name + '已存在');
                    notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','warning', 'animated fadeIn', 'animated fadeOutDown','文件：'+file.name+'已存在','');
                    $('#logo').val(obj.movepath);
                    $('#user_avatar').attr('src').html(obj.movepath);
                }
            });
            this.on("error", function(file, res) {
                $("#upload-status").removeClass();
                $("#upload-status").addClass('text-danger');
                $("#upload-status").html('文件:' + file.name + '上传失败，请滑到图片上查看错误信息');
                notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','error', 'animated fadeIn', 'animated fadeOutDown','文件：'+file.name+'上传失败','错误信息'+obj.msg);
                //console.log(file.path + file.name)
            });
        }
    });
    </script>
    <?php
}
$result->close();
?>
    <?php
//处理表单
if (isset($_POST['submit'])) {
    $admin_name          = FilterInput($_POST['admin_name']);
    $admin_email         = FilterInput($_POST['admin_email']);
    $admin_upload_avatar = $_POST['admin_upload_avatar'];
    if (!empty($_POST['admin_pwd'])) {
        $admin_pwd = MD5(FilterInput($_POST['admin_pwd']));
    } else {
        sweetalert('编辑失败', '错误信息：密码不能为空', 'error', '0', '', '返回', 'profile', 1, 5000);
        exit();
    }
    $admin_qq    = FilterInput($_POST['admin_qq']);
    $admin_phone = FilterInput($_POST['admin_phone']);
    unset($_SESSION['useravatar']);
    $_SESSION['useravatar'] = $admin_upload_avatar;
    $sql = "UPDATE manager
    SET admin_name =?,
    admin_pwd =?,
    admin_email =?,
    admin_qq =?,
    admin_phone =?
    WHERE
    admin_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssssi', $admin_name, $admin_pwd, $admin_email, $admin_qq, $admin_phone, $id);
    if ($stmt->execute()) {
        sweetalert('编辑成功', '管理员:' . $admin_name . '信息已更改', 'success', '0', '', '返回', 'profile', 1, 5000);

        $stmt->close();
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error . '</br>请将错误信息发给开发者获取帮助', 'error', '0', '', '返回', 'profile', 1, 5000);
    }
}

?>