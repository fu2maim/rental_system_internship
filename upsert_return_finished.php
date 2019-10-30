<?php
    require_once './common2.php';
    init_setting();

    if($_SERVER['REQUEST_METHOD']==='POST'){                                        //POSTで送られた場合のみ処理を行う
        session_start();

        $selected_id = $_POST['selectId'];                                          //前画面からselectIdをPOSTで送ってもらう


        error_check($selected_id);                                                  //エラーがないかチェックする
        $row = select_database($selected_id);                                       //データベースからデータを取得する
        $check = $_POST["log_check"];
    
        $s_return_check_name = $_POST['RETURN_CHECK_NAME'];

        $s_return_date_yyyy = $_POST['return_date_yyyy'];
        $s_return_date_mm = $_POST['return_date_mm'];
        $s_return_date_dd = $_POST['return_date_dd'];

        $s_return_date = check_date($s_return_date_yyyy,$s_return_date_mm,$s_return_date_dd);//不正な日付がないか確認する

        if($s_return_date_dd !== $s_return_date[8].$s_return_date[9]){
            $s_return_date_dd = $s_return_date[8].$s_return_date[9];
        }

        $today = date('Y-m-d H:i:s');                                               //今日の日付を取得する

            $id = $row['ID'];
            $rental_date = $row['RENTAL_DATE'];
            $acknowledger = $row['ACKNOWLEDGER'];
            $soft_name = $row['SOFT_NAME'];
            $version_name = $row['VERSION_NAME'];
            $take_out_user_name = $row['TAKE_OUT_USER_NAME'];
            $take_out_department = $row['TAKE_OUT_DEPARTMENT'];

        $year = $rental_date[0].$rental_date[1].$rental_date[2].$rental_date[3];
        $month = $rental_date[5].$rental_date[6];
        $day = $rental_date[8].$rental_date[9];


        //返却日付が貸出し日付よりも前に設定されたらエラーページに遷移する
        if($s_return_date_yyyy < $year or (($s_return_date_yyyy == $year) && (($s_return_date_mm < $month) or (($s_return_date_mm == $month) && ($s_return_date_dd < $day))))){
            $url = 'http://localhost/ispg2/update_Error.php';
            header('Location:'.$url.'?id=return_finished');
            exit();
        }

        //データベースに接続する
        $db = connect_database();

        //データベースをアップデートする
        try{
            $update = $db->prepare("UPDATE SOFT_USING_LIST SET RETURN_CHECK_NAME =?,RETURN_DATE =?, UPDATE_DATE=? WHERE ID =?");
            $update -> bindValue(1,$s_return_check_name,PDO::PARAM_STR);
            $update -> bindValue(2,$s_return_date,PDO::PARAM_STR);
            $update -> bindValue(3,$today,PDO::PARAM_STR);
            $update -> bindValue(4,(int)$selected_id,PDO::PARAM_INT);
            $update -> execute();
            }catch(PDOException $e){
                go_to_error();
            }

        //データベースから切断する
        disconnect_database($db);

        //SESSIONにデータを格納する
        $_SESSION['acknowledger'] = $acknowledger;
        $_SESSION['soft_name'] = $soft_name;
        $_SESSION['version_name'] = $version_name;
        $_SESSION['take_out_user_name'] = $take_out_user_name;
        $_SESSION['take_out_department'] = $take_out_department;
        $_SESSION['rental_date_yyyy'] = $year;
        $_SESSION['rental_date_mm'] = $month;
        $_SESSION['rental_date_dd'] = $day;
        $_SESSION['return_date_yyyy'] = $s_return_date_yyyy;
        $_SESSION['return_date_mm'] = $s_return_date_mm;
        $_SESSION['return_date_dd'] = $s_return_date_dd;
        $_SESSION['RETURN_CHECK_NAME'] = $s_return_check_name;

        $f = fopen("System_log.log","a");
        if($f){            
            if( $check == "insert" ){
                $writer = "返却登録--".$row[SOFT_NAME]."--".$row[TAKE_OUT_USER_NAME]."--".date('Y-m-d H:i:s')."\n";
            }else if($check == "update"){
                $writer = "返却変更--".$row[SOFT_NAME]."--".$row[TAKE_OUT_USER_NAME]."--".date('Y-m-d H:i:s')."\n";
            }
            mb_convert_variables("SJIS-win", "UTF-8", $writer);
            fputs($f,$writer);
        }
        fclose($f);

        header('Location: http://localhost/ispg2/upsert_return_finished.php');//再読み込みで二重登録が起こらないようリダイレクトする

    }
    else{
        //SESSIONからデータを取り出す
        $acknowledger = $_SESSION['acknowledger'];
        $soft_name = $_SESSION['soft_name'];
        $version_name = $_SESSION['version_name'];
        $take_out_user_name = $_SESSION['take_out_user_name'];
        $take_out_department = $_SESSION['take_out_department'];
        $year = $_SESSION['rental_date_yyyy'];
        $month = $_SESSION['rental_date_mm'];
        $day = $_SESSION['rental_date_dd'];
        $s_return_date_yyyy = $_SESSION['return_date_yyyy'];
        $s_return_date_mm = $_SESSION['return_date_mm'];
        $s_return_date_dd = $_SESSION['return_date_dd'];
        $s_return_check_name = $_SESSION['RETURN_CHECK_NAME'];
 
    }  
?>
<!DOCTYPE html>
<html lang = "ja">

    <head>
        <meta charset="utf-8">
        <title>返却登録・変更完了画面</title>
        <script>history.forward();</script>
        <link rel="stylesheet" href="./upsert_rental_finished.css">
        <link rel="stylesheet" href="./button_only.css">
    </head>

    <body>
        <header>
            <h1>ソフトウェア管理システム</h1>
            <h3>下記の登録・変更が完了しました。</h3>
        </header>
        <main>
        <div style="position:absolute;top:120px;left:70px;">
                <table style ="text-align: center">        
                    <tr>
                        <div>
                            <th>
                                <label>ソフトウェア名称</label>
                            </th>

                            <td>
                            <label><?PHP echo htmlspecialchars($soft_name) ?></label>
                            </td>
                        </div>
                    </tr>
                        
                    <tr>
                        <div class_exists>
                            <th>
                                <label>ソフトウェアバージョン</label>
                            </th>

                            <td>
                            <label><?PHP echo htmlspecialchars($version_name) ?></label>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <th>
                            <label>持ち出し者</label>
                        </th>
                    </tr>
    
                       
    
                    <tr>
                        <div>
                            <th>
                                <label>所属</label>
                            </th>
    
                            <td>
                            <label><?PHP echo htmlspecialchars($take_out_department) ?></label>
                            </td>
                        </div>
                    </tr>
    
                      
                    <tr>
                        <div>
                            <th>
                                <label>氏名</label>
                            </th>
    
                            <td>
                            <label><?PHP echo htmlspecialchars($take_out_user_name) ?></label>
                            </td>
                        </div>
                    </tr>
    
                      
    
                    <tr>
                        <div>
                            <th>
                                <label>承認者名</label>
                            </th>
                            <td>
                            <label><?PHP echo htmlspecialchars($acknowledger) ?></label>
                            </td>
                        </div>
                    </tr>
    
    
                       
    
                    <tr>
                        <div>
                            <th>
                                <label>貸出し日付</label>
                            </th>
                            <td>
                            <label><?php echo $year ?>年<?php echo $month ?>月<?php echo $day ?>日</label>
                            </td>
                        </div>
                    </tr>
                        
                    <tr>
                        <div><th><label>返却日付</label></th>
                            <td>
                            <label><?php echo $s_return_date_yyyy ?>年<?php echo $s_return_date_mm ?>月<?php echo $s_return_date_dd ?>日</label>
                            </td>
                        </div>
                    </tr>
    
                        
    
                    <tr>
                        <div>
                            <th>
                                <label>返却確認者</label>
                            </th>
                            <td>
                            <label><?php echo htmlspecialchars($s_return_check_name) ?></label>
                            </td>
                        </div>
                    </tr>
                        
                </table>
            </div>
        </main>
        <footer>
            <div style="position:absolute;top:400px;left:5pt">
                <button style="height:50px;border-radius:5px"type="button" class="button" id="back" onclick="location.href='./status_list.php'">戻る</button>
            </div>
        </footer>

    </body>

</html>
