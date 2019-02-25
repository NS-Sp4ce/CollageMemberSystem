<?php
if (isset($_POST['getinfo']) && $_POST['getinfo'] == 'true') {
    if (strcasecmp(PHP_OS, 'WINNT') == 0) {
        /**
         * 字节格式化 把字节数格式为 B K M G T P E Z Y 描述的大小
         * @param int $size 大小
         * @param int $dec 显示类型
         * @return int
         */
        function byte_format($size, $dec = 2)
        {
            $a   = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
            $pos = 0;
            while ($size >= 1024) {
                $size /= 1024;
                $pos++;
            }
            return round($size, $dec) . " " . $a[$pos];
        }
        /**
         * 取得单个磁盘信息
         * @param $letter
         * @return array
         */
        function get_disk_space($letter)
        {
            //获取磁盘信息
            $diskct = 0;
            $disk   = array();
            /*if(@disk_total_space($key)!=NULL) *为防止影响服务器，不检查软驱
            {
            $diskct=1;
            $disk["A"]=round((@disk_free_space($key)/(1024*1024*1024)),2)."G / ".round((@disk_total_space($key)/(1024*1024*1024)),2).'G';
            }*/
            $diskz = 0; //磁盘总容量
            $diskk = 0; //磁盘剩余容量

            $is_disk = $letter . ':';
            if (@disk_total_space($is_disk) != null) {
                $diskct++;
                $disk[$letter][0] = byte_format(@disk_free_space($is_disk));
                $disk[$letter][1] = byte_format(@disk_total_space($is_disk));
                $disk[$letter][2] = round(((@disk_free_space($is_disk) / (1024 * 1024 * 1024)) / (@disk_total_space($is_disk) / (1024 * 1024 * 1024))) * 100, 2) . '%';
                $diskk += byte_format(@disk_free_space($is_disk));
                $diskz += byte_format(@disk_total_space($is_disk));
            }
            return $disk;
        }
        /**
         * 取得磁盘使用情况
         * @return var
         */
        function get_spec_disk($type = 'system')
        {
            $disk = array();
            switch ($type) {
                case 'system':
                    //strrev(array_pop(explode(':',strrev(getenv_info('SystemRoot')))));//取得系统盘符
                    $disk = get_disk_space(strrev(array_pop(explode(':', strrev(getenv('SystemRoot'))))));
                    break;
                case 'all':
                    foreach (range('b', 'z') as $letter) {
                        $disk = array_merge($disk, get_disk_space($letter));
                    }
                    break;
                default:
                    $disk = get_disk_space($type);
                    break;
            }

            return $disk;
        }
        /**
         * 转为JSON
         */
        $data = array(get_spec_disk("all"));
        $jobj = new stdclass();
        foreach ($data as $key => $value) {
            $jobj->$key = $value;
        }
        $data = json_encode($jobj);
        print_r("{\"code\":1,\"OS\":\"WINNT\"," . "\"data\":" . $data . "}");
    } else if (strcasecmp(PHP_OS, 'Linux') == 0) {
        $fp = popen('df -lh | grep -E "^(/)"', "r");
        $rs = fread($fp, 1024);
        pclose($fp);
        $rs       = preg_replace("/\s{2,}/", ' ', $rs); //把多个空格换成 “_”
        $hd       = explode(" ", $rs);
        $hd_total = trim($hd[0]); //磁盘可用空间大小 单位G
        $hd_usage = trim($hd[1], 'G'); //总数 百分比
        $hd_avail  = trim($hd[3], 'G'); //已用 百分比
        /**
         * 转为JSON
         */
        $data = array(
            $hd_total,
            $hd_usage,
            $hd_avail
        );
        $jobj = new stdclass();
        foreach ($data as $key => $value) {
            $jobj->$key = $value;
        }
        $data = json_encode($jobj);
        print_r("{\"code\":1,\"OS\":\"LINUX\"," . "\"data\":" . $data . "}");
    } else {
        print_r("{\"code\":1," . "\"data\":{\"0\":\"NaN\",\"1\":\"NaN\"}");
    }
}
