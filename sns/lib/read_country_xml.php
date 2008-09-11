<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load("lib/country-en.xml");

 
  
   $countries = $xmlDoc->getElementsByTagName( "pais" );

   foreach ($countries as $country)
   {
	  
	   $country_name[$country->getAttribute('id')] = $country->nodeValue;
   }
  
?>




