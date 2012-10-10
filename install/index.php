<html>
	<head><title>smallCMS Setup</title></head>
	<body>
		<?php
		$step = 1;
		if (!empty($_REQUEST['step']))
			$step = $_REQUEST['step'];;

		if ($step == 1) {
			// check permissions
			$error = false;
			echo "<h3>Check file permissions:</h3><table>";
			$writable = array('cache', 'upload', 'config');

			$dir = realpath("..");
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if (substr($file, 0, 1) == '.')
						continue;
					print "<tr><td>" . $file . "</td><td>";
					if (in_array($file, $writable)) {
						if (is_writable($dir . "/" . $file))
							print '<font color="#00ff00">OK</font><br/>';
						else {
							$error = true;
							print '<font color="#ff0000"><strong>NOT WRITABLE</strong></font><br/>';
						}
					} else {
						if (is_readable($dir . "/" . $file))
							print '<font color="#00ff00">OK</font><br/>';
						else {
							$error = true;
							print '<font color="#ff0000"><strong>NOT READABLE</strong></font><br/>';
						}
					}
					print "</td></tr>";
				}
			}
			echo "</table>";
			if (!$error)
				echo '<p><a href="index.php?step=2">Proceed with step 2</a></p>';
		} else if ($step == 2) {
			// create config
			echo "<h3>Setup database</h3>";
			echo "<form action='index.php'><input type='hidden' name='step' value='3'/><table>";
			echo "<tr><td>Datenbank</td><td><select name='dbtype'><option value='mysql'>MySQL</option></select></td></tr>";
			echo "<tr><td>Datenbankname</td><td><input type='text' name='dbname'/></td></tr>";
			echo "<tr><td>Benutzer</td><td><input type='text' name='dbuser'/></td></tr>";
			echo "<tr><td>Passwort</td><td><input type='text' name='dbpass'/></td></tr>";
			echo "<tr><td>Server</td><td><input type='text' name='dbserver' value='localhost'/></td></tr>";
			echo "<tr><td>URL</td><td><input type='text' name='system' value='" . $_SERVER['HTTP_HOST'] . "'/></td></tr>";
			echo "<tr><td>Adminemail</td><td><input type='text' name='email' value='webmaster@" . $_SERVER['HTTP_HOST'] . "'/></td></tr>";

			echo "<tr><td>CMS Modul</td><td><select name='cms'><option value='false'>nein</option><option value='true'>ja</option></select></td></tr>";
			echo "<tr><td>Fragebogen Modul</td><td><select name='questionaire'><option value='false'>nein</option><option value='true'>ja</option></select></td></tr>";
			echo "<tr><td>W40K Modul</td><td><select name='w40k'><option value='false'>nein</option><option value='true'>ja</option></select></td></tr>";
			echo "<tr><td>Game Modul</td><td><select name='game'><option value='false'>nein</option><option value='true'>ja</option></select></td></tr>";
			echo "<tr><td>BBCode Modul</td><td><select name='bbcode'><option value='false'>nein</option><option value='true'>ja</option></select></td></tr>";

			echo "<tr><td></td><td><input type='submit' value='Proceed with step 3'/></td></tr>";
			echo "</table></form>";
		} else if ($step == 3) {
			// check and write config
			print "<h3>Write config</h3>";

			$db = @mysql_connect($_REQUEST['dbserver'], $_REQUEST['dbuser'], $_REQUEST['dbpass']) or die('Server, user or password is invalid: ' . mysql_error());
			$db = mysql_select_db($_REQUEST['dbname'], $db) or die('Database "' . $_REQUEST['dbname'] . '" is invalid: ' . mysql_error());

			$config_template = realpath("../config/config.inc.php.template");
			$config = "../config/config.inc.php";
			$content = file_get_contents($config_template);
			$content = str_replace("<dbname>", $_REQUEST['dbname'], $content);
			$content = str_replace("<dbtype>", $_REQUEST['dbtype'], $content);
			$content = str_replace("<dbuser>", $_REQUEST['dbuser'], $content);
			$content = str_replace("<dbpass>", $_REQUEST['dbpass'], $content);
			$content = str_replace("<dbserver>", $_REQUEST['dbserver'], $content);
			$content = str_replace("<system>", $_REQUEST['system'], $content);
			$content = str_replace("<email>", $_REQUEST['email'], $content);

			$content = str_replace("<cms>", $_REQUEST['cms'], $content);
			$content = str_replace("<questionaire>", $_REQUEST['questionaire'], $content);
			$content = str_replace("<w40k>", $_REQUEST['w40k'], $content);
			$content = str_replace("<game>", $_REQUEST['game'], $content);
			$content = str_replace("<bbcode>", $_REQUEST['bbcode'], $content);

			file_put_contents($config, "<?php\n" . $content);
			chmod($config, 0666);

			echo "<p>Config file is written to '$config' and marked as writable. Please set it to readable only when going to public!.</p>";
			echo '<p><a href="index.php?step=4">Proceed with step 4</a></p>';
		} else if ($step == 4) {
			// initialize database
			require_once realpath("../config/config.inc.php");
			$db = @mysql_connect($dbserver, $dbuser, $dbpassword) or die('Server, user or password is invalid: ' . mysql_error());
			$db = mysql_select_db($dbdatabase, $db) or die('Database "' . $dbdatabase . '" is invalid: ' . mysql_error());
			echo "<h3>Setup database</h3>";
			$dir = dirname(__FILE__) . '/mysql/';
			if ($handle = opendir($dir) !== false) {
				$files = array();

				while (false !== ($file = readdir($handle))) {
					if (substr($file, strrpos($file, '.')) == '.sql')
						$files[] = $file;
				}
				closedir($handle);
				sort($files);
				foreach ($files as $file) {
					if (file_exists($dir . "/" . $file)) {
						printf("<p>Process %s</p>", $file);
						$sql = file_get_contents($dir . "/" . $file);

						$statements = explode(';', $sql);
						foreach ($statements as $statement) {
							$statement = trim($statement);
							if (!empty($statement)) {
								mysql_query($statement) or die("ERROR: SQL (" . $dir . "/" . $file . ") fails: " . mysql_error());
							}
						}
					} else
						die("ERROR: File does not exist: " . $dir . "/" . $file);
				}
			}
		}
		?>
	</body>
</html>
