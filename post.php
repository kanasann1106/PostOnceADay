<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　投稿ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

/*-------------------------------
	画面処理
-------------------------------*/
// 画像表示用データ取得
// ------------------------------
// GETデータを格納
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
// DBから投稿データを取得
$dbFormData = (!empty($p_id)) ? getPost($_SESSION['user_id'], $p_id) : '';
// 新規投稿画面か編集画面か判別用フラグ
$edit_flg = (empty($dbFormData)) ? false : true;
debug('投稿ID：'.$p_id);
debug(' フォーム用DBデータ：'.print_r($dbFormData,true));

// パラメータ改ざんチェック
// ------------------------------
// GETパラメータが改ざんされている場合トップページへ遷移
if(!empty($p_id) && empty($dbFormData)){
	debug('GETパラメータの投稿IDが違います。トップページへ遷移');
	header("Location:index.php");
}

// post送信されていた場合
if(!empty($_POST)){

	$contents = $_POST['contents'];
	$post_img = (!empty($_FILES['post_img']['name'])) ? uploadImg($_FILES['post_img'],'post_img') : '';

	// 更新の場合はDBの情報と入力情報が異なる場合にバリデーションチェック
	if(empty($dbFormData)){
		// 未入力チェック
		validRequired($contents, 'contents');
		// 文字数チェック
		validMaxLen($contents, 'contents');
	}else{
		if($dbFormData['contents'] !== $contents){
			// 未入力チェック
			validRequired($contents, 'contents');
			// 文字数チェック
			validMaxLen($contents, 'contents');
		}
	}

	if(empty($err_msg)){
		debug('バリデーションOKです。');

		try{
			$dbh = dbConnect();
			
			if($edit_flg){ // 編集画面の場合
				debug('DB更新です。');
				$sql = 'UPDATE post SET contents = :contents, post_img = :post_img WHERE user_id = :u_id AND id = :p_id';
				$data = array(':contents' => $contents, ':post_img' => $post_img, ':u_id' => $_SESSION['user_id'], ':p_id' => $p_id);
			}else{
				debug('DB更新登録です。');
				$sql = 'INSERT INTO post (contents, post_img, user_id, created_date) VALUES (:contents, :post_img, :u_id, :date)';
				$data = array(':contents' => $contents, ':post_img' => $post_img, ':u_id' => $_SESSION['user_id'], ':date' => date('Y-m-d H:i:s'));
			}
			debug('SQL:'.$sql);
			debug('流し込みデータ：'.print_r($data,true));
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);

			// クエリ成功の場合
			if($stmt){
				$_SESSION['msg_success'] = SUC01;
				debug('トップページへ遷移します。');
				header("Location:index.php");
			}
		}catch(Exception $e){
			error_log('エラー発生：'. $e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = '投稿';
require('head.php');
?>

<body>
	<!-- ヘッダー -->
	<?php require('header.php'); ?>

	<!-- メインコンテンツ -->
	<main>
		<div class="site-wrap">
			<!-- 投稿フォーム -->
			<form action="" method="post" class="form" enctype="multipart/form-data">
				<h2>投稿する</h2>
				<div class="form-wrap">
					<div class="err_msg">
						<?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
					</div>

					<label class="mt-16 <?php if(!empty($err_msg['contents'])) echo 'err' ;?>">
						<textarea id="js-countup" name="contents" cols=63 rows=12></textarea>
					</label>
					<p class="counter-text"><span id="js-countup-view">0</span>/200</p>
					<div class="err_msg">
						<?php if(!empty($err_msg['contents'])) echo $err_msg['contents']; ?>
					</div>
					<div class="imgDrop-wrap">
						<label class="area-drop <?php if(!empty($err_msg['post_img'])) echo 'err' ;?>">
							ここに画像をドラッグ＆ドロップ
							<!-- <i class="far fa-image fa-6x image-icon"></i> -->
							<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
							<input type="file" name="post_img" class="input-file">
							<img src="<?php echo getFormData('post_img') ;?>" alt="投稿画像" class="prev-img" style="<?php if(empty(getFormData('post_img'))) echo 'display:none;' ?>">
						</label>
						<div class="err_msg">
							<?php if(!empty($err_msg['post_img'])) echo $err_msg['post_img']; ?>
						</div>
					</div>

					<div class="btn-container" style="text-align: right;">
						<input type="submit" name="delete" class="px-16 btn-gray btn-mid mr-24" value="削除">
						<input type="submit" name="submit" class="btn-primary btn-mid" value="送信">
					</div>
				</div>
			</form>
		</div>
	</main>

<!-- フッター -->
<?php require('footer.php'); ?>