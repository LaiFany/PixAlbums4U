$(document).ready(function(){
var header = $('body');

var backgrounds = new Array(
	'url(images/background_image.jpg)'
  , 'url(images/background_image3.jpg)'
  , 'url(images/background_image6.jpg)'
  , 'url(images/background_image2.jpg)'
);

var current = 0;

function nextBackground() {
    current++;
    current = current % backgrounds.length;
    header.css('background-image', backgrounds[current]);
}
setInterval(nextBackground, 10000);
var x = Math.floor(Math.random() * 3);
header.css('background-image', backgrounds[x]);
});