<?php
$fp = fopen('System_log.log', 'r+');
flock($fp, LOCK_EX);

//2番目の引数のファイルサイズを0にして空にする
ftruncate($fp,0); 

flock($fp, LOCK_UN);
fclose($fp);
$url = 'http://172.20.49.135/sw-manage/ispg2/status_list.php';
    header('Location:'.$url);
    exit();
?>