<?php
/* Copyright (C) 2007-2017  Laurent Destailleur <eldy@users.sourceforge.net>
 * Copyright (C) 2014-2016  Juanjo Menent       <jmenent@2byte.es>
 * Copyright (C) 2015       Florian Henry       <florian.henry@open-concept.pro>
 * Copyright (C) 2015       Raphaël Doursenaud  <rdoursenaud@gpcsolutions.fr>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file        class/discountrule.class.php
 * \ingroup     discountrules
 * \brief       This file is a CRUD class file for discountrule (Create/Read/Update/Delete)
 */

// Put here all includes required by your class file
require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php';
require_once DOL_DOCUMENT_ROOT . '/societe/class/societe.class.php';
require_once DOL_DOCUMENT_ROOT . '/product/class/product.class.php';

/**
 * Class for discountrule
 */
class discountrule extends CommonObject
{
	/**
	 * @var string ID to identify managed object
	 */
	public $element = 'discountrule';
	/**
	 * @var string Name of table without prefix where object is stored
	 */
	public $table_element = 'discountrule';

	/**
	 * @var array  Does this field is linked to a thirdparty ?
	 */
	protected $isnolinkedbythird = 1;
	/**
	 * @var array  Does discountrule support multicompany module ? 0=No test on entity, 1=Test with field entity, 2=Test with link by societe
	 */
	protected $ismultientitymanaged = 1;
	/**
	 * @var string String with name of icon for discountrule
	 */
	public $picto = 'discountrule';


	/**
	 *             'type' if the field format, 'label' the translation key, 'enabled' is a condition when the filed must be managed,
	 *             'visible' says if field is visible in list (-1 means not shown by default but can be aded into list to be viewed)
	 *             'notnull' if not null in database
	 *             'index' if we want an index in database
	 *             'position' is the sort order of field
	 *             'searchall' is 1 if we want to search in this field when making a search from the quick search button
	 *             'isameasure' must be set to 1 if you want to have a total on list for this field. Field type must be summable like integer or double(24,8).
	 *             'comment' is not used. You can store here any text of your choice.
	 */

	// BEGIN MODULEBUILDER PROPERTIES
	/**
	 * @var array  Array with all fields and their property
	 */
	public $fields=array(
		'rowid' => array(
		      'type'=>'integer', 
		    'label'=>'TechnicalID', 
		    'visible'=>-1, 
		    'enabled'=>1, 
		    'position'=>1, 
		    'notnull'=>1, 
		    'index'=>1, 
		    'comment'=>'Id',
		),
		'entity' => array(
		    'type'=>'integer', 
		    'label'=>'Entity', 
		    'visible'=>0, 
		    'enabled'=>1, 
		    'position'=>20, 
		    'notnull'=>1, 
		    'index'=>1,
		    'input' => array(
		        'type' => 'none', //{'text', 'select', 'textarea', 'radio', 'checkbox', 'file', 'shop', 'asso_shop', 'free', 'color'},
		    ),
		),
		'status' => array(
		    'type'=>'integer', 
		    'label'=>'Status', 
		    'visible'=>1, 
		    'enabled'=>1, 
		    'position'=>1000, 
		    'index'=>1,
		    'notnull'=>1, 
		    'default_value'=>1,
		    'input' => array(
		        'type' => 'select', //{'text', 'select', 'textarea', 'radio', 'checkbox', 'file', 'shop', 'asso_shop', 'free', 'color'},
		        'options' => array(    // This is only useful if type == select
		            '0' => 'Desable',
		            '1' => 'Enable',
		        ),
		    ),
		),
	    'from_quantity' => array(
	        'type'=>'integer',
	        'label'=>'FromQty',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>40,
	        'notnull'=>1,
	        'default_value' => 1,
	    ),
		'date_creation' => array(
		    'type'=>'datetime', 
		    'label'=>'DateCreation', 
		    'visible'=>-1, 
		    'enabled'=>1, 
		    'position'=>500, 
		    'notnull'=>1,
		),
		'tms' => array(
		    'type'=>'timestamp', 
		    'label'=>'DateModification', 
		    'visible'=>-1, 'enabled'=>1, 
		    'position'=>500, 
		    'notnull'=>1,
		),
	    'import_key' => array(
	        'type'=>'varchar(14)',
	        'label'=>'ImportKey',
	        'visible'=>-1,
	        'enabled'=>1,
	        'position'=>1000,
	        'index'=>1,
	    ),
	    'fk_category_product' =>array(
	        'type'=>'integer',
	        'label'=>'ProductCategory',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>1,
	        'comment'=>'Product Category ID',
	        'default_value'=>0,
	        'input' => array(
	            'type' => 'callback',
	            'callback' => array('Form', 'select_all_categories'),
	            'param' => array('product', 'field' => 0, 'fk_category_product', 64, 0, 0),
	        ),
	    ),
	   /* 'fk_category_supplier' =>array(
	        'type'=>'integer',
	        'label'=>'ProductSupplierCategory',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>1,
	        'comment'=>'Product supplier ID',
	    ),*/
	    'fk_category_compagny' =>array(
	        'type'=>'integer',
	        'label'=>'ClientCategory',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>1,
	        'comment'=>'Product compagny ID',
	        'default_value'=>0,
	        'input' => array(
	            'type' => 'callback',
	            'callback' => array('Form', 'select_all_categories'),
	            'param' => array('customer', 'field' => 0, 'fk_category_compagny', 64, 0, 0),
	        ),
	    ),
	    'fk_country' =>array(
	        'type'=>'integer',
	        'label'=>'Country',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>1,
	        'comment'=>'Country ID',
	        'default_value'=>1,
	        'input' => array(
	            'type' => 'callback',
	            'callback' => array('Form', 'select_country'),
	            'param' => array('field' => 0, 'fk_country'),
	        ),
	    ),
	    'fk_compagny' =>array(
	        'type'=>'integer',
	        'label'=>'Customer',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>1,
	        'comment'=>'Customer ID',
	        'default_value'=>0,
	        'input' => array(
	            'type' => 'callback',
	            'callback' => array('Form', 'select_thirdparty_list'),
	            'param' => array( 'field' => 0, 'fk_compagny', '', 1, 'customer'),
	        ),
	    ),
	    'reduction' =>array(
	        'type'=>'double(24,8)',
	        'label'=>'Discount',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>0,
	        'comment'=>'',
	        'input' => array(
	            'type' => 'text', //{'text','date', 'select', 'textarea', 'radio', 'checkbox', 'file', 'shop', 'asso_shop', 'free', 'color'},
	            'placeholder'=> 'xx,xx',
	        ),
	    ),
	    'reduction_type' =>array(
	        'type'=>'enum(\'amount\',\'percentage\')',
	        'label'=>'DiscountType',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>1,
	        'index'=>0,
	        'comment'=>'Reduction type',
	        'default_value'=>'percentage',
	        'input' => array(
	            'type' => 'select', //{'text','date', 'select', 'textarea', 'radio', 'checkbox', 'file', 'shop', 'asso_shop', 'free', 'color'},
	            'options' => array(    // This is only useful if type == select
	                //'amount' => 'amount',
	                'percentage' => 'percentage',
	            ),
	        ),
	    ),
	    'date_from' =>array(
	        'type'=>'datetime',
	        'label'=>'DateFrom',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>0,
	        'index'=>0,
	        'comment'=>'date from',
	        'input' => array(
	            'type' => 'date',
	        ),
	    ),
	    'date_to' =>array(
	        'type'=>'datetime',
	        'label'=>'DateEnd',
	        'visible'=>1,
	        'enabled'=>1,
	        'position'=>1,
	        'notnull'=>0,
	        'index'=>0,
	        'comment'=>'',
	        'input' => array(
	            'type' => 'date',
	        ),
	    ),
	);
	


	public $rowid;
	public $entity; 
	public $status;
	public $date_creation;
	public $tms;
	public $import_key;

	public $fk_category_product;
	public $fk_category_supplier;
	public $fk_category_compagny ;
	public $fk_country;
	public $fk_compagny;
	
	public $from_quantity;
	public $reduction;
	public $fk_reduction_tax;
	public $reduction_type;
	public $date_from;
	public $date_to;
	
	
	// END MODULEBUILDER PROPERTIES




	/**
	 * Constructor
	 *
	 * @param DoliDb $db Database handler
	 */
	public function __construct(DoliDB $db)
	{
		$this->db = $db;
	}
	
	/**
	 * Load object in memory from the database
	 *
	 * @param int    $id   Id object
	 * @param string $ref  Ref
	 * @return int         <0 if KO, 0 if not found, >0 if OK
	 */
	public function fetch($id, $ref = null)
	{
	    return parent::fetchCommon($id,$ref);
	}

	
	
	/**
	 * Function to prepare the values to insert.
	 * Note $this->${field} are set by the page that make the createCommon or the updateCommon.
	 *
	 * @return array
	 */
	/**
	 * Function to prepare the values to insert.
	 * Note $this->${field} are set by the page that make the createCommon or the updateCommon.
	 *
	 * @return array
	 */
	private function set_save_query()
	{
	    global $conf;
	    
	    $queryarray=array();
	    foreach ($this->fields as $field=>$info)	// Loop on definition of fields
	    {
	        // Depending on field type ('datetime', ...)
	        if($this->isDate($info))
	        {
	            if(empty($this->{$field}))
	            {
	                $queryarray[$field] = NULL;
	            }
	            else
	            {
	                $queryarray[$field] = $this->db->idate($this->{$field});
	            }
	        }
	        else if($this->isArray($info))
	        {
	            $queryarray[$field] = serialize($this->{$field});
	        }
	        else if($this->isInt($info))
	        {
	            if ($field == 'entity' && is_null($this->{$field})) $queryarray[$field]=$conf->entity;
	            else
	            {
	                $queryarray[$field] = (int) price2num($this->{$field});
	                if (empty($queryarray[$field])) $queryarray[$field]=0;		// May be rest to null later if property 'nullifempty' is on for this field.
	            }
	        }
	        else if($this->isFloat($info))
	        {
	            $queryarray[$field] = (double) price2num($this->{$field});
	            if (empty($queryarray[$field])) $queryarray[$field]=0;
	        }
	        else
	        {
	            $queryarray[$field] = $this->{$field};
	        }
	        
	        if ($info['type'] == 'timestamp' && empty($queryarray[$field])) unset($queryarray[$field]);
	        if (! empty($info['nullifempty']) && empty($queryarray[$field])) $queryarray[$field] = null;
	    }
	    
	    return $queryarray;
	}
	
	/**
	 * Update object into database
	 *
	 * @param  User $user      User that modifies
	 * @param  bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, >0 if OK
	 */
	/**
	 * Update object into database
	 *
	 * @param  User $user      User that modifies
	 * @param  bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, >0 if OK
	 */
	public function updateCommon(User $user, $notrigger = false)
	{
	    $error = 0;
	    
	    $fieldvalues = $this->set_save_query();
	    unset($fieldvalues['rowid']);	// We don't update this field, it is the key to define which record to update.
	    unset($fieldvalues['date_creation']);
	    unset($fieldvalues['entity']);
	    
	    foreach ($fieldvalues as $k => $v) {
	        if (is_array($key)){
	            $i=array_search($k, $key);
	            if ( $i !== false) {
	                $where[] = $key[$i].'=' . $this->quote($v, $this->fields[$k]);
	                continue;
	            }
	        } else {
	            if ( $k == $key) {
	                $where[] = $k.'=' .$this->quote($v, $this->fields[$k]);
	                continue;
	            }
	        }
	        $tmp[] = $k.'='.$this->quote($v, $this->fields[$k]);
	    }
	    $sql = 'UPDATE '.MAIN_DB_PREFIX.$this->table_element.' SET '.implode( ',', $tmp ).' WHERE rowid='.$this->id ;
	    
	    $this->db->begin();
	    if (! $error)
	    {
	        $res = $this->db->query($sql);
	        if ($res===false)
	        {
	            $error++;
	            $this->errors[] = $this->db->lasterror();
	        }
	    }
	    
	    if (! $error && ! $notrigger) {
	        // Call triggers
	        $result=$this->call_trigger(strtoupper(get_class($this)).'_MODIFY',$user);
	        if ($result < 0) { $error++; } //Do also here what you must do to rollback action if trigger fail
	        // End call triggers
	    }
	    
	    // Commit or rollback
	    if ($error) {
	        $this->db->rollback();
	        return -1;
	    } else {
	        $this->db->commit();
	        return $this->id;
	    }
	}
	
	/**
	 *  Return a link to the object card (with optionaly the picto)
	 *
	 *	@param	int		$withpicto			Include picto in link (0=No picto, 1=Include picto into link, 2=Only picto)
	 *	@param	string	$option				On what the link point to
     *  @param	int  	$notooltip			1=Disable tooltip
     *  @param  string  $morecss            Add more css on link
	 *	@return	string						String with URL
	 */
	function getNomUrl($withpicto=0, $option='', $notooltip=0, $morecss='', $urlOnly = 0)
	{
		global $db, $conf, $langs;
        global $dolibarr_main_authentication, $dolibarr_main_demo;
        global $menumanager;

        if (! empty($conf->dol_no_mouse_hover)) $notooltip=1;   // Force disable tooltips

        $result = '';
        $companylink = '';

        $label = '<u>' . $langs->trans("discountrule") . '</u>';
        $label.= '<br>';
        $label.= '<b>' . $langs->trans('Ref') . ':</b> ' . $this->ref;

        $url = $url = dol_buildpath('/discountrules/discountrule_card.php',1).'?id='.$this->id;

        $linkclose='';
        if (empty($notooltip))
        {
            if (! empty($conf->global->MAIN_OPTIMIZEFORTEXTBROWSER))
            {
                $label=$langs->trans("Showdiscountrule");
                $linkclose.=' alt="'.dol_escape_htmltag($label, 1).'"';
            }
            $linkclose.=' title="'.dol_escape_htmltag($label, 1).'"';
            $linkclose.=' class="classfortooltip'.($morecss?' '.$morecss:'').'"';
        }
        else $linkclose = ($morecss?' class="'.$morecss.'"':'');

        if($urlOnly) return $url;
        
		$linkstart = '<a href="'.$url.'"';
		$linkstart.=$linkclose.'>';
		$linkend='</a>';

        if ($withpicto)
        {
            $result.=($linkstart.img_object(($notooltip?'':$label), 'label', ($notooltip?'':'class="classfortooltip"')).$linkend);
            if ($withpicto != 2) $result.=' ';
		}
		$result.= $linkstart . $this->ref . $linkend;
		return $result;
	}

	/**
	 *  Retourne le libelle du status d'un user (actif, inactif)
	 *
	 *  @param	int		$mode          0=libelle long, 1=libelle court, 2=Picto + Libelle court, 3=Picto, 4=Picto + Libelle long, 5=Libelle court + Picto
	 *  @return	string 			       Label of status
	 */
	function getLibStatut($mode=0)
	{
		return $this->LibStatut($this->status,$mode);
	}

	/**
	 *  Return the status
	 *
	 *  @param	int		$status        	Id status
	 *  @param  int		$mode          	0=long label, 1=short label, 2=Picto + short label, 3=Picto, 4=Picto + long label, 5=Short label + Picto, 5=Long label + Picto
	 *  @return string 			       	Label of status
	 */
	static function LibStatut($status,$mode=0)
	{
		global $langs;

		if ($mode == 0)
		{
			$prefix='';
			if ($status == 1) return $langs->trans('Enabled');
			if ($status == 0) return $langs->trans('Disabled');
		}
		if ($mode == 1)
		{
			if ($status == 1) return $langs->trans('Enabled');
			if ($status == 0) return $langs->trans('Disabled');
		}
		if ($mode == 2)
		{
			if ($status == 1) return img_picto($langs->trans('Enabled'),'statut4').' '.$langs->trans('Enabled');
			if ($status == 0) return img_picto($langs->trans('Disabled'),'statut5').' '.$langs->trans('Disabled');
		}
		if ($mode == 3)
		{
			if ($status == 1) return img_picto($langs->trans('Enabled'),'statut4');
			if ($status == 0) return img_picto($langs->trans('Disabled'),'statut5');
		}
		if ($mode == 4)
		{
			if ($status == 1) return img_picto($langs->trans('Enabled'),'statut4').' '.$langs->trans('Enabled');
			if ($status == 0) return img_picto($langs->trans('Disabled'),'statut5').' '.$langs->trans('Disabled');
		}
		if ($mode == 5)
		{
			if ($status == 1) return $langs->trans('Enabled').' '.img_picto($langs->trans('Enabled'),'statut4');
			if ($status == 0) return $langs->trans('Disabled').' '.img_picto($langs->trans('Disabled'),'statut5');
		}
		if ($mode == 6)
		{
			if ($status == 1) return $langs->trans('Enabled').' '.img_picto($langs->trans('Enabled'),'statut4');
			if ($status == 0) return $langs->trans('Disabled').' '.img_picto($langs->trans('Disabled'),'statut5');
		}
	}


	/**
	 * Initialise object with example values
	 * Id must be 0 if object instance is a specimen
	 *
	 * @return void
	 */
	public function initAsSpecimen()
	{
		$this->initAsSpecimenCommon();
	}

	
	
	static function getCategoryChild($cat,$deep=0)
	{
	    global $db;
	    
	    dol_include_once('categories/class/categorie.class.php');
	    
	    $Tlist = array();
	    
	    $category = new Categorie($db);
	    $res = $category->fetch($cat);
	    
	    $Tfilles = $category->get_filles();
	    if(!empty($Tfilles) && $Tfilles>0)
	    {
	        foreach ($Tfilles as &$fille)
	        {
	            $Tlist[] = $fille->id;
	            
	            $Tchild = getCategoryChild($fille->id,$deep++);
	            if(!empty($Tchild)){
	                $Tlist = array_merge($Tlist,$Tchild);
	            }
	        }
	    }
	    
	    return $Tlist;
	    
	}
	
	static function getCategoryParent($cat,$isParent = 0, $reverse = 0)
	{
	    global $db;
	    
	    dol_include_once('categories/class/categorie.class.php');
	    
	    $Tlist = array();
	    
	    if($isParent){
	        $Tlist[] = $cat;
	    }
	    
	    $category = new Categorie($db);
	    $res = $category->fetch($cat);
	   
	    if($res > 0 && !empty( $category->fk_parent ) )
	    {
	        $TParent = self::getCategoryParent($category->fk_parent, 1, 0);
	        if(!empty($TParent)){
                $Tlist = array_merge($Tlist,$TParent);
            }
	    }
	    
	    if($reverse){ 
	        $Tlist = array_reverse ($Tlist); 
	    }
	    
	    return $Tlist;
	    
	}
	
	
	static function prepareSearch($col, $val)
	{
	    $sql = '';
	    $in = '0';
	    if(!empty($val)){
	        
	        if(is_array($val)){
	            $val = array_map('intval', $val);
	            $in.= ','.implode(',', $val);
	        }
	        else {
	            $in.= ','.intval($val);
	        }
	        
	    }
	    $sql.= ' AND '.$col.' IN ('.$in.') '; 
	    
	    return $sql;
	}
	
	static function prepareOrderByCase($col, $val)
	{
	    $sql = $col.' DESC ';
	    
	    if(!empty($val) && is_array($val) && count($val)>1)
	    {
	        
	        $sql = ' CASE ';
	        
	        $i = 0;
	        foreach($val as $id)
	        {
	            $i++;
	            if (empty($id)){
	                continue;
	            }
	            
	            $sql.= ' WHEN '.$col.' = '.intval($id).' THEN '.$i.' ';

	        }
	        
	        $sql.= ' ELSE '.PHP_INT_SIZE.' END DESC';
	        
	    }
	    
	    return $sql;
	}
	
	/**
	 * @param number $from_quantity
	 * @param number $fk_category_product
	 * @param number $fk_category_compagny
	 * @param number $fk_compagny
	 * @param number $reduction_type
	 * @param number $date
	 * @return int <0 if KO, 0 if not found, >0 if OK
	 */
	public function fetchByCrit($from_quantity = 1, $fk_category_product = 0, $fk_category_compagny = 0, $fk_compagny = 0, $reduction_type = 0, $date = 0 )
	{
	    //var_dump($fk_category_product);
	    $sql = 'SELECT * FROM '.MAIN_DB_PREFIX.$this->table_element.' WHERE from_quantity <= '.floatval($from_quantity).' AND status = 1 ' ;
	    
	    
	    $sql.= self::prepareSearch('fk_category_product', $fk_category_product);
	    $sql.= self::prepareSearch('fk_category_compagny', $fk_category_compagny);
	    $sql.= self::prepareSearch('fk_compagny', $fk_compagny);
	    
	    
	    if(!empty($reduction_type) && in_array($reduction_type, array('amount', 'percentage'))){
	        $sql.= ' AND reduction_type = \''.$this->db->escape($reduction_type).'\'';
	    }
	    
	    
	    if(!empty($date)){
	        $date = $this->db->idate($date);
	    }
	    else {
	        $date = $this->db->idate(time()); 
	    }
	    
	    $sql.= ' AND ( date_from <= \''.$date.'\'  OR date_from IS NULL )';
	    $sql.= ' AND ( date_to >= \''.$date.'\' OR date_to IS NULL )';
	    
	    
	    $sql.= ' ORDER BY reduction DESC, from_quantity DESC, fk_compagny DESC, '.self::prepareOrderByCase('fk_category_compagny', $fk_category_compagny).', '.self::prepareOrderByCase('fk_category_product', $fk_category_product);
	    
	    $sql.= ' LIMIT 1';
	    
	    $res = $this->db->query($sql);
	    if($res)
	    {
	        if ($obj = $this->db->fetch_object($res))
	        {
	            return $this->fetch($obj->rowid);
	        }
	    }
	    else
	    {
	        $this->reserror = $this->db->error;
	        $this->lastquery = $this->db->lastquery;
	    }
	    //print '<p>'.$sql.'</p>';
	    return 0;
	}
}
