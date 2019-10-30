<?php
    $file_name = 'rental_list.csv';
    $file_path = dirname(__FILE__).'/'.$file_name;
    $download_file_name = 'rental_list.csv';

    header('Content-Type: application/force-download;');
    header('Content-Length: '.filesize($file_path));
    header('Content-Disposition: attachment; filename="'.$file_name.'"');
    readfile($download_file_name);
?>