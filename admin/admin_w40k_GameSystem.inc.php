<?php
$adminlogin = (User::hasright('admin') || User::hasright('w40kadmin') || User::hasright('gamesystemadmin'));
if(empty($adminlogin)) die("DENIED");

$error = '';

if (isset($_REQUEST['store'])) {
	$obj = new $_REQUEST['type']($_REQUEST['id']);
	$err = $obj->parsefields($_REQUEST);
	if ($err===false) {
		$obj->store();
		unset($_REQUEST['id']);
		unset($_REQUEST['store']);
	} else
		echo(implode(",", $err));
}

if (isset($_REQUEST['delete'])) {
	$obj = new $_REQUEST['type']($_REQUEST['id']);
	if (!$obj->delete(true))
		$error = "L&ouml;schen des Objektes ist fehlgeschlagen. M&ouml;glicherweise wird es noch verwendet.";
	unset($_REQUEST['id']);
	unset($_REQUEST['delete']);
}
?>

<h3>GamesDB Configuration: <?php print $_REQUEST['type']?></h3>
<div class="error"><?php print $error?></div>
<?php if (isset($_REQUEST['type'])) { ?>
	<?php if(!isset($_REQUEST['id'])) { ?>
		<a href="index.php?admin&w40k&type=<?php print $_REQUEST['type']?>&id=">Neues GameSystem anlegen</a>
		<table class="adminlist" width="100%">
			<tr>
				<th width="80%">Name</th>
				<th width="20%">&nbsp;</th>
			</tr>
		<?php $t = new $_REQUEST['type']();
			$where = array();
			if (isset($_REQUEST['gamesystem']) && ($_REQUEST['gamesystem'] != ''))
				$where[] = array('key'=>'gamesystem', 'value'=>$_REQUEST['gamesystem']);
		   $list = $t->getlist('', true, 'name', array('id', 'name'), '', '', $where);
		   foreach($list as $item) { ?>
				<tr>
					<td width="80%"><?php print $item['name']?></td>
					<td width="20%">
						<a href='?admin&w40k&type=<?php print $_REQUEST['type']?>&id=<?php print $item['id']?>#edit'>
							<img src='img/edit.gif' border='0' alt='Edit'/>
						</a>
						<a href="?admin&w40k&type=<?php print $_REQUEST['type']?>&id=<?php print $item['id']?>&delete">
							<img src='img/delete.gif' border='0' alt='Delete'/>
						</a>
					</td>
				</tr>
		   <?php}
		?>
		</table>
	<?php } ?>
	<?php if(isset($_REQUEST['id'])) { ?>
			<div><a href="javascript:history.back()">Zur&uuml;ck</a></div>
			<form method="post" action="index.php">
				<?php $obj = new $_REQUEST['type']($_REQUEST['id']);?>
				<input type="hidden" name="admin"/>
				<input type="hidden" name="w40k"/>
				<input type="hidden" name="id" value="<?php print $obj->get('id')?>"/>
				<input type="hidden" name="type" value="<?php print $_REQUEST['type']?>"/>
				<table class="adminedit" width="100%">
					<tr>
						<th colspan="2"><h3>Bearbeiten/Anlegen (<?php print $_REQUEST['type']?>)</h3></th>
					</tr>
					<?php
						foreach($obj->getFields() as $field) { ?>
							<tr>
								<td><?php print $field['desc']?></td>
								<td><?php print $obj->getInputField($field)?></td>
							</tr>
						<?php}
					?>
					<tr>
						<td colspan="2"><input type="submit" name="store" value="Speichern"/></td>
					</tr>
				</table>
			</form>
	<?php } ?>
<?php } ?>
