<?php
$adminlogin = (User::hasPrivilege('admin') || User::hasPrivilege('settingsadmin'));
if (empty($adminlogin))
	die("DENIED");
?>

<h3>Systemsettings</h3>
<?php
if (isset($_REQUEST['save']))
{
	Setting::write($_REQUEST['name'], $_REQUEST['value']);
	unset($_REQUEST['save']);
	unset($_REQUEST['name']);
	unset($_REQUEST['value']);
}
if (isset($_REQUEST['edit']))
{
?>
	<div>
		<form action="index.php" method="post">
			<input type="hidden" name="admin"/>
			<input type="hidden" name="settings"/>
			<input type="hidden" name="save"/>
			<input type="hidden" name="name" value="<?php print $_REQUEST['name'] ?>"/>
			<table class="adminedit">
				<tr>
					<th colspan="2"><h3>Setting bearbeiten</h3></th>
				<tr>
					<td><?php print Session::getSubCookie('settingdesc', 'name') ?></td>
					<td><input size="25" name="value" type="text" value="<?php print Session::getSubCookie('setting', 'name') ?>"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit"/></td>
				</tr>
			</table>
		</form>
	</div>
<?php } ?>
<table class="adminlist" width="100%">
	<tr>
		<th align="left">Name</th><th align="left">Value</th><th align="left">&nbsp;</th>
	</tr>
<?php foreach (Session::getCookie('setting') as $name => $value)
{ ?>
	<tr>
		<td><?php print Session::getSubCookie('settingdesc', $name) ?></td>
		<td><?php
			if ($value === true)
				echo "true";
			else if ($value === false)
				echo "false";
			else
				echo $value;
?></td>
				<td><a href="?admin&settings&edit&name=<?php print $name ?>"><img src="img/edit.gif" border="0" alt="Edit"/></a></td>
			</tr>
<?php } ?></table>
