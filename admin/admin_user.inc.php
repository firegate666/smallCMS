<?php
$adminlogin = (User::hasright('admin') || User::hasright('useradmin'));
if(!$adminlogin) die("DENIED");

$error = '';

if(isset($_REQUEST['groupaction']) && isset($_REQUEST['userid'])) {
	$u = new User($_REQUEST['userid']);
	if ($_REQUEST['groupaction'] == 'change')
		$u->changenewgroup();
	if ($_REQUEST['groupaction'] == 'delete')
		$u->delnewgroup();
	unset($_REQUEST['groupaction']);
	unset($_REQUEST['userid']);
}

if (isset($_REQUEST['delete'])) {
	$ug = new User($_REQUEST['userid']);
	if(!$ug->delete(true))
		$error = 'Das L&ouml;schen des Benutzers ist fehlgeschlagen, m&ouml;licherweise wird er noch verwendet!';
	unset($_REQUEST['delete']);
	unset($_REQUEST['userid']);
}

if(isset($_REQUEST['store']) && isset($_REQUEST['userid'])) {
	$error = false;
	$u = new User($_REQUEST['userid']);
	if (!empty($_REQUEST['password']))
		if ($_REQUEST['password'] != $_REQUEST['password2'])
			$error = "Passwords do not match. ";
		else
			$u->set('password', myencrypt($_REQUEST['password']));
	$u->set('login', $_REQUEST['login']);
	$u->set('email', $_REQUEST['email']);
	$u->set('groupid', $_REQUEST['groupid']);
	if ($error === false) {
		$u->store();
		unset($_REQUEST['userid']);
		unset($_REQUEST['store']);
		unset($_REQUEST['password']);
	} else
		echo $error."Error while saving";
}

if(isset($_REQUEST['store']) && isset($_REQUEST['userright'])) {
	$ug = new Usergroup($_REQUEST['id']);
	$ug->set('name', $_REQUEST['name']);
	$ug->store();
	$ug->setUserrights($_REQUEST['userright']);
	unset($_REQUEST['id']);
	unset($_REQUEST['store']);
	unset($_REQUEST['usergroup']);
}
?>
<?php
if ((!isset($_REQUEST['usergroup'])) && (!isset($_REQUEST['userid']))) {
	$ug = new Usergroup();
?>
	<h3>User</h3>
	<div class="error"><?php print $error?></div>
	<form action="index.php" method="post">
		<input type="hidden" name="admin"/>
		<input type="hidden" name="user"/>
		<select name="usergroupid" onChange="this.form.submit()">
			<option value="">- Gruppenfilter aus -</option>
			<?php print $ug->getOptionList($_REQUEST['usergroupid'], false, 'name', true, 'name')?>
		</select>
	</form>

	<form method="get" action="index.php">
		<input type="hidden" name="admin"/>
		<input type="hidden" name="user"/>
		<input type="submit" name="userid" value="Neuen User anlegen"/>
	</form>

	<table class="adminlist" width="100%">
		<tr>
			<th align="left">Login</th>
			<th align="left">Email</th>
			<th align="left">Group</th>
			<th colspan="2" align="left">New Group</th>
			<th align="left">seit</th>
			<th align="left">Fehler</th>
			<th align="left">leztes Login</th>
			<th>&nbsp;</th>
		</tr>
	<?php
		$u = new User();
		$where = array();
		if (!empty($_REQUEST['usergroupid']))
			$where[] = array('key'=>'groupid', 'value'=>$_REQUEST['usergroupid']);
		$ul = $u->getlist('', true, 'login', array('*'), '', '', $where);
		foreach($ul as $myuser) {
			$ug = new Usergroup($myuser['groupid']);
			$ug2 = new Usergroup($myuser['newgroup']);
			$class = '';
			if ($myuser['newgroup'] <> 0)
				$class = 'lightborder';
		?>
			<tr>
				<td><?php print $myuser['login']?></td>
				<td><?php print $myuser['email']?></td>
				<td><?php print $ug->get('name')?></td>
				<td class="<?php print $class?>"><?php print $ug2->get('name')?></td>
				<td>
					<?php if (!empty($class)) { ?>
						<a href="index.php?admin&user&groupaction=delete&userid=<?php print $myuser['id']?>"><img src="img/deny.gif" alt="Reject Request"/></a>
						<a href="index.php?admin&user&groupaction=change&userid=<?php print $myuser['id']?>"><img src="img/verified.gif" alt="Acknowledge Request"/></a>
					<?php } ?>
				</td>
				<td><?php print $myuser['__createdon']?></td>
				<td><?php print $myuser['errorlogins']?></td>
				<td><?php print $myuser['lastlogin']?></td>
				<td><a href="?admin&user&userid=<?php print $myuser['id']?>"><img src="img/edit.gif" border="0" alt="Edit"/></a>
					<a href="?admin&user&userid=<?php print $myuser['id']?>&delete">
						<img src="img/delete.gif" border="0" alt="Delete"/>
					</a>
				</td>
			</tr>
		<?php }
	?>
	</table>
<?php }
if (isset($_REQUEST['userid'])) {
	$u = new User($_REQUEST['userid']);
	$ug = new Usergroup($u->get('groupid'));
?>
	<a name="edit"></a>
	<div><a href="javascript:history.back()">Zur&uuml;ck</a></div>
	<form action="index.php" method="post">
		<input type="hidden" name="admin"/>
		<input type="hidden" name="user"/>
		<input type="hidden" name="userid" value="<?php print $u->get('id')?>"/>
		<table class="adminedit">
			<tr>
				<th colspan="2"><h3>Edit User: <?php print $u->get('login')?></h3></th>
			</tr>
			<tr>
				<td>Login</td>
				<td><input type="text" name="login" value="<?php print $u->get('login')?>"/></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" value="<?php print $u->get('email')?>"/></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="password" value=""/>
					<input type="text" name="password2" value=""/>
				</td>
			</tr>
			<tr>
				<td>Usergroup</td>
				<td><select name="groupid"><?php print $ug->getOptionList($u->get('groupid'),true)?></select></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td><input type="submit" name="store" value="Speichern"/></td>
			</tr>
		</table>
	</form>
<?php } ?>
