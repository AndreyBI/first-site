/*

*/
(function($){
	$.fn.myPreloadImg = function(options){
		// параметры плагина
		options = $.extend({
			preloaderImg: "./preloader.gif" // путь до прелоадера
		}, options);
		
		// действия после загрузки картинки
		function finish_load(){
			// убираем прелоадер,
			// выводим картинку
			// и даляем однопиксельную картинку
			var elementImg = $(this);
			var imgSrc = $(this).attr('img_src');
			elementImg.attr('src', imgSrc);
			elementImg.attr('img_src', '');
			$('img').each(function(){
				if($(this).attr('img_src') == elementImg.attr('src')){
					$(this).attr('src', elementImg.attr('src'));
					elementImg.remove();
				}
			});
		}
		
		// действия при вызове плагина
		var make = function(){
			var element = $(this);
			var imgSrc = element.attr('src');	
			element.attr('img_src', imgSrc);
			element.attr('src', options.preloaderImg);
			// создаем пиксель и прячем его с глаз долой :) 
			// пока картинка не прогрузится
			var hideImg = $('<img>', {
				src: imgSrc,
				style: 'position: absolute; top: -1px; left: -1px; width: 1px;'
			});
			$('body').append(hideImg);
			// указываем, что делать, когда спрятанная картинка прогрузится
			hideImg.bind('load', finish_load);
		};
 
		// метод myTestCarusel вернет объект jQuery обратно
		return this.each(make); 
	};
})(jQuery);