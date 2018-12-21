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
					<!-- 登録できませんでした。 -->
					</div>

					<label class="mt-16">
						Email
						<input type="text" name="username">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
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