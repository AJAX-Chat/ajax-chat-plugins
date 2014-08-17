case '/nsfw':
$text = str_replace('/nsfw ','',$text); //remove the "/nsfw " part

if ($text == "/nsfw") {	
			$say = " is not safe for work";
		} else {
			$say = "[img]" . $text . "#nsfw[/img]";	
		}
$this->insertChatBotMessage( $this->getChannel(), $this->getUserName(). $say );
	return true; 
default: 
	return false;