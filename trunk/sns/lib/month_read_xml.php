<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load("lib/month.xml");

  $months = $xmlDoc->getElementsByTagName( "month" );

  foreach ($months as $month)
  {
	  $month_name[$month->getAttribute('id')] = $month->nodeValue;
  }
 
?>




