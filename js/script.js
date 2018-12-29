$(function(){

	// 投稿一覧から投稿詳細へ遷移
	$('.post').on('click',function(){
		location.href = 'postDetail.php';
	});

	// 文字数カウンター
	$('#js-countup').on('keyup', function(e){
		var count = $(this).val().replace(/\n/g, '').length; //改行は文字数に含めない
		$('#js-countup-view').html(count);
	});

});