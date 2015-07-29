<?php

/**
 * swmenufree v6.0 for Joomla1.5
 * http://swmenupro.com
 * Copyright 2007 Sean White
 * */
//error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
defined('_JEXEC') or die('Restricted access');
$absolute_path=JPATH_ROOT;
$live_site = JURI::base();
if(substr($live_site,(strlen($live_site)-1),1)=="/"){$live_site=substr($live_site,0,(strlen($live_site)-1));}
$database = &JFactory::getDBO();
require_once($absolute_path."/modules/mod_swmenufree/styles.php");
require_once($absolute_path."/modules/mod_swmenufree/functions.php");

$do_menu=1;
$swmenufree=array();

$sql="SELECT * FROM #__swmenufree_styles where id=1";
	$database->setQuery($sql);
	$swmenufree_obj=$database->loadObject();
        $temp_array = sw_stringToObject2($swmenufree_obj->params);
   
while (list ($key, $val) = each($temp_array)) {
   
    $swmenufree[$key] = $val;
}


if ($do_menu) {
      $doc =& JFactory::getDocument();
      $doc->addCustomTag( "\n<!-- start - swMenuFree 8.3_J2.5-J3.0 javascript and CSS links -->\n" );

    if ($swmenufree['disable_jquery']) {
        define('_swjquery_defined', 1);
    }
    if ($swmenufree['flash_hack']) {
        $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/fix_wmode2transparent_swf.js\"></script>\n";
        $doc =& JFactory::getDocument();
        $doc->addCustomTag( $headtag );
    }
  
$content = "\n<!--swMenuFree8.3_J2.5-3.0 " . $swmenufree['menustyle'] . " by http://www.swmenupro.com-->\n";

   
    
         if (!defined('_swjquery_defined')) {
            if (($swmenufree['extra'] != "" && $swmenufree['extra'] != "none" && $swmenufree['extra'] != "1" && $swmenufree['extra'] != "0") || $swmenufree['overlay_hack'] || ($swmenufree['t_corner_style'] !== 'none') || ($swmenufree['s_corner_style'] !== 'none') || ($swmenufree['c_corner_style'] !== 'none')||$swmenufree['menustyle']=="superfishmenu") {
               $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/jquery-1.6.min.js\"></script>\n";
               define('_swjquery_defined', 1);
               $doc =& JFactory::getDocument();
               $doc->addCustomTag( $headtag );
            }
         }
         if (($swmenufree['t_corner_style'] == 'curvycorner') || ($swmenufree['s_corner_style'] == 'curvycorner') || ($swmenufree['c_corner_style'] == 'curvycorner') && !(defined('_swcurvycorners_defined'))) {
            // $headtag.="<script type=\"text/javascript\"> var curvyCornersNoAutoScan = true; </script>\n";
             $headtag= "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/curvycorners.src.js\"></script>\n";
            define('_swcurvycorners_defined', 1);
            $doc =& JFactory::getDocument();
            $doc->addCustomTag( $headtag );
        }
        if (($swmenufree['t_corner_style'] != 'none') || ($swmenufree['s_corner_style'] != 'none') || ($swmenufree['c_corner_style'] != 'none') && !defined('_swcorners_defined')) {
            $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/jquery.corner.js\"></script>\n";
            define('_swcorners_defined', 1);
            $doc =& JFactory::getDocument();
            $doc->addCustomTag( $headtag );
        }
    
    if ($swmenufree['top_ttf']) {
       
        if (!defined('_swcufon_defined')) {
            $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/cufon-yui.js\"></script>\n";
            define('_swcufon_defined', 1);
             $doc =& JFactory::getDocument();
             $doc->addCustomTag( $headtag );
        }
        $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/fonts/" . $swmenufree['top_ttf'] . "\"></script>\n";
        $doc =& JFactory::getDocument();
        $doc->addCustomTag( $headtag );
    }

    if ($swmenufree['sub_ttf']) {
        if (!defined('_swcufon_defined')) {
            $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/cufon-yui.js\"></script>\n";
            define('_swcufon_defined', 1);
            $doc =& JFactory::getDocument();
            $doc->addCustomTag( $headtag );
        }
        if ($swmenufree['sub_ttf'] != $swmenufree['top_ttf']) {
            $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/fonts/" . $swmenufree['sub_ttf'] . "\"></script>\n";
            $doc =& JFactory::getDocument();
            $doc->addCustomTag( $headtag );
        }
    }

//echo $swmenufree['id'];
    if ($swmenufree['menutype'] && $swmenufree['id'] && $swmenufree['menustyle']) {
        if ($swmenufree['cssload'] == 1) {
            $headtag = "<link type='text/css' href='" . $live_site . "/modules/mod_swmenufree/styles/menu.css' rel='stylesheet' />\n";
            $doc =& JFactory::getDocument();
            $doc->addCustomTag( $headtag );
        }
 if ($swmenufree['parentid']==0){$swmenufree['parentid']=1;};
 if(($swmenufree['menutype']=="virtuemart2"||$swmenufree['menutype']=="virtueprod2")&&$swmenufree['parentid']==1){$swmenufree['parentid']=0;}
if(($swmenufree['menutype']=="virtuemart"||$swmenufree['menutype']=="virtueprod")&&$swmenufree['parentid']==1){$swmenufree['parentid']=0;}

//if(($swmenufree['menutype']=="virtuemart2"||$swmenufree['menutype']=="virtueprod2")&&$swmenufree['parentid']!=0){$swmenufree['parentid']=$swmenufree['parentid']+10000;}
//if(($swmenufree['menutype']=="virtuemart"||$swmenufree['menutype']=="virtueprod")&&$swmenufree['parentid']!=0){$swmenufree['parentid']=$swmenufree['parentid']+10000;}
 
        $ordered = swGetMenuFree($swmenufree['menutype'], $swmenufree['id'], $swmenufree['hybrid'], $swmenufree['tables'], $swmenufree['parentid'], $swmenufree['levels']);
       // echo count($ordered);
        if (count($ordered)) {

            if ($swmenufree['active_menu']) {
                $swmenufree['active_menu'] = sw_getactiveFree($ordered);
            }
            $ordered = chainFree('ID', 'PARENT', 'ORDER', $ordered, $swmenufree['parentid'], $swmenufree['levels']);
        }

        if (count($ordered) && ($swmenufree['orientation'] == 'horizontal/left')) {
            $topcount = count(chainFree('ID', 'PARENT', 'ORDER', $ordered, $swmenufree['parentid'], 1));
            for ($i = 0; $i < count($ordered); $i++) {
                $swmenu = $ordered[$i];
                if ($swmenu['indent'] == 0) {
                    $ordered[$i]['ORDER'] = $topcount;
                    $topcount--;
                }
            }
            $ordered = chainFree('ID', 'PARENT', 'ORDER', $ordered, $swmenufree['parentid'], $swmenufree['levels']);
        }
        
        if (count($ordered) && ($swmenufree['tablet_hack'])) {
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){

            for ($i = 0; $i < count($ordered); $i++) {
                 if ((($i + 1) != count($ordered)) && (@$ordered[$i + 1]['indent'] > $ordered[$i]['indent'])) {
                $ordered[$i]['URL']="javascript:void(0);";
                }
            }
          }
        }
     
        if (count($ordered)) {
            if ($swmenufree['menustyle'] == "mygosumenu") {
                $content.= doGosuMenuFree($ordered, $swmenufree);
            }
            if ($swmenufree['menustyle'] == "transmenu") {
                $content.= doTransMenuFree($ordered, $swmenufree);
            }

            if ($swmenufree['menustyle'] == "superfishmenu") {
                $content.= doSuperfishMenuFree($ordered, $swmenufree);
            }
        }
    }
      $doc =& JFactory::getDocument();
      $doc->addCustomTag( "\n<!-- end - swMenuFree javascript and CSS links -->\n" );
   // $GLOBALS['mainframe']->addCustomHeadTag("\n<!-- end - swMenuFree javascript and CSS links -->\n");
      $content.="\n<!--End swMenuFree menu module-->\n";

    return $content;
}

function doGosuMenuFree($ordered, $swmenufree) {
    $live_site = JURI::base();
    if (substr($live_site, (strlen($live_site) - 1), 1) == "/") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 1));
    }
    
    $str = "";
    $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/DropDownMenuX.js\"></script>\n";
    $doc =& JFactory::getDocument();
    $doc->addCustomTag( $headtag );
    if (!$swmenufree['cssload']) {
        if ((substr(swmenuGetBrowserFree(), 0, 5) != "MSIE6") && $swmenufree['padding_hack']) {
            $swmenufree = fixPaddingFree($swmenufree);
        }
        $str.= "\n<style type='text/css'>\n";
        $str.= "<!--\n";
        $str.= gosuMenuStyleFree($swmenufree);
        $str.= "\n-->\n";
        $str.= "</style>\n";
        $doc =& JFactory::getDocument();
        $doc->addCustomTag( $str );
    }
    $str = GosuMenuFree($ordered, $swmenufree);
    return $str;
}

function doTransMenuFree($ordered, $swmenufree) {
    $live_site = JURI::base();
    if (substr($live_site, (strlen($live_site) - 1), 1) == "/") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 1));
    }
    $str = "";
    $headtag = "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/transmenu_Packed.js\"></script>\n";
    $doc =& JFactory::getDocument();
    $doc->addCustomTag( $headtag );
    if (!$swmenufree['cssload']) {
        if ((substr(swmenuGetBrowserFree(), 0, 5) != "MSIE6") && $swmenufree['padding_hack']) {
            $swmenufree = fixPaddingFree($swmenufree);
        }
        $str.= "\n<style type='text/css'>\n";
        $str.= "<!--\n";
        $str.= transMenuStyleFree($swmenufree);
        $str.= "\n-->\n";
        $str.= "</style>\n";
        $doc =& JFactory::getDocument();
        $doc->addCustomTag( $str );
    }
    $str = transMenuFree($ordered, $swmenufree);
    return $str;
}

function doSuperfishMenuFree($ordered, $swmenufree) {
    $live_site = JURI::base();
    if (substr($live_site, (strlen($live_site) - 1), 1) == "/") {
        $live_site = substr($live_site, 0, (strlen($live_site) - 1));
    }
    $str = "";
    //$show_shadow=1;
    if (!$swmenufree['cssload']) {
        if ((substr(swmenuGetBrowserFree(), 0, 5) != "MSIE6") && $swmenufree['padding_hack']) {
            $swmenufree = fixPaddingFree($swmenufree);
        }
        $str.= "\n<style type='text/css'>\n";
        $str.= "<!--\n";
        $str.= superfishMenuStyleFree($swmenufree);
        $str.= "\n-->\n";
        $str.= "</style>\n";
        $doc =& JFactory::getDocument();
        $doc->addCustomTag( $str );
    }

    $headtag = "";

    if (!defined('_swjquery_defined')) {
        $headtag.= "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/jquery-1.6.min.js\"></script>\n";
        define('_swjquery_defined', 1);
    }
    //$headtag.= "<script type=\"text/javascript\" src=\"".$live_site."/modules/mod_swmenufree/jquery-1.2.6.pack.js\"></script>\n";
    //$headtag.= "<script type=\"text/javascript\" src=\"".$live_site."/modules/mod_swmenufree/jquery.topzindex.min.js\"></script>\n";
    $headtag.= "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/hoverIntent.js\"></script>\n";
    $headtag.= "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/superfish.js\"></script>\n";
    $headtag.= "<script type=\"text/javascript\" src=\"" . $live_site . "/modules/mod_swmenufree/supersubs.js\"></script>\n";

   
     $doc =& JFactory::getDocument();
     $doc->addCustomTag( $headtag );

    $str = SuperfishMenuFree($ordered, $swmenufree);
    return $str;
}
?>



