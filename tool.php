<?php

/**
* 创建目录
* @param string $dir
*/
static public function createDir( $dir ) {
    if ( !is_dir( $dir ) ) {
        mkdir( $dir, 0777 );
    }
}

/**
* 读取文件内容
* @param $file 文件路径
* @param $site 内容
*/

function FileGet( $file ) {
    return file_exists( $file ) ? file_get_contents( $file ) : '0';
}

/**
* 文件写入内容
* @param $file 文件路径
* @param $site 内容
*/

function FileSet( $file, $site ) {
    // 使用 FILE_APPEND 标记，可以在文件末尾追加内容
    //  LOCK_EX 标记可以防止多人同时写入
    // file_put_contents( $file, $site, FILE_APPEND | LOCK_EX );
    file_put_contents( $file, $site, LOCK_EX );
}

/**
* 删除文件
* @param string $filename
*/
static public function delFile( $filename ) {
    if ( file_exists( $filename ) ) unlink( $filename );
}

/**
* 删除目录
* @param string $path
*/
static public function delDir( $path ) {
    if ( is_dir( $path ) ) rmdir( $path );
}

/**
* 删除目录及地下的全部文件
* @param string $dir
* @return bool
*/
static public function delDirOfAll( $dir ) {
    //先删除目录下的文件：
    if ( is_dir( $dir ) ) {
        $dh = opendir( $dir );
        while ( !!$file = readdir( $dh ) ) {
            if ( $file != '.' && $file != '..' ) {
                $fullpath = $dir.'/'.$file;
                if ( !is_dir( $fullpath ) ) {
                    unlink( $fullpath );
                } else {
                    self::delDirOfAll( $fullpath );
                }
            }
        }
        closedir( $dh );
        //删除当前文件夹：
        if ( rmdir( $dir ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
* 字符串加密处理
* @param $password //需要加密的字符
* @param $encrypt //传入加密串
* @return array/password
*/

function password( $password, $encrypt = '666666asdd' ) {
    $pwd = array();
    $pwd['encrypt'] =  $encrypt ? $encrypt : randomstr();
    $pwd['password'] = str_replace( '1', '8', str_replace( 'b', 'd', md5( md5( trim( $password ) ).$pwd['encrypt'] ) ) );
    return $encrypt ? $pwd['password'] : $pwd;
}

/**
* 生成随机字符串
* @param string $lenth 长度
* @return string 字符串
*/

function randomstr( $lenth ) {
    return random( $lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ' );
}

/**
* 格式化单位
*/
static public function byteFormat( $size, $dec = 2 ) {
    $a = array ( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    $pos = 0;
    while ( $size >= 1024 ) {
        $size /= 1024;
        $pos ++;
    }
    return round( $size, $dec ) . ' ' . $a[$pos];
}

/**
* 弹窗
* @param string $_info
* @return js
*/
static public function alert( $_info ) {
    echo "<script type='text/javascript'>alert('$_info');</script>";
    exit();
}
?>