<?php
    require_once './common2.php';
    init_setting();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>貸出し登録画面</title>
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
        <form method="POST">
        <main>
            <div style="position:absolute;top:70px;left:70px;">
                <table style = "text-align: center">
                
                    <tr>
                    <th><label>ソフトウェア名称</label><label style = "color:red;">*</label></th>
                        <td><input type="text" style="height:40px;border-radius:5px" name="soft_name" class="long" maxlength="50" required></td>
                    
                    </tr>
                
                    <tr>
                        <th><label>ソフトウェアバージョン</label></th>
                            <td><input type="text" style="height:40px;border-radius:5px" name="version_name" class="long" maxlength="50"></td>
                        
                    </tr>
                
                <br>
                    <tr>
                            <th><label>持出し者</label></th>
                    </tr>

                

                    <tr>
                        <th><label>所属</label><label style = "color:red;">*</label></th>

                            <td><input type="text" style="height:40px;border-radius:5px" name="take_out_department" class="long" maxlength="50" required></td>
                        
                    </tr>

                
                    <tr>
                        <th><label>氏名</label><label style = "color:red;">*</label></th>

                            <td><input type="text" style="height:40px;border-radius:5px" name="take_out_user_name" class="long" maxlength="20" required></td>
                        
                    </tr>

                

                    <tr>
                        <th><label>承認者名</label><label style = "color:red;">*</label></th>
                            <td><input type="text" style="height:40px;border-radius:5px" name="acknowledger" class="long" maxlength="20" required></td>
                        
                    </tr>

                <br>
                    <tr>
                        <th><label>貸出し日付</label><label style = "color:red;">*</label></th>
                            <?php
                                $time = time();
                                $year = date("Y", $time);
                                $month = date("n", $time);
                                $day = date("j", $time);
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
            <input type="hidden" name="log_check" value="insert">
        </main>
        <footer>
            <div style="position:absolute;top:450px;left:5pt">
                <button style="height:50px;border-radius:5px;float: left" type="button"  class="button" onclick="location.href='./status_list.php'">戻る</button>
            </div>
            <div style="position:absolute;top:450px;left:150pt">
                <button style="height:50px;border-radius:5px;margin-left:250pt" type="submit" class="button" formaction="./upsert_rental_finished.php">登録</button>
            </div>
        </footer>
        </form>
    </body>
</html>