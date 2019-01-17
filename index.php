<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();
?>
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