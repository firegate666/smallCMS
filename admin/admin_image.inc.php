<?
$adminlogin = (User::hasright('admin') || User::hasright('templateadmin'));
$msg = "";
if(empty($adminlogin)) die("DENIED");

if (isset ($_REQUEST['img_delete'])) {
	if(isset($_REQUEST['id'])) {
	        $i = new Image($_REQUEST['id']);
	        $i->delete();
	}
}
if (isset ($_REQUEST['img_upload']) && isset($HTTP_POST_FILES['filename'])) {
	$image = new Image();
	$result = $image->parsefields($HTTP_POST_FILES['filename']);
	if ($result === false) {
		$image->set('emoticon', $_REQUEST['emoticon']);
		$msg .= "Dateigr&ouml;&szlig;e: ".$HTTP_POST_FILES['filename']['size']." bytes<br/>\n";
		$msg .= "Dateityp: ".$HTTP_POST_FILES['filename']['type']."<br/>\n";
		if (!empty($_REQUEST['img_name']))
			$image->set('name', $_REQUEST['img_name']);
		$image->store();
	} else {
		$msg .= implode($result);
	}
} else {
	$msg = "ready for upload";
}
?>
<h3>Dateiverwaltung</h3>
<div id="myform"><a href="index.php?admin&image&img_upload">Upload</a> /
<a href="index.php?admin&image&img_show">Anzeigen</a>
  <? if(isset($_REQUEST['img_upload'])) { ?>
	<form action="index.php" enctype="multipart/form-data" method="post" name="fupload">
		<script type="text/javascript">
			function upload() {
				document.getElementById('msg').innerHTML = 'uploading';
				document.getElementById('bar').style.display = 'block';
				document.getElementById('myform').style.display = 'none';
				document.forms['fupload'].submit();
			}
		</script>
		<input type="hidden" name="img_upload"/>
		<input type="hidden" name="image"/>
		<input type="hidden" name="admin"/>
		<input type="hidden" name="emoticon" value="0"/>
		<table class="adminedit">
			<tr>
				<th colspan="2"><h3>Bild hochladen</h3></th>
			</tr>
			<tr><td>Dateiname</td><td><input type="file" name="filename"/></td></tr>
			<tr><td>Bildname</td><td><input type="text" name="img_name"/></td></tr>
			<tr><td>Emoticon?</td><td><input type="checkbox" name="emoticon" value="1"/></td></tr>
			<tr><td><td><input type="button" value="Upload" onclick="upload()"/></td></tr>
       </table>
	</form></div>
	<div id="bar" style="display:none"><img src="img/progressbar.gif" alt="uploadbar"/></div>
	<div id="msg"><?=$msg?></div>
  <? } ?>
  <? if(isset($_REQUEST['img_show'])) {
  		$image = new Image();
		$optionlist = $image->getTypeOptionList($_REQUEST['filter_type']);
		$optionlist_emo = $image->getEmoOptionList($_REQUEST['filter_emoticon']);
?>
<form action="index.php" method="get">
	<input type="hidden" name="admin"/>
	<input type="hidden" name="image"/>
	<input type="hidden" name="img_show"/>
	<table class="adminlist">
		<tr>
			<th>Bildname</th>
			<th><select name="filter_emoticon" onChange="this.form.submit();"><option value="">Alle</option><?=$optionlist_emo?></select></th>
			<th>Gr&ouml;&szlig;e</th>
			<th><select name="filter_type" onChange="this.form.submit();"><option value="">Dateityp</option><?=$optionlist?></select></th>
			<th>URL</th>
			<th/>
		</tr>
<?
$where[] = 'parentid=0';
if (!empty($_REQUEST['filter_type']))
	$where[] = "type='{$_REQUEST['filter_type']}'";
if (isset($_REQUEST['filter_emoticon']) && ($_REQUEST['filter_emoticon'] != ''))
	$where[] = "emoticon='{$_REQUEST['filter_emoticon']}'";
$array = Image::getImageList($where);
foreach ($array as $item) {
?>
		<tr>
			<td><a href="?image/show/<?=$item['name']?>" target="_blank"><?=$item['name']?></a></td>
			<td><img src="?image/show/<?=$item['name']?>/y=20" alt="<?=$item['name']?>" height="20" width="20"/></td>
			<td><?=$item['size']?></td>
			<td><?=$item['type']?></td>
			<td><?=$item['url']?></td>
		    <td><a href="javascript:dialog_confirm('Wirklich l&ouml;schen?', 'index.php?admin&image&img_show&img_delete&id=<?=$item['id']?>');"><img src="img/delete.gif" border="0"alt="Delete"/></a></td>
		</tr>
<?
}
?>
	</table>
</form>
  <? } ?>
