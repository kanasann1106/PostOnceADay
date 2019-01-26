<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

// post送信されていた場合
if(!empty($_POST)){

	$username = $_POST['username'];
	$pass = $_POST['pass'];
	$pass_save = (!empty($_POST['pass_save'])) ? true : false;

	// 未入力チェック
	validRequired($username, 'username');
	validRequired($pass, 'pass');

	if(empty($err_msg)){
		// 文字数チェック
		validMaxLen($username, 'username', 15);
		// パスワードチェック
		validPass($pass, 'pass');

		if(empty($err_msg)){
			debug('バリデーションOKです。');

			try{
				// DB接続
				$dbh = dbConnect();
				$sql = 'SELECT password, id FROM users WHERE username = :username AND delete_flg = 0';
				$data = array(':username' => $username);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// クエリ結果の値を取得
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				debug('クエリ結果の中身：'.print_r($result,true));

				// パスワード照合
				if(!empty($result) && password_verify($pass, array_shift($result))){
					debug('パスワードがマッチしました。');

					//ログイン有効期限（デフォルトを１時間とする）
					$sesLimit = 60*60;
					// ログイン日時を現在日時に更新
					$_SESSION['login_date'] = time();

					// ログイン保持にチェックがある場合
					if($pass_save){
						debug('ログイン保持にチェックがあります');
						// ログイン有効期限を30日に
						$_SESSION['login_limit'] = $sesLimit * 24 * 30;
					}else{
						debug('ログイン保持にチェックはありません');
						// ログイン有効期限はデフォルトの1時間に
						$_SESSION['login_limit'] = $sesLimit;
					}
					// ユーザーIDを格納
					$_SESSION['user_id'] = $result['id'];

					debug('セッションの中身：'.print_r($_SESSION,true));
					debug('トップページへ遷移');
					header("Location:index.php");
				}else{
					debug('パスワードがアンマッチです。');
					$err_msg['common'] = MSG08;
				}
			}catch(Exception $e){
				error_log('エラー発生：'. $e->getMessage());
				$err_msg['common'] = MSG07;
			}
		}
	}
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = 'ログイン';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<p id="js-show-msg" style="display: none; position: relative; top: 56px;" class="msg-slide">
		<?php echo getSessionFlash('msg_success'); ?>
	</p>
	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- ログインフォーム -->
			<form action="" method="post" class="form">
				<h2>POADにログイン</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<?php getErrMsg('common'); ?>
					</div>

					<label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
						ユーザー名
						<input type="text" name="username" value="<?php if(!empty($_POST['username'])) echo $_POST['username']; ?>">
					</label>
					<div class="err_msg">
						<?php getErrMsg('username'); ?>
					</div>
					<label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
						パスワード（6文字以上）
						<input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'] ?>">
					</label>
					<div class="err_msg">
						<?php getErrMsg('pass'); ?>
					</div>
					
					<div class="btn-container">
						<input type="submit" class="btn-primary" value="ログイン">
					</div>
					<label>
						<input type="checkbox" name="pass_save">次回から自動ログインする
					</label>
					<div class="msg-container">
						<a href="passRemindSend.php">パスワードを忘れですか？</a>
					</div>
				</div>
			</form>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>