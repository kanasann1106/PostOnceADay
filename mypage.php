<?php
$siteTitle = 'マイページ';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="post-info">
			<span style="padding-left: 22%; margin-right: 24px;">投稿：90</span><span>いいね：120</span>
		</div>
		<!-- <section class="popup">
			<p>本当に退会しますか？</p>
			<div class="btn-container">
				<input type="submit" name="yes" class="px-16 btn-gray btn-mid mr-24" value="はい">
				<input type="submit" name="no" class="btn-primary btn-mid mr-24" value="いいえ">
			</div>
		</section> -->
		<div class="mypage-wrap">
			<!-- サイドバー -->
			<?php require('sidebar.php'); ?>

			<section class="my-contents">
				<!-- 投稿一覧 -->
				<!-- <?php require('postList.php');?> -->

				<!-- プロフィール編集 -->
				<?php require('profEdit.php'); ?>

				<!-- パスワード変更フォーム -->
				<!-- <?php require ('passEdit.php'); ?> -->
			</section>
		</div>
	</main>

	<!-- フッター -->
	<?php require('footer.php'); ?>