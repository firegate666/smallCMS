<?php
if (isset($logout))
{
	Session::cleanUpCookies();
	header("Location: index.php");
}

$adminlogin = User::loggedIn();

if (empty($adminlogin))
{
	header("Location: ?admin/show/login");
}

$admin = new Admin('head');
$vars = array();
echo $admin->show($vars);
?>
<table width="100%">
	<tr>
		<td rowspan="2" id="navframe">
			<p><a href="http://www.virtualid.de" target="_blank">
					<img src="img/smallCMS.gif" width="71" height="61" border="0" alt="smallCMS"/></a>
			</p>
			<a href="index.php?admin">Startseite</a>
			<br/><a href="index.php?admin&template">Templates</a>
			<?php if (get_config("cms", false))
			{ ?>
				<br/><a href="index.php?admin&image">Dateien</a>
				<br/><a href="index.php?admin&filecategory">Dateikategorien</a>
<?php } ?>
			<?php if (get_config("questionaire", false))
			{ ?>
				<br/><a href="index.php?admin&questionaire">Questionaire</a>
<?php } ?>

<?php if (get_config("game", false)): ?>
				<br/><br><a href="index.php?admin&techtree">Tech-Tree</a>
				<?php if (isset($_REQUEST['techtree'])): ?>
					<br/>=&gt; <a href="?admin&techtree&type=type">Type</a>
					<br/>=&gt; <a href="?admin&techtree&type=category">Category</a>
					<br/>=&gt; <a href="?admin&techtree&type=entry">Entry</a>
				<?php endif; ?>
<?php endif; ?>

<?php if (get_config("w40k", false))
			{
 ?>
				<br/><br/><a href="index.php?admin&w40k">Games-DB</a>
<?php if (isset($_REQUEST['w40k']))
				{ ?>
					<br/>=&gt; <a href="?admin&w40k&type=Codex">Codices</a>
					<br/>=&gt; <a href="?admin&w40k&type=Mission">Missionen</a>
					<br/>=&gt; <a href="?admin&w40k&type=BattleType">BattleTypes</a>
					<br/>=&gt; <a href="?admin&w40k&type=GameSystem">GameSystem</a>
			<?php }
			} ?>
			<br/><br/><a href="index.php?admin&user">User</a>
			<br/><a href="index.php?admin&usergroup">Usergroup</a>
			<br/><a href="index.php?admin&settings">Settings</a>
			<br/><a href="index.php?admin&config">Configuration</a>
			<br/><a href="index.php?user/logout//ref=index.php">Logout</a>
			<?php
			$admin = new Admin('customnavi');
			$vars = array();
			echo $admin->show($vars);
			?>
		</td>
		<td id="topframe">
			<?php
			$admin = new Admin('topframe');
			$vars = array();
			echo $admin->show($vars);
			?>
		</td>
	</tr>
	<tr>
		<td id="mainframe">
			<?php
			$actdir = dirname(__FILE__) . '/';
			if (isset($_REQUEST['template']))
			{
				require_once $actdir . 'admin_template.inc.php';
			}
			else if (isset($_REQUEST['image']))
			{
				require_once $actdir . 'admin_image.inc.php';
			}
			else if (isset($_REQUEST['filecategory']))
			{
				require_once $actdir . 'admin_filecategory.inc.php';
			}
			else if (isset($_REQUEST['techtree']) && isset($_REQUEST['type']))
			{
				require_once $actdir . 'admin_techtree_' . $_REQUEST['type'] . '.inc.php';
			}
			else if (isset($_REQUEST['settings']))
			{
				require_once $actdir . 'admin_settings.inc.php';
			}
			else if (isset($_REQUEST['config']))
			{
				require_once $actdir . 'admin_config.inc.php';
			}
			else if (isset($_REQUEST['questionaire']))
			{
				require_once $actdir . 'admin_questionaire.inc.php';
			}
			else if (isset($_REQUEST['user']))
			{
				require_once $actdir . 'admin_user.inc.php';
			}
			else if (isset($_REQUEST['usergroup']))
			{
				require_once $actdir . 'admin_usergroup.inc.php';
			}
			else if (isset($_REQUEST['w40k']) && isset($_REQUEST['type']))
			{
				require_once $actdir . 'admin_w40k_' . $_REQUEST['type'] . '.inc.php';
			}
			else
			{
				$admin = new Admin('index');
				$vars = array();
				echo $admin->show($vars);
			}
			?>
		</td>
	</tr>
</table>
</body>
</html>
