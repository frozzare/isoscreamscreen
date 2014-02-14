function startTime()
{
	var dateObj = humanDate();

	$('.iso_header h3').html(dateObj.day + " / " + dateObj.date + " " + dateObj.month + " / " + dateObj.time );
	t = setTimeout(function(){ startTime()}, 500 );
}

function checkTime(i)
{
	if (i<10)
	{
		i = "0" + i;
	}
	return i;
}

function humanDate () {
	var now = new Date();
	var h = now.getHours();
	var m = now.getMinutes();

	var s = now.getSeconds();
	// Add a zero in front of numbers<10

	m = checkTime(m);
	s = checkTime(s);

	var localTime = h + ":" + m + ":" + s;

	// ['Söndag','Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag'][now.getDay()]
	// ['Januari','Februari','Mars','April','Maj','Juni','Juli','Augusti','September','Oktober','November','December'][now.getMonth()]

	return {
		day: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][now.getDay()],
		date: now.getDate(),
		month: ['January','February','March','April','May','June','July','August','September','October','November','December'][now.getMonth()],
		time: localTime

	};
}


startTime();