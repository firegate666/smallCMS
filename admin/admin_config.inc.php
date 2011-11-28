<?php
$adminlogin = (User::hasright('admin') || User::hasright('configadmin'));
if(empty($adminlogin)) die("DENIED");
?>

<h3>System Configuration</h3>
<table class="adminlist" width="100%">
  <tr>
    <th align="left">Name</th><th align="left">Value</th>
  </tr>
<?php

	global $_CONFIG;
	foreach($_CONFIG as $name=>$value) { ?>
		<tr>
		  <td><?php print $name?></td>
		  <td><?php
		  		if ($value === true) echo "true";
		  		else if ($value === false) echo "false";
		  		else echo $value;
		  ?></td>
		</tr>
	<?php }
?>
</table>