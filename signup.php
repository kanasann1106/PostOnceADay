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
						メールアドレス
						<input type="text" name="email">
					</label>
					<div class="err_msg">
						<!-- メール形式で入力 -->
					</div>
					<label>
						パスワード（8文字以上）
						<input type="password" name="password">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
					</div>
					<label>
						パスワード再入力
						<input type="password" name="password_re">
					</label>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
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