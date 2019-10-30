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

    if($row['RETURN_CHECK_NAME'] !== null or $row['RETURN_DATE'] !== null){                                  //返却確認者のデータがあるときエラーページに遷移する
        $url = 'http://localhost/ispg2/update_Error.php';
        header('Location:'.$url.'?id=insert');
        exit();
    }
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset="utf-8">
        <title>返却登録画面</title>
        <link rel="stylesheet" href="./button_only.css">
        <style>
            body {
                background-color: snow;
            }
        </style>
        <script>
            history.forward();
        
            function dateCheck(return_date_yyyy, return_date_mm, return_date_dd) {
            var y = Number(document.getElementsByName(return_date_yyyy)[0].value);
            var m = Number(document.getElementsByName(return_date_mm)[0].value);
            var day = document.getElementsByName(return_date_dd)[0];
            var d = Number(day.value);
            if (y && m) {
                var ds = new Date(y, m, 0);
                var dsn = Number(ds.getDate());
                var html = '<option value="01">1日</option>';
                for(var i = 2; i <= dsn; i++) {
                if (i === d) {
                    html += '<option value="' + i + '" selected>' + i + '日</option>';
                }
                else {
                    html += '<option value="' + i + '">' + i + '日</option>';
                }
                }
                day.innerHTML = html;
            }
            }

            let cyyyy = document.getElementById('cyyyy');
            let cmm = document.getElementById('cmm');
            let cdd = document.getElementById('cdd');
            cyyyy.value = '<?PHP echo $t_year ?>';
            cmm.value = '<?PHP echo $t_month ?>';
            cdd.value = '<?PHP echo $t_year ?>';
        
        </script>
    </head>

    <body>
    <form method="POST" action="upsert_return_finished.php">

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
                                $s_year = $rental_date[0].$rental_date[1].$rental_date[2].$rental_date[3];
                                $s_month = $rental_date[5].$rental_date[6];
                                $s_day = $rental_date[8].$rental_date[9];

                                $t_year =  $today[0]. $today[1]. $today[2]. $today[3];
                                $t_month =  $today[5]. $today[6];
                                $t_day =  $today[8]. $today[9];

                                ?>
                                <select id = "cyyyy" style="height:42px;border-radius:5px" name="return_date_yyyy" onchange="dateCheck('return_date_yyyy','return_date_mm','return_date_dd')" value= '<?php echo $t_year ?>' required>
                                <option value="2016">2016年</option>
                                <option value="2017">2017年</option>
                                <option value="2018">2018年</option>
                                <option value="2019">2019年</option>
                                </select>
                                <select id = "cmm" style="height:42px;border-radius:5px" name="return_date_mm" onchange="dateCheck('return_date_yyyy','return_date_mm','return_date_dd')" value= '<?php echo $t_month ?>' required>
                                <option value="01">1月</option>
                                <option value="02">2月</option>
                                <option value="03">3月</option>
                                <option value="04">4月</option>
                                <option value="05">5月</option>
                                <option value="06">6月</option>
                                <option value="07">7月</option>
                                <option value="08">8月</option>
                                <option value="09">9月</option>
                                <option value="10">10月</option>
                                <option value="11">11月</option>
                                <option value="12">12月</option>
                                </select>
                                <select id = "cdd" style="height:42px;border-radius:5px" name="return_date_dd" value= '<?php echo $t_day ?>' required>
                                <option value="01">1日</option>
                                <option value="02">2日</option>
                                <option value="03">3日</option> 
                                <option value="04">4日</option>
                                <option value="05">5日</option>
                                <option value="06">6日</option>
                                <option value="07">7日</option>
                                <option value="08">8日</option>
                                <option value="09">9日</option>
                                <option value="10">10日</option>
                                <option value="11">11日</option>
                                <option value="12">12日</option>
                                <option value="13">13日</option>
                                <option value="14">14日</option>
                                <option value="15">15日</option>
                                <option value="16">16日</option>
                                <option value="17">17日</option>
                                <option value="18">18日</option>
                                <option value="19">19日</option>
                                <option value="20">20日</option>
                                <option value="21">21日</option>
                                <option value="22">22日</option>
                                <option value="23">23日</option>
                                <option value="24">24日</option>
                                <option value="25">25日</option>
                                <option value="26">26日</option>
                                <option value="27">27日</option>
                                <option value="28">28日</option>
                                <option value="29">29日</option>
                                <option value="30">30日</option>
                                <option value="31">31日</option>
                                </select>
                                
                            
                            </td>
                        </div>
                    </tr>
    
                        
    
                    <tr>
                        <div>
                            <th>
                                <label>返却確認者</label><label style = "color:red;">*</label>
                            </th>
                            <td>
                                <input type="text"style="height:40px;border-radius:5px" name="RETURN_CHECK_NAME" maxlength = "20" value="" required>
                            </td>
                        </div>
                    </tr>
                        
                </table>
            </div> 
        </main>            
        <footer>
                <div style="position:absolute;top:530px;left:5pt">
                <button style="height:50px;border-radius:5px;float:left"type="button"  class="button" id="back" onclick="location.href='./status_list.php'">戻る</button>
                </div>
                <div style="position:absolute;top:530px;left:150pt">
                <input style="height:50px;border-radius:5px;margin-left:250pt" class="button" type="submit" value= "登録">
                </div>
            <input type="hidden" id="soft_name" name="selectId" value="<?php echo $selected_id ?>">
            <input type="hidden" name="log_check" value="insert">
        </footer>
        </form>
    </body>

</html>
