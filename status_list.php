<?php
    require_once 'common2.php';
    $db = connect_database();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>貸出し状況一覧画面</title>
        <link rel="stylesheet" href="./status_list.css">
        <script>
            history.forward();
        </script>
        
        <script language="JavaScript">
            setTimeout("location.reload()",1000*30);

            function set2fig(num) {
            // 桁数が1桁だったら先頭に0を加えて2桁に調整する
            var ret;
            if( num < 10 ) { ret = "0" + num; }
            else { ret = num; }
            return ret;
            }
            function showClock2() {
            var nowTime = new Date();
            var nowYear = set2fig( nowTime.getFullYear() );
            var nowMonth = set2fig( nowTime.getMonth() + 1);
            var nowDate = set2fig( nowTime.getDate() );
            var nowHour = set2fig( nowTime.getHours() );
            var nowMin  = set2fig( nowTime.getMinutes() );
            var nowSec  = set2fig( nowTime.getSeconds() );
            var msg = nowYear + "/" + nowMonth + "/" + nowDate + " " + nowHour + ":" + nowMin + ":" + nowSec;
            document.getElementById("RealtimeClockArea2").innerHTML = msg; 
            }
            setInterval('showClock2()',1000);
        </script>
    </head>
    <body>
        <header>
            <h1>ソフトウェア管理システム</h1><p id="RealtimeClockArea2"></p>
        </header>
        <main>
            <form method="POST">
                <div class="menu">
                    <div class="kasidasi">
                        <span class="menu_title">貸出し情報メニュー</span><br><hr><br>
                        <button type="button" class="button" onclick="location.href='./insert_rental.php'">登録</button>　
                        <button type="submit" class="button" formaction="./update_rental.php">変更</button>　
                        <button type="submit" class="button" formaction="./delete_rental.php">削除</button>
                        <br>
                    </div>
                    　　　　
                    <div class="henkyaku">
                        <span class="menu_title">返却情報メニュー</span><br><hr><br>
                        <button type="submit" class="button" id="touroku" formaction="./insert_return.php">登録</button>　
                        <button type="submit" class="button" id= "henkou" formaction="./update_return.php">変更</button>　
                        <button type="submit" class="button" id="sakuzyo" formaction="./delete_return.php">削除</button>
                        <br>
                    </div>
                </div>
                <table class="status" id="list">
                    <caption>貸出しソフトウェア一覧　　<a href="./download_csv.php" class="csvdl"><img src="./csv.png" height="20px" width="20px">CSV形式でダウンロード</a></caption>
                    <thead>
                        <tr>
                            <th rowspan="2" width="60px"></th>
                            <th rowspan="2" width="120px">貸出し日付</th>
                            <th rowspan="2" width="100px">承認</th>
                            <th rowspan="2" width="220px">ソフトウェア名称<br>バージョン</th>
                            <th colspan="2" width="200px">持出し者</th>
                            <th rowspan="2" width="120px">返却日付</th>
                            <th rowspan="2" width="100px">確認</th>
                        </tr>
                        <tr>
                            <th width="100px">所属</th>
                            <th width="100px">氏名</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sth = $db->prepare("SELECT * FROM SOFT_USING_LIST WHERE STATUS_FLAG = 0 ORDER BY RENTAL_DATE, ID ASC");
                            $sth->execute();
                            $index = 0;
                            $today = date('Y/m/d');

                            $csv = array(array("貸出し日付","承認","ソフトウェア名称","ソフトウェアバージョン","持出し者_所属","持出し者_氏名","返却日付","確認"));
                            
                            foreach($sth as $row){
                                $rental_date = $row['RENTAL_DATE'];
                                $rental = date('Y/m/d', strtotime($rental_date));
                                $return_date = $row['RETURN_DATE'];
                                $return_check_name = $row['RETURN_CHECK_NAME'];
                                if(!empty($return_date)){
                                    $return_date = date('Y/m/d' , strtotime($return_date));
                                    echo '<tr>';
                                }else{
                                    if($rental == $today){
                                        echo '<tr style="background-color: rgb(157,204,224)">';
                                    }
                                    if($rental < $today){
                                        echo '<tr style="background-color: rgb(255,255,0)">';
                                    }
                                    if($rental > $today){
                                        echo '<tr>';
                                    }
                                }                                
                                if($index == 0){
                                    echo '<td width="60px" height="63px"><div class="toggle-wrap"><input type="radio" id="toggle-radio'.$index.'" name="selectId" value="' . $row['ID'] . '" checked>
                                            <label for="toggle-radio'.$index.'" class="toggle-button">ー</label><label class="toggle-content">✓</label></div></td>';
                                } else {
                                    echo '<td width="60px" height="63px"><div class="toggle-wrap"><input type="radio" id="toggle-radio'.$index.'" name="selectId" value="' . $row['ID'] . '">
                                            <label for="toggle-radio'.$index.'" class="toggle-button">ー</label><label class="toggle-content">✓</label></div></td>';
                                }
                                echo '<td width="122px"><label for="toggle-radio'.$index.'">' . date('Y/m/d', strtotime($rental_date)) . '</label></td>';
                                echo '<td width="101.7px"><label for="toggle-radio'.$index.'">' . htmlspecialchars($row['ACKNOWLEDGER']) . '</label></td>';
                                echo '<td width="223.8px"><label for="toggle-radio'.$index.'">' . htmlspecialchars($row['SOFT_NAME']). '<br>' . htmlspecialchars($row['VERSION_NAME']) . '</label></td>';
                                echo '<td width="101px"><label for="toggle-radio'.$index.'">' . htmlspecialchars($row['TAKE_OUT_DEPARTMENT']) . '</label></td>';
                                echo '<td width="101.7px"><label for="toggle-radio'.$index.'">' . htmlspecialchars($row['TAKE_OUT_USER_NAME']) . '</label></td>';
                                echo '<td width="122px"><label for="toggle-radio'.$index.'">'.$return_date.'</label></td>';
                                echo '<td width="101.7px"><label for="toggle-radio'.$index.'">' . htmlspecialchars($row['RETURN_CHECK_NAME']) . '</label></td></tr>';
                                
                                array_push($csv, array(date('Y/m/d', strtotime($rental_date)),htmlspecialchars($row['ACKNOWLEDGER']),htmlspecialchars($row['SOFT_NAME']),
                                        htmlspecialchars($row['VERSION_NAME']),htmlspecialchars($row['TAKE_OUT_DEPARTMENT']),htmlspecialchars($row['TAKE_OUT_USER_NAME']),
                                        $return_date,htmlspecialchars($row['RETURN_CHECK_NAME'])));
                                
                                
                                $index++;
                            }
                            $f = fopen("rental_list.csv","w");
                            if($f){
                                foreach($csv as $line){
                                    mb_convert_variables("SJIS-win", "UTF-8", $line);
                                    fputcsv($f, $line);
                                }
                            }
                            fclose($f);
                            disconnect_database($db);
                        ?>
                    </tbody>
                </table>
            </form>
        </main>
        <footer>
            <a href="./download_log.php" class="logdl">システムログをダウンロード</a>
            <a href="./log_reset.php" class="logreset" onclick = "return confirm('システムログをリセットしてもよろしいですか？')">システムログをリセット</a>
        </footer>
    </body>
</html>