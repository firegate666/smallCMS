<?php
$adminlogin = (User::hasPrivilege('admin') || User::hasPrivilege('templateadmin'));
if (empty($adminlogin))
	die("DENIED");

if (isset($_REQUEST['store']))
{
	$obj = new Filecategory($_REQUEST['id']);
	$err = $obj->parsefields($_REQUEST);
	if ($err === false)
	{
		$obj->store();
		unset($_REQUEST['id']);
		unset($_REQUEST['store']);
	} else
		echo(implode(",", $err));
}
?>

<h3>Filecatregory <?php print @$_REQUEST['parentname'] ?></h3>
<?php if (!isset($_REQUEST['id']))
{ ?>
	<a href="index.php?admin&filecategory&id=&parent=<?php print @$_REQUEST['parent'] ?>">Neue Filecategory anlegen</a>
	<table class="adminlist" width="100%">
		<tr>
			<th width="80%">Name</th>
			<th width="20%">&nbsp;</th>
		</tr>
	<?php
	$t = new Filecategory();
	$where = array(array('key' => 'parent', 'value' => null, 'comp' => ' is '));
	if (isset($_REQUEST['parent']) && ($_REQUEST['parent'] != ''))
		$where = array(array('key' => 'parent', 'value' => $_REQUEST['parent']));
	$list = $t->getlist('', true, 'name', array('id', 'name'), '', '', $where);
	foreach ($list as $item)
	{
	?>
		<tr>
			<td width="80%"><a href="?admin&filecategory&parent=<?php print $item['id'] ?>&parentname=<?php print $item['name'] ?>"><?php print $item['name'] ?></a></td>
			<td width="20%">
				<a href='?admin&filecategory&id=<?php print $item['id'] ?>'>
					<img src='img/edit.gif' border='0' alt='Edit'/>
				</a>
				<img src='img/delete.gif' border='0' alt='Delete'/>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<?php }

if (isset($_REQUEST['id']))
{ ?>
<div><a href="javascript:history.back()">Zur&uuml;ck</a></div>
<form method="post" action="index.php">
<?php
	$obj = new Filecategory($_REQUEST['id']);
	$obj->preloaddata($_REQUEST);
?>
	<input type="hidden" name="admin"/>
	<input type="hidden" name="id" value="<?php print $obj->get('id') ?>"/>
	<input type="hidden" name="filecategory"/>
	<table class="adminedit" width="100%">
		<tr>
			<th colspan="2"><h3>Bearbeiten/Anlegen</h3></th>
		</tr>
		<?php foreach ($obj->getFields() as $field)
		{ ?>
			<tr>
				<td><?php print $field['desc'] ?></td>
				<td><?php print $obj->getInputField($field) ?></td>
			</tr>
<?php }
?>
				<tr>
					<td colspan="2"><input type="submit" name="store" value="Speichern"/></td>
				</tr>
			</table>
		</form>
<?php } ?>
