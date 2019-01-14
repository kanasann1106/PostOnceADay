<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿詳細ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');
/*-------------------------------
	画面処理
-------------------------------*/
$p_id = '';
$dbPostData = '';
$dbPostUserInfo = '';
$dbCommentList = '';

// 画像表示用データ取得
// ------------------------------
// get送信がある場合
if(!empty($_GET['p_id'])){

	// 投稿IDのGETパラメータを取得
	$p_id = $_GET['p_id'];
	// DBから投稿データを取得
	$dbPostData = getPostData($p_id);
	debug('取得したDBデータ：'.print_r($dbPostData,true));
	// 投稿者の情報
	$dbPostUserInfo = getUser($dbPostData['user_id']);

	// DBからコメントを取得
	$dbCommentList = getComment($p_id);

	// パラメータに不正な値が入っているかチェック
	if(empty($dbPostData)){
		error_log('エラー発生：指定ページに不正な値が入りました。');
		header("Location:index.php");
	}
	debug('取得したDBデータ：'.print_r($dbPostData,true));
}else{
	header("Location:index.php");
}

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = '投稿詳細';
require('head.php');
?>

<body>
	<style>
		.comment .icon-wrap{
			width: 64px;
			height: 64px;
			background: #bee6cc;
			border-radius: 50%;
			-webkit-border-radius: 50%;
			-moz-border-radius: 50%;
			position: absolute;
			top: 4px;
			overflow: hidden;
		}
		.comment .post-wrap{
			min-height: 48px;
		}
		.comment .post-head{
			padding: 0 0 8px 0;
		}
	</style>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- 投稿詳細 -->
			<section class="post">
				<div class="icon-wrap">
					<img class="user-icon" src="<?php echo showImg(sanitize($dbPostUserInfo['user_img'])); ?>">
				</div>
				<div class="post-wrap">
					<div class="post-head">
						<a href="#" class="username"><?php echo sanitize($dbPostUserInfo['username']); ?></a>
						<time><?php echo date('Y/m/d H:i:s',strtotime(sanitize($dbPostData['created_date']))); ?></time>
					</div>
					<p>
						<?php echo sanitize($dbPostData['contents']); ?>
					</p>
					<div class="post-img-wrap">
						<img class="post-img" src="<?php echo sanitize($dbPostData['post_img']); ?>">
					</div>
					<div class="post-foot">
						<div class="btn-comment">
							<a class="link-nomal" href="comment.php?p_id=<?php echo $dbPostData['id']; ?>">
								<i class="far fa-comment-alt fa-lg px-16"></i><?php echo count($dbCommentList); ?>
							</a>
						</div>
						<div class="btn-like">
							<i class="far fa-heart fa-lg like-i px-16"></i>39
						</div>
					</div>
					<!-- コメント一覧 -->
					<?php
						foreach ($dbCommentList as $key => $val):
							$dbCommentUserId = $dbCommentList[$key]['user_id'];
							$dbCommentUserInfo = getUser($dbCommentUserId);
					?>
					<section class="comment">
						<div class="icon-wrap">
							<img class="user-icon" src="<?php echo showImg(sanitize($dbCommentUserInfo['user_img'])); ?>">
						</div>
						<div class="post-wrap">
							<div class="post-head">
								<a href="#" class="username"><?php echo sanitize($dbCommentUserInfo['username']); ?></a>
								<time><?php echo date('Y/m/d H:i:s',strtotime(sanitize($val['created_date']))); ?></time>
							</div>
							<p>
								<?php echo sanitize($val['comment']); ?>
							</p>
						</div>
					</section>
					<?php
						endforeach;
					?>
				</div>
			</section>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>