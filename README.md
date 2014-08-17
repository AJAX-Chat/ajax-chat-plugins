ajax-chat-plugins
=================

Plugins for frug's Ajax Chat

This assumes you have the CustomAjaxChat.php file set up with the `parseCustomCommands()` function.

It should start out like this:

```php
function parseCustomCommands($text, $textParts) {

if($this->getUserRole() == AJAX_CHAT_ADMIN || $this->getUserRole() == AJAX_CHAT_MODERATOR || $this->getUserRole() == AJAX_CHAT_USER || $this->getUserRole() == AJAX_CHAT_GUEST) {
  switch($textParts[0]) {
```

Please look at the included example for more info, or [the wiki page](https://github.com/Frug/AJAX-Chat/wiki/Custom-irc-style-commands#server-side) for better details.

##Table of comments

* [XKCD](#xkcd)
* [Stock](#stock)
* [Hype Machine](#hypem)
* [NSFW](#nsfw)
* [Soundcloud](#sc)

###/xkcd

This gets comics from XKCD.com.


Valid usage:

    /xkcd
    /xkcd new
    /xkcd rand
    /xkcd <comic number>

Examples:

    /xkcd 241
    /xkcd 1
    /xkcd 49
    /xkcd new
    /xkcd rand

This has precautions put in place to prevent severe lag from 404s.

###/stock

This fetches stock data from the Yahoo! stock API. 

Valid usage:
    
    /stock <stock symbol>

Examples:

    /stock FB
    /stock GOOG
    /stock C

###/hypem

This'll pull track data from [The Hype Machine](http://hypem.com)

Valid usage:

    /hypem genre <genre name>
    /hypem search <search term>
    /hypem artist <artist name>
    /hypem popular
    /hypem new

Examples:

    /hypem genre dubstep
    /hypem search party rock
    /hypem artist C2C
    /hypem popular
    /hypem new

###/nsfw

This will blur NSFW images, only unblurring on mouseover.

Valid usage:

    /nsfw <image url>
    
Examples:

    /nsfw http://i.imgur.com/EXAMPLE.jpg
    /nsfw http://i.imgur.com/FORKS.jpg
    /nsfw http://i.imgur.com/SUSHI.jpg
    /nsfw http://i.imgur.com/BLAHB.jpg
    
###/sc

This'll pull details from a Soundcloud URL, and spit it back out as a recommendation.

Valid usage:

    /sc <soundcloud url>
    
Examples:

    /sc https://soundcloud.com/uponthebridge/blue-song
    /sc https://soundcloud.com/ricardo-silva-131/moving-day
    /sc https://soundcloud.com/stwosc/aura
    /sc http://snd.sc/1cZmAMW

Feel free to submit pull requests with improvements.

Note: The included example CustomAJAXChat.php is just there to show structure. Do not use this, as I can't guarantee it will work. 