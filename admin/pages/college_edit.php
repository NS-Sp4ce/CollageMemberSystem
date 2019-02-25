<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//检测权限
CheckUserLevel('admin');
$sql    = "SELECT * FROM college";
$result = $con->query($sql);
?>
<header class="content__title">
    <h1>二级学院信息编辑</h1>
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
        <h2 class="card-title">二级学院信息编辑</h2>
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
                                            <th>学院名称</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>学院名称</th>
                                        <th>操作</th>
                                    </tr>
                                </tfoot>
                            ';
                        $n = 1;
                        while ($row_log = $result->fetch_array()) {
                               echo '<tr>' . PHP_EOL;
                               echo '<td>' . $n . '</td>' . PHP_EOL;
                               echo '<td>' . $row_log['college_name'] . '</td>' . PHP_EOL;
                               echo '<td>
                               <a class="btn btn-outline-danger waves-effect" href="?do=action&act=delete&t=college&id=' . $row_log['college_id'] . '" title="删除" data-toggle="tooltip" data-placement="top"><i class="zmdi zmdi-delete"></i></a>
                               <a class="btn btn-outline-warning waves-effect" href="?do=action&act=edit&t=college&id=' . $row_log['college_id'] . '" title="编辑" data-toggle="tooltip" data-placement="top"><i class="zmdi zmdi-edit"></i></a>
                               </td>';
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
<a class="btn btn-success btn--action btn--fixed" href="?do=college_add"><i class="zmdi zmdi-plus"></i></a>
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