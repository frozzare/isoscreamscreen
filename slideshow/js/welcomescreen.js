var jsonObj = {};
var jsonUrl = "welcomescreen.json";


$( document ).ready(function() {
	loadJson(jsonUrl);
	//loadJson("http://162.13.12.91/");
});



/**
 * Load JSON-data with slider data content
 */
function loadJson(url) {



	var htmlSection = "";

	$.getJSON(url)
		.done(function( data ) {

			jsonObj = data.content;


			$.each( data.content, function( i, item ) {

				// nested slides
				if(item.items.length > 1){
					htmlSection += "<section>";
				}

				$.each( item.items, function( j, sectionItem ) {

					switch(sectionItem.template)
					{
						case "img":
							htmlSection += getImgSection(j, sectionItem);
							break;
						case "mov":
							htmlSection += getMovSection(j, sectionItem);
							break;
						case "url":
							htmlSection += getUrlSection(j, sectionItem);
							break;
						default:
							htmlSection += getDefaultSection(j, sectionItem);
							break;
					}
				});

				if(item.items.length > 1){
					htmlSection += "</section>";
				}

			});


			//$( ".slides" ).empty();
			$( ".slides" ).append( htmlSection );

			console.log("Reveal " + isInitialized); //Reveal.isLastSlide();

			if(!isInitialized) startReveal();
			else{
				startSliderTimer();
			}
			console.log("Reveal " + isInitialized); //Reveal.isLastSlide();

		})
		.fail(function() {
			console.log( "error" );
		});

}

function getImgSection(nr, item) {
	var section =  "<section data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\">"
	section += "<div class=\"overview\" style=\"display: none;\"><h2>"
	if(nr==0) section += item.title;
	section +="</h2></div>";
	section += "<div class=\"content\"><img src =\"" + item.imgUrl + "\"></div>";
	section	+= "</section>"

	return section;
}

function getMovSection(nr, item) {
	var section =  "<section data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\">"
	section += "<div class=\"overview\" style=\"display: none;\"><h2>"
	if(nr==0) section += item.title;
	section +="</h2></div>";
	section += "<iframe data-autoplay src=\"" + item.url + "\" frameborder=\"0\" allowfullscreen></iframe>";
	section += "</section>"

	return section;

}

function getUrlSection(nr, item) {
	var section =  "<section data-autoslide=\"10000\"  data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\">"
	section += "<div class=\"overview\" style=\"display: none;\"><h2>"
	if(nr==0) section += item.title;
	section +="</h2></div>";
	section += "<iframe class=\"stretch\" width='1080px' height='2420px' src=\"" + item.url + "\" ></iframe>"
	section += "</section>"

	return section;
}

function getDefaultSection(item) {
	//var section =  "<section data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\"></section>"
}
