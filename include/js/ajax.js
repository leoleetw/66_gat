function Dd(did){
	return document.getElementById(did);
}

function block(divid){
	Dd(divid).style.display = "block";
}

function none(divid){
	Dd(divid).style.display = "none";
}

function DIVAlert(str,msgw,msgh){ //�Ы�DIVAlert
      var msgw,msgh,bordercolor;
      //msgw=400;//���ܵ��f��?��
      //msgh=100;//���ܵ��f������
      titleheight=25 //���ܵ��f??����
      bordercolor="#336699";//���ܵ��f��?��?��
      titlecolor="#99CCFF";//���ܵ��f��???��
   
      var sWidth,sHeight;
      sWidth=document.body.offsetWidth;
      sHeight=screen.height;
      var bgObj=document.createElement("div");
      bgObj.setAttribute('id','bgDiv');
      bgObj.style.position="absolute";
      bgObj.style.top="0";
      bgObj.style.background="#777";
      bgObj.style.filter="progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=25,finishOpacity=75";
      bgObj.style.opacity="0.6";
      bgObj.style.left="0";
      bgObj.style.width=sWidth + "px";
      bgObj.style.height=sHeight + "px";
      bgObj.style.zIndex = "10000";
      document.body.appendChild(bgObj);
   
      var msgObj=document.createElement("div")
      msgObj.setAttribute("id","msgDiv");
      msgObj.setAttribute("align","center");
      msgObj.style.background="white";
      msgObj.style.border="1px solid " + bordercolor;
         msgObj.style.position = "absolute";
               msgObj.style.left = "40%";
               msgObj.style.top = "25%";
               msgObj.style.font="12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif";
               msgObj.style.marginLeft = "-225px" ;
               msgObj.style.marginTop = -75+document.documentElement.scrollTop+"px";
               //msgObj.style.width = msgw ;
               //msgObj.style.height =msgh ;
               msgObj.style.width = msgw + "px";
               msgObj.style.height =msgh + "px";
               msgObj.style.textAlign = "center";
               msgObj.style.lineHeight ="25px";
               msgObj.style.zIndex = "10001";
   
        var title=document.createElement("h4");
        title.setAttribute("id","msgTitle");
        title.setAttribute("align","right");
        title.style.margin="0";
        title.style.padding="3px";
        title.style.background=bordercolor;
        title.style.filter="progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";
        title.style.opacity="0.75";
        title.style.border="1px solid " + bordercolor;
        title.style.height="18px";
        title.style.font="12px Verdana, Geneva, Arial, Helvetica, sans-serif";
        title.style.color="white";
        title.style.cursor="pointer";
        title.innerHTML="����";
        title.onclick=function(){
             document.body.removeChild(bgObj);
                   document.getElementById("msgDiv").removeChild(title);
                   document.body.removeChild(msgObj);
                   }
        document.body.appendChild(msgObj);
        document.getElementById("msgDiv").appendChild(title);
        var txt=document.createElement("p");
        txt.style.margin="1em 0"
        txt.setAttribute("id","msgTxt");
        txt.innerHTML=str;
              document.getElementById("msgDiv").appendChild(txt);
 }
 
 function cancelalert(){		//DIVAlert ����
	document.body.removeChild(Dd("bgDiv"));
	Dd("msgDiv").removeChild(Dd("msgTitle"));
	document.body.removeChild(Dd("msgDiv"));    
}

function getchecked(obj){ //��o�Ŀ諸��� RADIO
	var res="";
	for (var i=0; i< obj.length; i++){
				   if ( obj[i].checked){
				      res=obj[i].value;
				      break;
				   }
			}
	return res;
}

function padLeft(str, len) {  //�����0
    str = '' + str;
    return str.length >= len ? str : new Array(len - str.length + 1).join("0") + str;
}

function mysqldate(mytext){
	var arr=new Array();
	arr=mytext.split(" ");
	arr = arr[0].replace("-", "/");
	return arr[0];
}
function mysqldatetime(mytext){
	var arr=new Array();
	arr=mytext.split(".");
	return arr[0];
}
function mysqltime(mytext){
	var arr=new Array();
	var str=new Array();
	arr=mytext.split(".");
	str=arr[0].split(" ");
	return str[1];
}

function isnull(exam){ //innerHTML �� �NNULL�ର�ŭ�
	if ((!exam && typeof exam == "undefined" && exam != 0 )|| exam==null || exam==""){ //undefined != > ==
    return "";
	}
	else
		return exam;
}

function checkerror(mytext){ //�T�{�^�Ǫ��Ȭ�JSON��SPILT
	var arr=new Array();
	arr=mytext.split("&&");
	if(arr.length > 1){
		return true;
	}
	else{
		return false;
	}
}


function creat_date(){
	
 //$(document).ready(function(){ 
  var opt={dayNames:["�P����","�P���@","�P���G","�P���T","�P���|","�P����","�P����"],
           dayNamesMin:["��","�@","�G","�T","�|","��","��"],
           monthNames:["�@��","�G��","�T��","�|��","����","����","�C��","�K��","�E��","�Q��","�Q�@��","�Q�G��"],
           monthNamesShort:["�@��","�G��","�T��","�|��","����","����","�C��","�K��","�E��","�Q��","�Q�@��","�Q�G��"],
           prevText:"�W��",
           nextText:"�U��",
           weekHeader:"�g",
           showMonthAfterYear:true,
           dateFormat:"yy-mm-dd"
           };
  return opt; //p@$$w0rd64
  //$("#"+Ddstr).datepicker(opt);
  //$("#datepicker_1").datepicker(opt);

 // });
}

function str2sql(str){
	if(str==""||str==null){
		return "";
	}
	else{
		var str2="";
		str2 = str.replace(/  /g, "&nbsp;&nbsp;");
		str2 = str2.replace(/\n/g,"<br>");
		return str2;
	}
}

function sql2str(str){
	if(str==""||str==null){
		return "";
	}
	else{
		var str2="";
		str2 = str.replace(/&nbsp;&nbsp;/g, "  ");
		str2 = str2.replace(/<br>/g,"\n");
		//str2 = str2.replace("'", "''", str2);
		return str2;
	}
}

function isemail(str){
	var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;  
	if(str.search(emailRule)!= -1)
		return true;
	else
		return false;  
}
function submitenter(myfield,e){ //ENTER �۰ʵo�e
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	   {
	   login_check();
	   return false;
	   }
	else
	   return true;
}

function onlyNum(){
	if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))//�Ҽ{�p��L�W���Ʀr��
		event.returnvalue=false;
}

function imgResize(xObj,maxW,maxH , view){
  Dd(view).style .width =maxW +'px';
  Dd(view).style .height =maxH+'px';
  if (xObj.width > 0 && xObj.height > 0) {
    //�p�G�e�פj��
    if (xObj.width/xObj.height >= maxW/maxH) {
      if (xObj.width >= maxW){
        width = maxW;
        height = maxW * xObj.height / xObj.width; //��=��*��v�F ��v=�̤j�e��/�e��
      }
      else {
        //����
        width = xObj.width;
        height = xObj.height;
      }
    }
    else{
      //�e�פp�_����
      if(xObj.height>maxH){  
        width = xObj.width * maxH / xObj.height;     
        height = maxH;
      }
      else{
        width = xObj.width;  
        height = xObj.height;
      }
    }
    xObj.width=width;
    xObj.height=height;
  }
}


function tableToExcel(table, name, filename) {
	var n = new Date();
	var y = n.getFullYear();//.substr(2,2);
	var m = (n.getMonth()+1< 10)?("0" + (n.getMonth() + 1)):(n.getMonth() + 1);
	var d = (n.getDate()< 10)?("0" + (n.getDate())):(n.getDate());
	var h = (n.getHours()< 10)?("0" + (n.getHours())):(n.getHours());
	var mi = (n.getMinutes()< 10)?("0" + (n.getMinutes())):(n.getMinutes());
	var s = (n.getSeconds()< 10)?("0" + (n.getSeconds())):(n.getSeconds());
	filename = filename+y+m+d+h+mi+s+".xls";
	//alert(filename);
  var uri = 'data:application/vnd.ms-excel;base64,';
  //�w�q�榡�νs�X�覡

  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office"'
               + '      xmlns:x="urn:schemas-microsoft-com:office:excel"'
               + '      xmlns="http://www.w3.org/TR/REC-html40">'
               + '<head>'
               + '<!--[if gte mso 9]>'
               + '<xml>'
               + '  <x:ExcelWorkbook>'
               + '    <x:ExcelWorksheets>'
               + '      <x:ExcelWorksheet>'
               + '        <x:Name>{worksheet}</x:Name>'
               + '        <x:WorksheetOptions>'
               + '          <x:DisplayGridlines/>'
               + '        </x:WorksheetOptions>'
               + '      </x:ExcelWorksheet>'
               + '    </x:ExcelWorksheets>'
               + '  </x:ExcelWorkbook>'
               + '</xml>'
               + '<![endif]-->'
               + '</head>'
               + '<body>'
               + '  <table>{table}</table>'
               + '</body>'
               + '</html>';
  //Excel���򥻮ج[

  if (!table.nodeType)
    table = document.getElementById(table)

  var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

  document.getElementById("dlink").href = uri + base64(format(template, ctx));
  //�N�W�s�����VExcel���e
  document.getElementById("dlink").download = filename;
  //�w�q�W�s���U�����ɦW
  document.getElementById("dlink").click();
  //�����I���W�s�����ʧ@�ӤU���ɮ�
  
}

function base64(s) {
  return window.btoa(unescape(encodeURIComponent(s)))
}
//�N��r�sĶ��Base64�榡

function format(s, c) {
  return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
}
