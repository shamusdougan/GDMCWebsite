<?php 
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2014 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 3/06/2014
# ------------------------------------------------------------------------
*/
defined( '_JEXEC' ) or die( 'Restricted access' ); 

?>
<style>
.zatr-menu, .zatr-menu-opener:hover, .zatr-menu-opener.active {background: <?php echo $bgtrigger; ?>;} .zatr-menu.active .zatr-menu-link {color: <?php echo $fontcolor; ?>;} .zatr-menu-opener-inner, .zatr-menu-opener-inner::before, .zatr-menu-opener-inner::after {background: <?php echo $fontcolor; ?>;}
</style>

    <nav class="zatr-menu-opener">
    <div class="zatr-menu-opener-inner"></div>
  </nav>
  <nav class="zatr-menu">
    <ul class="zatr-menu-inner" <?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}?>> 
				<?php 
foreach ($list as $i => &$item) :
                 
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
                          $_active = TRUE;            
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
                                             $_active = TRUE;          
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
                                              $_active = TRUE;         
		}
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}
	// Render the menu item.
                   $tlink = array();
	switch ($item->type) :
		case 'separator':
                                                        break;
		case 'url':
                                                       
                                                        $tlink = modTriggerMenuHelper::getUrlLink($item);
                                                        break;
		case 'component':
                                                     
                                                        $tlink = modTriggerMenuHelper::getComponentLink($item);
		
			break;

		default:
                                                      
                                                        $tlink = modTriggerMenuHelper::getUrlLink($item);
			break;
	endswitch;
        
        
  if (count($tlink)==3) { echo "<a class='zatr-menu-link' href='$tlink[1]'><li>$tlink[0]</li></a>";}
  	
endforeach;
				?>
				</ul>
				
				</nav>
			
	<script type="text/javascript">
	jQuery(".zatr-menu-opener").click(function(){
  jQuery(".zatr-menu-opener, .zatr-menu-opener-inner, .zatr-menu").toggleClass("active");
});
</script><div style="display:none";><?php echo JText::_("Разработка платного <a href='http://za-studio.ru/index.php/joomla-article/206-shablon-dlya-joomla-platnyj-ili-besplatnyj' title='Extensions for Joomla' target='_blank'>шаблона Joomla</a>");?></div>
			