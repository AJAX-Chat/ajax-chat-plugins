case '/nsfw':
$text = str_replace('/nsfw ','',$text); //remove the "/nsfw " part

if ($text == "/nsfw") {	
			$say = " is not safe for work";
		} else {
			$say = "[img]" . $text . "#nsfw[/img]";	// This appends the #nsfw fragment to the image, allowing the css rules 
													// supplied in nsfw.css to catch it, and apply the svg blur filter.
		}
$this->insertChatBotMessage( $this->getChannel(), $this->getUserName(). $say );
	return true; 
default: 
	return false;