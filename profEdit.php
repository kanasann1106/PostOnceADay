<form action="" method="post" class="form" enctype="multipart/form-data">
	<h2>プロフィールを編集</h2>
	<div class="form-wrap">
		<div class="err_msg">
			<!-- 登録できませんでした。 -->
		</div>
		<div class="profImgDrop-wrap">
			<label>
				アイコン画像
				<div class="prof-area-drop">
					<i class="far fa-image fa-5x image-icon"></i>
					<input type="file" name="post-img">
				</div>
			</label>
			<div class="err_msg">
				<!-- 文字数オーバーです -->
			</div>
		</div>
		<label>
			ユーザー名
			<input type="text" name="username">
		</label>
		<div class="err_msg">
			<!-- 文字数オーバーです -->
		</div>
		<label>
			メールアドレス
			<input type="text" name="email">
		</label>
		<div class="err_msg">
			<!-- 文字数オーバーです -->
		</div>
		<label>
			メッセージ
			<textarea name="comment" cols=63 rows=10></textarea>
		</label>
		<div class="err_msg">
			<!-- 文字数オーバーです -->
		</div>
		<div class="btn-container" style="text-align: right;">
			<input type="submit" class="btn-primary btn-mid" value="保存">
		</div>
	</div>
</form>