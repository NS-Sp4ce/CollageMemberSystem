<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//检测权限
CheckUserLevel('admin');
$sql    = "SELECT * FROM teaching";
$result = $con->query($sql);
?>
<header class="content__title">
    <h1>授课信息列表</h1>
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
        <h2 class="card-title">授课信息列表</h2>
        <small class="card-subtitle">授课信息列表，可快速检索</small>
    </div>
    <div class="card-block">
        <div class="table-responsive">
                    <?php
if ($result->num_rows > 0) {
    echo '
            <table id="data-table" class="table table-bordered">
                <thead class="thead-default">
                    <tr>
                        <th>#</th>
                        <th>授课人</th>
                        <th>授课日期</th>
                        <th>授课内容</th>
                        <th>联系方式</th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>授课人</th>
                        <th>授课日期</th>
                        <th>授课内容</th>
                        <th>联系方式</th>
                        <th>状态</th>
                    </tr>
                </tfoot>
                ';
    $n = 1;
    while ($row_log = $result->fetch_array()) {
        $status = $row_log['edu_status'];
        switch ($status) {
            case '正常':
                $text_color = 'success';
                break;
            case '延期':
                $text_color = 'warning';
                break;
            case '取消':
                $text_color = 'danger';
                break;
            case '结束':
                $text_color = 'primary';
                break;
        }
        echo '<tr>' . PHP_EOL;
        echo '<td>' . $n . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['edu_teacher'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['edu_time'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['edu_content'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['edu_phone'] . '</td>' . PHP_EOL;
        echo '<td><span class="text-' . $text_color . '">' . $status . '</span></td>' . PHP_EOL;
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
<script type="text/javascript">
$(document).ready(function() {
        $("#data-table").DataTable({
            autoWidth: 0,
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