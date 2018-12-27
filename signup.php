<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ユーザー登録ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// post送信されていた場合
if(!empty($_POST)){
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	// 未入力チェック
	validRequired($username, 'username');
	validRequired($email, 'email');
	validRequired($pass, 'pass');
	validRequired($pass_re, 'pass_re');

	if(empty($err_msg)){
		// ユーザー名文字数チェック
		validMaxLen($username, 'username', 15);

		// emailの形式チェック
		validEmail($email, 'email');
		// emailの最大文字数チェック
		validMaxLen($email, 'email');

		// パスワードの半角英数字チェック
		validHalf($pass, 'pass');
		// パスワードの最大文字数チェック
		validMaxLen($pass, 'pass');
		// パスワードの最小文字数チェック
		validMinLen($pass, 'pass');

		if(empty($err_msg)){
			// パスワードとパスワード（再入力）が合っているかのチェック
			validMatch($pass, $pass_re, 'pass_re');

			if(empty($err_msg)){
				debug('パリデーションチェックOK!');
				try{
					// DB接続
					$dbh = dbConnect();
					$sql = 'INSERT INTO users (username, email, password, login_time, created_date) VALUES (:username, :email, :pass, :login_time, :created_date)';
					$data = array(
						':username' => $username, ':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
						':login_time' => date('Y-m-d H:i:s'), ':created_date' => date('Y-m-d H:i:s')
					);
					// クエリ実行
					$stmt = queryPost($dbh, $sql, $data);

					// クエリ成功の場合
					if($stmt){
						// ログイン有効期限（デフォルトは1時間）
						$sesLimit = 60*60;
						// ログイン日時を現在日時に更新
						$_SESSION['login_date'] = time();
						$_SESSION['login_limit'] = $sesLimit;
						// ユーザーIDを格納
						$_SESSION['user_id'] = $dbh->lastInsertId();

						debug('セッション変数の中身：'.print_r($_SESSION,true));

						header("Location:index.php");
					}
				}catch(Exception $e){
					error_log('エラー発生：'. $e->getMessage());
					$err_msg['common'] = MSG07;
				}
			}
		}
	}
}
?>
<?php
$siteTitle = 'ユーザー登録';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- ユーザー登録 -->
			<form action="" method="post" class="form">
				<h2>ユーザー登録</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<?php
						if(!empty($err_msg['common'])) echo $err_msg['common'];
						?>
					</div>

					<label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
						ユーザー名
						<input type="text" name="username" value="<?php if(!empty($_POST['username'])) echo $_POST['username']; ?>">
					</label>
					<div class="err_msg">
						<?php
						if(!empty($err_msg['username'])) echo $err_msg['username'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
						メールアドレス
						<input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
					</label>
					<div class="err_msg">
						<?php
						if(!empty($err_msg['email'])) echo $err_msg['email'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
						パスワード（6文字以上）
						<input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
					</label>
					<div class="err_msg">
						<?php
						if(!empty($err_msg['pass'])) echo $err_msg['pass'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['pass_re'])) echo 'err'; ?>">
						パスワード再入力
						<input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
					</label>
					<div class="err_msg">
						<?php
						if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re'];
						?>
					</div>
					<div class="btn-container">
						<input type="submit" class="btn-primary" value="登録">
					</div>
				</div>
			</form>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>