<?php
    /**
     * 清理过期 ipa 目录及文件
     * 
     * 比如在 Linux 上可以用 crontab 每天访问一次本程序即可清理无用的目录及文件
     */

    $uploads_dir  =  __DIR__ . DIRECTORY_SEPARATOR . 'uploads/' ;

    $files  =  scandir ( $uploads_dir );

    foreach($files as $file){
        if ( $file  ==  '.'  ||  $file  ==  '..' || $file == date('Ymd') ) {
            continue;
        }
        if ( delDirAndFile( $uploads_dir . $file, true) ){
            echo $file . " 目录删除成功\n";
        }else{
            echo $file . " 目录删除失败\n";
        }
    }
    
    /**
     * 删除目录及目录下所有文件或删除指定文件
     * @param str $path   待删除目录路径
     * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
     * @return bool 返回删除状态
     */
    function delDirAndFile($path, $delDir = false) {
        $handle = opendir($path);
        if ($handle) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..")
                    is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
            }
            closedir($handle);
            if ($delDir)
                return rmdir($path);
        }else {
            if (file_exists($path)) {
                return unlink($path);
            } else {
                return false;
            }
        }
    }