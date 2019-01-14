<?php
if(!empty($u_id)){
	$dbPostUserInfo = getUser($u_id);
}
?>
<aside class="sideber">
	<div class="prof-icon-wrap">
		<img class="porf-icon" src="<?php echo showImg(sanitize($dbPostUserInfo['user_img'])); ?>">
	</div>
	<ul class="prof">
		<li class="username"><?php echo sanitize($dbPostUserInfo['username']); ?></li>
		<li class="user-msg px-32 mt-16">
			<?php echo sanitize($dbPostUserInfo['msg']); ?>
		</li>
	</ul>
	<?php
		if(!empty($_SESSION['user_id']) && $u_id == $_SESSION['user_id']){
	?>
		<!-- マイメニュー -->
		<ul id="js-mymenulist" class="menu">
			<a href="logout.php">ログアウト</a>
			<a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>&menu=passEdit">パスワード変更</a>
			<a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>&menu=profEdit">プロフィール編集</a>
			<a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>&menu=withdraw">退会</a>
		</ul>
	<?php
		}
	?>
	
</aside>