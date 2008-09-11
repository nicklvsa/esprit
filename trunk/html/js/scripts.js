/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 */

function cancel()
{
	document.getElementById('upload').visible = false;
}

function errorInUserPic()
{
	alert("Invalid Image");
	MM_showHideLayers('apDiv1','','show',event);
}

function showHideLayers() 
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


function post_Reply(id)
{
	document.getElementById(id).style.display="";
}
function edit_caption(id,fl)
{
	if (fl==1)
	{
		document.getElementById(id).style.display='';
	}
	else
		document.getElementById(id).style.display='none';

}
function upLoad(id)
{
	if (id=='')
	{
		alert('Ivalid Path');
	}
	
else
	document.upload.submit();

}


if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover=hidestatus
document.onmouseout=hidestatus