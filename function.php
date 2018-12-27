<?php

/*-------------------------------
	ログ
-------------------------------*/
//ログを取るか
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');
/*-------------------------------
	デバッグ関数
-------------------------------*/
// デバッグフラグ
$debug_flg = true;
// デバッグログ関数
function debug($str){
	global $debug_flg;
	if(!empty($debug_flg)){
		error_log('デバッグ：'.$str);
	}
}
/*-------------------------------
	セッション準備・セッション有効期限を延ばす
-------------------------------*/
// セッションファイルの置き場を変更(30日は削除されない デフォルト有効期限は24分)
session_save_path("/var/tmp/");
// ガーベージコレクションが削除するセッションの有効期限を設定
ini_set('session.gc_maxlifetime', 60*60*24*30);
// ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60*60*24*30);
// セッション使用
session_start();
// セッションIDを新しく発行(なりすまし対策)
session_regenerate_id();
/*-------------------------------
	画面表示処理開始ログ吐き出し関数
-------------------------------*/
function debugLogStart(){
	debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
	debug('セッションID：'.session_id());
	debug('センション変数の中身：'.print_r($_SESSION,true));
	debug('現在日時のタイムスタンプ：'.time());
	if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
		debug('ログイン期限日時タイムスタンプ：'.($_SESSION['login_date'] + $_SESSION['login_limit']));
	}
}
/*-------------------------------
	定数
-------------------------------*/
// エラーメッセージ
define('MSG01', '入力必須です');
define('MSG02', '半角英数字で入力してください');
define('MSG03', 'パスワード(再入力)が合っていません');
define('MSG04', '文字以上で入力してください');
define('MSG05', 'E-mailの形式で入力してください');
define('MSG06', '文字以内で入力してください');
define('MSG07', 'エラーが発生しました。しばらく経ってからやり直してください');
define('MSG08', 'ユーザー名またはパスワードが違います');

/*-------------------------------
	グローバル変数
-------------------------------*/
// エラーメッセージ格納用の配列
$err_msg = array();

/*-------------------------------
	バリデーションチェック
-------------------------------*/
// 未入力チェック
function validRequired($str, $key){
	if($str === ''){
		global $err_msg;
		$err_msg[$key] = MSG01;
	}
}
// 最大文字数チェック
function validMaxLen($str, $key, $max = 200){
	if(mb_strlen($str) > $max){
		global $err_msg;
		$err_msg[$key] = $max.MSG06;
	}
}
// 最小文字数チェック
function validMinLen($str, $key, $min = 6){
	if(mb_strlen($str) < $min){
		global $err_msg;
		$err_msg[$key] = $min.MSG04;
	}
}
// E-mail形式チェック
function validEmail($str, $key){
	if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG05;
	}
}
// 半角英数字チェック
function validHalf($str, $key){
	if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG02;
	}
}
// 同値チェック
function validMatch($str1, $str2, $key){
	if($str1 !== $str2){
		global $err_msg;
		$err_msg[$key] = MSG03;
	}
}
/*-------------------------------
	データベース
-------------------------------*/
// DB接続関数
function dbConnect(){
	// DBへの接続準備
	$dsn = 'mysql:dbname=PostedOnceADay;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$options = array(
		// SQL実行失敗時にはエラーコードのみ設定
		PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
		// デフォルトフェッチモードを連想配列形式に設定
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		// バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
		// SELECTで得た結果に対してもrowCountメソッドを使えるようにする
		PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
	);
	// PDOオブジェクト生成（DBへ接続）
	$dbh = new PDO($dsn, $user, $password, $options);
	return $dbh;
}
// SQL実行関数
function queryPost($dbh, $sql, $data){
	// クエリ作成
	$stmt = $dbh->prepare($sql);
	// SQL文を実行
	if(!$stmt->execute($data)){
		debug('クエリ失敗しました。');
		debug('失敗したSQL：'.print_r($stmt,true));
		$err_msg['common'] = MSG07;
		return 0;
	}
	debug('クエリ成功');
	return $stmt;
}




