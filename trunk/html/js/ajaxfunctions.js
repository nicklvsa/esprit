function createRequestObject()
{
	var xmlhttp=false;
	try
	{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e)
	{
		try 
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (E) 
		{
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
	{
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function displayInfo(bkID)
{
	var request = createRequestObject();
	request.open('GET', 'doSql.php?&BkID='+bkID, true);
	request.onreadystatechange = function()
	{
		if(request.readyState == 4)
		{
			if(request.status == 200)
			{
				var response = request.responseText;
				document.getElementById('bookpanel').innerHTML = response;
			}
		}
	}
	request.send(null);
}