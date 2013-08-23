case '/hypem':
//	
$hypec = explode(" ",$text); //Still too lazy to use text parts 
switch ($hypec[1]) {
	case 'genre':  // Get Hype Machine Stuff by Genre.
		$genre = str_replace("/hypem genre ", "", $text); // Lazy man's way of getting the genre.
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/tags/$genre/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-2);
		$thumburl = str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']);//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$youtubeurl = "https://www.youtube.com/search?q=".str_replace(" ", "+", $hypej[$songnum]['artist'])."+".str_replace(" ", "+", $hypej[$songnum]['title'])."/"; //Grab the YouTube link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
		$hypemsn = str_replace(" ","+",$hypej[$songnum]['title']);
		$hypemat = str_replace(" ", "+", $hypej[$songnum]['artist']);
		$say = 'Here\'s a '.$genre.' song '.$this->getUserName().":\n";
		$say .= $hypej[$songnum]['artist'];
		$say .= ' - ';
		$say .= $hypej[$songnum]['title'];
		$say .= "\n[img]";
		$say .= $thumburl;
		$say .= "[/img]\nLength: ";
		$say .= $songlength;
		$say .= "\nDescripton: ";
		$say .= $hypej[$songnum]['description'];
		$say .= "...\n[url=http://hypem.com/track/";
		$say .= $hypej[$songnum]['mediaid'];
		$say .= '/';
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $youtubeurl;
		$say .= ']YouTube[/url]';
		break;
	case 'search': // Get Hype Machine Stuff by Searching
		//$songnum = rand(0,29);
		$searchterm = str_replace("/hypem search ", "", $text); // Lazy man's way of getting the search.
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/search/$searchterm/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-2); //Get the maximum random number by counting the elements non recursively in the json array.
		$thumburl = str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']);//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$youtubeurl = "https://www.youtube.com/search?q=".str_replace(" ", "+", $hypej[$songnum]['artist'])."+".str_replace(" ", "+", $hypej[$songnum]['title'])."/"; // Grab the YouTube link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
		
		$hypemsn = str_replace(" ","+",$hypej[$songnum]['title']);
		$hypemat = str_replace(" ", "+", $hypej[$songnum]['artist']);
		$say = 'Here\'s a song that matched '.$searchterm. ' ' .$this->getUserName().":\n"; // All together now
		$say .= $hypej[$songnum]['artist'];
		$say .= ' - ';
		$say .= $hypej[$songnum]['title'];
		$say .= "\n[img]";
		$say .= $thumburl;
		$say .= "[/img]\nLength: ";
		$say .= $songlength;
		$say .= "\nDescripton: ";
		$say .= $hypej[$songnum]['description'];
		$say .= "...\n[url=http://hypem.com/track/";
		$say .= $hypej[$songnum]['mediaid'];
		$say .= '/';
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $youtubeurl;
		$say .= ']YouTube[/url]';
		break;
	case 'artist': // Get Hype Machine Stuff by Artist
		$artistname = str_replace("/hypem artist ", "", $text); // Lazy man's way of getting the search.
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/artist/$artistname/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-2); // Get the maximum random number by counting the number of elements in the array nonrecursively
		$thumburl = !empty($hypej[$songnum]['thumb_url_medium']) ? str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']) : $hypej[$songnum]['thumb_url'];//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$youtubeurl = "https://www.youtube.com/search?q=".str_replace(" ", "+", $hypej[$songnum]['artist'])."+".str_replace(" ", "+", $hypej[$songnum]['title'])."/"; // Grab the YouTube link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
		$hypemsn = str_replace(" ","+",$hypej[$songnum]['title']);
		$hypemat = str_replace(" ", "+", $hypej[$songnum]['artist']);
		$say = 'Here\'s a song by '.$artistname. ' ' .$this->getUserName().":\n";
		$say .= $hypej[$songnum]['artist'];
		$say .= ' - ';
		$say .= $hypej[$songnum]['title'];
		$say .= "\n[img]";
		$say .= $thumburl;
		$say .= "[/img]\nLength: ";
		$say .= $songlength;
		$say .= "\nDescripton: ";
		$say .= $hypej[$songnum]['description'];
		$say .= "...\n[url=http://hypem.com/track/";
		$say .= $hypej[$songnum]['mediaid'];
		$say .= '/';
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $youtubeurl;
		$say .= ']YouTube[/url]';
		break;
	case 'popular': // Get Popular Hype Machine Stuff
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/popular/3day/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-2); // Get the maximum random number by counting the number of elements in the array nonrecursively
		$thumburl = !empty($hypej[$songnum]['thumb_url_medium']) ? str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']) : $hypej[$songnum]['thumb_url'];//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$youtubeurl = "https://www.youtube.com/search?q=".str_replace(" ", "+", $hypej[$songnum]['artist'])."+".str_replace(" ", "+", $hypej[$songnum]['title'])."/"; // Grab the YouTube link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
		
		$hypemsn = str_replace(" ","+",$hypej[$songnum]['title']);
		$hypemat = str_replace(" ", "+", $hypej[$songnum]['artist']);
		$say = 'Here\'s what\'s hot now ' .$this->getUserName().":\n";
		$say .= $hypej[$songnum]['artist'];
		$say .= ' - ';
		$say .= $hypej[$songnum]['title'];
		$say .= "\n[img]";
		$say .= $thumburl;
		$say .= "[/img]\nLength: ";
		$say .= $songlength;
		$say .= "\nDescripton: ";
		$say .= $hypej[$songnum]['description'];
		$say .= "...\n[url=http://hypem.com/track/";
		$say .= $hypej[$songnum]['mediaid'];
		$say .= '/';
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $youtubeurl;
		$say .= ']YouTube[/url]';
		break;
	case 'new':  // Get New Hype Machine Stuff
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/latest/all/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-2); // Get the maximum random number by counting the number of elements in the array nonrecursively
		$thumburl = !empty($hypej[$songnum]['thumb_url_medium']) ? str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']) : $hypej[$songnum]['thumb_url'];//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$youtubeurl = "https://www.youtube.com/search?q=".str_replace(" ", "+", $hypej[$songnum]['artist'])."+".str_replace(" ", "+", $hypej[$songnum]['title'])."/"; // Grab the YouTube link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
		
		$hypemsn = str_replace(" ","+",$hypej[$songnum]['title']);
		$hypemat = str_replace(" ", "+", $hypej[$songnum]['artist']);
		$say = 'Here\'s what\'s new ' .$this->getUserName().":\n";
		$say .= $hypej[$songnum]['artist'];
		$say .= ' - ';
		$say .= $hypej[$songnum]['title'];
		$say .= "\n[img]";
		$say .= $thumburl;
		$say .= "[/img]\nLength: ";
		$say .= $songlength;
		$say .= "\nDescripton: ";
		$say .= $hypej[$songnum]['description'];
		$say .= "...\n[url=http://hypem.com/track/";
		$say .= $hypej[$songnum]['mediaid'];
		$say .= '/';
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $youtubeurl;
		$say .= ']YouTube[/url]';
		break;
	default:
		$say="Invalid syntax: Valid syntax is /hypem <genre genrename/search searchterm/artist artistname/popular/new>.";
		break;
	}
	//
	$this->insertChatBotMessage( $this->getChannel(), $say );
	return true;
default:
	return false; 
