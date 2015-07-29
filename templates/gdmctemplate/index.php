<?php


defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$menuID 		 = $app->getMenu()->getActive()->id;
$doc             = JFactory::getDocument();


JLoader::import('joomla.filesystem.file');


JHtml::_('bootstrap.framework');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template .'/css/site.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template .'/css/articles-display.css');
$doc->addScript($this->baseurl . '/templates/' . $this->template .'/js/jquery.cycle.lite.js');	
require_once __DIR__ . '/library.php';

//echo $this->baseurl . '/templates/' . $this->template .'/js/jquery.cycle.lite.js';

//place different backgrounds for different pages
$filelist = array();
$imagePath = "images/backgrounds/";
$imagePath2 = "images/background_blackwhite/";

if($menuID == 143) //principals	
	{
	$filelist[] = $imagePath2."street_view_bw.jpg";
	}
else{
	$filelist = get_backgroundlist();		
}	

		
	echo $menuID."<br>";


function isMobile() {
    
    return false;
    //return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<meta name="viewport" content="initial-scale=1.0">


<jdoc:include type="head" />

<script> 
	jQuery(document).ready(function(){

		jQuery("#top_menu_toggle").click(function() {
	   		jQuery("#sap_content_container").animate({
	            height: 'toggle'		
			});
			jQuery("#nav_icon").toggleClass("top_menu_up_arrow top_menu_down_arrow");
		});

	});
	
	
	
	
	 
	jQuery(document).ready(function() {
				jQuery('#slideshow').cycle({
				fx: 'fade',
				pager: '#smallnav', 
				pause:   1, 
				speed: 5000,
				timeout:  3500 
				});			
		});
		
	
	
</script> 


</head>
<body>




<div class='body_wrapper'>
	<div  class='top_menu'>
		<div class='top_menu_content_wrapper'>
			<div class='top_menu_content_title'>
				<img src='images/square_and_compass_Masonic_symbol_white.png' width='150px' height='150px'><br>
				Greensborough Masonic Centre 			
			</div>
			<div class='top_menu_content_menu'>
				<jdoc:include type="modules" name="top_main_menu" />
			</div>
				
			<div class='top_menu_toggle_wrapper'>
				<div id='top_menu_toggle' class='top_menu_toggle'>
					<div id='nav_icon' class='top_menu_up_arrow'></div>
				</div>
			</div>
		</div>
			
	
		
	</div>
	<div class='content_main'>
	
	
	
	
	
		<div id="slideshow">
			<?php
			foreach($filelist as $filename){
				echo "<image src='/".$filename."' class='bgM'/>\n";
				}
			?>
		</div>
		


	
		<div id='sap_content_container' class='content_body'>	
			<?php if(!isMobile()){ ?>
				<jdoc:include type="component" />
			<?php } ?>
		</div>
		
			
	</div>


	
</div>
	
	



</body>
</html>