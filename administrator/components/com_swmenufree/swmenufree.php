<?php

/**
 * swmenufree v6.0
 * http://swmenupro.com
 * Copyright 2006 Sean White
 * */

// ensure this file is being included by a parent file
//error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// no direct access
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!JFactory::getUser()->authorise('core.manage', 'com_swmenufree')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}


jimport( 'joomla.application.component.controller' );
$absolute_path=JPATH_ROOT;
$task=JRequest::getVar('task');
if (file_exists($absolute_path.'/administrator/components/com_swmenufree/language/default.ini'))
{
    if($task=='changelanguage'){
         $lang = JRequest::getVar('language', "english.php");
      include($absolute_path.'/administrator/components/com_swmenufree/language/'.$lang);  
    }else{
$filename = $absolute_path.'/administrator/components/com_swmenufree/language/default.ini';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
include($absolute_path.'/administrator/components/com_swmenufree/language/'.$contents);
    }
}

require_once( JPATH_COMPONENT.'/admin.swmenufree.html.php' ) ;

switch ($task) {
    case 'preview':
        preview();
        break;

   case "saveedit":
        JToolbarHelper::title(JText::_('swMenuFree: Menu Module Editor'));
        saveconfig();
        break;

    case 'changelanguage':
         JToolbarHelper::title(JText::_('swMenuFree: Upgrade/Repair swMenuFree'));
        changeLanguage();
        break;

    case 'uploadfile':
        uploadPackage();
        break;

     case 'get_cufon':
	HTML_swmenufree::uploadCufon( );
	break;
    
    case 'upload_ttf':
        upload_ttf();
        break;

    case 'upload_ttf_file':
        upload_ttf_file();
        break;

    case "upgrade":
         JToolbarHelper::title(JText::_('swMenuFree: Upgrade/Repair swMenuFree'));
        upgrade();
        break;

    case "manualsave":
         JToolbarHelper::title(JText::_('swMenuFree: Manual Edit CSS File'));
        saveCSS();
        break;

    case "editDhtmlMenu":
         JToolbarHelper::title(JText::_('swMenuFree: Menu Module Editor'));
        editDhtmlMenu();
        break;

    case "editCSS":
        JToolbarHelper::title(JText::_('swMenuFree: Manual Edit CSS File'));
        editCSS();
        break;

    default:
        JToolbarHelper::title(JText::_('swMenuFree: Menu Module Editor'));
        editDhtmlMenu();
        break;
}

function preview( )
{	
	$absolute_path=JPATH_ROOT;
	include($absolute_path.'/administrator/components/com_swmenufree/preview.php');
}

function editDhtmlMenu() {
  
	$absolute_path=JPATH_ROOT;
        
        
         if (!file_exists($absolute_path . '/modules/mod_swmenufree/mod_swmenufree.xml')) {
           echo "<dl id=\"system-message\"><dt class=\"message\">Message</dt>
		<dd class=\"\"><ul><li>swMenuFree module is missing</li>
	   </ul></dd></dl>\n";
          upgrade('com_swmenufree');
         
         }else{
	$config =& JFactory::getConfig();
$dbprefix= $config->get( 'dbprefix' );
$db= $config->get( 'db' );
$database = &JFactory::getDBO();


$sql="SELECT COUNT(*) FROM #__modules where module='mod_swmenufree' and published > -1";
	$database->setQuery($sql);
	$modcount=$database->loadResult();
        if($modcount>1){
            
            echo "<dl id=\"system-message\"><dt class=\"message\">Message</dt>
		<dd class=\"\"><ul><li>More Than one swMenuFree module has been detected.  This will cause errors.  Please remove one of the swMenuFree modules using the Joomla module manager</li>
	   </ul></dd></dl>\n";
            
            
            
        }

	$sql="SELECT id FROM #__modules where module='mod_swmenufree' AND published > -1";
	$database->setQuery($sql);
	$id=$database->loadResult();
	
	$row 	=& JTable::getInstance('module');
	// load the row from the db table
	$row->load( $id );

$sql="SELECT * FROM #__swmenufree_styles where id=1";
	$database->setQuery($sql);
	$swmenufree=$database->loadObject();
  
    $params = sw_stringToObject($swmenufree->params);
  $row2= new stdClass();   
//$row2=array();
while (list ($key, $val) = each($params)) {
   
    $row2->$key = $val;
}

    $lists = array();
   
    $cssload[] = JHTML::_('select.option', '0', _SW_CSS_DYNAMIC_SELECT);
    $cssload[] = JHTML::_('select.option', '1', _SW_CSS_LINK_SELECT);
    //$cssload[]= JHTML::_('select.option', '2', _SW_CSS_IMPORT_SELECT );
    $cssload[] = JHTML::_('select.option', '3', _SW_CSS_NONE_SELECT);
    $lists['cssload'] = JHTML::_('select.genericlist', $cssload, 'cssload', 'id="cssload" class="inputbox" size="1" style="width:200px" ', 'value', 'text', $row2->cssload ? $row2->cssload : '0' );

   
    $tables[] = JHTML::_('select.option', '0', _SW_SHOW_TABLES_SELECT);
    $tables[] = JHTML::_('select.option', '1', _SW_SHOW_BLOGS_SELECT);
    $lists['tables'] = JHTML::_('select.genericlist', $tables, 'tables', 'id="tables" class="inputbox" size="1" style="width:200px" ', 'value', 'text', $row2->tables ? $row2->tables : '0' );

//echo $menutype;
    if ($row2->menustyle == "mygosumenu") {
        $extra2[] = JHTML::_('select.option', 'none', _SW_SPECIAL_EFFECTS_NONE);
        $extra2[] = JHTML::_('select.option', 'slide', _SW_SPECIAL_EFFECTS_SLIDE);
        $extra2[] = JHTML::_('select.option', 'fade', _SW_SPECIAL_EFFECTS_FADE);
        // $extra2[]= JHTML::_('select.option', 'slide/fade', "Slide and Fade" );
        $lists['extra'] = JHTML::_('select.genericlist', $extra2, 'extra', 'id="extra" class="inputbox" size="1" style="width:200px" ', 'value', 'text', $row2->extra ? $row2->extra : 'none' );
    }
    if ($row2->menustyle == "superfishmenu") {
        $extra2[] = JHTML::_('select.option', 'none', _SW_SPECIAL_EFFECTS_NONE);
        $extra2[] = JHTML::_('select.option', 'fade', 'Fade');
        $extra2[] = JHTML::_('select.option', 'slide-down', 'Slide Down');
        $extra2[] = JHTML::_('select.option', 'slide-right', "Slide Right");
        $lists['extra'] = JHTML::_('select.genericlist', $extra2, 'extra', 'id="extra" class="inputbox" size="1" style="width:200px" ', 'value', 'text', $row2->extra ? $row2->extra : 'none' );
    }
    if ($row2->menustyle == "transmenu") {

        $extra2[] = JHTML::_('select.option', '0', _SW_SPECIAL_EFFECTS_NONE);
        $extra2[] = JHTML::_('select.option', '1', "Submenu Shadow");
        //$extra2[]= JHTML::_('select.option', 'fade', _SW_SPECIAL_EFFECTS_FADE );
        // $extra2[]= JHTML::_('select.option', 'slide/fade', "Slide and Fade" );
        $lists['extra'] = JHTML::_('select.genericlist', $extra2, 'extra', 'id="extra" class="inputbox" size="1" style="width:200px" ', 'value', 'text', $row2->extra ? $row2->extra : 'none' );
    }

    $lists['levels'] = JHTML::_('select.integerlist', 0, 10, 1, 'levels', 'class="inputbox" size="1" style="width:200px"', $row2->levels);
    
    $cssload = array();
    $cssload[] = JHTML::_('select.option', 'none', 'none');
    $cssload[] = JHTML::_('select.option', 'curvycorner', 'curvyCorners');
    $cssload[] = JHTML::_('select.option', 'round', 'Round');
    $cssload[] = JHTML::_('select.option', 'bevel', 'Bevel');
    $cssload[] = JHTML::_('select.option', 'notch', 'Notch');
    $cssload[] = JHTML::_('select.option', 'bite', 'Bite');
    $cssload[] = JHTML::_('select.option', 'cool', 'Cool');
    $cssload[] = JHTML::_('select.option', 'sharp', 'Sharp');
    $cssload[] = JHTML::_('select.option', 'slide', 'Slide');
    $cssload[] = JHTML::_('select.option', 'jut', 'Jut');
    $cssload[] = JHTML::_('select.option', 'curl', 'Curl');
    $cssload[] = JHTML::_('select.option', 'tear', 'Tear');
    $cssload[] = JHTML::_('select.option', 'fray', 'Fray');
    $cssload[] = JHTML::_('select.option', 'wicked', 'Wicked');
    $cssload[] = JHTML::_('select.option', 'sculpt', 'Sculpt');
    $cssload[] = JHTML::_('select.option', 'long', 'Long');
    $cssload[] = JHTML::_('select.option', 'dog', 'Dog Ear 1');
    $cssload[] = JHTML::_('select.option', 'dog2', 'Dog Ear 2');
    $cssload[] = JHTML::_('select.option', 'dog3', 'Dog Ear 3');

    //$row2->c_corner_size=$c_corner_size;
    $lists['c_corner_style'] = JHTML::_('select.genericlist', $cssload, 'c_corner_style', 'id="c_corner_style" onchange="do_complete_corner();" class="inputbox"  size="1" style="width:200px"', 'value', 'text', $row2->c_corner_style);
    //$lists['c_corner_size'] = JHTML::_('select.integerlist',0,100,1, 'c_corner_size', 'onchange="do_complete_corner();" id="c_corner_size" class="inputbox"', $c_corner_size );

    $lists['c_corner_size'] = "<input type='text' name='c_corner_size' onchange='do_complete_corner();' id='c_corner_size' class='inputbox' size='3' value='" . $row2->c_corner_size . "' >";


    $lists['t_corner_style'] = JHTML::_('select.genericlist', $cssload, 't_corner_style', 'id="t_corner_style" onchange="do_top_corner();" class="inputbox"  size="1" style="width:200px"', 'value', 'text', $row2->t_corner_style);
    //$lists['t_corner_size'] = JHTML::_('select.integerlist',0,100,1, 't_corner_size', 'class="inputbox"', $t_corner_size );
    $lists['t_corner_size'] = "<input type='text' name='t_corner_size' onchange='do_top_corner();' id='t_corner_size' class='inputbox' size='3' value='" . $row2->t_corner_size . "' >";


    $lists['s_corner_style'] = JHTML::_('select.genericlist', $cssload, 's_corner_style', 'id="s_corner_style"  onchange="do_sub_corner();" class="inputbox"  size="1" style="width:200px"', 'value', 'text', $row2->s_corner_style);
    $lists['s_corner_size'] = "<input type='text' name='s_corner_size' onchange='do_sub_corner();' id='s_corner_size' class='inputbox' size='3' value='" . $row2->s_corner_size . "' >";

    if (@$row2->ctl_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['ctl_corner'] = "<input type='checkbox' onchange='do_complete_corner();' id='ctl_corner' name='ctl_corner' value='1' " . $tex . " />";
    if (@$row2->ctr_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['ctr_corner'] = "<input type='checkbox' onchange='do_complete_corner()' id='ctr_corner' name='ctr_corner' value='1' " . $tex . " />";
    if (@$row2->cbl_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['cbl_corner'] = "<input type='checkbox' onchange='do_complete_corner()' id='cbl_corner' name='cbl_corner' value='1' " . $tex . " />";
    if (@$row2->cbr_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['cbr_corner'] = "<input type='checkbox' onchange='do_complete_corner()' id='cbr_corner' name='cbr_corner' value='1' " . $tex . " />";

    if (@$row2->ttl_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['ttl_corner'] = "<input type='checkbox' onchange='do_top_corner();' id='ttl_corner' name='ttl_corner' value='1' " . $tex . " />";
    if (@$row2->ttr_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['ttr_corner'] = "<input type='checkbox' onchange='do_top_corner();' id='ttr_corner' name='ttr_corner' value='1' " . $tex . " />";
    if (@$row2->tbl_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['tbl_corner'] = "<input type='checkbox' onchange='do_top_corner();' id='tbl_corner' name='tbl_corner' value='1' " . $tex . " />";
    if (@$row2->tbr_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['tbr_corner'] = "<input type='checkbox' onchange='do_top_corner();' id='tbr_corner' name='tbr_corner' value='1' " . $tex . " />";

    if (@$row2->stl_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['stl_corner'] = "<input type='checkbox' onchange='do_sub_corner();' id='stl_corner' name='stl_corner' value='1' " . $tex . " />";
    if (@$row2->str_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['str_corner'] = "<input type='checkbox' onchange='do_sub_corner();' id='str_corner' name='str_corner' value='1' " . $tex . " />";
    if (@$row2->sbl_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['sbl_corner'] = "<input type='checkbox' onchange='do_sub_corner();' id='sbl_corner' name='sbl_corner' value='1' " . $tex . " />";
    if (@$row2->sbr_corner == 1) {
        $tex = "checked='checked'";
    } else {
        $tex = "";
    }
    $lists['sbr_corner'] = "<input type='checkbox' onchange='do_sub_corner();' id='sbr_corner' name='sbr_corner' value='1' " . $tex . " />";


    $lists['top_sub_indicator'] = "<img id='top_sub' src='../" . ($row2->top_sub_indicator ? $row2->top_sub_indicator : 'modules/mod_swmenufree/images/empty.gif') . "'  align='middle' /><input type='hidden' id='top_sub_indicator' name='top_sub_indicator' value='" . $row2->top_sub_indicator . "' />";
    $lists['sub_sub_indicator'] = "<img id='sub_sub' src='../" . ($row2->sub_sub_indicator ? $row2->sub_sub_indicator : 'modules/mod_swmenufree/images/empty.gif') . "'  align='middle' /><input type='hidden' id='sub_sub_indicator' name='sub_sub_indicator' value='" . $row2->sub_sub_indicator . "' />";

    
    $lists['top_sub_indicator_top'] = "<input type=\"text\" size=\"4\" id=\"top_sub_indicator_top\" name=\"top_sub_indicator_top\" value=\"" . $row2->top_sub_indicator_top . "\" />";
    $lists['top_sub_indicator_left'] = "<input type=\"text\" size=\"4\" id=\"top_sub_indicator_left\" name=\"top_sub_indicator_left\" value=\"" . $row2->top_sub_indicator_left . "\" />";

    $lists['sub_sub_indicator_top'] = "<input type=\"text\" size=\"4\" id=\"sub_sub_indicator_top\" name=\"sub_sub_indicator_top\" value=\"" . $row2->sub_sub_indicator_top . "\" />";
    $lists['sub_sub_indicator_left'] = "<input type=\"text\" size=\"4\" id=\"sub_sub_indicator_left\" name=\"sub_sub_indicator_left\" value=\"" . $row2->sub_sub_indicator_left . "\" />";

     $yesno = array();
    $yesno[] = JHTML::_('select.option', '1', _SW_YES);
    $yesno[] = JHTML::_('select.option', '0', _SW_NO);
     $lists['active_menu'] = JHTML::_('select.genericlist', $yesno, 'active_menu', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->active_menu);
     $lists['padding_hack'] = JHTML::_('select.genericlist', $yesno, 'padding_hack', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->padding_hack);
    $lists['auto_position'] = JHTML::_('select.genericlist', $yesno, 'auto_position', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->auto_position);
     $lists['overlay_hack'] = JHTML::_('select.genericlist', $yesno, 'overlay_hack', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->overlay_hack);
      $lists['disable_jquery'] = JHTML::_('select.genericlist', $yesno, 'disable_jquery', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->disable_jquery);
     $lists['flash_hack'] = JHTML::_('select.genericlist', $yesno, 'flash_hack', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->flash_hack);
     $lists['hybrid'] = JHTML::_('select.genericlist', $yesno, 'hybrid', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->hybrid);
      $lists['tablet_hack'] = JHTML::_('select.genericlist', $yesno, 'tablet_hack', 'class="inputbox" size="1" style="width:100px;"', 'value', 'text', $row2->tablet_hack);
  
  
    
    // build the html select list for published
 //   $lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published ? $row->published : 0);

    $query = 'SELECT DISTINCT #__menu.menutype AS value FROM #__menu';
    $database->setQuery($query);
    $menutypes = $database->loadObjectList();
    //$menutypes3[]= JHTML::_('select.option', '-999', 'Select Source Menu' );
    //$menutypes3[]= JHTML::_('select.option', '-999', '-----------------' );
    $menutypes3[] = JHTML::_('select.option', 'swcontentmenu', _SW_SOURCE_CONTENT_SELECT);
    $menutypes3[] = JHTML::_('select.option', '-999', '-----------------');
    if (TableExists($dbprefix . "virtuemart_configs")) {
        $menutypes3[] = JHTML::_('select.option', 'virtuemart2', 'Virtuemart2 Categories');
        $menutypes3[] = JHTML::_('select.option', 'virtueprod2', 'Virtuemart2 Products');
        $menutypes3[] = JHTML::_('select.option', '-999', '-----------------');
    }else if (TableExists($dbprefix . "vm_category")) {
        $menutypes3[] = JHTML::_('select.option', 'virtuemart', 'Virtuemart Categories');
        $menutypes3[] = JHTML::_('select.option', 'virtueprod', 'Virtuemart Products');
        $menutypes3[] = JHTML::_('select.option', '-999', '-----------------');
    }
    if (file_exists($absolute_path . "/components/com_mtree/mtree.php")) {
        $menutypes3[] = JHTML::_('select.option', 'mosetstree', 'Mosets Tree component');
        //$menutypes3[]= JHTML::_('select.option', 'virtueprod', 'Virtuemart Products' );
        $menutypes3[] = JHTML::_('select.option', '-999', '-----------------');
    }
    $menutypes3[] = JHTML::_('select.option', '-999', _SW_SOURCE_EXISTING_SELECT);
    $menutypes3[] = JHTML::_('select.option', '-999', '-----------------');



    foreach($menutypes as $menutypes2){
		$menutypes3[]= JHTML::_('select.option', addslashes($menutypes2->value), addslashes($menutypes2->value) );
	}
	$lists['menutype']= JHTML::_('select.genericlist', $menutypes3, 'menutype',' id="menutype" class="inputbox" size="1" style="width:200px" onchange="changeDynaList(\'parentid\',orders2,document.getElementById(\'menutype\').options[document.getElementById(\'menutype\').selectedIndex].value, originalPos2, originalOrder2);"','value', 'text', $row2->menutype ? $row2->menutype : 'mainmenu' );
	$categories3[]= JHTML::_('select.option', 0, 'TOP' );

	$sql =  "SELECT DISTINCT #__categories.id AS value, #__categories.title AS text, #__categories.extension, #__categories.level AS level
                FROM #__categories                                  
                INNER JOIN #__content ON #__content.catid = #__categories.id
                WHERE #__categories.published = 1
                AND #__categories.extension='com_content'
                ORDER BY #__categories.lft
                
                ";
	$database->setQuery( $sql );
	$categories = $database->loadObjectList();

	foreach($categories as $categories2){
		$categories3[]= JHTML::_('select.option', ($categories2->value), (str_repeat("- ",$categories2->level).$categories2->text) );
	}

	foreach($categories3 as $category){
		$menuitems['swcontentmenu'][] = JHTML::_('select.option', $category->value, addslashes($category->text) );

	}
    if (file_exists($absolute_path . "/components/com_virtuemart/virtuemart.php")) {
        $categories4[] = JHTML::_('select.option', 0, 'All Categories (top)');

 
   if (TableExists($dbprefix . "virtuemart_configs")) {
        $sql = "SELECT  #__virtuemart_configs.config
                FROM #__virtuemart_configs
                WHERE #__virtuemart_configs.virtuemart_config_id=1";
         $database->setQuery($sql);
         $result=$database->loadResult();
       
       $config = explode('|', $result);
			foreach($config as $item){
				$item = explode('=',$item);
				if(!empty($item[1])){
					// if($item[0]!=='offline_message' && $item[0]!=='dateformat' ){
					if($item[0]!=='offline_message' ){
						$pair[$item[0]] = unserialize($item[1] );
					} else {
						$pair[$item[0]] = unserialize(base64_decode($item[1]) );
					}

				} else {
					$pair[$item[0]] ='';
				}

			}
$vmlang= $pair['vmlang']?$pair['vmlang']:"en_gb";
//echo $vmlang;
        
        $sql = "SELECT DISTINCT #__virtuemart_categories_".$vmlang.".virtuemart_category_id AS value, #__virtuemart_categories_".$vmlang.".category_name AS text
                FROM #__virtuemart_categories_".$vmlang;
    }else{
        $sql = "SELECT DISTINCT #__vm_category.category_id AS value, #__vm_category.category_name AS text
                FROM #__vm_category ";
        
    }
        $database->setQuery($sql);
        $sections = $database->loadObjectList();
        $categories4[] = JHTML::_('select.option', -999, '--------');
        $categories4[] = JHTML::_('select.option', -999, 'Categories');
        $categories4[] = JHTML::_('select.option', -999, '--------');
        foreach ($sections as $sections2) {
            $categories4[] = JHTML::_('select.option', ($sections2->value+10000), $sections2->text);
        }

        foreach ($categories4 as $category) {
            $menuitems['virtuemart'][] = JHTML::_('select.option', $category->value, addslashes($category->text));
            $menuitems['virtueprod'][] = JHTML::_('select.option', $category->value, addslashes($category->text));
            $menuitems['virtuemart2'][] = JHTML::_('select.option', $category->value, addslashes($category->text));
            $menuitems['virtueprod2'][] = JHTML::_('select.option', $category->value, addslashes($category->text));
        }
    }
    $menuitems2=array();
	$database->setQuery( "SELECT m.*"
	. "\n FROM #__menu m"
	//. "\n WHERE type != 'url'"
	//. "\n WHERE type != 'separator'"
	. "\n WHERE published = '1'"
	. "\n AND parent_id!='0'"
	. "\n ORDER BY menutype, parent_id"
	);
	$mitems = $database->loadObjectList();
	$mitems_temp = $mitems;

	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ( $mitems as $v ) {
		$id = $v->id;
		$pt = $v->parent_id;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	// second pass - get an indent list of the items
	$list = swmenuTreeRecurse( intval( $mitems[0]->parent_id ), '', array(), $children );

	// Code that adds menu name to Display of Page(s)
	$text_count = "0";
	$mitems_spacer = "";
	foreach ($list as $list_a) {
		foreach ($mitems_temp as $mitems_a) {
			if ($mitems_a->id == $list_a->id) {
				// Code that inserts the blank line that seperates different menus
				if ($mitems_a->menutype <> $mitems_spacer) {
					//$list_temp[] = JHTML::_('select.option', -99, "----------" );
					$list_temp[] = JHTML::_('select.option', -99, "--------------" );
					$list_temp[] = JHTML::_('select.option', -99, $mitems_a->menutype );
					$list_temp[] = JHTML::_('select.option', -99, "--------------" );
					$menuitems[$mitems_a->menutype][] = JHTML::_('select.option', 0, "TOP" );
					$mitems_spacer = $mitems_a->menutype;
				}
				$text = addslashes("- ".$list_a->treename);
				$text2 = addslashes($list_a->treename);
				$list_temp[] = JHTML::_('select.option', $list_a->id, $text );
				$menuitems[$mitems_a->menutype][] = JHTML::_('select.option', $list_a->id, $text2 );
				if ( strlen($text) > $text_count) {
					$text_count = strlen($text);
				}
			}
		}
	}
	$list = $list_temp;

	
    $align[] = JHTML::_('select.option', 'left', 'left');
    $align[] = JHTML::_('select.option', 'right', 'right');
    $lists['top_sub_indicator_align'] = JHTML::_('select.genericlist', $align, 'top_sub_indicator_align', 'id="top_sub_indicator_align" size="1" class="inputbox" style="width:100px"', 'value', 'text', $row2->top_sub_indicator_align);
    $lists['sub_sub_indicator_align'] = JHTML::_('select.genericlist', $align, 'sub_sub_indicator_align', 'id="sub_sub_indicator_align" size="1" class="inputbox" style="width:100px"', 'value', 'text', $row2->sub_sub_indicator_align);

    $align = array();
    $align[] = JHTML::_('select.option', '', 'none');
    $align[] = JHTML::_('select.option', 'italic', 'italic');
    $align[] = JHTML::_('select.option', 'oblique', 'oblique');
    $align[] = JHTML::_('select.option', 'underline', 'underline');
    $align[] = JHTML::_('select.option', 'line-through', 'line-through');
    $align[] = JHTML::_('select.option', 'overline', 'overline');
    $align[] = JHTML::_('select.option', 'uppercase', 'uppercase');
    $align[] = JHTML::_('select.option', 'lowercase', 'lowercase');
    $align[] = JHTML::_('select.option', 'capitalize', 'capitalize');
    $lists['top_font_extra'] = JHTML::_('select.genericlist', $align, 'top_font_extra', 'id="top_font_extra" onchange="do_top_font_extra();" size="1" class="inputbox"', 'value', 'text', $row2->top_font_extra);
    $lists['sub_font_extra'] = JHTML::_('select.genericlist', $align, 'sub_font_extra', 'id="sub_font_extra" onchange="do_sub_font_extra();" size="1" class="inputbox"', 'value', 'text', $row2->sub_font_extra);

    $yesno = array();
    $yesno[] = JHTML::_('select.option', 'normal', "Wrap text");
    $yesno[] = JHTML::_('select.option', 'nowrap', "No text Wrapping");
    $lists['top_wrap'] = JHTML::_('select.genericlist', $yesno, 'top_wrap', 'class="inputbox" size="1" id="top_wrap" onchange="jQuery(\'.top_preview\').css(\'white-space\',this.value);" ', 'value', 'text', $row2->top_wrap);
    $lists['sub_wrap'] = JHTML::_('select.genericlist', $yesno, 'sub_wrap', 'class="inputbox" size="1" id="sub_wrap" onchange="jQuery(\'.sub_preview\').css(\'white-space\',this.value);"', 'value', 'text', $row2->sub_wrap);


    $cssload = array();
    $cssload[] = JHTML::_('select.option', 'none', 'none');
    $cssload[] = JHTML::_('select.option', 'solid', 'solid');
    $cssload[] = JHTML::_('select.option', 'dashed', 'dashed');
    $cssload[] = JHTML::_('select.option', 'inset', 'inset');
    $cssload[] = JHTML::_('select.option', 'outset', 'outset');
    $cssload[] = JHTML::_('select.option', 'groove', 'groove');
    $cssload[] = JHTML::_('select.option', 'double', 'double');
    $lists['main_border_style'] = JHTML::_('select.genericlist', $cssload, 'main_border_style', 'id="main_border_style" class="inputbox" onchange="doMainBorder();" size="1" style="width:100px"', 'value', 'text', $row2->main_border_style);
    $lists['sub_border_style'] = JHTML::_('select.genericlist', $cssload, 'sub_border_style', 'id="sub_border_style" class="inputbox" onchange="doSubBorder();" size="1" style="width:100px"', 'value', 'text', $row2->sub_border_style);
    $lists['main_border_over_style'] = JHTML::_('select.genericlist', $cssload, 'main_border_over_style', 'id="main_border_over_style" class="inputbox" onchange="doMainBorder();" size="1" style="width:100px"', 'value', 'text', $row2->main_border_over_style);
    $lists['sub_border_over_style'] = JHTML::_('select.genericlist', $cssload, 'sub_border_over_style', 'id="sub_border_over_style" class="inputbox" onchange="doSubBorder();" size="1" style="width:100px"', 'value', 'text', $row2->sub_border_over_style);

    
    $cssload = array();
    $cssload[] = JHTML::_('select.option', 'Arial, Helvetica, sans-serif', 'Arial, Helvetica, sans-serif');
    $cssload[] = JHTML::_('select.option', 'Times New Roman, Times, serif', 'Times New Roman, Times, serif');
    $cssload[] = JHTML::_('select.option', 'Georgia, Times New Roman, Times, serif', 'Georgia, Times New Roman, Times, serif');
    $cssload[] = JHTML::_('select.option', 'Verdana, Arial, Helvetica, sans-serif', 'Verdana, Arial, Helvetica, sans-serif');
    $cssload[] = JHTML::_('select.option', 'Geneva, Arial, Helvetica, sans-serif', 'Geneva, Arial, Helvetica, sans-serif');
    $cssload[] = JHTML::_('select.option', 'Tahoma, Arial, sans-serif', 'Tahoma, Arial, sans-serif');
    $lists['font_family'] = JHTML::_('select.genericlist', $cssload, 'font_family', 'id="font_family" onchange="jQuery(\'.top_preview\').css(\'font-family\',this.value);" class="inputbox" size="1" style="width:230px"', 'value', 'text', $row2->font_family);
    $lists['sub_font_family'] = JHTML::_('select.genericlist', $cssload, 'sub_font_family', 'id="sub_font_family" onchange="jQuery(\'.sub_preview\').css(\'font-family\',this.value);" class="inputbox" size="1" style="width:230px"', 'value', 'text', $row2->sub_font_family);

   
    $cssload = array();
    $cssload[] = JHTML::_('select.option', 'normal', 'normal');
    $cssload[] = JHTML::_('select.option', 'bold', 'bold');
    $cssload[] = JHTML::_('select.option', 'bolder', 'bolder');
    $cssload[] = JHTML::_('select.option', 'lighter', 'lighter');
    $lists['font_weight'] = JHTML::_('select.genericlist', $cssload, 'font_weight', 'id="font_weight" onchange="jQuery(\'.top_preview\').css(\'font-weight\',this.value);" class="inputbox" size="1" style="width:100px"', 'value', 'text', $row2->font_weight);
    $lists['font_weight_over'] = JHTML::_('select.genericlist', $cssload, 'font_weight_over', 'id="font_weight_over" onchange="jQuery(\'.sub_preview\').css(\'font-weight\',this.value);" class="inputbox" size="1" style="width:100px"', 'value', 'text', $row2->font_weight_over);

    $cssload = array();
    $cssload[] = JHTML::_('select.option', 'left', 'left');
    $cssload[] = JHTML::_('select.option', 'right', 'right');
    $cssload[] = JHTML::_('select.option', 'center', 'center');
    $cssload[] = JHTML::_('select.option', 'justify', 'justify');
    $lists['main_align'] = JHTML::_('select.genericlist', $cssload, 'main_align', 'id="main_align" onchange="jQuery(\'.top_preview\').css(\'text-align\',this.value);" class="inputbox" size="1" style="width:100px"', 'value', 'text', $row2->main_align);
    $lists['sub_align'] = JHTML::_('select.genericlist', $cssload, 'sub_align', 'id="sub_align" onchange="jQuery(\'.sub_preview\').css(\'text-align\',this.value);" class="inputbox" size="1" style="width:100px"', 'value', 'text', $row2->sub_align);

   
    $cssload = array();
    $cssload[] = JHTML::_('select.option', 'left', 'left');
    $cssload[] = JHTML::_('select.option', 'right', 'right');
    $cssload[] = JHTML::_('select.option', 'center', 'center');
    $lists['position'] = JHTML::_('select.genericlist', $cssload, 'position', 'id="position" class="inputbox" size="1" style="width:120px"', 'value', 'text', $row2->position ? $row2->position : '0' );


    $cssload=array();
	$cssload[]= JHTML::_('select.option', 'left top', 'left top' );
	$cssload[]= JHTML::_('select.option', 'left center', 'left center' );
	$cssload[]= JHTML::_('select.option', 'left bottom', 'left bottom' );
	$cssload[]= JHTML::_('select.option', 'right top', 'right top' );
	$cssload[]= JHTML::_('select.option', 'right center', 'right center' );
	$cssload[]= JHTML::_('select.option', 'right bottom', 'right bottom' );
        $cssload[]= JHTML::_('select.option', 'center top', 'center top' );
	$cssload[]= JHTML::_('select.option', 'center center', 'center center' );
	$cssload[]= JHTML::_('select.option', 'center bottom', 'center bottom' );
	$lists['complete_background_position']= JHTML::_('select.genericlist', $cssload, 'complete_background_position','id="complete_background_position" class="inputbox" size="1" onchange="$(\'#top_preview_outer\').css(\'background-position\',this.value);" style="width:120px"','value', 'text', $row2->complete_background_position ? $row2->complete_background_position : 'left top' );
	$lists['active_background_position']= JHTML::_('select.genericlist', $cssload, 'active_background_position','id="active_background_position" class="inputbox" size="1" onchange="$(\'#top_preview_active\').css(\'background-position\',this.value);" style="width:120px"','value', 'text', $row2->active_background_position ? $row2->active_background_position : 'left top' );
	$lists['top_background_position']= JHTML::_('select.genericlist', $cssload, 'top_background_position','id="top_background_position" class="inputbox" size="1" onchange="$(\'.top_preview.normal\').css(\'background-position\',this.value);" style="width:120px"','value', 'text', $row2->top_background_position ? $row2->top_background_position : 'left top' );
	$lists['top_hover_background_position']= JHTML::_('select.genericlist', $cssload, 'top_hover_background_position','id="top_hover_background_position" class="inputbox" size="1" onchange="$(\'#top_preview_hover\').css(\'background-position\',this.value);" style="width:120px"','value', 'text', $row2->top_hover_background_position ? $row2->top_hover_background_position : 'left top' );
	$lists['sub_background_position']= JHTML::_('select.genericlist', $cssload, 'sub_background_position','id="sub_background_position" class="inputbox" size="1" onchange="$(\'#sub_preview_outer\').css(\'background-position\',this.value);" style="width:120px"','value', 'text', $row2->sub_background_position ? $row2->sub_background_position : 'left top' );
	$lists['sub_hover_background_position']= JHTML::_('select.genericlist', $cssload, 'sub_hover_background_position','id="sub_hover_background_position" class="inputbox" size="1" onchange="$(\'#sub_preview_hover\').css(\'background-position\',this.value);" style="width:120px"','value', 'text', $row2->sub_hover_background_position ? $row2->sub_hover_background_position : 'left top' );
	
        
         $cssload=array();
	$cssload[]= JHTML::_('select.option', 'repeat', 'repeat' );
	$cssload[]= JHTML::_('select.option', 'repeat-x', 'repeat-x' );
	$cssload[]= JHTML::_('select.option', 'repeat-y', 'repeat-y' );
	$cssload[]= JHTML::_('select.option', 'no-repeat', 'no-repeat' );
	$lists['complete_background_repeat']= JHTML::_('select.genericlist', $cssload, 'complete_background_repeat','id="complete_background_repeat" class="inputbox" size="1" onchange="$(\'#top_preview_outer\').css(\'background-repeat\',this.value);" style="width:100px"','value', 'text', $row2->complete_background_repeat ? $row2->complete_background_repeat : 'repeat' );
	$lists['active_background_repeat']= JHTML::_('select.genericlist', $cssload, 'active_background_repeat','id="active_background_repeat" class="inputbox" size="1" onchange="$(\'#top_preview_active\').css(\'background-repeat\',this.value);" style="width:100px"','value', 'text', $row2->active_background_repeat ? $row2->active_background_repeat : 'repeat' );
	$lists['top_background_repeat']= JHTML::_('select.genericlist', $cssload, 'top_background_repeat','id="top_background_repeat" class="inputbox" size="1" onchange="$(\'.top_preview.normal\').css(\'background-repeat\',this.value);" style="width:100px"','value', 'text', $row2->top_background_repeat ? $row2->top_background_repeat : 'repeat' );
	$lists['top_hover_background_repeat']= JHTML::_('select.genericlist', $cssload, 'top_hover_background_repeat','id="top_hover_background_repeat" class="inputbox" size="1" onchange="$(\'#top_preview_hover\').css(\'background-repeat\',this.value);" style="width:100px"','value', 'text', $row2->top_hover_background_repeat ? $row2->top_hover_background_repeat : 'repeat' );
	$lists['sub_background_repeat']= JHTML::_('select.genericlist', $cssload, 'sub_background_repeat','id="sub_background_repeat" class="inputbox" size="1" onchange="$(\'#sub_preview_outer\').css(\'background-repeat\',this.value);" style="width:100px"','value', 'text', $row2->sub_background_repeat ? $row2->sub_background_repeat : 'repeat' );
	$lists['sub_hover_background_repeat']= JHTML::_('select.genericlist', $cssload, 'sub_hover_background_repeat','id="sub_hover_background_repeat" class="inputbox" size="1" onchange="$(\'#sub_preview_hover\').css(\'background-repeat\',this.value);" style="width:100px"','value', 'text', $row2->sub_hover_background_repeat ? $row2->sub_hover_background_repeat : 'repeat' );
	

    $cssload = array();

    if ($row2->menustyle == "transmenu" || $row2->menustyle == "mygosumenu") {
        $cssload[] = JHTML::_('select.option', 'horizontal/down', 'horizontal/down/right');
        $cssload[] = JHTML::_('select.option', 'vertical/right', 'vertical/right');
        $cssload[] = JHTML::_('select.option', 'horizontal/up', 'horizontal/up');
        $cssload[] = JHTML::_('select.option', 'vertical/left', 'vertical/left');
        $cssload[] = JHTML::_('select.option', 'horizontal/left', 'horizontal/down/left');
    } else {
        $cssload[] = JHTML::_('select.option', 'horizontal', 'horizontal');
        $cssload[] = JHTML::_('select.option', 'vertical', 'vertical');
    }

    $lists['orientation'] = JHTML::_('select.genericlist', $cssload, 'orientation', 'id="orientation" onchange="change_orientation();" class="inputbox" size="1" style="width:160px"', 'value', 'text', $row2->orientation ? $row2->orientation : '0' );

    $basedir = $absolute_path . "/modules/mod_swmenufree/fonts/";
    $handle = opendir($basedir);
    $font = array();
    $font[] = JHTML::_('select.option', "", "None");
    while ($file = readdir($handle)) {
        if ($file == "." || $file == ".." || $file == "default.ini") {
            
        } else {
            $filename = file_get_contents('' . $absolute_path . '/modules/mod_swmenufree/fonts/' . $file . '');
            $pos_start = strpos($filename, "font-family") + 14;
            $pos_end = strpos($filename, "\"", $pos_start) - $pos_start;
            $fontname = substr($filename, $pos_start, $pos_end);
            $font[] = JHTML::_('select.option', $file, $fontname);
        }
    }
        $lists['topTTF'] = JHTML::_('select.genericlist', $font, 'top_ttf', 'id="top_ttf" onchange="do_top_ttf();" class="inputbox" size="1" style="width:200px"', 'value', 'text', $row2->top_ttf);
        $lists['subTTF'] = JHTML::_('select.genericlist', $font, 'sub_ttf', 'id="sub_ttf" onchange="do_sub_ttf();" class="inputbox" size="1" style="width:200px"', 'value', 'text', $row2->sub_ttf);
    
    closedir($handle);


    $cssload = array();

    $cssload[] = JHTML::_('select.option', 'transmenu', _SW_TRANS_MENU);
    $cssload[] = JHTML::_('select.option', 'mygosumenu', _SW_MYGOSU_MENU);
    //$cssload[]= JHTML::_('select.option', 'tigramenu', _SW_TIGRA_MENU );
    $cssload[] = JHTML::_('select.option', 'superfishmenu', _SW_SUPERFISH_MENU);

    $lists['menustyle'] = JHTML::_('select.genericlist', $cssload, 'menustyle', 'id="menustyle" class="inputbox" size="1" onChange="changeOrientation();" style="width:200px"', 'value', 'text', $row2->menustyle ? $row2->menustyle : 'transmenu' );

    HTML_swmenufree::MenuConfig($row2, $row, $lists, $menuitems);
    HTML_swmenufree::footer();
}

}

function saveconfig() {

$database = &JFactory::getDBO();
$export = JRequest::getVar(  'export2', 0 );
$msg=_SW_SAVE_MENU_MESSAGE;

$style="";             
                
reset($_POST);
while (list ($key, $val) = each($_POST)) {
  
    $style.= $key ."=".$val."\n";
}

$database->setQuery( "SELECT COUNT(*) FROM #__swmenufree_styles");
	$database->query();
	$count=$database->loadResult();

	if(($count)) {
	$database->setQuery( "UPDATE #__swmenufree_styles SET params='".$style."' WHERE id = '1'");
	$database->query();
		
	} else {
            
            $database->setQuery("INSERT INTO #__swmenufree_styles"
                . "\nSET id='1', params='$style'"
        );
        $database->query();
	
	}
        
        if ($export) {
   $msg = exportMenu();
}
                
   sleep(3);
		echo "<div id=\"system-message-container\"><div class=\"system-message\">
		$msg</div></div>\n";             
                
editDhtmlMenu();
}

function exportMenu() {
    $absolute_path = JPATH_ROOT;
    $database = &JFactory::getDBO();
    include( $absolute_path . "/modules/mod_swmenufree/styles.php");
    $css = "";

 
$sql="SELECT * FROM #__swmenufree_styles where id=1";
	$database->setQuery($sql);
	$swmenufree_obj=$database->loadObject();
  
    $params = sw_stringToObject($swmenufree_obj->params);
    
//$row2=array();
while (list ($key, $val) = each($params)) {
   
    $swmenufree[$key]=$val;
}


    switch ($swmenufree['menustyle']) {
        case "mygosumenu":
            $css = gosuMenuStyleFree($swmenufree);
            break;
        case "superfishmenu":
            $css = superfishMenuStyleFree($swmenufree);
            break;
        case "transmenu":
            $css = transMenuStyleFree($swmenufree);
            break;
    }

//echo "css:".$css;
    $file = $absolute_path . "/modules/mod_swmenufree/styles/menu.css";
    if (!file_exists($file)) {
        touch($file);
        $handle = fopen($file, 'w'); // Let's open for read and write
    } else {
        $handle = fopen($file, 'w'); // Let's open for read and write
    }
    rewind($handle); // Go back to the beginning

    if (fwrite($handle, $css)) {
        $msg = _SW_SAVE_MENU_CSS_MESSAGE;
    } else {
        $msg = _SW_NO_SAVE_MENU_CSS_MESSAGE;
    } // Don't forget to increment the counter

    fclose($handle); // Done


    return $msg;
}

function saveCSS() {

  
    $absolute_path = JPATH_ROOT;
    $css = JRequest::getVar('filecontent', "");
   
    $css = str_replace('\\', '', $css);
    $file = $absolute_path . "/modules/mod_swmenufree/styles/menu.css";
    if (!file_exists($file)) {
        touch($file);
        $handle = fopen($file, 'w'); // Let's open for read and write
    } else {
        $handle = fopen($file, 'w'); // Let's open for read and write
    }
    rewind($handle); // Go back to the beginning

    fwrite($handle, $css); // Don't forget to increment the counter
    fclose($handle); // Done
    //echo $css;

    $msg = _SW_SAVE_CSS_MESSAGE;

   
        sleep(3);
        echo "<dl id=\"system-message\"><dt class=\"message\">Message</dt>
		<dd class=\"message message fade\"><ul><li>" . $msg . "</li>
	   </ul></dd></dl>\n";
        editCSS();
   
}

function editCSS() {
   
    $absolute_path = JPATH_ROOT;
    $file = $absolute_path . '/modules/mod_swmenufree/styles/menu.css';

    $fp = fopen($file, 'r');
    if ($fp) {
        $content = fread($fp, filesize($file));
        //$content = htmlspecialchars( $content );
        $database = &JFactory::getDBO();
        $sql="SELECT title FROM #__modules where module='mod_swmenufree' and published > -1";
	$database->setQuery($sql);
	$title=$database->loadResult();
        
        HTML_swmenufree::editCSS($content, $title);
        HTML_swmenufree::footer();
    }
}



function swmenuTreeRecurse($id, $indent, $list, &$children, $maxlevel=9999, $level=0) {
	if (@$children[$id] && $level <= $maxlevel) {
		foreach ($children[$id] as $v) {
			$id = $v->id;
			$txt = $v->title;
			//$pt = $v->parent_id;
			$list[$id] = $v;
			$list[$id]->treename = "$indent$txt";
			$list[$id]->children = count( @$children[$id] );
			$list = swmenuTreeRecurse( $id, str_repeat("- ",$level+1), $list, $children, $maxlevel, $level+1 );
		}
	}
	return $list;
}



function get_Version($directory){
	
	$xml =simplexml_load_file($directory);
		
$version=@$xml->version[0];
	
return floatval($version);
}

function changeLanguage() {

    $absolute_path = JPATH_ROOT;

    $lang = JRequest::getVar('language', "english.php");


    $file = $absolute_path . "/administrator/components/com_swmenufree/language/default.ini";
    if (!file_exists($file)) {
        touch($file);
        $handle = fopen($file, 'w'); // Let's open for read and write
    } else {
        $handle = fopen($file, 'w'); // Let's open for read and write
    }
    rewind($handle); // Go back to the beginning

    if (fwrite($handle, $lang)) {
        //	$msg=_SW_SAVE_MENU_CSS_MESSAGE;
    } else {
        //	$msg=_SW_NO_SAVE_MENU_CSS_MESSAGE;
    } // Don't forget to increment the counter

    fclose($handle); // Done


    upgrade('com_swmenufree');
}

function upgrade() {

  $database		=& JFactory::getDBO();
  $absolute_path=JPATH_ROOT;
  $config =& JFactory::getConfig();
  $dbprefix= $config->get( 'dbprefix' );
 $row= new stdClass();
	//echo $db;
	$row->message="";
	$row->database_version=1;
	
    if (TableExists($dbprefix . "swmenufree_config")) {
         
        $query = "SELECT * FROM #__swmenufree_config WHERE id = 1";
        $database->setQuery($query);
        $result = $database->loadObjectList();
       
        $swmenufree = array();
        $sql="SELECT id FROM #__modules where module='mod_swmenufree' AND published > -1";
	$database->setQuery($sql);
	$id=$database->loadResult();
	$row 	=& JTable::getInstance('module');
	// load the row from the db table
	$row->load( $id );
        $row->message="";
         
        if ($result) {
            $style=$row->params;
           
            while (list ($key, $val) = each($result[0])) {
               $swmenufree[$key] = $val;
               
               if($key=='id'){
               $val=$row->id;
                $style.= $key ."=".$val."\n";
               }else if($key=='corners'){
                $style.= $val."\n";   
               }else if($key=='sub_indicator'){
                $style.= $val."\n";   
               }else if($key=='sub_padding'){
                $padding = explode("px", $val);
                $style.= "sub_pad_top=".$padding[0]."\n";  
                $style.= "sub_pad_right=".$padding[1]."\n";  
                $style.= "sub_pad_bottom=".$padding[2]."\n";  
                $style.= "sub_pad_left=".$padding[3]."\n";  
               }else if($key=='main_padding'){
                $padding = explode("px", $val);
                $style.= "main_pad_top=".$padding[0]."\n";  
                $style.= "main_pad_right=".$padding[1]."\n";  
                $style.= "main_pad_bottom=".$padding[2]."\n";  
                $style.= "main_pad_left=".$padding[3]."\n";  
               }else if($key=='complete_padding'){
                $padding = explode("px", $val);
                $style.= "complete_margin_top=".$padding[0]."\n";  
                $style.= "complete_margin_right=".$padding[1]."\n";  
                $style.= "complete_margin_bottom=".$padding[2]."\n";  
                $style.= "complete_margin_left=".$padding[3]."\n";  
               }else if($key=='top_margin'){
                $padding = explode("px", $val);
                $style.= "top_margin_top=".$padding[0]."\n";  
                $style.= "top_margin_right=".$padding[1]."\n";  
                $style.= "top_margin_bottom=".$padding[2]."\n";  
                $style.= "top_margin_left=".$padding[3]."\n";  
               }else if($key=='main_border'){
                $border = explode(" ", $val);
                $style.= "main_border_width=".(rtrim(trim($border[0]), 'px'))."\n";  
                $style.= "main_border_style=".$border[1]."\n";  
                $style.= "main_border_color=".$border[2]."\n";  
               }else if($key=='main_border_over'){
                $border = explode(" ", $val);
                $style.= "main_border_over_width=".(rtrim(trim($border[0]), 'px'))."\n";  
                $style.= "main_border_over_style=".$border[1]."\n";  
                $style.= "main_border_color_over=".$border[2]."\n";  
               }else if($key=='sub_border'){
                $border = explode(" ", $val);
                $style.= "sub_border_width=".(rtrim(trim($border[0]), 'px'))."\n";  
                $style.= "sub_border_style=".$border[1]."\n";  
                $style.= "sub_border_color=".$border[2]."\n";  
               }else if($key=='sub_border_over'){
                $border = explode(" ", $val);
                $style.= "sub_border_over_width=".(rtrim(trim($border[0]), 'px'))."\n";  
                $style.= "sub_border_over_style=".$border[1]."\n";  
                $style.= "sub_border_color_over=".$border[2]."\n";  
               }else{
                $style.= $key ."=".$val."\n";   
               }
               
               
              
            }
            $style.="top_sub_indicator_top=0\n";
            $style.="top_sub_indicator_left=0\n";
            $style.="top_sub_indicator_align=right\n";
            $style.="sub_sub_indicator_top=0\n";
            $style.="sub_sub_indicator_left=0\n";
            $style.="sub_sub_indicator_align=right\n";
            $style.="tablet_hack=0\n";
            $style.="complete_background_position=top left\n";
            $style.="active_background_position=top left\n";
            $style.="top_background_position=top left\n";
            $style.="sub_background_position=top left\n";
            $style.="top_hover_background_position=top left\n";
            $style.="sub_hover_background_position=top left\n";
            $style.="complete_background_repeat=repeat\n";
            $style.="active_background_repeat=repeat\n";
            $style.="top_background_repeat=repeat\n";
            $style.="sub_background_repeat=repeat\n";
            $style.="top_hover_background_repeat=repeat\n";
            $style.="sub_hover_background_repeat=repeat\n";
            if (TableExists($dbprefix . "swmenufree_styles")) {
                
                $query = "SELECT * FROM #__swmenufree_styles WHERE id = 1";
                $database->setQuery($query);
                $styles = $database->loadObjectList();
                if (!count($styles)){
                    $row->message.="Copying swmenufree_config table to swmenufree_styles<br />";
                    $database->setQuery("INSERT INTO #__swmenufree_styles SET id='1', params='$style'");
                    $database->query(); 
                }
             }else{
              
              $database->setQuery(" CREATE TABLE IF NOT EXISTS #__swmenufree_styles (
                      `id` int(11) NOT NULL,
                      `params` text,
                       PRIMARY KEY (`id`)
                     ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
                    ");
               $row->message.="Creating swmenufree_styles table and copying swmenufree_config table to swmenufree_styles<br />";
                 $database->query();
                 $database->setQuery("INSERT INTO #__swmenufree_styles SET id='1', params='$style'");
                 $database->query(); 
            }
        }
       
//echo count($swmenufree);
       
    } else {
        if (TableExists($dbprefix . "swmenufree_styles")) {
                $query = "SELECT * FROM #__swmenufree_styles WHERE id = 1";
                $database->setQuery($query);
                $styles = $database->loadObjectList();
                if (!count($styles)){
                    $row->message.="Creating default style<br />";
                    $database->setQuery("INSERT INTO `#__swmenufree_styles` (`id`, `params`) VALUES
(1, 'position=left\norientation=vertical/right\nmain_width=0\nmain_height=0\nsub_width=0\nsub_height=0\nmain_top=0\nmain_left=0\nlevel1_sub_top=0\nlevel1_sub_left=0\nlevel2_sub_top=0\nlevel2_sub_left=0\ncomplete_margin_top=8\ncomplete_margin_right=16\ncomplete_margin_bottom=16\ncomplete_margin_left=16\ntop_margin_top=12\ntop_margin_right=0\ntop_margin_bottom=0\ntop_margin_left=0\nmain_pad_top=11\nmain_pad_right=28\nmain_pad_bottom=11\nmain_pad_left=20\nsub_pad_top=9\nsub_pad_right=29\nsub_pad_bottom=10\nsub_pad_left=15\ncomplete_background_image=\ncomplete_background_repeat=repeat\ncomplete_background_position=left top\nactive_background_image=\nactive_background_repeat=repeat\nactive_background_position=left top\nmain_back_image=\ntop_background_repeat=repeat\ntop_background_position=left top\nmain_back_image_over=\ntop_hover_background_repeat=repeat\ntop_hover_background_position=left top\nsub_back_image=\nsub_background_repeat=repeat\nsub_background_position=left top\nsub_back_image_over=\nsub_hover_background_repeat=repeat\nsub_hover_background_position=left top\ncomplete_background=#4E84CC\nactive_background=#942E8D\nmain_back=#0F3322\nmain_over=#163961\nsub_back=#168C9E\nsub_over=#D1FF54\ntop_sub_indicator=images/swmenufree/arrows/whiteleft-on.gif\ntop_sub_indicator_align=right\ntop_sub_indicator_top=0\ntop_sub_indicator_left=13\nsub_sub_indicator=images/swmenufree/arrows/blackleft-on.gif\nsub_sub_indicator_align=right\nsub_sub_indicator_top=0\nsub_sub_indicator_left=13\nfont_family=Times New Roman, Times, serif\nsub_font_family=Times New Roman, Times, serif\ntop_ttf=\nsub_ttf=\nmain_font_color=#EBEFF5\nmain_font_color_over=#E1EBE4\nsub_font_color=#FEFFF5\nsub_font_color_over=#0A1F14\nactive_font=#F0F09E\nmain_font_size=15\nsub_font_size=15\nfont_weight=normal\nfont_weight_over=normal\nmain_align=left\nsub_align=left\ntop_wrap=nowrap\nsub_wrap=nowrap\ntop_font_extra=\nsub_font_extra=\nmain_border_width=3\nmain_border_over_width=0\nsub_border_width=0\nsub_border_over_width=0\nmain_border_style=solid\nmain_border_over_style=none\nsub_border_style=none\nsub_border_over_style=none\nmain_border_color=#17050E\nmain_border_color_over=#F34AFF\nsub_border_color=#061C1B\nsub_border_color_over=#94FFB4\nc_corner_style=curvycorner\nc_corner_size=23\nctl_corner=1\ncbr_corner=1\nt_corner_style=none\nt_corner_size=12\nttl_corner=1\ntbr_corner=1\ns_corner_style=none\ns_corner_size=12\nstl_corner=1\nstr_corner=1\nsbl_corner=1\nsbr_corner=1\nmenustyle=mygosumenu\nmenutype=mainmenu\nparentid=0\nlevels=0\nactive_menu=1\ncssload=0\nhybrid=0\ntables=0\noverlay_hack=1\npadding_hack=0\nauto_position=1\nflash_hack=0\ndisable_jquery=0\ntablet_hack=0\nextra=fade\nspecialB=321\nspecialA=80\npreview_background=#FFFFFF\ntitle=swMenuFree\nborder_hack=0\noption=com_swmenufree\ntmpl=index\ntask=saveedit\nid=108\ntop_font_face=\nsub_font_face=\npreview=dynamic\nexport2=\ndefaultfolder=swmenufree\n');
");
                    $database->query(); 
                }
             }else{
                
              $database->setQuery(" CREATE TABLE IF NOT EXISTS #__swmenufree_styles (
                      `id` int(11) NOT NULL,
                      `params` text,
                       PRIMARY KEY (`id`)
                     ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
                    ");
                 $row->message.="Creating swmenufree_styles table and default style<br />";
                 $database->query();
                $database->setQuery("INSERT INTO `#__swmenufree_styles` (`id`, `params`) VALUES
(1, 'position=left\norientation=vertical/right\nmain_width=0\nmain_height=0\nsub_width=0\nsub_height=0\nmain_top=0\nmain_left=0\nlevel1_sub_top=0\nlevel1_sub_left=0\nlevel2_sub_top=0\nlevel2_sub_left=0\ncomplete_margin_top=8\ncomplete_margin_right=16\ncomplete_margin_bottom=16\ncomplete_margin_left=16\ntop_margin_top=12\ntop_margin_right=0\ntop_margin_bottom=0\ntop_margin_left=0\nmain_pad_top=11\nmain_pad_right=28\nmain_pad_bottom=11\nmain_pad_left=20\nsub_pad_top=9\nsub_pad_right=29\nsub_pad_bottom=10\nsub_pad_left=15\ncomplete_background_image=\ncomplete_background_repeat=repeat\ncomplete_background_position=left top\nactive_background_image=\nactive_background_repeat=repeat\nactive_background_position=left top\nmain_back_image=\ntop_background_repeat=repeat\ntop_background_position=left top\nmain_back_image_over=\ntop_hover_background_repeat=repeat\ntop_hover_background_position=left top\nsub_back_image=\nsub_background_repeat=repeat\nsub_background_position=left top\nsub_back_image_over=\nsub_hover_background_repeat=repeat\nsub_hover_background_position=left top\ncomplete_background=#4E84CC\nactive_background=#942E8D\nmain_back=#0F3322\nmain_over=#163961\nsub_back=#168C9E\nsub_over=#D1FF54\ntop_sub_indicator=images/swmenufree/arrows/whiteleft-on.gif\ntop_sub_indicator_align=right\ntop_sub_indicator_top=0\ntop_sub_indicator_left=13\nsub_sub_indicator=images/swmenufree/arrows/blackleft-on.gif\nsub_sub_indicator_align=right\nsub_sub_indicator_top=0\nsub_sub_indicator_left=13\nfont_family=Times New Roman, Times, serif\nsub_font_family=Times New Roman, Times, serif\ntop_ttf=\nsub_ttf=\nmain_font_color=#EBEFF5\nmain_font_color_over=#E1EBE4\nsub_font_color=#FEFFF5\nsub_font_color_over=#0A1F14\nactive_font=#F0F09E\nmain_font_size=15\nsub_font_size=15\nfont_weight=normal\nfont_weight_over=normal\nmain_align=left\nsub_align=left\ntop_wrap=nowrap\nsub_wrap=nowrap\ntop_font_extra=\nsub_font_extra=\nmain_border_width=3\nmain_border_over_width=0\nsub_border_width=0\nsub_border_over_width=0\nmain_border_style=solid\nmain_border_over_style=none\nsub_border_style=none\nsub_border_over_style=none\nmain_border_color=#17050E\nmain_border_color_over=#F34AFF\nsub_border_color=#061C1B\nsub_border_color_over=#94FFB4\nc_corner_style=curvycorner\nc_corner_size=23\nctl_corner=1\ncbr_corner=1\nt_corner_style=none\nt_corner_size=12\nttl_corner=1\ntbr_corner=1\ns_corner_style=none\ns_corner_size=12\nstl_corner=1\nstr_corner=1\nsbl_corner=1\nsbr_corner=1\nmenustyle=mygosumenu\nmenutype=mainmenu\nparentid=0\nlevels=0\nactive_menu=1\ncssload=0\nhybrid=0\ntables=0\noverlay_hack=1\npadding_hack=0\nauto_position=1\nflash_hack=0\ndisable_jquery=0\ntablet_hack=0\nextra=fade\nspecialB=321\nspecialA=80\npreview_background=#FFFFFF\ntitle=swMenuFree\nborder_hack=0\noption=com_swmenufree\ntmpl=index\ntask=saveedit\nid=108\ntop_font_face=\nsub_font_face=\npreview=dynamic\nexport2=\ndefaultfolder=swmenufree\n');
");
                $database->query(); 
            }
    }




    $database->setQuery("SELECT COUNT(*) FROM `#__extensions` WHERE element LIKE '%com_swmenufree%'");
	$com_entries=$database->loadResult();
  	
  	if($com_entries!=1){
  		$row->message.=_SW_UPDATE_LINKS."<br />";
  		//$database->setQuery("DELETE FROM `#__components` WHERE admin_menu_link like '%com_swmenufree%'");
  		//$database->query();
  		
  		$database->setQuery("INSERT INTO `#__extensions` VALUES ( '', 'swMenuFree', 'component', 'com_swmenufree', '', 0, 1, 0, 0, '{\"legacy\":true,\"name\":\"swMenuFree\",\"type\":\"component\",\"creationDate\":\"06\\/09\\/2010\",\"author\":\"Sean White\",\"copyright\":\"This Component is Proprietry Software\",\"authorEmail\":\"sean@swmenupro.com\",\"authorUrl\":\"http:\\/\\/www.swmenupro.com\",\"version\":\"7.0\",\"description\":\"Joomla 1.5 DHTML Menu Component\",\"group\":\"\"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0)");
  		$database->query();
                
                $database->setQuery("DELETE FROM `#__menu` WHERE link='index.php?option=com_swmenufree'");
  		$database->query();
  	}
  	
        $database->setQuery("SELECT COUNT(*) FROM `#__extensions` WHERE element LIKE '%mod_swmenufree%'");
	$com_entries=$database->loadResult();
  	
  	if($com_entries!=1){
  		$row->message.=_SW_UPDATE_LINKS."<br />";
  		//$database->setQuery("DELETE FROM `#__components` WHERE admin_menu_link like '%com_swmenufree%'");
  		//$database->query();
  		
  		$database->setQuery("INSERT INTO `#__extensions` VALUES('', 'swMenuFree', 'module', 'mod_swmenufree', '', 0, 1, 0, 0, '{\"legacy\":false,\"name\":\"swMenuFree\",\"type\":\"module\",\"creationDate\":\"26\\/01\\/2012\",\"author\":\"Sean White\",\"copyright\":\"This component is copyright www.swmenupro.com\",\"authorEmail\":\"sean@swmenupro.com\",\"authorUrl\":\"http:\\/\\/www.swmenupro.com\",\"version\":\"7.0\",\"description\":\"Joomla\\/Mambo DHTML Menu Component\",\"group\":\"\"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0)");

  		$database->query();
  	}
  	
  	$database->setQuery("SELECT COUNT(*) FROM `#__menu` WHERE title LIKE '%swMenuFree%' AND client_id='1'");
	$com_entries=$database->loadResult();
  	
  	if($com_entries!=1){
  		$row->message.=_SW_UPDATE_LINKS."<br />";
  		//$database->setQuery("DELETE FROM `#__components` WHERE admin_menu_link like '%com_swmenufree%'");
  		//$database->query();
  		
  		$database->setQuery("SELECT extension_id FROM `#__extensions` WHERE element LIKE '%com_swmenufree%'");
	$com_id=$database->loadResult();
  		
  		
  		
  		$database->setQuery("INSERT INTO `#__menu` VALUES('', 'main', 'swMenuFree', 'swMenuFree', '', 'swMenuFree', 'index.php?option=com_swmenufree', 'component', 0, 1, 1, ".$com_id.", 0, 0, '0000-00-00 00:00:00', 0, 1, 'components/com_swmenufree/images/swmenupro_icon.png', 0, '', 283, 284, 0, '', 1);");
  		$database->query();
  	}
        
        
       
        
        $row->component_version = get_Version($absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');
        $row->upgrade_version = $row->component_version;
        $xml =@simplexml_load_file('http://swmenupro.com/swmenufree_updates.xml');
        if($xml){
          foreach ($xml->update as $update) {
            switch((string) $update->targetplatform['version']) { // Get attributes as element indices
             case substr(JVERSION,0,3):
                 if(floatval($update->version) > floatval($row->component_version)){                                             
                   $row->message.= "swMenuFree ".$update->version." is available.  Please visit <a href='http://www.swmenupro.com'>swmenupro.com</a> and download the latest swMenuFree ".$update->version." file.  Then use the upload feature on this page to upload the file and upgrade this copy of swMenuFree.<br />"; 
                 }
             break;
           }
        }
      }
  
       

    if (file_exists($absolute_path . '/modules/mod_swmenufree/mod_swmenufree.xml')) {
        $row->module_version = get_Version($absolute_path . '/modules/mod_swmenufree/mod_swmenufree.xml');
        $row->new_module_version = get_Version($absolute_path . '/administrator/components/com_swmenufree/module/mod_swmenufree.xml');
        if ($row->module_version < $row->new_module_version) {
            if (copydirr($absolute_path . "/administrator/components/com_swmenufree/module", $absolute_path . "/modules/mod_swmenufree", false)) {
              //  unlink($absolute_path . '/modules/mod_swmenufree/mod_swmenufree.xml');
              //  rename($absolute_path . "/modules/mod_swmenufree/mod_swmenufree.sw", $absolute_path . "/modules/mod_swmenufree/mod_swmenufree.xml");
                $row->message.=_SW_MODULE_SUCCESS . "<br />";
            } else {
                $row->message.=_SW_MODULE_FAIL . "<br />";
            }
        }
    } else {
        mkdir($absolute_path . "/modules/mod_swmenufree");
        if (copydirr($absolute_path . "/administrator/components/com_swmenufree/module", $absolute_path . "/modules/mod_swmenufree",  false)) {
            //rename($absolute_path . "/modules/mod_swmenufree/mod_swmenufree.sw", $absolute_path . "/modules/mod_swmenufree/mod_swmenufree.xml");
            $row->message.=_SW_MODULE_SUCCESS . "<br />";
        } else {
            $row->message.=_SW_MODULE_FAIL . "<br />";
        }
    }

if (file_exists($absolute_path . '/administrator/components/com_swmenufree/admin.swmenufree.php')) {
    unlink($absolute_path . '/administrator/components/com_swmenufree/admin.swmenufree.php');
}

if(!is_dir(JPATH_ROOT  .'/images/swmenufree')){
	if (@mkdir(JPATH_ROOT . '/images/swmenufree')){
				
				//echo 'Directory created: '.JPATH_ROOT .DS. 'images'.DS.'swmenufree';
			}else{
			$row->message.= '<b>ERROR:</b>cannot create directory '.JPATH_ROOT .'/images/swmenufree<br />';
                        }
                        if(copydirr(JPATH_ROOT. '/modules/mod_swmenufree/images',JPATH_ROOT . '/images/swmenufree',false)){
	//rename($absolute_path."/modules/mod_swmenufree/mod_swmenufree.sw",$absolute_path."/modules/mod_swmenufree/mod_swmenufree.xml");
	$row->message.="Successfully Installed swmenufree images<br />";
	}else{
	$row->message.="Could Not Install swMenuFree Images.<br />\n";
	}
        }
      
        
        
    $row->component_version = get_Version($absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');
    $row->module_version = get_Version($absolute_path . '/modules/mod_swmenufree/mod_swmenufree.xml');


    $langfile = "english.php";
    if (file_exists($absolute_path . '/administrator/components/com_swmenufree/language/default.ini')) {
        $filename = $absolute_path . '/administrator/components/com_swmenufree/language/default.ini';
        $handle = fopen($filename, "r");
        $langfile = fread($handle, filesize($filename));
        fclose($handle);
    }

    $basedir = $absolute_path . "/administrator/components/com_swmenufree/language/";
    $handle = opendir($basedir);
    $lang = array();
    $lists = array();
    while ($file = readdir($handle)) {
        if ($file == "." || $file == ".." || $file == "default.ini") {
            
        } else {
            $lang[] = JHTML::_('select.option', $file, $file);
        }
        $lists['langfiles'] = JHTML::_('select.genericlist', $lang, 'language', 'id="language" class="inputbox" size="1" style="width:200px"', 'value', 'text', $langfile);
    }
    closedir($handle);


    HTML_swmenufree::upgradeForm($row, $lists);
    HTML_swmenufree::footer();
}

function copydirr($fromDir, $toDir,  $verbose = false)
/*
  copies everything from directory $fromDir to directory $toDir
  and sets up files mode $chmod
 */ {
    //* Check for some errors
    $errors = array();
    $messages = array();
    if (!is_writable($toDir))
        $errors[] = 'target ' . $toDir . ' is not writable';
    if (!is_dir($toDir))
        $errors[] = 'target ' . $toDir . ' is not a directory';
    if (!is_dir($fromDir))
        $errors[] = 'source ' . $fromDir . ' is not a directory';
    if (!empty($errors)) {
        if ($verbose)
            foreach ($errors as $err)
                echo '<strong>Error</strong>: ' . $err . '<br />';
        return false;
    }
    //*/
    $exceptions = array('.', '..');
    //* Processing
    $handle = opendir($fromDir);
    while (false !== ($item = readdir($handle)))
        if (!in_array($item, $exceptions)) {
            //* cleanup for trailing slashes in directories destinations
            $from = str_replace('//', '/', $fromDir . '/' . $item);
            $to = str_replace('//', '/', $toDir . '/' . $item);
            //*/
            if (is_file($from)) {
                if (@copy($from, $to)) {
                   
                    touch($to, filemtime($from)); // to track last modified time
                    $messages[] = 'File copied from ' . $from . ' to ' . $to;
                }
                else
                    $errors[] = 'cannot copy file from ' . $from . ' to ' . $to;
            }
            if (is_dir($from)) {
                if (@mkdir($to)) {
                   
                    $messages[] = 'Directory created: ' . $to;
                }
                else
                    $errors[] = 'cannot create directory ' . $to;
                copydirr($from, $to,  $verbose);
            }
        }
    closedir($handle);
    //*/
    //* Output
    if ($verbose) {
        foreach ($errors as $err)
            echo '<strong>Error</strong>: ' . $err . '<br />';
        foreach ($messages as $msg)
            echo $msg . '<br />';
    }
    //*/
    return true;
}

function upload_ttf() {
  
    $absolute_path = JPATH_ROOT;
    //echo $absolute_path;
    $userfile = JRequest::getVar('cufonfile', null, 'files', 'array');
$success=0;
    if (!$userfile) {

        exit();
    }

    $userfile_name = $userfile['name'];
//echo $userfile_name;

    if (is_writable($absolute_path . '/modules/mod_swmenufree/fonts')) {
        if (substr($userfile_name, (strlen($userfile_name) - 2)) == "js") {
            move_uploaded_file($userfile['tmp_name'], $absolute_path . '/modules/mod_swmenufree/fonts/' . $userfile['name']);
            $filename = file_get_contents('' . $absolute_path . '/modules/mod_swmenufree/fonts/' . $userfile['name'] . '');
            if (stripos($filename, 'Cufon.registerFont') === false) {
                $message = "File is not a cufon font file";
                unlink($absolute_path . '/modules/mod_swmenufree/fonts/' . $userfile['name']);
            } else {


                $pos_start = strpos($filename, "font-family") + 14;
                $pos_end = strpos($filename, "\"", $pos_start) - $pos_start;
                $fontname = substr($filename, $pos_start, $pos_end);
                $message = "Sucessfully Installed the " . $fontname . " font file.";
                $success=1;
            }
        } else {

            $message = "File is not a cufon javascript file";
        }
    } else {
        $message = '/modules/mod_swmenufree/fonts folder can not be written to.';
    }

    echo "<dl id=\"system-message\"><dt class=\"message\">Message</dt>
		<dd class=\"message message fade\"><ul><li>".$message."</li>
	   </ul></dd></dl>\n";
    if(!$success){
      HTML_swmenufree::uploadCufon(  );  
    }else{
     echo "<script language=\"javascript\" type=\"text/javascript\">\n";
     echo "window.parent.jInsertCufon('". $userfile['name']."', '".$fontname."');\n";
   //  echo "alert(filename);\n";
     echo "</script>";
     echo "You may now choose the ".$fontname." font from the True Type Font select boxes";
     echo "<br><input type='button' class='sw_get' onclick='window.parent.SqueezeBox.close();' value='close' />";
    }
                //echo $row->id;
		//editCSS($id, $option);
//upgrade($option='com_swmenufree', $installdir='');
   // $mainframe->redirect("index.php?&option=com_swmenufree&task=upgrade", $message);
}

function uploadPackage() {
  
    $absolute_path = JPATH_ROOT;
    //echo $absolute_path;
    $userfile = JRequest::getVar('userfile', null, 'files', 'array');

    if (!$userfile) {

        exit();
    }

  
//echo $userfile_name;
    $msg = '';

    move_uploaded_file($userfile['tmp_name'], $absolute_path . '/tmp/' . $userfile['name']);
    //$resultdir = uploadFile( $userfile['tmp_name'], $userfile['name'], $msg );
    $msg = extractArchive($userfile['name']);

    if (file_exists($msg . "/swmenufree.xml")) {
        $upload_version = get_Version($msg . "/swmenufree.xml");
    } else {
        $upload_version = 0;
    }
  //  echo $msg;
    $current_version = get_Version($absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');

//echo $upload_version;
    if ($current_version < $upload_version) {
        if (copydirr($msg . "/admin/", $absolute_path . '/administrator/components/com_swmenufree', false)) {
            unlink($absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');
            unlink($absolute_path . '/administrator/components/com_swmenufree/admin.swmenufree.php');
            copy($msg . "/swmenufree.xml", $absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');
           $message = _SW_COMPONENT_SUCCESS;
        } else {
            $message = _SW_COMPONENT_FAIL;
        }
    } else {

        $message = _SW_INVALID_FILE;
    }

    sw_deldir($msg);
    unlink($absolute_path . "/tmp/" . $userfile['name']);

   echo "<dl id=\"system-message\"><dt class=\"message\">Message</dt>
		<dd class=\"message message fade\"><ul><li>".$message."</li>
	   </ul></dd></dl>\n";
		//editCSS($id, $option);
upgrade('com_swmenufree');
}

/**
 * @param string The name of the php (temporary) uploaded file
 * @param string The name of the file to put in the temp directory
 * @param string The message to return
 */
function uploadFile($filename, $userfile_name, &$msg) {
   
    $absolute_path = JPATH_ROOT;
    $baseDir = $absolute_path . '/modules/mod_swmenufree/fonts';

    if (file_exists($baseDir)) {
        if (is_writable($baseDir)) {
            if (move_uploaded_file($filename, $baseDir . $userfile_name)) {
               
            } else {
                $msg = 'Failed to move uploaded file to <code>/media</code> directory.';
            }
        } else {
            $msg = 'Upload failed as <code>/media</code> directory is not writable.';
        }
    } else {
        $msg = 'Upload failed as <code>/media</code> directory does not exist.';
    }
    return false;
}

function extractArchive($filename) {
	
	$absolute_path=JPATH_ROOT;

	$base_Dir 		=  $absolute_path . '/tmp/' ;

	$archivename 	= $base_Dir . $filename;
	$tmpdir 		= uniqid( 'install_' );

	$extractdir 	=  $base_Dir . $tmpdir ;
	//$archivename 	= mosPathName( $archivename;
//echo $archivename;
	//$this->unpackDir( $extractdir );

	if (preg_match( '/.zip$/', $archivename )) {
		// Extract functions
		require_once( $absolute_path . '/administrator/components/com_swmenufree/pcl/pclzip.lib.php' );
		require_once( $absolute_path . '/administrator/components/com_swmenufree/pcl/pclerror.lib.php' );
		require_once( $absolute_path . '/administrator/components/com_swmenufree/pcl/pcltrace.lib.php' );
		//require_once( $absolute_path . '/administrator/includes/pcl/pcltar.lib.php' );
		$zipfile = new PclZip( $archivename );
		//if($this->isWindows()) {
		//		define('OS_WINDOWS',1);
		//	} else {
		//		define('OS_WINDOWS',0);
		//	}

		$ret = $zipfile->extract( PCLZIP_OPT_PATH, $extractdir );
		if($ret == 0) {
			//$this->setError( 1, 'Unrecoverable error "'.$zipfile->errorName(true).'"' );
			return false;
		}
	} else {
		require_once( $absolute_path . '/administrator/components/com_swmenufree/pcl/Tar.php' );
		$archive = new Archive_Tar( $archivename );
		$archive->setErrorHandling( PEAR_ERROR_PRINT );

		if (!$archive->extractModify( $extractdir, '' )) {
			$this->setError( 1, 'Extract Error' );
			return false;
		}
	}


	return $extractdir;

}

function sw_deldir($dir) {
    $current_dir = opendir($dir);
    $old_umask = umask(0);
    while ($entryname = readdir($current_dir)) {
        if ($entryname != '.' and $entryname != '..') {
            if (is_dir($dir . "/" . $entryname)) {
                sw_deldir($dir . "/" . $entryname);
            } else {
                //@chmod($dir . "/" . $entryname, 0777);
                unlink($dir . "/" . $entryname);
            }
        }
    }
    umask($old_umask);
    closedir($current_dir);
    return rmdir($dir);
}


function TableExists($tablename) {
    $exists=FALSE;
    $database = &JFactory::getDBO();
    $test=$database->getTableList();
    while (list ($key, $val) = each($test)) {
        if($val==$tablename){
            $exists=TRUE;
        }
  }
   return $exists;
}





function sw_stringToObject($data)
{
     $obj= new stdClass();
    $lines = explode("\n", $data);

		// Process the lines.
		foreach ($lines as $line)
		{
			// Trim any unnecessary whitespace.
			$line = trim($line);

			// Ignore empty lines and comments.
			if (empty($line) || ($line{0} == ';'))
			{
				continue;
			}

			// Check that an equal sign exists and is not the first character of the line.
			if (!strpos($line, '='))
			{
				// Maybe throw exception?
				continue;
			}

			// Get the key and value for the line.
			list ($key, $value) = explode('=', $line, 2);

			// Validate the key.
			if (preg_match('/[^A-Z0-9_]/i', $key))
			{
				// Maybe throw exception?
				continue;
			}

			// If the value is quoted then we assume it is a string.
			$length = strlen($value);
			if ($length && ($value[0] == '"') && ($value[$length - 1] == '"'))
			{
				// Strip the quotes and Convert the new line characters.
				$value = stripcslashes(substr($value, 1, ($length - 2)));
				$value = str_replace('\n', "\n", $value);
			}
			else
			{
				// If the value is not quoted, we assume it is not a string.

				// If the value is 'false' assume boolean false.
				if ($value == 'false')
				{
					$value = false;
				}
				// If the value is 'true' assume boolean true.
				elseif ($value == 'true')
				{
					$value = true;
				}
				// If the value is numeric than it is either a float or int.
				elseif (is_numeric($value))
				{
					// If there is a period then we assume a float.
					if (strpos($value, '.') !== false)
					{
						$value = (float) $value;
					}
					else
					{
						$value = (int) $value;
					}
				}
			}

			
				$obj->$key = $value;
			
		}

		// Cache the string to save cpu cycles -- thus the world :)
		

		return $obj;
	
}

?>
