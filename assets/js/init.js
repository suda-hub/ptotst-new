$(function(){
	// スムーススクロール
	smoothscroll();
});

const smoothscroll = () => {
	$('a[href^="#"]').click(function(){
		const speed = 500,
		href= $(this).attr("href"),
		target = $(href == "#" || href == "" ? 'html' : href),
		position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
			return false;
	});
}