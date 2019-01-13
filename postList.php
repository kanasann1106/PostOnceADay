<?php

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿一覧　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

/*---------------------------
	画面処理
----------------------------*/
$dbPostList = '';
$dbPostUserId = '';
$dbPostUserInfo = '';

// --------------------------
// マイページの場合自分の投稿だけ表示する
if(isset($mypage_flg)){
	// DBから自分の投稿情報を取得
	global $dbPostList;
	$dbPostList = getMyPostList($_SESSION['user_id']);
}else{
	// DBから全ての投稿情報を取得
	global $dbPostList;
	$dbPostList = getPostList();
}
debug(print_r($dbPostList,true));
foreach($dbPostList as $key => $val):
	$dbPostUserId = $dbPostList[$key]['user_id'];
	$dbPostUserInfo = getUser($dbPostUserId);
?>
<article class="post" data-postid="<?php echo sanitize($dbPostList[$key]['id']); ?>">
	<div class="icon-wrap">
		<a href="mypage.php?u_name=">
			<img class="user-icon" src="<?php echo showImg(sanitize($dbPostUserInfo['user_img'])); ?>">
		</a>
	</div>
	<div class="post-wrap">
		<div class="post-head">
			<a href="mypage.php?u_name=" class="username"><?php echo sanitize($dbPostUserInfo['username']); ?></a>
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