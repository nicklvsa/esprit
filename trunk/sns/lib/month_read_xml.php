<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load("lib/month.xml");

 
  
   $months = $xmlDoc->getElementsByTagName( "month" );

  foreach ($months as $month)
   {
	  
	   $month_name[$month->getAttribute('id')] = $month->nodeValue;
	   //$country_id[]  = $country->getAttribute('id').'<br />';
   }
 //print_r($country_name);
 
 /* foreach($country_name as $id=>$name)
  {
	  echo "key".$id;
	  echo "name".$name."\n";
  }*/
 
?>




