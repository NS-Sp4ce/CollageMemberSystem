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
$sql = "
SELECT * FROM site_config";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row       = $result->fetch_array();
    $site_name = $row['site_name'];
    $site_logo = $row['site_logo'];
    $main_page = $row['site_main_page'];
    $version   = $row['program_version'];
}
?>
    <div class="content__inner">
        <header class="content__title">
            <h1>修改站点信息</h1>
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
                <h2 class="card-title">修改站点信息</h2>
            </div>
            <div class="card-block">
                <form action="" method="post" role="form">
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $site_name; ?>" name="site_name">
                        <label>名称</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float col-md-6">
                        <input type="text" class="form-control" value="<?php echo $site_logo; ?>" name="site_logo" id="logo" readonly>
                        <label>图标</label>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="dropzone col-md-6 form-group" id="dropzone-upload"></div>
                    <div class="clearfix mb-2"></div>
                    <span id="upload-status"></span>
                    <div class="clearfix mb-2"></div>
                    <div class="form-group form-group--float">
                        <input type="text" class="form-control" value="<?php echo $version; ?>" name="version" required>
                        <label>程序版本</label>
                        <i class="form-group__bar"></i>
                    </div>
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
        url: "./upload.php?adr=site", //文件提交地址
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
                console.log(res);
                var obj = JSON.parse(res);
                console.log(obj.status);
                if (obj.status == 200) {
                    $("#upload-status").removeClass();
                    $("#upload-status").addClass('text-success');
                    $("#upload-status").html('文件:' + file.name + '上传成功');
                    notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','success', 'animated fadeIn', 'animated fadeOutDown','文件：'+file.name+'上传成功','');
                    $('#logo').val(obj.movepath);
                    $('#site_logo').attr('src').html(obj.movepath);
                } else if (obj.status == 201) {
                    $("#upload-status").removeClass();
                    $("#upload-status").addClass('text-warning');
                    $("#upload-status").html('文件:' + file.name + '已存在');
                    notify('top', 'right','zmdi zmdi-alert-triangle zmdi-hc-fw','warning', 'animated fadeIn', 'animated fadeOutDown','文件：'+file.name+'已存在','');
                    $('#logo').val(obj.movepath);
                    $('#site_logo').attr('src').html(obj.movepath);
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
$result->close();
?>
    <?php
//处理表单
if (isset($_POST['submit'])) {
    $site_name = FilterInput($_POST['site_name']);
    $site_logo = FilterInput($_POST['site_logo']);
    $version   = FilterInput($_POST['version']);
    $main_page = FilterInput($_POST['main_page']);
    unset($_SESSION['site_logo']);
    $_SESSION['site_logo'] = $admin_upload_avatar;
    $sql       = "UPDATE site_config
    SET site_name =?,
    site_logo =?,
    site_main_page =?,
    program_version =?
    WHERE
    site_id = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ssss', $site_name, $site_logo, $main_page, $version);
    if ($stmt->execute()) {
        sweetalert('编辑成功', '站点信息:' . $site_name . '已更改', 'success', '0', '', '返回', 'site_setting', 1, 5000);
        $stmt->close();
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error . '</br>请将错误信息发给开发者获取帮助', 'error', '0', '', '返回', 'site_setting', 1, 5000);
    }
}

?>