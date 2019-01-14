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
/*---------------------------
	投稿一覧の表示処理
----------------------------*/
if(isset($u_id)){
	// DBからユーザーIDと一致した投稿情報を取得
	// global $dbPostList;
	$dbPostList = getMyPostList($u_id);
}else{
	// DBから全ての投稿情報を取得
	// global $dbPostList;
	$dbPostList = getPostList();
}

foreach($dbPostList as $key => $val):
$dbPostUserId = $dbPostList[$key]['user_id'];
$dbPostUserInfo = getUser($dbPostUserId);

?>
<article class="post" data-postid="<?php echo sanitize($dbPostList[$key]['id']); ?>">
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
			<?php echo $val['contents']; ?>
		</p>
		<div class="post-img-wrap">
			<img class="post-img" src="<?php echo sanitize($val['post_img']); ?>">
		</div>
		
		<div class="post-foot">
			<div class="btn-comment">
				<a class="link-nomal" href="comment.php?p_id=<?php echo $val['id']; ?>">
					<i class="far fa-comment-alt fa-lg px-16"></i>2
				</a>
			</div>
			<div class="btn-like">
				<i class="far fa-heart fa-lg like-i px-16"></i>39
			</div>
		</div>
	</div>
</article>
<?php
	endforeach;
?>
</article>