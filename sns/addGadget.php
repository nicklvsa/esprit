<link rel='stylesheet' type='text/css' href='../html/css/general.css'>
<script type="text/javascript" src="../html/js/validations.js"></script>
<?php

    require_once('Config/config.php');
	$ret = array();

    $res = "select * from applications where id = $app_id";
	$rs_Apps = mysql_query($res) ;
    $row_rs_Apps = mysql_fetch_assoc($rs_Apps);
    
	$gadget = $row_rs_Apps;
  
    $container = 'default';

	$prefs = '';
    if($gadget['user_prefs'])
	{
		foreach ($gadget['user_prefs'] as $name => $value) {
			if (!empty($value) && !isset($appParams[$name])) {
				$prefs .= '&up_'.urlencode($name).'='.urlencode($value);
			}
		}
    } 

	$securityToken = BasicSecurityToken::createFromValues(
	isset($person_id) ? $person_id : '0',						// owner
	(isset($viewer_id) ? $viewer_id : '0'),						// viewer
	$gadget['id'],												// app id
	$_SERVER['HTTP_HOST'],										// domain
	urlencode($gadget['url']),									// app url
	$gadget['mod_id']											// mod id
	);

	$gadget_url_params = array();
	parse_str(parse_url ( $gadget['url'], PHP_URL_QUERY ), $gadget_url_params);
 
	$iframe_url = 
	$gadget_server.'/gadgets/ifr?'.
	"synd=".$container.
	"&container=".$container.
	"&viewer=".(isset($viewer_id) ? $viewer_id : '0').
	"&owner=".(isset($person_id) ? $person_id : $viewer_id).
	"&aid=".$gadget['id'].
	"&mid=".$gadget['mod_id']."&nocache=1".
	"&country=US".
	"&lang=EN".
	"&view=".$view.
	"&parent=".urlencode("http://".$_SERVER['HTTP_HOST']).
	$prefs.
	(isset($_REQUEST['appParams']) ? '&view-params='.urlencode($_REQUEST['appParams'])  : '').
	"&st=".base64_encode($securityToken->toSerialForm()).
	"&v=".$gadget['version'].
	"&url=".urlencode($gadget['url']).
	"#rpctoken=".rand(0,getrandmax());
		
	
	$height = !empty($gadget['height'])?$gadget['height']:'200';
	$iframe_name = "remote_iframe_".$mod_id;
	$iframe_id = "remote_iframe_".$mod_id;
	$scrolling = $gadget['scrolling'] ? 'yes' : 'no';

	$iframe_str = "<iframe width=".$width." height=".$height." name=".$iframe_name." id=".$iframe_id." scrolling =".$scrolling." frameborder='no' src= '".$iframe_url."' class='gadgets-gadget' style=\"display:none;\" onLoad=\"showIframe('".$iframe_id."','".$mod_id."');\"></iframe>";
	echo "<div class='iframe_div'>".$iframe_str."</div>";

			
?>

  