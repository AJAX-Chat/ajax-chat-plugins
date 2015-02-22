<?PHP
////////////////////////////////////////////////////////////////////////////////
// MYSQL connection - this is needed!!!
////////////////////////////////////////////////////////////////////////////////
include_once('../../php/include.php');
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
// here STARTS the default stuff
////////////////////////////////////////////////////////////////////////////////
class CustomAJAXChat extends AJAXChat {
//
// Initialize custom configuration settings
function initCustomConfig() {
		global $db;

		// Use the existing phpBB database connection:
		$this->setConfig('dbConnection', 'link', $db->db_connect_id);
		}

		// Initialize custom request variables:
		function initCustomRequestVars() {
			global $user;

			// Auto-login phpBB users:
			if(!$this->getRequestVar('logout') && ($user->data['user_id'] != ANONYMOUS)) {
			$this->setRequestVar('login', true);
		}
}

// Replace custom template tags:
function replaceCustomTemplateTags($tag, $tagContent) {
		global $user;

		switch($tag) {
		default:
		return null;
		}
}

// Returns true if the userID of the logged in user is identical to the userID of the authentication system
// or the user is authenticated as guest in the chat and the authentication system
function revalidateUserID() {
	global $user;

	if($this->getUserRole() === AJAX_CHAT_GUEST && $user->data['user_id'] == ANONYMOUS || ($this->getUserID() === $user->data['user_id'])) {
		return true;
		}
return false;
}

// Returns an associative array containing userName, userID and userRole
// Returns null if login is invalid
function getValidLoginUserData() {
	global $auth,$user;

	// Return false if given user is a bot:
	if($user->data['is_bot']) {
		return false;
	}

	// Check if we have a valid registered user:
	if($user->data['is_registered']) {
		$userData = array();
		$userData['userID'] = $user->data['user_id'];

		$userData['userName'] = $this->trimUserName($user->data['username']);

		if($auth->acl_get('a_'))
			$userData['userRole'] = AJAX_CHAT_ADMIN;
		elseif($auth->acl_get('m_'))
			$userData['userRole'] = AJAX_CHAT_MODERATOR;
		else
			$userData['userRole'] = AJAX_CHAT_USER;

			return $userData;

	} else {
		// Guest users:
		return $this->getGuestUser();
	}
}

// Store the channels the current user has access to
// Make sure channel names don't contain any whitespace
function &getChannels() {
	if($this->_channels === null) {
		global $auth;

		$this->_channels = array();

		$allChannels = $this->getAllChannels();

		foreach($allChannels as $key=>$value) {
			// Check if we have to limit the available channels:
			if($this->getConfig('limitChannelList') && !in_array($value, $this->getConfig('limitChannelList'))) {
			continue;
			}

			// Add the valid channels to the channel list (the defaultChannelID is always valid):
			if($value == $this->getConfig('defaultChannelID') || $auth->acl_get('f_read', $value)) {
				$this->_channels[$key] = $value;
			}
		}
	}
	return $this->_channels;
}

// Store all existing channels
// Make sure channel names don't contain any whitespace
function &getAllChannels() {
	if($this->_allChannels === null) {
		global $db;

		$this->_allChannels = array();

		// Get valid phpBB forums:
		$sql = 'SELECT
		forum_id,
		forum_name
		FROM
		'.FORUMS_TABLE. '
		WHERE
		forum_type=1
		AND
		forum_password=\'\';';

		$result = $db->sql_query($sql);

		$defaultChannelFound = false;

		while ($row = $db->sql_fetchrow($result)) {
			$forumName = $this->trimChannelName($row['forum_name']);

			$this->_allChannels[$forumName] = $row['forum_id'];

			if(!$defaultChannelFound && $row['forum_id'] == $this->getConfig('defaultChannelID')) {
				$defaultChannelFound = true;
			}
		}
		$db->sql_freeresult($result);

		if(!$defaultChannelFound) {
			// Add the default channel as first array element to the channel list:
			$this->_allChannels = array_merge(
			array(
			$this->trimChannelName($this->getConfig('defaultChannelName'))=>$this->getConfig('defaultChannelID')
			),
			$this->_allChannels
			);
		}
	}
	return $this->_allChannels;
}

// Method to set the style cookie depending on the phpBB user style
function setStyle() {
	global $config,$user,$db;

	if(isset($_COOKIE[$this->getConfig('sessionName'). '_style']) && in_array($_COOKIE[$this->getConfig('sessionName'). '_style'], $this->getConfig('styleAvailable')))
		return;

	$styleID = (!$config['override_user_style'] && $user->data['user_id'] != ANONYMOUS) ? $user->data['user_style'] : $config['default_style'];
	$sql = 'SELECT
	style_name
	FROM
	'.STYLES_TABLE. '
	WHERE
	style_id = \'' . $db->sql_escape($styleID). '\';';
	$result = $db->sql_query($sql);
	$styleName = $db->sql_fetchfield('style_name');
	$db->sql_freeresult($result);

	if(!in_array($styleName, $this->getConfig('styleAvailable'))) {
		$styleName = $this->getConfig('styleDefault');
	}

	setcookie(
	$this->getConfig('sessionName'). '_style',
	$styleName,
	time()+60*60*24*$this->getConfig('sessionCookieLifeTime'),
	$this->getConfig('sessionCookiePath'),
	$this->getConfig('sessionCookieDomain'),
	$this->getConfig('sessionCookieSecure')
	);
return;
}


function parseCustomCommands($text, $textParts) {

if($this->getUserRole() == AJAX_CHAT_ADMIN || $this->getUserRole() == AJAX_CHAT_MODERATOR || $this->getUserRole() == AJAX_CHAT_USER || $this->getUserRole() == AJAX_CHAT_GUEST) {
	switch($textParts[0]) {
	case '/says':
		$say = str_replace('/says', '', $text);
		$this->insertChatBotMessage( $this->getChannel(), "[i]" . $say . "[/i]" );
		return true;
	default:
		return false;
//
////////////////////////////////////////////////////////////////////////////////
// here ENDS the default stuff
////////////////////////////////////////////////////////////////////////////////
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = true, $atts = array() ) {
   $url = 'http://www.gravatar.com/avatar/';
   $url .= md5( strtolower( trim( $email ) ) );
   $url .= "?s=$s&d=$d&r=$r";
   if ( $img ) {

      //$url = '<img src="' . $url . '"';
      //foreach ( $atts as $key => $var )
         //$url .= ' ' . $key . '="' . $var . '"';
      //$url .= ' />';

      $url = '[img]' . $url;
      foreach ( $atts as $key => $var )
         $url .= ' ' . $key . '="' . $var . '"';
      $url .= '[/img]';
   }
   return $url;
}

////////////////////////////////////////////////////////////////////////////////
// here STARTS the CUSTOM stuff
////////////////////////////////////////////////////////////////////////////////

case '/hypem':
//
$hypec = explode(" ",$text); //Still too lazy to use text parts
switch ($hypec[1]) {
	case 'genre':  // Get Hype Machine Stuff by Genre.
		$genre = str_replace("/hypem genre ", "", $text); // Lazy man's way of getting the genre.
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/tags/$genre/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-1);
		$thumburl = str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']);//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$itunesurl = str_replace("\\", "", $hypej[$songnum]['itunes_link']); //Grab the iTunes link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
		$hypemsn = str_replace("+","",$hypej[$songnum]['title']);
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
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $itunesurl;
		$say .= ']iTunes[/url]';
		break;
	case 'search': // Get Hype Machine Stuff by Searching
		//$songnum = rand(0,29);
		$searchterm = str_replace("/hypem search ", "", $text); // Lazy man's way of getting the search.
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/search/$searchterm/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-1); //Get the maximum random number by counting the elements non recursively in the json array.
		$thumburl = str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']);//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$itunesurl = str_replace("\\", "", $hypej[$songnum]['itunes_link']); // Grab the iTunes link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
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
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $itunesurl;
		$say .= ']iTunes[/url]';
		break;
	case 'artist': // Get Hype Machine Stuff by Artist
		$artistname = str_replace("/hypem artist ", "", $text); // Lazy man's way of getting the search.
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/artist/$artistname/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-1); // Get the maximum random number by counting the number of elements in the array nonrecursively
		$thumburl = !empty($hypej[$songnum]['thumb_url_medium']) ? str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']) : $hypej[$songnum]['thumb_url'];//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$itunesurl = str_replace("\\", "", $hypej[$songnum]['itunes_link']); // Grab the iTunes link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
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
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $itunesurl;
		$say .= ']iTunes[/url]';
		break;
	case 'popular': // Get Popular Hype Machine Stuff
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/popular/3day/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-1); // Get the maximum random number by counting the number of elements in the array nonrecursively
		$thumburl = !empty($hypej[$songnum]['thumb_url_medium']) ? str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']) : $hypej[$songnum]['thumb_url'];//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$itunesurl = str_replace("\\", "", $hypej[$songnum]['itunes_link']); // Grab the iTunes link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
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
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $itunesurl;
		$say .= ']iTunes[/url]';
		break;
	case 'new':  // Get New Hype Machine Stuff
		$hypej = json_decode(file_get_contents("http://hypem.com/playlist/latest/all/json/1/data.js"),TRUE); // Let's get that JSON data.
		$songnum = rand(0,count($hypej)-1); // Get the maximum random number by counting the number of elements in the array nonrecursively
		$thumburl = !empty($hypej[$songnum]['thumb_url_medium']) ? str_replace("\\", "", $hypej[$songnum]['thumb_url_medium']) : $hypej[$songnum]['thumb_url'];//Get the thumbnail image
		$posturl = str_replace("\\", "", $hypej[$songnum]['posturl']);//Get the blog post
		$itunesurl = str_replace("\\", "", $hypej[$songnum]['itunes_link']); // Grab the iTunes link for good measure
		$songlength = 0 + $hypej[$songnum]['time']; // String to int conversion
		$songlength = gmdate("i:s",$songlength); //Change number of seconds into Minute:Second Format for prettiness
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
		$say .= $hypej[$songnum]['artist'];
		$say .= "+-+";
		$say .= $hypemsn;
		$say .= ']Hype Machine[/url] - [url=';
		$say .= $posturl;
		$say .= ']';
		$say .= $hypej[$songnum]['sitename'];
		$say .= '[/url] - [url=';
		$say .= $itunesurl;
		$say .= ']iTunes[/url]';
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

case '/xkcd':

	$xkcds = explode(" ",$text); //Forgot to use textParts
	$xkcds[1] = stristr($xkcds[1], ".") ? substr($xkcds[1],0,strpos($xkcds[1], ".")) : $xkcds[1]; //Let's make sure nobody's trying to fetch decimals.
	if(empty($xkcds[1])||$xkcds[1]=="new") { //Both these get the newest comic
		$xkjson = json_decode(file_get_contents("http://xkcd.com/info.0.json"),TRUE); //Get and parse the newest comic's JSON data
	}
	else if($xkcds[1]=="rand"){ //This gets a random comic
		$randnum = json_decode(file_get_contents("http://xkcd.com/info.0.json"),TRUE); //Get the latest comic JSON data
		$randnum = $randnum['num']; //This sets the max rand number
		$randnum = mt_rand(1,$randnum); //Every day I'm shufflin'
		$xkjson = json_decode(file_get_contents("http://xkcd.com/".$randnum."/info.0.json"),TRUE); //Get the random comic's JSON data and parse it
	}
	else if(is_numeric($xkcds[1])) { //Makes sure it's a number.
		$maxnum = json_decode(file_get_contents("http://xkcd.com/info.0.json"),TRUE); //Newest Comic Data
		$maxnum = $maxnum['num']; //Highest comic number
		if($xkcds[1]>$maxnum || $xkcds[1]<=0) { //Make sure it's not oustide the range, one way or the other
			$xkcderror = TRUE; //Sets an error
			$xkerrortext = "\nERROR: This comic either hasn't been invented yet, or never will be."; //Error Message
		}
		else {
			$xkjson = json_decode(file_get_contents("http://xkcd.com/".$xkcds[1]."/info.0.json"),TRUE); //Do eet!
		}
	}
	else { //All unhandled errors
		$xkcderror = TRUE; //Sets an error
		$xkerrortext = " doesn't know how to use /xkcd.\nUsage: '/xkcd <new/rand/[num]>' where [num] is a valid XKCD number"; //Error Message
	}
	if(!$xkcderror) { //If there wasn't an error...
	  /************************************************************************************************************************\
		** Let's concatenate this string.                                                                                       *|
		** XKCD JSON Variables:                                                                                                 *|
		** "day" : The day it was published on.                                                                                 *|
		** "month" : The month it was published in (int).                                                                       *|
		** "year" : The year it was published in.                                                                               *|
		** "num" : The unique comic ID.                                                                                         *|
		** "link" : Not sure.^1                                                                                                 *|
		** "news" : Any news sharing the day with the comic.^1                                                                  *|
		** "title" : The human readable title.                                                                                  *|
		** "safe_title" : The title stripped of special characters.                                                             *|
		** "transcript" : A description of the action happening in the comic.^1                                                 *|
		** "img" : The image URL with slashes escaped.                                                                          *|
		**                                                                                                                      *|
		** ^1 = Not every comic has this parameter set. empty() could be your best friend if you want to try and include these. *|
		\************************************************************************************************************************/
		//TODO Parse escaped HTML entities such as &eacute;
		$say = "\n[img]".str_replace("\\", "", $xkjson['img'])."[/img]\nXKCD #".$xkjson['num'].": [url=http://xkcd.com/".$xkjson['num']."/]".$xkjson['title']."[/url] on ".$xkjson['month']."/".$xkjson['day']."/".$xkjson['year']."\n[i]".$xkjson['alt']."[/i]"; //Outputs the parsed JSON data.
	}
	else { //But if there was an error...
		$say = $xkerrortext; //Set the error text as what to be said by the chatbot.
	}

	$this->insertChatBotMessage( $this->getChannel(), $this->getUserName().$say);//Say it with the username (Included so spammers can be easily detected)

	return true; //Fin
default:
	return false;
				break;
			}
		}
	}
}
//
