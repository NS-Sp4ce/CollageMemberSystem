<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
$admin_name=$_SESSION['username'];
if ($_SESSION['user_level']==1) {
    $sql    = "SELECT * FROM sign_in_log ORDER BY sign_in_id DESC";
    $result = $con->query($sql);
}else{
    $sql    = "SELECT * FROM sign_in_log WHERE sign_in_name= '$admin_name' ORDER BY sign_in_id DESC";
    $result = $con->query($sql);
}

?>
<header class="content__title">
    <h1>登录日志</h1>
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
        <h2 class="card-title">登录日志</h2>
        <small class="card-subtitle">显示历史登录日志</small>
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
                        <th>登录帐号</th>
                        <th>登录IP</th>
                        <th>浏览器UA</th>
                        <th>登录时间</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>登录帐号</th>
                        <th>登录IP</th>
                        <th>浏览器UA</th>
                        <th>登录时间</th>
                    </tr>
                </tfoot>
                ';
    $n = 1;
    while ($row_log = $result->fetch_array()) {
        echo '<tr>' . PHP_EOL;
        echo '<td>' . $n . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['sign_in_name'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['sign_in_ip'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['sign_in_ua'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['sign_in_time'] . '</td>' . PHP_EOL;
        echo '</tr>' . PHP_EOL;
        $n++;
    }
    echo '
    </tbody>
    </table>' . PHP_EOL;
} else {
    echo "<div class=\"alert alert-warning\" role=\"alert\">数据为空！</div>";
}
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