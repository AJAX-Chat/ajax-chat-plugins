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
###/xkcd
=================

This gets comics from XKCD.com.

Valid usage:
    /xkcd
    /xkcd new
    /xkcd rand
    /xkcd 241
    /xkcd 1
    /xkcd 49

This has precautions put in place to prevent severe lag from 404s.

###/stock
=================

This fetches stock data from the Yahoo! stock API. 

Valid usage:
    /stock FB
    /stock GOOG
    /stock C

=================

Feel free to submit pull requests with improvements.