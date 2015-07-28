<?php 
 
 function get_backgroundlist(){
 	
	
	$filepath = "images/backgrounds";
	
	$files = scandir($filepath);
	
	$filelist = array();
	foreach($files as $filename){
		if(strcmp($filename, ".") && strcmp($filename, "..")){
			$filelist[] = $filepath."/".$filename;
			}
		}
	return $filelist;
	
 }
 
 function sap_pagination($itemList, $offset, $limit, $baseURL){
 	
 	//work out the pages number that are going to be required
 	$itemCount = count($itemList);
 	
 	//Work out the page count for the display
 	if($itemCount <= $limit )
 	{
		$pageCount = 1;
	}
	else{
		$pageCount = $itemCount / $limit;
		if($itemCount % $limit > 0 ){
			$pageCount++;
		}
	}
	
 	
 	//If we are pass the first page active the prev arrow
 	if($offset >= $limit){
 		$prevString = "<li><a class='hasTooltip' title='Previous' <a href='".$baseURL."?offset=".($offset-$limit)."'><i class='icon-previous'></i></a></li>";
 		} 
 	//if we are still in the first page
 	else{
		$prevString = "<li class='active'><a class='hasTooltip' title='Previous'><i class='icon-previous'></i></a></li>";
	}
 		
 		
 	//if we are in the last page of the list then
 	if($offset >= ($itemCount - $limit))
 	{
		$nextString = '<li class="disabled" ><a class="hasTooltip" title="Next"><i class="icon-next"></i></a></li></ul>';
	}
	else
	{
		$nextString = '<li><a class="hasTooltip" title="Next" href="'.$baseURL.'?offset='.($offset+$limit).'"><i class="icon-next"></i></a></li></ul>';
	}
 	
 	$currentPage = ($offset / $limit) +1 ;
 	
 	$returnString = "<div class='pagination pagination-toolbar'><ul class='pagination-list'>".$prevString;
 	for($count = 1; $count <= $pageCount; $count++)
 	{
 		
 		$currOffset = ($count-1) * $limit;
 		if($count == $currentPage)
 		{
			$returnString .= "<li class='active'><a>".$count."</a></li>";
		}
		else{
			$returnString .= "<li><a href='".$baseURL."?offset=".$currOffset."'>".$count."</a></li>";
		}
 		
 		//calculate the offset required for this page
	
	
 		
 		
 		
		
	}
 	$returnString .= $nextString;
 	
 	
 
 	
 	return $returnString;
 }
 
 ?> 