<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="content-type" charset="utf-8">
        <link rel="stylesheet" href="./button_only.css">
        
        <title>返却削除画面</title>
        <h1>ソフトウェア管理システム</h1>
        <br><br>
        <script>history.forward();</script>
            
        <style>
            body {
                background-color: snow;
            }
        </style>
        <link rel="stylesheet" href="./button_only.css">
    </head>
    <body>
        <?php        
         require_once './common2.php';   
         init_setting();
         $selectId = $_POST['selectId'];
         error_check($selectId);
         $row = select_database($selectId);
                $rental_date = $row[RENTAL_DATE];
                $rental_year = $rental_date[0].$rental_date[1].$rental_date[2].$rental_date[3];
                $rental_month = $rental_date[5].$rental_date[6];
                $rental_day = $rental_date[8].$rental_date[9];

                $return_date = $row[RETURN_DATE];
                $return_year = $return_date[0].$return_date[1].$return_date[2].$return_date[3];
                $return_month = $return_date[5].$return_date[6];
                $return_day = $return_date[8].$return_date[9];
        ?>
        <?php
            if(!isset($row['RETURN_CHECK_NAME']) or !isset($row['RETURN_DATE'])){//nullを見る。
                $url = 'http://localhost/ispg2/update_Error.php';
                header("Location:$url?id=delete");
            }
            ?>

        <div style="position:absolute;top:400px;left:5pt">
        <button type="button" class = "button" onclick="location.href='./status_list.php'">戻る
        </button>
        </div>

        <div style="position:absolute;top:400px;left:400pt">  
            <form method="POST" action="delete_return_finished.php">
            <input type = "hidden" name = "selectId" value="<?php echo $selectId ?>">
            <input type="submit" class = "button" button onclick = "return confirm('本当に削除してもよろしいですか？')" value="削除">
            </form>
        </div>

       <div style="position:absolute;top:120px;left:70px;">
            <table style="text-align: center">
                <tr>
                <th>ソフトウェア名称</th>
                <td><?php echo  htmlspecialchars($row[SOFT_NAME]); ?></td>
                </tr>
                <tr>
                <th>ソフトウェアバージョン</th>
                <td><?php echo htmlspecialchars($row[VERSION_NAME]); ?></td>
                </tr>
                <tr>
                <th> 持出し者</th>
                <td><?php echo "  "; ?></td>
                </tr>
                <tr>
                <th>所属</th>
                <td><?php echo htmlspecialchars($row[TAKE_OUT_DEPARTMENT]); ?></td>
                </tr>
                <tr>
                <th>氏名</th>
                <td><?php echo htmlspecialchars($row[TAKE_OUT_USER_NAME]); ?></td>
                </tr>
                <tr>
                <th>承認者名</th>
                <td><?php echo htmlspecialchars($row[ACKNOWLEDGER]); ?></td>
                </tr>
                <tr>
                <th>貸出し日付</th>
                <td>
                <?php echo $rental_year;?>年<?php echo $rental_month;?>月<?php echo $rental_day;?>日<br>
                </td>
                </tr>
                <tr>
                <th>返却日付</th>
                <td>
                <?php if( $row[RETURN_DATE] != null ){ ?>
                <?php echo $return_year?>年<?php echo $return_month;?>月<?php echo $return_day;?>日
                <?php }else{ echo ' '; } ?>
                </td>
                </tr>
                <tr>
                <th>返却確認者</th>
                <td><?php echo htmlspecialchars($row[RETURN_CHECK_NAME]); ?></td>
                </tr>        
            </table>
        </div>       
    </body>