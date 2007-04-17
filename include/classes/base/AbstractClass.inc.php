<?
/**
 * The main features everyone should know
 */
abstract class AbstractClass {
	
    /** main data array */
    protected $data = array();
    protected $viewname = null;
    
    /** auto id of object */
    protected $id;
    
    protected static $relations = array();
    
	protected $language;
	
	protected function addlog($msg, $loglevel=0) {
		FileLogger::write("QUERY: ".$msg, $loglevel);
	}

	/**
	 * return input field for objectfield
	 * 
	 * @param	String	name of field
	 */
	public function getInputField($field) {
		$return = '';
		switch($field['htmltype']) {
			case 'input': $return = "<input type='text' name='{$field['name']}' value='".$this->get($field['name'], true)."' size='75'/>";
				break; 
			case 'textarea': $return = "<textarea name='{$field['name']}' cols='75' rows='5'>".$this->get($field['name'], true)."</textarea>";
				break;
			case 'select':
				$return = "<select name='{$field['name']}'>\n";
				if (is_array($field['join'])) {
					foreach($field['join'] as $key=>$value) {
						$SELECTED = '';
						if ($this->get($field['name']) == $value)
							$SELECTED = 'selected="selected"';	
						$return .= '<option '.$SELECTED.' value="'.$value.'">'.$key.'</option>'."\n";
					}
				} else {
					$obj = new $field['join']();
					$cannull = !(isset($field['notnull']) && ($field['notnull'] === true));
					$return .= $obj->getOptionList($this->get($field['name']), $cannull);
				}
				$return .= "</select>\n";
				break;
		}
		return $return;
	}
	
	/**
	 * workaround for get_class to user with lowercase
	 * tablenames
	 * 
	 * @return	String	lowercase class name
	 */
	public function class_name($prefer_view=false) {
		if ($prefer_view && !empty($this->viewname))
			return $this->viewname;
		return strtolower(get_class($this));
	}
	
	/**
	 * return sequence name, postgres only
	 */
	public function sequence_name() {
		return strtolower(get_class($this)).'_id_seq';
	}
	
	/**
	 * return xml document of all items
	 */
	function xmllist() {
		global $mysql;
		$result[$this->class_name()] = $mysql->select("SELECT * FROM ".$this->class_name, true);
		$output = XML::get($result);
		return xml($output);
	}
	
	/**
	 * test if logged in user has righ $right
	 * 
	 * @param String	$userright to test
	 */
	public function hasright($right) {
		return User::hasright($right);
	}  
	
	/**
	 * All database fields are made public at this place
	 * Each field is one array row
	 * Example
	 * $fields[] = array('name' => id,
	 * 					'type' => boolean,
	 * 					'notnull' = false,
	 * 					'default' = '') 
	 * type can be: integer, string, boolean, timestamp
	 * it has to be implmented in each class, else it throws
	 * an error
	 *
	 * @return	String[][]	all known fields or false if no fields are set
	 */
	public function getFields() {
		return true;
		// not yet used
		// if activated
		// return false;
	}
	
	/**
	 * returns all rows for class $classname
	 * 
	 * @param	String	$classname	name of table to select from
	 * @param	bool	$ascending	order directiion ascending
	 * @param	String	$orderby	field to order by
	 * @param	Array	$fields	fields to select
	 * @param	integer	$limitstart	
	 * @param	integer	$limit
	 * @param	Array	$wherea	array of where conditions key, value
	 * @param	String	$boolop	bool operator for where clause
	 * @return	String[][]	complete result
	 */
	function getlist($classname='', $ascending=true, $orderby = 'id',
				 $fields = array('id'), $limitstart='', $limit='',
				 $wherea=array(), $boolop = 'AND', $comp = "=") {
		global $mysql;
		$where = null;
		if (!empty($wherea) && is_array($wherea))
			foreach($wherea as $cond)
				if (isset($cond['key'])) {
					$value = "'".$this->escape($cond['value'])."'";					
					if ($cond['value'] === null)
						$value = "null";
					if (!empty($cond['comp']))
						$comp = $cond['comp'];
					$where[] = " {$cond['key']} $comp $value ";
				}
		if(!empty($where))
			$where = " WHERE ".implode($boolop, $where);
			
		if (empty($classname)) $classname = $this->class_name(true);
		$orderdir = "ORDER BY ".$this->escape($orderby)." ";
		$fields = implode(',', $fields);
		if ($ascending) $orderdir .= "ASC";
		else $orderdir .= "DESC";
		$limits = '';
		if ($limitstart != '') {
			$limits = 'LIMIT '.$this->escape($limitstart);
			if ($limit != '')
				$limits .= ', '.$this->escape($limit);
		}
		else if ($limit != '')
			$limits = 'LIMIT '.$this->escape($limit);
		$query = "SELECT ".$fields." FROM ".$this->escape($classname)." $where $orderdir $limits;";
		$result = $mysql->select($query, true);
		return $result;
	}
	
	/**
	 * Setter
	 *
	 * @param	String	$key	name of attribute
	 * @param	String	$value	value of attribute
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	/**
	 * Getter for instance attributes
	 *
	 * @param	String	$key	name of attribute
	 * @param	bool	$raw	return without conversion (bbcode f.e)
	 * @return	String	value of attribute
	 */
	public function get($key, $raw = false) {
		if($key == 'id')
			return $this->id;
		if (!isset($this->data[$key]))
			return null; 
		if (!$raw && get_config('bbcode', true)) {
			$value = $this->data[$key];
			$value = Image::ReplaceEmoticons($value);
			return BBCode::parse($value);
		} else
			return $this->data[$key];
	}

	/**
	 * return data array
	 */
	public function getData() {
		return $this->data;
	}
	
	/**
	 * copy data from source to this
	 */
	public function copy($source) {
		if (get_class($this) != get_class($source))
			error("Source (".get_class($source).") and destination (".get_class($this).") must be from same class for copy", get_class($this), "copy");
		$this->data = $source->getData();
	}

	/**
	 * not used yet
	 * not sure if used anywhen
	 */
	function load_language($language,$class){
	}
	
	/**
	 * does this object exists?
	 *
	 * @return	boolean	true, if $this->id exists
	 */
	function exists() {
	   return !empty($this->id);
	}

	/**
	 * load object from database
	 */
	function load() {
		global $mysql;
    	$id = $mysql->escape($this->id);
    	if (empty($id))
    		return;
    	$tablename 	= $this->class_name();
    	$this->data = $mysql->executeSql("SELECT * FROM ".$tablename." WHERE id=$id;");
    	$this->id	= $this->data['id'];
    	unset($this->data['id']);
    }

    /**
     * delete me, remove record from database
     */
    function delete($mayfail = false) {
    	global $mysql;
    	if(empty($this->id)) return;
    	$tablename = $this->class_name();
    	$id = $this->id;
    	$query = "DELETE FROM $tablename WHERE id=$id";
    	return $mysql->update($query, $mayfail);
    }
    
	/**
	* returns id of logged in user, 0 if no one is logged in
	*
	* @return	integer	userid
	*/
   protected function loggedIn() {
    	return User::loggedIn();
    }
    
    /**
     * save me to database
     * fetch all from $this->data and build SQL Statement
     * Update if existed, insert if new
     *
     * @return	int	id of object
     */
    function store() {
		global $mysql;
		// set timestamps
		$datenow = Date::now();
		if($this->id=='')
			$this->data['__createdon'] = $datenow;
		$this->data['__changedon'] = $datenow;
		
		// Seperate keys from values
		$keys   = array_keys($this->data);
		$values = array_values($this->data);
		for($i=0;$i<count($values);$i++) {
			if ($values[$i] === null)
				$nextval = 'null';
			else {
				$nextval = $this->escape($values[$i]);
				$nextval = "'$nextval'";
			}
			$values[$i] = $nextval;
		}
		// CREATE SQL Statement
		$tablename = $this->class_name();
		if($this->id=='') {
			$query = "INSERT INTO $tablename (".implode(",",$keys).") VALUES (".implode(",",$values).");";
			$this->id = $mysql->insert($query, $this->sequence_name());
		} else {
			$query  = "UPDATE $tablename SET";
			$query .= " ".$keys[0]."=".$values[0];
			for($i=1;$i<count($values);$i++)
				$query .= ", ".$keys[$i]."=".$values[$i];
			$query .= " WHERE id=".$this->id.";";
			$mysql->update($query);
		}
		return $this->id;
	}
    
    /**
     * print myself to console
     */
    function printout() {
      print_a($this);
    }
	
	/**
	* public constructor
	*
	* @param	int	$id	id of object
	*/
	public function AbstractClass($id='') {
		if(!$this->getFields()) error("No fields set",$this->class_name(),'Constructor');
		if(empty($id) || !is_numeric($id)) return;
		$this->id=$id;
		$this->load();
	}
	
	/**
	* checks whether it is allowed to call method from outside 	or	 who is
	* allowed to call.
	*
	* @param	String	$method	function to test
	* @return	boolean	true if allowed, else false
	*/
	public function acl($method) {
		// more rights have to be checked at this place
		//if($method == 'xmllist') return true;
		return false;
	}
	
	/**
	 * get template
	 *
	 * @param	String[]	$array	Array with tags for replacement
	 * @param	String		$layout	Name of template
	 * @param	String[]	parameters from request
	 * @return	String	layout
	 */
	function getLayout($array, $layout, &$vars) {
		$t = new Template();

		// add some basic tags to parse
		$array['_created_'] = $this->get('__createdon');
		$array['_changed_'] = $this->get('__changedon');
		$array['_datetime_'] = Date::now();
		
		if (isset($this->layoutclass))
			return $t->getLayout($this->layoutclass,$layout,$array,false,$vars);
		else			
			return $t->getLayout($this->class_name(),$layout,$array,false,$vars);
	}
	
	/**
	 * generic show using template page
	 * 
	 * @param	String[]	$vars	request parameters
	 * @return	String	output
	 */
	function show(&$vars, $layout = 'page', $array = array(), $raw = false) {
		foreach($this->data as $key=>$value) {
			if (!isset($array[$key]))
				$array[$key] = $this->get($key, $raw);
		}
		if (!isset($array['id']))
			$array['id'] = $this->id;
		return $this->getLayout($array, $layout, $vars);
	}

	/**
	 * parse data from $vars using $this->getfields() to check input data
	 * and store into $this->data
	 * 
	 * @param	Array	$vars	input data
	 * @return	Array/boolean	false if no error or array with error msg	
	 */
	function parsefields($vars) {
		$err = false;
		if (!$this->getFields()) {
			$this->data = $vars;
			return true;
		}
		foreach($this->getFields() as $field) {
			// set some defaults
			if (!isset($field['type'])) $field['type'] = "string";
			if (!isset($field['notnull'])) $field['notnull'] = false;
			if (isset($vars[$field['name']]) && ($vars[$field['name']] !== null)) {
				$value = $vars[$field['name']];
				if ($field['notnull'] && empty($value))
					$err[] = "{$field['name']} is null";
				if ($field['type'] == 'date') {
					$darray = explode("-", $value);
					if (count($darray) != 3)
						$err[] = "Unknown date format: $value";
					else {
						if (@checkdate($darray[1], $darray[2], $darray[0] ) === false)
							$err[] = "illegal date: $value";
					}
					
				} else
					if (!settype($value, $field['type']))
						$err[] = "{$field['name']} type error, must be ".$field['type'];
				if (isset($field['size']))
					if (strlen($value) > $field['size'])
						$err[] = "{$field['name']} too long. Max.: ".$field['size'];
				if (isset($field['min']))
					if (strlen($value) < $field['min'])
						$err[] = "{$field['name']} too short. Min.: ".$field['min'];
				$this->data[$field['name']] = $value;
			} else {
				// check not null
				if (($field['notnull'] || $field['password']))
					$err[] = "{$field['name']} is null";
			}
		}
		return $err;
	}

	/**
	 * helps building forms
	 *
	 * @param	String	$content	content to show inside of form, if array, build table
	 * @param	String	$class
	 * @param	String	$method
	 * @param	String	$name	name of form
	 * @param	String[]	$vars	request parameters
	 * @return	String	form
	 */
	function getForm($content='', $class='', $method='show',$name='MyForm', $vars=array(), $enctype='') {
		if(empty($class)) $class = $this->class_name();
		$o = '<!--getform start-->';
		$o .= '<form action="index.php" enctype="'.$enctype.'" name="'.$name.'" METHOD="POST">';
		$o .= HTML::input('hidden', 'class', $class);
		$o .= HTML::input('hidden', 'method', $method);
		$o2 = '';
		if(is_string($content))
			$o .= $content;
		else {
			$o .= '<table>'."\n";
			foreach($content as $input) {
				if($input['descr']=='') $o2 .= $input['input'];
				else $o .= HTML::tr('<td>'.$input['descr'].'</td>'.
							'<td>'.$input['input'].'</td>');
			}
			$o .= '</table>'."\n";
		}
		$o .= '</form><!--getform end-->';
		return $o2.$o;
	}
	
	public function advsearch($where=array(), $fields=array('id'), $boolop = 'AND') {
		global $mysql;
		$query = "SELECT ".implode(",", $fields)." FROM ".($this->class_name()).
					" WHERE ".implode(" $boolop ", $where).";";
		return $mysql->select($query, true);			
	}
	
	/**
	 * @param String $where needle
	 * @param String $sfield searchfield
	 * @param String $fields return fields
	 */
	public function search($where, $sfield='id', $fields='id') {
		global $mysql;
		if ($where == null)
			$this->error('Error in where clause', 'search');
		if (($sfield == null) || ($sfield == ''))
			$this->error('Error in where clause (field)', 'search');
		if (!is_array($fields))
			$fields = array($fields);
		if (count($fields) == 0)
			$this->error('Error in where clause (fields)', 'search');
		$fields = implode(",", $fields);
		$query = "SELECT ".$fields." FROM ".($this->class_name()).
					" WHERE ".$sfield." = '".$where."';";
		return $mysql->select($query, true);			
	}
	
	protected function error($msg, $action) {
		error($msg, get_class($this), $action);
	}

	/**
	 * preload data from $vars and store into $this->data
	 * works only with $this->getFields()
	 */
	public function preloaddata($vars) {
		$fields = $this->getFields();
		if (!$fields)
			return;
			
		foreach($fields as $field) {
			if (isset($vars[$field['name']]))
				$this->set($field['name'], $vars[$field['name']]);
		}
	}

	/**
	 * return html option list
	 * 
	 * @param	String	$default	default value to select
	 * @param	boolean	$cannull	if true adds empty option
	 * @param	String	$field		Object field to use as description in option
	 * @param	boolean	$asc		if true order ascending
	 * @param	String	$orderby	order by field
	 * @param	String	$value		field to use as value in option	
	 * @param	Array	$where		where array @see getlist()
	 * @return	String	HTML-optionlist
	 */
	public function getOptionList($default = 0, $cannull = false, $field = 'name', $asc= true,
			$orderby='id', $value = 'id', $where = array()) {
		$list = $this->getlist('', $asc, $orderby, array('id'), '', '', $where);
		$options = "";
		if ($cannull)
			$options = "<option value=''></option>";
		foreach($list as $item) {
			$obj = new $this($item['id']);
			$selected = "";
			if (is_array($default)) {
				if (in_array($obj->get($value), $default))
					$selected = "selected='selected'";
			} else 
				if ($obj->get($value) == $default)
					$selected = "selected='selected'";
			$opt_desc = "";
			if (is_array($field)) {
				foreach($field as $name) {
					$opt_desc[] = $obj->get($name);
				}
				$opt_desc = implode(', ', $opt_desc);
			} else
				$opt_desc = $obj->get($field);
			$options .= "<option $selected value='".$obj->get($value)."'>".$opt_desc."</option>";
		}
		return $options;
	}

	/**
	 * dbescape String, depends on DB System
	 */
	function escape($string) {
		global $mysql;
		return $mysql->escape($string);
	}
}
?>
