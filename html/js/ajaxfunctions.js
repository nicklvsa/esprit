/* Making a request.*/
function createRequestObject()
{
/* Initialising the variable xmlhttp */
	var xmlhttp=false;
	
/* Try and catch block for creating xmlhttp object according to the browser */
	try
	{
	/* The xmlhttp object is built into the Microsoft XML Parser. */
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e)
	{
		try 
		{
		/* The xmlhttp object is built into the Microsoft IE. */
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (E) 
		{
			xmlhttp = false;
		}
	}
/* The xmlhttp object is built into the browsers other than Microsoft IE. */
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