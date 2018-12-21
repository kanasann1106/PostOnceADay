<?php
$siteTitle = 'ログイン';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- ログインフォーム -->
			<form action="" method="post" class="form">
				<h2>PORTFOLIOにログイン</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<!-- 登録できませんでした。 -->
					</div>

					<label>
						ユーザー名
						<input type="text" name="username">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
					</div>
					<label>
						パスワード（8文字以上）
						<input type="password" name="password">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
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