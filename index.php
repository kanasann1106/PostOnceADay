<?php
$siteTitle = 'TOP';
require('head.php');
?>
<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<section class="site-wrap">
			<!-- 投稿一覧 -->
			<?php require('postList.php'); ?>
		</section>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>
