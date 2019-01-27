<?php

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿一覧　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

/*-------------------------------
	画面処理
-------------------------------*/
$dbPostList = '';
$dbPostUserId = '';
$dbPostUserInfo = '';
$dbPostCommentNum = '';
$dbPostGoodNum = '';
$edit_flg = '';
/*---------------------------
	投稿一覧の表示処理
----------------------------*/
if(isset($u_id)){
  if(empty($_GET['good'])){
    // DBからユーザーIDと一致した投稿情報を取得
    debug('ユーザーの投稿を取得');
    $dbPostList = getUserPostList($u_id);
  }else{
    // いいねした投稿を取得
    debug('ユーザーのいいねした投稿を取得');
    $dbPostList = getUserGoodPostList($u_id);
  }
}else{
  // DBから全ての投稿情報を取得
  debug('全ての投稿を取得');
  $dbPostList = getPostList();
}

if(!empty($dbPostList)){
	// 投稿情報がある場合は表示
	foreach($dbPostList as $key => $val):
	$dbPostUserId = $dbPostList[$key]['user_id'];
	$dbPostUserInfo = getUser($dbPostUserId);
	// コメント数取得
	$dbPostCommentNum = count(getComment($dbPostList[$key]['id']));
	// いいね数取得
	$dbPostGoodNum = count(getGood($dbPostList[$key]['id']));
	// 自分の投稿には編集フラグを立てる
	$edit_flg = (!empty($_SESSION['user_id']) && 
								$dbPostList[$key]['user_id'] === $_SESSION['user_id']) ? true : false;

?>
<article class="post js-post-click" data-postid="<?php echo sanitize($dbPostList[$key]['id']); ?>">
	<div class="icon-wrap">
		<a href="userpage.php?u_id=<?php echo sanitize($dbPostUserId); ?>">
			<img class="user-icon" src="<?php echo showImg(sanitize($dbPostUserInfo['user_img'])); ?>">
		</a>
	</div>
	<div class="post-wrap">
		<div class="post-head">
			<a href="userpage.php?u_id=<?php echo sanitize($dbPostUserId); ?>" class="username"><?php echo sanitize($dbPostUserInfo['username']); ?></a>
			<time><?php echo date('Y/m/d H:i:s',strtotime(sanitize($val['created_date']))); ?></time>
		</div>
		<p>
			<?php echo nl2br(sanitize($val['contents'])); ?>
		</p>
		<?php if(!empty($val['post_img'])): ?>
		<div class="post-img-wrap">
			<img class="post-img" src="<?php echo sanitize($val['post_img']); ?>">
		</div>
		<?php endif; ?>
		
		<div class="post-foot">
			<!-- 自分の投稿には編集アイコンを表示する -->
			<?php if($edit_flg){ ?>
				<a href="post.php?p_id=<?php echo sanitize($dbPostList[$key]['id']); ?>">
					<i class="fas fa-edit js-post-edit btn-edit"></i>
				</a>
			<?php } ?>
			<div class="btn-comment">
				<a class="link-nomal" href="comment.php?p_id=<?php echo $val['id']; ?>">
					<i class="far fa-comment-alt fa-lg px-16"></i><?php echo $dbPostCommentNum; ?>
				</a>
			</div>
			<!-- $login_flgをscript.jsに渡すための記述 -->
			<?php $login_flg = !empty($_SESSION['user_id']); ?>
			<script>var login_flg = "<?php echo $login_flg ?>"</script>
			<div class="btn-good <?php if(isGood(isset($_SESSION['user_id']), $dbPostList[$key]['id'])) echo 'active'; ?>">
				<!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
				<i class="fa-heart fa-lg px-16
				<?php
					if(!empty($_SESSION['user_id'])){
						if(isGood($_SESSION['user_id'],$dbPostList[$key]['id'])){
							echo ' active fas';
						}else{
							echo ' far';
						}
					}else{
						echo ' far';
					}; ?>"></i><span><?php echo $dbPostGoodNum; ?></span>
			</div>
		</div>
	</div>
</article>
<?php
	endforeach;
}else{
?>
	<?php
		if(isset($u_id) && !empty($_GET['good'])){
	?>
		<p style="text-align: center; margin-top: 64px;">いいねがありません</p>
	<?php
		}else{
	?>
		<p style="text-align: center; margin-top: 64px;">まだ投稿はありません</p>
	<?php
		}
}

