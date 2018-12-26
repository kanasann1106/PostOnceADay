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
			<!-- 投稿詳細 -->
			<section class="post-detail">
				<div class="icon-wrap">
					<img class="user-icon" src="images/user-icon.png">
				</div>
				<div class="post-wrap">
					<div class="post-head">
						<a href="#" class="username">メッテジさん</a>
						<time>2018/12/22</time>
					</div>
					<p>
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。
						文章が入ります。文章が入ります。文章が入ります。文章が入ります。
					</p>
					<div class="post-foot">
						<div class="btn-comment">
							<a class="link-nomal" href="comment.php">
								<i class="far fa-comment-alt fa-lg px-16"></i>2
							</a>
						</div>
						<div class="btn-like">
							<i class="far fa-heart fa-lg like-i px-16"></i>39
						</div>
					</div>
					<!-- コメント一覧 -->
					<section class="comment">
						<div class="icon-wrap">
							<img class="user-icon" src="images/user-icon2.png">
						</div>
						<div class="post-wrap">
							<div class="post-head">
								<a href="#" class="username">ケェさん</a>
								<time>2018/12/22</time>
							</div>
							<p>
								コメントが入ります。コメントが入ります。コメントが入ります。
								コメントが入ります。コメントが入ります。コメントが入ります。
							</p>
						</div>
					</section>
					<section class="comment">
						<div class="icon-wrap">
							<img class="user-icon" src="images/user-icon2.png">
						</div>
						<div class="post-wrap">
							<div class="post-head">
								<a href="#" class="username">ケェさん</a>
								<time>2018/12/22</time>
							</div>
							<p>
								コメントが入ります。コメントが入ります。コメントが入ります。
								コメントが入ります。コメントが入ります。コメントが入ります。
								コメントが入ります。コメントが入ります。コメントが入ります。
								コメントが入ります。コメントが入ります。コメントが入ります。
							</p>
						</div>
					</section>
				</div>
			</section>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>