<?php
    require_once './common2.php';
    init_setting();

    $db = connect_database();

    $selected_id = $_POST['selectId'];
    error_check($selected_id);
    
    $row = select_database($selected_id);

    
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
    
    $rental_year = $rental_date[0].$rental_date[1].$rental_date[2].$rental_date[3];
    $rental_month = $rental_date[5].$rental_date[6];
    $rental_day = $rental_date[8].$rental_date[9];

    $return_year = $return_date[0].$return_date[1].$return_date[2].$return_date[3];
    $return_month = $return_date[5].$return_date[6];
    $return_day = $return_date[8].$return_date[9];

    disconnect_database($db);
    
?>


<!DOCTYPE html>
<html lang = "ja">

    <head>
        <meta charset="utf-8">
        <title>貸出し削除画面</title>
        <link rel="stylesheet" href="./button_only.css">
        <style>
            body {
                background-color: snow;
            }
        </style>
        <script>history.forward();</script>
    </head>

    <body>
    <form method="POST" action="delete_rental_finished.php">
        <header>
            <h1>ソフトウェア管理システム</h1>
        </header>
        <main>
        
        <div style="position:absolute;top:120px;left:70px;">
         <table style="text-align: center">   
                    <tr>
                        <div class="input">
                            <th>
                                <label for="ccode">ソフトウェア名称</label>
                            </th>

                            <td>
                            <label><?PHP echo htmlspecialchars($soft_name) ?></label>
                            </td>
                        </div>
                    </tr>
                        
                    <tr>
                        <div class="input">
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
                        <div class="input">
                            <th>
                                <label>所属</label>
                            </th>
    
                            <td>
                            <label><?PHP echo htmlspecialchars($take_out_department) ?></label>
                            </td>
                        </div>
                    </tr>
    
                      
                    <tr>
                        <div class="input">
                            <th>
                                <label>氏名</label>
                            </th>
    
                            <td>
                            <label><?PHP echo htmlspecialchars($take_out_user_name) ?></label>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="input">
                            <th>
                                <label>承認者名</label>
                            </th>
                            <td>
                            <label><?PHP echo htmlspecialchars($acknowledger) ?></label>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="input">
                            <th>
                                <label>貸出し日付</label>
                            </th>
                            <td>
                            <label><?php echo $rental_year ?>年<?php echo $rental_month ?>月<?php echo $rental_day ?>日</label>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="input">
                            <th>
                                <label>返却日付</label>
                            </th>
                            <td>
                            <?php if( $row[RETURN_DATE] != null ){ ?>
                            <?php echo $return_year;?>年<?php echo $return_month;?>月<?php echo $return_day;?>日
                            <?php }else{ echo ' '; } ?>
                            </td>
                        </div>
                    </tr>                   
                    <tr>
                        <div class="input">
                            <th>
                                <label>返却確認者</label>
                            </th>
                            <td>
                            <label><?php echo htmlspecialchars($return_check_name) ?></label>
                            </td>
                        </div>
                    </tr>
                </table>
            </div>  
            
        </main>
        <footer>
        
                <div style="position:absolute;top:400px;left:5pt">
                <button style="height:50px;border-radius:5px;float:left"type="button" class="button" id="back" onclick="location.href='./status_list.php'">戻る</button>
                </div>
                <div style="position:absolute;top:400px;left:200pt">
                <input style="height:50px;border-radius:5px;margin-left:250px"type="submit" class="button" button onclick = "return confirm('本当に削除してもよろしいですか？')" value="削除"></button>
                </p>
                </div>
            <input type="hidden"  name="selectId" value="<?php echo $selected_id ?>">
        </footer>
    </form>
    </body>

</html>
