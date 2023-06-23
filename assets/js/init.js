$(function(){

	/** 
	 * 共通パーツ
	 * スマホメニュー
	 */
	navigation();

	/** 
	 * 共通パーツ
	 * スムーススクロール
	 */
	// smoothscroll();
});

const navigation = () => {
	const head = $('.js-header'),
		menu = $('.js-header-menu');

	menu.on('click',function(){
		head.toggleClass('active');
	});
}

const smoothscroll = () => {
	$('a[href^="#"]').click(function(){
		const speed = 500;
		const href= $(this).attr("href");
		const target = $(href == "#" || href == "" ? 'html' : href);
		const position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});
}