<?php

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　退会　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

/*-------------------------------
	画面処理
-------------------------------*/
// post送信されていた場合
if(!empty($_POST)){
	if($_POST['yes']){
		debug('退会します');

		try{
			// DBへ接続
			$dbh = dbConnect();
			// SQL文作成
			$sql1 = 'UPDATE users SET delete_flg = 1 WHERE id = :u_id';
			$sql2 = 'UPDATE post SET delete_flg = 1 WHERE user_id = :u_id';
			$sql3 = 'UPDATE good SET delete_flg = 1 WHERE user_id = :u_id';
			
			$data = array(':u_id' => $_SESSION['user_id']);
			// クエリ実行
			$stmt1 = queryPost($dbh, $sql1, $data);
			$stmt2 = queryPost($dbh, $sql2, $data);
			$stmt3 = queryPost($dbh, $sql3, $data);

			if($stmt1 && $stmt2 && $stmt3){
				// セッション削除
				session_destroy();
				debug('セッション変数の中身：'.print_r($_SESSION,true));
				debug('トップページへ遷移します。');
				header("Location:index.php");
			}else{
				debug('クエリが失敗しました。');
				$err_msg['common'] = MSG07;
			}

		}catch(Exception $e){
			error_log('エラー発生：'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}

	}else{
		debug('退会をキャンセル(mypageに遷移)');
		header("Location:userpage.php?u_id=".$_SESSION['user_id']);
	}
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<form action="" method="post">
	<section class="popup">
		<p>本当に退会しますか？</p>
		<div class="btn-container">
			<input type="submit" name="yes" class="px-16 btn-gray btn-mid mr-24" value="はい">
			<input type="submit" name="no" class="btn-primary btn-mid mr-24" value="いいえ">
		</div>
	</section>
</form>
