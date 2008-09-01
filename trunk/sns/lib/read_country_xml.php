<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load("lib/country-en.xml");

 
  
   $countries = $xmlDoc->getElementsByTagName( "pais" );

   foreach ($countries as $country)
   {
	  
	   $country_name[$country->getAttribute('id')] = $country->nodeValue;
	   //$country_id[]  = $country->getAttribute('id').'<br />';
   }
 //print_r($country_name);
 
 /* foreach($country_name as $id=>$name)
  {
	  echo "key".$id;
	  echo "name".$name."\n";
  }*/
 
?>




