
<form method="POST" name='bk' action="<? echo $_SERVER['PHP_SELF']."?userID=".$view_id;?>">
  
  <table border="0" width='90%' align="center" cellpadding="20" cellspacing="0" height="124">
  <tr><td height="25%"></td></tr>
    <tr>
	<td align='right'><label>Add the url</label></td>
      <td align='right'><input name="app_add" type="text" id="add_app" accesskey="e" tabindex="4" value="<?echo $app;?>" size="50" ></td>
    
      <td align='left'><input type="submit" value="Add" name="add_app" ></td>
    </tr>
	<div id="edit_apps"></div>
  </table>
  

</form>

