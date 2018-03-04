<?php

    $token = $_POST['token'];
    if ($token !== 'XKu$6Yff#WvY23dK'){     // 设置上传密码
        error( '令牌错误' );
    }
    
    // 文件名
    $file_name = $_FILES['file']['name'];

    //限制文件大小  
    $file_size = $_FILES['file']['size'];
    if($file_size > 100*1024*1024) {
        error( '上传文件必须小于 100M' );
    }
    
    // 限制文件类型
    /* 暂时关闭验证
    $file_type = strtolower($_FILES['file']['type']);
    if($file_type != 'application/zip') {
        error( '文件类型错误' . $file_type );
    }*/

    // 判断文件是否是通过 HTTP POST 上传的
    if(!is_uploaded_file($_FILES['file']['tmp_name'])) {
        error( '上传文件异常' );
    }
    
    
    // 上传过来的文件名
    $uploaded_file = $_FILES['file']['tmp_name'];
    
    // 保存文件的子目录
    $uploads_dir =  'uploads' . DIRECTORY_SEPARATOR . date('Ymd') . DIRECTORY_SEPARATOR;
    
    // 保存文件的完整目录路径
    $uploads_path = __DIR__ . DIRECTORY_SEPARATOR . $uploads_dir;
    
    // 保存的文件完整路径
    $save_path = $uploads_path . $file_name;
    
    // 没有这个文件夹就创建 
    if(!is_dir($uploads_path)) {  
        mkdir($uploads_path, 0755, true);
    }
    
    // 移动文件
    if(!move_uploaded_file($uploaded_file, $save_path. '.ipa')){
        error( '文件上传失败' );
    }
    
    // 设置基础目录
    $script_name = basename($_SERVER['SCRIPT_FILENAME']);
    if (basename($_SERVER['SCRIPT_NAME']) === $script_name) {
        $base_file = $_SERVER['SCRIPT_NAME'];
    } elseif (basename($_SERVER['PHP_SELF']) === $script_name) {
        $base_file = $_SERVER['PHP_SELF'];
    } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $script_name) {
        $base_file = $_SERVER['ORIG_SCRIPT_NAME'];
    } elseif (($pos = strpos($_SERVER['PHP_SELF'], '/' . $script_name)) !== false) {
        $base_file = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $script_name;
    } elseif (isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
        $base_file = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
    }
    $base_dir  = substr($base_file, 0, strripos($base_file, '/') + 1);
    
    // 设置 plist 和 ipa 的url
    $plist_url = 'https://' . $_SERVER['HTTP_HOST'] . $base_dir . $uploads_dir . $file_name . '.plist';
    $ipa_url   = 'https://' . $_SERVER['HTTP_HOST'] . $base_dir . $uploads_dir . $file_name . '.ipa';
    
    // 创建 plist 文件
    $plist_tmpl = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
    <dict>
        <key>items</key>
        <array>
            <dict>
                <key>assets</key>
                <array>
                    <dict>
                        <key>kind</key>
                        <string>software-package</string>
                        <key>url</key>
                        <string>'. $ipa_url .'</string>
                    </dict>
                </array>
                <key>metadata</key>
                <dict>
                    <key>bundle-identifier</key>
                    <string>*</string>
                    <key>bundle-version</key>
                    <string>1.0</string>
                    <key>kind</key>
                    <string>software</string>
                    <key>title</key>
                    <string>app</string>
                </dict>
            </dict>
        </array>
    </dict>
</plist>';

     // 写 plist 文件
    $plist_file = fopen($save_path. '.plist', "w");
    fwrite($plist_file, $plist_tmpl);
    fclose($plist_file);
    
    echo json_encode(array(
            'status' => true,
            'plist'    => $plist_url,
        ));
    
    
    function error( $msg ){
        echo json_encode(array(
            'status' => false,
            'msg'    => $msg,
        ));
        exit();
    }