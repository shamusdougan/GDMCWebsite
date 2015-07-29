<?php

/**
 * swmenufree v6.0
 * http://swmenufree.com
 * Copyright 2006 Sean White
 * */
defined( '_JEXEC' ) or die( 'Restricted access' );




function swGetMenuFree($menu,$id,$hybrid,$use_table,$parent_id,$levels){
 
           // echo $menu.$id.count($swmenupro_array);
			$swmenupro_array=swGetMenuLinksFree($menu,$id,$hybrid,$use_table);
                        //echo $menu.$id.count($swmenupro_array);
			$final_menu=get_Final_MenuFree($swmenupro_array, $parent_id, $levels);
	  
       // echo count($final_menu);
        return $final_menu;
}

function get_Final_MenuFree($swmenufree_array, $parent_id, $levels){
	//echo $parent_id;
	$valid=0;
	$my = & JFactory::getUser();
	//$param= & JForm::bind();
	$final_menu=array();
	$group= ($my->getAuthorisedGroups());
	//print_r ($group);
	if(count($group)<2){
		$group[0]=1;
		$group[1]=1;
	}
	
	
$access =  $my->getAuthorisedViewLevels();
//echo count($swmenufree_array);
	for($i=0;$i<count($swmenufree_array);$i++){
		$swmenu=$swmenufree_array[$i];
		
	if(in_array((int)$swmenu['ACCESS'], $access)){
            //echo "hello".$swmenu['PARENT'];
			if ($swmenu['PARENT']==$parent_id) {
				$valid++;
                               // echo "valid";
			}
			
			if (strcasecmp(substr($swmenu['URL'],0,4),"http")) {
			$swmenu['URL'] = JRoute::_($swmenu['URL'],1);
			}
			
			$swmenu['URL']=str_replace('&amp;','&',$swmenu['URL']);
			$final_menu[] =array("TITLE" => $swmenu['TITLE'], "URL" =>  $swmenu['URL'] , "ID" => $swmenu['ID']  , "PARENT" => $swmenu['PARENT'] ,  "ORDER" => $swmenu['ORDER'], "TARGET" => $swmenu['TARGET'],"ACCESS" => $swmenu['ACCESS'] );
		}
	}
	if(count($final_menu)&&$valid){
		$final_menu = chainfree('ID', 'PARENT', 'ORDER', $final_menu, $parent_id, 25);
	}else{
		$final_menu=array();
	}
       // echo count($final_menu);
	return $final_menu;
}


function swGetMenuLinksFree($menu,$id,$hybrid,$use_tables){
	
	$database = &JFactory::getDBO();
	$config=&JFactory::getConfig();
	$time_offset=0;
	$now = date( "Y-m-d H:i:s", time()+$time_offset*60*60 );
	$swmenufree_array=array();
	if ($menu=="swcontentmenu") {
		
		$sql =  "SELECT #__categories.* 
                FROM #__categories 
                WHERE #__categories.extension='com_content'
                AND #__categories.published = 1
                ORDER BY lft
                ";

		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];


			if(!$use_tables){
							$url="index.php?option=com_content&view=category&id=".$result2->id;
							}else{
							$url="index.php?option=com_content&view=category&layout=blog&id=".$result2->id;
							}

			$swmenufree_array[] =array("TITLE" => $result2->title, "URL" =>  $url , "ID" => $result2->id  , "SECURE" => 0 ,"PARENT" => $result2->parent_id ,  "ORDER" => $result2->lft, "TARGET" => 0,"ACCESS" => $result2->access );
		}
		

		$sql =  "SELECT #__content.*
                FROM #__content 
                INNER JOIN #__categories ON #__content.catid = #__categories.id
                WHERE #__content.state = 1
                AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now'  )
                AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )
               ORDER BY #__content.ordering
                ";
		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];


			$url="index.php?option=com_content&view=article&id=".$result2->id ;
			$swmenufree_array[] =array("TITLE" => $result2->title, "URL" =>  $url , "ID" => $result2->id+10000  ,"SECURE" => 0 , "PARENT" => $result2->catid ,  "ORDER" => $result2->ordering, "TARGET" => 0,"ACCESS" => $result2->access );
		}
	}else if ($menu == "virtuemart" || $menu == "virtueprod") {
        $sql = "SELECT #__vm_category.* ,#__vm_category_xref.*
                FROM #__vm_category
                INNER JOIN #__vm_category_xref ON #__vm_category_xref.category_child_id= #__vm_category.category_id
                AND #__vm_category.category_publish = 'Y'
                ORDER BY #__vm_category.list_order
                ";
        $database->setQuery($sql);
        $result = $database->loadObjectList();
        for ($i = 0; $i < count($result); $i++) {
            $result2 = $result[$i];
            $url = "index.php?option=com_virtuemart&page=shop.browse&category_id=" . $result2->category_id . "&Itemid=" . ($Itemid) ;
            $swmenufree_array[] = array(
                "TITLE" => $result2->category_name,
                "URL" => $url,
                "ID" => ($result2->category_id + 10000),
                "SECURE" => 0,
                "PARENT" => ($result2->category_parent_id ? (($result2->category_parent_id + 10000)) : 0),
                "ORDER" => $result2->list_order,
                "TARGET" => 0,
                "ACCESS" => 1,
             
            );
            if ($menu == "virtueprod") {
                $sql = "SELECT #__vm_product.* ,#__vm_product_category_xref.*
                FROM #__vm_product
                INNER JOIN #__vm_product_category_xref ON #__vm_product_category_xref.product_id= #__vm_product.product_id
                AND #__vm_product.product_publish = 'Y'
                AND #__vm_product_category_xref.category_id = $result2->category_id
          
                ";
                $database->setQuery($sql);
                $result3 = $database->loadObjectList();
                for ($j = 0; $j < count($result3); $j++) {
                    $result4 = $result3[$j];
                    $url = "index.php?option=com_virtuemart&page=shop.product_details&flypage=shop.flypage&product_id=" . $result4->product_id . "&category_id=" . $result4->category_id . "&manufacturer_id=" . $result4->vendor_id . "&Itemid=" . ($Itemid) ;
                    $swmenufree_array[] = array(
                        "TITLE" => $result4->product_name,
                        "URL" => $url,
                        "ID" => ($result4->product_id + 100000),
                        "SECURE" => 0,
                        "PARENT" => ($result2->category_id ? (($result2->category_id + 10000)) : 0),
                        "ORDER" => $result2->list_order,
                        "TARGET" => 0,
                        "ACCESS" => 1,
                    );
                }
            }
        }
    } else if ($menu == "virtuemart2" || $menu == "virtueprod2") {
       $sql = "SELECT  #__virtuemart_configs.config
                FROM #__virtuemart_configs
                WHERE #__virtuemart_configs.virtuemart_config_id=1";
         $database->setQuery($sql);
         $result=$database->loadResult();
        // echo "config=".$result;
         //print_r($result);
         
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
//$result=$jlang->getDefault();
//print_r($pair);
$vmlang= $pair['vmlang']?$pair['vmlang']:"en_gb";
        
        $sql = "SELECT #__virtuemart_categories_".$vmlang.".* ,#__virtuemart_category_categories.*,#__virtuemart_categories.*
                FROM #__virtuemart_categories,#__virtuemart_categories_".$vmlang."
                INNER JOIN #__virtuemart_category_categories ON #__virtuemart_category_categories.category_child_id= #__virtuemart_categories_".$vmlang.".virtuemart_category_id
                WHERE #__virtuemart_categories.virtuemart_category_id=#__virtuemart_categories_".$vmlang.".virtuemart_category_id
                AND #__virtuemart_categories.published='1'
                ORDER BY #__virtuemart_categories.ordering
                ";
        $database->setQuery($sql);
        $result = $database->loadObjectList();
        //echo count($result);
        for ($i = 0; $i < count($result); $i++) {
            $result2 = $result[$i];
            $url = "index.php?option=com_virtuemart&view=category&virtuemart_category_id=" . $result2->virtuemart_category_id ;
            $swmenufree_array[] = array(
                "TITLE" => $result2->category_name,
                "URL" => $url,
                "ID" => ($result2->virtuemart_category_id + 10000),
                "SECURE" => 0,
                "PARENT" => ($result2->category_parent_id ? (($result2->category_parent_id + 10000)) : 0),
                "ORDER" => $result2->ordering,
                "TARGET" => 0,
                "ACCESS" => 1,
             
            );
            if ($menu == "virtueprod2") {
                $sql = "SELECT #__virtuemart_products_".$vmlang.".* ,#__virtuemart_product_categories.*,#__virtuemart_products.*
                FROM #__virtuemart_products,#__virtuemart_products_".$vmlang."
                INNER JOIN #__virtuemart_product_categories ON #__virtuemart_product_categories.virtuemart_product_id= #__virtuemart_products_".$vmlang.".virtuemart_product_id
                WHERE #__virtuemart_products.virtuemart_product_id=#__virtuemart_products_".$vmlang.".virtuemart_product_id
                AND #__virtuemart_product_categories.virtuemart_category_id = $result2->virtuemart_category_id
                AND #__virtuemart_products.published='1'
                
          
                ";
                $database->setQuery($sql);
                $result3 = $database->loadObjectList();
               // echo count($result3);
                for ($j = 0; $j < count($result3); $j++) {
                    $result4 = $result3[$j];
                    $url = "index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=" . $result4->virtuemart_product_id . "&virtuemart_category_id=" . $result4->virtuemart_category_id;
                    $swmenufree_array[] = array(
                        "TITLE" => $result4->product_name,
                        "URL" => $url,
                        "ID" => ($result4->virtuemart_product_id + 100000),
                        "SECURE" => 0,
                        "PARENT" => ($result2->virtuemart_category_id ? (($result2->virtuemart_category_id + 10000)) : 0),
                        "ORDER" => $result2->ordering,
                        "TARGET" => 0,
                        "ACCESS" => 1,
                    );
                }
            }
        }
        
        } else {
		if ($hybrid){
				$sql =  "SELECT #__content.* 
                FROM #__content 
                INNER JOIN #__categories ON #__content.catid = #__categories.id
                WHERE #__content.state = 1
                AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now'  )
                AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )
              
                ORDER BY #__content.catid,#__content.ordering
                ";
			$database->setQuery( $sql   );
			$hybrid_content = $database->loadObjectList();	
			//print_r($hybrid_content);
			
			
			$sql =  "SELECT #__categories.id,#__categories.title,#__categories.parent_id,#__categories.lft,#__categories.published,#__categories.access 
                FROM #__categories 
                WHERE #__categories.published =1
                AND #__categories.extension='com_content'
               
                ORDER BY #__categories.lft DESC
                ";
			$database->setQuery( $sql   );
			$hybrid_cat = $database->loadObjectList();	
			//print_r($hybrid_cat);
			
			//print_r($hybrid_cat);
			//echo $hybrid_cat[1]->published;	
		}
				
		$sql = "SELECT #__menu.* 
                FROM #__menu 
                WHERE #__menu.menutype = '".$menu."' AND published = '1'
           
                ORDER BY parent_id
            ";

		$database->setQuery( $sql   );
		$result = $database->loadObjectList();
//jimport( 'joomla.html.application' );
		$swmenufree_array=array();
		//echo $preview;
		$preview=JRequest::getVar( 'preview', 0 );
		//echo $preview;
	if(!$preview){$menu_items  =& JSite::getMenu();}
//print_r ($menu_items);
       // echo $config->getValue('language');
       $language=$config->get('language');
		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];
			
			
//$item       =  $menu_items->getActive();
if(!$preview){
$params     =& $menu_items->getParams($result2->id);
$iSecure= $params->get( 'secure',0 );
}else{$iSecure=0;}


			switch ($result2->type) {
				case 'separator';
				$mylink = "javascript:void(0);";
				break;

				case 'url':
					$mylink = $result2->link;
				if (preg_match( "/index.php\?/i", $result2->link )) {
					if (!preg_match( "/Itemid=/i", $result2->link )) {
						$mylink .= "&Itemid=$result2->id";
					}
				}
				break;
				
				case 'menulink';
				$mylink = $result2->link;
				break;
				
				case 'alias';
				if(!$preview){
				$alias =  $params->get( 'aliasoptions',$result2->id );
				}else{$alias="";}
				//$mylink = $result2->link;
				//echo $test;
				$mylink = "index.php?Itemid=".$alias;
				break;
				
								
				default:
				$mylink = "index.php?Itemid=".$result2->id;
				break;
			}
                        if($result2->language==$language || $result2->language=="*"){
			//echo "parent ".$result2->language." order ".$result2->lft;
			$swmenufree_array[] =array("TITLE" => $result2->title, "URL" =>  $mylink , "ID" => $result2->id  ,"SECURE" => $iSecure, "PARENT" => $result2->parent_id ,  "ORDER" => $result2->lft, "TARGET" => $result2->browserNav,"ACCESS" => $result2->access );
                        }
			if ($hybrid){
				$opt=array();
				parse_str($result2->link, $opt);
				$opt['view'] = @$opt['view'] ? $opt['view']: 0;
				$opt['id'] = @$opt['id'] ? $opt['id']: 0;
				
				//echo $opt['id'];
				
				if (($opt['view']=="category" || $opt['view']=="categories") && $result2->id != 472) {
					//echo "hello";
					
					for($j=0;$j<count($hybrid_content);$j++){	
					$row=$hybrid_content[$j];
					//echo $row->catid;
					if($row->catid==$opt['id']){
						//echo "hello";
							$url="index.php?option=com_content&view=article&catid=".$row->catid."&id=" . $row->id ."&Itemid=".$result2->id;
							$swmenufree_array[] =array("TITLE" => $row->title, "URL" =>  $url , "ID" => $row->id+100000  ,"SECURE" => $iSecure, "PARENT" => $result2->id ,  "ORDER" => $row->ordering, "TARGET" => 0,"ACCESS" => $row->access  );
						}	
					}
					
					for($j=0;$j<count($hybrid_cat);$j++){	
				     $row=$hybrid_cat[$j];
					 if($row->parent_id==$opt['id'] && $opt['id']){
						//$j=count($hybrid_cat);
														
							if(!$use_tables){
							$url="index.php?option=com_content&view=category&id=".$row->id."&Itemid=".$result2->id;
							}else{
							$url="index.php?option=com_content&view=category&layout=blog&id=".$row->id."&Itemid=".$result2->id;
							}
							$swmenufree_array[] =array("TITLE" => $row->title, "URL" =>  $url , "ID" => $row->id+10000  ,"SECURE" => $iSecure, "PARENT" => $result2->id ,  "ORDER" => $row->lft, "TARGET" => 0,"ACCESS" => $row->access  );
							
							for($n=0;$n<count($hybrid_cat);$n++){	
							$row3=$hybrid_cat[$n];
							if($row3->parent_id==$row->id){
								//echo "hello";	
							if(!$use_tables){
							$url="index.php?option=com_content&view=category&id=".$row3->id."&Itemid=".$result2->id;
							}else{
							$url="index.php?option=com_content&view=category&layout=blog&id=".$row3->id."&Itemid=".$result2->id;
							}
								$swmenufree_array[] =array("TITLE" => $row3->title, "URL" =>  $url , "ID" => $row3->id+10000  ,"SECURE" => $iSecure, "PARENT" => $row->id+10000 ,  "ORDER" => $row->lft, "TARGET" => 0,"ACCESS" => $row->access  );	
							for($k=0;$k<count($hybrid_content);$k++){	
							$row2=$hybrid_content[$k];
								if($row2->catid==$row3->id){
									
									$url="index.php?option=com_content&view=article&catid=".$row->id."&id=" . $row2->id."&Itemid=".$result2->id ;
									$swmenufree_array[] =array("TITLE" => $row2->title, "URL" =>  $url , "ID" => $row2->id+100000  ,"SECURE" => $iSecure , "PARENT" => $row3->id+10000 ,  "ORDER" => $row2->ordering, "TARGET" => 0,"ACCESS" => $row2->access  );
									}	
								}
							for($m=0;$m<count($hybrid_cat);$m++){	
							$row4=$hybrid_cat[$m];
							if($row4->parent_id==$row3->id){
								//echo "hello";	
							if(!$use_tables){
							$url="index.php?option=com_content&view=category&id=".$row4->id."&Itemid=".$result2->id;
							}else{
							$url="index.php?option=com_content&view=category&layout=blog&id=".$row4->id."&Itemid=".$result2->id;
							}
								$swmenufree_array[] =array("TITLE" => $row4->title, "URL" =>  $url , "ID" => $row4->id+10000  ,"SECURE" => $iSecure, "PARENT" => $row3->id+10000 ,  "ORDER" => $row->lft, "TARGET" => 0,"ACCESS" => $row->access  );	
							
							for($k=0;$k<count($hybrid_content);$k++){	
							$row2=$hybrid_content[$k];
								if($row2->catid==$row4->id){
									
									$url="index.php?option=com_content&view=article&catid=".$row->id."&id=" . $row2->id."&Itemid=".$result2->id ;
									$swmenufree_array[] =array("TITLE" => $row2->title, "URL" =>  $url , "ID" => $row2->id+100000  ,"SECURE" => $iSecure , "PARENT" => $row4->id+10000 ,  "ORDER" => $row2->ordering, "TARGET" => 0,"ACCESS" => $row2->access  );
									}	
								}
							}	
							}
							
							}	
							
							
							}
							
							
							
							
							for($k=0;$k<count($hybrid_content);$k++){	
							$row2=$hybrid_content[$k];
								if($row2->catid==$row->id){
									
									$url="index.php?option=com_content&view=article&catid=".$row->id."&id=" . $row2->id."&Itemid=".$result2->id ;
									$swmenufree_array[] =array("TITLE" => $row2->title, "URL" =>  $url , "ID" => $row2->id+100000  ,"SECURE" => $iSecure , "PARENT" => $row->id+10000 ,  "ORDER" => $row2->ordering, "TARGET" => 0,"ACCESS" => $row2->access  );
									}	
								}
							}
						}
				
					/*
					
					for($j=0;$j<count($hybrid_content);$j++){	
					$row=$hybrid_content[$j];
					//echo $row->catid;
					if($row->catid==$opt['id']){
						//echo "hello";
							$url="index.php?option=com_content&view=article&catid=".$row->catid."&id=" . $row->id ."&Itemid=".$result2->id;
							$swmenupro_array[] =array("TITLE" => $row->title, "URL" =>  $url , "ID" => $row->id+100000  ,"SECURE" => $iSecure, "PARENT" => $result2->id ,  "ORDER" => $row->ordering, "IMAGE" => $row->image, "IMAGEOVER" => $row->image_over, "SHOWNAME" => $row->show_name, "IMAGEALIGN" => $row->image_align, "TARGETLEVEL" => $row->target_level, "TARGET" => 0,"ACCESS" => $row->access,"NCSS" => $row->normal_css,"OCSS" => $row->over_css,"SHOWITEM" => $row->show_item  );
						}	
					}
					*/
				}else if ($opt['view']=="blogsection" || $opt['view']=="section" ) {	
				//echo "hello";
				
					}		
				}
			}
		}
	return $swmenufree_array;
}


function chainFree($primary_field, $parent_field, $sort_field, $rows, $root_id = 0, $maxlevel = 25) {
    $c = new chainFree($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel);
    return $c->chainFreemenu_table;
}

class chainFree {

    var $table;
    var $rows;
    var $chainFreemenu_table;
    var $primary_field;
    var $parent_field;
    var $sort_field;

    function chainFree($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel) {
        $this->rows = $rows;
        $this->primary_field = $primary_field;
        $this->parent_field = $parent_field;
        $this->sort_field = $sort_field;
        $this->buildchainFree($root_id, $maxlevel);
    }

    function buildchainFree($rootcatid, $maxlevel) {
        foreach ($this->rows as $row) {
            $this->table[$row[$this->parent_field]][$row[$this->primary_field]] = $row;
        }
        $this->makeBranch($rootcatid, 0, $maxlevel);
    }

    function makeBranch($parent_id, $level, $maxlevel) {
        $rows = $this->table[$parent_id];
     //   $key_array1 = array_keys($rows);
       // $key_array_size1 = sizeOf($key_array1);
        //for ($j=0;$j<$key_array_size1;$j++)
        foreach ($rows as $key => $value) {
            //$key = $key_array1[$j];
            $rows[$key]['key'] = $this->sort_field;
        }

        usort($rows, 'chainFreemenuCMP');
        //$row_array = array_values($rows);
       // $row_array_size = sizeOf($row_array);
        $i = 0;
        foreach ($rows as $item) {
            //$item = $row_array[$i];
            $item['ORDER'] = ($i + 1);
            $item['indent'] = $level;
            $i++;
            $this->chainFreemenu_table[] = $item;
            if ((isset($this->table[$item[$this->primary_field]])) && (($maxlevel > $level + 1) || ($maxlevel == 0))) {
                $this->makeBranch($item[$this->primary_field], $level + 1, $maxlevel);
            }
        }
    }

}

function chainFreemenuCMP($a, $b) {
    if ($a[$a['key']] == $b[$b['key']]) {
        return 0;
    }
    return($a[$a['key']] < $b[$b['key']]) ? -1 : 1;
}

function transMenuFree($ordered, $swmenufree) {
   
   $live_site = JURI::base();
    if (substr($live_site, (strlen($live_site) - 1), 1) == "/") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 1));
    }
    if (substr($live_site, (strlen($live_site) - 13), 13) == "administrator") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 14));
    }
    if (substr($live_site, (strlen($live_site) - 1), 1) != "/") {
        $live_site =$live_site."/" ;
    }

    $str = "";
    $name = "";
    $topcounter = 0;
    $counter = 0;
    $number = count(chainFree('ID', 'PARENT', 'ORDER', $ordered, $swmenufree['parentid'], 1));

  

    $str .= "<table id=\"menu_wrap\" class=\"swmenu\" align=\"" . $swmenufree['position'] . "\"><tr><td><div id=\"td_menu_wrap\" >\n";
    $str .= "<table cellspacing=\"0\" cellpadding=\"0\" id=\"swmenu\" class=\"swmenu\" > \n";
    if (substr($swmenufree['orientation'], 0, 10) == "horizontal") {
        $str.= "<tr> \n";
    }

    foreach ($ordered as $top) {

        if ($top['indent'] == 0) {
            $top['URL'] = str_replace('&', '&amp;', $top['URL']);
            $topcounter++;

            $name = $top['TITLE'];

            if (substr($swmenufree['orientation'], 0, 8) == "vertical") {
                $str.= "<tr> \n";
            }
            if (($topcounter == $number) && ($top["ID"] == $swmenufree['active_menu'])) {
                $str.= "<td id=\"trans-active\" class='last'> \n";
            } else if ($top["ID"] == $swmenufree['active_menu']) {
                $str.= "<td id='trans-active'> \n";
            } else if ($topcounter == $number) {
                $str.= "<td class=\"last\"> \n";
            } else {
                $str.= "<td> \n";
            }

            if ((@$ordered[$counter + 1]['indent'] > $top['indent']) && $swmenufree['top_sub_indicator']) {

                $name = "<img src='" . $live_site . $swmenufree['top_sub_indicator'] . "' align='" . $swmenufree['top_sub_indicator_align'] . "' style='position:relative;left:" . $swmenufree['top_sub_indicator_left'] . "px;top:" . $swmenufree['top_sub_indicator_top'] . "px;' alt=''  border='0' />" . $name;
            }

            switch ($top['TARGET']) {
                // cases are slightly different
                case 1:
                    // open in a new window
                    $str.= '<a id="menu' . $top['ID'] . '" href="' . $top['URL'] . '" target="_blank"  >' . $name . '</a>' . "\n";
                    break;

                case 2:
                    // open in a popup window
                    $str.= "<a href=\"#\" id=\"menu" . $top['ID'] . "\" onclick=\"javascript: window.open('" . $top['URL'] . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" >" . $name . "</a>\n";
                    break;

                case 3:
                    // don't link it
                    $str.= '<a id="menu' . $top['ID'] . '" >' . $name . '</a>' . "\n";
                    break;

                default: // formerly case 2
                    $str.= '<a id="menu' . $top['ID'] . '" href="' . $top['URL'] . '" >';

                    $str.= $name . '</a>' . "\n";

                    break;
            }

            //$counter++;
            $str.= "</td> \n";

            if (substr($swmenufree['orientation'], 0, 8) == "vertical") {
                $str.= "</tr> \n";
            }
        }
        $counter++;
    }
    if (substr($swmenufree['orientation'], 0, 10) == "horizontal") {
        $str.= "</tr> \n";
    }
    $str .= "</table></div></td></tr></table><hr style=\"display:block;clear:left;margin:-0.66em 0;visibility:hidden;\" />  \n";
    $str.= "<div id=\"subwrap\"> \n";
    $str.="<script type=\"text/javascript\">\n";
    $str.="<!--\n";
    $str.="if (TransMenu.isSupported()) {\n";

    if ($swmenufree['orientation'] == "horizontal/down") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.down, " . $swmenufree['level1_sub_left'] . "," . $swmenufree['level1_sub_top'] . ", TransMenu.reference.bottomLeft);\n";
    } elseif ($swmenufree['orientation'] == "horizontal/up") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.up, " . $swmenufree['level1_sub_left'] . ", " . $swmenufree['level1_sub_top'] . ", TransMenu.reference.topLeft);\n";
    } elseif ($swmenufree['orientation'] == "horizontal/left") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.dleft, " . $swmenufree['level1_sub_left'] . "," . $swmenufree['level1_sub_top'] . ", TransMenu.reference.bottomRight);\n";
    } elseif ($swmenufree['orientation'] == "vertical/right") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.right, " . $swmenufree['level1_sub_left'] . ", " . $swmenufree['level1_sub_top'] . ", TransMenu.reference.topRight);\n";
    } elseif ($swmenufree['orientation'] == "vertical/left") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.left, " . $swmenufree['level1_sub_left'] . ", " . $swmenufree['level1_sub_top'] . ", TransMenu.reference.topLeft);\n";
    } elseif ($swmenufree['orientation'] == "vertical") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.right, " . $swmenufree['level1_sub_left'] . ", " . $swmenufree['level1_sub_top'] . ", TransMenu.reference.topRight);\n";
    } elseif ($swmenufree['orientation'] == "horizontal") {
        $str.= "var ms = new TransMenuSet(TransMenu.direction.down, " . $swmenufree['level1_sub_left'] . ", " . $swmenufree['level1_sub_top'] . ", TransMenu.reference.bottomLeft);\n";
    }
    $par = $ordered[0];

    foreach ($ordered as $sub) {
        $name = $sub['TITLE'];
        $sub2 = next($ordered);
        if ($sub['TARGET'] == "3") {
            $sub['TARGET'] = 0;
            $sub['URL'] = "javascript:void(0);";
        }
        if (($sub['indent'] == 0) && (($sub2['indent']) == 1)) {
            $str.= "var menu" . $sub['ID'] . " = ms.addMenu(document.getElementById(\"menu" . $sub['ID'] . "\"));\n ";
        } else if (($sub['ORDER'] == 1) && ($sub['indent'] > 1)) {
            $str.= "var menu" . ($sub['ID']) . " = menu" . findParFree($ordered, $par) . ".addMenu(menu" . findParFree($ordered, $par) . ".items[" . ($par['ORDER'] - 1) . "]," . $swmenufree['level2_sub_left'] . "," . $swmenufree['level2_sub_top'] . ");\n";
        }
        if ($sub['indent'] > 0) {
            $str.= "menu" . findParFree($ordered, $sub) . ".addItem(\"" . addslashes($name) . "\", \"" . addslashes($sub['URL']) . "\", \"" . $sub['TARGET'] . "\");\n";
        }
        $par = $sub;
    }

  

    $str.="function init() {\n";
    $str.="if (TransMenu.isSupported()) {\n";
    $str.="TransMenu.initialize();\n";
    $counter = 0;
    for ($i = 0; $i < count($ordered); $i++) {
        if ($ordered[$i]['indent'] == 0) {
            $counter++;
            if (@$ordered[$i + 1]['indent'] == 1) {
                $str.= "menu" . ($ordered[$i]['ID']) . ".onactivate = function() {document.getElementById(\"menu" . $ordered[$i]['ID'] . "\").className = \"hover\"; };\n ";
                $str.= "menu" . ($ordered[$i]['ID']) . ".ondeactivate = function() {document.getElementById(\"menu" . $ordered[$i]['ID'] . "\").className = \"\"; };\n ";
            } else {
                $str.= "document.getElementById(\"menu" . $ordered[$i]['ID'] . "\").onmouseover = function() {\n";
                $str.= "ms.hideCurrent();\n";
                $str.= "this.className = \"hover\";\n";
                $str.= "}\n";
                $str.= "document.getElementById(\"menu" . $ordered[$i]['ID'] . "\").onmouseout = function() { this.className = \"\"; }\n";
            }
        }
    }

    $str.="}}\n";
    if ($swmenufree['sub_sub_indicator']) {
        $str.="TransMenu.spacerGif = \"" . $live_site . "/modules/mod_swmenufree/images/transmenu/x.gif\";\n";

        $str.="TransMenu.dingbatOn = \"" . $live_site . $swmenufree['sub_sub_indicator'] . "\";\n";
        $str.="TransMenu.dingbatOff = \"" . $live_site . $swmenufree['sub_sub_indicator'] . "\"; \n";
        $str.="TransMenu.dingbatLeft = "  . $swmenufree['sub_sub_indicator_left'] . ";\n";
        $str.="TransMenu.dingbatTop = "  . $swmenufree['sub_sub_indicator_top'] . "; \n";
        $str.="TransMenu.dingbatAlign = \"" . $swmenufree['sub_sub_indicator_align'] . "\"; \n";

        $str.="TransMenu.sub_indicator = true; \n";
    } else {
        $str.="TransMenu.dingbatSize = 0;\n";
        $str.="TransMenu.spacerGif = \"\";\n";
        $str.="TransMenu.dingbatOn = \"\";\n";
        $str.="TransMenu.dingbatOff = \"\"; \n";
        $str.="TransMenu.sub_indicator = false;\n";
    }
    $str.="TransMenu.menuPadding = 0;\n";
    $str.="TransMenu.itemPadding = 0;\n";
    $str.="TransMenu.shadowSize = 2;\n";
    $str.="TransMenu.shadowOffset = 3;\n";
    $str.="TransMenu.shadowColor = \"#888\";\n";
    $str.="TransMenu.shadowPng = \"" . $live_site . "/modules/mod_swmenufree/images/transmenu/grey-40.png\";\n";
    $str.="TransMenu.backgroundColor = \"" . $swmenufree['sub_back'] . "\";\n";
    $str.="TransMenu.backgroundPng = \"" . $live_site . "/modules/mod_swmenufree/images/transmenu/white-90.png\";\n";
    $str.="TransMenu.hideDelay = " . ($swmenufree['specialB'] * 2) . ";\n";
    $str.="TransMenu.slideTime = " . $swmenufree['specialB'] . ";\n";
    $str .= "TransMenu.selecthack = 1;\n";
    $str .= "TransMenu.autoposition = " . $swmenufree['auto_position'] . ";\n";
    $str .= "TransMenu.fontFace = \"" . $swmenufree['top_font_face'] . "\";\n";
    $str .= "TransMenu.fontColor = \"" . $swmenufree['main_font_color'] . "\";\n";
    // $str .= "TransMenu.activeId = \"" . $active_id . "\";\n";
//    $str .= "TransMenu.preview = \"" . $preview . "\";\n";
    $str .= "TransMenu.renderAll();\n";


    $str.="if ( typeof window.addEventListener != \"undefined\" )\n";
    $str.="window.addEventListener( \"load\", init, false );\n";
    $str.="else if ( typeof window.attachEvent != \"undefined\" ) {\n";
    $str.="window.attachEvent( \"onload\", init);\n";
    $str.="}else{\n";
    $str.="if ( window.onload != null ) {\n";
    $str.="var oldOnload = window.onload;\n";
    $str.="window.onload = function ( e ) {\n";
    $str.="oldOnload( e );\n";
    $str.="init();\n";
    $str.="}\n}else\n";
    $str.="window.onload = init();\n";
    $str.="}\n}\n\n";

    
   
      
        if (($swmenufree['c_corner_style'] != 'none') && ($swmenufree['c_corner_style'])&& ($swmenufree['c_corner_style'] != 'curvycorner')){
        
        if (($swmenufree['main_border_width'] > 0) && ($swmenufree['main_border_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
                $str .= "jQuery('#td_menu_wrap').css('z-index','-1');\n";
               // $str .= "jQuery('#td_menu_wrap').wrap('<div></div>');\n";
                $str .= "jQuery('#td_menu_wrap').parent().css('padding', '" . $swmenufree['main_border_width'] . "px');\n";
                $str .= "jQuery('#td_menu_wrap').parent().css('background-color', '" . $swmenufree['main_border_color'] . "');\n";
                $str .= "jQuery('#td_menu_wrap').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
                $str .= "jQuery('#td_menu_wrap').parent().corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size'] + $swmenufree['main_border_width']) . "px');\n";
                //$str .= "jQuery('#td_menu_wrap').parent().css('display','block');\n";
                $str .= "}else{\n";
                $str .= "jQuery('#td_menu_wrap').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               $str .= "jQuery('#td_menu_wrap').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
            }
        }
        
        if (($swmenufree['t_corner_style'] != 'none') && ($swmenufree['t_corner_style'])&& ($swmenufree['t_corner_style'] != 'curvycorner')){
        
        if (($swmenufree['main_border_over_width'] > 0) && ($swmenufree['main_border_over_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
                //$str .= "jQuery('#td_menu_wrap a').css('z-index','-1');\n";
                $str .= "jQuery('#td_menu_wrap a').wrap('<div></div>');\n";
                $str .= "jQuery('#td_menu_wrap a').parent().css('padding', '" . $swmenufree['main_border_over_width'] . "px');\n";
                $str .= "jQuery('#td_menu_wrap a').parent().css('background-color', '" . $swmenufree['main_border_color_over'] . "');\n";
                $str .= "jQuery('#td_menu_wrap a').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
               // $str .= "jQuery('#td_menu_wrap a').parent().corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size'] + $swmenufree['main_border_over_width']) . "px');\n";
                //$str .= "jQuery('#td_menu_wrap').parent().css('display','block');\n";
                $str .= "}else{\n";
                $str .= "jQuery('#td_menu_wrap a').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               $str .= "jQuery('#td_menu_wrap a').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
            }
        }
       
       if (($swmenufree['s_corner_style'] != 'none') && ($swmenufree['s_corner_style'])&& ($swmenufree['s_corner_style'] != 'curvycorner')){
           
            $str .= "jQuery('#subwrap .background').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . @$swmenufree['s_corner_size'] . "px');\n";
            $str .= "jQuery('#subwrap  .item.hover td ').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . @$swmenufree['s_corner_size'] . "px');\n";
        }
    





    if ($swmenufree['top_ttf']) {
       $str .= "Cufon.replace('table.swmenu a',{hover: true, fontFamily: '" . $swmenufree['top_font_face'] . "' });\n";
    }
    if ($swmenufree['sub_ttf']) {
        $str .= "Cufon.replace('#subwrap .item ',{hover: true, fontFamily: '" . $swmenufree['sub_font_face'] . "' });\n";
    }
    if ($swmenufree['overlay_hack']) {
        $str .= "jQuery(document).ready(function($){\n";
       // $str .= "jQuery('#menu_wrap').parents().css('overflow','visible');\n";
       // $str .= "jQuery('html').css('overflow','auto');\n";
        $str .= "jQuery('#menu_wrap').parents().css('z-index','1');\n";
        $str .= "jQuery('#menu_wrap').css('z-index','101');\n";
        $str .= "});\n";
    }
    $str .= "//--> \n";
    $str .= "</script></div>  \n";
    return $str;
}

function findParFree($ordered, $sub) {
    $submenu = chainFree('ID', 'PARENT', 'ORDER', $ordered, $sub['PARENT'], 1);

    if ($sub['indent'] == 1) {
        return $submenu[0]['PARENT'];
    } else {
        return $submenu[0]['ID'];
    }
}

function GosuMenuFree($ordered, $swmenufree) {
   
    $live_site = JURI::base();
    if (substr($live_site, (strlen($live_site) - 1), 1) == "/") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 1));
    }
    if (substr($live_site, (strlen($live_site) - 13), 13) == "administrator") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 14));
    }
    if (substr($live_site, (strlen($live_site) - 1), 1) != "/") {
        $live_site =$live_site."/" ;
    }
   
    $sub_active = 0;
    $name = "";
    $counter = 0;
    $doMenu = 1;
    $number = count($ordered);
    $topcount = 0;
    
    $str = "<table  id=\"outertable\" align=\"" . $swmenufree['position'] . "\" class=\"outer\"><tr><td><div id=\"outerwrap\" >\n";
    $str .= "<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" id=\"swmenu\" class=\"ddmx\"  > \n";
    if ($swmenufree['orientation'] == "horizontal/down" || $swmenufree['orientation'] == "horizontal" || $swmenufree['orientation'] == "horizontal/left" || $swmenufree['orientation'] == "horizontal/up") {
        $str .= "<tr> \n";
    }
    while ($doMenu) {
        if ($ordered[$counter]['indent'] == 0) {
            $ordered[$counter]['URL'] = str_replace('&', '&amp;', $ordered[$counter]['URL']);
            $name = ($ordered[$counter]['TITLE']);
            if ($swmenufree['orientation'] == "vertical/right" || $swmenufree['orientation'] == "vertical" || $swmenufree['orientation'] == "vertical/left") {
                $str .= "<tr> \n";
            }
            $act = 0;
            if (islastFree($ordered, $counter)) {
                if (($ordered[$counter]['ID'] == $swmenufree['active_menu'])) {
                    $str .= "<td class='item11 acton last'> \n";
                    $act = 1;
                } else {
                    $str .= "<td class='item11 last'> \n";
                }
            } else {
                if (($ordered[$counter]['ID'] == $swmenufree['active_menu'])) {
                    $str .= "<td class='item11 acton'> \n";
                    $act = 1;
                } else {
                    $str .= "<td class='item11'> \n";
                }
            }
            $topcount++;

            // echo $top_sub_indicator;
            $classname = "item1";
            if ($ordered[$counter]['indent'] > @$ordered[$counter - 1]['indent']) {
                $classname .= " first";
            }
            if (($counter + 1 == $number) || islastFree($ordered, $counter)) {
                $classname .= " last";
            }
            
            if (($counter + 1 != $number) && ($ordered[$counter + 1]['indent'] > $ordered[$counter]['indent']) && $swmenufree['top_sub_indicator']) {
             $name = "<div><img src='" . $live_site . $swmenufree['top_sub_indicator'] . "' align='" . $swmenufree['top_sub_indicator_align'] . "' style='position:relative;left:" . $swmenufree['top_sub_indicator_left'] . "px;top:" . $swmenufree['top_sub_indicator_top'] . "px;' alt=''  border='0' />" . $name."</div>\n";
             }


            switch ($ordered[$counter]['TARGET']) {
                case 1:
                    $str .= '<a href="' . $ordered[$counter]['URL'] . '" target="_blank" class="' . $classname . '" >' . $name . '</a>';
                    break;
                case 2:
                    $str .= "<a href=\"#\" onclick=\"javascript: window.open('" . $ordered[$counter]['URL'] . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class='" . $classname . "'>" . $name . "</a>\n";
                    break;
                case 3:
                    $str .= '<a class="' . $classname . '" >' . $name . '</a>';
                    break;
                default:
                    $str .= '<a href="' . $ordered[$counter]['URL'] . '" class="' . $classname . '">' . $name . '</a>';
                    break;
            }

            if ($counter + 1 == $number) {
                $doSubMenu = 0;
                $doMenu = 0;
                $str .= "<div class=\"section\" style=\"border:0 !important;display:none;\"></div> \n";
            } elseif ($ordered[$counter + 1]['indent'] == 0) {
                $doSubMenu = 0;
                $str .= "<div class=\"section\" style=\"border:0 !important;display:none;\"></div> \n";
            } else {
                $doSubMenu = 1;
            }
            $counter++;
          
            while ($doSubMenu) {
                if ($ordered[$counter]['indent'] != 0) {
                    if ($ordered[$counter]['indent'] > $ordered[$counter - 1]['indent']) {
                        if ($act && $sub_active && ($swmenufree['orientation'] == "vertical/right")) {
                            $str .= '<div class="subsection"  >';
                        } else {
                            $str .= '<div class="section"  >';
                        }
                    }
                    $ordered[$counter]['URL'] = str_replace('&', '&amp;', $ordered[$counter]['URL']);
                    $name = ($ordered[$counter]['TITLE']);
                    if (($counter + 1 == $number) || ($ordered[$counter + 1]['indent'] == 0)) {
                        $doSubMenu = 0;
                    }
                    $style = " style=\"";
                    $classname = "item2";
                    if ($ordered[$counter]['indent'] > $ordered[$counter - 1]['indent']) {
                        $classname .= " first";
                    }
                    if (($counter + 1 == $number) || islastFree($ordered, $counter)) {
                        $classname .= " last";
                    }
                    if (($counter + 1 != $number) && ($ordered[$counter + 1]['indent'] > $ordered[$counter]['indent']) && $swmenufree['sub_sub_indicator']) {

                         $name = "<img src='" . $live_site . $swmenufree['sub_sub_indicator'] . "' align='" . $swmenufree['sub_sub_indicator_align'] . "' style='position:relative;left:" . $swmenufree['sub_sub_indicator_left'] . "px;top:" . $swmenufree['sub_sub_indicator_top'] . "px;' alt=''  border='0' />" . $name;
                       }
                    $style .= "\" ";

                    switch ($ordered[$counter]['TARGET']) {
                        case 1:
                            $str .= '<a href="' . $ordered[$counter]['URL'] . '" ' . $style . ' target="_blank" class="' . $classname . '" >' . $name . '</a>';
                            break;
                        case 2:
                            $str .= "<a href=\"#\" " . $style . " onclick=\"javascript: window.open('" . $ordered[$counter]['URL'] . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"" . $classname . "\">" . $name . "</a>\n";
                            break;
                        case 3:
                            $str .= '<a class="' . $classname . '" ' . $style . ' >' . $name . '</a>';
                            break;
                        default:
                            $str .= "<a href=\"" . $ordered[$counter]['URL'] . "\" class=\"" . $classname . "\" " . $style . ">" . $name . "</a>\n";
                            break;
                    }

                    if (($counter + 1 == $number) || ($ordered[$counter + 1]['indent'] < $ordered[$counter]['indent'])) {
                        $str .= str_repeat('</div>', (($ordered[$counter]['indent']) - (@$ordered[$counter + 1]['indent'])));
                    }
                    $counter++;
                }
            }
        }
        $str .= "</td> \n";
        if ($swmenufree['orientation'] == "vertical/right" || $swmenufree['orientation'] == "vertical/left" || $swmenufree['orientation'] == "vertical") {
            $str .= "</tr> \n";
        }
        if ($counter == ($number)) {
            $doMenu = 0;
        }
    }
    if ($swmenufree['orientation'] == "horizontal/down" || $swmenufree['orientation'] == "horizontal/left" || $swmenufree['orientation'] == "horizontal/up" || $swmenufree['orientation'] == "horizontal") {
        $str .= "</tr> \n";
    }
    $str .= "</table></div></td></tr></table><hr style=\"display:block;clear:left;margin:-0.66em 0;visibility:hidden;\" /> \n";
    $str .= "<script type=\"text/javascript\">\n";
    $str .= "<!--\n";
    $str .= "function makemenu(){\n";
    $str .= "var ddmx = new DropDownMenuX('swmenu');\n";
    $str .= "ddmx.type = '" . $swmenufree['orientation'] . "'; \n";
    $str .= "ddmx.delay.show = 0;\n";
    $str .= "ddmx.iframename = 'ddmx';\n";
    $str .= "ddmx.delay.hide = " . $swmenufree['specialB'] . ";\n";
    $str .= "ddmx.effect = '" . ($swmenufree['extra'] ? $swmenufree['extra'] : 'none') . "';\n";
    $str .= "ddmx.position.levelX.left = " . $swmenufree['level2_sub_left'] . ";\n";
    $str .= "ddmx.position.levelX.top = " . $swmenufree['level2_sub_top'] . ";\n";
    $str .= "ddmx.position.level1.left = " . $swmenufree['level1_sub_left'] . ";\n";
    $str .= "ddmx.position.level1.top = " . $swmenufree['level1_sub_top'] . "; \n";
    $str .= "ddmx.fixIeSelectBoxBug =  true;\n";
    $str .= "ddmx.autoposition = " . ($swmenufree['auto_position'] ? 'true' : 'false') . ";\n";
   
    $str .= "ddmx.init(); \n";
    $str .= "}\n";
    $str .= "if ( typeof window.addEventListener != \"undefined\" )\n";
    $str .= "window.addEventListener( \"load\", makemenu, false );\n";
    $str .= "else if ( typeof window.attachEvent != \"undefined\" ) { \n";
    $str .= "window.attachEvent( \"onload\", makemenu );\n";
    $str .= "}\n";
    $str .= "else {\n";
    $str .= "if ( window.onload != null ) {\n";
    $str .= "var oldOnload = window.onload;\n";
    $str .= "window.onload = function ( e ) { \n";
    $str .= "oldOnload( e ); \n";
    $str .= "makemenu() \n";
    $str .= "} \n";
    $str .= "}  \n";
    $str .= "else  { \n";
    $str .= "window.onload = makemenu();\n";
    $str .= "} }\n";
    $str .= "//--> \n";
    $str .= "</script>  \n";
    $str .= "<script type=\"text/javascript\">\n";
    $str .= "<!--\n";
  //  $str.= "alert(jQuery.browser.version);\n";
    
    if (($swmenufree['c_corner_style'] != 'none') && ($swmenufree['c_corner_style'])&& ($swmenufree['c_corner_style'] != 'curvycorner')){
        
        if (($swmenufree['main_border_width'] > 0) && ($swmenufree['main_border_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9 ) {\n";
                $str .= "jQuery('#outerwrap').css('z-index','-1');\n";
                $str .= "jQuery('#outerwrap').wrap('<div></div>');\n";
                $str .= "jQuery('#outerwrap').parent().css('padding', '" . $swmenufree['main_border_width'] . "px');\n";
                $str .= "jQuery('#outerwrap').parent().css('background-color', '" . $swmenufree['main_border_color'] . "');\n";
                $str .= "jQuery('#outerwrap').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
                $str .= "jQuery('#outerwrap').parent().corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size'] + $swmenufree['main_border_width']) . "px');\n";
               // $str .= "jQuery('#outerwrap').css('z-index','1');\n";
                $str .= "}else{\n";
                $str .= "jQuery('#outerwrap').corner('keep " . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               $str .= "jQuery('#outerwrap').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
            }
        }
    if (($swmenufree['t_corner_style'] != 'none') && ($swmenufree['t_corner_style'])&& ($swmenufree['t_corner_style'] != 'curvycorner')){
        if (($swmenufree['main_border_over_width'] > 0) && ($swmenufree['main_border_over_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
                $str .= "jQuery('#swmenu .item1').css('z-index','-1');\n";
               // $str .= "jQuery('#swmenu .item1').wrap('<span></span>');\n";
                $str .= "jQuery('#swmenu .item1').parent().css('padding', '" . $swmenufree['main_border_over_width'] . "px');\n";
                $str .= "jQuery('#swmenu .item1').parent().css('background-color', '" . $swmenufree['main_border_color_over'] . "');\n";
                $str .= "jQuery('#swmenu .item1').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
                $str .= "jQuery('#swmenu .item1').parent().corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size'] + $swmenufree['main_border_over_width']) . "px');\n";
               // $str .= "jQuery('#outerwrap').css('z-index','1');\n";
                $str .= "}else{\n";
                $str .= "jQuery('#swmenu .item1').corner('keep " . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               $str .= "jQuery('#swmenu .item1').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
            }
         }
    if (($swmenufree['s_corner_style'] != 'none') && ($swmenufree['s_corner_style'])&& ($swmenufree['s_corner_style'] != 'curvycorner')){
       
         if (($swmenufree['sub_border_width'] > 0) && ($swmenufree['sub_border_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
               // $str .= "jQuery('.section').css('z-index','-1');\n";
             //   $str .= "jQuery('.section').wrap('<span></span>');\n";
             //   $str .= "jQuery('.section').parent().css('padding', '" . $swmenufree['sub_border_width'] . "px');\n";
             //   $str .= "jQuery('.section').parent().css('background-color', '" . $swmenufree['sub_border_color'] . "');\n";
                $str .= "jQuery('.section').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . ($swmenufree['s_corner_size']) . "px');\n";
            //    $str .= "jQuery('.section').parent().corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . ($swmenufree['s_corner_size'] + $swmenufree['sub_border_width']) . "px');\n";
               // $str .= "jQuery('#outerwrap').css('z-index','1');\n";
                $str .= "}else{\n";
                $str .= "jQuery('.section').corner('keep " . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . ($swmenufree['s_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               if (@$swmenufree['stl_corner'] + @$swmenufree['str_corner'] != 0) {
                    $str .= "jQuery('#swmenu .section .item2.first').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . @$swmenufree['s_corner_size'] . "px');\n";
               }
               if (@$swmenufree['sbl_corner'] + @$swmenufree['sbr_corner'] != 0) {
                    $str .= "jQuery('#swmenu .section .item2.last').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . @$swmenufree['s_corner_size'] . "px');\n";
               }
       }
        
        
        
    }
    
 // $str.="curvyCorners.init();\n";
   if ($swmenufree['overlay_hack']) {
        $str .= "jQuery('#swmenu').parents().css('overflow','visible');\n";
        $str .= "jQuery('html').css('overflow','auto');\n";
        $str .= "jQuery('#swmenu').parents().css('z-index','1');\n";
        $str .= "jQuery('#swmenu').css('z-index','501');\n";
    }
    if ($swmenufree['top_ttf']) {
       $str .= "Cufon.replace('.ddmx .item1',{hover: true, fontFamily: '" . $swmenufree['top_font_face']. "' });\n";
    }
    if ($swmenufree['sub_ttf']) {
       
        $str .= "Cufon.replace('.ddmx .item2',{hover: true, fontFamily: '" . $swmenufree['sub_font_face']. "' });\n";
    }
    $str .= "//-->\n";
    $str .= "</script>\n";
    return $str;
}

function SuperfishMenuFree($ordered, $swmenufree) {
   
   $live_site = JURI::base();
    if (substr($live_site, (strlen($live_site) - 1), 1) == "/") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 1));
    }
    if (substr($live_site, (strlen($live_site) - 13), 13) == "administrator") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 14));
    }
    if (substr($live_site, (strlen($live_site) - 1), 1) != "/") {
        $live_site =$live_site."/" ;
    }
    $name = "";
    $counter = 0;
    $doMenu = 1;
    //$uniqueID = $swmenufree['id'];
    $number = count($ordered);
    $topcount = 0;
   
    $str = "<div id=\"sfmenu\" align=\"" . $swmenufree['position'] . "\" >\n";
    if ($swmenufree['orientation'] == "horizontal") {
        $str.= "<ul  id=\"swmenu\" class=\"sw-sf\"  > \n";
    } else {

        $str.= "<ul  id=\"swmenu\" class=\"sw-sf sf-vertical\"  > \n";
    }

    while ($doMenu) {

        if ($ordered[$counter]['indent'] == 0) {
            $ordered[$counter]['URL'] = str_replace('&', '&amp;', $ordered[$counter]['URL']);
            $name = $ordered[$counter]['TITLE'];

            if (($counter + 1 != $number) && ($ordered[$counter + 1]['indent'] > $ordered[$counter]['indent']) && $swmenufree['top_sub_indicator']) {
                $name = "<img src='" . $live_site . $swmenufree['top_sub_indicator'] . "' align='" . $swmenufree['top_sub_indicator_align'] . "' style='position:relative;left:" . $swmenufree['top_sub_indicator_left'] . "px;top:" . $swmenufree['top_sub_indicator_top'] . "px;' alt=''  border='0' />" . $name;
              }

            if ($swmenufree['orientation'] == "vertical") {
                //	$str.= "<tr> \n";
            }
            $act = 0;
            if (islastFree($ordered, $counter)) {
                if (($ordered[$counter]['ID'] == $swmenufree['active_menu'])) {
                    $str.= "<li id='sf-" . $ordered[$counter]['ID'] . "' class='current'> \n";
                    $act = 1;
                   
                } else {
                    $str.= "<li id='sf-" . $ordered[$counter]['ID'] . "' > \n";
                }
            } else {
                if (($ordered[$counter]['ID'] == $swmenufree['active_menu'])) {
                    $str.= "<li id='sf-" . $ordered[$counter]['ID'] . "' class='current'> \n";
                    $act = 1;
                    
                } else {
                    $str.= "<li id='sf-" . $ordered[$counter]['ID'] . "' > \n";
                }
            }
            $topcount++;
            
            switch ($ordered[$counter]['TARGET']) {
                // cases are slightly different
                case 1:
                    // open in a new window
                    if (islastFree($ordered, $counter)) {
                        $str.= '<a href="' . $ordered[$counter]['URL'] . '" target="_blank" class="item1 last" >' . $name . '</a>';
                    } else {
                        $str.= '<a href="' . $ordered[$counter]['URL'] . '" target="_blank" class="item1" >' . $name . '</a>';
                    }

                    break;

                case 2:
                    // open in a popup window
                    if (islastFree($ordered, $counter)) {
                        $str.= "<a href=\"#\" onclick=\"javascript: window.open('" . $ordered[$counter]['URL'] . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"item1 last\">" . $name . "</a>\n";
                    } else {
                        $str.= "<a href=\"#\" onclick=\"javascript: window.open('" . $ordered[$counter]['URL'] . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"item1\">" . $name . "</a>\n";
                    }

                    break;

                case 3:
                    // don't link it
                    if (islastFree($ordered, $counter)) {
                        $str.= '<a class="item1 last" >' . $name . '</a>';
                    } else {
                        $str.= '<a class="item1" >' . $name . '</a>';
                    }

                    break;

                default: // formerly case 2
                    // open in parent window
                    if (islastFree($ordered, $counter)) {
                        $str.= "<a href='" . $ordered[$counter]['URL'] . "' class='item1 last'>" . $name . "</a>\n";
                    } else {
                        $str.= "<a href='" . $ordered[$counter]['URL'] . "' class='item1'>" . $name . "</a>\n";
                    }
                    break;
            }


            if ($counter + 1 == $number) {
                $doSubMenu = 0;
                $doMenu = 0;
                //$str.= "<div class=\"section\" style=\"border:0 !important;\"></div> \n";
            } elseif ($ordered[$counter + 1]['indent'] == 0) {
                $doSubMenu = 0;
                //$str.= "<div class=\"section\" style=\"border:0 !important;\"></div> \n";
            } else {
                $doSubMenu = 1;
            }


            $counter++;
            
            while ($doSubMenu) {
                if ($ordered[$counter]['indent'] != 0) {
                    if ($ordered[$counter]['indent'] > $ordered[$counter - 1]['indent']) {
                        $str.= "<ul class='sf-section' >\n";
                    }
                    $ordered[$counter]['URL'] = str_replace('&', '&amp;', $ordered[$counter]['URL']);
                    $name = $ordered[$counter]['TITLE'];

                    if (($counter + 1 == $number) || ($ordered[$counter + 1]['indent'] == 0)) {
                        $doSubMenu = 0;
                        //$str.= "</li> \n";
                    }
                    //$style=" style=\"";
                    $li_class = "";
                    $a_class = "item2";

                    if (($counter + 1 == $number) || islastFree($ordered, $counter)) {
                        $a_class.=" last";
                    }
                    if ($ordered[$counter]['indent'] > $ordered[$counter - 1]['indent']) {
                        $a_class.=" first";
                    }

                    if (($counter + 1 != $number) && ($ordered[$counter + 1]['indent'] > $ordered[$counter]['indent']) && $swmenufree['sub_sub_indicator']) {
                        $name = "<img src='" . $live_site . $swmenufree['sub_sub_indicator'] . "' align='" . $swmenufree['sub_sub_indicator_align'] . "' style='position:relative;left:" . $swmenufree['sub_sub_indicator_left'] . "px;top:" . $swmenufree['sub_sub_indicator_top'] . "px;' alt=''  border='0' />" . $name;
                     }

                   
                        $li_class = "sf-" . $ordered[$counter]['ID'] . "";
                   


                    $str.="<li id=\"" . $li_class . "\">";


                    switch ($ordered[$counter]['TARGET']) {
                        // cases are slightly different
                        case 1:
                            // open in a new window
                            $str.= '<a href="' . $ordered[$counter]['URL'] . '" target="_blank" class="' . $a_class . '" >' . $name . '</a>';
                            break;

                        case 2:
                            // open in a popup window
                            $str.= "<a href=\"#\" onclick=\"javascript: window.open('" . $ordered[$counter]['URL'] . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"" . $a_class . "\">" . $name . "</a>\n";
                            break;

                        case 3:
                            // don't link it
                            $str.= '<a class="' . $a_class . '" >' . $name . '</a>';
                            break;

                        default: // formerly case 2
                            // open in parent window
                            $str.= "<a href=\"" . $ordered[$counter]['URL'] . "\" class=\"" . $a_class . "\" >" . $name . "</a>\n";
                            break;
                    }




                    if (($counter + 1 == $number) || ($ordered[$counter + 1]['indent'] < $ordered[$counter]['indent'])) {
                        $str .= str_repeat("</li></ul>\n", (($ordered[$counter]['indent']) - (@$ordered[$counter + 1]['indent'])));
                        if ((@$ordered[$counter + 1]['indent'] > 0)) {
                            $str .= "</li> \n";
                        }
                    } else if ((@$ordered[$counter + 1]['indent'] <= $ordered[$counter]['indent'])) {
                        $str .= "</li> \n";
                    }
                    $counter++;
                }
            }
            $str.= "</li> \n";
        }

        //$str.= "</li> \n";

        if ($swmenufree['orientation'] == "vertical") {
            //$str.= "</tr> \n";
        }
        if ($counter == ($number)) {
            $doMenu = 0;
        }
    }
    //if ($swmenufree['orientation']=="horizontal"){$str.= "</tr> \n";}
    $str .= "</ul><hr style=\"display:block;clear:left;margin:-0.66em 0;visibility:hidden;\" /></div> \n";


    if ($swmenufree['sub_width'] > 0) {
        $str.="<script type=\"text/javascript\">\n";
        $str.="<!--\n";
        $str.="jQuery.noConflict();\n";
        $str.="jQuery(document).ready(function($){\n";
        $str.="$('.sw-sf').superfish({\n";
        switch ($swmenufree['extra']) {
            // cases are slightly different
            case "fade":
                $str.="animation:   {opacity:'show'},";
                $str.="speed:  " . $swmenufree['specialB'] . ",";
                break;

            case "slide-down":
                $str.="animation:   {height:'show'},";
                $str.="speed:  " . $swmenufree['specialB'] . ",";
                break;

            case "slide-right":
                $str.="animation:   {width:'show'},";
                $str.="speed:  " . $swmenufree['specialB'] . ",";
                break;

            default:
                //	$str.="animation:   {opacity:'show'},";
                $str.="speed:   1,";
                break;
        }
        // $str.="animation:   {opacity:'show',width:'show'},";

        $str.="autoArrows:  false\n";

        //$str.="dropShadows: true\n";
        //$str.="pathClass:  'current' \n";
        $str.="});\n";

        if ($swmenufree['overlay_hack']) {
            //$str.="alert($.topZIndex());\n";
            //  $str.="$('#left_container').topZIndex();\n";
          //  $str.="$('.sw-sf').parents().css('overflow','visible');\n";
          //  $str.="$('html').css('overflow','auto');\n";
            $str.="$('.sw-sf').parents().css('z-index','1');\n";
            $str.="$('.sw-sf').css('z-index','501');\n";
        }
        /// $str.="$('#menu".$uniqueID." ).dropShadow();\n";
        $str.="});\n";
    } else {

        $str.="<script type=\"text/javascript\">\n";
        $str.="<!--\n";
      //  $str.="jQuery.noConflict();\n";
        //$str.="alert($.topZIndex());\n";
        $str.="jQuery(document).ready(function($){\n";
        $str.="$('.sw-sf').supersubs({ \n";
        $str.="minWidth:8,\n";
        $str.="maxWidth:80,\n";
        $str.="extraWidth:2\n";
        $str.="}).superfish({\n";
        switch ($swmenufree['extra']) {
            // cases are slightly different
            case "fade":
                $str.="animation:   {opacity:'show'},";
                $str.="speed:  " . $swmenufree['specialB'] . ",";
                break;

            case "slide-down":
                $str.="animation:   {height:'show'},";
                $str.="speed:  " . $swmenufree['specialB'] . ",";
                break;

            case "slide-right":
                $str.="animation:   {width:'show'},";
                $str.="speed:  " . $swmenufree['specialB'] . ",";
                break;

            default:
                //	$str.="animation:   {opacity:'show'},";
                $str.="speed:   1,";
                break;
        }

        //$str.="animation:   {opacity:'show',width:'show'},";

        $str.="autoArrows:  false\n";

        //$str.="dropShadows: true\n";
        //$str.="pathClass:  'current' \n";
        $str.="});\n";

        //$str.="$.fx.off=true;\n";

        if ($swmenufree['overlay_hack']) {
            //$str.="alert($.topZIndex());\n";
            //  $str.="$('#left_container').topZIndex();\n";
          //  $str.="$('.sw-sf').parents().css('overflow','visible');\n";
          //  $str.="$('html').css('overflow','auto');\n";
            $str.="$('.sw-sf').parents().css('z-index','1');\n";
            $str.="$('.sw-sf').css('z-index','501');\n";
        }
        $str.="});\n";
    }


   if (($swmenufree['c_corner_style'] != 'none') && ($swmenufree['c_corner_style'])&& ($swmenufree['c_corner_style'] != 'curvycorner')){
        
        if (($swmenufree['main_border_width'] > 0) && ($swmenufree['main_border_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
                $str .= "jQuery('#sfmenu').css('z-index','-1');\n";
                $str .= "jQuery('#sfmenu').wrap('<div></div>');\n";
                $str .= "jQuery('#sfmenu').parent().css('padding', '" . $swmenufree['main_border_width'] . "px');\n";
                $str .= "jQuery('#sfmenu').parent().css('background-color', '" . $swmenufree['main_border_color'] . "');\n";
                $str .= "jQuery('#sfmenu').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
                $str .= "jQuery('#sfmenu').parent().corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size'] + $swmenufree['main_border_width']) . "px');\n";
               // $str .= "jQuery('#outerwrap').css('z-index','1');\n";
                $str .= "}else{\n";
                $str .= "jQuery('#sfmenu').corner('keep " . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               $str .= "jQuery('#sfmenu').corner('" . $swmenufree['c_corner_style'] . " " . (@$swmenufree['ctl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ctr_corner'] ? 'tr' : '') . " " . (@$swmenufree['cbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['cbr_corner'] ? 'br' : '') . " " . ($swmenufree['c_corner_size']) . "px');\n";
            }
        }
    if (($swmenufree['t_corner_style'] != 'none') && ($swmenufree['t_corner_style'])&& ($swmenufree['t_corner_style'] != 'curvycorner')){
        if (($swmenufree['main_border_over_width'] > 0) && ($swmenufree['main_border_over_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
                $str .= "jQuery('.sw-sf a.item1').css('z-index','-1');\n";
               // $str .= "jQuery('.sw-sf a.item1').wrap('<span></span>');\n";
                $str .= "jQuery('.sw-sf a.item1').parent().css('padding', '" . $swmenufree['main_border_over_width'] . "px');\n";
                $str .= "jQuery('.sw-sf a.item1').parent().css('background-color', '" . $swmenufree['main_border_color_over'] . "');\n";
                $str .= "jQuery('.sw-sf a.item1').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
                $str .= "jQuery('.sw-sf a.item1').parent().corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size'] + $swmenufree['main_border_over_width']) . "px');\n";
               // $str .= "jQuery('#outerwrap').css('z-index','1');\n";
                $str .= "}else{\n";
                $str .= "jQuery('.sw-sf a.item1').corner('keep " . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               $str .= "jQuery('.sw-sf a.item1').corner('" . $swmenufree['t_corner_style'] . " " . (@$swmenufree['ttl_corner'] ? 'tl' : '') . " " . (@$swmenufree['ttr_corner'] ? 'tr' : '') . " " . (@$swmenufree['tbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['tbr_corner'] ? 'br' : '') . " " . ($swmenufree['t_corner_size']) . "px');\n";
            }
         }
    if (($swmenufree['s_corner_style'] != 'none') && ($swmenufree['s_corner_style'])&& ($swmenufree['s_corner_style'] != 'curvycorner')){
       
         if (($swmenufree['sub_border_width'] > 0) && ($swmenufree['sub_border_style'] != 'none')) {
                $str .= "if (jQuery.browser.msie && jQuery.browser.version < 9) {\n";
               // $str .= "jQuery('.section').css('z-index','-1');\n";
             //   $str .= "jQuery('.section').wrap('<span></span>');\n";
             //   $str .= "jQuery('.section').parent().css('padding', '" . $swmenufree['sub_border_width'] . "px');\n";
             //   $str .= "jQuery('.section').parent().css('background-color', '" . $swmenufree['sub_border_color'] . "');\n";
                $str .= "jQuery('.sf-section .item2').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . ($swmenufree['s_corner_size']) . "px');\n";
            //    $str .= "jQuery('.section').parent().corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . ($swmenufree['s_corner_size'] + $swmenufree['sub_border_width']) . "px');\n";
               // $str .= "jQuery('#outerwrap').css('z-index','1');\n";
                $str .= "}else{\n";
                $str .= "jQuery('.sf-section .item2').corner('keep " . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . ($swmenufree['s_corner_size']) . "px');\n";
                $str .= "}\n";
            }else{ 
               if (@$swmenufree['stl_corner'] + @$swmenufree['str_corner'] != 0) {
                   $str .= "jQuery('.sf-section .item2.first').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['stl_corner'] ? 'tl' : '') . " " . (@$swmenufree['str_corner'] ? 'tr' : '') . " " . @$swmenufree['s_corner_size'] . "px');\n";
           
                    }
                if (@$swmenufree['sbl_corner'] + @$swmenufree['sbr_corner'] != 0) {
                    $str .= "jQuery('.sf-section .item2.last').corner('" . $swmenufree['s_corner_style'] . " " . (@$swmenufree['sbl_corner'] ? 'bl' : '') . " " . (@$swmenufree['sbr_corner'] ? 'br' : '') . " " . @$swmenufree['s_corner_size'] . "px');\n";
                }
       }
        
        
        
    }
       
   if ($swmenufree['top_ttf']) {
       $str .= "Cufon.replace('.sw-sf .item1',{hover: true, fontFamily: '" . $swmenufree['top_font_face'] . "' });\n";
    }
    if ($swmenufree['sub_ttf']) {
        $str .= "Cufon.replace('.sw-sf .item2',{hover: true, fontFamily: '" . $swmenufree['sub_font_face'] . "' });\n";
    }
    $str .= "//-->\n";
    $str .= "</script>\n";

    return $str;
}

function islastFree($array, $id) {

    $this_level = $array[$id]['indent'];
    $last = 0;
    $i = $id + 1;
    $do = 1;
    while ($do) {

        if (@$array[$i]['indent'] < $this_level || $i == count($array)) {
            $last = 1;
        }
        if (@$array[$i]['indent'] <= $this_level) {
            $do = 0;
        }
        $i++;
    }
    return $last;
}

function swmenuGetBrowserFree() {

    $br = new swBrowserFree;
    // echo substr($br->Name.$br->Version,0,5);


    return($br->Name . $br->Version);
}

function inAgentFree($agent) {
    global $HTTP_USER_AGENT;
    $notAgent = strpos($HTTP_USER_AGENT, $agent) === false;
    return !$notAgent;
}

function fixPaddingFree(&$swmenufree) {

    $padding1 = explode("px", $swmenufree['main_padding']);
    $padding2 = explode("px", $swmenufree['sub_padding']);
    for ($i = 0; $i < 4; $i++) {
        $padding1[$i] = trim(@$padding1[$i]);
        $padding2[$i] = trim(@$padding2[$i]);
    }
    if ($swmenufree['main_width'] != 0) {
        $swmenufree['main_width'] = ($swmenufree['main_width'] - ($padding1[1] + $padding1[3]));
    }
    if ($swmenufree['main_height'] != 0) {
        $swmenufree['main_height'] = ($swmenufree['main_height'] - ($padding1[0] + $padding1[2]));
    }
    if ($swmenufree['sub_width'] != 0) {
        $swmenufree['sub_width'] = ($swmenufree['sub_width'] - ($padding2[1] + $padding2[3]));
    }
    if (@$swmenufree['sub_width'] != 0) {
        $swmenufree['sub_height'] = ($swmenufree['sub_height'] - ($padding2[0] + $padding2[2]));
    }
    return($swmenufree);
}

function sw_getactiveFree($ordered){
	$current_itemid = trim( JRequest::getVar( 'Itemid', 0 ) );
	$current_id = trim( JRequest::getVar( 'id', 0 ) );
	$current_task = trim( JRequest::getVar( 'task', 0 ) );
	$menu_items  =& JSite::getMenu();
 $cur_option = trim(JRequest::getVar('option', 0));
      
     if (($cur_option == "com_virtuemart")) {
        
            $prod_id = trim(JRequest::getVar('virtuemart_product_id', 0));
            $cat_id  = trim(JRequest::getVar('virtuemart_category_id', 0));
            if(!$prod_id){$prod_id=trim(JRequest::getVar('product_id', 0));}
            if(!$cat_id){$cat_id=trim(JRequest::getVar('category_id', 0));}
            //echo $prod_id;
            if ($prod_id) {
                $current_itemid = $prod_id + 100000;
            } else {
                $current_itemid = $cat_id +10000;
            }
        
    }
	if (!$current_itemid && $current_id){

		if(preg_match( "/category/i" , $current_task)){
			$current_itemid = $current_id+1000;
		}elseif(preg_match( "/section/i" , $current_task)){
			$current_itemid = $current_id;
		}
		elseif(preg_match( "/view/i" , $current_task)){
			$current_itemid = $current_id+10000;
		}
	}
	$indent=0;
	$parent_value = $current_itemid;
	$parent=1;
	$id=0;
	while ($parent){
		for($i=0;$i<count($ordered);$i++) {
			$row=$ordered[$i];
			$params     =& $menu_items->getParams($row['ID']);
			$alias =  $params->get( 'aliasoptions',$row['ID'] );
			if ($row['ID']==$parent_value || $alias==$parent_value){
				$parent_value = $row['PARENT'];
				$indent = $row['indent'];
				$id=$row['ID'];
			}
		}
		if (!$indent){
			$parent=0;
		}
	}
       // echo $id;
       // $id=435;
	return ($id);
}
class swBrowserFree {

    var $Name = "Unknown";
    var $Version = "Unknown";
    var $Platform = "Unknown";
    var $UserAgent = "Not reported";
    var $AOL = false;

    function swBrowserFree() {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        // initialize properties
        $bd['platform'] = "Unknown";
        $bd['swBrowserFree'] = "Unknown";
        $bd['version'] = "Unknown";
        $this->UserAgent = $agent;

        // find operating system
        if (preg_match("/win/i", $agent))
            $bd['platform'] = "Windows";
        elseif (preg_match("/mac/i", $agent))
            $bd['platform'] = "MacIntosh";
        elseif (preg_match("/linux/i", $agent))
            $bd['platform'] = "Linux";
        elseif (preg_match("/OS2/i", $agent))
            $bd['platform'] = "OS/2";
        elseif (preg_match("/BeOS/i", $agent))
            $bd['platform'] = "BeOS";

        // test for Opera        
        if (preg_match("/opera/i", $agent)) {
            $val = stristr($agent, "opera");
            if (preg_match("//i", $val)) {
                $val = explode("/", $val);
                $bd['swBrowserFree'] = $val[0];
                $val = explode(" ", $val[1]);
                $bd['version'] = $val[0];
            } else {
                $val = explode(" ", stristr($val, "opera"));
                $bd['swBrowserFree'] = $val[0];
                $bd['version'] = $val[1];
            }

            // test for WebTV
        } elseif (preg_match("/webtv/i", $agent)) {
            $val = explode("/", stristr($agent, "webtv"));
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for MS Internet Explorer version 1
        } elseif (preg_match("/microsoft internet explorer/i", $agent)) {
            $bd['swBrowserFree'] = "MSIE";
            $bd['version'] = "1.0";
            $var = stristr($agent, "/");
            if (preg("/308|425|426|474|0b1/", $var)) {
                $bd['version'] = "1.5";
            }

            // test for NetPositive
        } elseif (preg_match("/NetPositive/i", $agent)) {
            $val = explode("/", stristr($agent, "NetPositive"));
            $bd['platform'] = "BeOS";
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for MS Internet Explorer
        } elseif (preg_match("/msie/i", $agent) && !preg_match("/opera/i", $agent)) {
            $val = explode(" ", stristr($agent, "msie"));
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for MS Pocket Internet Explorer
        } elseif (preg_match("/mspie/i", $agent) || preg_match('/pocket/i', $agent)) {
            $val = explode(" ", stristr($agent, "mspie"));
            $bd['swBrowserFree'] = "MSPIE";
            $bd['platform'] = "WindowsCE";
            if (preg_match("/mspie/i", $agent))
                $bd['version'] = $val[1];
            else {
                $val = explode("/", $agent);
                $bd['version'] = $val[1];
            }

            // test for Galeon
        } elseif (preg_match("/galeon/i", $agent)) {
            $val = explode(" ", stristr($agent, "galeon"));
            $val = explode("/", $val[0]);
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for Konqueror
        } elseif (preg_match("/Konqueror/i", $agent)) {
            $val = explode(" ", stristr($agent, "Konqueror"));
            $val = explode("/", $val[0]);
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for iCab
        } elseif (preg_match("/icab/i", $agent)) {
            $val = explode(" ", stristr($agent, "icab"));
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for OmniWeb
        } elseif (preg_match("/omniweb/i", $agent)) {
            $val = explode("/", stristr($agent, "omniweb"));
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];

            // test for Phoenix
        } elseif (preg_match("/Phoenix/i", $agent)) {
            $bd['swBrowserFree'] = "Phoenix";
            $val = explode("/", stristr($agent, "Phoenix/"));
            $bd['version'] = $val[1];

            // test for Firebird
        } elseif (preg_match("/firebird/i", $agent)) {
            $bd['swBrowserFree'] = "Firebird";
            $val = stristr($agent, "Firebird");
            $val = explode("/", $val);
            $bd['version'] = $val[1];

            // test for Firefox
        } elseif (preg_match("/Firefox/i", $agent)) {
            $bd['swBrowserFree'] = "Firefox";
            $val = stristr($agent, "Firefox");
            $val = explode("/", $val);
            $bd['version'] = $val[1];

            // test for Mozilla Alpha/Beta Versions
        } elseif (preg_match("/mozilla/i", $agent) &&
                preg_match("/rv:[0-9].[0-9][a-b]/i", $agent) && !preg_match("/netscape/i", $agent)) {
            $bd['swBrowserFree'] = "Mozilla";
            $val = explode(" ", stristr($agent, "rv:"));
            preg_match("/rv:[0-9].[0-9][a-b]/i", $agent, $val);
            $bd['version'] = str_replace("rv:", "", $val[0]);

            // test for Mozilla Stable Versions
        } elseif (preg_match("/mozilla/i", $agent) &&
                preg_match("/rv:[0-9]\.[0-9]/i", $agent) && !preg_match("/netscape/i", $agent)) {
            $bd['swBrowserFree'] = "Mozilla";
            $val = explode(" ", stristr($agent, "rv:"));
            preg_match("/rv:[0-9]\.[0-9]\.[0-9]/i", $agent, $val);
            $bd['version'] = str_replace("rv:", "", $val[0]);

            // test for Lynx & Amaya
        } elseif (preg_match("/libwww/i", $agent)) {
            if (preg_match("/amaya/i", $agent)) {
                $val = explode("/", stristr($agent, "amaya"));
                $bd['swBrowserFree'] = "Amaya";
                $val = explode(" ", $val[1]);
                $bd['version'] = $val[0];
            } else {
                $val = explode("/", $agent);
                $bd['swBrowserFree'] = "Lynx";
                $bd['version'] = $val[1];
            }

            // test for Safari
        } elseif (preg_match("/safari/i", $agent)) {
            $bd['swBrowserFree'] = "Safari";
            $bd['version'] = "";

            // remaining two tests are for Netscape
        } elseif (preg_match("/netscape/i", $agent)) {
            $val = explode(" ", stristr($agent, "netscape"));
            $val = explode("/", $val[0]);
            $bd['swBrowserFree'] = $val[0];
            $bd['version'] = $val[1];
        } elseif (preg_match("/mozilla/i", $agent) && !preg_match("/rv:[0-9]\.[0-9]\.[0-9]/i", $agent)) {
            $val = explode(" ", stristr($agent, "mozilla"));
            $val = explode("/", $val[0]);
            $bd['swBrowserFree'] = "Netscape";
            $bd['version'] = $val[1];
        }

        // clean up extraneous garbage that may be in the name
        $bd['swBrowserFree'] = preg_replace("[^a-z,A-Z]", "", $bd['swBrowserFree']);
        // clean up extraneous garbage that may be in the version        
        $bd['version'] = preg_replace("[^0-9,.,a-z,A-Z]", "", $bd['version']);

        // check for AOL
        if (preg_match("/AOL/i", $agent)) {
            $var = stristr($agent, "AOL");
            $var = explode(" ", $var);
            $bd['aol'] = preg_replace("[^0-9,.,a-z,A-Z]", "", $var[1]);
        }

        // finally assign our properties
        $this->Name = $bd['swBrowserFree'];
        $this->Version = $bd['version'];
        $this->Platform = $bd['platform'];
        // $this->AOL = $bd['aol'];
        //echo $this->Name;
    }

}


function sw_stringToObject2($data)
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
