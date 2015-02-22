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

Feel free to submit your own pull requests with your own requests, but please see the [CONTRIBUTING.md](https://github.com/AJAX-Chat/ajax-chat-plugins/tree/master/CONTRIBUTING.md) before you do.

Note: The included example CustomAJAXChat.php is just there to show structure. Do not use this, as I can't guarantee it will work.
