<?php
/**
 * Jedipedia functions 
 * @author 01miki10
 * @version 2.1
 * @copyright GPL 3.0 or later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

class jplinks extends module {
	public $title = "Jedipedia functions";
	public $author = "01miki10";
	public $version = "2.0";
	
	public function init() {
		$this->adminList = new ini("modules/jplinks/admins.ini");
	}
	
	/* link functions */
	public function wikilink($line, $args) {
		/* define URL based on channel */
		switch ($line['to']) {
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
				$link = "http://www.jedipedia.fi/wiki/";
				break;
		}
		$page = $this->parseTitle($args['query']);
		/* return full URL */
		$this->ircClass->privMsg($line['to'], $link.$page);
	}
	
	public function parseWikilink($line, $args) {
		if ($line['to'] == "#wookieepedia") {
			$link = "https://starwars.fandom.com/wiki/";
		} elseif ($line['to'] == "#jedipedia") {
			$link = "http://www.jedipedia.fi/wiki/";
		} else {
			return;
		}
		$linkReg = "\[\[[^\]]+\]\]";
		$templateReg = "\{\{[^\}]+\}\}";
		if (preg_match_all("/$linkReg/", $line['text'], $matches)) {
			foreach ($matches[0] as $match) {
				$page = str_replace("[[", "", $match);
				$page = str_replace("]]", "", $page);
				$page = $this->parseTitle($page);
				$this->ircClass->privMsg($line['to'], $link.$page);
			}
		}
		if (preg_match_all("/$templateReg/", $line['text'], $matches)) {
			foreach ($matches[0] as $match) {
				$page = str_replace("{{", "", $match);
				$page = str_replace("}}", "", $page);
				$page = $this->parseTitle($page);
				$this->ircClass->privMsg($line['to'], $link."Template:".$page);
			}
		}
	}
	
	public function makelink($line, $args) {
		/* define URL based on command */
		switch ($args['cmd'])
		{
			case "!jedi":
				$link = "http://www.jedipedia.fi/wiki/";
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
				$link = "https://hiki.pedia.ws/wiki/";
				break;
			case "!wikia":
			case "!fandom":
				$link = "https://starwars.fandom.com/fi/wiki/";
				break;
			case "!uncyc":
				$link = "https://en.uncyclopedia.org/wiki/";
				break;
			case "!brick":
			case "!lego":
				$link = "https://en.brickimedia.org/wiki/";
				break;
			case "!phab":
				$link = "https://phabricator.shoutwiki.com/";
				break;
			case "!mw":
				$link = "https://www.mediawiki.org/wiki/";
				break;
			case "!gerrit":
				$link = "https://gerrit.wikimedia.org/r/";
				break;
			/* this should never be executed, but just in case */
			default:
				$this->ircClass->privMsg($line['to'], "Unknown command");
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
	
	public function kriff($line, $args) {
		if ($line['to'] == '#jedipedia') {
			if ($args['nargs'] < 1) {
				$this->ircClass->privMsg($line['to'], "Kriff mitä sithiä!");
			} else {
				$this->ircClass->privMsg($line['to'], $args['query'].", kriff mitä sithiä!");
			}
		}
		else {
			if ($args['nargs'] < 1) {
				$this->ircClass->privMsg($line['to'], "Kriff this sith!");
			} else {
				$this->ircClass->privMsg($line['to'], $args['query'].", kriff this sith!");
			}
		}
	}
	
	public function no($line) {
		$this->ircClass->privMsg($line['to'], "NOOOOOOOOO!");
	}
	
	public function admins($line) {
		$admins = $this->adminList->getSection($line['to']);
		$message = "";
		if ($admins !== false) {
			foreach ($admins as $nick => $foo) {
				if ($message == "") {
					$message = $nick;
				} else {
					$message = $message.", ".$nick;
				}
			}
			$this->ircClass->privMsg($line['to'], $message);
		}
	}
	
	public function hiall($line) {
		$members = $this->ircClass->getChannelData($line['to'])->memberList;
		$message = "Hei";
		foreach ($members as $member) {
			/* ignore ChanServ and bot itself */
			if ($member->realNick != "ChanServ" && $member->realNick != $this->ircClass->getNick()) {
				$nick = $member->realNick;
				$message = $message.", ".$nick;
			}
		}
		$this->ircClass->privMsg($line['to'], $message."!");
	}
}

?>