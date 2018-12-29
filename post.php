<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

// post送信されていた場合
if(!empty($_POST)){

	$contents = $_POST['contents'];
	$post_img = $_FILES['post_img'];

	// 未入力チェック
	validRequired($contents, 'contents');
	// 文字数チェック
	validMaxLen($contents, 'contents');




}
?>
<?php
$siteTitle = '投稿';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- 投稿フォーム -->
			<form action="" method="post" class="form" enctype="multipart/form-data">
				<h2>投稿する</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
					</div>

					<label class="mt-16">
						<textarea id="js-countup" name="contents" cols=63 rows=12></textarea>
					</label>
					<p class="counter-text"><span id="js-countup-view">0</span>/200</p>
					<div class="err_msg">
						<?php if(!empty($err_msg['contents'])) echo $err_msg['contents']; ?>
					</div>
					<div class="imgDrop-wrap">
						<label>
							画像
							<div class="area-drop">
								ここに画像をドラッグ＆ドロップ
								<i class="far fa-image fa-6x image-icon"></i>
								<input type="file" name="post_img">
							</div>
						</label>
						<div class="err_msg">
							<?php if(!empty($err_msg['post_img'])) echo $err_msg['post_img']; ?>
						</div>
					</div>

					<div class="btn-container" style="text-align: right;">
						<input type="submit" name="delete" class="px-16 btn-gray btn-mid mr-24" value="削除">
						<input type="submit" name="submit" class="btn-primary btn-mid" value="送信">
					</div>
				</div>
			</form>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>