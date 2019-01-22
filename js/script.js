$(function(){
	// 投稿一覧から投稿詳細ページへ遷移
	var $post = $('.js-post-click') || null;
	if($post !== null){
		$post.on('click',function(){
			var postId = $(this).data('postid');
			window.location.href = 'postDetail.php?p_id=' + postId;
		});
	}else{
		window.location.href = 'index.php';
	}
	
	// 文字数カウンター
	$('#js-countup').on('keyup', function(e){
		var count = $(this).val().replace(/\n/g, '').length; //改行は文字数に含めない
		$('#js-countup-view').html(count);
	});

	// 画像ライブプレビュー
	var $dropArea = $('.js-area-drop');
	var $fileInput = $('.input-file');
	$dropArea.on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css('border', '3px #ccc dashed');
	});
	$dropArea.on('dragleave', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css('border', 'none');
	});
	$fileInput.on('change', function(e){
		$dropArea.css('border', 'none');
		var file =this.files[0],
				$img = $(this).siblings('.prev-img'),
				fileReader = new FileReader();

		fileReader.onload =function(event){
			$img.attr('src', event.target.result).show();
		};

		fileReader.readAsDataURL(file);
	});
	// いいね機能
	var $good = $('.btn-good'),
			goodPostId;

	$good.on('click',function(e){
		if(login_flg){
			e.stopPropagation();
			var $this = $(this);
			goodPostId = $this.parents('.post').data('postid'); //投稿ID取得
			$.ajax({
				type: 'POST',
				url: 'ajaxGood.php',
				data: { postId: goodPostId}
			 }).done(function(data){
			 		console.log('Ajax Success');

			 		// いいねの総数を表示
					$this.children('span').html(data);
					// いいね取り消しのスタイル
					$this.children('i').toggleClass('far'); //空洞ハート
					// いいね押した時のスタイル
					$this.children('i').toggleClass('fas'); //塗りつぶしハート
					$this.children('i').toggleClass('active');
					$this.toggleClass('active');
				}).fail(function(msg) {
					console.log('Ajax Error');
				});
			}else{
				window.location.href = 'index.php';
			}
		
		});

	// スマホ画面のスライドメニュー
	var $menu_btn = $('.js-menu-slide'),
			$menulist = $('#js-menulist');

	$menu_btn.on('click', function(){
		$menulist.toggleClass('right-slide');
	});
});
