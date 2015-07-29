<?php
/**
 * swmenufree v5.0
 * http://swonline.biz
 * Copyright 2006 Sean White
 * */
//error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE); 
defined('_JEXEC') or die('Restricted access');

$database = &JFactory::getDBO();
$absolute_path=JPATH_ROOT;
require_once($absolute_path ."/modules/mod_swmenufree/styles.php");
require_once($absolute_path ."/modules/mod_swmenufree/functions.php");

$swmenufree=array();

reset($_POST);
while (list ($key, $val) = each($_POST)) {
    if ($val)
        $$key = $val;
    $swmenufree[$key] = $val;
}

//echo $swmenufree['preview'];
if ($swmenufree['preview'] == "CSS") {
   $sql="SELECT * FROM #__swmenufree_styles where id=1";
	$database->setQuery($sql);
	$swmenufree_obj=$database->loadObject();
        $temp_array = sw_stringToObject($swmenufree_obj->params);
   
while (list ($key, $val) = each($temp_array)) {
   
    $swmenufree[$key] = $val;
}
  $swmenufree['preview']="CSS"; 
} 

if(($swmenufree['menutype']=="virtuemart2"||$swmenufree['menutype']=="virtueprod2")&&$swmenufree['parentid']==1){$swmenufree['parentid']=0;}
    if(($swmenufree['menutype']=="virtuemart"||$swmenufree['menutype']=="virtueprod")&&$swmenufree['parentid']==1){$swmenufree['parentid']=0;}

// if(($swmenufree['menutype']=="virtuemart2"||$swmenufree['menutype']=="virtueprod2")&&$swmenufree['parentid']!=0){$swmenufree['parentid']=$swmenufree['parentid']+10000;}
//    if(($swmenufree['menutype']=="virtuemart"||$swmenufree['menutype']=="virtueprod")&&$swmenufree['parentid']!=0){$swmenufree['parentid']=$swmenufree['parentid']+10000;}

if ($swmenufree['menutype'] && $swmenufree['menustyle']) {

    $content = "\n<!--swmenufree6.2 " . $swmenufree['menustyle'] . " by http://www.swmenupro.com-->\n";

    if ($swmenufree['menutype'] && $swmenufree['menustyle']) {

        $final_menu = array();
        $swmenufree_array = swGetMenuLinksFree($swmenufree['menutype'], $swmenufree['id'], $swmenufree['hybrid'], 1);
        if ($swmenufree['parentid']==0){$swmenufree['parentid']=1;};
        if(($swmenufree['menutype']=="virtuemart2"||$swmenufree['menutype']=="virtueprod2")&&$swmenufree['parentid']==1){$swmenufree['parentid']=0;}
    if(($swmenufree['menutype']=="virtuemart"||$swmenufree['menutype']=="virtueprod")&&$swmenufree['parentid']==1){$swmenufree['parentid']=0;}
       // print_r($swmenufree_array);
        $ordered = chainFree('ID', 'PARENT', 'ORDER', $swmenufree_array, $swmenufree['parentid'], $swmenufree['levels']);

      

        //  $out = JRequest::getVar( 'php_out', '' );
        for ($i = 0; $i < count($ordered); $i++) {
            $swmenu = $ordered[$i];
            $swmenu['URL'] = "javascript:void(0)";

            $final_menu[] = array("TITLE" => $swmenu['TITLE'], "URL" => 'javascript:void(0);', "ID" => $swmenu['ID'], "PARENT" => $swmenu['PARENT'], "ORDER" => $swmenu['ORDER'], "TARGET" => 0, "ACCESS" => $swmenu['ACCESS']);
        }


        if (count($final_menu)) {
            
                $swmenufree['position'] = "center";
            
            echo previewHead($swmenufree['preview_background']);

            echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/jquery-1.6.min.js\"></script>\n";
            echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/jquery.corner.js\"></script>\n";
            
             echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/curvycorners.src.js\"></script>\n";
           
            if ($swmenufree['top_ttf']) {
                echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/cufon-yui.js\"></script>\n";
                echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/fonts/" . $swmenufree['top_ttf'] . "\"></script>\n";
            }

            if ($swmenufree['sub_ttf']) {
                if (!$swmenufree['top_ttf']) {
                    echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/cufon-yui.js\"></script>\n";
                }

                echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/fonts/" . $swmenufree['sub_ttf'] . "\"></script>\n";
            }

                $ordered = chainFree('ID', 'PARENT', 'ORDER', $final_menu, $swmenufree['parentid'], $swmenufree['levels']);
          
            if ($swmenufree['menustyle'] == "mygosumenu") {
                $content.= doGosuMenuPreview($ordered, $swmenufree);
            }
            if ($swmenufree['menustyle'] == "superfishmenu") {
                $content.= dosuperFishMenuPreview($ordered, $swmenufree);
            }
            if ($swmenufree['menustyle'] == "transmenu") {
                $content.= doTransMenuPreview($ordered, $swmenufree);
            }
        }
    }
    $content.="\n<!--End swmenufree menu module-->\n";
}



function doSuperfishMenuPreview($ordered, $swmenufree) {
    //echo previewHead();
    //echo '<script type="text/javascript" src="../modules/mod_swmenufree/jquery.dropshadow.js"></script>';
    //	echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/jquery-1.2.6.pack.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/hoverIntent.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/superfish.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"../modules/mod_swmenufree/supersubs.js\"></script>\n";


    if ($swmenufree['preview'] == "CSS") {
        $css = JRequest::getVar("filecontent", '');
        echo "\n<style type='text/css'>\n";
        echo "<!--\n";
        echo str_replace("\\", "", $css);
        echo "\n-->\n";
        echo "</style>\n";
    } else {

        if ((substr(swmenuGetBrowserFree(), 0, 5) != "MSIE6") && $swmenufree['padding_hack']) {
            $swmenufree = fixPaddingFree($swmenufree);
        }
        echo "\n<style type='text/css'>\n";
        echo "<!--\n";
        echo superfishMenuStyleFree($swmenufree);
        echo "\n-->\n";
        echo "</style>\n";
    }
  //  echo "</head><body>";
    if (($swmenufree['main_width'] == 0) && ($swmenufree['orientation'] == "vertical")) {
        echo "<div align=\"center\" style=\"margin:auto;width:200px;\" >";
    } else {
        echo "<div align=\"center\" style=\"margin:auto;\" >";
    }
    echo SuperfishMenuFree($ordered, $swmenufree);
    echo "</div>";
    //echo changeBgColor();
  //  echo "</body></html>";
}

function doGosuMenuPreview($ordered, $swmenufree) {
  
    echo '<script type="text/javascript" src="../modules/mod_swmenufree/DropDownMenuX_Packed.js"></script>';

      if ($swmenufree['preview'] == "CSS") {
        $css = JRequest::getVar("filecontent", '');
        echo "\n<style type='text/css'>\n";
        echo "<!--\n";
        echo str_replace("\\", "", $css);
        echo "\n-->\n";
        echo "</style>\n";
    } else {

        if ((substr(swmenuGetBrowserFree(), 0, 5) != "MSIE6") && $swmenufree['padding_hack']) {
            $swmenufree = fixPaddingFree($swmenufree);
        }
        echo "\n<style type='text/css'>\n";
        echo "<!--\n";
        echo gosuMenuStyleFree($swmenufree);
        echo "\n-->\n";
        echo "</style>\n";
    }
   // echo "</head><body>";
    echo GosuMenuFree($ordered, $swmenufree);
    echo changeBgColor();
   // echo "</body></html>";
}

function doTransMenuPreview($ordered, $swmenufree) {

    echo '<script type="text/javascript" src="../modules/mod_swmenufree/transmenu_Packed.js"></script>';
     if ($swmenufree['preview'] == "CSS") {
        $css = JRequest::getVar("filecontent", '');
        echo "\n<style type='text/css'>\n";
        echo "<!--\n";
        echo str_replace('\\', '', $css);
        echo "\n-->\n";
        echo "</style>\n";
    }  else {
        if ((substr(swmenuGetBrowserFree(), 0, 5) != "MSIE6") && $swmenufree['padding_hack']) {
            $swmenufree = fixPaddingFree($swmenufree);
        }
        echo "\n<style type='text/css'>\n";
        echo "<!--\n";
        echo transMenuStyleFree($swmenufree);
        echo "\n-->\n";
        echo "</style>\n";
    }
    echo "<center>";
    echo transMenuFree($ordered, $swmenufree);
echo changeBgColor();
    echo "</center>";
}

function previewHead($preview_background) {
   
    ?>
    <script type="text/javascript">
        <!--
        function changeBG(){
            document.body.style.backgroundColor = '<?php echo $preview_background; ?>';
            //alert(document.getElementById('back_color').value);
        }

        -->
    </script>
    <?php
}

function changeBgColor() {
    ?>


    <script type="text/javascript">
        <!--
        changeBG();
        //-->
    </script>

    <?php
}
?>
 


