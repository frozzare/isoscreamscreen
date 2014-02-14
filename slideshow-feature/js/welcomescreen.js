$( document ).ready(function() {
	loadJson("welcomescreen.json");
});

/**
 * Load JSON-data with slider data content
 */
function loadJson(url) {

	var htmlSection = "";

	$.getJSON(url)
		.done(function( data ) {
	var markup = "";
			$.each( data.content, function( i, item ) {
					
				
			
				//markup += "<section data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\">";
					
			
				var bgUrl = item.bgrUrl;
				var title = item.title;
				var transition = item.transition;
				$.each( item.items, function( j, sectionItem ) {

					//console.log(j, sectionItem);
					
					switch(sectionItem.template)
					{
						case "img":
							markup += getImgSection(sectionItem, bgUrl, title, transition);
							break;
						case "mov":
							htmlSection += getMovSection(sectionItem);
							break;
						case "url":
							htmlSection += getUrlSection(sectionItem);
							break;
						default:
							htmlSection += getDefaultSection(sectionItem);
							break;
					}
				});
				
				//markup +="</section>"
			});

			//console.log(htmlSection);
			//$( ".slides" ).append( markup );

			startReveal();

		})
		.fail(function() {
			console.log( "error" );
		});

}

function getImgSection(item, bgUrl, title, transition) {
	return "<section data-background=\"" + bgUrl + "\" data-background-transition=\"" + transition + "\"><div class='overview' style='display:none'><h2>" + title + "</h2></div><div class='content'><img src="+ item.imgUrl +" alt='lol'/></div></section>"
}

function getMovSection(item) {
	return ""
	//console.log("<section data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\">" + <iframe width="1024" height="576" src="//www.youtube.com/embed/32UGD0fV45g" frameborder="0" allowfullscreen></iframe> + "</section>");
	//console.log("mov - " + item.bgrUrl);
}

function getUrlSection(item) {
	return ""
	//console.log("url - " + item.bgrUrl);
}

function getDefaultSection(item) {
	return ""
	//console.log("default - " + item.bgrUrl);
}
