case '/sc':
    $scapikey = 'YOUR_API_KEY_GOES_HERE';
    $scUrl = 'http://api.soundcloud.com/resolve.json?url='.urlencode($textParts[1]).'&client_id='.$scapikey;
    $scJson = json_decode(file_get_contents($scUrl),TRUE);
    $name = $scJson["user"]["username"]." - ".$scJson["title"];
    $link = $scJson["permalink_url"];
    $named_link = "[url=".$link."]".$name."[/url]";
    $say = $this->getUserName().' suggested this song: '.$named_link;
    if(!$scJson["errors"]) {
        $this->insertChatBotMessage( $this->getChannel(), $say);
    } else {
        $this->insertChatBotMessage( $this->getPrivateMessageID(),"[i][color=red]Error: No URL Supplied[/color][/i]");
    }
    return true;
default:
    return false;