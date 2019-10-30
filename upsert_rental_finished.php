<?php
    require_once './common2.php';
    init_setting();

    if($_SERVER['REQUEST_METHOD']==='POST'){
        session_start();

        $db = connect_database();
        $acknowledger = $_POST['acknowledger'];
        $soft_name = $_POST['soft_name'];
        $version_name = $_POST['version_name'];
        $take_out_user_name = $_POST['take_out_user_name'];
        $take_out_department = $_POST['take_out_department'];

        $rental_date_yyyy = $_POST['rental_date_yyyy'];
        $rental_date_mm = $_POST['rental_date_mm'];
        $rental_date_dd = $_POST['rental_date_dd'];
        $check = $_POST['log_check'];

        $rental_date=check_date($rental_date_yyyy,$rental_date_mm,$rental_date_dd);

        if($rental_date_dd !== $rental_date[8].$rental_date[9]){
            $rental_date_dd = $rental_date[8].$rental_date[9];
        }

        $today = date('Y-m-d H:i:s');

        if(strcmp($_SERVER['HTTP_REFERER'], 'http://localhost/ispg2/insert_rental.php')== 0){
            $sth = $db->prepare("INSERT INTO SOFT_USING_LIST (ID, RENTAL_DATE, ACKNOWLEDGER, SOFT_NAME, VERSION_NAME, 
                                TAKE_OUT_USER_NAME, TAKE_OUT_DEPARTMENT, UPDATE_DATE, STATUS_FLAG) 
                                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, 0)");
            $sth->bindValue(1,$rental_date, PDO::PARAM_STR);
            $sth->bindValue(2,$acknowledger, PDO::PARAM_STR);
            $sth->bindValue(3,$soft_name, PDO::PARAM_STR);
            $sth->bindValue(4,$version_name, PDO::PARAM_STR);
            $sth->bindValue(5,$take_out_user_name, PDO::PARAM_STR);
            $sth->bindValue(6,$take_out_department, PDO::PARAM_STR);
            $sth->bindValue(7,$today, PDO::PARAM_STR);
            $sth->execute();
        }else if(strcmp($_SERVER['HTTP_REFERER'], 'http://localhost/ispg2/update_rental.php') == 0){
            $selected_id = $_POST['selectId'];
            $sth = $db->prepare("SELECT RETURN_DATE FROM SOFT_USING_LIST WHERE ID =?");
            $sth->bindValue(1, $selected_id, PDO::PARAM_INT);
            $sth->execute();
            foreach($sth as $row){
                $return = date('Y/m/d', strtotime($row['RETURN_DATE']));
            }
            if(!empty($row['RETURN_DATE']) && $rental_date > $return){
                $url = 'http://localhost/ispg2/update_Error.php';
                header('Location:'.$url.'?id=rental_finished');
                exit();
            }
            $sth = $db->prepare("UPDATE SOFT_USING_LIST SET SOFT_NAME=?, VERSION_NAME=?, 
                                TAKE_OUT_DEPARTMENT=?, TAKE_OUT_USER_NAME=?, RENTAL_DATE=?, UPDATE_DATE=?, ACKNOWLEDGER=? WHERE ID=?");
            $sth->bindValue(1,$soft_name, PDO::PARAM_STR);
            $sth->bindValue(2,$version_name, PDO::PARAM_STR);
            $sth->bindValue(3,$take_out_department, PDO::PARAM_STR);
            $sth->bindValue(4,$take_out_user_name, PDO::PARAM_STR);
            $sth->bindValue(5,$rental_date, PDO::PARAM_STR);
            $sth->bindValue(6,$today, PDO::PARAM_STR);
            $sth->bindValue(7,$acknowledger, PDO::PARAM_STR);
            $sth->bindValue(8,$selected_id, PDO::PARAM_INT);
            $sth->execute();
            
        }else{
            go_to_error();
        }    
        
        $_SESSION['acknowledger'] = $acknowledger;
        $_SESSION['soft_name'] = $soft_name;
        $_SESSION['version_name'] = $version_name;
        $_SESSION['take_out_user_name'] = $take_out_user_name;
        $_SESSION['take_out_department'] = $take_out_department;
        $_SESSION['rental_date_yyyy'] = $rental_date_yyyy;
        $_SESSION['rental_date_mm'] = $rental_date_mm;
        $_SESSION['rental_date_dd'] = $rental_date_dd;

        $f = fopen("System_log.log","a");
        if($f){
            if( $check == "insert" ){
                $writer = "貸出登録--".$soft_name."--".$take_out_user_name."--".date('Y-m-d H:i:s')."\n";
            }else if($check == "update"){
                $writer = "貸出変更--".$soft_name."--".$take_out_user_name."--".date('Y-m-d H:i:s')."\n";
            }
            mb_convert_variables("SJIS-win", "UTF-8", $writer);
            fputs($f, $writer);
        }
        fclose($f);

        disconnect_database($db);

        header('Location: http://localhost/ispg2/upsert_rental_finished.php');
}
else{

   $acknowledger = $_SESSION['acknowledger'];
   $soft_name = $_SESSION['soft_name'];
   $version_name = $_SESSION['version_name'];
   $take_out_user_name = $_SESSION['take_out_user_name'];
   $take_out_department = $_SESSION['take_out_department'];
   $rental_date_yyyy = $_SESSION['rental_date_yyyy'];
   $rental_date_mm = $_SESSION['rental_date_mm'];
   $rental_date_dd = $_SESSION['rental_date_dd'];


}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>貸出し登録・変更完了画面</title>
        <script> history.forward(); </script>
        <link rel="stylesheet" href="./upsert_rental_finished.css">
        <link rel="stylesheet" href="./button_only.css">
    </head>
    <body>
        <header>
            <h1>ソフトウェア管理システム</h1>
        </header>
        <main>
            <h3>下記の登録・変更が完了しました。</h3>
            <div style="position:absolute;top:120px;left:70px;">
                <table style="text-align: center">
                <tr>
                <th>ソフトウェア名称</th>
                <td><?php echo htmlspecialchars($soft_name) ?></td>
                </tr>
                <tr>
                <th>ソフトウェアバージョン</th>
                <td><?php echo htmlspecialchars($version_name) ?></td>
                </tr>
                <tr>
                <th> 持出し者</th>
                <td><?php echo "  "; ?></td>
                </tr>
                <tr>
                <th>所属</th>
                <td><?php echo htmlspecialchars($take_out_department) ?></td>
                </tr>
                <tr>
                <th>氏名</th>
                <td><?php echo htmlspecialchars($take_out_user_name) ?></td>
                </tr>
                <tr>
                <th>承認者名</th>
                <td><?php echo htmlspecialchars($acknowledger) ?></td>
                </tr>
                <tr>
                <th>貸出し日付</th>
                <td>
                <?php echo $rental_date_yyyy;?>年<?php echo $rental_date_mm;?>月<?php echo $rental_date_dd;?>日<br>
                </td>
                </tr>
                </table>
            </div>
        </main>
        <footer>
        <div style="position:absolute;top:350px;left:5pt">
            <button type="button" class="button" id="back" onclick="location.href='./status_list.php'">戻る</button>
            </div>
        </footer>
    </body>
</html>