<?php

// if not exists set pwdstyle
Setting::write('pwdstyle', '(\w|\d){5,}', 'Password complexity (regex)', false); //
Setting::write('systememail', 'noreply@sea-wars.de', 'System Email Address', false); //

TemplateClasses::add('login');

/**
 * Userlogin, maybe this can be moved to spieler sometime
 */
class Login extends AbstractNoNavigationClass {

	function getMainLayout() {
		return 'login_logout';
	}

	/**
	 * is there a player with that name?
	 * @username	username
	 * @return		true/false
	 */
	function playerExists($username) {
		global $mysql;
		$username = $mysql->escape($username);
		$array = $mysql->executeSql("SELECT id, username FROM spieler WHERE username='" . $username . "';");
		return (!empty($array));
	}

	/**
	 * is there a player with that email?
	 * @email	email
	 * @return	true/false
	 */
	function emailExists($email) {
		global $mysql;
		$email = $mysql->escape($email);
		$array = $mysql->executeSql("SELECT id, username FROM spieler WHERE email='" . $email . "';");
		return (!empty($array));
	}

	/**
	 * check passwordstyle of given password
	 * @param	String	$password	password as String
	 * @return	boolean	true if correct, false if not
	 */
	function checkpasswordstyle($password) {
		$pattern = Setting::read('pwdstyle', '');
		if (!empty($pattern))
			if (!preg_match('/' . $pattern . '/', $password))
				return false;
			else
				return true;
		return true;
	}

	/**
	 * register player
	 * redirect to login or show error
	 */
	function register2(& $vars) {
		global $mysql;
		if (isset($vars['username']))
			Session :: setCookie('register_username', $vars['username']);
		if (isset($vars['password']))
			Session :: setCookie('register_password', $vars['password']);
		if (isset($vars['password2']))
			Session :: setCookie('register_password2', $vars['password2']);
		if (isset($vars['email']))
			Session :: setCookie('register_email', $vars['email']);
		if ($vars['password'] != $vars['password2'])
			$error .= 'Passwörter nicht gleich<br>';
		if (!$this->checkpasswordstyle($vars['password']))
			$error .= 'Passwort zu einfach<br>';
		if ($this->playerExists($vars['username']))
			$error .= 'Benutzername bereits vergeben<br>';
		if ($this->emailExists($vars['email']))
			$error .= 'Email bereits vergeben<br>';
		if (isset($error))
			$target = "index.php?class=login&method=register&error=$error";
		else {
			$spieler = new Spieler();
			$spieler->set("username", $vars['username']);
			$spieler->set("password", myencrypt($vars['password']));
			$spieler->set("email", $vars['email']);
			$spieler->set("hash", md5(randomstring(10)));
			$spieler->store();
			$spieler_id = $spieler->get('id');
			// hier email vorbereiten mit confirm link
			// und an spieler verschicken
			$link = Setting::read('baseurl') . "?class=login&method=confirm&spieler_id=$spieler_id&hash=" . $spieler->get('hash');
			$email = "Um Deine Anmeldung zu vervollständigen musst du den folgenden Link anklicken:\n" . $link;
			Mailer::simplesend(Setting::read('systememail'), $spieler->get('email'), "Anmeldung für Sea Wars", $email);
			$array['username'] = $spieler->get('username');
			$array['email'] = $spieler->get('email');
			$layout = $this->getLayout($array, "registerok", $vars);
			return $layout;
		}
		return redirect($target);
	}

	function confirm(&$vars) {
		global $mysql;
		$spieler_id = mysql_real_escape_string($vars['spieler_id']);
		$spieler = new Spieler($vars['spieler_id']);
		if ($spieler->get('confirmed') == 1)
			error("Dieser Spieler wurde bereits verifiziert", 'Login', 'confirm');
		if ((isset($vars['hash']) && !empty($vars['hash']))) {
			$hash = $mysql->escape($vars['hash']);
			if ($hash != $spieler->get('hash'))
				error("Falscher Link, falsche Security ID übermittelt.", 'Login', 'confirm');
			$spieler->set('confirmed', 1);
			$spieler->store();
			$inseln = Insel::getStartIslands();
			$anzahl = count($inseln);
			$insel = new Insel($inseln[rand(0, $anzahl)][0]);
			$insel->set('spieler_id', $spieler_id);
			$insel->store();
			$query = "INSERT INTO ttexplored (spieler_id, techtree_entry_id, finished) VALUES('$spieler_id', 0, 1)";
			$mysql->insert($query);
			$array['username'] = $spieler->get('username');
			$layout = $this->getLayout($array, "confirmok", $vars);
			return $layout;
		} else
			error("Falscher Link, keine Security ID übermittelt.", 'Login', 'confirm');
	}

	/**
	 * show register dialog
	 */
	function register(& $vars) {
		$array['username'] = Session :: getCookie("register_username");
		$array['password'] = Session :: getCookie("register_password");
		$array['password2'] = Session :: getCookie("register_password2");
		$array['email'] = Session :: getCookie("register_email");
		$array['error'] = isset($vars['error']) ? $vars['error'] : '';
		$layout = $this->getLayout($array, "register", $vars);
		return $layout;
	}

	function acl($method) {
		$method = strtolower($method);
		if ($method == 'register') {
			return true;
		} else if ($method == 'register2') {
			return true;
		} else if ($method == 'logout') {
			return true;
		} else if ($method == 'login') {
			return true;
		} else if ($method == 'show') {
			return true;
		} else if ($method == 'confirm') {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * is there a logged in player?
	 */
	function isLoggedIn() {
		$spieler_id = Session::getCookie('spieler_id');
		return !empty($spieler_id);
	}

	/**
	 * show denied if login fails
	 * bad style, has to be improved
	 */
	function denied() {
		return error("Zugang verweigert", $this->class_name, "denied");
	}

	/**
	 * logout player, reset session has to be
	 * implemented in session
	 */
	function logout(& $vars) {
		Session::unsetCookie("username");
		Session::unsetCookie("spieler_id");
		return redirect("index.php");
	}

	/**
	 * login player
	 */
	function login(& $vars) {
		global $mysql;
		if ($this->isLoggedIn())
			$this->logout($vars);
		// Passwort �berpr�fen
		$username = $mysql->escape($vars['username']);
		$password = myencrypt($mysql->escape($vars['password']));
		$array = $mysql->select("SELECT id FROM spieler WHERE username='$username' AND password='$password' AND confirmed=1");
		$result['content'] = "URL";
		$target = '';
		if (count($array) == 1) {
			Session::setCookie("username", $username, NULL);
			Session::setCookie("spieler_id", $array[0][0], NULL);
			$result['target'] = "index.php?class=inselliste&mode=OWN";
			$target = "index.php?class=Inselliste";
		} else {
			$result['target'] = "index.php?class=Login&method=denied";
			$target = "index.php?class=Login&method=denied";
		}
		return redirect($target);
	}

	function show(& $vars) {
		if ($this->isLoggedIn())
			return redirect("index.php?class=Inselliste");

		$array = array("title" => "Spieler Login", "lbl_username" => "Benutzername", "lbl_password" => "Passwort", "lbl_login" => "Anmelden");
		return $this->getLayout($array, "login_window", $vars);
	}

}
