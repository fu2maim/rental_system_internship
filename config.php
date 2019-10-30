<?php
//初期処理
function init_setting() {
    ini_set('display_errors', 0);
    date_default_timezone_set('Asia/Tokyo');
    session_start();
}

//データベースへ接続する
function connect_database(){
        try{ $db = new PDO(DB_HOST,DB_USERNAME,DB_PASSWORD,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            )
        );
        }
        catch(PDOException $e){
            go_to_error();
            }
        return $db;

}

//不正な日付がないかをチェックする
function check_date($y,$m,$d){
    $check = date('m',mktime(0,0,0,$m ,$d,$y));
    if($m !== $check){
        $date = date('Y/m/t',mktime(0,0,0,$m + 1 ,0,$y));
    }
    else{
        $date = $y."/".$m."/".$d;
    }
    return $date;
}

//エラーや不正なアクセスをチェックする
function error_check($id){
    if($id == NULL){
        go_to_error();
    }
}

//データベースからデータを取得する
function select_database($id){
    $db = connect_database();
    try{$row = $db->prepare('SELECT * FROM SOFT_USING_LIST WHERE ID = ? AND STATUS_FLAG = 0');
        $row -> bindValue(1,$id,PDO::PARAM_INT);
        $row -> execute();
    }
    catch(PDOException $e){
        go_to_error();
    }
    disconnect_database($db);
    foreach($row as $sth){}

    if($sth['ID'] == NULL or $sth['STATUS_FLAG'] == 1){
        go_to_error();
    }

    return $sth;
}

//データベースから切断する
function disconnect_database($connection){
    if($connection != null){
        $connection = null;
    }
}

//エラーページに遷移する
function go_to_error(){
    $url = 'http://localhost/ispg2/SystemError.html';
    header('Location:'.$url);
    exit();
}

?>