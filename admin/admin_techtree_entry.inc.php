<?php
$adminlogin = User::hasPrivileges(array('admin', 'seawars_admin', 'techtree_admin'));

if (empty($adminlogin))
	die("DENIED");

if (isset($_REQUEST['create']))
{
	$tc = new TTEntry();
	$tc->set('name', $_REQUEST['name']);
	$tc->set('description', $_REQUEST['description']);
	$tc->set('aufwand', $_REQUEST['aufwand']);
	$tc->set('tttypeid', $_REQUEST['tttypeid']);
	$tc->set('ttcategoryid', $_REQUEST['ttcategoryid']);
	$tc->set('imageid', null);
	$tc->store();

	foreach($_REQUEST['dependson'] as $dependency) {
		if (empty($dependency))
			continue;

		$tcd = new TTEntryDependson();
		$tcd->set('entry_id', $tc->get('id'));
		$tcd->set('dependson_id', $dependency);
		$tcd->store();
	}

	header("Location: index.php?admin&techtree&type={$_REQUEST['type']}");
}
if (isset($_REQUEST['del']))
{
	$tc = new TTEntry($_REQUEST['id']);
	$tc->delete();
	header("Location: index.php?admin&techtree&type={$_REQUEST['type']}");
}
?>

<h3>Tech-Tree Management - Entries</h3>

<table>
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Aufwand</th>
		<th>Type</th>
		<th>Category</th>
		<th>Dependencies</th>
		<th>&nbsp;</th>
	</tr>
	<?php
	$ttcat = new TTEntry();
	$result = $ttcat->getlist();
	foreach ($result as $item)
	{
		if ($item['id'] == 1)
			continue;
		$tc = new TTEntry($item['id']);
	?><tr>
		<td><?php print $tc->get('name') ?></td>
		<td><?php print $tc->get('description') ?></td>
		<td><?php print $tc->get('aufwand') ?></td>
		<td><?php print $tc->get('tttypeid') ?></td>
		<td><?php print $tc->get('ttcategoryid') ?></td>
		<td>
			<?php
				$ttdepends = new TTEntryDependson();
				print implode(', ', $ttdepends->get($item['id']));
			?>
		</td>
		<td><a href="?admin=&techtree=&type=<?=$_REQUEST['type']?>&del=1&id=<?=$tc->get('id')?>">löschen</a></td>
	</tr>
	<?php } ?>
</table>

<h4>Eintrag erstellen</h4>

<form>

	<input type="hidden" name="admin">
	<input type="hidden" name="techtree">
	<input type="hidden" name="type" value="<?=$_REQUEST['type']?>">
	<input type="hidden" name="create">

	<table>
		<tr>
			<td>Name</td>
			<td><input type="text" name="name" value="" /></td>
		</tr>
		<tr>
			<td>Description</td>
			<td><input type="text" name="description" value="" /></td>
		</tr>
		<tr>
			<td>Aufwand</td>
			<td><input type="text" name="aufwand" value="" /></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><select name="tttypeid">
					<?php
						$tttype = new TTType();
						print $tttype->getOptionList('');
					?>
				</select></td>
		</tr>
		<tr>
			<td>Kategorie</td>
			<td><select name="ttcategoryid">
					<?php
						$ttcategory = new TTCategory();
						print $ttcategory->getOptionList('');
					?>
				</select></td>
		</tr>
		<tr>
			<td>Abhängigkeiten</td>
			<td><select name="dependson[]">
					<?php
						$ttentry = new TTEntry();
						print $ttentry->getOptionList('');
					?>
				</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><select name="dependson[]">
					<?php
						$ttentry = new TTEntry();
						print $ttentry->getOptionList('', true);
					?>
				</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><select name="dependson[]">
					<?php
						$ttentry = new TTEntry();
						print $ttentry->getOptionList('', true);
					?>
				</select></td>
		</tr>
	</table>


	<input type="submit" value="Erstellen">
</form>
