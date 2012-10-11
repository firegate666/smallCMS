<?php
$adminlogin = User::hasPrivileges(array('admin', 'seawars_admin', 'techtree_admin'));

if (empty($adminlogin))
	die("DENIED");

if (isset($_REQUEST['create']))
{
	$tc = new TTType();
	$tc->set('name', $_REQUEST['name']);
	$tc->set('beschreibung', $_REQUEST['beschreibung']);
	$tc->store();
	header("Location: index.php?admin&techtree&type={$_REQUEST['type']}");
}
if (isset($_REQUEST['del']))
{
	$tc = new TTType($_REQUEST['id']);
	$tc->delete();
	header("Location: index.php?admin&techtree&type={$_REQUEST['type']}");
}
?>

<h3>Tech-Tree Management - Types</h3>

<table>
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>&nbsp;</th>
	</tr>
	<?php
	$ttcat = new TTType();
	$result = $ttcat->getlist();
	foreach ($result as $item)
	{
		$tc = new TTType($item['id']);
	?><tr>
		<td><?php print $tc->get('name') ?></td>
		<td><?php print $tc->get('beschreibung') ?></td>
		<td><a href="?admin=&techtree=&type=<?=$_REQUEST['type']?>&del=1&id=<?=$tc->get('id')?>">löschen</a></td>
	</tr>
	<?php } ?>
</table>

<form>
	<input type="hidden" name="admin">
	<input type="hidden" name="techtree">
	<input type="hidden" name="type" value="<?=$_REQUEST['type']?>">
	<input type="hidden" name="create">
		Kategoriename: <input type="text" name="name" maxlength="100" /> <br/>
		Beschreibung
		<textarea name="beschreibung"></textarea>
	<input type="submit" value="Erstellen">
</form>
