<?php

$template_classes[] = 'w40k';
$__userrights[] = array('name' => 'codexadmin', 'desc' => 'can edit codices');
$__userrights[] = array('name' => 'missionadmin', 'desc' => 'can edit missions');
$__userrights[] = array('name' => 'battletypeadmin', 'desc' => 'can edit battle types');
$__userrights[] = array('name' => 'gamesystemadmin', 'desc' => 'can edit game system');
$__userrights[] = array('name' => 'w40kuser_extern', 'desc' => 'can use W40K');
$__userrights[] = array('name' => 'w40kuser_intern', 'desc' => 'can use W40K');
$__userrights[] = array('name' => 'w40kadmin', 'desc' => 'can edit codices & missions');

/**
 * @package w40k
 */
abstract class W40K extends AbstractClass
{

	protected $layoutclass = "w40k";
	protected $image;

	public function delete($mayfail = false)
	{
		// delete images
		$obj_id = $this->get('id');
		$bool = parent::delete($mayfail);
		if (!$bool)
		{
			$image = new Image();
			$ilist = $image->getlist('', true, 'name', array('*'));
			foreach ($ilist as $iobj)
				if (($iobj['parent'] == $this->class_name()) && ($iobj['parentid'] == $obj_id))
				{
					$image = new Image($iobj['id']);
					$image->delete();
				}
		}
		return $bool;
	}

	protected function numImages($id = null)
	{
		if ($id == null)
			$id = $this->get('id');

		$i = new Image();
		$where[] = "parent='" . $this->class_name() . "'";
		$where[] = "parentid=" . $id;
		return count($i->advsearch($where, array('id')));
	}

	public function acl($method)
	{
		if ($method == 'view')
			return $this->exists();
		if ($method == 'showlist')
			return true;
		if ($method == 'delimage')
			return ($this->get('userid') == User::loggedIn())
			|| $this->hasright('admin')
			|| $this->hasright('w40kadmin');
		if ($method == 'prioimage')
			return ($this->get('userid') == User::loggedIn())
			|| $this->hasright('admin')
			|| $this->hasright('w40kadmin');
		return false;
	}

	function delimage($vars)
	{
		if (isset($vars['image']))
		{
			$image = new Image($vars['image']);
			if ($image->exists() && ($image->get('parentid') == $this->get('id')))
				$image->delete();
		}
		return redirect("?" . $this->class_name() . "/edit/" . $this->get('id'));
	}

	function prioimage($vars)
	{
		if (!empty($vars['prio']))
			foreach ($vars['prio'] as $id => $value)
			{
				$image = new Image($id);
				if ($image->exists() && ($image->get('parentid') == $this->get('id')))
				{
					$image->set('prio', $value);
					$image->store();
				}
			}
		return redirect($vars['ref']);
	}

	public function parsefields($vars)
	{
		$err = parent::parsefields($vars);
		if ($err !== false)
			return $err;
		if (isset($vars['__files']['filename']) && ($this->get('id') != '') && ($this->get('id') != 0))
		{
			$err = $this->image->parsefields($vars['__files']['filename'], $this->class_name(), $this->get('id'));
			if ($err === false)
				$this->image->store();
		} else if (isset($vars['__files']['filename']) && ($this->get('id') == ''))
			$err[] = "Upload failed, Object is new";
		if ($err !== false)
			return $err;

		return false;
	}

	public function __construct($id='')
	{
		parent::__construct($id);
		$this->image = new Image();
	}

}
