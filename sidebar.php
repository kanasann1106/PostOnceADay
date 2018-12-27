<aside class="sideber">
	<div class="prof-icon-wrap">
		<img class="porf-icon" src="images/user-icon.png">
	</div>
	<ul class="prof">
		<li class="username">メッテジさん</li>
		<li class="user-msg px-32 mt-16">
			こんにちは。こんにちは。こんにちは。こんにちは。こんにちは。こんにちは。
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