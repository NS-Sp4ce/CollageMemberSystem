<?php 
//检测登录
CheckLogin(); 
$user_level=$_SESSION['user_level'];
?>
                <ul class="navigation">
                    <li><a href="?do=main"><i class="zmdi zmdi-home"></i> 主页  </a></li>
                    <?php 
                    if ($user_level==1 || $user_level==2) {
                    echo '<li><a href="?do=dashboard"><i class="zmdi zmdi-chart"></i> 仪表盘</a></li>
                    ';}
                    ?>
                    <li class="navigation__sub">
                        <a href=""><i class="zmdi zmdi-account-box"></i> 会员管理</a>
                        <ul>
                            <li><a href="?do=mem_list"><i class="zmdi zmdi-accounts-list"></i> 会员列表</a></li>
                            <li><a href="?do=mem_edit"><i class="zmdi zmdi-edit"></i> 编辑会员</a></li>
                        </ul>
                    </li>
                    <?php 
                    if ($user_level==1 || $user_level==2) {
                    echo '
                    <li class="navigation__sub">
                        <a href=""><i class="zmdi zmdi-money-box"></i> 缴费管理</a>
                        <ul>
                            <li><a href="?do=pay_list"><i class="zmdi zmdi-view-list-alt"></i> 缴费列表</a></li>
                            <li><a href="?do=pay_edit"><i class="zmdi zmdi-edit"></i> 编辑缴费</a></li>
                        </ul>
                    </li>
                    <li class="navigation__sub">
                        <a href=""><i class="zmdi zmdi-book"></i> 授课管理</a>
                        <ul>
                            <li><a href="?do=edu_list"><i class="zmdi zmdi-view-list-alt"></i> 授课列表</a></li>
                            <li><a href="?do=edu_edit"><i class="zmdi zmdi-edit"></i> 编辑授课</a></li>
                        </ul>
                    </li>
                    <li><a href="?do=college_edit"><i class="zmdi zmdi-book-image"></i>学院信息编辑</a></li>
                    ';}
                    ?>
                    <?php 
                    if ($user_level!=1) {
                        echo '<li><a href="?do=login_log"><i class="zmdi zmdi-file-text"></i> 登录日志</a></li>';
                    }else{
                    echo '<li class="navigation__sub">
                        <a href=""><i class="zmdi zmdi-accounts"></i> 管理员配置</a>
                        <ul>
                            <li><a href="?do=manager_list"><i class="zmdi zmdi-accounts-list-alt"></i> 管理员列表</a></li>
                            <li><a href="?do=manager_edit"><i class="zmdi zmdi-edit"></i> 编辑管理员</a></li>
                            <li><a href="?do=login_log"><i class="zmdi zmdi-file-text"></i> 登录日志</a></li>
                        </ul>
                    </li>';
                }
                     ?>
                     <?php 
                    if ($user_level!=1) {
                        echo '<li><a href="?do=profile"><i class="zmdi zmdi-assignment-account"></i> 个人设置</a></li>';
                    }else{
                    echo '<li class="navigation__sub">
                        <a href=""><i class="zmdi zmdi-settings-square"></i> 系统设置</a>
                        <ul>
                            <li><a href="?do=site_setting"><i class="zmdi zmdi-settings"></i> 站点设置</a></li>
                            <li><a href="?do=index_setting"><i class="zmdi zmdi-file"></i> 首页设置</a></li>
                            <li><a href="?do=profile"><i class="zmdi zmdi-assignment-account"></i> 个人设置</a></li>
                            <li><a href="?do=backupdb"><i class="zmdi zmdi-dns"></i> 备份数据库</a></li>
                        </ul>
                    </li>';
                }
                     ?>

                </ul>