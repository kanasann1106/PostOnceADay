<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　コメントページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');
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
						<!-- 登録できませんでした。 -->
					</div>

					<label class="mt-16">
						<textarea name="comment" cols=63 rows=20></textarea>
					</label>
					<p class="counter-text">0/200</p>
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