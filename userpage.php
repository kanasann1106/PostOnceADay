<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ユーザーページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');
/*-------------------------------
	画面処理
-------------------------------*/
$u_id = $_GET['u_id'];
$dbPostData = '';
$dbPostGoodNum = '';
// ------------------------------
// get送信がある場合
if(!empty($_GET['u_id']) && !empty(getUser($u_id))){
	$dbPostUserInfo = getUser($u_id);
	$dbPostData = getUserPostList($u_id);
	$dbPostGoodNum = count(getUserGoodPostList($u_id));
}else{
	header("Location:index.php");
}
?>
<?php
$siteTitle = ($_SESSION['user_id']=== $u_id) ? 'マイページ' : 'ユーザーページ';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="sp-prof-info">
			<div class="prof-icon-wrap">
				<img class="porf-icon" src="<?php echo showImg(sanitize($dbPostUserInfo['user_img'])); ?>">
			</div>
			<div class="sp-username"><?php echo sanitize($dbPostUserInfo['username']); ?></div>
			<!-- メッセージがある場合のみ表示 -->
			<?php if(!empty($dbPostUserInfo['msg'])){ ?>
			<div class="sp-user-msg">
				<p><?php echo sanitize($dbPostUserInfo['msg']); ?></p>
			</div>
			<?php } ?>

			<!-- マイメニュー -->
			<?php if(!empty($_SESSION['user_id']) && $u_id == $_SESSION['user_id']){ ?>
			<span class="sp-menu-btn js-menu-slide"><i class="fas fa-cog fa-lg"></i></span>
			<ul id="js-menulist" class="sp-menu">
			<li><a href="logout.php">ログアウト</a></li>
			<li><a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>&menu=profEdit">プロフィール編集</a></li>
			<li><a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>&menu=passEdit">パスワード変更</a></li>
			<li><a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>&menu=withdraw">退会</a></li>
			</ul>
		<?php } ?>
		</div>
		<div class="post-info">
				<a href="userpage.php?u_id=<?php echo sanitize($u_id); ?>">投稿：<?php echo count($dbPostData); ?></a>
				<a href="userpage.php?u_id=<?php echo sanitize($u_id).'&good=exist'; ?>">いいね：<?php echo $dbPostGoodNum; ?></a>
		</div>

		<div class="mypage-wrap">
			<!-- サイドバー -->
			<?php require('sidebar.php'); ?>

			<section class="my-contents">
				<?php 
					if(empty($_GET['menu'])){
						//投稿一覧
						require('postList.php');
					}elseif($_GET['menu'] === 'profEdit'){
						//プロフィール編集
						require('profEdit.php');
					}elseif($_GET['menu'] === 'passEdit'){
						//パスワード変更フォーム
						require('passEdit.php');
					}elseif($_GET['menu'] === 'withdraw'){
						//退会ポップアップ
						require('withdraw.php');
					}else{
						debug('maimomo');
						header("Location:userpage.php?u_id=".$_SESSION['user_id']); //マイページへ
					}
				?>
			</section>
		</div>
	</main>

	<!-- フッター -->
	<?php require('footer.php'); ?>