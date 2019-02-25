<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//检查权限
CheckUserLevel('suadmin');
$dir = "./db_backup/"; //这是一个目录地址  也是根目录
?>
<header class="content__title">
    <h1>数据库备份页</h1>
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
        <h2 class="card-title">数据库备份页</h2>
        <div class="clearfix mb-5"></div>
        <a class="btn btn-outline-info waves-effect" href="?do=action&act=backupdb">备份数据库</a>
    </div>
    <div class="card-block">
        <div class="table-responsive text-center">
            <?php
                
                if (is_dir($dir)) {
                    //判断$dir是否是一个目录
                    echo '
                                            <table id="data-table" class="table table-bordered">
                                                <thead class="thead-default">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>文件名称</th>
                                                        <th>文件大小</th>
                                                        <th>文件类型</th>
                                                        <th>修改时间</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>文件名称</th>
                                                        <th>文件大小</th>
                                                        <th>文件类型</th>
                                                        <th>修改时间</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </tfoot>
                                                ';
                    $it  = new FilesystemIterator($dir);
                    $num = '1';
                    foreach ($it as $file) {
                        echo '<tr>' . PHP_EOL;
                        echo '<td>' . $num . '</td>' . PHP_EOL;
                        echo '<td>' . $file->getBasename() . '</td>' . PHP_EOL;
                        echo '<td>' . byte_format($file->getSize()) . '</td>' . PHP_EOL;
                        echo '<td>' . $file->getExtension() . '</td>' . PHP_EOL;
                        echo '<td>' . date("Y-m-d H:i:s", $file->getMTime()) . '</td>' . PHP_EOL;
                        echo '<td>
                        <a class="btn btn-outline-primary waves-effect" href="?do=action&act=downloaddb&filename=' . $file->getBasename() . '" title="下载" data-toggle="tooltip" data-placement="top"><i class="zmdi zmdi-download"></i></a>
                        </td>';
                        echo '</tr>' . PHP_EOL;
                        $num++;
                    }
                    echo '</tbody>
                        </table>' . PHP_EOL;
                } else {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">无数据库备份</div>";
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