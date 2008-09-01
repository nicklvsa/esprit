function MM_showHideLayers() 
{ //v9.0
	var i,p,v,obj,args=MM_showHideLayers.arguments;
	var event = args[args.length-1];
	//alert (event.);
	for (i=0; i<(args.length-2); i+=3) 
	with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
	if (obj.style) 
	{
		obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; 
	}
	obj.visibility=v; 
	obj.top =event.screenY-140+"px";
	obj.left =event.screenX+30+"px";
	}
	return obj;
}

function cancel()
{
	document.getElementById('upload').visible = false;
}

function errorInUserPic()
{
	alert("Invalid Image");
	MM_showHideLayers('apDiv1','','show',event);
}

function MM_showHideLayers() 
{ //v9.0
	var i,p,v,obj,args=MM_showHideLayers.arguments;
	var event = args[args.length-1];
	for (i=0; i<(args.length-2); i+=3) 
	with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) 
	{ v=args[i+2];
		if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
		obj.visibility=v; 
		obj.top =event.screenY-140+"px";
		obj.left =event.screenX+30+"px";
	}
	return obj;
}

function chgImg(direction) {
	if (document.images) {
		ImgNum = ImgNum + direction;
		if (ImgNum > ImgLength) {
			ImgNum = 0;
		}
		if (ImgNum < 0) {
			ImgNum = ImgLength;
		}
		document.slideshow.src = NewImg[ImgNum];
   }
}

function auto() {
	if (lock == true) {
		lock = false;
		window.clearInterval(run);
	}
	else if (lock == false) {
		lock = true;
		run = setInterval("chgImg(1)", delay);
    }
}

 function showPreview(appId)
 {
	window.location.href = "application.php?viewer_id=0&owner_id=0&app_id="+appId+"&mod_id=0";
 }

 function selectDays(day)
{
	var days;
	switch (day)
		{
		case "01":
		case "03":
		case "05":
		case "07":
		case "08":
		case "10":
		case "12":
		   days= 31;
		  break;
		case "02":
		  days= 29;
		  break;
		case "04":
		case "06":
		case "09":
		case "11":
		   days= 30;
		  break;
		
		}
		//alert(days);
		var retVal="<select name='day'>";
		for(var i = 1;i<=days;i++)
		{
			retVal+="<option value="+i+">";
			retVal+=i;
			retVal+="</option>";
		}
		retVal+="</select>";
	document.getElementById('day').innerHTML=retVal;
//alert(document.getElementById('day').innerHTML);
}

function validate(obj)
{
	if(obj.innerHTML="Enter your message here.")
        obj.innerHTML = "";
}

function hidestatus(){
window.status=''
return true
}
if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover=hidestatus
document.onmouseout=hidestatus