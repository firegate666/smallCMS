<?
	if(isset($logout)) {
		Session::cleanUpCookies();
		header("Location: index.php");
	}

	$adminlogin = User::loggedIn();

	if(empty($adminlogin)) {
		header("Location: ?admin/show/login");
	}
	
	print '<?xml version="1.0" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  	<title>smallCMS Admin</title>
    <link href="?admin/show/css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript">
		function dialog_confirm(question, dest) 
		{
  			if (confirm(question)) location = dest;
		}
	</script>
  </head>
<body>
<table width="100%">
  <tr>
    <td rowspan="2" id="navframe">
    	<p><a href="http://www.virtualid.de" target="_blank">
    		<img src="img/smallCMS.gif" width="71" height="61" border="0" alt="smallCMS"/></a>
    	</p>
      <a href="index.php?admin">Startseite</a>
      <br/><a href="index.php?admin&template">Templates</a>
      <? if(get_config("cms", false)) { ?>
	      <br/><a href="index.php?admin&image">Dateien</a>
      <? } ?>
      <? if(get_config("questionaire", false)) { ?>
      	<br/><a href="index.php?admin&questionaire">Questionaire</a>
      <? } ?>
      <? if(get_config("w40k", false)) { ?>
      	<br/><br/><a href="index.php?admin&w40k">Games-DB</a>
      	<? if (isset($_REQUEST['w40k'])) { ?>
      		<br/>=&gt; <a href="?admin&w40k&type=Codex">Codices</a>
      		<br/>=&gt; <a href="?admin&w40k&type=Mission">Missionen</a>
      		<br/>=&gt; <a href="?admin&w40k&type=BattleType">BattleTypes</a>
      		<br/>=&gt; <a href="?admin&w40k&type=GameSystem">GameSystem</a>
      <? }} ?>
      <br/><br/><a href="index.php?admin&user">User</a>
      <br/><a href="index.php?admin&usergroup">Usergroup</a>
      <br/><a href="index.php?admin&settings">Settings</a>
      <br/><a href="index.php?admin&config">Configuration</a>
      <br/><a href="index.php?user/logout//ref=index.php">Logout</a>
		<?
	    	$admin = new Admin('customnavi');
	    	$vars = array();
	    	echo $admin->show($vars);
	    ?>
	</td>
    <td id="topframe">
    <?
    	$admin = new Admin('topframe');
    	$vars = array();
    	echo $admin->show($vars);
    ?>
    </td>
  </tr>
  <tr>
    <td id="mainframe">
    <?		if (isset ($_REQUEST['template'])) {
			include ('admin/admin_template.inc.php');
		} else if (isset ($_REQUEST['image'])) {
			include ('admin/admin_image.inc.php');
		} else if (isset ($_REQUEST['techtree'])) {
			include ('admin/admin_techtree.inc.php');
		} else if (isset ($_REQUEST['settings'])) {
			include ('admin/admin_settings.inc.php');
		} else if (isset ($_REQUEST['config'])) {
			include ('admin/admin_config.inc.php');
		} else if (isset ($_REQUEST['questionaire'])) {
			include ('admin/admin_questionaire.inc.php');
		} else if (isset ($_REQUEST['user'])) {
			include ('admin/admin_user.inc.php');
		} else if (isset ($_REQUEST['usergroup'])) {
			include ('admin/admin_usergroup.inc.php');
		} else if (isset ($_REQUEST['w40k']) && isset($_REQUEST['type'])) {
			include ('admin/admin_w40k_'.$_REQUEST['type'].'.inc.php');
		} else {
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