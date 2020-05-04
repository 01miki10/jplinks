<?php
/**
 * Jedipedia functions 
 * @author --miki--@Jedipedia
 * @version 2.0
 * @license GPL 3.0 or later
 */

class jplinks extends module {
	public $title = "Jedipedia functions";
	public $author = "--miki--@Jedipedia";
	public $version = "2.0";
	
	/* link functions */
	public function wikilink($line, $args)
	{
		/* return instructions, if no arguments */
		if ($args['nargs'] < 1)
		{
			$this->ircClass->notice($line['fromNick'], 'Käyttö: !wiki <sivu>');
			return;
		}
		/* define URL based on channel */
		switch ($line['to'])
		{
			case "#wookieepedia":
				$link = "https://starwars.fandom.com/wiki/";
				break;
			case "#darthipedia":
				$link = "https://darthipedia.com/wiki/";
				break;
			case "#greedopedia":
				$link = "http://fi.darth.shoutwiki.com/wiki/";
				break;
			case "#shoutwiki":
				$link = "http://www.shoutwiki.com/wiki/";
				break;
			default:
				$link = "http://fi.starwars.shoutwiki.com/wiki/";
				break;
		}
		$page = $this->parseTitle($args['query']);
		/* return full URL */
		$this->ircClass->privMsg($line['to'], $link.$page);
	}
	public function makelink($line, $args)
	{
		/* return instructions, if no arguments */
		if ($args['nargs'] < 1)
		{
			$this->ircClass->notice($line['fromNick'], 'Käyttö: '.$args['cmd'].' <sivu>');
			return;
		}
		
		/* define URL based on command */
		switch ($args['cmd'])
		{
			case "!jedi":
				$link = "http://fi.starwars.shoutwiki.com/wiki/";
				break;
			case "!fanon":
				$link = "http://fi.swfanon.shoutwiki.com/wiki/";
				break;
			case "!greedo":
				$link = "http://fi.darth.shoutwiki.com/wiki/";
				break;
			case "!wook":
				$link = "https://starwars.fandom.com/wiki/";
				break;
			case "!dewiki":
				$link = "https://www.jedipedia.net/wiki/";
				break;
			case "!ossus":
				$link = "http://www.ossus.pl/biblioteka/";
				break;
			case "!darth":
				$link = "https://darthipedia.com/wiki/";
				break;
			case "!wp":
				$link = "https://fi.wikipedia.org/wiki/";
				break;
			case "!hiki":
				$link = "http://hikipedia.info/wiki/";
				break;
			case "!wikia":
			case "!fandom":
				$link = "https://starwars.fandom.com/fi/wiki/";
				break;
			/* this should never be executed, but just in case */
			default:
				$this->ircClass->privMsg($line['to'], "Tunnistamaton komento");
				return;
		}
		$page = $this->parseTitle($args['query']);
		/* return full URL */
		$this->ircClass->privMsg($line['to'], $link.$page);
	}
	
	/* replace spaces by underscores */
	private function parseTitle($page) {
		return str_replace(" ", "_", $page);
	}
	
	public function kriff($line, $args)
	{
		if ($args['nargs'] < 1)
		{
			$this->ircClass->privMsg($line['to'], "Kriff mitä sithiä!");
		}
		else
		{
			$this->ircClass->privMsg($line['to'], $args['query'].", kriff mitä sithiä!");
		}
	}
	
	public function no($line)
	{
		$this->ircClass->privMsg($line['to'], "NOOOOOOOOO!");
	}
	
	public function admins($line)
	{
		/* only #jedipedia for now */
		if ($line['to'] != "#jedipedia") {
			return;
		}
		/* FIXME: should probably be stored in a separate file instead of hardcoded value */
		$this->ircClass->privMsg($line['to'], "ashley, miki, xwing");
	}
	
	public function hiall($line)
	{
		$members = $this->ircClass->getChannelData($line['to'])->$memberList;
		$message = "Hei ";
		foreach ($members as $nick) {
			/* ignore ChanServ and bot itself */
			if ($nick == "ChanServ" || $nick == $this->ircClass->getNick()) {
				return;
			} else {
				$message = $message.$nick.", ";
			}
		}
		$this->ircClass->privMsg($line['to'], $message);
	}
}

?>