<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
if (!$_GET['year']) {
    $y_sql  = "SELECT mem_join_time FROM member ORDER BY mem_join_time DESC LIMIT 1 ";
    $result = $con->query($y_sql);
    $row    = $result->fetch_array();
    if ($result->num_rows>0) {
        $year   = $row['mem_join_time'];
    }else{
        $year=date('Y');
    }
    $result->free();
    header("Location:?do=mem_list&year=$year", "", "302");
}
$year   = intval(trim($_GET['year']));
$sql    = "SELECT * FROM member WHERE mem_join_time = '$year'";
$result = $con->query($sql);
?>
<header class="content__title">
    <h1>会员列表</h1>
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
        <h2 class="card-title">会员信息列表</h2>
        <small class="card-subtitle">会员信息列表，可快速检索</small>
        <div class="col-sm-6 col-md-4">
            <small class="h6">按年份显示：
                <select class="select2" data-placeholder="选择一项" name="mem_college" onchange="window.location=this.value">
                            <?php
$year_sql    = "SELECT DISTINCT mem_join_time FROM member ORDER BY mem_join_time DESC";
$year_result = $con->query($year_sql);
if ($year_result->num_rows > 0) {
    while ($year_row = $year_result->fetch_array()) {
        echo "<option value=\"?do=mem_list&year=" . $year_row['mem_join_time'] . "\" ";
        if ($year == $year_row['mem_join_time']) {
            print ' selected="selected"';
        }
        echo ">" . $year_row['mem_join_time'] . "</option>" . PHP_EOL;
    }
}
?>
                </select>
            </small>
        </div>
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
                        <th>姓名</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>联系方式</th>
                        <th>QQ号</th>
                        <th>班级</th>
                        <th>学院</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>联系方式</th>
                        <th>QQ号</th>
                        <th>班级</th>
                        <th>学院</th>
                    </tr>
                </tfoot>
                ';
    $num = 1;
    while ($row_log = $result->fetch_array()) {
        if ($row_log['mem_gender'] == 1) {
            $sex = '男';
        } elseif ($row_log['mem_gender'] == 0) {
            $sex = '女';
        } else {
            $sex = '未知';
        }
        echo '<tr>' . PHP_EOL;
        echo '<td>' . $num . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['mem_name'] . '</td>' . PHP_EOL;
        echo '<td>' . $sex . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['mem_stunum'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['mem_phone'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['mem_qq'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['mem_class'] . '</td>' . PHP_EOL;
        echo '<td>' . $row_log['mem_college'] . '</td>' . PHP_EOL;
        echo '</tr>' . PHP_EOL;
        $num++;
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