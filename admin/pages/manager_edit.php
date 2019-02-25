<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//检查权限
CheckUserLevel('suadmin');
$sql    = "SELECT a.*,b.* FROM manager a,manager_level b WHERE a.admin_level=b.level_id";
$result = $con->query($sql);
?>
    <header class="content__title">
        <h1>编辑管理员信息</h1>
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
            <h2 class="card-title">编辑管理员信息</h2>
            <small class="card-subtitle">编辑管理员信息，可快速检索</small>
        </div>
        <div class="card-block">
            <div class="table-responsive text-center">
                <?php
                    if ($result->num_rows > 0) {
                    echo '
            <table id="data-table" class="table table-bordered">
                <thead class="thead-default">
                    <tr>
                        <th>#</th>
                        <th>管理员名称</th>
                        <th>管理员邮箱</th>
                        <th>管理员联系方式</th>
                        <th>管理员QQ</th>
                        <th>创建时间</th>
                        <th>级别</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>管理员名称</th>
                        <th>管理员邮箱</th>
                        <th>管理员联系方式</th>
                        <th>管理员QQ</th>
                        <th>创建时间</th>
                        <th>级别</th>
                        <th>操作</th>
                    </tr>
                </tfoot>
                ';
    $n = 1;
    while ($row_log = $result->fetch_array()) {
        switch ($row_log['level_id']) {
            case '1':
                $color='text-danger';
                break;
            case '2':
                $color='text-warning';
                break;
            case '3':
                $color='text-info';
                break;
            default:
                # code...
                break;
        }
        echo '<tr>' . PHP_EOL;
        echo '<td>' . $n . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['admin_name'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['admin_email'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['admin_phone'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['admin_qq'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['admin_create_time'] . '</td>' . PHP_EOL;
        echo '<td class="'.$color.'">' . $row_log['level_name'] . '</td>' . PHP_EOL;
        if ($row_log['admin_id']==1) {
           echo '<td>
           <a class="btn btn-outline-danger waves-effect" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="系统保留帐号禁止删除！" data-original-title="提示" readonly><i class="zmdi zmdi-delete"></i></a>
           <a class="btn btn-outline-warning waves-effect" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="系统保留帐号请到个人编辑处修改！" data-original-title="提示" readonly><i class="zmdi zmdi-edit"></i></a>
           </td>';
        }else{
        echo '<td>
        <a class="btn btn-outline-danger waves-effect" href="?do=action&act=delete&t=manager&id=' . $row_log['admin_id'] . '" title="删除" data-toggle="tooltip" data-placement="top"><i class="zmdi zmdi-delete"></i></a>
        <a class="btn btn-outline-warning waves-effect" href="?do=action&act=edit&t=manager&id=' . $row_log['admin_id'] . '" title="编辑" data-toggle="tooltip" data-placement="top"><i class="zmdi zmdi-edit"></i></a>
        </td>';
    }
        echo '</tr>' . PHP_EOL;
        $n++;
    }
    echo '
    </tbody>
    </table>' . PHP_EOL;
} else {
    echo "<div class=\"alert alert-warning\" role=\"alert\">数据为空！</div>";
}
$result->free(); 
?>
            </div>
        </div>
    </div>
    <a class="btn btn-success btn--action btn--fixed" href="?do=manager_add"><i class="zmdi zmdi-plus"></i></a>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#data-table").DataTable({
            autoWidth: !1,
            responsive: 0,
            lengthMenu: [
                [15, 30, 45, -1],
                ["15 条", "30 条", "45 条", "所有"]
            ],
            language: {
                searchPlaceholder: "搜索...",
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