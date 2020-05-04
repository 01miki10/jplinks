Jedipedia functions (jplinks is a legacy name, originally it only had linking functions)

Miscellanous commands for Manick's PHP-IRC, used in #jedipedia on freenode. Shouldn't be difficult to port for other IRC bots, as it's very simple.

Installing:

Copy jplinks folder to php-irc/modules and add following to function.conf:
include modules/jplinks/jplinks.conf

If you have installed Commands module, add following instead:
include modules/jplinks/jplinks_commands_mod.conf

Licensed under GPL 3.0