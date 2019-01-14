<header>
	<div class="flex-b">
		<h1><a href="index.php">POAD -PostOnceADay-</a></h1>
		<nav id="top-nav">
			<ul>
				
				<?php
					if(empty($_SESSION['user_id'])){
				?>	<!-- 未ログイン -->
						<li><a href="login.php">ログイン</a></li>
						<li><a class="btn-primary" href="signup.php">ユーザー登録</a></li>
				<?php
					}else{
				?>	<!-- ログイン済み -->
						<li><a class="btn-primary" href="post.php"><i class="fas fa-pencil-alt fa-lg mr-16"></i>投稿</a></li>
						<li><a href="userpage.php?u_id=<?php echo $_SESSION['user_id'] ?>"><i class="fas fa-home fa-2x pt-10"></i></a></li>
				<?php
					}
				?>
			</ul>
		</nav>
	</div>
</header>