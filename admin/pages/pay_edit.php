<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//检测权限
CheckUserLevel('admin');
$sql    = "SELECT mem_id,mem_name,mem_gender,mem_stunum,mem_phone,mem_pay_check FROM member";
$result = $con->query($sql);
?>
<header class="content__title">
    <h1>编辑缴费信息</h1>
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
        <h2 class="card-title">编辑缴费信息</h2>
        <small class="card-subtitle">编辑缴费信息，可快速检索</small>
    </div>
    <div class="card-block">
        <div class="table-responsive">

                    <?php
if ($result->num_rows > 0) {
    echo '<form action="" method="post">
            <table id="data-table" class="table table-bordered">
                <thead class="thead-default">
                    <tr>
                        <th>批量更改</th>
                        <th>#</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>联系方式</th>
                        <th>已缴费</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>批量更改</th>
                        <th>#</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>联系方式</th>
                        <th>已缴费</th>
                        <th>操作</th>
                    </tr>
                </tfoot>
                ';
    $n = 1;
    while ($row_log = $result->fetch_array()) {
        if ($row_log['mem_pay_check'] == 1) {
            $pay        = '是';
            $text_color = 'text-success';
            $icon       = '<i class="zmdi zmdi-check-circle"></i>';
        } else {
            $pay        = '否';
            $text_color = 'text-danger';
            $icon       = '<i class="zmdi zmdi-close-circle"></i>';
        }
        if ($row_log['mem_gender'] == 1) {
            $sex = '男';
        } elseif ($row_log['mem_gender'] == 0) {
            $sex = '女';
        } else {
            $sex = '未知';
        }
        echo '      <tr>' . PHP_EOL;
        echo '          <td>
            <div class="toggle-switch toggle-switch--blue">
            <input class="toggle-switch__checkbox" type="checkbox" name="editpay[]" value="' . $row_log['mem_id'] . '"';
        if ($row_log['mem_pay_check'] == 1) {
            echo " checked ";
        }
        echo '><i class="toggle-switch__helper"></i>
            </div>
        </td>' . PHP_EOL;
        echo '      <td>' . $n . '</td>' . PHP_EOL;
        echo '      <td>' . $row_log['mem_name'] . '</td>' . PHP_EOL;
        echo '      <td>' . $sex . '</td>' . PHP_EOL;
        echo '      <td>' . $row_log['mem_stunum'] . '</td>' . PHP_EOL;
        echo '      <td>' . $row_log['mem_phone'] . '</td>' . PHP_EOL;
        echo '      <td><span class="' . $text_color . '">' . $icon . $pay . '</span></td>' . PHP_EOL;
        echo '      <td>
        <a class="btn btn-outline-warning waves-effect" href="?do=action&act=edit&t=pay&id=' . $row_log['mem_id'] . '" title="编辑" data-toggle="tooltip" data-placement="top"><i class="zmdi zmdi-edit"></i></a>
        </td>' . PHP_EOL;
        echo '      </tr>' . PHP_EOL;
        $n++;
    }
    echo '
            </tbody>
        </table>
        <button class="btn btn-info btn--icon-text btn--fixed" type="submit" name="submit"><i class="zmdi zmdi-check"></i>提交批量编辑信息</button>
    </form>' . PHP_EOL;
} else {
    echo "<div class=\"alert alert-warning\" role=\"alert\">数据为空！</div>";
}
$result->free();
?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
        $("#data-table").DataTable({
            autoWidth: 1,
            responsive: 0,
            lengthMenu: [
                [15, 30, 45, -1],
                ["15 条", "30 条", "45 条", "所有"]
            ],
            language: {
                searchPlaceholder: "搜索..."
            },
            dom: "Blfrtip",
            buttons: [{
                extend: "excelHtml5",
                title: "导出数据"
            }, {
                extend: "csvHtml5",
                title: "导出数据"
            }, {
                extend: "print",
                title: "打印"
            }],
            initComplete: function(a, b) {
                $(this).closest(".dataTables_wrapper").prepend('<div class="dataTables_buttons hidden-sm-down actions"><span class="actions__item zmdi zmdi-print" data-table-action="print" /><span class="actions__item zmdi zmdi-fullscreen" data-table-action="fullscreen" /><div class="dropdown actions__item"><i data-toggle="dropdown" class="zmdi zmdi-download" /><ul class="dropdown-menu dropdown-menu-right"><a href="" class="dropdown-item" data-table-action="excel">Excel (.xlsx)</a><a href="" class="dropdown-item" data-table-action="csv">CSV (.csv)</a></ul></div></div>')
            }
        }), $(".dataTables_filter input[type=search]").focus(function() {
            $(this).closest(".dataTables_filter").addClass("dataTables_filter--toggled")
        }), $(".dataTables_filter input[type=search]").blur(function() {
            $(this).closest(".dataTables_filter").removeClass("dataTables_filter--toggled")
        }), $("body").on("click", "[data-table-action]", function(a) {
            a.preventDefault();
            var b = $(this).data("table-action");
            if ("excel" === b && $(this).closest(".dataTables_wrapper").find(".buttons-excel").trigger("click"), "csv" === b && $(this).closest(".dataTables_wrapper").find(".buttons-csv").trigger("click"), "print" === b && $(this).closest(".dataTables_wrapper").find(".buttons-print").trigger("click"), "fullscreen" === b) {
                var c = $(this).closest(".card");
                c.hasClass("card--fullscreen") ? (c.removeClass("card--fullscreen"), $("body").removeClass("data-table-toggled")) : (c.addClass("card--fullscreen"), $("body").addClass("data-table-toggled"))
            }
        })
    });
</script>
<?php
if (isset($_POST['submit'])) {
    //接收到的值
    $pay_info_id = $_POST['editpay'];
    //转字符串
    $slit_id = implode(",", $pay_info_id);
    //准备SQL语句
    $pay_info_sql = "UPDATE member SET mem_pay_check =1 WHERE mem_id = ?";
    //预处理语句
    if ($stmt = $con->prepare($pay_info_sql)) {
        //绑定参数
        $stmt->bind_param("i", $id);
        //还原数组
        $all_id = explode(',', $slit_id);
        for ($i = 0; $i < count($all_id); $i++) {
            $id = $all_id[$i];
            $stmt->execute();
        }
        sweetalert('编辑成功', '共编辑:' . count($all_id) . ' 条数据', 'success', '0', '', '返回', 'pay_edit', 1, 5000);
    } else {
        sweetalert('编辑失败', '错误信息：' . $con->error, 'error', '0', '', '返回', 'pay_edit', 1, 5000);
    }
}
?>