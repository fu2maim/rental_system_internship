<?php
    require_once './common2.php';
    init_setting();

    $selected_id = $_POST['selectId'];                                      //前画面からselectIdをPOSTで送ってもらう

    error_check($selected_id);                                              //エラーがないかチェックする

    $row = select_database($selected_id);                                   //データベースからデータを取得する

        $id = $row['ID'];
        $rental_date = $row['RENTAL_DATE'];
        $acknowledger = $row['ACKNOWLEDGER'];
        $soft_name = $row['SOFT_NAME'];
        $version_name = $row['VERSION_NAME'];
        $take_out_user_name = $row['TAKE_OUT_USER_NAME'];
        $take_out_department = $row['TAKE_OUT_DEPARTMENT'];
        $return_date = $row['RETURN_DATE'];
        $return_check_name = $row['RETURN_CHECK_NAME'];
        $update_date = $row['UPDATE_DATE'];
        $status_flag = $row['STATUS_FLAG'];        

    $today = date('Y/m/d');                                                 //今日の日付を取得する
    
    if($row['RETURN_CHECK_NAME'] == null or $row['RETURN_DATE'] == null){  //返却確認者のデータがないときエラーページに遷移する
        $url = 'http://172.20.49.135/sw-manage/ispg2/update_Error.php';
        header('Location:'.$url.'?id=update');
        exit();
    }
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset="utf-8">
        <title>返却変更画面</title>
        <link rel="stylesheet" href="./button_only.css">
        <style>
            body {
                background-color: snow;
            }
        </style>
    </head>

    <body>
       <form method="POST" action="./upsert_return_finished.php">

        <header>
            <h1>ソフトウェア管理システム</h1>
        </header>
        <main>
            
        <div style="position:absolute;top:70px;left:70px;">
                <table style = "text-align: center">        
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
                        <div>
                            <th>
                                <label>ソフトウェアバージョン</label>
                            </th>

                            <td>
                            <label><?PHP echo htmlspecialchars($version_name) ?></label>
                            </td>
                        </div>
                    </tr>
            <br>
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
                                <?php
                                $year = $rental_date[0].$rental_date[1].$rental_date[2].$rental_date[3];
                                $month = $rental_date[5].$rental_date[6];
                                $day = $rental_date[8].$rental_date[9];
                                ?>
                                <label><?php echo $year ?>年<?php echo $month ?>月<?php echo $day ?>日</label>
                             
                            </td>
                        </div>
                    </tr>
                        
            <br>
                    <tr>
                        <div><th><label>返却日付</label><label style = "color:red;">*</label></th>
                            <td>
                            <?php
                                $s_year = $return_date[0].$return_date[1].$return_date[2].$return_date[3];
                                $s_month = $return_date[5].$return_date[6];
                                $s_day = $return_date[8].$return_date[9];

                                $t_year =  $today[0]. $today[1]. $today[2]. $today[3];
                                $t_month =  $today[5]. $today[6];
                                $t_day =  $today[8]. $today[9];

                                echo '<select style="height:42px;border-radius:5px" name="return_date_yyyy" required>';
                                for($i = 2016;$i <=  $t_year; $i++){
                                    if($i == $s_year){
                                        echo '<option value="'.$i.'"selected>'.$i.'年</option>';
                                    }else{
                                        echo '<option value="'.$i.'">'.$i.'年</option>';
                                    }
                                }
                                echo '</select><select style="height:42px;border-radius:5px" name="return_date_mm" required>';
                                    for($j = 1; $j <= 12; $j++){
                                        if($j == $s_month){
                                            echo '<option value="'.sprintf("%02d",$j).'"selected>'.$j.'月</option>';
                                        }else{
                                            echo '<option value="'.sprintf("%02d",$j).'">'.$j.'月</option>';
                                        }
                                    }
                                echo '</select><select style="height:42px;border-radius:5px" name="return_date_dd" required>';
                                    for($k = 1; $k <= 31; $k++){
                                        if($k == $s_day){
                                            echo '<option value="'.sprintf("%02d",$k).'"selected>'.$k.'日</option>';
                                        }else{
                                            echo '<option value="'.sprintf("%02d",$k).'">'.$k.'日</option>';
                                        }
                                    }
                                echo'</select>';
                                
                            ?>
                            </td>
                        </div>
                    </tr>
    
                    
                    <tr>
                        <div>
                            <th>
                                <label>返却確認者</label><label style = "color:red;">*</label>
                            </th>
                            <td>
                                <input type="text"style="height:40px;border-radius:5px" name="RETURN_CHECK_NAME" maxlength = "20" value="<?php echo $return_check_name?>" required>
                            </td>
                        </div>
                    </tr>
                        
                </table>
            </div>
            
        </main>
            <footer>
                <div style="position:absolute;top:530px;left:5pt">
                    <button style="height:50px;border-radius:5px;float:left"type="button" class="button" onclick="location.href='./status_list.php'">戻る</button>
                    </div>
                <div style="position:absolute;top:530px;left:150pt">
                    <input style="height:50px;border-radius:5px;margin-left:250pt"type="submit" class="button" value= "変更">
                    </div>
                <input type="hidden" name="selectId" value="<?php echo $selected_id ?>">
                <input type="hidden" name="log_check" value="update">
            </footer>
</form> 
    </body>

</html>
