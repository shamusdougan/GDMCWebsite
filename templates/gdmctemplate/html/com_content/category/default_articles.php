<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Create some shortcuts.
$params		= &$this->item->params;
$n			= count($this->items);

$jinput = JFactory::getApplication()->input;
require_once ('templates/michaelmorrisarchitectstemplate/library.php');
$limit = 6;
$offset = $jinput->get('offset', 0, "INT" );;




?>
<div class='article_listing_web'>
<div class='sapient_transparent_background'>
<div class='article_listing_title_bar'>
	<div class='article_listing_title_content'>
		<?php print_r($this->category->title); ?>
	</div>
</div>
<div class='article_listing_container'>
	<div class='article_listing'>
<?php 
$iCount = 0;

foreach ($this->items as $i => $article) 
{
	if($i >= $offset && $iCount < $limit){
		$displayArticle = JTable::getInstance("content"); 
		$displayArticle->load($article->id); 
		$images = json_decode($displayArticle->images); 
		$displayTitle = strtoupper(trim(strip_tags($displayArticle->get("title"))));
		$displayText = trim(strip_tags($displayArticle->get("introtext")));
		
		$id = $article->id;
		$alias = $displayArticle->get('alias');
		
		
		if (isset($images->image_intro) and !empty($images->image_intro))
		{
			$displayImage = $images->image_intro;
		}	
		else
		{
			$displayImage = "images/no_image_found.jpg";
		}
		?>
		
		
		<div class='article_listing_wrapper'>
			<div class='article_listing_picture'>
			 	<div class="view view-first">
					<img src='<?php echo htmlspecialchars ("/".$displayImage); ?>' />
				 	<div class="mask">
		                <h2><?php echo $displayTitle; ?></h2>
		                <p><?php echo $displayText; ?></p>
		                <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>" class="info">View More</a>
		            </div>	
				</div> 
				
			</div>
			<div class='article_listing_title'>
				<A href='<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>'>
					<?php echo $displayTitle; ?>
				</A>
			</div>
			
			
		</div>
		
	
	
	
<? 		$iCount++;
		} 
	

	} ?>


	
	</div>
	
</div>
</div>


<?php if($n != 0 && $n > $limit) { ?>

	
	
		<div class='article_listing_footer_wrapper'>
			<div class='article_listing_footer_content'>
				<?php 
				echo  sap_pagination($this->items, $offset, $limit, JRoute::_(ContentHelperRoute::getCategoryRoute($article->catid))); ?>
			</div>
		</div>
	<?php } ?>
</div>
</div>


<div class='article_listing_mobile'>
	<div class='mobile_article_listing_title_bar'>
		<div class='mobile_article_listing_title_content'>
			<?php echo ($this->category->title); ?>
		</div>
	</div>
	<div class='mobile_article_listing_container'>
	
	<?php 
		foreach ($this->items as $i => $article) 
			{
			$displayArticle = JTable::getInstance("content"); 
			$displayArticle->load($article->id); 
			$images = json_decode($displayArticle->images); 
			$displayTitle = strtoupper(trim(strip_tags($displayArticle->get("title"))));
			$displayText = trim(strip_tags($displayArticle->get("introtext")));
			
			$id = $article->id;
			$alias = $displayArticle->get('alias');
			
			
			if (isset($images->image_intro) and !empty($images->image_intro))
			{
				$displayImage = $images->image_intro;
			}	
			else
			{
				$displayImage = "images/no_image_found.jpg";
			}
	?>
		<div class='mobile_article_listing_wrapper'>
			<div class='mobile_article_listing_picture'>
			 	<div class="view view-first">
					<A href='<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>'>
						<img src='<?php echo htmlspecialchars ("/".$displayImage); ?>' />
					</A>
				 
				</div> 
				
			</div>
			<div class='article_listing_title'>
				<A href='<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>'>
					<?php echo $displayTitle; ?>
				</A>
			</div>
		</div>
		<? } ?>
		
	</div>

</div>

</div>	
