<?php
if (isset($_POST['getinfo']) && $_POST['getinfo'] == 'true') {
    if (strcasecmp(PHP_OS, 'WINNT') == 0) {
        /**
         *  Windows获取资源利用率
         *
         */
        class SystemInfoWindows
        {
            /**
             * 判断指定路径下指定文件是否存在，如不存在则创建
             * @param string $fileName 文件名
             * @param string $content  文件内容
             * @return string 返回文件路径
             */
            private function getFilePath($fileName, $content)
            {
                $path = dirname(__FILE__) . "\\$fileName";
                if (!file_exists($path)) {
                    file_put_contents($path, $content);
                }
                return $path;
            }

            /**
             * 获得cpu使用率vbs文件生成函数
             * @return string 返回vbs文件路径
             */
            function getCupUsageVbsPath()
            {
                return $this->getFilePath(
                    'cpu_usage.vbs',
                    "On Error Resume Next
       Set objProc = GetObject(\"winmgmts:\\\\.\\root\cimv2:win32_processor='cpu0'\")
       WScript.Echo(objProc.LoadPercentage)"
                );
            }

            /**
             * 获得总内存及可用物理内存JSON vbs文件生成函数
             * @return string 返回vbs文件路径
             */
            function getMemoryUsageVbsPath()
            {
                return $this->getFilePath(
                    'memory_usage.vbs',
                    "On Error Resume Next
       Set objWMI = GetObject(\"winmgmts:\\\\.\\root\cimv2\")
       Set colOS = objWMI.InstancesOf(\"Win32_OperatingSystem\")
       For Each objOS in colOS
         Wscript.Echo(\"{\"\"TotalVisibleMemorySize\"\":\" & objOS.TotalVisibleMemorySize & \",\"\"FreePhysicalMemory\"\":\" & objOS.FreePhysicalMemory & \"}\")
       Next"
                );
            }

            /**
             * 获得CPU使用率
             * @return Number
             */
            function getCpuUsage()
            {
                $path = $this->getCupUsageVbsPath();
                exec("cscript -nologo $path", $usage);
                return $usage[0];
            }

            /**
             * 获得内存使用率数组
             * @return array
             */
            function getMemoryUsage()
            {
                $path = $this->getMemoryUsageVbsPath();
                exec("cscript -nologo $path", $usage);
                $memory          = json_decode($usage[0], true);
                $memory['usage'] = Round((($memory['TotalVisibleMemorySize'] - $memory['FreePhysicalMemory']) / $memory['TotalVisibleMemorySize']) * 100);
                return $memory;
            }
            /**
             * 删除2个信息文件
             * @return Ture Or Fail
             */
            function deleteInfoFile()
            {
                $file = array
                    (
                    "cpu_usage.vbs",
                    "memory_usage.vbs",
                );
                foreach ($file as $deletefile) {
                    unlink($deletefile);
                }
            }
        }
        $info        = new SystemInfoWindows();
        $cpu         = $info->getCpuUsage();
        $memory_init = $info->getMemoryUsage();
        $memory      = $memory_init['usage'];
        $data        = array(
            $cpu,
            $memory,
        );
        $jobj = new stdclass();
        foreach ($data as $key => $value) {
            $jobj->$key = $value;
        }
        $data = json_encode($jobj);
        print_r("{\"code\":1," . "\"data\":" . $data . "}");
    } else if (strcasecmp(PHP_OS, 'Linux') == 0) {
        $fp = popen('top -b -n 1 | grep -E "^(%Cpu|KiB Mem|Tasks)"', "r"); //获取某一时刻Linux系统cpu和内存使用情况
        $rs = "";
        while (!feof($fp)) {
            $rs .= fread($fp, 1024);
        }
        pclose($fp);
        $sys_info = explode("\n", $rs);
        $cpu_info  = explode(",", $sys_info[1]); //CPU占有量  数组
        $mem_info  = explode(",", $sys_info[2]); //内存占有量 数组
        //CPU占有量
        $cpu_usage = round(100 * intval(trim(trim($cpu_info[0], 'Cpu(s): '), '%us'))); //百分比
        //内存占有量
        $mem_total = trim(trim($mem_info[0], 'KiB Mem: '), 'total');
        $mem_used  = trim($mem_info[1], 'used');
        $mem_usage = round(100 * intval($mem_used) / intval($mem_total), 2); //百分比
        $data        = array(
            $cpu_usage,
            $mem_usage,
        );
        $jobj = new stdclass();
        foreach ($data as $key => $value) {
            $jobj->$key = $value;
        }
        $data = json_encode($jobj);
        print_r("{\"code\":1," . "\"data\":" . $data . "}");
    } else {
        print_r("{\"code\":0," . "\"data\":{\"0\":\"NaN\",\"1\":\"NaN\"}");
    }
}
