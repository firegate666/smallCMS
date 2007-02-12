<?
/**
 * Imagelinks
 */
class Image extends AbstractClass {

	public function ReplaceEmoticons($string) {
		global $mysql;
		$list = $mysql->select("SELECT name, url FROM image WHERE emoticon=1;", true);
		foreach($list as $item)
			$string = str_replace('::'.$item['name'].'::', '<img src="'.$item['url'].'" alt="'.$item['name'].'"/>', $string);
		return $string;
	}

	public function acl($method){
		if ($method=='show')
			return true;
		return false;
	}

	public function getTypeOptionList($default = 0, $cannull = false){
		global $mysql;
		$list = $mysql->select("SELECT DISTINCT type FROM image ORDER BY type ASC;", true);//$this->getlist('', $asc, $orderby);
		$options = "";
		if ($cannull)
			$options = "<option></option>";
		foreach($list as $item) {
			$selected = "";
			if (is_array($default)) {
				if (in_array($item['type'], $default))
					$selected = "SELECTED='SELECTED'";
			} else 
				if ($item['type'] == $default)
					$selected = "SELECTED='SELECTED'";
			$options .= "<option $selected value='".$item['type']."'>".$item['type']."</option>";
		}
		return $options;
	}

	public function getEmoOptionList($default = 0, $cannull = false){
		$list[] = array('value'=>'0', 'name'=>'ohne Emoticons');
		$list[] = array('value'=>'1', 'name'=>'nur Emoticons');
		$options = "";
		if ($cannull)
			$options = "<option></option>";
		foreach($list as $item) {
			$selected = "";
			if (is_array($default)) {
				if (in_array($item['value'], $default))
					$selected = "SELECTED='SELECTED'";
			} else 
				if ($item['value'] == $default)
					$selected = "SELECTED='SELECTED'";
			$options .= "<option $selected value='".$item['value']."'>".$item['name']."</option>";
		}
		return $options;
	}

   	public function getFields() {
		$fields[] = array('name' => 'parent',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => null);
		$fields[] = array('name' => 'parentid',
                          'type' => 'integer',
                          'notnull' => null);
		$fields[] = array('name' => 'name',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);
		$fields[] = array('name' => 'url',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);
		$fields[] = array('name' => 'size',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'prio',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'type',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);
		$fields[] = array('name' => 'emoticon',
                          'type' => 'integer',
                          'notnull' => false);

		return $fields;
	}
    
    public function parsefields($vars, $parent = '0', $parentid = '0'){
    	$vars['parent'] = $parent;
    	$vars['parentid'] = $parentid;
    	$err = false;
//    	if (!in_array($vars['type'], array('image/gif', 'image/pjpeg', 'image/jpeg')))
//    		$err[] = "Image must be: image/gif, image/pjpeg or image/jpeg; found: ".$vars['type'];
    	if (!is_uploaded_file($vars['tmp_name']))
    		$err[] = "Upload failed";
    	$vars['name'] = str_replace (" ", "_", $vars['name']);
    	$vars['name'] = str_replace ("�", "ae", $vars['name']);
    	$vars['name'] = str_replace ("�", "oe", $vars['name']);
    	$vars['name'] = str_replace ("�", "ue", $vars['name']);
    	$vars['name'] = str_replace ("�", "Ae", $vars['name']);
    	$vars['name'] = str_replace ("�", "Oe", $vars['name']);
    	$vars['name'] = str_replace ("�", "Ue", $vars['name']);
    	$vars['name'] = str_replace ("�", "ss", $vars['name']);
    	$url = get_config("uploadpath").randomstring(25)."-".$parent."-".$parentid."-".$vars['name'];
    	if ($err === false) {
    		$res = copy($vars['tmp_name'], $url);
	    	if (!$res)
	    		$err[] = "Copy faild";
	    	else
	    		$vars['url'] = $url;
    	}
    	if ($err !== false)
    		return $err;
    	return parent::parsefields($vars);
    }
    
    /**
    * delete Image from database and filesystem
    */
    function delete() {
        if(!isset($this->data['url']) || empty($this->data['url']))
                return;
        @unlink($this->data['url']);
        parent::delete();
    }

	/**
	 * returns all know images
	 */
	function getImageList($where="") {
		global $mysql;
		if (is_array($where))
			$where = " WHERE ".implode(' AND ', $where);
		$query = "SELECT * FROM image $where;";
		$array = $mysql->select($query, true);
		return $array;
	}

	/**
	* load image by known name
	* @param     String   $name             name of image
	*/
    function loadbyname($name) {
		global $mysql;
		$name = $mysql->escape($name);
		$query = "SELECT id FROM image WHERE name='$name';";
		$array = $mysql->executeSql($query);
		$this->id = $array['id'];
		$this->load();
	}

	function getExtension() {
		$ext = substr(strrchr($this->get('url'), "."), 1);
		return $ext;
	}
	
	function show(& $vars, $layout = '', $array = array()) {
		if ($layout != '')
			return parent::show($vars, $layout, $array);
		//header('Content-Description: File Transfer');
		//header('Content-Type: application/force-download');
		//header("Content-Disposition: attachment; filename=\"".basename($url)."\";");
		//header('Content-Length: ' . filesize($url));
		header('Content-Type: '.$this->get('type'));
		header("Content-Disposition: inline; filename=\"".$this->get('name').$this->getExtension."\";");
		header('Content-Length: '.filesize($this->get('url')));
		if (isset($vars['x']) || isset($vars['y']))
			$this->resize($vars);
		else
			@readfile($this->get('url')) or die("Error while downloading webfile");
	}

	function resize($vars) {
		$x=-1;
		$y=-1;
		if (!empty($vars['x']))
			$x = $vars['x'];
		if (!empty($vars['y']))
			$y = $vars['y'];
		
		$src_im = null;
		$imgname = $this->get('url');
		$cachekey = md5($x."-".$y."-".$imgname);
		if (file_exists($cachekey)) {
			$this->addlog("Read image from cache: ".$cachekey, 10);
			header("Content-type: ".$this->get('type'));
			@readfile('./cache/files/'.$cachekey);
			die;
		}
		
		if (($this->get('type') == 'image/jpeg')&& function_exists('imagecreatefromjpeg')) {
			$src_im = imagecreatefromjpeg($imgname);
		} else if (($this->get('type') == 'image/gif') && function_exists('imagecreatefromgif')) {
			$src_im = imagecreatefromgif($imgname);
		} else if (($this->get('type') == 'image/png') && function_exists('imagecreatefrompng')) {
			$src_im = imagecreatefrompng($imgname);
		}
		
		if ($src_im == null) // image not supported or not recognized
			die("Image not supported");
		
		$newwidth=imagesx($src_im);
		$newheight=imagesy($src_im);

		if (($y!=-1)&&($y<$newheight)) {
			$newwidth=round($newwidth/$newheight*$y);
			$newheight=$y;
		}
		if (($x!=-1)&&($x<$newwidth)) {
			$newheight=round($newheight/$newwidth*$x);
			$newwidth=$x;
		}

   		$dest_im = imagecreatetruecolor($newwidth,$newheight);
		imagecopyresized ($dest_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, imagesx($src_im), imagesy($src_im));

		if (($this->get('type') == 'image/jpeg') && function_exists('imagejpeg')) {
			header("Content-type: image/jpeg");
			imagejpeg($dest_im, './cache/files/'.$cachekey, 100);
		} else if (($this->get('type') == 'image/png') && function_exists('imagepng')) {
			header("Content-type: image/png");
			imagepng($dest_im, './cache/files/'.$cachekey, 100);
		} else if (($this->get('type') == 'image/gif') && function_exists('imagegif')) {
			header("Content-type: image/gif");
			imagegif($dest_im, './cache/files/'.$cachekey, 100);
		} else // image not supported or not recognized
			die("Image not supported"); 
		$this->addlog("Write image to cache: ".$cachekey, 10);
		@readfile('./cache/files/'.$cachekey);
		imagedestroy($dest_im);
	}
	function Image($nameorid = '') {
		if (empty ($nameorid))
			return;
		if(is_numeric($nameorid)) {
			parent::AbstractClass($nameorid);
		} else
			$this->loadbyname($nameorid);
	}
}
?>