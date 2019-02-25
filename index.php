<!DOCTYPE html>
<?php
$run_time_start = microtime(true);
//包含函数文件
require_once './include/function.php';
//包含数据库连接文件
include './include/conn.php';
$sitesql    = "SELECT * FROM site_config";
$siteresult = $con->query($sitesql);
if (!empty($siteresult)) {
    $siterow = $siteresult->fetch_array();
    if (!empty($siterow['site_name'])) {
        $sitename = $siterow['site_name'] . "◎";
    } else {
        $sitename = $siterow['site_name'];
    }
    if (!empty($siterow['site_logo'])) {
        $site_logo = $siterow['site_logo'];
        $show_logo='1';
    } else {
        $show_logo='0';
    }
    $siteresult->close();
}
ob_start();
?>
<html lang="en">
<?php
    //资源文件
    require_once './recourse/header.php';
    ?>

<body data-ma-theme="blue">
    <main class="main">
        <!--预加载 Start-->
        <div class="page-loader">
            <div class="page-loader__spinner">
                <svg viewBox="25 25 50 50">
                    <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                </svg>
            </div>
            <p>载入中....</p>
        </div>
        <!--预加载 End-->
        <header class="header">
            <!--导航左侧图标 Start-->
            <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
                <div class="navigation-trigger__inner">
                    <i class="navigation-trigger__line"></i>
                    <i class="navigation-trigger__line"></i>
                    <i class="navigation-trigger__line"></i>
                </div>
            </div>
            <!--导航左侧图标 End-->
            <!--导航左侧logo 名称 Start-->
            <div class="header__logo hidden-sm-down">
                <h1><a href="index.php" class="association__logo">
                                <?php 
                            if ($show_logo=='1') {
                                echo "<img id=\"site_logo\" class=\"association__logo-del\" src=\"".$site_logo."\">";
                            }
                            echo $sitename; ?>会员信息管理系统</a>
                            </h1>
            </div>
            <!--导航左侧logo 名称 End-->
            <!--导航右侧图标 Start-->
            <ul class="top-nav">
                <li class="hidden-xs-down">
                    <a href="/admin/"><i class="zmdi zmdi-account zmdi-hc-fw"></i>管理登录</a>
                </li>
                <li class="hidden-xs-down ml-3">
                    <a href="/member/"><i class="zmdi zmdi-account zmdi-hc-fw"></i>会员登录</a>
                </li>
                <li class="dropdown hidden-xs-down">
                    <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-item theme-switch">
                            选择主题
                            <div class="btn-group btn-group--colors mt-2" data-toggle="buttons">
                                <label class="btn bg-green active">
                                    <input type="radio" value="green" autocomplete="off">
                                </label>
                                <label class="btn bg-blue">
                                    <input type="radio" value="blue" autocomplete="off">
                                </label>
                                <label class="btn bg-red">
                                    <input type="radio" value="red" autocomplete="off">
                                </label>
                                <label class="btn bg-orange">
                                    <input type="radio" value="orange" autocomplete="off">
                                </label>
                                <label class="btn bg-teal">
                                    <input type="radio" value="teal" autocomplete="off">
                                </label>
                                <br>
                                <label class="btn bg-cyan">
                                    <input type="radio" value="cyan" autocomplete="off">
                                </label>
                                <label class="btn bg-blue-grey">
                                    <input type="radio" value="blue-grey" autocomplete="off">
                                </label>
                                <label class="btn bg-purple">
                                    <input type="radio" value="purple" autocomplete="off">
                                </label>
                                <label class="btn bg-indigo">
                                    <input type="radio" value="indigo" autocomplete="off">
                                </label>
                                <label class="btn bg-lime">
                                    <input type="radio" value="lime" autocomplete="off">
                                </label>
                            </div>
                        </div>
                        <a href="" class="dropdown-item" data-ma-action="fullscreen"> 全屏</a>
                        <a href="" class="dropdown-item" data-ma-action="clear-localstorage">清理本地缓存</a>
                    </div>
                </li>
            </ul>
            <!--导航右侧图标 End-->
        </header>
        <aside class="sidebar sidebar--hidden">
            <div class="scrollbar-inner">
                <ul class="navigation">
                    <li>
                        <a href="/admin/"><i class="zmdi zmdi-account zmdi-hc-fw"></i>管理登录</a>
                    </li>
                    <li>
                        <a href="/member/"><i class="zmdi zmdi-account zmdi-hc-fw"></i>会员登录</a>
                    </li>
                </ul>
            </div>
        </aside>
        
        <section class="content--full">
            <!--主体内容 Start-->
            <!--照片轮播 Start-->
            <div class="card-block col-12">
                <div id="carouselExampleCaption" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaption" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaption" data-slide-to="1"></li>
                        <li data-target="#carouselExampleCaption" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="demo/img/carousel/c-1.jpg" alt="First slide">
                            <div class="carousel-caption">
                                <h3>First slide label</h3>
                                <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="demo/img/carousel/c-2.jpg" alt="Second slide">
                            <div class="carousel-caption">
                                <h3>Second slide label</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="demo/img/carousel/c-3.jpg" alt="Third slide">
                            <div class="carousel-caption">
                                <h3>Third slide label</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaption" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaption" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            <div class="clearfix mb-5"></div>
            <!--照片轮播 End-->
            <!--社团介绍 Start-->
            <div class="text-center">
                <h1 class="color-grey">社团介绍</h1>
            </div>
            <hr>
            <div class="card">
                <div class="card-block">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header">
                                <a class="card-title" data-toggle="collapse" data-parent="#accordionExample" href="#collapseOne">Collapsible Group Item #1</a>
                            </div>
                            <div id="collapseOne" class="collapse show">
                                <div class="card-block">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo">
                                <a class="collapsed card-title" data-toggle="collapse" data-parent="#accordionExample" href="#collapseTwo">Collapsible Group Item #2</a>
                            </div>
                            <div id="collapseTwo" class="collapse">
                                <div class="card-block">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <a class="collapsed card-title" data-toggle="collapse" data-parent="#accordionExample" href="#collapseThree">Collapsible Group Item #3</a>
                            </div>
                            <div id="collapseThree" class="collapse">
                                <div class="card-block">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--社团介绍 End-->
            <!--团队介绍 Start-->
            <div class="text-center">
                <h1 class="color-grey">我们的团队</h1>
                <small class="color-grey">点击下列部门可查看详情</small>
            </div>
            <hr>
            <div class="card">
                <div class="row col-12 mt-5 ml-1">
                    <div class="col-md-4">
                        <div class="card card-outline-warning card_enlarge" data-toggle="modal" data-target="#modal-1">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 1</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-warning card_enlarge" data-toggle="modal" data-target="#modal-2">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 2</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-warning card_enlarge" data-toggle="modal" data-target="#modal-3">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 3</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-warning card_enlarge" data-toggle="modal" data-target="#modal-4">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 4</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-warning card_enlarge" data-toggle="modal" data-target="#modal-5">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 5</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-warning card_enlarge" data-toggle="modal" data-target="#modal-6">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Growth Rate 6</h2>
                                <small class="card-subtitle">Commodo luctus nisi erat porttitor ligula eget lacinia odio semnec elit</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--团队介绍End-->
            <!--服务 Start-->
            <div class="text-center">
                <h1 class="color-grey">我们提供的服务</h1>
                <small class="color-grey">点击下列可查看详情</small>
            </div>
            <hr>
            <div class="card row">
                <div class="row col-12 mt-5 ml-1">
                    <div class="col-md-4">
                        <div class="card card-outline-primary card_enlarge" data-toggle="modal" data-target="#modal-support-1">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 1</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-primary card_enlarge" data-toggle="modal" data-target="#modal-support-2">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 2</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-outline-primary card_enlarge" data-toggle="modal" data-target="#modal-support-3">
                            <img class="card-img-top" src="demo/img/headers/6.png">
                            <div class="card-header">
                                <h2 class="card-title">Sales Statistics 3</h2>
                                <small class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</small>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--服务 End-->
            <!--主体内容 End-->
        </section>
    </main>
    <!--Introduction Modals Start-->
    <div class="modal fade" id="modal-1" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 1</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-2" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 2</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-3" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 3</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-4" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 4</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-5" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 5</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-6" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 6</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Introduction Modals End-->
    <!--Support Modals Start-->
    <div class="modal fade" id="modal-support-1" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 1</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-support-2" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 2</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-support-3" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">Large modal 3</h5>
                </div>
                <div class="modal-body">
                    Curabitur blandit mollis lacus. Nulla sit amet est. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Cras sagittis.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link">Save changes</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Support Modals End-->
    <footer class="footer hidden-xs-down">
        <!--底部信息 Start-->
        <?php
        require_once './include/footer.php';
        ?>
        <!--底部信息 End-->
    </footer>
    <!-- 老IE警告 -->
    <?php
        require_once './include/old_ie_warning.php';
    ?>
</body>

</html>
<?php
    ob_end_flush();
    $con->close();
    ?>