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
						<!-- 登録できませんでした。 -->
					</div>

					<label class="mt-16">
						<textarea name="comment" cols=63 rows=16></textarea>
					</label>
					<p class="counter-text">0/200</p>
					<div class="err_msg">
						<!-- 文字数オーバーです -->
					</div>
					<div class="imgDrop-wrap">
						<label>
							画像
							<div class="area-drop">
								ここに画像をドラッグ＆ドロップ
								<i class="far fa-image fa-6x image-icon"></i>
								<input type="file" name="post-img">
							</div>
						</label>
						<div class="err_msg">
							
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