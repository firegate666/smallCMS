<?
$adminlogin = (User::hasright('admin') || User::hasright('templateadmin'));
if(empty($adminlogin)) die("DENIED");

if (isset($_REQUEST['store'])) {
	$obj = new Filecategory($_REQUEST['id']);
	$err = $obj->parsefields($_REQUEST);
	if ($err===false) {
		$obj->store();
		unset($_REQUEST['id']);
		unset($_REQUEST['store']);
	} else
		echo(implode(",", $err));
}

?>

<h3>Filecatregory Configuration</h3>
	<? if(!isset($_REQUEST['id'])) { ?>
		<a href="index.php?admin&w40k&type=filecategory&id=">Neue Filecategory anlegen</a>
		<table class="adminlist" width="100%">
			<tr>
				<th width="40%">Name</th>
				<th width="40%">Parent</th>
				<th width="20%">&nbsp;</th>
			</tr>
		<? $t = new Filecategory();
			$where = array();
		   $list = $t->getlist('', true, 'name', array('id', 'name'), '', '', $where);
		   foreach($list as $item) { ?>
				<tr>
					<td width="40%"><?=$item['name']?></td>
					<td width="40%"><?=$item['parent']?></td>
					<td width="20%">
						<a href='?admin&w40k&type=filecategory&id=<?=$item['id']?>'>
							<img src='img/edit.gif' border='0' alt='Edit'/>
						</a>
						<img src='img/delete.gif' border='0' alt='Delete'/>
					</td>
				</tr>
		   <?}
		?>
		</table>
	<? } ?>
	<? if(isset($_REQUEST['id'])) { ?>
			<div><a href="javascript:history.back()">Zurück</a></div>
			<form method="post" action="index.php">
				<?$obj = new Filecategory($_REQUEST['id']);?>
				<input type="hidden" name="admin"/>
				<input type="hidden" name="w40k"/>
				<input type="hidden" name="id" value="<?=$obj->get('id')?>"/>
				<input type="hidden" name="type" value="filecategory"/>
				<table class="adminedit" width="100%">
					<tr>
						<th colspan="2"><h3>Bearbeiten/Anlegen</h3></th>
					</tr>
					<?
						foreach($obj->getFields() as $field) { ?>
							<tr>
								<td><?=$field['desc']?></td>
								<td><?=$obj->getInputField($field)?></td>
							</tr>
						<?}
					?>
					<tr>
						<td colspan="2"><input type="submit" name="store" value="Speichern"/></td>
					</tr>
				</table>
			</form>
	<? } ?>