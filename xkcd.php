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