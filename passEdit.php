<form action="" method="post" class="form" enctype="multipart/form-data">
<h2>パスワードを変更</h2>
<div class="form-wrap">
	<div class="err_msg">
		<!-- 登録できませんでした。 -->
	</div>

	<label>
		現在のパスワード（8文字以上）
		<input type="password" name="password">
	</label>
	<div class="err_msg">
		<!-- 文字数オーバーです -->
	</div>
	<label>
		新しいパスワード（8文字以上）
		<input type="password" name="password">
	</label>
	<div class="err_msg">
		<!-- 文字数オーバーです -->
	</div>
	<label>
		新しいパスワード再入力
		<input type="password" name="password_re">
	</label>
	<div class="err_msg">
		<!-- 文字数オーバーです -->
	</div>
	<div class="btn-container" style="text-align: right;">
		<input type="submit" class="btn-primary btn-mid" value="変更">
	</div>
</div>
</form>
