<?php
/* Jedipedia links by --miki--@Jedipedia */

class jplinks extends module {
	public $title = "Jedipedia functions";
	public $author = "--miki--@Jedipedia";
	public $version = "1.5";
	
	/* link function */
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
			case "!wiki":
				$link = "http://fi.starwars.shoutwiki.com/wiki/";
				break;
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
				$link = "http://darth.uncyclomedia.co/wiki/";
				break;
			case "!wp":
				$link = "https://fi.wikipedia.org/wiki/";
				break;
			case "!hiki":
				$link = "http://hikipedia.info/wiki/";
				break;
			case "!wikia":
				$link = "https://starwars.fandom.com/fi/wiki/";
				break;
			case "!fandom":
				$link = "https://starwars.fandom.com/fi/wiki/";
				break;
		}
		/* define page, replace spaces by underscores */
		$page = str_replace(" ", "_", $args['query']);
		/* return full URL */
		$this->ircClass->privMsg($line['to'], $link.$page);
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
		$this->ircClass->privMsg($line['to'], "ashley, miki, xwing");
	}
	
	public function hiall($line)
	{
		// todo
	}
}

?>