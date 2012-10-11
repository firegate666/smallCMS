<?php
$adminlogin = User::hasPrivileges(array('admin', 'seawars_admin', 'techtree_admin'));

if (empty($adminlogin))
	die("DENIED");

if (isset($_REQUEST['cat']) && isset($_REQUEST['create']))
{
	$tc = new TTCategory();
	$tc->set('name', $_REQUEST['cat_name']);
	$tc->store();
	header("Location: index.php?admin&techtree&type={$_REQUEST['type']}&cat");
}
if (isset($_REQUEST['cat']) && isset($_REQUEST['del']))
{
	$tc = new TTCategory($_REQUEST['id']);
	$tc->delete();
	header("Location: index.php?admin&techtree&type={$_REQUEST['type']}&cat");
}
?>

<h3>Tech-Tree Management</h3>

<table>
	<tr>
		<th>Name</th>
		<th>&nbsp;</th>
	</tr>
	<?php
	$ttcat = new TTCategory();
	$result = $ttcat->getlist('ttcategory');
	foreach ($result as $item)
	{
		$tc = new TTCategory($item['id']);
	?><tr>
		<td><?php print $tc->get('name') ?></td>
		<td><a href="?admin=&techtree=&type=<?=$_REQUEST['type']?>&cat=1&del=1&id=<?=$tc->get('id')?>">löschen</a></td>
	</tr>
	<?php } ?>
</table>

<form>
	<input type="hidden" name="admin">
	<input type="hidden" name="techtree">
	<input type="hidden" name="cat">
	<input type="hidden" name="type" value="<?=$_REQUEST['type']?>">
	<input type="hidden" name="create">
		Kategoriename: <input type="text" name="cat_name" maxlength="100">
	<input type="submit" value="Erstellen">
</form>
