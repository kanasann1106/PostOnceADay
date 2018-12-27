<?php
/*-------------------------
	ログイン認証・自動ログアウト
-------------------------*/
// ログインしている場合
if(!empty($_SESSION['login_date'])){
	debug('ログイン済みユーザーです。');

	// ログイン有効期限が超えていた場合
	if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()){
		debug('ログイン有効期限オーバーです。');

		// セッションを削除(ログアウト)しログインページへ
		session_destroy();
		header("Location:login.php");
	}else{
		debug('ログイン有効期限内です。');
		// 最終ログイン日時を現在日時に更新
		$_SESSION['login_date'] = time();
	}
}else{
	debug('未ログインユーザーです。');
	if(basename($_SERVER['PHP_SELF']) !== 'login.php'){
		header("Location:login.php");
	}
}