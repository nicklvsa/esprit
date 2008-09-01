<?php

require("class.xml.php");
class mysql2xml {

   var $xml; 

   function mysql2xml() {
      //$this->recordSet = new recordSet();
	  $this->xml = new XMLFile();
      
   }
   # Initialization

   
   
   # Convert a query into XML
   function convertToXML($res, $filename) {
      //$result = $this->recordSet->select($sql);
	  $result = $res;
	  
      $this->xml->create_root();
      $this->xml->roottag->name = "table";
   
      while ($list_result = mysql_fetch_array($result)) {

      $this->xml->roottag->add_subtag("ROW", array());
      $tag = &$this->xml->roottag->curtag;
   	     
		 for ($i = 0; $i <= mysql_num_fields($result)- 1; $i++){
	   	    $tag->add_subtag(mysql_field_name($result, $i), array());
			$tag->curtag->cdata = $list_result[$i];
         }
	  }
	
	  $xml_file = fopen($filename, "w" );
      $this->xml->write_file_handle( $xml_file );
   }


} # class end
?>