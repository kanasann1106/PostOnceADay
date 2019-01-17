<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　Ajax　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

/*-------------------------------
	Ajax処理
-------------------------------*/
// postがある場合
if(isset($_POST['postId'])){
	debug('post送信があります');
	$p_id = $_POST['postId'];
	debug('投稿ID：'.$p_id);

	try{
		$dbh = dbConnect();
		$sql = 'SELECT * FROM good WHERE post_id = :p_id AND user_id = :u_id';
		$data = array(':p_id' => $p_id, 'u_id' => $_SESSION['user_id']);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$resultCount = $stmt->rowCount();
		// レコードが1件でもある場合
		if(!empty($resultCount)){
			// レコードを削除する
			$sql = 'DELETE FROM good WHERE post_id = :p_id AND user_id = :u_id';
			$data = array(':p_id' => $p_id, ':u_id' => $_SESSION['user_id']);
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
			debug(count(getGood($p_id)));
			echo count(getGood($p_id));
		}else{
			// レコードを挿入する
			$sql = 'INSERT INTO good (post_id, user_id, created_date) VALUES (:p_id, :u_id, :date)';
			$data = array(':p_id' => $p_id, ':u_id' => $_SESSION['user_id'], ':date' => date('Y-m-d H:i:s'));
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
			debug(count(getGood($p_id)));
			echo count(getGood($p_id));
		}
	}catch(Exception $e){
		error_log('エラー発生：'.$e->getMessage());
	}
}
debug('Ajax処理終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');