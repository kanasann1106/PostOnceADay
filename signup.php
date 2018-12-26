<?php
// 共通変数・関数ファイルを読み込み
require('function.php');

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

			// if(empty($err_msg)){
			// 	debug('パリデーションチェックOK!');
			// 	try{

			// 	}catch{

			// 	}
			// }

			
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