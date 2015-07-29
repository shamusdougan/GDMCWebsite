<?php
/**
 * swmenufree v4.5
 * http://swonline.biz
 * Copyright 2006 Sean White
 * */
// ensure this file is being included by a parent file
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.controller');

class HTML_swmenufree {

    function editCSS(&$content, $title) {
     
        $absolute_path = JPATH_ROOT;
        $live_site = JURI::root();
        $css_path = $absolute_path . '/modules/mod_swmenufree/styles/menu.css';
        // echo $css_path;
        ?>
       
        <script type="text/javascript" src="<?php echo $live_site; ?>/modules/mod_swmenufree/jquery.corner.js"></script>


        <script type="text/javascript" >
            <!--
            function doPreviewWindow() {
                document.adminForm.tmpl.value="component";
                document.adminForm.target="win1";
                document.adminForm.action="index.php";
                document.adminForm.task.value="preview";
                window.open('', 'win1', 'status=no,toolbar=no,scrollbars=auto,titlebar=no,menubar=no,resizable=yes,width=600,height=500,directories=no,location=no');
                setTimeout('document.adminForm.submit()',200) ;
                setTimeout('document.adminForm.target="_self"',300);
                setTimeout('document.adminForm.action="index.php"',300);
                setTimeout('document.adminForm.tmpl.value="index"',300);
                setTimeout('document.adminForm.task.value="manualsave"',300);


            }

            -->
        </script>
        <link rel="stylesheet" type="text/css" href="components/com_swmenufree/css/swmenufree.css" />
        <div class="swmenu_container" align="center">

            <form action="index.php" method="post" name="adminForm">
                <table  class="sw_inner_container_header"  border="0" width="750">


                    <tr>
                         <td width="250"><img src="components/com_swmenufree/images/swmenufree_logo.png" height="39" width="247" align="left" border="0"/></td>
                        <td valign="bottom"><span class="swmenu_sectionname"><?php echo _SW_MANUAL_CSS_EDITOR; ?></span> </td>
                       <td valign="top" align="right">
                        <a class="sw_upgrade_button" href="index.php?option=com_swmenufree&task=upgrade" ><img src="components/com_swmenufree/images/gtk_update.png" align="absmiddle" ><?php echo _SW_UPGRADE_LINK; ?></a>
        
                            <a class="sw_manual_button" href="index.php?option=com_swmenufree" ><img src="components/com_swmenufree/images/paper_content_pencil.png" align="absmiddle" ><?php echo _SW_MANAGER_LINK; ?></a>
        

                    </td>
                    </tr>
                </table>
                <table class="sw_inner_container" cellpadding="0" cellspacing="0" border="0" width="750">
                    <tr>
                        <td colspan="3" align="left"><?php echo "<b>" . $css_path . " :</b>"; ?><b><?php echo is_writable($css_path) ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></b></td>
                    </tr>
                </table>
                <table class="swmenu_tabheading" style="margin:auto;" align="center" cellpadding="0" cellspacing="4" border="0" width="750">
                    <tr>
                        <td align="left" width="80%"><?php echo _SW_MODULE_NAME; ?>: &nbsp; <?php echo $title; ?> </td>
                        <td align="right"><a href="javascript:void(0);" class="swmenu_button_save"  onClick="document.adminForm.submit();" onmouseover="return escape('<?php echo _SW_SAVE_TIP; ?>')" ><?php echo _SW_SAVE_BUTTON; ?></a></td>
                        <td><a href="javascript:void(0);" class="swmenu_button_preview"  onClick="doPreviewWindow();" onmouseover="return escape('<?php echo _SW_PREVIEW_TIP; ?>')" ><?php echo _SW_PREVIEW_BUTTON; ?></a></td>
                        <td><a href="index.php?option=com_swmenufree&amp;task=showmodules"  class="swmenu_button_cancel" onmouseover="return escape('<?php echo _SW_CANCEL_TIP; ?>')"><?php echo _SW_CANCEL_BUTTON; ?></a></td>
                    </tr>
                </table>
                <table class="sw_inner_container" width="750">
                    <tr>
                        <td><textarea style="width:100%;height:500px" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $content; ?></textarea></td>
                    </tr>
                </table>
                <input type="hidden" name="tmpl" id="tmpl" value="0" />
                <input type="hidden" name="preview" id="preview" value="CSS" />
                <input type="hidden" name="option" value="com_swmenufree" />
                <input type="hidden" name="task" value="manualsave" />
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="returntask" value="editCSS" />
            </form>
        </div>
        <script language="JavaScript" type="text/javascript" src="components/com_swmenufree/js/wz_tooltip.js"></script>
        <script type="text/javascript">
            <!--
jQuery('.sw_manual_button').corner();
             jQuery('.sw_upgrade_button').corner();
 jQuery('.sw_inner_container_header').corner('tl tr');
            jQuery('#toolbar-box').remove();

            jQuery.noConflict();
            -->
        </script>
        <?php
    }

    function footer() {
        ?>
        <br clear="all" />
        <table cellpadding="4" cellspacing="0" border="0" align="center" width="100%">
            <tr>
                <td width="100%" align="center">
                    <a href="http://www.swmenupro.com" target="_blank">
                        <img src="components/com_swmenufree/images/swmenufree_footer.png" alt="swmenufree.com" border="0"/>
                    </a><br/> swMenuFree &copy;2004 - 2012 by Sean White<br />
                    <a href="http://www.swmenupro.com" target="_blank">http://www.swmenupro.com</a>
                </td>
            </tr>
        </table>

        <?php
    }

    function upgradeForm($row, $lists) {
       
        $absolute_path = JPATH_ROOT;
     
        if (file_exists($absolute_path . '/administrator/components/com_swmenufree/admin.swmenufree.php')) {
    unlink($absolute_path . '/administrator/components/com_swmenufree/admin.swmenufree.php');
     
    
}
        ?>
        
        
        <script type="text/javascript" src="../modules/mod_swmenufree/jquery-1.6.min.js"></script>
        <script type="text/javascript" src="../modules/mod_swmenufree/jquery.corner.js"></script>
        <script type="text/javascript" src="components/com_swmenufree/js/swmenufree2.js"></script>
        <script language="javascript" type="text/javascript">
            function uploadUpgrade() {
                var form = document.filename;
                // do field validation
                if (form.userfile.value == ""){
                    alert( "Not a valid updated swMenuFree file" );
                } else {
                    form.task.value="uploadfile";
                    form.submit();
                }
            }
            
            
            function uploadCufon() {
                var form = document.filename;
                // do field validation
                if (form.cufonfile.value == ""){
                    alert( "Not a valid updated swMenuFree file" );
                } else {
                    form.task.value="upload_ttf";
                    form.submit();
                }
            }


            function submitform() {
                var form = document.filename;
                // do field validation
                if (form.userfile.value == ""){
                    alert( "<?php echo _SW_UPLOAD_FILE_NOTICE; ?>" );
                } else {
                    form.submit();
                }
            }

            function changeLanguage() {
                var form = document.filename;
                form.task.value="changelanguage";
                form.submit();

            }
        </script>
        <div class="swmenu_container" align="center">
            <link rel="stylesheet" href="components/com_swmenufree/css/swmenufree.css" type="text/css" />
            <form enctype="multipart/form-data" action="index.php" method="post" name="filename">
                <table  class="sw_inner_container_header" cellpadding="4" cellspacing="4" border="0" width="750">
                    <tr>
                       <td width="250"><img src="components/com_swmenufree/images/swmenufree_logo.png" height="39" width="247" align="left" border="0"/></td>
                        <td valign="bottom"><span class="swmenu_sectionname"><?php echo _SW_UPGRADE_FACILITY; ?></span> </td>
                        <td valign="top" align="right">
        
                            <a class="sw_manual_button" href="index.php?option=com_swmenufree" ><img src="components/com_swmenufree/images/paper_content_pencil.png" align="absmiddle" ><?php echo _SW_MANAGER_LINK; ?></a>
        </td>
                    </tr>
                </table>
                 <table  class="sw_inner_container" cellpadding="0" cellspacing="0" border="0" width="750"><tr><td>
                <div class="swmenu_tabheading" style="width:750px;text-align:center;" align="center">&nbsp;</div>
                         </td></tr></table>
                <table  class="sw_inner_container" cellpadding="0" cellspacing="0" border="0" width="750">
                    <tr><td width="50%" valign="top">

                            <table width="100%"><tr><td>
                                        <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                            <tr><td colspan="2" class="swmenu_tabheading" ><?php echo _SW_UPGRADE_VERSIONS; ?></td></tr>
                                            <tr class="swmenu_menubackgr">
                                                <td><?php echo _SW_COMPONENT_VERSION; ?>:</td><td> <?php echo $row->component_version; ?></td>
                                            </tr><tr>
                                                <td><?php echo _SW_MODULE_VERSION; ?>: </td><td><?php echo $row->module_version; ?></td>
                                            </tr>
                                        </table>

                                    </td></tr><tr><td>
                                        <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                            <tr><td  class="swmenu_tabheading" ><?php echo _SW_SELECTED_LANGUAGE_HEADING; ?></td></tr>
                                            <tr class="swmenu_menubackgr">
                                                <td><?php echo _SW_LANGUAGE_FILES; ?>:</td>
                                            </tr><tr>
                                                <td><?php echo $lists['langfiles']; ?>
                                                    <input class="button" type="button" onclick="changeLanguage();" value="<?php echo _SW_LANGUAGE_CHANGE_BUTTON; ?>" /></td>
                                                </td>
                                            </tr>
                                        </table>

                                    </td></tr>
                                <!--
                                <tr><td>
                                <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                <tr><td  class="swmenu_tabheading" ><?php echo _SW_UPLOAD_LANGUAGE_HEADING; ?></td></tr>
                                <tr class="swmenu_menubackgr">
                                        <td><input class="text_area" name="languagefile" type="file" size="50"/>
                                        <input class="button" type="button" onclick="uploadLanguage();" value="<?php echo _SW_LANGUAGE_UPLOAD_BUTTON; ?>" /></td>
                                  </tr>
                                </table>

                                </td></tr>
                                -->
                                <tr><td>
                                        <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                            <tr><td  class="swmenu_tabheading" ><?php echo _SW_UPLOAD_UPGRADE; ?></td></tr>
                                            <tr class="swmenu_menubackgr">
                                                <td><input class="text_area" name="userfile" type="file" size="50"/>
                                                    <input class="button" type="button" onclick="uploadUpgrade();" value="<?php echo _SW_UPLOAD_UPGRADE_BUTTON; ?>" /></td>
                                            </tr>
                                            
                                        </table>

                                    </td></tr>
                            
                            
                            
                           
                            
                            
                            
                            
                            
                            
                            </table>

                        </td><td width="50%" valign="top">

                            <table width="100%" align="right"><tr><td>
                                        <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                            <tr><td class="swmenu_tabheading" ><?php echo _SW_MESSAGES; ?></td></tr>
                                            <tr>
                                                <td><?php echo $row->message ? $row->message : _SW_OK; ?></td>
                                            </tr>
                                        </table>

                                    </td></tr><tr><td>
                                        <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                            <tr><td  class="swmenu_tabheading" ><?php echo _SW_FILE_PERMISSIONS; ?></td></tr>
                                            <tr>
                                                <td>
                                                    <table align="center">
                                                        <tr>
                                                            <td>/tmp</td><td><?php echo is_writable($absolute_path . "/tmp") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/modules</td><td><?php echo is_writable($absolute_path . "/modules") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/modules/mod_swmenufree</td><td><?php echo is_writable($absolute_path . "/modules/mod_swmenufree") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/modules/mod_swmenufree/images</td><td><?php echo is_writable($absolute_path . "/modules/mod_swmenufree/images") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/modules/mod_swmenufree/styles</td><td><?php echo is_writable($absolute_path . "/modules/mod_swmenufree/styles") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/modules/mod_swmenufree/fonts</td><td><?php echo is_writable($absolute_path . "/modules/mod_swmenufree/fonts") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/components/com_swmenufree</td><td><?php echo is_writable($absolute_path . "/components/com_swmenufree") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?></td>
                                                        </tr><tr>
                                                            <td>/administrator/components/com_swmenufree</td><td><?php echo is_writable($absolute_path . "/administrator/components/com_swmenufree") ? '<font color="green">' . _SW_WRITABLE . '</font>' : '<font color="red">' . _SW_UNWRITABLE . '</font>' ?>
                                                            </td></tr>
                                                        
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td></tr></table>
                        </td></tr></table>
                <br clear="all" />
                <table class="sw_inner_container" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center"><img alt="" src="components/com_swmenufree/images/started_top.png" width="750" height="47" border="0" hspace="0" vspace="0" /> </td>
                    </tr>
                </table>

                <table class="sw_inner_container" align="center" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center"><img alt="" src="components/com_swmenufree/images/comparison.png" border="0" hspace="0" vspace="0" /> </td>

                        <td width="50%" align="left" valign="top">
                            <img alt="" src="components/com_swmenufree/images/cd_cover.png" align="left" border="0" hspace="10" vspace="10" />
                            <p style="font-size:14px;"><?php echo _SW_SWMENUPRO_INFO; ?></p>
                            <p><i>(1)</i> <?php echo _SW_SWMENUPRO_1; ?></p>
                            <p><i>(2)</i> <?php echo _SW_SWMENUPRO_2; ?></p>
                            <p><i>(3)</i> <?php echo _SW_SWMENUPRO_3; ?></p>
                            <p><i>(4)</i> <?php echo _SW_SWMENUPRO_4; ?></p>
                            <p><i>(5)</i> <?php echo _SW_SWMENUPRO_5; ?></p>
                            <table><tr><td width="200" align="center"><a href="http://www.swmenupro.com" class="swmenu_button_save" target="_blank" ><?php echo _SW_LEARNMORE; ?></a>
                                    </td><td width="200" align="center"><a href="http://www.swmenupro.com/index.php?option=com_content&task=view&id=24&Itemid=312" class="swmenu_button_export" target="_blank" ><?php echo _SW_BUYNOW; ?></a>
                                    </td></tr></table>
                        </td>
                    </tr>
                </table>


                <input type="hidden" name="task" value="uploadfile"/>
                <input type="hidden" name="option" value="com_swmenufree"/>
            </form>
             <script type="text/javascript">
            <!--
jQuery('.sw_manual_button').corner();
             jQuery('.sw_upgrade_button').corner();
 jQuery('.sw_inner_container_header').corner('tl tr');
            jQuery('#toolbar-box').remove();

            jQuery.noConflict();
            -->
        </script>
        </div>

        <?php
    }

    function MenuConfig($rows, $row2, $lists, $orders3) {
      
  $absolute_path=JPATH_ROOT;
  
        ?>
        
      
  <script src="../media/system/js/mootools-core.js" type="text/javascript"></script>
  <script src="../media/system/js/core.js" type="text/javascript"></script> 
  <script type="text/javascript" src="../modules/mod_swmenufree/jquery-1.6.min.js"></script>
  <script type="text/javascript" src="../modules/mod_swmenufree/jquery.corner.js"></script>
  <script type="text/javascript" language="javascript" src="components/com_swmenufree/js/dhtml.js"></script>
  <script type="text/javascript" src="components/com_swmenufree/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../modules/mod_swmenufree/cufon-yui.js"></script>
  <script type="text/javascript" src="components/com_swmenufree/js/jscolor/jscolor.js"></script>
  <script type="text/javascript" src="components/com_swmenufree/js/swmenufree2.js"></script>
  <script src="../media/system/js/modal.js" type="text/javascript"></script>
  
  <link rel="stylesheet" href="components/com_swmenufree/css/swmenufree.css" type="text/css" />
  <link rel="stylesheet" href="components/com_swmenufree/css/jquery-ui.css" type="text/css" />
  <link rel="stylesheet" href="../media/system/css/modal.css" type="text/css" />
 
 
  <script type="text/javascript" language="javascript">
            <!--


            function submitbutton(pressbutton) {
                doMainBorder();
                doSubBorder();
                document.adminForm.target="_self";
                document.adminForm.action="index.php";
                submitform( pressbutton );
            }


            function changeOrientation(){
                menusystem=document.getElementById('menustyle').value;

                orientation=document.getElementById('orientation');
                effects=document.getElementById('extra');

                if(menusystem=='superfishmenu'){
                    effects.options.length=0;
                    effects.options[0]= new Option("none","none");
                    effects.options[1]= new Option("fade","fade");
                    effects.options[2]= new Option("slide down","slide-down");
                    effects.options[3]= new Option("slide right","slide-right");
                    orientation.options.length=0;
                    orientation.options[0]= new Option("horizontal","horizontal");
                    orientation.options[1]= new Option("vertical","vertical");
                    change_orientation();
                }
                if((menusystem=='mygosumenu' || menusystem=='transmenu')&&orientation.options.length<4){
                    orientation.options.length=0;
                    orientation.options[0]=new Option("horizontal/down/right","horizontal/down");
                    orientation.options[1]=new Option("vertical/right","vertical/right");
                    orientation.options[2]=new Option("horizontal/up","horizontal/up");
                    orientation.options[3]=new Option("vertical/left","vertical/left");
                    orientation.options[4]=new Option("horizontal/down/left","horizontal/left");
                    change_orientation();
                }
                if(menusystem=='mygosumenu'){
                    effects.options.length=0;
                    effects.options[0]= new Option("none","none");
                    effects.options[1]= new Option("fade","fade");
                    effects.options[2]= new Option("slide","slide");
                }
                if(menusystem=='transmenu'){
                    effects.options.length=0;
                    effects.options[0]= new Option("none","0");
                    effects.options[1]= new Option("Submenu Shadow","1");
                }
            }

            function doSystemPopup(){
                window.open('components/com_swmenufree/menu_systems.php', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=780,height=550,directories=no,location=no');
            }

         
            var originalOrder2='<?php echo @$rows->parentid; ?>';
            var originalPos2='<?php echo $rows->menutype; ?>';
            var orders2=new Array();	// array in the format [key,value,text]
        <?php
        $i = 0;
        foreach ($orders3 as $k => $items) {
            foreach ($items as $v) {
                echo "\n	orders2[" . $i++ . "]=new Array( '$k','$v->value','$v->text' );";
            }
        }
        ?>
            //-->
        </script>

        <style type='text/css'>
            <!--

            .top_preview{
                display:block;
                background-color:<?php echo $rows->main_back; ?>;
                padding:<?php echo $rows->main_pad_top."px ".$rows->main_pad_right."px ".$rows->main_pad_bottom."px ".$rows->main_pad_left."px"; ?>;
                margin:<?php echo $rows->top_margin_top."px ".$rows->top_margin_right."px ".$rows->top_margin_bottom."px ".$rows->top_margin_left."px"; ?>;
                color:<?php echo $rows->main_font_color; ?>;
                font-size:<?php echo $rows->main_font_size; ?>px;
                font-family:<?php echo $rows->font_family; ?>;
                font-weight:<?php echo $rows->font_weight; ?>;
                <?php
                if ($rows->main_width != 0) {
                    echo " width:" . $rows->main_width . "px; \n";
                }
               
                if ($rows->main_height != 0) {
                    echo " height:" . $rows->main_height . "px; \n";
                }
                ?>
                text-align:<?php echo $rows->main_align; ?>;
                white-space:<?php echo $rows->top_wrap; ?>;
                border:<?php echo $rows->main_border_over_width."px ".$rows->main_border_over_style." ".$rows->main_border_color_over; ?>;
                <?php
                switch ($rows->top_font_extra) {
                    case "italic":
                    case "oblique":
                        echo " font-style:" . $rows->top_font_extra . ";\n";
                        echo " text-decoration: none ;\n";
                        echo " text-transform: none ;\n";
                        break;
                    case "underline":
                    case "overline":
                    case "line-through":
                        echo " text-decoration:" . $rows->top_font_extra . " ;\n";
                        echo " font-style: none ;\n";
                        echo " text-transform: none ;\n";
                        break;
                    case "uppercase":
                    case "lowercase":
                    case "capitalize":
                        echo " text-transform:" . $rows->top_font_extra . " ;\n";
                        echo " text-decoration: none ;\n";
                        echo " font-style: none ;\n";
                        break;
                    default:
                        echo " font-style: none ;\n";
                        echo " text-decoration: none;\n";
                        echo " text-transform: none ;\n";
                        break;
                }
                
                ?>

            }

            .top_preview.normal{
                background-image:<?php echo "url('../" . $rows->main_back_image . "')"; ?>;
                background-repeat:<?php echo $rows->top_background_repeat; ?>;
                background-position:<?php echo $rows->top_background_position; ?>;
            }


            #top_preview_hover{
                background-image:<?php echo "url('../" . $rows->main_back_image_over . "')"; ?>;
                background-repeat:<?php echo $rows->top_hover_background_repeat; ?>;
                background-position:<?php echo $rows->top_hover_background_position; ?>;
                background-color:<?php echo $rows->main_over; ?>;
                color:<?php echo $rows->main_font_color_over; ?>;

            }

            #top_preview_active{
                background-image:<?php echo "url('../" . $rows->active_background_image . "')"; ?>;
                background-repeat:<?php echo $rows->active_background_repeat; ?>;
                background-position:<?php echo $rows->active_background_position; ?>;
                background-color:<?php echo $rows->active_background; ?>;
                color:<?php echo $rows->active_font; ?>;

            }

            .jquery-corner { position: relative; }
            div.autosize { display: table;width:auto}
            div.autosize > div { display: table-cell; }


            #top_preview_outer{
                position:relative;
                z-index:-1;
                display:block;

                background-image:<?php echo "url('../" . $rows->complete_background_image . "')"; ?>;
                background-repeat:<?php echo $rows->complete_background_repeat; ?>;
                background-position:<?php echo $rows->complete_background_position; ?>;
                background-color:<?php echo $rows->complete_background; ?>;
                padding:<?php echo $rows->complete_padding_top."px ".$rows->complete_padding_right."px ".$rows->complete_padding_bottom."px ".$rows->complete_padding_left."px"; ?>;
                border:<?php echo $rows->main_border_width."px ".$rows->main_border_style." ".$rows->main_border_color; ?>;
               
            }

            #top_preview_parent{
                position:relative;
                z-index:1;
                display:block;
            }

            .top_preview_item{
                position:relative;
                z-index:1;
                display:block;
            }
            .top_preview{
                position:relative;
                z-index:-1;
                display:block;
            }



            .sub_preview{
                display:block;
                 padding:<?php echo $rows->sub_pad_top."px ".$rows->sub_pad_right."px ".$rows->sub_pad_bottom."px ".$rows->sub_pad_left."px"; ?>;
               

                color:<?php echo $rows->sub_font_color; ?>;
                font-size:<?php echo $rows->sub_font_size; ?>px;
                font-family:<?php echo $rows->sub_font_family; ?>;
                font-weight:<?php echo $rows->font_weight_over; ?>;
                <?php
                if ($rows->sub_width != 0) {
                    echo " width:" . $rows->sub_width . "px; \n";
                }
               
                if ($rows->sub_height != 0) {
                    echo " height:" . $rows->sub_height . "px; \n";
                }
                ?>
                text-align:<?php echo $rows->sub_align; ?>;
                white-space:<?php echo $rows->sub_wrap; ?>;
                 border:<?php echo $rows->sub_border_over_width."px ".$rows->sub_border_over_style." ".$rows->sub_border_color_over; ?>;
               
                <?php
                switch ($rows->sub_font_extra) {
                    case "italic":
                    case "oblique":
                        echo " font-style:" . $rows->sub_font_extra . ";\n";
                        echo " text-decoration: none ;\n";
                        echo " text-transform: none ;\n";
                        break;
                    case "underline":
                    case "overline":
                    case "line-through":
                        echo " text-decoration:" . $rows->sub_font_extra . " ;\n";
                        echo " font-style: none ;\n";
                        echo " text-transform: none ;\n";
                        break;
                    case "uppercase":
                    case "lowercase":
                    case "capitalize":
                        echo " text-transform:" . $rows->sub_font_extra . " ;\n";
                        echo " text-decoration: none ;\n";
                        echo " font-style: none ;\n";
                        break;
                    default:
                        echo " font-style: none ;\n";
                        echo " text-decoration: none;\n";
                        echo " text-transform: none ;\n";
                        break;
                }
                ?>

            }

            .sub_preview.normal{

            }

            #sub_preview_hover{
                background-image:<?php echo "url('../" . $rows->sub_back_image_over . "')"; ?>;
                background-repeat:<?php echo $rows->sub_hover_background_repeat; ?>;
                background-position:<?php echo $rows->sub_hover_background_position; ?>;
                background-color:<?php echo $rows->sub_over; ?>;
                color:<?php echo $rows->sub_font_color_over; ?>;

            }

            #sub_preview_outer{
                position:relative;
                z-index:-1;
                display:block;

                background-color:<?php echo $rows->sub_back; ?>;
                border:<?php echo $rows->sub_border_width."px ".$rows->sub_border_style." ".$rows->sub_border_color; ?>;
               
                background-image:<?php echo "url('../" . $rows->sub_back_image . "')"; ?>;
                background-repeat:<?php echo $rows->sub_background_repeat; ?>;
                background-position:<?php echo $rows->sub_background_position; ?>;
            }

            #sub_preview_parent{
                position:relative;
                z-index:1;
                display:block;


                background-color:none;
            }



            -->
        </style>


        <div class="swmenu_container" align="center">


            <table  class="sw_inner_container_header"  border="0" width="750">
                <tr>
                    <td width="250"><img src="components/com_swmenufree/images/swmenufree_logo.png" height="39" width="247" align="left" border="0"/></td>
                    <td  valign="bottom" align="left"><span class="swmenu_sectionname"><?php echo _SW_MODULE_EDITOR; ?></span> </td>
                    <td valign="top" align="right" nowrap>
                        <a class="sw_upgrade_button" href="index.php?option=com_swmenufree&task=upgrade" ><img src="components/com_swmenufree/images/gtk_update.png" align="absmiddle" ><?php echo _SW_UPGRADE_LINK; ?></a>
        <?php if (file_exists($absolute_path . "/modules/mod_swmenufree/styles/menu.css") && $row2->id) { ?>
                            <a class="sw_manual_button" href="index.php?option=com_swmenufree&task=editCSS&id=<?php echo $row2->id; ?>" ><img src="components/com_swmenufree/images/paper_content_pencil.png" align="absmiddle" ><?php echo _SW_CSS_LINK; ?></a>
        <?php } else { ?>
                            <a class="sw_manual_button" href="javascript:void(0);" onClick="doExport();" ><img src="components/com_swmenufree/images/export_to_file.png" align="absmiddle" ><?php echo _SW_EXPORT_LINK; ?></a>
        <?php } ?>

                    </td>
                </tr>
            </table>

            <form action="index.php" method="POST" name="adminForm" id="sw_admin_form">
                <table class="sw_inner_container" cellpadding="0" cellspacing="0" border="0" width="750" style="height:35px">
                    <tr>
                        <td id="tab6" class="swmenu_offtab" onclick="dhtml.cycleTab(this.id);"><?php echo _SW_MODULE_SETTINGS_TAB; ?></td>
                        <td id="tab1" class="swmenu_offtab" onclick="dhtml.cycleTab(this.id);"><?php echo _SW_SIZE_OFFSETS_TAB; ?></td>
                        <td id="tab2" class="swmenu_offtab" onclick="dhtml.cycleTab(this.id);"><?php echo _SW_BACKGROUND_INDICATOR_TAB; ?></td>
                        <td id="tab3" class="swmenu_offtab" onclick="dhtml.cycleTab(this.id);"><?php echo _SW_FONTS_TEXT_TAB; ?></td>
                        <td id="tab5" class="swmenu_offtab" onclick="dhtml.cycleTab(this.id);"><?php echo _SW_BORDERS_CORNERS_TAB; ?></td>


                    </tr>
                </table>

                <table class="swmenu_tabheading" style="width:750px;margin:auto;" width="750">
                    <tr>
                        <td width="80%"> <?php echo _SW_MODULE_NAME.": ". $row2->title; ?>&nbsp;<a class="sw_joomla_button"  href="javascript:void(0);" onclick='get_module();'/> <?php echo _SW_EDIT_JOOMLA_PROPERTIES; ?></a>
                        </td><td><a href="javascript:void(0);" class="swmenu_button_save" onClick="doSave();" onmouseover="this.T_ABOVE=true;return escape('<?php echo _SW_SAVE_TIP; ?>')" ><?php echo _SW_SAVE_BUTTON; ?></a>
                        </td>
                        <?php if (file_exists($absolute_path . "/modules/mod_swmenufree/styles/menu.css") && $row2->id) { ?>
                        <td><a href="javascript:void(0);" class="swmenu_button_export" onClick="doExport();" onmouseover="this.T_ABOVE=true;return escape('<?php echo _SW_EXPORT_TIP; ?>')" ><?php echo _SW_EXPORT_BUTTON; ?></a>
                        </td>
                         <?php } ?>
                        <td><a href="javascript:void(0);" class="swmenu_button_preview" onClick="doPreviewWindow();" onmouseover="this.T_ABOVE=true;return escape('<?php echo _SW_PREVIEW_TIP; ?>')" ><?php echo _SW_PREVIEW_BUTTON; ?></a>
                        </td><td><a href="javascript:void(0);" class="swmenu_button_cancel" onClick="doCancel();" onmouseover="this.T_ABOVE=true;return escape('<?php echo _SW_CANCEL_TIP; ?>')"><?php echo _SW_CANCEL_BUTTON; ?></a>
                        </td>
                    </tr>
                </table>

                <div id="page1" class="pagetext" >

                    <table width="750">
                        <tr>
                            <td width="50%" valign="top" align="center">
                                <table class="sw_table_left"  >
                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_POSITION_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU . " - " . _SW_ALIGNMENT; ?>:</td>
                                        <td> <div align="right"><?php echo $lists['position']; ?></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_TOP_MENU . " - " . _SW_ORIENTATION; ?>:</td>
                                        <td> <div align="right"><?php echo $lists['orientation']; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_SIZES_LABEL . " " . _SW_AUTOSIZE; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_ITEM_WIDTH; ?></td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="main_width" name="main_width" value="<?php echo $rows->main_width; ?>" />px</div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_ITEM_HEIGHT; ?></td>
                                        <td> <div align="right">
                                                <input id="main_height" name="main_height" type="text" value="<?php echo $rows->main_height; ?>" size="4"/>px</div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_ITEM_WIDTH; ?></td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="sub_width" name="sub_width" value="<?php echo $rows->sub_width; ?>"/>px</div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_ITEM_HEIGHT; ?></td>
                                        <td> <div align="right">
                                                <input id="sub_height" name="sub_height" type="text" value="<?php echo $rows->sub_height; ?>" size="4"/>px</div></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_TOP_OFFSETS_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_OFFSET; ?>:</td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="main_top" name="main_top" value="<?php echo $rows->main_top; ?>"/>px</div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_LEFT_OFFSET; ?>:</td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="main_left" name="main_left" value="<?php echo $rows->main_left; ?>"/>px</div></td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_SUB_OFFSETS_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_LEVEL . " 1 - " . _SW_TOP_OFFSET; ?>:</td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="level1_sub_top" name="level1_sub_top" value="<?php echo $rows->level1_sub_top; ?>"/>px</div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_LEVEL . " 1 - " . _SW_LEFT_OFFSET; ?>:</td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="level1_sub_left" name="level1_sub_left" value="<?php echo $rows->level1_sub_left; ?>"/>px</div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_LEVEL . " 2 - " . _SW_TOP_OFFSET; ?>:</td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="level2_sub_top" name="level2_sub_top" value="<?php echo $rows->level2_sub_top; ?>"/>px</div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_LEVEL . " 2 - " . _SW_LEFT_OFFSET; ?>:</td>
                                        <td> <div align="right">
                                                <input type="text" size="4" id="level2_sub_left" name="level2_sub_left" value="<?php echo $rows->level2_sub_left; ?>"/>px</div></td>
                                    </tr>

                                </table>
                            </td>
                            <td width="50%" valign="top" align="center">
                                <table class="sw_table_right"  >


                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_COMPLETE_MENU_PADDING; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_TOP; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_BOTTOM; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_LEFT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><input type="text" onchange="doCompletePadding();" size="3" id="complete_margin_top" name="complete_margin_top" value="<?php echo $rows->complete_margin_top; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doCompletePadding();" size="3" id="complete_margin_right" name="complete_margin_right" value="<?php echo $rows->complete_margin_right; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doCompletePadding();" size="3" id="complete_margin_bottom" name="complete_margin_bottom" value="<?php echo $rows->complete_margin_bottom; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doCompletePadding();" size="3" id="complete_margin_left" name="complete_margin_left" value="<?php echo $rows->complete_margin_left; ?>" maxlength="3" />px</td>
                                                </tr><tr>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider18'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider19'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider20'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider21'></div></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_TOP_MENU_MARGINS_LABEL; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_TOP; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_BOTTOM; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_LEFT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><input type="text" onchange="doTopMargin();" size="3" id="top_margin_top" name="top_margin_top" value="<?php echo $rows->top_margin_top; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doTopMargin();" size="3" id="top_margin_right" name="top_margin_right" value="<?php echo $rows->top_margin_right; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doTopMargin();" size="3" id="top_margin_bottom" name="top_margin_bottom" value="<?php echo $rows->top_margin_bottom; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doTopMargin();" size="3" id="top_margin_left" name="top_margin_left" value="<?php echo $rows->top_margin_left; ?>" maxlength="3" />px</td>
                                                </tr><tr>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider14'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider15'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider16'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider17'></div></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_TOP_MENU . " " . _SW_PADDING; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_TOP; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_BOTTOM; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_LEFT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><input type="text" onchange="doMainPadding();" size="3" id="main_pad_top" name="main_pad_top" value="<?php echo $rows->main_pad_top; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doMainPadding();" size="3" id="main_pad_right" name="main_pad_right" value="<?php echo $rows->main_pad_right; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doMainPadding();" size="3" id="main_pad_bottom" name="main_pad_bottom" value="<?php echo $rows->main_pad_bottom; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doMainPadding();" size="3" id="main_pad_left" name="main_pad_left" value="<?php echo $rows->main_pad_left; ?>" maxlength="3" />px</td>
                                                </tr><tr>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider22'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider23'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider24'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider25'></div></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_SUB_MENU . " " . _SW_PADDING; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_TOP; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_BOTTOM; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_LEFT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><input type="text" onchange="doSubPadding();" size="3" id="sub_pad_top" name="sub_pad_top" value="<?php echo $rows->sub_pad_top; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doSubPadding();" size="3" id="sub_pad_right" name="sub_pad_right" value="<?php echo $rows->sub_pad_right; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doSubPadding();" size="3" id="sub_pad_bottom" name="sub_pad_bottom" value="<?php echo $rows->sub_pad_bottom; ?>" maxlength="3" />px</td>
                                                    <td width="80" align="center"><input type="text" onchange="doSubPadding();" size="3" id="sub_pad_left" name="sub_pad_left" value="<?php echo $rows->sub_pad_left; ?>" maxlength="3" />px</td>
                                                </tr><tr>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider26'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider27'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider28'></div></td>
                                                    <td width="80" align="center"><div style='width:70px;' id='slider29'></div></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>



                </div>



                <div id="page2" class="pagetext">

                   <table width="750">
  <tr>
    <td width="50%" valign="top" align="center"> 
      <table class="sw_table_left" >
        <tr>
          <td colspan="3" class="swmenu_tabheading"> <div align="center"><?php echo _SW_BACKGROUND_IMAGE_LABEL; ?></div></td>
        </tr>
        <tr class="swmenu_menubackgr" >
        <td width="30%"> <?php echo _SW_COMPLETE_MENU; ?>:</td>
        <td align="right"> 
          <table  align="right" id="complete_background_image_box" style="border: 1px solid #000000; width:120px;margin-right:10px;" background="../<?php echo $rows->complete_background_image;?>" align="left"> 
            <tr><td width="100%" height="36">&nbsp;</td></tr>
          </table>
        </td><td width="40%" align="right">
            <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('complete_background_image');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('complete_background_image_box').style.background='none';document.getElementById('complete_background_image').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
         <input type="hidden" id="complete_background_image" name="complete_background_image" value="<?php echo $rows->complete_background_image;?>"/>
       
          </td>
     </tr>
      <tr class="swmenu_menubackgr" >
        <td align="right" colspan="3"> <?php echo _SW_BACKGROUND_REPEAT; ?>:
        <?php echo $lists['complete_background_repeat']; ?>
            <?php echo _SW_BACKGROUND_POSITION; ?>:
          <?php echo $lists['complete_background_position']; ?></td>
      </tr>
      <tr>
          <td><?php echo _SW_ACTIVE_MENU; ?>:</td>
          <td align="right"> 
          <table  align="right" id="active_background_image_box" style="border: 1px solid #000000; width:120px;margin-right:10px;" background="../<?php echo $rows->active_background_image;?>" align="left"> 
            <tr><td width="100%" height="36">&nbsp;</td></tr>
          </table>
        </td><td align="right">
           <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('active_background_image');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('active_background_image_box').style.background='none';document.getElementById('active_background_image').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
       
          <input type="hidden" id="active_background_image" name="active_background_image" value="<?php echo $rows->active_background_image;?>"/>
       
          </td>
      </tr>
     
     <tr>
        <td align="right" colspan="3"> <?php echo _SW_BACKGROUND_REPEAT; ?>:
        <?php echo $lists['active_background_repeat']; ?>
            <?php echo _SW_BACKGROUND_POSITION; ?>:
          <?php echo $lists['active_background_position']; ?></td>
      </tr>
     
   <tr class="swmenu_menubackgr" >
          <td><?php echo _SW_TOP_MENU; ?>:</td>
          <td align="right"> 
          <table  align="right" id="main_back_image_box" style="border: 1px solid #000000; width:120px;margin-right:10px;" background="../<?php echo $rows->main_back_image;?>" align="left"> 
            <tr><td width="100%" height="36">&nbsp;</td></tr>
          </table>
        </td><td align="right">
          <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('main_back_image');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('main_back_image_box').style.background='none';document.getElementById('main_back_image').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
       
          <input type="hidden" id="main_back_image" name="main_back_image" value="<?php echo $rows->main_back_image;?>"/>
       
          </td>
      </tr>
      <tr class="swmenu_menubackgr" >
        <td align="right" colspan="3"> <?php echo _SW_BACKGROUND_REPEAT; ?>:
        <?php echo $lists['top_background_repeat']; ?>
            <?php echo _SW_BACKGROUND_POSITION; ?>:
          <?php echo $lists['top_background_position']; ?></td>
      </tr>
      
      <tr>
        <td><?php echo _SW_TOP_MENU." "._SW_HOVER; ?>:</td>
        <td align="right"> 
          <table  align="right" id="main_back_image_over_box" style="border: 1px solid #000000; width:120px;margin-right:10px;" background="../<?php echo $rows->main_back_image_over;?>" align="left"> 
            <tr><td width="100%" height="36">&nbsp;</td></tr>
          </table>
        </td><td align="right">
           <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('main_back_image_over');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('main_back_image_over_box').style.background='none';document.getElementById('main_back_image_over').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
        
          <input type="hidden" id="main_back_image_over" name="main_back_image_over" value="<?php echo $rows->main_back_image_over;?>"/>
       
          </td>
     </tr>
     <tr>
        <td align="right" colspan="3"> <?php echo _SW_BACKGROUND_REPEAT; ?>:
        <?php echo $lists['top_hover_background_repeat']; ?>
            <?php echo _SW_BACKGROUND_POSITION; ?>:
          <?php echo $lists['top_hover_background_position']; ?></td>
      </tr>
     
     
     
     <tr class="swmenu_menubackgr" >
       <td><?php echo _SW_SUB_MENU; ?>:</td>
      <td align="right"> 
          <table  align="right" id="sub_back_image_box" style="border: 1px solid #000000; width:120px;margin-right:10px;" background="../<?php echo $rows->sub_back_image;?>" align="left"> 
            <tr><td width="100%" height="36">&nbsp;</td></tr>
          </table>
        </td><td align="right">
           <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('sub_back_image');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('sub_back_image_box').style.background='none';document.getElementById('sub_back_image').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
       
          <input type="hidden" id="sub_back_image" name="sub_back_image" value="<?php echo $rows->sub_back_image;?>"/>
       
          </td>
     </tr>
     <tr class="swmenu_menubackgr" >
        <td align="right" colspan="3"> <?php echo _SW_BACKGROUND_REPEAT; ?>:
        <?php echo $lists['sub_background_repeat']; ?>
            <?php echo _SW_BACKGROUND_POSITION; ?>:
          <?php echo $lists['sub_background_position']; ?></td>
      </tr>
     <tr>
       <td><?php echo _SW_SUB_MENU." "._SW_HOVER; ?>:</td>
         <td align="right"> 
          <table  align="right" id="sub_back_image_over_box" style="border: 1px solid #000000; width:120px;margin-right:10px;" background="../<?php echo $rows->sub_back_image_over;?>" align="left"> 
            <tr><td width="100%" height="36">&nbsp;</td></tr>
          </table>
        </td><td align="right">
           <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('sub_back_image_over');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('sub_back_image_over_box').style.background='none';document.getElementById('sub_back_image_over').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
       
          <input type="hidden" id="sub_back_image_over" name="sub_back_image_over" value="<?php echo $rows->sub_back_image_over;?>"/>
       
          </td>
      </tr>
     <tr>
        <td align="right" colspan="3"> <?php echo _SW_BACKGROUND_REPEAT; ?>:
        <?php echo $lists['sub_hover_background_repeat']; ?>
            <?php echo _SW_BACKGROUND_POSITION; ?>:
          <?php echo $lists['sub_hover_background_position']; ?></td>
      </tr>
      
      
     
   </table>
                            </td>
                            <td width="50%" valign="top" align="center">
                                <table class="sw_table_right"  >

                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_BACKGROUND_COLOR_LABEL; ?></div></td>
                                    </tr>

                                    <tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_COMPLETE_MENU ?>:</td>
                                        <td>  <div style="float:right;" >
                                                <div id="complete_background_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:26px" bgColor='<?php echo $rows->complete_background; ?>'>
                                                </div><input type="text" size="8" onchange="doColorChange(this);" class="color {styleElement:'complete_background_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}" id="complete_background" name="complete_background" value="<?php echo $rows->complete_background; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('complete_background').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('complete_background_box').style.background='none';document.getElementById('complete_background').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a></div></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _SW_ACTIVE_MENU ?>:</td>
                                        <td>  <div style="float:right;" >
                                                <div id="active_background_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:26px" bgColor='<?php echo $rows->active_background; ?>'>
                                                </div><input type="text" size="8"  onchange="doColorChange(this);" class="color {styleElement:'active_background_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}" id="active_background" name="active_background" value="<?php echo $rows->active_background; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('active_background').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif" /><?php echo _SW_GET; ?></a>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('active_background_box').style.background='none';document.getElementById('active_background').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a></div></td>
                                    </tr>
                                    <tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td>  <div style="float:right;" >
                                                <div id="main_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:26px" bgColor='<?php echo $rows->main_back; ?>'>
                                                </div>
                                                <input type="text" size="8" onchange="doColorChange(this);" class="color {styleElement:'main_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}" id="main_back" name="main_back" value="<?php echo $rows->main_back; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_back').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_box').style.background='none';document.getElementById('main_back').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_HOVER; ?>:</td>
                                        <td>  <div style="float:right;" >
                                                <div id="main_over_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:26px" bgColor='<?php echo $rows->main_over; ?>'>
                                                </div>
                                                <input type="text" size="8"  onchange="doColorChange(this);" class="color {styleElement:'main_over_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}" id="main_over" name="main_over" value="<?php echo $rows->main_over; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_over').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_over_box').style.background='none';document.getElementById('main_over').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a></div></td>
                                    </tr>



                                    <tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td> <div style="float:right;" >
                                                <div id="sub_back_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:26px" bgColor='<?php echo $rows->sub_back; ?>'>
                                                </div>
                                                <input type="text" size="8" onchange="doColorChange(this);" class="color {styleElement:'sub_back_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"  id="sub_back" name="sub_back" value="<?php echo $rows->sub_back; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_back').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_back_box').style.background='none';document.getElementById('sub_back').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_HOVER; ?>:</td>
                                        <td>  <div style="float:right;" >
                                                <div id="sub_over_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:26px" bgColor='<?php echo $rows->sub_over; ?>'>
                                                </div><input type="text" size="8" onchange="doColorChange(this);" class="color {styleElement:'sub_over_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}" id="sub_over" name="sub_over" value="<?php echo $rows->sub_over; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_over').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_over_box').style.background='none';document.getElementById('sub_over').value='';doCompletePreview();">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a></div></td>
                                    </tr>
                                  

                                    
                                    
                                    
                                     <tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_SUB_INDICATOR; ?></div></td>
                                    </tr>
                                    <tr>
                                        <td width="30%"><?php echo _SW_TOP_MENU; ?>:
   </td>
 <td align="right">
     <table  style="border: 1px solid #000000; width:100px;margin-right:10px;"  align="left"> 
            <tr><td id="top_sub_table" align="center" valign="center" width="100%" height="20"><?php echo $lists['top_sub_indicator']; ?></td></tr>
          </table> 
              <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('top_sub');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('top_sub').src='../modules/mod_swmenupro/images/empty.gif';document.getElementById('top_sub_indicator').value='';">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
             
                                        </td>
                                    <tr class="swmenu_menubackgr">
                                        <td height="20" ><?php echo _SW_ALIGNMENT; ?>:</td>
                                        <td> <div align="right"><?php echo $lists['top_sub_indicator_align']; ?></div></td>
                                    </tr>

                                    <tr>
                                        <td height="20"><?php echo _SW_TOP_OFFSET; ?>:</td>
                                        <td> <div align="right">
        <?php echo $lists['top_sub_indicator_top']; ?>px</div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td height="20"><?php echo _SW_LEFT_OFFSET; ?>:</td>
                                        <td> <div align="right">
        <?php echo $lists['top_sub_indicator_left']; ?>px</div></td>
                                    </tr>
                                    
<tr>
  <td width="33%"><?php echo _SW_SUB_MENU; ?>:
   </td>
 <td align="right"><table style="border: 1px solid #000000; width:100px;margin-right:10px;" align="left"> 
            <tr><td id="sub_sub_table" align="center" valign="center" width="100%" height="20"><?php echo $lists['sub_sub_indicator']; ?></td></tr>
          </table>  <a onMouseOver="this.style.cursor='pointer'" onclick="get_background_image('sub_sub');"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET_IMAGE_BUTTON; ?></a>
            <a onMouseOver="this.style.cursor='pointer'" onclick="document.getElementById('sub_sub').src='../modules/mod_swmenupro/images/empty.gif';document.getElementById('sub_sub_indicator').value='';">&nbsp;<img src="components/com_swmenufree/images/clear.png" hspace="4" align="top" /><?php echo _SW_CLEAR; ?></a>
             
                                        </td>
                                    <tr class="swmenu_menubackgr">
                                        <td height="20" ><?php echo _SW_ALIGNMENT; ?>:</td>
                                        <td> <div align="right"><?php echo $lists['sub_sub_indicator_align']; ?></div></td>
                                    </tr>

                                    <tr>
                                        <td height="20"><?php echo _SW_TOP_OFFSET; ?>:</td>
                                        <td> <div align="right">
        <?php echo $lists['sub_sub_indicator_top']; ?>px</div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td height="20"><?php echo _SW_LEFT_OFFSET; ?>:</td>
                                        <td> <div align="right">
        <?php echo $lists['sub_sub_indicator_left']; ?>px</div></td>
                                    </tr>
                                    
                                    
                                    


                                </table>
                            </td>
                        </tr>
                    </table>


                </div>


                <div id="page3" class="pagetext">
                    <table width="750">
                        <tr>
                           <td width="50%" valign="top" align="center">
                                <table class="sw_table_left" >
                                    <tr>
                                        <td colspan="3" class="swmenu_tabheading"><div align="center"><?php echo _SW_FONT_FAMILY_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  colspan="2" ><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td  width="250"><div align="right"><?php echo $lists['font_family']; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" ><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td  width="250"><div align="right"><?php echo $lists['sub_font_family']; ?></div></td>
                                    </tr>
                                    <tr>
                                       <td colspan="3" class="swmenu_tabheading"><div align="center"><?php echo _SW_TRUE_TYPE_FONTS_LABEL; ?> &nbsp;<a class="sw_joomla_button"  href="javascript:void(0);" onclick='get_cufon();'/><?php echo _SW_UPLOAD_TTF; ?></a></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  colspan="2" ><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td width="250"><div align="right"><?php echo $lists['topTTF']; ?></div>




                                        </td>
                                    </tr><tr>
                                        <td colspan="2" ><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td width="250"><div align="right"><?php echo $lists['subTTF']; ?></div></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="swmenu_tabheading"> <div align="center"><?php echo _SW_FONT_COLOR_LABEL; ?></div>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  colspan="2"><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td>  <div style="float:right;" >
                                                <div id="main_font_color_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:32px" bgColor='<?php echo $rows->main_font_color; ?>'>

                                                </div>

                                                <input name="main_font_color" onchange="doFontColor(this);" type="text" id="main_font_color" value="<?php echo $rows->main_font_color; ?>" size="8" class="color {styleElement:'main_font_color_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_font_color').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr><tr>
                                        <td  colspan="2"><?php echo _SW_TOP_MENU . " " . _SW_HOVER; ?>:</td>
                                        <td> <div style="float:right;" >
                                                <div id="main_font_color_over_box" style="border: 1px solid #000000; width:20px; height:32px;float:left;margin-right:10px;" bgColor='<?php echo $rows->main_font_color_over; ?>'>
                                                </div>
                                                <input name="main_font_color_over" onchange="doFontColor(this);" type="text" id="main_font_color_over" value="<?php echo $rows->main_font_color_over; ?>" size="8" class="color {styleElement:'main_font_color_over_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_font_color_over').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  colspan="2"><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td>
                                            <div style="float:right;" >
                                                <div id="sub_font_color_box" style="border: 1px solid #000000; width:20px; height:32px;float:left;margin-right:10px;" bgColor='<?php echo $rows->sub_font_color; ?>'>
                                                </div>
                                                <input name="sub_font_color" type="text" onchange="doFontColor(this);" id="sub_font_color" value="<?php echo $rows->sub_font_color; ?>" size="8" class="color {styleElement:'sub_font_color_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_font_color').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr><tr>
                                        <td  colspan="2"><?php echo _SW_SUB_MENU . " " . _SW_HOVER; ?>:</td>
                                        <td>
                                            <div style="float:right;" >
                                                <div id="sub_font_color_over_box" style="border: 1px solid #000000; width:20px; height:32px;float:left;margin-right:10px;" bgColor='<?php echo $rows->sub_font_color_over; ?>'>
                                                </div>
                                                <input name="sub_font_color_over" type="text" onchange="doFontColor(this);" id="sub_font_color_over" value="<?php echo $rows->sub_font_color_over; ?>"  size="8" class="color {styleElement:'sub_font_color_over_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_font_color_over').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr>
                                    <tr  class="swmenu_menubackgr">
                                        <td  colspan="2"><?php echo _SW_ACTIVE_MENU ?>:</td>
                                        <td>
                                            <div style="float:right;" >
                                                <div id="active_font_box" style="border: 1px solid #000000; width:20px; height:32px;float:left;margin-right:10px;" bgColor='<?php echo $rows->active_font; ?>'>
                                                </div><input type="text" size="8" onchange="doFontColor(this);" class="color {styleElement:'active_font_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}" id="active_font" name="active_font" value="<?php echo $rows->active_font; ?>"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('active_font').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr>




                                </table>
                            </td>
                           <td width="50%" valign="top" align="center">
                                <table class="sw_table_right" >
                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_FONT_SIZE_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td width="100"><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td>
                                            <div align="right">
                                                <input id="main_font_size" onchange="jQuery('.top_preview').css('font-size',this.value+'px');" name="main_font_size" type="text" value="<?php echo $rows->main_font_size; ?>" size="3" /> px
                                            </div>
                                        </td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td>
                                            <div align="right">
                                                <input id="sub_font_size" onchange="jQuery('.sub_preview').css('font-size',this.value+'px');" name="sub_font_size" type="text" value="<?php echo $rows->sub_font_size; ?>" size="3" /> px
                                            </div>
                                        </td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_FONT_WEIGHT_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['font_weight']; ?></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['font_weight_over']; ?></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading">
                                            <div align="center"><?php echo _SW_FONT_ALIGNMENT_LABEL; ?></div>
                                        </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['main_align']; ?></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['sub_align']; ?></div></td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading">
                                            <div align="center"><?php echo _SW_TEXT_WRAPPING_LABEL ?></div>
                                        </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['top_wrap']; ?></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['sub_wrap']; ?></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading">
                                            <div align="center"><?php echo _SW_ADDITIONAL_STYLES_LABEL ?></div>
                                        </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['top_font_extra']; ?></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU; ?>:</td>
                                        <td><div align="right"><?php echo $lists['sub_font_extra']; ?></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </div>


                <div id="page5" class="pagetext">
                    <table width="750">
                        <tr>
                            <td width="50%" valign="top" align="center">
                                <table class="sw_table_left" >
                                    <tr>
                                        <td colspan="3" class="swmenu_tabheading"><div align="center"><?php echo _SW_BORDER_WIDTHS_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_OUTSIDE; ?>:</td>
                                        <td   colspan="2" align="right">
                                            <input id="main_border_width" onchange="doMainBorder();" name="main_border_width" type="text" value="<?php echo $rows->main_border_width; ?>" size="3" /> px

                                        </td>
                                    </tr><tr>
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_INSIDE; ?>:</td>
                                        <td colspan="2" align="right">
                                            <input id="main_border_over_width" onchange="doMainBorder();" name="main_border_over_width" type="text" value="<?php echo $rows->main_border_over_width; ?>" size="3" /> px

                                        </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_OUTSIDE; ?>:</td>
                                        <td colspan="2" align="right">
                                            <input id="sub_border_width" onchange="doSubBorder();" name="sub_border_width" type="text" value="<?php echo $rows->sub_border_width; ?>" size="3" /> px

                                        </td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_INSIDE; ?>:</td>
                                        <td colspan="2" align="right">
                                            <input id="sub_border_over_width" onchange="doSubBorder();" name="sub_border_over_width" type="text" value="<?php echo $rows->sub_border_over_width; ?>" size="3" /> px

                                        </td>
                                    </tr><tr>
                                        <td colspan="3" class="swmenu_tabheading"><div align="center"><?php echo _SW_BORDER_STYLES_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  colspan="2"><?php echo _SW_TOP_MENU . " " . _SW_OUTSIDE; ?>:</td>
                                        <td align="right"><?php echo $lists['main_border_style']; ?></td>
                                    </tr><tr>
                                        <td  colspan="2"><?php echo _SW_TOP_MENU . " " . _SW_INSIDE; ?>:</td>
                                        <td align="right"><?php echo $lists['main_border_over_style']; ?></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  colspan="2"><?php echo _SW_SUB_MENU . " " . _SW_OUTSIDE; ?>:</td>
                                        <td align="right"><?php echo $lists['sub_border_style']; ?></td>
                                    </tr><tr>
                                        <td  colspan="2"><?php echo _SW_SUB_MENU . " " . _SW_INSIDE; ?>:</td>
                                        <td align="right"><?php echo $lists['sub_border_over_style']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="swmenu_tabheading"> <div align="center"><?php echo _SW_BORDER_COLOR_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_OUTSIDE; ?>:</td>
                                        <td colspan="2"><div style="float:right;">
                                                <div id="main_border_color_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:30px" bgColor='<?php echo $rows->main_border_color; ?>'>

                                                </div>

                                                <input  name="main_border_color" onChange="doMainBorder();" type="text" id="main_border_color" value="<?php echo $rows->main_border_color; ?>" size="8" class="color {styleElement:'main_border_color_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_border_color').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_TOP_MENU . " " . _SW_INSIDE; ?>:</td>
                                        <td colspan="2"><div style="float:right;">
                                                <div id="main_border_color_over_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:30px" bgColor='<?php echo $rows->main_border_color_over; ?>'>

                                                </div>

                                                <input  name="main_border_color_over" onChange="doMainBorder();" type="text" id="main_border_color_over" value="<?php echo $rows->main_border_color_over; ?>" size="8" class="color {styleElement:'main_border_color_over_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('main_border_color_over').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_OUTSIDE; ?>:</td>
                                        <td colspan="2"><div style="float:right;">
                                                <div id="sub_border_color_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:30px" bgColor='<?php echo $rows->sub_border_color; ?>'>
                                                </div>
                                                <input  name="sub_border_color" type="text" onChange="doSubBorder();" id="sub_border_color" value="<?php echo $rows->sub_border_color; ?>" size="8" class="color {styleElement:'sub_border_color_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_border_color').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr><tr>
                                        <td><?php echo _SW_SUB_MENU . " " . _SW_INSIDE; ?>:</td>
                                        <td colspan="2"><div style="float:right;">
                                                <div id="sub_border_color_over_box" style="float:left;margin-right:10px;border: 1px solid #000000; width:20px; height:30px" bgColor='<?php echo $rows->sub_border_color_over; ?>'>
                                                </div>
                                                <input  name="sub_border_color_over" type="text" onChange="doSubBorder();" id="sub_border_color_over" value="<?php echo $rows->sub_border_color_over; ?>" size="8" class="color {styleElement:'sub_border_color_over_box',hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                                <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('sub_border_color_over').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div></td>
                                    </tr>
                                </table>
                            </td>
                           <td width="50%" valign="top" align="center">
                                <table class="sw_table_right" >
                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_COMPLETE_MENU . " " . _SW_CORNER_STYLES_LABEL; ?></div></td>
                                    </tr>
                                    <tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_CORNER_STYLE; ?>:</td>
                                        <td align="right">
        <?php echo $lists['c_corner_style']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _SW_CORNER_SIZE; ?>:</td>
                                        <td align="right">
        <?php echo $lists['c_corner_size']; ?> px

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_CORNER_TOP_LEFT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_TOP_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_BOTTOM_LEFT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_BOTTOM_RIGHT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><?php echo $lists['ctl_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['ctr_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['cbl_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['cbr_corner']; ?></td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_TOP_MENU . " " . _SW_CORNER_STYLES_LABEL; ?></div></td>
                                    </tr>
                                    <tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_CORNER_STYLE; ?>:</td>
                                        <td align="right">
        <?php echo $lists['t_corner_style']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _SW_CORNER_SIZE; ?>:</td>
                                        <td align="right">
        <?php echo $lists['t_corner_size']; ?> px

                                        </td>
                                    </tr><tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_CORNER_TOP_LEFT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_TOP_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_BOTTOM_LEFT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_BOTTOM_RIGHT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><?php echo $lists['ttl_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['ttr_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['tbl_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['tbr_corner']; ?></td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_SUB_MENU . " " . _SW_CORNER_STYLES_LABEL; ?></div></td>
                                    </tr>
                                    <tr class="swmenu_menubackgr">
                                        <td><?php echo _SW_CORNER_STYLE; ?>:</td>
                                        <td align="right">
        <?php echo $lists['s_corner_style']; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _SW_CORNER_SIZE; ?>:</td>
                                        <td align="right">
        <?php echo $lists['s_corner_size']; ?> px

                                        </td>
                                    </tr><tr>
                                        <td colspan="2" align="center">
                                            <table>
                                                <tr class="swmenu_menubackgr">
                                                    <td width="80" align="center"><?php echo _SW_CORNER_TOP_LEFT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_TOP_RIGHT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_BOTTOM_LEFT; ?></td>
                                                    <td width="80" align="center"><?php echo _SW_CORNER_BOTTOM_RIGHT; ?></td>
                                                </tr><tr>
                                                    <td width="80" align="center"><?php echo $lists['stl_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['str_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['sbl_corner']; ?></td>
                                                    <td width="80" align="center"><?php echo $lists['sbr_corner']; ?></td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>


                </div>


                <div id="page6" class="pagetext">
                    <table width="750">
                        <tr>
                           <td width="50%" valign="top" align="center">
                                <table class="sw_table_left" >
                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_MENU_SOURCE_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td align="left"><?php echo _SW_MENU_SYSTEM; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_MENU_SYSTEM_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle"  border="0" /></a>
        <?php echo $lists['menustyle']; ?> </td>
                                    </tr><tr>
                                        <td align="left"><?php echo _SW_MENU_SOURCE; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_MENU_SOURCE_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['menutype']; ?> </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td  align="left" ><?php echo _SW_PARENT; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_PARENT_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
                                            <script language="javascript" type="text/javascript">
                                                <!--
                                                writeDynaList( 'class="inputbox" name="parentid" size="1" style="width:200px"', orders2, originalPos2, originalPos2, originalOrder2 );
                                                //-->
                                            </script> </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _SW_MAX_LEVELS; ?>:</td><td>
                                            <a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_MAX_LEVELS_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
                                            <?php echo $lists['levels']; ?> </td>
                                    </tr>
                                        <tr class="swmenu_menubackgr">
                                        <td valign="top"><?php echo _SW_ACTIVE_MENU; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_ACTIVE_MENU_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['active_menu']; ?> </td>
                                    </tr>
                                   <tr>
                                        <td valign="top"><?php echo _SW_STYLE_SHEET; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_STYLE_SHEET_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['cssload']; ?> </td>
                                    </tr><tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_AUTO_ITEM_LABEL; ?></div></td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td valign="top"><?php echo _SW_HYBRID_MENU; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_HYBRID_MENU_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['hybrid']; ?> </td>
                                    </tr><tr>
                                        <td valign="top"><?php echo _SW_TABLES_BLOGS; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_TABLES_BLOGS_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['tables']; ?> </td>
                                    </tr>
                                </table>


                            </td>
                           <td width="50%" valign="top" align="center">
                                <table class="sw_table_right" >
                                  

                                    <tr>
                                        <td colspan="2" class="swmenu_tabheading"> <div align="center"><?php echo _SW_MENU_HACKS; ?></div></td>
                                    </tr>
                                     
                                    <tr  class="swmenu_menubackgr">
                                        <td valign="top"><?php echo _SW_OVERLAY_HACK; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_OVERLAY_HACK_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle"  border="0" /></a>
        <?php echo $lists['overlay_hack']; ?> </td>
                                    </tr>
                                   
                                    <tr>
                                        <td valign="top"><?php echo _SW_PADDING_HACK; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_PADDING_HACK_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['padding_hack']; ?> </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td valign="top"><?php echo _SW_AUTO_POSITION; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_AUTO_POSITION_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['auto_position']; ?> </td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo _SW_FLASH_HACK; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_FLASH_HACK_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['flash_hack']; ?> </td>
                                    </tr>
                                    <tr class="swmenu_menubackgr">
                                        <td valign="top"><?php echo _SW_DISABLE_JQUERY; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_DISABLE_JQUERY_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['disable_jquery']; ?> </td>
                                    </tr>
                                    
                                     <tr>
                                        <td valign="top"><?php echo _SW_TABLET_HACK; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_TABLET_HACK_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['tablet_hack']; ?> </td>
                                    </tr>

  <tr>
                                        <td colspan="2" class="swmenu_tabheading"><div align="center"><?php echo _SW_SPECIAL_EFFECTS_LABEL; ?></div></td>
                                    </tr><tr>
                                        <td valign="top"><?php echo _SW_SPECIAL_EFFECTS_LABEL; ?>:</td>
                                        <td><a href="javascript:void(0);" onmouseover="return escape('<?php echo _SW_SPECIAL_EFFECTS_TIP; ?>')" >
                                                <img src="components/com_swmenufree/images/info.png" alt="info" align="middle" name="info" border="0" /></a>
        <?php echo $lists['extra']; ?> </td>
                                    </tr><tr class="swmenu_menubackgr">
                                        <td ><?php echo  _SW_DELAY; ?>:</td>
                                        <td><div align="right">
                                                <input id="specialB" name="specialB" type="text" value="<?php echo $rows->specialB; ?>" size="4" /> ms
                                            </div>
                                        </td>
                                    </tr><tr>
                                        <td ><?php echo _SW_SUB_MENU . " " . _SW_OPACITY; ?>:</td>
                                        <td><div align="right">
                                                <input id="specialA" name="specialA" type="text" value="<?php echo $rows->specialA; ?>" size="4" /> %&nbsp;
                                            </div>
                                        </td></tr>

                                   

                                </table></td>
                        </tr>
                    </table>
                </div>





                <div id="preview_pane" >


                    <table class="sw_inner_container" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="40%" class="swmenu_tabheading"> <div align="left">
                                    <a href="javascript:void(0)" onclick="doCompletePreview();"><img src="components/com_swmenufree/images/gtk_refresh.png" ><?php echo _SW_PREVIEW_REFRESH; ?></a></div></td>

                            <td width="20%" class="swmenu_tabheading"> <div align="center" style="font-size:14px;" ><?php echo _SW_LIVE_PREVIEW; ?></div></td>


                            <td class="swmenu_tabheading"> <div align="right"><?php echo _SW_PREVIEW_BACKGROUND; ?>

                                    <input  name="preview_background" onChange="jQuery('#preview_div').css('background-color',this.value);" type="text" id="preview_background" value="#FFFFFF" size="8" class="color {hash:true,required:false,pickerOnfocus:false,pickerClosable:true}"/>
                                    <a onMouseOver="this.style.cursor='pointer'" onClick="document.getElementById('preview_background').color.showPicker()"><img src="components/com_swmenufree/images/sel.gif"/><?php echo _SW_GET; ?></a></div>


                            </td>
                        </tr>
                    </table>

        <?php
        if (substr($rows->orientation, 0, 10) == "horizontal") {
            ?>
                        <div id="preview_div">

                            <table align="center"  border="0" cellpadding="10" cellspacing="0"><tr><td>
                                        <div id="top_preview_parent" ><div  id="top_preview_outer">

                                                <table border="0" cellpadding="0" cellspacing="0"><tr><td>
                                                            <div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal"><?php echo _SW_TOP_MENU_ITEM; ?></a></div></td><td>
                                                            <div  class="top_preview_item"><a class="top_preview" id="top_preview_hover"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_HOVER; ?></a></div></td><td>
                                                            <div  class="top_preview_item"><a class="top_preview" id="top_preview_active"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_ACTIVE; ?></a></div></td><td>
                                                            <div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal2"><?php echo _SW_TOP_MENU_ITEM; ?></a></div></td></tr></table>

                                            </div></div></td></tr></table><br /><br />

                            <table align="center" border="0" cellpadding="0" cellspacing="0"><tr><td>
                                        <div  id="sub_preview_parent"><div  id="sub_preview_outer">
                                                <a class="sub_preview normal" id="sub_preview_normal"><?php echo _SW_SUB_MENU_ITEM; ?></a>
                                                <a class="sub_preview" id="sub_preview_hover"><?php echo _SW_SUB_MENU_ITEM . " " . _SW_HOVER; ?></a>
                                                <a class="sub_preview normal" id="sub_preview_normal2"><?php echo _SW_SUB_MENU_ITEM; ?></a>
                                                <a class="sub_preview normal" id="sub_preview_normal3"><?php echo _SW_SUB_MENU_ITEM; ?></a>
                                            </div>
                                    </td></tr></table>
                        </div>

            <?php
        } else {
            ?>

                        <div id="preview_div">
                            <table align="center" width="100%" border="0" cellpadding="10" cellspacing="0"><tr><td align="center">
                                        <table border="0" cellpadding="0" cellspacing="0"><tr><td >
                                                    <div id="top_preview_parent" ><div  id="top_preview_outer">
                                                            <div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal"><?php echo _SW_TOP_MENU_ITEM; ?></a></div>
                                                            <div  class="top_preview_item"><a class="top_preview" id="top_preview_hover"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_HOVER; ?></a></div>
                                                            <div  class="top_preview_item"><a class="top_preview" id="top_preview_active"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_ACTIVE; ?></a></div>
                                                            <div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal2"><?php echo _SW_TOP_MENU_ITEM; ?></a></div>
                                                        </div></div></td></tr></table>
                                    </td><td width="50%" align="center">
                                        <table border="0" cellpadding="0" cellspacing="0"><tr><td>
                                                    <div id="sub_preview_parent" ><div  id="sub_preview_outer">
                                                            <a class="sub_preview normal" id="sub_preview_normal"  ><?php echo _SW_SUB_MENU_ITEM; ?></a>
                                                            <a class="sub_preview" id="sub_preview_hover"><?php echo _SW_SUB_MENU_ITEM . " " . _SW_HOVER; ?></a>
                                                            <a class="sub_preview normal" id="sub_preview_normal2"><?php echo _SW_SUB_MENU_ITEM; ?></a>
                                                            <a class="sub_preview normal" id="sub_preview_normal3"><?php echo _SW_SUB_MENU_ITEM; ?></a>
                                                        </div></div>
                                                </td></tr></table>
                                        </div>


        <?php } ?>





                                </td></tr>



                        </table>


                    </div>
                </div>

                <div id="top_preview_hidden" style="display:none;" ></div>







                <input type="hidden" name="title" id="title" value="<?php echo $row2->title; ?>" />
                <input type="hidden" id="border_hack" name="border_hack" value="0" />
                <input type="hidden" name="option" value="com_swmenufree" />
                <input type="hidden" name="tmpl" id="tmpl" value="index" />
                <input type="hidden" name="task" value="editdhtmlMenu" />     
                <input type="hidden" name="id" id="id" value="<?php echo $row2->id; ?>">
                <input type="hidden" name="top_font_face" id="top_font_face" value="<?php echo @$row2->top_font_face; ?>">
                <input type="hidden" name="sub_font_face" id="sub_font_face" value="<?php echo @$row2->sub_font_face; ?>">
                <input type="hidden" name="preview" value="dynamic" />
                <input type="hidden" name="export2" value="" />
                <input type="hidden" id="defaultfolder" name="defaultfolder" value="<?php echo @$row2->defaultfolder?$row2->defaultfolder:"swmenufree"; ?>" />
            </form>
        </div>

        <script language="JavaScript" type="text/javascript" src="components/com_swmenufree/js/wz_tooltip.js"></script>
        <script language="javascript" type="text/javascript">
            <!--
            dhtml.onTabStyle='swmenu_ontab';
            dhtml.offTabStyle='swmenu_offtab';
            dhtml.cycleTab('tab6');
            -->
        </script>


        <script type="text/javascript">
            <!--


            function change_orientation(){
                var str = document.getElementById('orientation').value;
                var orientation = str.substring(0,10);
                //alert(orientation);

                if(orientation=="horizontal"){
                    jQuery('#preview_div').html('<table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td>'
                        +'<div id="top_preview_parent" ><div  id="top_preview_outer"><table border="0" cellpadding="0" cellspacing="0" ><tr><td>'
                        +'<div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal"><?php echo _SW_TOP_MENU_ITEM; ?></a></div></td><td>'
                        +'<div  class="top_preview_item"><a class="top_preview" id="top_preview_hover"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_HOVER; ?></a></div></td><td>'
                        +'<div  class="top_preview_item"><a class="top_preview" id="top_preview_active"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_ACTIVE; ?></a></div></td><td>'
                        +'<div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal2"><?php echo _SW_TOP_MENU_ITEM; ?></a></div></td></tr></table>'
                        +'</div></div></td></tr></table><br /><br /><table align="center" border="0" cellpadding="0" cellspacing="0"><tr><td>'
                        +'<div id="sub_preview_parent" ><div  id="sub_preview_outer">'
                        +'<a class="sub_preview normal" id="sub_preview_normal"><?php echo _SW_SUB_MENU_ITEM; ?></a>'
                        +'<a class="sub_preview" id="sub_preview_hover"><?php echo _SW_SUB_MENU_ITEM . " " . _SW_HOVER; ?></a>'
                        +'<a class="sub_preview normal" id="sub_preview_normal2"><?php echo _SW_SUB_MENU_ITEM; ?></a>'
                        +'<a class="sub_preview normal" id="sub_preview_normal3"><?php echo _SW_SUB_MENU_ITEM; ?></a>'
                        +'</div></div></td></tr></table>'
                );
                }else{
                    jQuery('#preview_div').html('<table border="0" width="100%" cellpadding="10" cellspacing="0" align="center" ><tr><td align="center">'
                        +'<table border="0" cellpadding="0" cellspacing="0"><tr><td>'
                        +'<div id="top_preview_parent" ><div  id="top_preview_outer">'
                        +'<div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal"><?php echo _SW_TOP_MENU_ITEM; ?></a></div>'
                        +'<div  class="top_preview_item"><a class="top_preview" id="top_preview_hover"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_HOVER; ?></a></div>'
                        +'<div  class="top_preview_item"><a class="top_preview" id="top_preview_active"><?php echo _SW_TOP_MENU_ITEM . " " . _SW_ACTIVE; ?></a></div>'
                        +'<div  class="top_preview_item"><a class="top_preview normal" id="top_preview_normal2"><?php echo _SW_TOP_MENU_ITEM; ?></a></div>'
                        +'</div></div></td></tr></table></td><td align="center" width="50%">'
                        +'<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>'
                        +'<div id="sub_preview_parent" ><div  id="sub_preview_outer">'
                        +'<a class="sub_preview normal" id="sub_preview_normal"><?php echo _SW_SUB_MENU_ITEM; ?></a>'
                        +'<a class="sub_preview" id="sub_preview_hover"><?php echo _SW_SUB_MENU_ITEM . " " . _SW_HOVER; ?></a>'
                        +'<a class="sub_preview normal" id="sub_preview_normal2"><?php echo _SW_SUB_MENU_ITEM; ?></a>'
                        +'<a class="sub_preview normal" id="sub_preview_normal3"><?php echo _SW_SUB_MENU_ITEM; ?></a>'
                        +'</div></div></td></tr></table>'
                );



                }
                //doTopMargin;

                doCompletePreview();

            }



            //setTimeout('doShadow()',2000);
            //if(document.getElementById('top_ttf').value!=""){do_top_ttf();}
            //if(document.getElementById('sub_ttf').value!=""){do_sub_ttf();}
            //if(document.getElementById('c_corner_style').value!=""){do_complete_corner();}
            //if(document.getElementById('t_corner_style').value!=""){do_top_corner();}
            //if(document.getElementById('s_corner_style').value!=""){do_sub_corner();}
            //do_top_corner();

            jQuery('#toolbar-box').remove();
            //jQuery('.sw_inner_container').dropShadow();
            //jQuery('.sw_inner_container_header').dropShadow();
            //jQuery('.pagetext').dropShadow();
           // document.styleSheets[0].disabled = true;
           // jQuery("input").removeAttr('style');
              jQuery('.sw_manual_button').corner();
             jQuery('.sw_upgrade_button').corner();
            jQuery('.sw_inner_container_header').corner('tl tr');
            //doShadow();
            doSliders();
            doCompletePreview();
            //setTimeout('doShadow();',2000);
            //jQuery.noConflict();
            -->
        </script>

        <?php
    }
    
    
    
    function uploadCufon( ) {
	
?>
      
       
<script language="javascript" type="text/javascript">
	
        
        function uploadCufon() {
                var form = document.filename;
                // do field validation
                if (form.cufonfile.value == ""){
                    alert( "Not a valid font file" );
                } else {
                    form.task.value="upload_ttf";
                   // window.parent.jInsertCufon(form.cufonfile);
                    form.submit();
                }
            }
	
	
</script>
<link rel="stylesheet" type="text/css" href="components/com_swmenufree/css/swmenufree.css" />
	<div class="swmenu_container" >
	<form enctype="multipart/form-data" action="index.php" method="post" name="filename">
	


                                        <table cellpadding="4" align="left" cellspacing="4" style="border:1px solid #ccc;margin-top:4px;" width="100%">
                                            <tr><td  class="swmenu_tabheading" ><?php echo _SW_UPLOAD_TTF; ?></td></tr>
                                            <tr class="swmenu_menubackgr">
                                                <td><input class="text_area" name="cufonfile" type="file" size="50"/>
                                                    <input class="button" type="button" onclick="uploadCufon();" value="<?php echo _SW_UPLOAD_UPGRADE_BUTTON; ?>" /></td>
                                            </tr>
                                        </table>

              



<input type="hidden" name="task" value="upload_ttf"/>
<input type="hidden" name="tmpl" value="component"/>
<input type="hidden" name="option" value="com_swmenufree"/>

</form>
</div>
		<?php
	}


}
?>
