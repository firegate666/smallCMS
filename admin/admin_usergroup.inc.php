<?php
$adminlogin = (User::hasPrivilege('admin') || User::hasPrivilege('useradmin'));
if (!$adminlogin)
	die("DENIED");

$error = array();

if (isset($_REQUEST['store']))
{
	$ug = new Usergroup($_REQUEST['id']);
	$error = $ug->parsefields($_REQUEST);
	if (!$error)
	{
		$error = array();
		$ug->store();
		$ug->setUserrights($_REQUEST['userright']);
		unset($_REQUEST['id']);
	}
	unset($_REQUEST['store']);
}

if (isset($_REQUEST['delete']))
{
	$ug = new Usergroup($_REQUEST['id']);
	if (!$ug->delete(true))
		$error[] = 'Das L&ouml;schen der Benutzergruppe ist fehlgeschlagen, m&ouml;licherweise wird sie noch verwendet!';
	unset($_REQUEST['delete']);
	unset($_REQUEST['id']);
}

if (!isset($_REQUEST['id']))
{
	$ug = new Usergroup();
?>
	<h3>Groups</h3>
	<div class="error"><?php print implode(' ', $error); ?></div>
	<form method="get" action="index.php">
		<input type="hidden" name="admin"/>
		<input type="hidden" name="id" value="0"/>
		<input type="submit" name="usergroup" value="Neue Gruppe anlegen"/>
	</form>
	<table class="adminlist" width="100%">
		<tr>
			<th align="left" width="100%">Name</th>
			<th></th>
		</tr>
<?php
	$u = new Usergroup();
	foreach ($u->getlist('', true, 'name', array('*')) as $ug)
	{
?>
		<tr>
			<td><?php print $ug['name'] ?></td>
			<td>
				<a href="?admin&usergroup&id=<?php print $ug['id'] ?>">
					<img src="img/edit.gif" border="0" alt="Edit"/>
				</a>
				<a href="?admin&usergroup&id=<?php print $ug['id'] ?>&delete">
						<img src="img/delete.gif" border="0" alt="Edit"/>
					</a>
				</td>
			</tr>
<?php } ?>
	</table>
<?php
}
if (isset($_REQUEST['id']))
{
	$ug = new Usergroup($_REQUEST['id']);
?>
	<a name="edit"></a>
	<div><a href="javascript:history.back()">Zur&uuml;ck</a></div>
	<form action="index.php" method="post">
		<input type="hidden" name="admin"/>
		<input type="hidden" name="usergroup"/>
		<input type="hidden" name="id" value="<?php print $ug->get('id') ?>"/>
		<table class="adminedit">
			<tr>
				<th colspan="2"><h3>Edit Group: <?php print $ug->get('name') ?></h3></th>
			<tr>
				<td colspan="2"><span class="error"><?php print implode(' ', $error); ?></span></td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input type="text" name="name" value="<?php print $ug->get('name') ?>"/>
		</tr>
		<tr>
			<td></td>
			<td>
<?php
				$rights = $ug->getUserrights();
				foreach (UserPrivileges::get() as $priv)
				{
					$checked = "";
					if (in_array($priv['name'], $rights))
						$checked = 'CHECKED="CHECKED"';
?><input <?php print $checked ?> type="checkbox" name="userright[<?php print $priv['name'] ?>]"/> <?php print $priv['name'] ?>, <?php print $priv['desc'] ?><br/><?php } ?>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" name="store" value="Speichern"/>
						</tr>
					</table>
				</form>
<?php } ?>
