
var sliderInterval;
var isInitialized;


function startReveal(){
	// Full list of configuration options available here:
	// https://github.com/hakimel/reveal.js#configuration
	Reveal.initialize({
		controls: false,
		progress: true,
		history: false,
		center: true,


		//autoSlide: 5000,
		loop: true,
		slideNumber:false,

		width: 1024,
		height: 1900,


		theme: 'night', //Reveal.getQueryHash().theme, // available themes are in /css/theme
		transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/fade/none

		// Transition style for full page slide backgrounds
		backgroundTransition: 'fade',
		transition: 'slides',
		// Parallax scrolling
		// parallaxBackgroundImage: 'https://s3.amazonaws.com/hakim-static/reveal-js/reveal-parallax-1.jpg',
		// parallaxBackgroundSize: '2100px 900px',

		// Optional libraries used to extend on reveal.js
		dependencies: [
			{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
				{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
				{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
				{ src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
				{ src: 'plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } },
				{ src: 'plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }
]
});

	isInitialized = true;

	startSliderTimer();

}


var indexv, lastindexv;

function updateCounter(){
	var str = Reveal.getIndices().v + 1 + " av " + jsonObj[Reveal.getIndices().h].items.length;

	$('.iso_footer h3.sectioncounter').html(str);
	$('.iso_footer h3.sectionname').html(jsonObj[Reveal.getIndices().h].items[Reveal.getIndices().v].title);
	}

function startSliderTimer(){

	updateCounter();

	indexv = Reveal.getIndices().v;
	lastindexv = indexv;

	var timerValue = (jsonObj[Reveal.getIndices().h].items[Reveal.getIndices().v].timer)*1000;

	sliderInterval = setInterval(nextSlide, timerValue);
}

function nextSlide(){

	Reveal.down();

	if(lastindexv == indexv){

		if(Reveal.isLastSlide()){
			console.log("lastslide");
			stopSliderTimer();

			//location.reload();
			// Reveal.togglePause();
			loadJson("http://dev.wordpress.org/", true);
		}

		nextZoomOutSlide();
	}
	else{
		lastindexv = indexv;

		stopSliderTimer();

		var timerValue = (jsonObj[Reveal.getIndices().h].items[Reveal.getIndices().v].timer)*1000;

		sliderInterval = setInterval(nextSlide, timerValue);
	}

}

function nextZoomOutSlide(){
	stopSliderTimer();
	startZoomOutTimer();

	Reveal.toggleOverview();
}

function startZoomOutTimer(){
	sliderInterval = setInterval(nextOverviewSlide, 1500);
}

function nextOverviewSlide(){
	stopSliderTimer();
	Reveal.next();
	startZoomInTimer();
}

function startZoomInTimer(){
	sliderInterval = setInterval(nextZoomInSlide, 1500);
}

function nextZoomInSlide(){
	stopSliderTimer();
	startSliderTimer();
	Reveal.toggleOverview();
}



function stopSliderTimer(){
	window.clearInterval(sliderInterval);
}




Reveal.addEventListener( 'slidechanged', function( event ) {
	indexv = event.indexv;

	updateCounter();
} );



/*
,
{
	"title": "Vilka är vi",
	"bgrUrl": "img/common/screen_bg_green.png",
	"backgroundTransition": "slide",
	"template": "url",
	"url": "http://www.youtube.com/embed/9W82sMSMJJg?feature=player_detailpage",
	"timer":5
}
*/