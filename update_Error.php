<!DOCTYPE html>
<html lang="ja">
        <meta http-equiv="content-type" charset="utf-8">
    <head>
        <meta http-equiv="refresh"content="3; url=http://localhost/ispg2/status_list.php">
        <title>SYSTEM ERROR</title>

        <h1>ソフトウェア管理システム</h1><br>
        <style>
                body {
                    background-color: snow;
                }
            </style>
            <link rel="stylesheet" type="text/css" href="error.css">
    </head>
    <body>
        <?php
        require_once './common2.php'; 
        
        $srt = $_SERVER["REQUEST_URI"];
        $insert = "/ispg2/update_Error.php?id=insert";
        $update = "/ispg2/update_Error.php?id=update";
        $delete = "/ispg2/update_Error.php?id=delete";
        $return_finished = "/ispg2/update_Error.php?id=return_finished";
        $rental_finished = "/ispg2/update_Error.php?id=rental_finished";
        ?>

        <div class="message">
            <?php if(strcmp($srt, $insert) == 0){ ?>
                <b>既に登録情報があるため登録ができません。<br>
            <?php }else if(strcmp($srt, $update) == 0){?>
                <b>返却情報がないため変更ができません。<br>                    
            <?php }else if(strcmp($srt, $delete) == 0){?>
                <b>返却情報がないため削除ができません。<br>
            <?php }else if(strcmp($srt, $return_finished) == 0){?>
                <b>貸出し日付より前の返却日付が選択されています。<br>
                <b>始めから入力してください。<br>
            <?php }else if(strcmp($srt, $rental_finished) == 0){?>
                <b>返却日付より後の貸出し日付が選択されています。<br>
                <b>始めから入力してください。<br>
            <?php } else{
                go_to_error();
                }?>
            3秒後に一覧画面に戻ります。</b>    
        </div>
    </body>
</html>