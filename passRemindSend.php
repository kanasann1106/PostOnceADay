<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再発行メール送信ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
if(!empty($_POST)){
	debug('POST情報'.print_r($_POST, true));

	$email = $_POST['email'];

	// 未入力チェック
	validRequired($email, 'email');

	if(empty($err_msg)){
		// emailの形式チェック
		validEmail($email, 'email');
		// emailの最大文字数チェック
		validMaxLen($email, 'email');

		if(empty($err_msg)){
			debug('バリデーションOK！');

			try{
				$dbh = dbConnect();
				$sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
				$data = array(':email' => $email);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);

				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				// EmailがDBに登録されている場合
				if($stmt && array_shift($result)){
					debug('クエリ成功。DBにemail登録あり');
					$_SESSION['msg_success'] = SUC04;

					$auth_key = makeRandKey(); // 認証キー生成

					// メール送信
					$from = 'POADカスタマーセンター';
					$to = $email;
					$subject = '【パスワード再発行認証】｜PostOnceADay';
					$comment = <<<EOT
本メールアドレス宛にパスワード再発行のご依頼がありました。
下記のURLにて認証キーと新しくパスワードを入力してパスワードの再設定をしてください。

パスワード再発行認証キー入力ページ:https://poad.kanasann.com/passReset.php
認証キー：{$auth_key}
※認証キーの有効期限は30分となります

認証キーを再発行されたい場合は下記ページより再度再発行をお願いします。
https://poad.kanasann.com/passRemindSend.php

////////////////////////////////////////
POADカスタマーセンター
URL  https://poad.kanasann.com/
////////////////////////////////////////
EOT;
					sendMail($from, $to, $subject, $comment);
					// 認証に必要な情報をセッションへ保存
					$_SESSION['auth_key'] = $auth_key;
					$_SESSION['auth_email'] = $email;
					$_SESSION['auth_key_limit'] = time()+(60*30);
					debug('センション変数の中身：'.print_r($_SESSION, true));
					header("Location:passReset.php"); //認証キーとパスワード再設定画面へ遷移
				}else{
					debug('クエリに失敗したかemailがDBに登録されていないです。');
					$err_msg['common'] = MSG07;
				}
			}catch(Exception $e){
				error_log('エラー発生：'.$e->getMessage());
				$err_msg['common'] = MSG07;
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
			<!-- パスワードリマインダーフォーム -->
			<form action="" method="post" class="form">
				<h2>パスワードリマインダ</h2>
				<div class="msg-container">
					ここにメールアドレスを入力してください。認証コードを含むメールが送信されます。
				</div>
				<div class="form-wrap">
					<div class="err_msg">
						<?php getErrMsg('common'); ?>
					</div>

					<label class="mt-16 <?php if(!empty($err_msg['email'])) echo 'err'; ?>">
						Email
						<input type="text" name="email" <?php if(!empty($_POST['email'])) echo $_POST['email']; ?>>
					</label>
					<div class="err_msg">
						<?php getErrMsg('email'); ?>
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
