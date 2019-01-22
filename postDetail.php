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
$dbPostGoodNum = '';
$edit_flg = '';

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
	// DBからいいねを取得
	$dbPostGoodNum = count(getGood($p_id));
	// 自分の投稿なら編集フラグを立てる
	$edit_flg = ($dbPostData['user_id'] === $_SESSION['user_id']) ? true : false;

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
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- 投稿詳細 -->
			<section class="post" data-postid="<?php echo sanitize($p_id); ?>">
				<div class="icon-wrap">
					<a href="userpage.php?u_id=<?php echo sanitize($dbPostUserInfo['id']); ?>">
						<img class="user-icon" src="<?php echo showImg(sanitize($dbPostUserInfo['user_img'])); ?>">
					</a>
				</div>
				<div class="post-wrap">
					<div class="post-head">
						<a href="userpage.php?u_id=<?php echo sanitize($dbPostUserInfo['id']); ?>" class="username"><?php echo sanitize($dbPostUserInfo['username']); ?></a>
						<time><?php echo date('Y/m/d H:i:s',strtotime(sanitize($dbPostData['created_date']))); ?></time>
					</div>
					<p>
						<?php echo sanitize($dbPostData['contents']); ?>
					</p>

					<?php if(!empty($dbPostData['post_img'])): ?>
					<div class="post-img-wrap">
						<img class="post-img" src="<?php echo sanitize($dbPostData['post_img']); ?>">
					</div>
					<?php endif; ?>
					
					<div class="post-foot">
						<!-- 自分の投稿には編集アイコンを表示する -->
						<?php if($edit_flg){ ?>
							<a href="post.php?p_id=<?php echo $p_id; ?>">
								<i class="fas fa-edit js-post-edit btn-edit"></i>
							</a>
						<?php } ?>
						<div class="btn-comment">
							<a class="link-nomal" href="comment.php?p_id=<?php echo $dbPostData['id']; ?>">
								<i class="far fa-comment-alt fa-lg px-16"></i><?php echo count($dbCommentList); ?>
							</a>
						</div>
						<!-- $login_flgをscript.jsに渡すための記述 -->
						<?php $login_flg = !empty($_SESSION['user_id']); ?>
						<script>var login_flg = "<?php echo $login_flg ?>"</script>
						<div class="btn-good <?php if(isGood($_SESSION['user_id'], $dbPostData['id'])) echo 'active'; ?>">
							<!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
							<i class="fa-heart fa-lg px-16
							<?php
								if(isGood($_SESSION['user_id'],$dbPostData['id'])){
									echo ' active fas';
								}else{
									echo ' far';
								}; ?>"></i><span><?php echo $dbPostGoodNum; ?></span>
						</div>
					</div>
				</div>
			</section>
			<!-- コメント一覧 -->
					<?php
						foreach ($dbCommentList as $key => $val):
							$dbCommentUserId = $dbCommentList[$key]['user_id'];
							$dbCommentUserInfo = getUser($dbCommentUserId);
					?>
					<section class="comment">
						<div class="icon-wrap">
							<a href="userpage.php?u_id=<?php echo sanitize($dbCommentUserInfo['id']); ?>">
								<img class="user-icon" src="<?php echo showImg(sanitize($dbCommentUserInfo['user_img'])); ?>">
							</a>
						</div>
						<div class="post-wrap">
							<div class="post-head">
								<a href="userpage.php?u_id=<?php echo sanitize($dbCommentUserInfo['id']); ?>" class="username"><?php echo sanitize($dbCommentUserInfo['username']); ?></a>
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
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>
