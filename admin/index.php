<!DOCTYPE html>
<?php
$run_time_start = microtime(true);
//包含函数文件
require_once './include/function.php';
//检测登录
CheckLogin();

//包含数据库连接文件
include './include/conn.php';
ob_start();

// 单一入口模式
//error_reporting ( 0 ); // 关闭错误显示
$file    = addslashes($_GET['do']); // 接收文件名
$u_name  = $_SESSION['username'];
$u_email = $_SESSION['useremail'];
if (!empty($_SESSION['useravatar'])) {
    $u_avatar= $_SESSION['useravatar'];
}else{
    $u_avatar='demo/img/profile-pics/8.jpg';
}

if (empty($u_email)) {
    $u_email = '<a href="?do=profile&focus=email">填写邮箱</a>';
}
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
        <?php
                //加载完再做会话验证
                CheckSession();
                SetNewSessionTime();
                ?>
        <!--预加载 End-->
        <header class="header">
            <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
                <div class="navigation-trigger__inner">
                    <i class="navigation-trigger__line"></i>
                    <i class="navigation-trigger__line"></i>
                    <i class="navigation-trigger__line"></i>
                </div>
            </div>
            <!--导航左侧图标 Start-->
            <div class="header__logo hidden-sm-down">
                <h1><a href="index.php" class="association__logo">
                                <?php 
                            if ($show_logo=='1') {
                                echo "<img id=\"site_logo\" class=\"association__logo-del\" src=\"".$site_logo."\">";
                            }
                            echo $sitename; ?>会员信息管理系统</a>
                            </h1>
            </div>
            <!--导航左侧图标 End-->
            <!--导航右侧图标 Start-->
            <ul class="top-nav">
                <li class="dropdown hidden-xs-down">
                    <a href="" data-toggle="dropdown"><i class="zmdi zmdi-apps"></i></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                        <div class="row app-shortcuts">
                            <a class="col-4 app-shortcuts__item" href="?do=main">
                                    <i class="zmdi zmdi-home bg-light-green"></i>
                                    <small class="">主页</small>
                                </a>
                            <a class="col-4 app-shortcuts__item" href="?do=dashboard">
                                    <i class="zmdi zmdi-chart bg-blue"></i>
                                    <small class="">仪表盘</small>
                                </a>
                            <a class="col-4 app-shortcuts__item" href="?do=site_setting">
                                    <i class="zmdi zmdi-settings-square bg-teal"></i>
                                    <small class="">系统设置</small>
                                </a>
                            <a class="col-4 app-shortcuts__item" href="?do=edu_edit">
                                    <i class="zmdi zmdi-book bg-blue-grey"></i>
                                    <small class="">授课管理</small>
                                </a>
                            <a class="col-4 app-shortcuts__item" href="?do=mem_edit">
                                    <i class="zmdi zmdi-account-box bg-orange"></i>
                                    <small class="">会员管理</small>
                                </a>
                            <a class="col-4 app-shortcuts__item" href="?do=logout">
                                    <i class="zmdi zmdi-time-restore bg-red"></i>
                                    <small class="">注销</small>
                                </a>
                        </div>
                    </div>
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
        <aside class="sidebar">
            <!--菜单 Start-->
            <div class="scrollbar-inner">
                <!--用户菜单及信息 Start-->
                <div class="user">
                    <div class="user__info">
                        <img class="user__img" src="<?php echo $u_avatar; ?>" alt="" id="user_avatar">
                        <div>
                            <div class="user__name">
                                <?php echo $u_name; ?>
                            </div>
                            <div class="user__email">
                                <?php echo $u_email; ?>
                            </div>
                        </div>
                    </div>
                    <a class="user__info mt-2" href="" data-toggle="dropdown">设置</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?do=profile">用户设置</a>
                        <a class="dropdown-item" href="?do=siteseting">站点设置</a>
                        <a class="dropdown-item" href="?do=logout">注销</a>
                    </div>
                </div>
                <!--用户菜单及信息 End-->
                <?php
                            require_once './include/menu.php';
                            ?>
            </div>
            <!--菜单 End-->
        </aside>
        <!--聊天 Start-->
        <!--聊天 End-->
        <section class="content">
            <!--主体内容 Start-->
            <?php
                        switch ($file) {
                            case '':
                                $action = 'main';
                                header("Location:?do=$action", "", "302");
                                break;
                            case 'login':
                                header("Location:./login.php", "", "302");
                                break;
                            default:
                                if (!file_exists('./pages/' . $file . '.php')) {
                                    sweetalert('404 NOT FOUND', '页面未找到！', 'error', '0', '', '返回', 'main', 1, 5000);
                                    header("HTTP/1.1 404 NOT FOUND");
                                    exit;}
                                $action = $file;
                                break;
                            }
                            include './pages/' . $action . '.php';?>
            <!--主体内容 End-->
        </section>
    </main>
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