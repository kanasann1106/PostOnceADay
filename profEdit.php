<?php

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　プロフィール編集　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

/*-------------------------------
	画面処理
-------------------------------*/
// DBからユーザーデータを取得
$dbFormData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報：'.print_r($dbFormData,true));

if(!empty($_POST)){
	debug('post送信があります。');
	debug('post情報：'.print_r($_POST,true));
	debug('file情報：'.print_r($_FILES,true));

	$username = $_POST['username'];
	$email = $_POST['email'];
	$msg = $_POST['msg'];
	// 画像をアップロードし、パスを格納
	$user_img = (!empty($_FILES['user_img']['name'])) ? uploadImg($_FILES['user_img'], 'user_img') : '';
	// 画像をpostしなかった場合、既にDBに登録されていたらDBのパスを入れる
	$user_img = (empty($user_img) && !empty($dbFormData['user_img'])) ? $dbFormData['user_img'] : $user_img;

	// DBの情報と入力情報が異なる場合にバリデーションチェックを行う
	if($dbFormData['username'] !== $username){
		// 未入力チェック
		validRequired($username, 'username');

		// ユーザー名文字数チェック
		validMaxLen($username, 'username', 15);
	}
	if($dbFormData['email'] !== $email){
		// 未入力チェック
		validRequired($email, 'email');
		if(empty($err_msg['email'])){
			// emailの形式チェック
			validEmail($email, 'email');
			// emailの最大文字数チェック
			validMaxLen($email, 'email');
			// email重複チェック
			validEmailDup($email);
		}
	}
	if($dbFormData['msg'] !== $msg){
		// メッセージ文字数チェック
		validMaxLen($msg, 'msg', 100);
	}

	if(empty($err_msg)){
		debug('バリデーションOKです。');

		try{
			// DBへ接続
			$dbh = dbConnect();
			// SQL文作成
			$sql = 'UPDATE users SET username = :u_name, email = :email, msg = :msg, user_img = :user_img WHERE id = :u_id';
			$data = array(':u_name' => $username, ':email' => $email, ':msg' => $msg, ':user_img' => $user_img, ':u_id' => $dbFormData['id']);
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);

			// クエリ成功の場合
			if($stmt){
				$_SESSION['msg_success'] = SUC02;
				debug('マイページへ遷移します。');
				header("Location:userpage.php?u_id=".$_SESSION['user_id']);
			}
		}catch(Exception $e){
			error_log('エラー発生：'.$e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}
}
debug('画面表示処理終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<form action="" method="post" class="form" enctype="multipart/form-data">
	<h2>プロフィールを編集</h2>
	<div class="form-wrap">
		<div class="err_msg">
			<?php getErrMsg('common'); ?>
		</div>
		<div class="profImgDrop-wrap">
			<label class="prof-img-area js-area-drop <?php if(!empty($err_msg['user_img'])) echo 'err'; ?>">
				<i class="far fa-user fa-3x user-icon" style="<?php if(!empty(getFormData('user_img'))) echo 'display: none'; ?>"></i>
				<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
				<input type="file" name="user_img" class="input-file">
				<img src="<?php echo getFormData('user_img'); ?>" alt="投稿画像" class="prev-img" style="<?php if(empty(getFormData('user_img'))) echo 'display:none' ?>">
			</label>
			<div class="err_msg">
				<?php getErrMsg('prof_img'); ?>
			</div>
		</div>
		<label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
			ユーザー名
			<input type="text" name="username" value="<?php echo getFormData('username'); ?>">
		</label>
		<div class="err_msg">
			<?php getErrMsg('username'); ?>
		</div>
		<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
			メールアドレス
			<input type="text" name="email" value="<?php echo getFormData('email'); ?>">
		</label>
		<div class="err_msg">
			<?php getErrMsg('email'); ?>
		</div>
		<label class="<?php if(!empty($err_msg['msg'])) echo 'err'; ?>">
			メッセージ
			<textarea name="msg" rows="9"><?php echo getFormData('msg'); ?></textarea>
		</label>
		<div class="err_msg">
			<?php getErrMsg('msg'); ?>
		</div>
		<div class="btn-container" style="text-align: right;">
			<input type="submit" class="btn-primary btn-mid" value="保存">
		</div>
	</div>
</form>