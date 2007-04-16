<?
$adminlogin = (User::hasright('admin') || User::hasright('w40kadmin')|| User::hasright('codexadmin'));
if(empty($adminlogin)) die("DENIED");

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
	$obj->delete(true);
	unset($_REQUEST['id']);
	unset($_REQUEST['delete']);
}
?>

<h3>GamesDB Configuration: <?=$_REQUEST['type']?></h3>
<? if (isset($_REQUEST['type'])) { ?>
	<? if(!isset($_REQUEST['id'])) { ?>
		<form method="get">
			<input type="hidden" name="admin"/>
			<input type="hidden" name="w40k"/>
			<input type="hidden" name="type" value="<?=$_REQUEST['type']?>"/>
			<select name="gamesystem" onChange="this.form.submit();">
			<?
				$gamesystem = new GameSystem();
				$optionlist = $gamesystem->getOptionList($_REQUEST['gamesystem'], true); 
			?>
				<?=$optionlist?>
			</select>
			<a href="index.php?admin&w40k&type=<?=$_REQUEST['type']?>&id=">Neuen Codex anlegen</a>
		</form>
		<table class="adminlist" width="100%">
			<tr>
				<th width="80%">Name</th>
				<th width="20%">&nbsp;</th>
			</tr>
		<? $t = new $_REQUEST['type']();
			$where = array();
			if (isset($_REQUEST['gamesystem']) && ($_REQUEST['gamesystem'] != ''))
				$where[] = array('key'=>'gamesystem', 'value'=>$_REQUEST['gamesystem']);
		   $list = $t->getlist('', true, 'name', array('id', 'name'), '', '', $where);
		   foreach($list as $item) { ?>
				<tr>
					<td width="80%"><?=$item['name']?></td>
					<td width="20%">
						<a href='?admin&w40k&type=<?=$_REQUEST['type']?>&id=<?=$item['id']?>'>
							<img src='img/edit.gif' border='0' alt='Edit'/>
						</a>
						<a href="?admin&w40k&type=<?=$_REQUEST['type']?>&id=<?=$item['id']?>&delete">
							<img src='img/delete.gif' border='0' alt='Delete'/>
						</a>
					</td>
				</tr>
		   <?}
		?>
		</table>
	<? } ?>
	<? if(isset($_REQUEST['id'])) { ?>
			<div><a href="javascript:history.back()">Zurück</a></div>
			<form method="post" action="index.php">
				<?$obj = new $_REQUEST['type']($_REQUEST['id']);?>
				<input type="hidden" name="admin"/>
				<input type="hidden" name="w40k"/>
				<input type="hidden" name="id" value="<?=$obj->get('id')?>"/>
				<input type="hidden" name="type" value="<?=$_REQUEST['type']?>"/>
				<table class="adminedit" width="100%">
					<tr>
						<th colspan="2"><h3>Bearbeiten/Anlegen (<?=$_REQUEST['type']?>)</h3></th>
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
<? } ?>