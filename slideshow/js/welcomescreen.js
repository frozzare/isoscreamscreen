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

			$.each( data.content, function( i, item ) {

				$.each( item, function( j, sectionItem ) {

					//console.log(j, sectionItem);

					switch(sectionItem.template)
					{
						case "img":
							htmlSection += getImgSection(sectionItem);
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
			});

			//console.log(htmlSection);
			$( ".slides" ).append( htmlSection );

			startReveal();

		})
		.fail(function() {
			console.log( "error" );
		});

}

function getImgSection(item) {
	return "<section data-background=\"" + item.bgrUrl + "\" data-background-transition=\"" + item.backgroundTransition + "\"></section>"
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
