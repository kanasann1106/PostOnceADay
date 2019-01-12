<?php
// 本人のユーザー情報を取得
$myUserInfo = getUser($_SESSION['user_id']);
?>
<aside class="sideber">
	<div class="prof-icon-wrap">
		<img class="porf-icon" src="<?php echo showImg(sanitize($myUserInfo['user_img'])); ?>">
	</div>
	<ul class="prof">
		<li class="username"><?php echo sanitize($myUserInfo['username']); ?></li>
		<li class="user-msg px-32 mt-16">
			<?php echo sanitize($myUserInfo['msg']); ?>
		</li>
	</ul>
	<?php
		if(!empty($_SESSION['user_id'])){
	?>
		<!-- マイメニュー -->
		<ul id="js-mymenulist" class="menu">
			<a href="logout.php">ログアウト</a>
			<a href="mypage.php?menu=passEdit">パスワード変更</a>
			<a href="mypage.php?menu=profEdit">プロフィール編集</a>
			<a href="mypage.php?menu=withdraw">退会</a>
		</ul>
	<?php
		}
	?>
	
</aside>