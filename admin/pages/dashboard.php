<?php
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();
//检测来路
CheckEntrance();
//检测权限
CheckUserLevel('admin');
/**
 * [$sql 一行命令取多个值]
 * @var male_counts 男性会员
 * @var female_counts 女性会员
 * @var pay_counts 已缴费
 * @var no_pay_counts 未缴费
 */
$sql = "SELECT
SUM(CASE WHEN mem_gender='1' THEN 1 ELSE 0 END) AS male_counts,
SUM(CASE WHEN mem_gender='0' THEN 1 ELSE 0 END) AS female_counts,
SUM(CASE WHEN mem_pay_check='1' THEN 1 ELSE 0 END) AS pay_counts,
SUM(CASE WHEN mem_pay_check='0' OR mem_pay_check IS NULL THEN 1 ELSE 0 END) AS no_pay_counts
FROM member";
$result = $con->query($sql);
$row    = $result->fetch_array();
if (empty($row['male_counts'])) {
    $male_counts = '0';
} else {
    $male_counts = $row['male_counts'];
}
if (empty($row['female_counts'])) {
    $female_counts = '0';
} else {
    $female_counts = $row['female_counts'];
}
if (empty($row['pay_counts'])) {
    $paid_counts = '0';
} else {
    $paid_counts = $row['pay_counts'];
}
if (empty($row['no_pay_counts'])) {
    $no_pay_counts = '0';
} else {
    $no_pay_counts = $row['no_pay_counts'];
}

$mem_counts = (int) $male_counts + (int) $female_counts;
$result->free();
/**
 * 管理员数量
 */
$admin_sql      = "SELECT * FROM manager";
$admin_result   = $con->query($admin_sql);
$manager_counts = $admin_result->num_rows;
/**
 * 授课
 */
$teach_sql = "SELECT
SUM(CASE WHEN DATE_FORMAT(edu_time,'%Y%m')=DATE_FORMAT(CURDATE(),'%Y%m') THEN 1 ELSE 0 END) AS now_month,
COUNT(edu_time) AS teach_all,
SUM(CASE WHEN edu_status = '正常' THEN 1 ELSE 0 END) AS normal_times,
SUM(CASE WHEN edu_status = '延期' THEN 1 ELSE 0 END) AS delay_times,
SUM(CASE WHEN edu_status = '取消' THEN 1 ELSE 0 END) AS cancel_times,
SUM(CASE WHEN edu_status = '结束' THEN 1 ELSE 0 END) AS finish_times
FROM teaching";
$result = $con->query($teach_sql);
$row    = $result->fetch_array();
if (empty($row['now_month'])) {
    $now_month = '0';
} else {
    $now_month = $row['now_month'];
}
if (empty($row['teach_all'])) {
    $teach_all = '0';
} else {
    $teach_all = $row['now_month'];
}
if (empty($row['normal_times'])) {
    $normal_times = '0';
} else {
    $normal_times = $row['now_month'];
}
if (empty($row['delay_times'])) {
    $delay_times = '0';
} else {
    $delay_times = $row['now_month'];
}
if (empty($row['cancel_times'])) {
    $cancel_times = '0';
} else {
    $cancel_times = $row['now_month'];
}
if (empty($row['finish_times'])) {
    $finish_times = '0';
} else {
    $finish_times = $row['now_month'];
}
$result->free();
/**
 * 取学院会员数量
 */
$CollegeMemNumSQL = "SELECT mem_college,COUNT(mem_college) AS memcount FROM member GROUP BY mem_college ORDER BY memcount DESC";
$result           = $con->query($CollegeMemNumSQL);
?>
    <header class="content__title">
        <h1>
        仪表盘
    </h1>
        <small>
        服务器综合信息汇总
    </small>
        <div class="actions">
            <div class="dropdown actions__item">
                <i class="zmdi zmdi-more-vert" data-toggle="dropdown">
            </i>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="">
                    刷新
                </a>
                </div>
            </div>
        </div>
    </header>
    <div class="row quick-stats">
        <div class="col-sm-6 col-md-2">
            <div class="quick-stats__item bg-light-blue">
                <li class="zmdi zmdi-account zmdi-hc-2x text-white">
                </li>
                <div class="quick-stats__info">
                    <h2 class="ml-2" id="mem-count">
                    0
                </h2>
                    <small>
                    会员人数
                </small>
                </div>
                <div class="quick-stats__chart sparkline-bar-stats">
                    6,4,8,6,5,6,7,8,3,5,9,5
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="quick-stats__item bg-amber">
                <li class="zmdi zmdi-accounts-alt zmdi-hc-2x text-white">
                </li>
                <div class="quick-stats__info">
                    <h2 class="ml-2" id="manager-count">
                    0
                </h2>
                    <small>
                    系统管理成员数
                </small>
                </div>
                <div class="quick-stats__chart sparkline-bar-stats">
                    4,7,6,2,5,3,8,6,6,4,8,6
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="quick-stats__item bg-light-green">
                <li class="zmdi zmdi-money zmdi-hc-2x text-white">
                </li>
                <div class="quick-stats__info">
                    <h2 class="ml-2" id="paid-count">
                    0
                </h2>
                    <small>
                    已缴费人数
                </small>
                </div>
                <div class="quick-stats__chart sparkline-bar-stats">
                    9,4,6,5,6,4,5,7,9,3,6,5
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="quick-stats__item bg-red">
                <li class="zmdi zmdi-money-off zmdi-hc-2x text-white">
                </li>
                <div class="quick-stats__info">
                    <h2 class="ml-2" id="no-pay-count">
                    0
                </h2>
                    <small>
                    未缴费人数
                </small>
                </div>
                <div class="quick-stats__chart sparkline-bar-stats">
                    5,6,3,9,7,5,4,6,5,6,4,9
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="quick-stats__item bg-indigo">
                <li class="zmdi zmdi-file-text zmdi-hc-2x text-white">
                </li>
                <div class="quick-stats__info">
                    <h2 class="ml-2" id="month-teach-times">
                    0
                </h2>
                    <small>
                    当月授课次数
                </small>
                </div>
                <div class="quick-stats__chart sparkline-bar-stats">
                    5,6,3,9,7,5,4,6,5,6,4,9
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="quick-stats__item bg-orange">
                <li class="zmdi zmdi-collection-text zmdi-hc-2x text-white">
                </li>
                <div class="quick-stats__info">
                    <h2 class="ml-2" id="all-teach-times">
                    0
                </h2>
                    <small>
                    授课总次数
                </small>
                </div>
                <div class="quick-stats__chart sparkline-bar-stats">
                    5,6,3,9,7,5,4,6,5,6,4,9
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix mb-2"></div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">当前缴费人数占比</h2>
                </div>
                <div class="card-block">
                    <div class="flot-chart flot-pie" id="mem_data"></div>
                    <div class="flot-chart-legends flot-chart-legend--pie" id="mem_data_des"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">会员性别占比</h2>
                </div>
                <div class="card-block">
                    <div class="flot-chart flot-donut" id="gen_data"></div>
                    <div class="flot-chart-legends flot-chart-legend--donut" id="gen_data_des"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">授课状态占比</h2>
                </div>
                <div class="card-block">
                    <div class="flot-chart flot-donut" id="edu_data"></div>
                    <div class="flot-chart-legends flot-chart-legend--donut" id="edu_data_des"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">当月授课次数与总次数占比</h2>
                </div>
                <div class="card-block">
                    <div class="flot-chart flot-donut" id="edu_times"></div>
                    <div class="flot-chart-legends flot-chart-legend--donut" id="edu_times_per"></div>
                </div>
            </div>
        </div>
         <div class="col-md-12 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">会员学院分布情况</h2>
                </div>
                <div class="card-block">
                    <div class="flot-chart flot-donut" id="mem_college" style="height: 450px;"></div>
                    <div class="flot-chart-legends flot-chart-legend--donut" id="mem_college_bar"></div>
                </div>
            </div>
        </div> 
    </div>
    <div class="clearfix mb-2"></div>
    <header class="content__title">
        <h1>
        服务器性能信息
    </h1>
    </header>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="card card-inverse widget-past-days">
                <div class="card-header">
                    <h2 class="card-title">当前服务器磁盘使用情况</h2>
                </div>
                <div class="listview listview--inverse listview--striped" id="disk_info_table">
                    <div class="listview__item">
                        <div class="widget-past-days__info">
                            <small>Loading....</small>
                            <h3>信息加载中</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="card card-inverse widget-pie">
                <div class="col-sm-4 col-md-6 widget-pie__item">
                    <div class="easy-pie-chart" data-percent="" data-size="80" data-track-color="rgba(0,0,0,0.08)" data-bar-color="#fff" id="cpu_usage_percent">
                        <span class="easy-pie-chart__value" id="cpu_usage">NaN</span>
                    </div>
                    <div class="widget-pie__title">CPU
                        <br>利用率</div>
                </div>
                <div class="col-sm-4 col-md-6 widget-pie__item">
                    <div class="easy-pie-chart" data-percent="" data-size="80" data-track-color="rgba(0,0,0,0.08)" data-bar-color="#fff" id="memory_usage_percent">
                        <span class="easy-pie-chart__value" id="memory_usage">NaN</span>
                    </div>
                    <div class="widget-pie__title">内存
                        <br>利用率</div>
                </div>
                <div class="col-sm-4 col-md-6 widget-pie__item">
                    <div class="easy-pie-chart" data-percent="" data-size="80" data-track-color="rgba(0,0,0,0.08)" data-bar-color="#fff">
                        <span class="easy-pie-chart__value">NaN</span>
                    </div>
                    <div class="widget-pie__title">Buffer
                        <br>利用率</div>
                </div>
                <div class="col-sm-4 col-md-6 widget-pie__item">
                    <div class="easy-pie-chart" data-percent="" data-size="80" data-track-color="rgba(0,0,0,0.08)" data-bar-color="#fff">
                        <span class="easy-pie-chart__value">NaN</span>
                    </div>
                    <div class="widget-pie__title">Cache
                        <br>利用率</div>
                </div>
            </div>
        </div>
    </div>
    <?php
$admin_result->free();
?>
    <script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {
            getsysteminfo();
            getdiskinfo();
        }, 3000);
        //获取服务器资源占用情况
        function getsysteminfo() {
            $.ajax({
                'type': 'post',
                'url': './sysinfo/getsysteminfo.php',
                'dataType': 'json',
                'timeout': '3000',
                'data': { "getinfo": "true" },
                success: function(data) {
                    switch (data.code) {
                        case 0:
                            {}
                            break;
                        case 1:
                            {
                                //console.log(data.data);
                                var data1 = data.data;
                                $('div #cpu_usage').text(data1[0]);
                                $('#cpu_usage_percent').data('easyPieChart').update(data1[0]);
                                $('#cpu_usage_percent').data('easyPieChart').enableAnimation();
                                $('div #memory_usage').text(data1[1]);
                                $('#memory_usage_percent').data('easyPieChart').update(data1[1]);
                                $('#memory_usage_percent').data('easyPieChart').enableAnimation();
                                //console.log(data1[0], data1[1]);
                                break;
                            }
                    }
                },
            })
        };
        //获取磁盘占用信息
        function getdiskinfo() {
            $.ajax({
                'async': 'true',
                'type': 'post',
                'url': './sysinfo/getdiskinfo.php',
                'dataType': 'json',
                'timeout': '3000',
                'data': { "getinfo": "true" },
                success: function(data) {
                    switch (data.code) {
                        case 0:
                            {}
                            break;
                        case 1:
                            {
                                var os=data.OS;
                                if (os=='LINUX') {
                                    //console.log(data);
                                    var html = '';
                                    html = html + '<div class="listview__item">';
                                    html = html + '<div class="widget-past-days__info">';
                                    html = html + '<small>' + data.data[0] + ' 总空间/可用空间</small>';
                                    html = html + '<h3>' + data.data[1] + "G/" + data.data[2] + 'G</h3>';
                                    html = html + '</div>';
                                    html = html + '</div>';
                                    //console.log(html);
                                    $('#disk_info_table').html(html);
                                }
                                if (os=='WINNT'){
                                //windows盘符大写函数
                                function upperDisck(jsonObj) {
                                    for (var key in jsonObj) {
                                        jsonObj["\"" + key.toUpperCase() + "\""] = jsonObj[key];
                                        delete(jsonObj[key]);
                                    }
                                    return jsonObj;
                                }
                                var UpperDname = upperDisck(data);
                                var html = '';
                                var pie_html = '';
                                for (var o in data) {
                                    /*
                                    console.log(UpperDname);//大写盘符
                                    console.log(o.replace(/['"]+/g, ''));//去除引号
                                    console.log(data[o]);//获取空间数据
                                    console.log(data[o][0]);//取空间数据中指定数组
                                    */
                                    html = html + '<div class="listview__item">';
                                    html = html + '<div class="widget-past-days__info">';
                                    html = html + '<small>' + o.replace(/['"]+/g, '') + ' 总空间/可用空间</small>';
                                    html = html + '<h3>' + data[o][1] + "/" + data[o][0] + '</h3>';
                                    html = html + '</div>';
                                    html = html + '</div>';
                                    $('#disk_info_table').html(html);
                                }
                            }
                                break;
                            }
                    }
                },
            })
        };
        //延迟加载效果
        setTimeout(countUp_mem_num(), countUp_admin_num(), countUp_paid_num(), countUp_no_pay_num(), countUp_teach_all(), countUp_teach_month(), 8000);
        //获取函数系列
        function countUp_mem_num() {
            var options = {
                useEasing: true,
                  useGrouping: true,
                  separator: ',', //千位分隔符
                  decimal: '.', //小数点
                  suffix: '' //后缀
            };
            var memCount = new CountUp('mem-count', 0, <?php echo $mem_counts; ?>, 0, 5, options);
            if (!memCount.error) {
                memCount.start();
            } else {
                console.error(memCount.error);
            }
        };

        function countUp_admin_num() {
            var options = {
                useEasing: true,
                  useGrouping: true,
                  separator: ',', //千位分隔符
                  decimal: '.', //小数点
                  suffix: '' //后缀
            };
            var memCount = new CountUp('manager-count', 0, <?php echo $manager_counts; ?>, 0, 5, options);
            if (!memCount.error) {
                memCount.start();
            } else {
                console.error(memCount.error);
            }
        };
        //缴费
        function countUp_paid_num() {
            var options = {
                useEasing: true,
                  useGrouping: true,
                  separator: ',', //千位分隔符
                  decimal: '.', //小数点
                  suffix: '' //后缀
            };
            var memCount = new CountUp('paid-count', 0, <?php echo $paid_counts; ?>, 0, 5, options);
            if (!memCount.error) {
                memCount.start();
            } else {
                console.error(memCount.error);
            }
        };

        function countUp_no_pay_num() {
            var options = {
                useEasing: true,
                  useGrouping: true,
                  separator: ',', //千位分隔符
                  decimal: '.', //小数点
                  suffix: '' //后缀
            };
            var memCount = new CountUp('no-pay-count', 0, <?php echo $no_pay_counts; ?>, 0, 5, options);
            if (!memCount.error) {
                memCount.start();
            } else {
                console.error(memCount.error);
            }
        };
        //授课
        function countUp_teach_all() {
            var options = {
                useEasing: true,
                  useGrouping: true,
                  separator: ',', //千位分隔符
                  decimal: '.', //小数点
                  suffix: '' //后缀
            };
            var memCount = new CountUp('all-teach-times', 0, <?php echo $teach_all; ?>, 0, 5, options);
            if (!memCount.error) {
                memCount.start();
            } else {
                console.error(memCount.error);
            }
        };

        function countUp_teach_month() {
            var options = {
                useEasing: true,
                  useGrouping: true,
                  separator: ',', //千位分隔符
                  decimal: '.', //小数点
                  suffix: '' //后缀
            };
            var memCount = new CountUp('month-teach-times', 0, <?php echo $now_month; ?>, 0, 5, options);
            if (!memCount.error) {
                memCount.start();
            } else {
                console.error(memCount.error);
            }
        };

        // 饼盘数据
        // 缴费比例
        var payData = [
            { data: <?php echo $paid_counts; ?>, color: '<?php echo RandColor(); ?>', label: '已缴费' },
            { data: <?php echo $no_pay_counts; ?>, color: '<?php echo RandColor(); ?>', label: '未缴费' }
        ];
        //男女比例
        var genData = [
            { data: <?php echo $male_counts; ?>, color: '<?php echo RandColor(); ?>', label: '男' },
            { data: <?php echo $female_counts; ?>, color: '<?php echo RandColor(); ?>', label: '女' }
        ];
        //授课状态比例
        var eduData = [
            { data: <?php echo $normal_times; ?>, color: '<?php echo RandColor(); ?>', label: '正常' },
            { data: <?php echo $cancel_times; ?>, color: '<?php echo RandColor(); ?>', label: '取消' },
            { data: <?php echo $finish_times; ?>, color: '<?php echo RandColor(); ?>', label: '结束' },
            { data: <?php echo $delay_times; ?>, color: '<?php echo RandColor(); ?>', label: '延期' }
        ];
        //授课次数比例
        var eduTimesData = [
            { data: <?php echo $now_month; ?>, color: '<?php echo RandColor(); ?>', label: '当月次数' },
            { data: <?php echo $teach_all; ?>, color: '<?php echo RandColor(); ?>', label: '总次数' }
        ];
        //二级学院占比
        var CollegeData = [
                <?php
                while ($row = $result->fetch_array()) {
                    echo "
                    {
                    data: '" . $row['memcount'] . "',
                    color: '" . RandColor() . "',
                    label: '" . $row['mem_college'] . "' },
                    ";
                    $num++;
                }
                $result->free();
               ?>
        ];

        // 缴费饼盘
        $.plot('#mem_data', payData, {
            series: {
                pie: {
                    show: true,
                    stroke: {
                        width: 2
                    },
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    }
                }
            },
            legend: {
                container: '#mem_data_des',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });

        // 会员性别饼盘
        $.plot('#gen_data', genData, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    stroke: {
                        width: 2
                    },
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    }
                }
            },
            legend: {
                container: '#gen_data_des',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });
        //画授课状态饼盘
        $.plot('#edu_data', eduData, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    stroke: {
                        width: 2
                    },
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    }
                }
            },
            legend: {
                container: '#edu_data_des',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });
        //画授课次数饼盘
        $.plot('#edu_times', eduTimesData, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    stroke: {
                        width: 2
                    },
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    }
                }
            },
            legend: {
                container: '#edu_times_per',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });
        //会员学院饼盘
        $.plot('#mem_college', CollegeData, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    stroke: {
                        width: 2
                    },
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    }
                }
            },
            legend: {
                container: '#mem_college_bar',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });

        function labelFormatter(label, series) {
            return "<div style='font-size:8px; text-align:center; padding:2px; color:white;'>" + Math.round(series.percent) + "%</div>";
        };

    });
    </script>