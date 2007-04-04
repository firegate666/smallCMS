<?$adminlogin = (User::hasright('admin') || User::hasright('templateadmin'));if(empty($adminlogin)) die("DENIED");
if (isset ($_REQUEST['tpl_content'])) {
	global $mysql;	$_REQUEST['tpl_content'] = htmlentities($_REQUEST['tpl_content']);	$_REQUEST['tpl_class'] = $mysql->escape($_REQUEST['tpl_class']);	$_REQUEST['tpl_layout'] = $mysql->escape($_REQUEST['tpl_layout']);
	$_REQUEST['contenttype'] = $mysql->escape($_REQUEST['contenttype']);	$tpl_query = "UPDATE template SET content='{$_REQUEST['tpl_content']}', contenttype='{$_REQUEST['contenttype']}' WHERE class='{$_REQUEST['tpl_class']}' AND layout = '{$_REQUEST['tpl_layout']}';";
	$mysql->update($tpl_query);
	if (!isset($_REQUEST['submitandstay']))		unset ($_REQUEST['tpl_layout']);
}
if (isset ($_REQUEST['tpl_addlayout'])) {
	if ($_REQUEST['tpl_layoutname'] != "") {		Template::createTemplate($_REQUEST['tpl_class'], $_REQUEST['tpl_layoutname']);		$_REQUEST['tpl_layout'] = $_REQUEST['tpl_layoutname'];	}
}
if (isset ($_REQUEST['tpl_delete'])) {
	Template::deleteTemplate($_REQUEST['tpl_class'], $_REQUEST['tpl_layout']);
	unset ($_REQUEST['tpl_delete']);
	unset ($_REQUEST['tpl_layout']);
}
?>
<table class="adminlist" width="100%">
<tr>	<th colspan="4"><h3>Templates bearbeiten</h3></th></tr>  <?

$array = array ();
$link = "index.php?admin&template&tpl_class=";
$array = Template::getClasses();
$options = '<option value=""></option>';
foreach ($array as $items) {
	if($items == $_REQUEST['tpl_class']) $options .= '<option selected="selected">'.$items.'</option>';	else $options .= '<option>'.$items.'</option>';
}
?>
<tr>	<td>Template Klasse</td>
	<td>
    	<form name="selectclass" action="index.php" method="get">      		<input type="hidden" name="admin"/>	  		<input type="hidden" name="template"/>	    	<select name="tpl_class" onChange="this.form.submit()"><?=$options?></select>
    	</form>    </td>
<? if (isset ($_REQUEST['tpl_class']) && !empty($_REQUEST['tpl_class'])) { ?>    <td>Template</td>    <td>		<form name="showtemplate" action="index.php" method="get">			<input type="hidden" name="admin"/>			<input type="hidden" name="template"/>			<input type="hidden" name="tpl_class" value="<?=$_REQUEST['tpl_class']?>"/>			<input type="hidden" name="admin"/>			<select name="tpl_layout" size="1" onChange="this.form.submit()">				<option value=""></option><?
$array = Template::getLayouts($_REQUEST['tpl_class']);
foreach ($array as $items) {	$selected = '';	if($items[0] == $_REQUEST['tpl_layout'])		$selected ='selected="selected"';	echo "\t\t\t\t<option $selected value='{$items[0]}'>{$items[0]}</option>\n";}?>
			</select>			<input type='submit' value='Bearbeiten'/>			<input type='submit' value='Löschen' name='tpl_delete'/>		</form>	</td></tr><tr>	<td>Neues Template</td>    <td>    	<form action="index.php" method="get">       		<input type="hidden" name="tpl_addlayout"/>			<input type="hidden" name="admin"/>			<input type="hidden" name="template"/>			<input type="hidden" name="tpl_class" value="<?=$_REQUEST['tpl_class']?>"/>			<input type="text"   name="tpl_layoutname"/>			<input type="submit" value="Add Layout"/>		</form>    </td>    <td colspan="2"></td></tr><?}?></table><? if (isset ($_REQUEST['tpl_layout'])) { ?>
  <script type="text/javascript" src="?admin/show/javascript"></script>
  <form action="index.php" method="post" name="edittpl">
    <p>Template '<?=$_REQUEST['tpl_layout']?>' bearbeiten</p>    <input type="submit" name="submit" value="Speichern und schließen"/>    <input type="submit" name="submitandstay" value="Nur Speichern"/>    <table>
      <tr>
        <td>
          <input type="button" value="Fett" onClick="insertTag('b')"/>          <input type="button" value="Kursiv" onClick="insertTag('i')"/>          <input type="button" value="Unterstrichen" onClick="insertTag('u')"/>          <input type="button" value="ImageTag" onClick="insertTag('image')"/>
          <input type="button" value="PageLink" onClick="insertTag('plink')"/>
          <input type="button" value="PageInclude" onClick="insertTag('page')"/>
        </td>
      </tr>
      <tr>
        <td>
          <textarea name="tpl_content" cols="80" rows="50"><?=(Template::getLayout($_REQUEST['tpl_class'], $_REQUEST['tpl_layout'],array(),true, array(), true));?></textarea>
        </td>
      </tr>      <tr>      	<td>      		<select name="contenttype">				<?=Template::contenttypeoptionlist($_REQUEST['tpl_class'], $_REQUEST['tpl_layout']);?>      		</select>      	</td>      </tr>    </table>
    <input type="submit" name="submit" value="Speichern und schließen"/>    <input type="submit" name="submitandstay" value="Nur Speichern"/>    <input type="hidden" name="template" value=""/>
    <input type="hidden" name="admin" value=""/>
    <input type="hidden" name="tpl_class" value="<?=$_REQUEST['tpl_class']?>"/>
    <input type="hidden" name="tpl_layout" value="<?=$_REQUEST['tpl_layout']?>"/>
  </form>
<? } ?>