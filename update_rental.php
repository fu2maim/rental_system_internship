<?php
    require_once './common2.php';
    init_setting();

    $selectId = $_POST['selectId'];

    error_check($selectId);

    $row = select_database($selectId);

    $selected_id = $row['ID'];
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

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>貸出し変更画面</title>
        <script> history.forward(); </script>
        <style>
            body{
                background-color: snow;
            }
        </style>
        <link rel="stylesheet" href="./button_only.css">
    </head>
    <body>
        <header>
            <h1>ソフトウェア管理システム</h1>
        </header>
        <form action="./upsert_rental_finished.php" method="POST">
        <main>
            <div style="position:absolute;top:70px;left:70px;">
                <table style="text-align: center">
                
                    <tr>
                    <th><label for="ccode">ソフトウェア名称</label><label style = "color:red;">*</label></th>
                    <td><input type="text" style="height:40px;border-radius:5px" value="<?php echo $soft_name ?>" name="soft_name" class="long" maxlength="50" required></td>
                    
                    </tr>
        
                    <tr>
                    <th><label>ソフトウェアバージョン</label></th>
                    <td><input type="text" style="height:40px;border-radius:5px" value="<?php echo $version_name ?>" name="version_name" maxlength="50" class="long"></td>
                    
                    </tr>
                
                    <br>

                    <tr>
                    <th><label>持出し者</label></th>
                    </tr>

                    <tr>
                    <th><label>所属</label><label style = "color:red;">*</label></th>
                    <td><input type="text" style="height:40px;border-radius:5px" value="<?php echo $take_out_department ?>" name="take_out_department" class="long" maxlength="50" required></td>
                    
                    </tr>
                
                    <tr>
                    <th><label>氏名</label><label style = "color:red;">*</label></th>
                    <td><input type="text" style="height:40px;border-radius:5px" value="<?php echo $take_out_user_name ?>" name="take_out_user_name" class="long" maxlength="20" required></td>
                    
                    </tr>

                    <tr>
                    <th><label>承認者名</label><label style = "color:red;">*</label></th>
                    <td><input type="text" style="height:40px;border-radius:5px" value="<?php echo $acknowledger ?>" name="acknowledger" class="long" maxlength="20" required></td>
                    
                    </tr>

                    <br>

                    <tr>
                    <th><label>貸出し日付</label><label style = "color:red;">*</label></th>
                        <?php
                            $year = $rental_date[0].$rental_date[1].$rental_date[2].$rental_date[3];
                            $month = $rental_date[5].$rental_date[6];
                            $day = $rental_date[8].$rental_date[9];
                            echo '<td> <select style="height:42px;border-radius:5px" name="rental_date_yyyy" required>';
                                for($i = 2016; ; $i++){
                                    if($i == $year){
                                        echo '<option value="'.$i.'" selected>'.$i.'年</option>';
                                        break;
                                    }else{  
                                        echo '<option value="'.$i.'">'.$i.'年</option>';
                                    }
                                }
                            echo '</select><select style="height:42px;border-radius:5px" name="rental_date_mm" required>';
                                for($j = 1; $j <= 12; $j++){
                                    if($j == $month){
                                        echo '<option value="'.sprintf("%02d",$j).'" selected>'.$j.'月</option>';
                                    }else{
                                        echo '<option value="'.sprintf("%02d",$j).'">'.$j.'月</option>';
                                    }
                                }
                            echo '</select><select style="height:42px;border-radius:5px" name="rental_date_dd" required>';
                                for($k = 1; $k <= 31; $k++){
                                    if($k == $day){
                                        echo '<option value="'.sprintf("%02d",$k).'" selected>'.$k.'日</option>';
                                    }else{
                                        echo '<option value="'.sprintf("%02d",$k).'">'.$k.'日</option>';
                                    }
                                }
                            echo'</select></td>';
                                
                        ?>
                        
                    </tr>

                </table>
            </div>  
            <input type="hidden" id="soft_name" name="selectId" value="<?php echo $selected_id ?>">
            <input type="hidden" name="log_check" value="update">
        </main>
        <footer>
                <div style="position:absolute;top:450px;left:5pt">
                <button type="button" style="height:50px;border-radius:5px;float: left" class="button" id="back" onclick="location.href='./status_list.php'">戻る</button>
                </div>
                <div style="position:absolute;top:450px;left:150pt">
                <button type="submit" style="height:50px;border-radius:5px;margin-left:250pt" class="button" id="back">変更</button>
                </div>
        </footer>
        </form>
    </body>
</html>