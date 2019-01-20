<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再発行認証キー入力ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//SESSIONに認証キーがあるか確認、なければリダイレクト
if(empty($_SESSION['auth_key'])){
		header("Location:passRemindSend.php"); //認証キー送信ページへ
}
//================================
// 画面処理
//================================
//post送信されていた場合
if(!empty($_POST)){
	debug('POST情報：'.print_r($_POST, true));

	
	$auth_key = $_POST['token'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	// 未入力チェック
	validRequired($auth_key, 'token');
	validRequired($pass, 'pass');
	validRequired($pass_re, 'pass_re');

	if(empty($err_msg)){
		debug('未入力チェックOK');
		// 固定長チェック
		validLength($auth_key, 'token');
		// 半角チェック
		validHalf($auth_key, 'token');

		// パスワードチェック
		validPass($pass, 'pass');

		if(empty($err_msg)){
			// パスワードとパスワード（再入力）が合っているかのチェック
			validMatch($pass, $pass_re, 'pass_re');
			if(empty($err_msg)){
				debug('バリデーションOK');
				// 認証キーが正しいか
				if($auth_key !== $_SESSION['auth_key']){
				$err_msg['token'] = MSG13;
				}
				// 認証キーが有効期限内か
				if(time() > $_SESSION['auth_key_limit']){
					$err_msg['token'] = MSG14;
				}

				if(empty($err_msg)){
				debug('認証OK');

					try{
						$dbh = dbConnect();
						$sql = 'UPDATE users SET password = :pass WHERE email = :email AND delete_flg = 0';
						$data = array(':email' => $_SESSION['auth_email'], ':pass' => password_hash($pass, PASSWORD_DEFAULT));
						// クエリ実行
						$stmt = queryPost($dbh, $sql, $data);

						// クエリ成功時
						if($stmt){
							debug('クエリ成功');

							// メールを送信
							$from = 'POADカスタマーセンター';
							$to = $_SESSION['auth_email'];
							$subject = '【パスワード再発行完了】｜PostOnceADay';
							$comment = <<<EOT
本メールアドレス宛にパスワードが再設定されたことをお知らせするメールを送信しています。
下記のURLにて再設定したパスワードをご入力頂き、ログインください。

ログインページ：http://localhost:8888/PostedOnceADay/login.php

////////////////////////////////////////
POADカスタマーセンターカスタマーセンター
URL  http://yonaguni-media.com/
E-mail info@webukatu.com
////////////////////////////////////////
EOT;
							sendMail($from, $to, $subject, $comment);

							// センション削除
							session_unset();
							$_SESSION['msg_success'] = SUC04;
							debug('セッションの中身：'.print_r($_SESSION,true));

							header("Location:login.php"); //ログインページへ
						}else{
							debug('クエリに失敗しました。');
							$err_msg['common'] = MSG07;
						}
					}catch(Exception $e){
						error_log('エラー発生:' . $e->getMessage());
						$err_msg['common'] = MSG07;
					}
				}
			}
		}
	}
}
?>

<?php
$siteTitle = 'パスワードリセット';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<form action="" method="post" class="form">
				<h2>パスワードのリセット</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<?php getErrMsg('common'); ?>
					</div>

					<label class="<?php if(!empty($err_msg['token'])) echo 'err'; ?>">
						認証コード
						<input type="text" name="token" value="<?php if(!empty($_POST['token'])) echo $_POST['token']; ?>">
					</label>
					<div class="err_msg">
						<?php getErrMsg('token'); ?>
					</div>
					<label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
						新しいパスワード（6文字以上）
						<input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
					</label>
					<div class="err_msg">
						<?php getErrMsg('pass'); ?>
					</div>
					<label class="<?php if(!empty($err_msg['pass_re'])) echo 'err'; ?>">
						新しいパスワード再入力
						<input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
					</label>
					<div class="err_msg">
						<?php getErrMsg('pass_re'); ?>
					</div>
					<div class="btn-container">
						<input type="submit" class="btn-primary" value="リセット">
					</div>
				</div>
			</form>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>