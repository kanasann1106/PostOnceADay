<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　コメントページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

/*-------------------------------
	画面処理
-------------------------------*/
// GETデータを格納
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';

if(!empty($_POST)){
	debug('post情報'.print_r($_POST,true));

	$comment = $_POST['comment'];
	// 未入力チェック
	validRequired($comment, 'comment');
	// 最大文字数チェック
	validMaxLen($comment, 'comment');
	if(empty($err_msg)){
		debug('バリデーションOK!');

		try{
			$dbh = dbConnect();
			$sql = 'INSERT INTO comment (post_id, user_id, comment, created_date) VALUES (:p_id, :u_id, :comment, :date)';
			$date = array(':p_id' => $p_id, ':u_id' => $_SESSION['user_id'], ':comment' => $comment, ':date' => date('Y-m-d H:i:s'));
			// クエリ実行
			$stmt = queryPost($dbh,$sql,$date);

			if($stmt){
				header("Location:postDetail.php?p_id=".$p_id);
			}
		}catch(Exception $e){
			error_log('エラー発生：'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = 'コメント送信';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<form action="" method="post" class="form">
				<h2>コメントする</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<?php getErrMsg('common'); ?>
					</div>

					<label class="mt-16 <?php if(!empty($err_msg['comment'])) echo 'err' ?>">
						<textarea name="comment" cols=63 rows=20><?php echo getFormData('comment'); ?></textarea>
					</label>
					<p class="counter-text">0/200</p>
					<div class="err_msg">
						<?php getErrMsg('comment'); ?>
					</div>
					<div class="btn-container">
						<input type="submit" class="btn-primary" value="送信">
					</div>
				</div>
			</form>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>