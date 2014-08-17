case '/stock':
//if(stristr($text, '/stock'))
{
	$stry = explode(" ", $text);
	$skey = array_search('/stock', $stry); //TODO Remove the array search to streamline it. No longer necessary
	$symbol = $stry[$skey+1];
	$stockapiurl = "http://finance.yahoo.com/d/quotes.csv?s=" . $symbol . "&f=nsb2vohgkjrc1p2"; //TODO Allow multiple symbols at once.
	$rtime = $_SERVER['REQUEST_TIME'];
	//$scsv = explode(",", file_get_contents($stockapiurl));
	//
	$results = file_get_contents($stockapiurl);
	// trying this to fix issue with stuff like FB, commas can cause issues in things like Facebook
	$results = str_replace(", "," ",$results);
	//
	// was THIS.. and it sorta works
	//$scsv = explode(',', file_get_contents($stockapiurl));
	// trying this out instead
	$scsv = explode(',', $results);
	$rtime = date('m/d/y - h:i:s A', $rtime); //Set the date and time
	//
	// these are just different formats for the date/time... remove if you want
	//$rtime = date('l, F jS, Y - h:i:s A', $rtime);
	//$rtime = date(DATE_RFC822, $rtime);
	//$rtime = date(DATE_ATOM, $rtime);
	//
	$volume = number_format($scsv[3], 0, '. ', ','); 
	//$say = $results;
	$say = "Stock quote for " . $scsv[0] . " at " . $rtime . ".\n Symbol: " . $scsv[1] . "\n Current bid: $" . $scsv[2] . " ($" . $scsv[10] . ")\n Percent Change: " . str_replace('"', '', $scsv[11]) . "Volume: " . $volume . "\n Open: $" . $scsv[4] . "\n High: $" . $scsv[5] . "\n Low: $" . $scsv[6] . "\n 52 Week High: $" . $scsv[7] . "\n 52 Week Low: $" . $scsv[8] . "\n P/E Ratio: " . $scsv[9];
	//
	$this->insertChatBotMessage($this->getChannel(), $say );
}
	return true; 
default: 
	return false; 