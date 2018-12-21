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
						<!-- 登録できませんでした。 -->
					</div>

					<label>
						認証コード
						<input type="text" name="username">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
					</div>
					<label>
						新しいパスワード（8文字以上）
						<input type="password" name="password">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
					</div>
					<label>
						新しいパスワード再入力
						<input type="password" name="password_re">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
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