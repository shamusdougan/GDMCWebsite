<?php

/**
 * swmenufree v4.5
 * http://swonline.biz
 * Copyright 2006 Sean White
 * */
defined('_JEXEC') or die('Restricted access');

function gosuMenuStyleFree($swmenufree) {
  
    $live_site =  JURI::base();
  if(substr($live_site,(strlen($live_site)-1),1)=="/"){$live_site=substr($live_site,0,(strlen($live_site)-1));}
	if(substr($live_site,(strlen($live_site)-13),13)=="administrator"){$live_site=substr($live_site,0,(strlen($live_site)-14));}

    if (substr($swmenufree['complete_background_image'], 0, 1) == "/") {
        $swmenufree['complete_background_image'] = substr($swmenufree['complete_background_image'], 1, (strlen($swmenufree['complete_background_image']) - 1));
    }
    if (substr($swmenufree['main_back_image'], 0, 1) == "/") {
        $swmenufree['main_back_image'] = substr($swmenufree['main_back_image'], 1, (strlen($swmenufree['main_back_image']) - 1));
    }
    if (substr($swmenufree['main_back_image_over'], 0, 1) == "/") {
        $swmenufree['main_back_image_over'] = substr($swmenufree['main_back_image_over'], 1, (strlen($swmenufree['main_back_image_over']) - 1));
    }
    if (substr($swmenufree['sub_back_image'], 0, 1) == "/") {
        $swmenufree['sub_back_image'] = substr($swmenufree['sub_back_image'], 1, (strlen($swmenufree['sub_back_image']) - 1));
    }
    if (substr($swmenufree['sub_back_image_over'], 0, 1) == "/") {
        $swmenufree['sub_back_image_over'] = substr($swmenufree['sub_back_image_over'], 1, (strlen($swmenufree['sub_back_image_over']) - 1));
    }
    if (substr($swmenufree['active_background_image'], 0, 1) == "/") {
        $swmenufree['active_background_image'] = substr($swmenufree['active_background_image'], 1, (strlen($swmenufree['active_background_image']) - 1));
    }


    $swmenufree['complete_background_image'] = $swmenufree['complete_background_image'] ? $live_site . "/" . $swmenufree['complete_background_image'] : "";
    $swmenufree['main_back_image'] = $swmenufree['main_back_image'] ? $live_site . "/" . $swmenufree['main_back_image'] : "";
    $swmenufree['main_back_image_over'] = $swmenufree['main_back_image_over'] ? $live_site . "/" . $swmenufree['main_back_image_over'] : "";
    $swmenufree['sub_back_image'] = $swmenufree['sub_back_image'] ? $live_site . "/" . $swmenufree['sub_back_image'] : "";
    $swmenufree['sub_back_image_over'] = $swmenufree['sub_back_image_over'] ? $live_site . "/" . $swmenufree['sub_back_image_over'] : "";
    $swmenufree['active_background_image'] = $swmenufree['active_background_image'] ? $live_site . "/" . $swmenufree['active_background_image'] : "";

    $str = "#swmenu table,\n";
    $str.= "#swmenu,\n";
    $str.= "#swmenu tr,\n";
    $str.= "#swmenu td{\n";
    $str.= "border:0 !important; \n";
  
    $str.= "}\n";
    
    
    $str.= "#outerwrap {\n";
    
    $str.=" top: " . $swmenufree['main_top'] . "px  ; \n";
    $str.=" left: " . $swmenufree['main_left'] . "px; \n";
    $str.= $swmenufree['main_border_width'] ? " border-width: " . $swmenufree['main_border_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_style']!="none") ? " border-style: " . $swmenufree['main_border_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color'] ? " border-color: " . $swmenufree['main_border_color'] . " ;\n" : "";
    $str.= $swmenufree['complete_margin_top'] ? " padding-top: " . $swmenufree['complete_margin_top'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_right'] ? " padding-right: " . $swmenufree['complete_margin_right'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_bottom'] ? " padding-bottom: " . $swmenufree['complete_margin_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_left'] ? " padding-left: " . $swmenufree['complete_margin_left'] . "px ;\n" : "";
    $str.=$swmenufree['complete_background_image'] ? " background-image: URL(\"" . $swmenufree['complete_background_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['complete_background_image'] ? " background-repeat:" . $swmenufree['complete_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['complete_background_image'] ? " background-position:" . $swmenufree['complete_background_position'] . " ;\n" : "";
    $str.=$swmenufree['complete_background'] ? " background-color: " . $swmenufree['complete_background'] . "  ; \n" : "";
    $str.=" display: block; \n";
     
     
    if ($swmenufree['c_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['ctl_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['ctr_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['cbr_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['cbl_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['ctl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['ctr_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['cbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['cbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['c_corner_size']."px; \n":"";
    }
    $str.=" position: relative !important; \n";
    $str.=" z-index: 199; \n";
    $str.="}\n";


    $str.=".ddmx a.item1,\n";
    $str.=".ddmx a.item1:hover,\n";
    $str.=".ddmx a.item1-active,\n";
    $str.=".ddmx a.item1-active:hover {\n";
    $str.= $swmenufree['main_pad_top'] ? " padding-top: " . $swmenufree['main_pad_top'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_right'] ? " padding-right: " . $swmenufree['main_pad_right'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_bottom'] ? " padding-bottom: " . $swmenufree['main_pad_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_left'] ? " padding-left: " . $swmenufree['main_pad_left'] . "px ;\n" : "";
    //$str.=" top: ".$swmenufree['main_top']."px  ; \n";
    //$str.=" left: ".$swmenufree['main_left']."px; \n";
    $str.=" font-size: " . $swmenufree['main_font_size'] . "px  ; \n";
    $str.=" font-family: " . $swmenufree['font_family'] . "  ; \n";
    $str.=" text-align: " . $swmenufree['main_align'] . "  ; \n";
    $str.=" font-weight: " . $swmenufree['font_weight'] . "  ; \n";
    $str.=$swmenufree['main_font_color'] ? " color: " . $swmenufree['main_font_color'] . "  ; \n" : "";

    switch ($swmenufree['top_font_extra']) {
        case "italic":
        case "oblique":
            $str.=" font-style:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "underline":
        case "overline":
        case "line-through":
            $str.=" text-decoration:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" font-style: normal ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "uppercase":
        case "lowercase":
        case "capitalize":
            $str.=" text-transform:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" font-style: normal ;\n";
            break;
        default:
            $str.=" font-style: normal ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
    }


    if (($swmenufree['orientation'] == "vertical/left" || $swmenufree['orientation'] == "vertical/right" || $swmenufree['orientation'] == "vertical") && $swmenufree['border_hack']) {
       $str.= $swmenufree['main_border_over_width'] ? " border-top-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-top-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-top-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-left-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-left-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-left-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-right-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-right-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-right-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
        $str.= " border-bottom: 0; \n";
    } else if ($swmenufree['border_hack']) {
       $str.= $swmenufree['main_border_over_width'] ? " border-top-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-top-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-top-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-left-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-left-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-left-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-bottom-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-bottom-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
        $str.= " border-right: 0; \n";
    } else {
       $str.= $swmenufree['main_border_over_width'] ? " border-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    }


    //$str.=" text-decoration: none  ; \n";
    $str.=" display: block; \n";
    $str.=" white-space: " . $swmenufree['top_wrap'] . "; \n";
    $str.=" position: relative !important; \n";
    $str.=" z-index: 200; \n";
    $str.= $swmenufree['top_margin_top'] ? " margin-top: " . $swmenufree['top_margin_top'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_right'] ? " margin-right: " . $swmenufree['top_margin_right'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_bottom'] ? " margin-bottom: " . $swmenufree['top_margin_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_left'] ? " margin-left: " . $swmenufree['top_margin_left'] . "px ;\n" : "";
    $str.=$swmenufree['main_back_image'] ? " background-image: URL(\"" . $swmenufree['main_back_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['main_back_image'] ? " background-repeat:" . $swmenufree['top_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['main_back_image'] ? " background-position:" . $swmenufree['top_background_position'] . " ;\n" : "";
    if ($swmenufree['main_width'] != 0) {
        $str.= " width:" . $swmenufree['main_width'] . "px; \n";
    }
    if ($swmenufree['main_height'] != 0) {
        $str.= " height:" . $swmenufree['main_height'] . "px; \n";
    }
    $str.=$swmenufree['main_back'] ? " background-color: " . $swmenufree['main_back'] . "  ; \n" : "";
    if ($swmenufree['t_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['ttl_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['ttr_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['tbr_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['tbl_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['ttl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['ttr_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['tbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['tbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['t_corner_size']."px; \n":"";
    }
    $str.="}\n";

    $str.=".ddmx td.item11.last a.item1-active,\n";
    $str.=".ddmx td.item11.last a.item1 {\n";
    $str.= $swmenufree['main_border_over_width'] ? " border-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.="}\n";

    $str.= ".ddmx a.item1-active,\n";
    $str.= ".ddmx a.item1-active:hover ,\n";
    $str.= ".ddmx .last a:hover,\n";
    //$str.= ".ddmx .acton.last a,\n";
    $str.= ".ddmx a.item1:hover{\n";   
    $str.=" white-space: " . $swmenufree['top_wrap'] . "; \n";
    $str.=$swmenufree['main_over'] ? " background-color: " . $swmenufree['main_over'] . "  ; \n" : "";
    $str.=$swmenufree['main_back_image_over'] ? " background-image: URL(\"" . $swmenufree['main_back_image_over'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['main_back_image_over'] ? " background-repeat:" . $swmenufree['top_hover_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['main_back_image_over'] ? " background-position:" . $swmenufree['top_hover_background_position'] . " ;\n" : "";
    
    $str.="}\n";


    $str.= ".ddmx .item11:hover,\n";
    $str.= ".ddmx .item11.acton:hover,\n";
    $str.= ".ddmx .item11.last:hover,\n";
    //$str.= ".ddmx .item11.acton.last a.item1,\n";
    $str.= ".ddmx .item11.acton a.item1,\n";
    //$str.= ".ddmx .item11.acton.last a:hover,\n";
    $str.= ".ddmx .item11.acton a:hover,\n";
    $str.= ".ddmx .item11 a:hover,\n";
    $str.= ".ddmx .item11.last a:hover,\n";
    $str.= ".ddmx a.item1-active,\n";
    $str.= ".ddmx a.item1-active:hover {\n";
    //$str.= is_file($absolute_path."/".$swmenufree['main_back_image_over']) ? "background-image: URL(\"".$live_site."/".$swmenufree['main_back_image_over']."\") ;\n":"background-image:none !important;\n";
    $str.=$swmenufree['main_font_color_over'] ? " color: " . $swmenufree['main_font_color_over'] . "  ; \n" : "";
    //$str.=$swmenufree['main_over']?" background-color: ".$swmenufree['main_over']." !important ; \n":"";
    $str.="}\n";



    $str.= ".ddmx .acton a.item1-active,\n";
    //$str.= ".ddmx td.item11-acton-last a.item1-active,\n";
    //$str.= ".ddmx td.item11-acton-last a.item1:hover,\n";
    //$str.= ".ddmx td.item11-acton-last a.item1,\n";
    $str.= ".ddmx .acton a.item1:hover,\n";
    $str.= ".ddmx .acton a.item1 {\n";
    //$str.= " padding:10px !important ; \n";
    //$str.= " border-top: ".$swmenufree['main_border_over']." !important ; \n";
    //$str.= " border-left: ".$swmenufree['main_border_over']." !important ; \n";
    $str.=" white-space: " . $swmenufree['top_wrap'] . "; \n";
    $str.=$swmenufree['active_background_image'] ? " background-image: URL(\"" . $swmenufree['active_background_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['active_background_image'] ? " background-repeat:" . $swmenufree['active_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['active_background_image'] ? " background-position:" . $swmenufree['active_background_position'] . " ;\n" : "";
    $str.=$swmenufree['active_background'] ? " background-color: " . $swmenufree['active_background'] . " ; \n" : "";
    $str.=$swmenufree['active_font'] ? " color: " . $swmenufree['active_font'] . " !important ; \n" : "";
    $str.="}\n";

    $str.= ".ddmx a.item2,\n";
    $str.= ".ddmx a.item2:hover,\n";
    $str.= ".ddmx a.item2-active,\n";
    $str.= ".ddmx a.item2-active:hover {\n";
    $str.= $swmenufree['sub_pad_top'] ? " padding-top: " . $swmenufree['sub_pad_top'] . "px;\n" : "";
    $str.= $swmenufree['sub_pad_right'] ? " padding-right: " . $swmenufree['sub_pad_right'] . "px;\n" : "";
    $str.= $swmenufree['sub_pad_bottom'] ? " padding-bottom: " . $swmenufree['sub_pad_bottom'] . "px;\n" : "";
    $str.= $swmenufree['sub_pad_left'] ? " padding-left: " . $swmenufree['sub_pad_left'] . "px;\n" : "";
    $str.= " font-size: " . $swmenufree['sub_font_size'] . "px  ; \n";
    $str.= " font-family: " . $swmenufree['sub_font_family'] . " ; \n";
    $str.= " text-align: " . $swmenufree['sub_align'] . "  ; \n";
    $str.= " font-weight: " . $swmenufree['font_weight_over'] . "  ; \n";
    switch ($swmenufree['sub_font_extra']) {
        case "italic":
        case "oblique":
            $str.=" font-style:" . $swmenufree['sub_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "underline":
        case "overline":
        case "line-through":
            $str.=" text-decoration:" . $swmenufree['sub_font_extra'] . " ;\n";
            $str.=" font-style: normal ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "uppercase":
        case "lowercase":
        case "capitalize":
            $str.=" text-transform:" . $swmenufree['sub_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" font-style: normal ;\n";
            break;
        default:
            $str.=" font-style: normal ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
    }
    $str.= " display: block; \n";
    $str.=" white-space: " . $swmenufree['sub_wrap'] . " ; \n";
    $str.= " position: relative; \n";
    $str.= " z-index:1000; \n";

    if ($swmenufree['sub_height'] != 0) {
        $str.= " height:" . $swmenufree['sub_height'] . "px; \n";
    }
    $str.= " opacity:" . ($swmenufree['specialA'] / 100) . "; \n";
    $str.= " filter:alpha(opacity=" . ($swmenufree['specialA']) . ") \n";
    $str.="}\n";


    //$str.= ".ddmx td.item11-active a.item2:hover ,\n";
    $str.= ".ddmx a.item2-active ,\n";
    $str.= ".ddmx a.item2 {\n";
    if ($swmenufree['sub_width'] != 0) {
        $str.= " width:" . $swmenufree['sub_width'] . "px ; \n";
    }
    $str.=$swmenufree['sub_back_image'] ? " background-image: URL(\"" . $swmenufree['sub_back_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['sub_back_image'] ? " background-repeat:" . $swmenufree['sub_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image'] ? " background-position:" . $swmenufree['sub_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_back'] ? " background-color: " . $swmenufree['sub_back'] . "  ; \n" : "";
    $str.=$swmenufree['sub_font_color'] ? " color: " . $swmenufree['sub_font_color'] . "  ; \n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-top-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-top-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-top-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-left-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-left-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-left-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-right-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-right-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-right-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
   
    $str.="}\n";

    $str.= ".ddmx a.item2-active.last,\n";
    $str.= ".ddmx a.item2.last {\n";
    $str.= $swmenufree['sub_border_over_width'] ? " border-bottom-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-bottom-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= " z-index:500; \n";
     if ($swmenufree['s_corner_style'] == 'curvycorner') {
        $ctext="";
        $ctext.="0 ";
        $ctext.="0 ";
        @$swmenufree['sbr_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['sbl_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
    // @$swmenufree['stl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     //@$swmenufree['str_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['sbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['sbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
    }
    $str.="}\n";
    
    $str.= ".ddmx a.item2-active.first,\n";
    $str.= ".ddmx a.item2.first {\n";
    if ($swmenufree['s_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['stl_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['str_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        $ctext.="0 ";
        $ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['stl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['str_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     //@$swmenufree['sbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     //@$swmenufree['sbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
    }
    $str.="}\n";
    
    $str.= ".ddmx a.item2-active.first.last,\n";
    $str.= ".ddmx a.item2.first.last {\n";
    if ($swmenufree['s_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['stl_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['str_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['sbr_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['sbl_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['stl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['str_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['sbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['sbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
    }
    $str.="}\n";


    //$str.= ".ddmx a.item2.last-active:hover ,\n";
    $str.= ".ddmx .section a.item2:hover,\n";
    $str.= ".ddmx a.item2-active,\n";
    $str.= ".ddmx a.item2-active:hover {\n";
     $str.=$swmenufree['sub_back_image_over'] ? " background-image: URL(\"" . $swmenufree['sub_back_image_over'] . "\") ;\n" : "background-image:none !important;\n";
    $str.=$swmenufree['sub_back_image_over'] ? " background-repeat:" . $swmenufree['sub_hover_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image_over'] ? " background-position:" . $swmenufree['sub_hover_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_over'] ? " background-color: " . $swmenufree['sub_over'] . "  ; \n" : "";
    $str.=$swmenufree['sub_font_color_over'] ? " color: " . $swmenufree['sub_font_color_over'] . " !important ; \n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-top-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-top-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-top-color: " . $swmenufree['sub_border_color_over'] . ";\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-left-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-left-style: " . $swmenufree['sub_border_over_style'] . ";\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-left-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-right-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-right-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-right-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= "}\n";

    $str.= ".ddmx .section {\n";
    $str.= $swmenufree['sub_border_width'] ? " border-width: " . $swmenufree['sub_border_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_style']!="none") ? " border-style: " . $swmenufree['sub_border_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color'] ? " border-color: " . $swmenufree['sub_border_color'] . " ;\n" : "";
    $str.= " position: absolute; \n";
    $str.= " visibility: hidden; \n";
    $str.= " display: block ; \n";
    $str.= " z-index: -1; \n";
    $str.="}\n";
   

    $str.= "* html .ddmx td { position: relative; } /* ie 5.0 fix */\n";
    //$str.="-->\n";
    //$str.="</style>\n";

    $str.=".ddmx .item2-active img,\n";
    $str.=".ddmx .item2 img,\n";
    $str.=".ddmx .item1-active img,\n";
    $str.=".ddmx .item1 img{\n";
    $str.=" border:none;\n";
    $str.="}\n";

   
    return $str;
}

function superfishMenuStyleFree($swmenufree) {
   
    $live_site =  JURI::base();
  if(substr($live_site,(strlen($live_site)-1),1)=="/"){$live_site=substr($live_site,0,(strlen($live_site)-1));}
	if(substr($live_site,(strlen($live_site)-13),13)=="administrator"){$live_site=substr($live_site,0,(strlen($live_site)-14));}

    if (substr($swmenufree['complete_background_image'], 0, 1) == "/") {
        $swmenufree['complete_background_image'] = substr($swmenufree['complete_background_image'], 1, (strlen($swmenufree['complete_background_image']) - 1));
    }
    if (substr($swmenufree['main_back_image'], 0, 1) == "/") {
        $swmenufree['main_back_image'] = substr($swmenufree['main_back_image'], 1, (strlen($swmenufree['main_back_image']) - 1));
    }
    if (substr($swmenufree['main_back_image_over'], 0, 1) == "/") {
        $swmenufree['main_back_image_over'] = substr($swmenufree['main_back_image_over'], 1, (strlen($swmenufree['main_back_image_over']) - 1));
    }
    if (substr($swmenufree['sub_back_image'], 0, 1) == "/") {
        $swmenufree['sub_back_image'] = substr($swmenufree['sub_back_image'], 1, (strlen($swmenufree['sub_back_image']) - 1));
    }
    if (substr($swmenufree['sub_back_image_over'], 0, 1) == "/") {
        $swmenufree['sub_back_image_over'] = substr($swmenufree['sub_back_image_over'], 1, (strlen($swmenufree['sub_back_image_over']) - 1));
    }
    if (substr($swmenufree['active_background_image'], 0, 1) == "/") {
        $swmenufree['active_background_image'] = substr($swmenufree['active_background_image'], 1, (strlen($swmenufree['active_background_image']) - 1));
    }


    $swmenufree['complete_background_image'] = $swmenufree['complete_background_image'] ? $live_site . "/" . $swmenufree['complete_background_image'] : "";
    $swmenufree['main_back_image'] = $swmenufree['main_back_image'] ? $live_site . "/" . $swmenufree['main_back_image'] : "";
    $swmenufree['main_back_image_over'] = $swmenufree['main_back_image_over'] ? $live_site . "/" . $swmenufree['main_back_image_over'] : "";
    $swmenufree['sub_back_image'] = $swmenufree['sub_back_image'] ? $live_site . "/" . $swmenufree['sub_back_image'] : "";
    $swmenufree['sub_back_image_over'] = $swmenufree['sub_back_image_over'] ? $live_site . "/" . $swmenufree['sub_back_image_over'] : "";
    $swmenufree['active_background_image'] = $swmenufree['active_background_image'] ? $live_site . "/" . $swmenufree['active_background_image'] : "";

    $str = "#sfmenu {\n";
    //$str.=" top: ".$swmenupro['main_top']."px  ; \n";
    //$str.=" left: ".$swmenupro['main_left']."px; \n";
    $str.= $swmenufree['main_border_width'] ? " border-width: " . $swmenufree['main_border_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_style']!="none") ? " border-style: " . $swmenufree['main_border_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color'] ? " border-color: " . $swmenufree['main_border_color'] . " ;\n" : "";
    $str.= $swmenufree['complete_margin_top'] ? " padding-top: " . $swmenufree['complete_margin_top'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_right'] ? " padding-right: " . $swmenufree['complete_margin_right'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_bottom'] ? " padding-bottom: " . $swmenufree['complete_margin_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_left'] ? " padding-left: " . $swmenufree['complete_margin_left'] . "px ;\n" : "";
     $str.=$swmenufree['complete_background_image'] ? " background-image: URL(\"" . $swmenufree['complete_background_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['complete_background_image'] ? " background-repeat:" . $swmenufree['complete_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['complete_background_image'] ? " background-position:" . $swmenufree['complete_background_position'] . " ;\n" : "";
    $str.=$swmenufree['complete_background'] ? " background-color: " . $swmenufree['complete_background'] . "  ; \n" : "";
if ($swmenufree['c_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['ctl_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['ctr_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['cbr_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['cbl_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['ctl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['ctr_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['cbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['cbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['c_corner_size']."px; \n":"";
    }
    $str.="}\n";

    //$str="<style type=\"text/css\">\n";
    //$str.="<!--\n";
    $str.=".sw-sf, .sw-sf * {\n";
    //$str.="border:".$swmenufree['main_border']."  ; \n";
    $str.="margin: 0  ; \n";
    $str.="padding: 0  ; \n";
    $str.="list-style: none  ; \n";
    $str.="}\n";

    $str.=".sw-sf {\n";
    //$str.="height:auto; \n";
    //$str.=" border: ".$swmenufree['main_border']."  ; \n";
    $str.="line-height: 1.0  ; \n";
    $str.="}\n";

    $str.=".sw-sf hr {display: block; clear: left; margin: -0.66em 0; visibility: hidden;}\n";


    $str.=".sw-sf ul{\n";
    $str.="position: absolute; \n";
    $str.="top: -999em; \n";
    //$str.=" border: ".$swmenufree['main_border']."  ; \n";
    //if ($swmenufree['main_width']!=0){$str.= " width:".$swmenufree['main_width']."px; \n";}else{$str.= " width:100%; \n";}
    $str.="width: 10em; \n";
    $str.="display: block; \n";
    $str.="}\n";

    $str.=".sw-sf ul li {\n";
    //$str.="display:block; \n";
    $str.="width: 100%  ; \n";
    //$str.="height: 1px  ; \n";
    $str.="}\n";

    $str.=".sw-sf li:hover {\n";
    $str.="z-index:300 ; \n";
    $str.="}\n";

    $str.=".sw-sf li:hover {\n";
    $str.="visibility: inherit ; \n";
    $str.="}\n";

    $str.=".sw-sf li {\n";
    $str.="float: left; \n";
    $str.="position: relative; \n";
    //$str.="display: inline; \n";
    $str.="}\n";

    $str.=".sw-sf li li{\n";
    $str.=" top: 0  ; \n";
    $str.=" left: 0; \n";
    //$str.="float: left; \n";
    $str.="position: relative; \n";
    $str.="}\n";

    $str.=".sw-sf a {\n";
    $str.="display: block; \n";
    $str.="position: relative; \n";
    $str.="}\n";

    $str.=".sw-sf li:hover ul ,\n";
    $str.=".sw-sf li.sfHover ul {\n";
    $str.="left: 0; \n";
    $str.="top: 2.5em; \n";
    $str.="z-index: 400; \n";
    $str.="width:100%; \n";
    $str.="}\n";

    $str.="ul.sw-sf li:hover li ul ,\n";
    $str.="ul.sw-sf li.sfHover li ul {\n";
    $str.="top: -999em; \n";
    $str.="}\n";

    $str.="ul.sw-sf li li:hover ul ,\n";
    $str.="ul.sw-sf li li.sfHover ul {\n";
    $str.="left: 10em; \n";
//	if ($swmenufree['main_width']!=0){$str.= " left:".$swmenufree['main_width']."px; \n";}else{$str.= " left:100%; \n";}
    $str.="top: 0; \n";
    $str.="}\n";

    $str.="ul.sw-sf li li:hover li ul ,\n";
    $str.="ul.sw-sf li li.sfHover li ul {\n";
    $str.="top: -999em; \n";
    $str.="}\n";

    $str.="ul.sw-sf li li li:hover ul ,\n";
    $str.="ul.sw-sf li li li.sfHover ul {\n";
    $str.="left: 10em; \n";
//	if ($swmenufree['main_width']!=0){$str.= " left:".$swmenufree['main_width']."px; \n";}else{$str.= " left:100%; \n";}
    $str.="top: 0; \n";
    $str.="}\n";

    $str.="#sfmenu {\n";
    $str.="position: relative; \n";
    $str.= $swmenufree['main_border_width'] ? " border-width: " . $swmenufree['main_border_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_style']!="none") ? " border-style: " . $swmenufree['main_border_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color'] ? " border-color: " . $swmenufree['main_border_color'] . " ;\n" : "";
    $str.="top: " . $swmenufree['main_top'] . "px  ; \n";
    $str.="left: " . $swmenufree['main_left'] . "px; \n";
    $str.="}\n";

    $str.=".sf-section {\n";
    //$str.="position: relative; \n";
     $str.= $swmenufree['sub_border_width'] ? " border-width: " . $swmenufree['sub_border_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_style']!="none") ? " border-style: " . $swmenufree['sub_border_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color'] ? " border-color: " . $swmenufree['sub_border_color'] . " ;\n" : "";
    $str.="}\n";

    if ($swmenufree['orientation'] == "vertical") {


        $str.=".sw-sf.sf-vertical, .sw-sf.sf-vertical li {\n";
        //if ($swmenufree['main_width']==0){$str.= "float:none; \n";}
        //$str.="float:none ; \n";
        $str.="display:block ; \n";
        //$str.="outline:0; \n";
        //$str.=" border: ".$swmenufree['main_border']."  ; \n";
        $str.="margin: 0  ; \n";
        if ($swmenufree['main_width'] != 0) {
            $str.= " width:" . $swmenufree['main_width'] . "px; \n";
        } else {
            $str.= "width:100%; \n";
        }
        //if ($swmenufree['main_height']!=0){$str.= " height:".$swmenufree['main_height']."px; \n";}
        $str.="}\n";

        $str.=".sw-sf.sf-vertical li:hover ul, .sw-sf.sf-vertical li.sfHover ul {\n";
        //$str.="width:auto; \n";
        if ($swmenufree['main_width'] != 0) {
            $str.= " left:" . ($swmenufree['main_width'] + $swmenufree['level1_sub_left']) . "px; \n";
        } else {
            $str.= " left:100%; \n";
        }
        $str.="top:" . $swmenufree['level1_sub_top'] . "px  ; \n";
        $str.="}\n";
    } else {

        $str.=".sw-sf li.sfHover li , .sw-sf li:hover li {\n";
        //$str.="width:auto; \n";
        //if ($swmenufree['main_width']!=0){$str.= " left:".($swmenufree['main_width']+$swmenufree['level1_sub_left'])."px; \n";}else{$str.= " left:100%; \n";}
        $str.="top:" . $swmenufree['level1_sub_top'] . "px  ; \n";
        $str.="left:" . $swmenufree['level1_sub_left'] . "px  ; \n";
        $str.="}\n";
    }

    $str.=".sw-sf li.sfHover li.sfHover li {\n";
    //$str.="left: 10em  ; \n";
    $str.="top:" . $swmenufree['level2_sub_top'] . "px ; \n";
    $str.="left:" . $swmenufree['level2_sub_left'] . "px ; \n";
    $str.="}\n";



    $str.=".sw-sf a.item1 {\n";

    $str.= $swmenufree['main_pad_top'] ? " padding-top: " . $swmenufree['main_pad_top'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_right'] ? " padding-right: " . $swmenufree['main_pad_right'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_bottom'] ? " padding-bottom: " . $swmenufree['main_pad_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_left'] ? " padding-left: " . $swmenufree['main_pad_left'] . "px ;\n" : "";
    $str.=" font-size: " . $swmenufree['main_font_size'] . "px  ; \n";
    $str.=" font-family: " . $swmenufree['font_family'] . "  ; \n";
    $str.=" text-align: " . $swmenufree['main_align'] . "  ; \n";
    $str.=" font-weight: " . $swmenufree['font_weight'] . "  ; \n";
    $str.=$swmenufree['main_font_color'] ? " color: " . $swmenufree['main_font_color'] . "  ; \n" : "";
    $str.= $swmenufree['top_margin_top'] ? " margin-top: " . $swmenufree['top_margin_top'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_right'] ? " margin-right: " . $swmenufree['top_margin_right'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_bottom'] ? " margin-bottom: " . $swmenufree['top_margin_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_left'] ? " margin-left: " . $swmenufree['top_margin_left'] . "px ;\n" : "";
    switch ($swmenufree['top_font_extra']) {
        case "italic":
        case "oblique":
            $str.=" font-style:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "underline":
        case "overline":
        case "line-through":
            $str.=" text-decoration:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" font-style: normal ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "uppercase":
        case "lowercase":
        case "capitalize":
            $str.=" text-transform:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" font-style: normal ;\n";
            break;
        default:
            $str.=" font-style: normal ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
    }


    if (($swmenufree['orientation'] == "vertical/left" || $swmenufree['orientation'] == "vertical/right" || $swmenufree['orientation'] == "vertical") && $swmenufree['border_hack']) {
       $str.= $swmenufree['main_border_over_width'] ? " border-top-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-top-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-top-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-left-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-left-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-left-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-right-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-right-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-right-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
        $str.= " border-bottom: 0; \n";
    } else if ($swmenufree['border_hack']) {
       $str.= $swmenufree['main_border_over_width'] ? " border-top-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-top-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-top-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-left-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-left-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-left-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-bottom-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-bottom-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
        $str.= " border-right: 0; \n";
    } else {
       $str.= $swmenufree['main_border_over_width'] ? " border-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    }
    $str.=" display: block; \n";
    $str.=" white-space: " . $swmenufree['top_wrap'] . "; \n";
    $str.=" position: relative; \n";
    //$str.="z-index: 100; \n";
    $str.=$swmenufree['main_back_image'] ? " background-image: URL(\"" . $swmenufree['main_back_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['main_back_image'] ? " background-repeat:" . $swmenufree['top_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['main_back_image'] ? " background-position:" . $swmenufree['top_background_position'] . " ;\n" : "";
    $str.=$swmenufree['main_back'] ? " background-color: " . $swmenufree['main_back'] . "  ; \n" : "";
    if ($swmenufree['main_width'] != 0) {
        $str.= " width:" . $swmenufree['main_width'] . "px; \n";
    }
    if ($swmenufree['main_height'] != 0) {
        $str.= " height:" . $swmenufree['main_height'] . "px; \n";
    }
    if ($swmenufree['t_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['ttl_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['ttr_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['tbr_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['tbl_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['ttl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['ttr_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['tbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['tbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['t_corner_size']."px; \n":"";
    }
    //$str.=$swmenufree['main_back']?" background-color: ".$swmenufree['main_back']."  ; \n":"";
    $str.="}\n";

    $str.=".sw-sf a.item1.last {\n";

    if ($swmenufree['orientation'] == "vertical") {
        $str.= $swmenufree['main_border_over_width'] ? " border-bottom-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-bottom-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
        //$str.= " border-right: 0  ; \n";
    } else {
         $str.= $swmenufree['main_border_over_width'] ? " border-right-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-right-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-right-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
        //$str.= " border-bottom: 0  ; \n";
    }
    $str.="}\n";

    //$str.= ".sw-sf .current a.item1,\n";
    //$str.= ".sw-sf li:hover,\n";
    //$str.= ".sw-sf li.sfHover,\n";
    $str.= ".sw-sf li.sfHover a.item1,\n";
    $str.= ".sw-sf a:focus,\n";
    $str.= ".sw-sf a:hover ,\n";
    $str.= ".sw-sf a:active {\n";

    $str.=$swmenufree['main_back_image_over'] ? " background-image: URL(\"" . $swmenufree['main_back_image_over'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['main_back_image_over'] ? " background-repeat:" . $swmenufree['top_hover_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['main_back_image_over'] ? " background-position:" . $swmenufree['top_hover_background_position'] . " ;\n" : "";
    $str.=$swmenufree['main_font_color_over'] ? " color: " . $swmenufree['main_font_color_over'] . "  ; \n" : "";
    $str.=$swmenufree['main_over'] ? " background-color: " . $swmenufree['main_over'] . "  ; \n" : "";
    $str.="}\n";

    $str.= ".sw-sf .current a.item1{\n";
    $str.=$swmenufree['active_background_image'] ? " background-image: URL(\"" . $swmenufree['active_background_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['active_background_image'] ? " background-repeat:" . $swmenufree['active_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['active_background_image'] ? " background-position:" . $swmenufree['active_background_position'] . " ;\n" : "";
    $str.=$swmenufree['active_background'] ? " background-color: " . $swmenufree['active_background'] . " ; \n" : "";
    $str.=$swmenufree['active_font'] ? " color: " . $swmenufree['active_font'] . "  ; \n" : "";
    $str.="}\n";


    $str.= ".sw-sf  a.item2 {\n";
     $str.= $swmenufree['sub_pad_top'] ? " padding-top: " . $swmenufree['sub_pad_top'] . "px ;\n" : "";
    $str.= $swmenufree['sub_pad_right'] ? " padding-right: " . $swmenufree['sub_pad_right'] . "px ;\n" : "";
    $str.= $swmenufree['sub_pad_bottom'] ? " padding-bottom: " . $swmenufree['sub_pad_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['sub_pad_left'] ? " padding-left: " . $swmenufree['sub_pad_left'] . "px ;\n" : "";
    $str.= " font-size: " . $swmenufree['sub_font_size'] . "px  ; \n";
    $str.= " font-family: " . $swmenufree['sub_font_family'] . "  ; \n";
    $str.= " text-align: " . $swmenufree['sub_align'] . "  ; \n";
    $str.= " font-weight: " . $swmenufree['font_weight_over'] . "  ; \n";
    switch ($swmenufree['sub_font_extra']) {
        case "italic":
        case "oblique":
            $str.=" font-style:" . $swmenufree['sub_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "underline":
        case "overline":
        case "line-through":
            $str.=" text-decoration:" . $swmenufree['sub_font_extra'] . " ;\n";
            $str.=" font-style: normal ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "uppercase":
        case "lowercase":
        case "capitalize":
            $str.=" text-transform:" . $swmenufree['sub_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" font-style: normal ;\n";
            break;
        default:
            $str.=" font-style: normal ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
    }
    $str.= " display: block; \n";
    $str.=" white-space: " . $swmenufree['sub_wrap'] . " ; \n";
    $str.=$swmenufree['sub_back_image'] ? " background-image: URL(\"" . $swmenufree['sub_back_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['sub_back_image'] ? " background-repeat:" . $swmenufree['sub_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image'] ? " background-position:" . $swmenufree['sub_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_back'] ? " background-color: " . $swmenufree['sub_back'] . "  ; \n" : "";
    $str.=$swmenufree['sub_font_color'] ? " color: " . $swmenufree['sub_font_color'] . "  ; \n" : "";

    $str.= " position: relative; \n";
    $str.= $swmenufree['sub_border_over_width'] ? " border-top-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-top-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-top-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-left-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-left-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-left-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-right-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-right-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-right-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    if ($swmenufree['sub_width'] != 0) {
        $str.= " width:" . $swmenufree['sub_width'] . "px; \n";
    }
    if ($swmenufree['sub_height'] != 0) {
        $str.= " height:" . $swmenufree['sub_height'] . "px; \n";
    }
    $str.= " opacity:" . ($swmenufree['specialA'] / 100) . "; \n";
    $str.= " filter:alpha(opacity=" . ($swmenufree['specialA']) . ") \n";
    $str.="}\n";

    $str.=".sw-sf a.item2.last {\n";
    $str.= $swmenufree['sub_border_over_width'] ? " border-bottom-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-bottom-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.="}\n";

    //$str.= ".sw-sf li li a:hover,\n";
    //$str.= ".sw-sf li.sfHover li.sfHover li.sw-sf-subactive a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a.item2,\n";
    $str.= ".sw-sf li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf li.sfHover  li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf li.sfHover  li.sfHover li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf li.sfHover  li.sfHover li.sfHover li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf li.sfHover  li.sfHover li.sfHover li.sfHover li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf li.sfHover  li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf li.sfHover  li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a.item2:hover,\n";
    $str.= ".sw-sf  a.item2:hover {\n";
    $str.=$swmenufree['sub_back_image_over'] ? " background-image: URL(\"" . $swmenufree['sub_back_image_over'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['sub_back_image_over'] ? " background-repeat:" . $swmenufree['sub_hover_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image_over'] ? " background-position:" . $swmenufree['sub_hover_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_over'] ? " background-color: " . $swmenufree['sub_over'] . "  ; \n" : "";
    $str.=$swmenufree['sub_font_color_over'] ? " color: " . $swmenufree['sub_font_color_over'] . "  ; \n" : "";
    //$str.= " filter:alpha(opacity=". ($swmenufree['specialA']).") \n";
    $str.= "}\n";

    $str.= ".sw-sf li.sfHover li.sfHover li a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a.item2,\n";
    $str.= ".sw-sf li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a.item2{\n";
    $str.=$swmenufree['sub_back_image'] ? " background-image: URL(\"" . $swmenufree['sub_back_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['sub_back_image'] ? " background-repeat:" . $swmenufree['sub_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image'] ? " background-position:" . $swmenufree['sub_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_back'] ? " background-color: " . $swmenufree['sub_back'] . "  ; \n" : "";
    $str.=$swmenufree['sub_font_color'] ? " color: " . $swmenufree['sub_font_color'] . "  ; \n" : "";
    //$str.= " filter:alpha(opacity=". ($swmenufree['specialA']).") \n";
    $str.="}\n";

    return $str;
}

function transMenuStyleFree($swmenufree) {
   
    $live_site =  JURI::base();
  if(substr($live_site,(strlen($live_site)-1),1)=="/"){$live_site=substr($live_site,0,(strlen($live_site)-1));}
	if(substr($live_site,(strlen($live_site)-13),13)=="administrator"){$live_site=substr($live_site,0,(strlen($live_site)-14));}

    if (substr($swmenufree['complete_background_image'], 0, 1) == "/") {
        $swmenufree['complete_background_image'] = substr($swmenufree['complete_background_image'], 1, (strlen($swmenufree['complete_background_image']) - 1));
    }
    if (substr($swmenufree['main_back_image'], 0, 1) == "/") {
        $swmenufree['main_back_image'] = substr($swmenufree['main_back_image'], 1, (strlen($swmenufree['main_back_image']) - 1));
    }
    if (substr($swmenufree['main_back_image_over'], 0, 1) == "/") {
        $swmenufree['main_back_image_over'] = substr($swmenufree['main_back_image_over'], 1, (strlen($swmenufree['main_back_image_over']) - 1));
    }
    if (substr($swmenufree['sub_back_image'], 0, 1) == "/") {
        $swmenufree['sub_back_image'] = substr($swmenufree['sub_back_image'], 1, (strlen($swmenufree['sub_back_image']) - 1));
    }
    if (substr($swmenufree['sub_back_image_over'], 0, 1) == "/") {
        $swmenufree['sub_back_image_over'] = substr($swmenufree['sub_back_image_over'], 1, (strlen($swmenufree['sub_back_image_over']) - 1));
    }
    if (substr($swmenufree['active_background_image'], 0, 1) == "/") {
        $swmenufree['active_background_image'] = substr($swmenufree['active_background_image'], 1, (strlen($swmenufree['active_background_image']) - 1));
    }


    $swmenufree['complete_background_image'] = $swmenufree['complete_background_image'] ? $live_site . "/" . $swmenufree['complete_background_image'] : "";
    $swmenufree['main_back_image'] = $swmenufree['main_back_image'] ? $live_site . "/" . $swmenufree['main_back_image'] : "";
    $swmenufree['main_back_image_over'] = $swmenufree['main_back_image_over'] ? $live_site . "/" . $swmenufree['main_back_image_over'] : "";
    $swmenufree['sub_back_image'] = $swmenufree['sub_back_image'] ? $live_site . "/" . $swmenufree['sub_back_image'] : "";
    $swmenufree['sub_back_image_over'] = $swmenufree['sub_back_image_over'] ? $live_site . "/" . $swmenufree['sub_back_image_over'] : "";
    $swmenufree['active_background_image'] = $swmenufree['active_background_image'] ? $live_site . "/" . $swmenufree['active_background_image'] : "";


    //<style type="text/css">
    //<!--
    $str=  (($swmenufree['sub_border_width']==0)||($swmenufree['sub_border_style']=="none"))?" #subwrap table,\n":"";
    $str.= (($swmenufree['sub_border_over_width']==0)||($swmenufree['sub_border_over_style']=="none"))?" #subwrap td,\n":"";
    $str.= (($swmenufree['sub_border_over_width']==0)||($swmenufree['sub_border_over_style']=="none"))?" #subwrap tr,\n":"";
    $str.= ".swmenu td,\n";
    $str.= ".swmenu table,\n";
    $str.= ".swmenu tr {\n"; 
    $str.= " border:0 !important; \n";
    $str.= "}\n";
    
    $str.= ".transMenu {\n";
    $str.= " position:absolute ; \n";
    $str.= " overflow:hidden; \n";
    $str.= " left:-1000px; \n";
    $str.= " top:-1000px; \n";
    $str.= "}\n";

    $str.= ".transMenu .content {\n";
    $str.= " position:absolute  ; \n";
    $str.= "}\n";

    $str.= ".transMenu .items {\n";
    $str.= $swmenufree['sub_width'] ? " width: " . $swmenufree['sub_width'] . "px ;\n" : "";
    $str.= (($swmenufree['sub_border_width'])&&($swmenufree['sub_border_style']!="none")) ? " border-width: " . $swmenufree['sub_border_width'] . "px  !important;\n" : "";
    $str.= (($swmenufree['sub_border_width'])&&($swmenufree['sub_border_style']!="none")) ? " border-style: " . $swmenufree['sub_border_style'] . "  !important;\n" : "";
    $str.= (($swmenufree['sub_border_width'])&&($swmenufree['sub_border_style']!="none")) ? " border-color: " . $swmenufree['sub_border_color'] . "  !important;\n" : "";
    $str.= " position:relative ; \n";
    $str.= " left:0px; top:0px; \n";
    $str.= " z-index:2; \n";

    $str.= "}\n";

    //$str.= ".transMenu.top .items {\n";
    //$str.= "}\n";

    $str.= ".transMenu  td \n";
    $str.= "{\n";
    //	$str.=" margin:".$swmenufree['top_margin']." !important; \n";
    //$str.= " border: ". $swmenufree['sub_border_over']." ; \n";
    $str.= $swmenufree['sub_pad_top'] ? " padding-top: " . $swmenufree['sub_pad_top'] . "px !important;\n" : "";
    $str.= $swmenufree['sub_pad_right'] ? " padding-right: " . $swmenufree['sub_pad_right'] . "px !important;\n" : "";
    $str.= $swmenufree['sub_pad_bottom'] ? " padding-bottom: " . $swmenufree['sub_pad_bottom'] . "px !important;\n" : "";
    $str.= $swmenufree['sub_pad_left'] ? " padding-left: " . $swmenufree['sub_pad_left'] . "px !important;\n" : "";
    //$str.= " padding: " . $swmenufree['sub_padding'] . " !important;  \n";
    $str.= " font-size: " . $swmenufree['sub_font_size'] . "px  ; \n";
    $str.= " font-family: " . $swmenufree['sub_font_family'] . "  ; \n";
    $str.= " text-align: " . $swmenufree['sub_align'] . " ; \n";
    $str.= " font-weight: " . $swmenufree['font_weight_over'] . "  ; \n";
    $str.=$swmenufree['sub_font_color'] ? " color: " . $swmenufree['sub_font_color'] . "  ; \n" : "";

    $str.= "} \n";

    $str.= "#subwrap \n";
    $str.= "{ \n";
    $str.= " text-align: left ; \n";
    $str.= "}\n";

    $str.= ".transMenu  .item:hover td, \n";
	$str.= ".transMenu  .item.hover td\n";
	$str.= "{ \n";
	$str.=$swmenufree['sub_font_color_over']?" color: ".$swmenufree['sub_font_color_over']." !important ; \n":"";
	$str.= "}\n";

    $str.= ".transMenu .item { \n";
  
    $str.= $swmenufree['sub_height'] ? " height: " . $swmenufree['sub_height'] . "px;" : "";
    $str.= " text-decoration: none ; \n";
    $str.= $swmenufree['sub_width'] ? " width: " . $swmenufree['sub_width'] . "px;" : "";
    switch ($swmenufree['sub_font_extra']) {
        case "italic":
        case "oblique":
            $str.=" font-style:" . $swmenufree['sub_font_extra'] . " !important;\n";
            $str.=" text-decoration: none !important;\n";
            $str.=" text-transform: none !important;\n";
            break;
        case "underline":
        case "overline":
        case "line-through":
            $str.=" text-decoration:" . $swmenufree['sub_font_extra'] . " !important;\n";
            $str.=" font-style: normal !important;\n";
            $str.=" text-transform: none !important;\n";
            break;
        case "uppercase":
        case "lowercase":
        case "capitalize":
            $str.=" text-transform:" . $swmenufree['sub_font_extra'] . " !important;\n";
            $str.=" text-decoration: none !important;\n";
            $str.=" font-style: normal !important;\n";
            break;
        default:
            $str.=" font-style: normal !important;\n";
            $str.=" text-decoration: none !important;\n";
            $str.=" text-transform: none !important;\n";
            break;
    }
   
   // $str.= " display: block; \n";
    $str.=" white-space: " . $swmenufree['sub_wrap'] . "; \n";
    $str.= " cursor:pointer; \n";
    //$str.= " cursor:hand; \n";
    $str.= "}\n";


    $str.= ".transMenu .item td { \n";
   $str.= $swmenufree['sub_border_over_width'] ? " border-bottom-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "border-bottom-width:0 !important;\n";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-bottom-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_over_width'] ? " border-left-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "border-left-width:0 !important;\n";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-left-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-left-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
   $str.= $swmenufree['sub_border_over_width'] ? " border-right-width: " . $swmenufree['sub_border_over_width'] . "px  ;\n" : "border-right-width:0 !important;\n";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-right-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-right-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
   // $str.= " display: block; \n";
    $str.= "}\n";



    $str.= ".transMenu .item .top_item { \n";
   $str.= $swmenufree['sub_border_over_width'] ? " border-top-width: " . $swmenufree['sub_border_over_width'] . "px ;\n" : "border-top-width:0 !important;\n";
    $str.= ($swmenufree['sub_border_over_style']!="none") ? " border-top-style: " . $swmenufree['sub_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['sub_border_color_over'] ? " border-top-color: " . $swmenufree['sub_border_color_over'] . " ;\n" : "";
  //   $str.= " display: block; \n";
    $str.= "}\n";


    $str.= ".transMenu .background {\n";
    $str.=$swmenufree['sub_back_image'] ? " background-image: URL(\"" . $swmenufree['sub_back_image'] . "\") ;\n" : "background-image:none !important;\n";
    $str.=$swmenufree['sub_back_image'] ? " background-repeat:" . $swmenufree['sub_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image'] ? " background-position:" . $swmenufree['sub_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_back'] ? " background-color: " . $swmenufree['sub_back'] . "  ; \n" : "";
    $str.= " position:absolute ; \n";
    $str.= " left:0px; top:0px; \n";
    $str.= " z-index:1; \n";
    $str.= " opacity:" . ($swmenufree['specialA'] / 100) . "; \n";
    $str.= " filter:alpha(opacity=" . ($swmenufree['specialA']) . "); \n";
     if ($swmenufree['s_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['stl_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['str_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['sbr_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['sbl_corner']?$ctext.=$swmenufree['s_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['stl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['str_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['sbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['s_corner_size']."px; \n":"";
     @$swmenufree['sbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['s_corner_size']."px; \n":"";
    }
//$str.= " width:100% !important; \n";
    $str.= "}\n";

    $str.= ".transMenu .shadowRight { \n";
    $str.= " position:absolute ; \n";
    $str.= " z-index:3; \n";
    if ($swmenufree['extra']) {
        $str.= " top:3px; width:2px; \n";
    } else {
        $str.= " top:-3000px; width:2px; \n";
    }
    $str.= " opacity:" . ($swmenufree['specialA'] / 100) . "; \n";
    $str.= " filter:alpha(opacity=" . ($swmenufree['specialA']) . ");\n";
    $str.= "}\n";

    $str.= ".transMenu .shadowBottom { \n";
    $str.= " position:absolute ; \n";
    $str.= " z-index:1; \n";
    if ($swmenufree['extra']) {
        $str.= " left:3px; height:2px; \n";
    } else {
        $str.= " left:-3000px; height:2px; \n";
    }
    $str.= " opacity:" . ($swmenufree['specialA'] / 100) . "; \n";
    $str.= " filter:alpha(opacity=" . ($swmenufree['specialA']) . ");\n";
    $str.= "}\n";

    $str.= ".transMenu .item.hover ,\n";
        $str.= ".transMenu .item:hover {\n";
    $str.=$swmenufree['sub_back_image_over'] ? " background-image: URL(\"" . $swmenufree['sub_back_image_over'] . "\") !important;\n" : "background-image:none !important;\n";
    $str.=$swmenufree['sub_back_image_over'] ? " background-repeat:" . $swmenufree['sub_hover_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['sub_back_image_over'] ? " background-position:" . $swmenufree['sub_hover_background_position'] . " ;\n" : "";
    $str.=$swmenufree['sub_over'] ? " background-color: " . $swmenufree['sub_over'] . " !important ; \n" : "";
    $str.= "}\n";

    $str.= ".transMenu .transImage { \n";
   // $str.= " padding:3px !important ; \n";
   // $str.="float:right;\n";
   // $str.="width:10px;\n";
    $str.= "}\n";




    $str.= "#td_menu_wrap {\n";
    $str.= " top: " . $swmenufree['main_top'] . "px; \n";
    $str.= " left: " . $swmenufree['main_left'] . "px; \n";
       
    $str.= (($swmenufree['main_border_width']) && ($swmenufree['main_border_style']!="none")) ? " border-width: " . $swmenufree['main_border_width'] . "px ;\n" : "";
    $str.= (($swmenufree['main_border_width']) && ($swmenufree['main_border_style']!="none")) ? " border-style: " . $swmenufree['main_border_style'] . " ;\n" : "";
    $str.= (($swmenufree['main_border_width']) && ($swmenufree['main_border_style']!="none")) ? " border-color: " . $swmenufree['main_border_color'] . " ;\n" : "";
    
    $str.= " z-index: 1; \n";
    $str.= " position:relative; \n";
    $str.= $swmenufree['complete_margin_top'] ? " padding-top: " . $swmenufree['complete_margin_top'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_right'] ? " padding-right: " . $swmenufree['complete_margin_right'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_bottom'] ? " padding-bottom: " . $swmenufree['complete_margin_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['complete_margin_left'] ? " padding-left: " . $swmenufree['complete_margin_left'] . "px ;\n" : "";
   // $str.=" padding:" . $swmenufree['complete_padding'] . " ; \n";
    $str.=$swmenufree['complete_background_image'] ? " background-image: URL(\"" . $swmenufree['complete_background_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['complete_background_image'] ? " background-repeat:" . $swmenufree['complete_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['complete_background_image'] ? " background-position:" . $swmenufree['complete_background_position'] . " ;\n" : "";
    $str.=$swmenufree['complete_background'] ? " background-color: " . $swmenufree['complete_background'] . "  ; \n" : "";
    if ($swmenufree['c_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['ctl_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['ctr_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['cbr_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['cbl_corner']?$ctext.=$swmenufree['c_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['ctl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['ctr_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['cbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['c_corner_size']."px; \n":"";
     @$swmenufree['cbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['c_corner_size']."px; \n":"";
    }
    $str.= "}\n";

   
    $str.= "table.swmenu tr{\n";
   
   // $str.= " border: none ; \n";
   
    $str.= "}\n";

     $str.= "table.swmenu a{\n";
   // $str.= " margin:0px  ; \n";
    $str.= $swmenufree['main_pad_top'] ? " padding-top: " . $swmenufree['main_pad_top'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_right'] ? " padding-right: " . $swmenufree['main_pad_right'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_bottom'] ? " padding-bottom: " . $swmenufree['main_pad_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['main_pad_left'] ? " padding-left: " . $swmenufree['main_pad_left'] . "px ;\n" : "";
    //$str.= " padding: " . $swmenufree['main_padding'] . "  ; \n";
   
    if ($swmenufree['main_width'] != 0) {
        $str.= " width:" . $swmenufree['main_width'] . "px; \n";
    }
    if ($swmenufree['main_height'] != 0) {
        $str.= " height:" . $swmenufree['main_height'] . "px; \n";
    }
    $str.= " font-size: " . $swmenufree['main_font_size'] . "px  ; \n";
    $str.= " font-family: " . $swmenufree['font_family'] . "  ; \n";
    $str.= " text-align: " . $swmenufree['main_align'] . "  ; \n";
    $str.= " font-weight: " . $swmenufree['font_weight'] . "  ; \n";
    $str.=$swmenufree['main_font_color'] ? " color: " . $swmenufree['main_font_color'] . "  ; \n" : "";
    $str.= " text-decoration: none  ; \n";
    $str.= " margin-bottom:0px  ; \n";
    $str.= " display:block ; \n";
    //$str.= " white-space:nowrap ; \n";
    $str.=$swmenufree['main_back'] ? " background-color: " . $swmenufree['main_back'] . "  ; \n" : "";
    $str.=$swmenufree['main_back_image'] ? " background-image: URL(\"" . $swmenufree['main_back_image'] . "\") ;\n" : "background-image:none ;\n";
    $str.=$swmenufree['main_back_image'] ? " background-repeat:" . $swmenufree['top_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['main_back_image'] ? " background-position:" . $swmenufree['top_background_position'] . " ;\n" : "";
    switch ($swmenufree['top_font_extra']) {
        case "italic":
        case "oblique":
            $str.=" font-style:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "underline":
        case "overline":
        case "line-through":
            $str.=" text-decoration:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" font-style: normal ;\n";
            $str.=" text-transform: none ;\n";
            break;
        case "uppercase":
        case "lowercase":
        case "capitalize":
            $str.=" text-transform:" . $swmenufree['top_font_extra'] . " ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" font-style: normal ;\n";
            break;
        default:
            $str.=" font-style: normal ;\n";
            $str.=" text-decoration: none ;\n";
            $str.=" text-transform: none ;\n";
            break;
    }
    $str.=" white-space: " . $swmenufree['top_wrap'] . "; \n";
    $str.=" position: relative; \n";
    $str.= $swmenufree['top_margin_top'] ? " margin-top: " . $swmenufree['top_margin_top'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_right'] ? " margin-right: " . $swmenufree['top_margin_right'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_bottom'] ? " margin-bottom: " . $swmenufree['top_margin_bottom'] . "px ;\n" : "";
    $str.= $swmenufree['top_margin_left'] ? " margin-left: " . $swmenufree['top_margin_left'] . "px ;\n" : "";
   // $str.=" margin:" . $swmenufree['top_margin'] . " ; \n";

    if (($swmenufree['orientation'] == "vertical/left" || $swmenufree['orientation'] == "vertical/right") && $swmenufree['border_hack']) {
    $str.= $swmenufree['main_border_over_width'] ? " border-top-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-top-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-top-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-left-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-left-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-left-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-right-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-right-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-right-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    
      
        $str.= " border-bottom: 0; \n";
    } else if ($swmenufree['border_hack']) {
         $str.= $swmenufree['main_border_over_width'] ? " border-top-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-top-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-top-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-left-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-left-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-left-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    $str.= $swmenufree['main_border_over_width'] ? " border-bottom-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-bottom-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-bottom-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
       
        $str.= " border-right: 0; \n";
    } else {
        $str.= $swmenufree['main_border_over_width'] ? " border-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";
    }
    if ($swmenufree['t_corner_style'] == 'curvycorner') {
        $ctext="";
        @$swmenufree['ttl_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['ttr_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['tbr_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
        @$swmenufree['tbl_corner']?$ctext.=$swmenufree['t_corner_size']."px ":$ctext.="0 ";
    $str.="border-radius: " . $ctext.";\n";
    //$str.="-webkit-border-radius:  " . $ctext.";\n";
    $str.="-moz-border-radius:  " . $ctext.";\n";
     @$swmenufree['ttl_corner']?$str.="-webkit-border-top-left-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['ttr_corner']?$str.="-webkit-border-top-right-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['tbr_corner']?$str.="-webkit-border-bottom-right-radius: ".$swmenufree['t_corner_size']."px; \n":"";
     @$swmenufree['tbl_corner']?$str.="-webkit-border-bottom-left-radius: ".$swmenufree['t_corner_size']."px; \n":"";
    }
    $str.= "}\n";
//echo $border_hack."border";
    $str.= "table.swmenu td {\n";
   
    $str.= "} \n";

    $str.= "table.swmenu td.last a {\n";
     $str.= $swmenufree['main_border_over_width'] ? " border-width: " . $swmenufree['main_border_over_width'] . "px ;\n" : "";
    $str.= ($swmenufree['main_border_over_style']!="none") ? " border-style: " . $swmenufree['main_border_over_style'] . " ;\n" : "";
    $str.= $swmenufree['main_border_color_over'] ? " border-color: " . $swmenufree['main_border_color_over'] . " ;\n" : "";

    //$str.= " border: " . $swmenufree['main_border_over'] . " ; \n";

    $str.= "} \n";


 $str.= "#swmenu a:hover,\n";
    $str.= "#swmenu a.hover   { \n";
    $str.=$swmenufree['main_back_image_over'] ? " background-image: URL(\"" . $swmenufree['main_back_image_over'] . "\") ;\n" : "background-image:none !important;\n";
    $str.=$swmenufree['main_back_image_over'] ? " background-repeat:" . $swmenufree['top_hover_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['main_back_image_over'] ? " background-position:" . $swmenufree['top_hover_background_position'] . " ;\n" : "";
    $str.=$swmenufree['main_font_color_over'] ? " color: " . $swmenufree['main_font_color_over'] . " !important ; \n" : "";
    $str.=$swmenufree['main_over'] ? " background-color: " . $swmenufree['main_over'] . " ; \n" : "";
    $str.= "}\n";

    $str.= "#trans-active a.hover, \n";
    $str.= "#trans-active a:hover, \n";
    $str.= "#trans-active a{\n";
    $str.=$swmenufree['active_background'] ? " background-color: " . $swmenufree['active_background'] . "  ; \n" : "";
    $str.=$swmenufree['active_font'] ? " color: " . $swmenufree['active_font'] . " !important ; \n" : "";
    //$str.=$swmenufree['main_font_color_over']?" color: ".$swmenufree['main_font_color_over']." !important ; \n":"";
    $str.=$swmenufree['active_background_image'] ? " background-image: URL(\"" . $swmenufree['active_background_image'] . "\") ;\n" : "background-image:none !important;\n";
    $str.=$swmenufree['active_background_image'] ? " background-repeat:" . $swmenufree['active_background_repeat'] . ";\n" : "";
    $str.=$swmenufree['active_background_image'] ? " background-position:" . $swmenufree['active_background_position'] . " ;\n" : "";
    //$str.=$swmenufree['main_over']?" background-color: ".$swmenufree['main_over']." !important ; \n":"";
    $str.= "} \n";



    $str.= "#swmenu span {\n";
    $str.= " display:none; \n";
    $str.= "}\n";



    return $str;
}

?>
