<?php 
//检测登录
$run_time_end = microtime(true);
$run_time = $run_time_end - $run_time_start;
CheckLogin(); 
?>
                <p>© <?php echo $sitename; ?>会员信息管理系统. 保留所有权利.</p>
                <ul class="nav footer__nav">
                    <a class="nav-link" href="?do=main"><i class="zmdi zmdi-home"></i> 主页</a>
                    <a class="nav-link" href="https://github.com/NS-Sp4ce" target="_blank"><i class="zmdi zmdi-github"></i>Github</a>
                    <a class="nav-link" href="?do=about">支持</a>
                    <a class="nav-link" href="javascript:contact()">联系我</a>
                    <a class="nav-link" href="">程序执行时间:<?php echo $run_time."s";?></a>
                </ul>
                <script type="text/javascript">
                	function contact(){
                		swal({
                			title: '您可以通过以下方式联系我',
                			text: 'Email:l0nelysp4ce#vip.qq.com（#换@）',
                			type: 'info',
                			buttonsStyling: false,
                			allowOutsideClick: false,
                			allowEscapeKey:false,
                			confirmButtonClass: 'btn btn-primary'
                		})
                	}
                </script>