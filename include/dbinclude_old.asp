<?php
response.buffer =true
response.expires=-1
query_string=LCase(Request.ServerVariables("query_string") )
if instr(query_string,"""")>0 or instr(query_string,"1=1")>0 or instr(query_string,"--")>0 or instr(query_string,";")>0 or instr(query_string,"'")>0 or instr(query_string,"iframe")>0 or instr(query_string,"create")>0 or instr(query_string,"script")>0 then
  response.redirect "/index.php"
end if
if instr(query_string,"src")>0 or instr(query_string,"css")>0 or instr(query_string,"js")>0 or instr(query_string,"<")>0 or instr(query_string,">")>0  then
  response.redirect "/index.php"
end if
session.Timeout=600
Server.ScriptTimeout=600
set conn=server.createobject("ADODB.Connection")
conn.connectiontimeout=600
conn.commandtimeout=600
conn.Provider="sqloledb"
'conn.open "server=HFS18;uid=webuser;pwd=webuser;database=CLAYART"
conn.open "server=125.227.188.239;uid=sa;pwd=p@$$w0rd64;database=CLAYART"

Function ShowGrid (SQL)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i	
    echo "<table id=grid border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 0 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr>"
	For i = 0 To FieldsCount
          echo "<td bgcolor='#FFFFFF'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
	Next    
        RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
End Function

Function DataGrid (SQL,HLink,LinkParam,LinkTarget)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></td>"
    Next
    echo "<td bgcolor='#FFE1AF' nowrap><span style='font-size: 9pt; font-family: 新細明體'>處理</span></td>"
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
	Next
        echo "<td><a href='JavaScript:if(confirm(""是否確定要刪除 ?"")){window.location.href=""" & HLink & RS1(LinkParam) & """;}' target='" & LinkTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='刪除'></a></td>"    
	RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
End Function

Function DataLinkGrid (SQL,HLink,LinkParam,LinkTarget,DataLink,DataParam,DataTarget)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 2 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>處理</span></font></td>"
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 2 To FieldsCount
        if i = 2 then
	       echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>" & RS1(i) & "</a></span></td>"
        else
           echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
        end if
	Next
    echo "<td><a href='JavaScript:if(confirm(""是否確定要刪除 ?"")){window.location.href=""" & DataLink & RS1(DataParam) & """;}' target='" & DataTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='刪除'></a></td>"    
	RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
End Function

Function GetGrid (SQL,LinkField)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 0 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 0 To FieldsCount
	    if i = 0 then
		   echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & "<a href='javascript:opener.document.form." & LinkField & ".value=""" & RS1(i) & """;self.close()'>" & RS1(i) & "</a></span></td>"
	    else
           echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
	    end if   
        Next    
        RS1.MoveNext
        echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
End Function

Function LinkGrid (SQL,HLink,LinkParam,LinkTarget,LinkType)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 1 To FieldsCount
	  echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
      if Hlink<>"" then
         if LinkType="window" then
            echo "<a href onclick=""window.open('" & Hlink & RS1(LinkParam)&"','','scrollbars=no,top=100,left=120,width=470,height=320')"">"
         else
            echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
         end if   
         showhand="style='cursor:hand'"
      end if
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For i = 1 To FieldsCount
           echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
      Next    
      RS1.MoveNext
      echo "</tr>"
      echo "</a>"
    Wend
    echo "</table>"
    RS1.Close
End Function

Function LinkGrid2 (SQL,HLink,LinkParam,LinkTarget)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 1 To FieldsCount
	    if i = 1 then
	      echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>" & RS1(i) & "</a></span></td>"
	    else
          echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
	    end if   
       Next    
       RS1.MoveNext
       echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
End Function

Function PageList (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink)
	Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    if Not RS1.EOF then 
       FieldsCount = rs1.Fields.Count-1
       totRec=RS1.Recordcount         '總筆數
       if totRec>0 then 
          RS1.PageSize=PageSize       '每頁筆數
          if nowPage="" or nowPage=0 then 
             nowPage=1
      	  elseif cint(nowPage) > RS1.PageCount then 
         	 nowPage=RS1.PageCount 
      	  end if    
      	  session("nowPage")=nowPage        	
          RS1.AbsolutePage=nowPage
          totPage=RS1.PageCount       '總頁數
          Sql=server.URLEncode(Sql)
       end if    
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='30%'></td>"
    echo "<td width='55%'><span style='font-size: 9pt; font-family: 新細明體'>第" & nowPage & "/" & totPage & "頁&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: 新細明體'>共" & totRec & "筆&nbsp;&nbsp;</span>"
    if cint(nowPage) <>1 then             
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>上一頁</a>" 
    end if      
    if cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount then 
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>下一頁</a>" 
    end if
    echo " |&nbsp;<span style='font-size: 9pt; font-family: 新細明體'> 跳至第<select name=GoPage size='1' style='font-size: 9pt; font-family: 新細明體'>"
    For iPage=1 to totPage
        if iPage=cint(nowPage) then
           strSelected = "selected"
	    else
	       strSelected = "" 
	    end if   
        echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>頁</span></td>" 
    
    if AddLink <> "" then
       echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
		echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
      if Hlink<>"" then
         echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
         showhand="style='cursor:hand'"
      end if   
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(j) & "</span></td>"
	  Next
      i = i + 1
	  rs1.MoveNext
	'若資料指標到達EOF則跳出回圈
	  echo "</tr>"
	  echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
    else
        echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
        echo "<tr><td width='85%' align='center' style='color:#ff0000'>** 沒有符合條件的資料 **</td>"
        if AddLink <> "" then
           echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
        end if  
        echo "</table>"
    end if 
    rs1.close
End Function

Function PageList2 (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink)
	Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    if Not RS1.EOF then 
       FieldsCount = rs1.Fields.Count-1
       totRec=RS1.Recordcount         '總筆數
       if totRec>0 then 
          RS1.PageSize=PageSize       '每頁筆數
          if nowPage="" or nowPage=0 then 
             nowPage=1
      	  elseif cint(nowPage) > RS1.PageCount then 
         	 nowPage=RS1.PageCount 
      	  end if    
      	  session("nowPage")=nowPage        	
          RS1.AbsolutePage=nowPage
          totPage=RS1.PageCount       '總頁數
          Sql=server.URLEncode(Sql)
       end if    
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='35%'></td>"
    echo "<td width='50%'><span style='font-size: 9pt; font-family: 新細明體'>第" & nowPage & "/" & totPage & "頁&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: 新細明體'>共" & totRec & "筆&nbsp;&nbsp;</span>"
    if cint(nowPage) <>1 then             
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>上一頁</a>" 
    end if      
    if cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount then 
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>下一頁</a>" 
    end if
    echo " |&nbsp;<span style='font-size: 9pt; font-family: 新細明體'> 跳至第<select name=GoPage size='1' style='font-size: 9pt; font-family: 新細明體'>"
    For iPage=1 to totPage
        if iPage=cint(nowPage) then
           strSelected = "selected"
	    else
	       strSelected = "" 
	    end if   
        echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>頁</span></td>" 
    
    if AddLink <> "" then
       echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href onclick=""window.open('" & AddLink &"','','scrollbars=no,top=100,left=120,width=470,height=320')"">新增資料</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
		echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
      if Hlink<>"" then
         echo "<a href onclick=""window.open('" & Hlink & RS1(LinkParam)&"','','scrollbars=no,top=100,left=120,width=470,height=320')"">"
         showhand="style='cursor:hand'"
      end if   
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(j) & "</span></td>"
	  Next
      i = i + 1
	  rs1.MoveNext
	'若資料指標到達EOF則跳出回圈
	  echo "</tr>"
	  echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
    else
        echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
        echo "<tr><td width='85%' align='center' style='color:#ff0000'>** 沒有符合條件的資料 **</td>"
        if AddLink <> "" then
           echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href onclick=""window.open('" & AddLink &"','','scrollbars=no,top=100,left=120,width=470,height=320')"">新增資料</a></span></td>"
        end if  
        echo "</table>"
    end if 
    rs1.close
End Function

Function LinkPageGrid (SQL,PageSize,HLink,LinkParam,LinkTarget,AddLink)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    rs1.PageSize = PageSize
    FieldsCount = rs1.Fields.Count-1
    nowAbsolutePage = Cint(Request("PostAbsolutePage"))
    if nowAbsolutePage <> "" then
	   myAbsolutePage = nowAbsolutePage
    else
	   myAbsolutePage = 1
    end if
    arrowValue = Request("ArrowAbsolutePage")
    if arrowValue = "上一頁" then
	   myAbsolutePage = myAbsolutePage - 1
    elseif arrowValue = "下一頁" then
	   myAbsolutePage = myAbsolutePage + 1
    elseif arrowValue = "第一頁" then
	   myAbsolutePage = 1
    elseif arrowValue = "最後頁" then
	   myAbsolutePage = rs1.PageCount
    end if
    if myAbsolutePage = "" or myAbsolutePage < 1 then
	   myAbsolutePage = 1
    elseif myAbsolutePage > rs1.PageCount then
	   myAbsolutePage = rs1.PageCount
    end if
    if rs1.PageCount > 0 then 
       rs1.AbsolutePage = myAbsolutePage
    end if   
    echo "<Form action='' id=form1 name=form1><table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' align='center'>"
    echo "<td><span style='font-size: 9pt; font-family: 新細明體'>第" & myAbsolutePage & "頁</span></td>"
    echo "<Input type=hidden name='PostAbsolutePage' value='" & myAbsolutePage & "'>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='第一頁' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='上一頁' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='下一頁' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='最後頁' class=cbutton></td>"
    echo "<td><span style='font-size: 9pt; font-family: 新細明體'>計: " & RS1.PageCount & "頁/ " & RS1.RecordCount & "筆</span></td>"
    if AddLink <> "" then
       echo "<td width=15></td>"
       echo "<td><span style='font-size: 9pt; font-family: 新細明體'><a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
	  echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          if j = 1 then
	         echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>" & RS1(j) & "</a></span></td>"
          else
             echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(j) & "</span></td>"
          end if
	  Next
      i = i + 1
	  rs1.MoveNext
	'若資料指標到達EOF則跳出回圈
	  echo "</tr>"
    Wend
    echo "</table>"
    echo "</form>"
    if RS1.RecordCount=0 then
       echo "<center>尚未建立任何資料</center>"
    end if 
    rs1.close
End Function

Function PageGrid (SQL,PageSize)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    rs1.PageSize = PageSize
    FieldsCount = rs1.Fields.Count-1
    nowAbsolutePage = Cint(Request("PostAbsolutePage"))
    if nowAbsolutePage <> "" then
	   myAbsolutePage = nowAbsolutePage
    else
	   myAbsolutePage = 1
    end if
    arrowValue = Request("ArrowAbsolutePage")
    if arrowValue = "上一頁" then
	   myAbsolutePage = myAbsolutePage - 1
    elseif arrowValue = "下一頁" then
	   myAbsolutePage = myAbsolutePage + 1
    elseif arrowValue = "第一頁" then
	   myAbsolutePage = 1
    elseif arrowValue = "最後頁" then
	   myAbsolutePage = rs1.PageCount
    end if
    if myAbsolutePage = "" or myAbsolutePage < 1 then
	   myAbsolutePage = 1
    elseif myAbsolutePage > rs1.PageCount then
	   myAbsolutePage = rs1.PageCount
    end if
    if rs1.PageCount > 0 then 
       rs1.AbsolutePage = myAbsolutePage
    end if   
    echo "<Form action='' id=form1 name=form1><table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' align='center'>"
    echo "<td><span style='font-size: 9pt; font-family: 新細明體'>第" & myAbsolutePage & "頁</span></td>"
    echo "<Input type=hidden name='PostAbsolutePage' value='" & myAbsolutePage & "'>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='第一頁' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='上一頁' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='下一頁' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='最後頁' class=cbutton></td>"
    echo "<td><span style='font-size: 9pt; font-family: 新細明體'>計: " & RS1.PageCount & "頁/ " & RS1.RecordCount & "筆</span></td>"
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 0 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & rs1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For j = 0 To FieldsCount
	    echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & rs1(j) & "</span></td>"
	Next
    i = i + 1
	rs1.MoveNext
	'若資料指標到達EOF則跳出回圈
	echo "</tr>"
    Wend
    echo "</table>"
    echo "</form>"
    rs1.close
End Function

Function OptionList (SQL,FName,Listfield,BoundColumn,menusize)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    echo "<SELECT Name='" & FName & "' size='" & menusize & "' style='font-size: 9pt; font-family: 新細明體'>"
    If RS1.EOF then
	echo "<OPTION>" & " " & "</OPTION>"
    End If
    if BoundColumn="" or IsNull(BoundColumn) then
       echo "<OPTION selected value=''>" & " " & "</OPTION>"
    end if    
    While Not RS1.EOF
	If RS1(FName)=BoundColumn then
	   strSelected = "selected"
	else
	   strSelected = ""
	End if      
	echo "<OPTION " & strSelected & " value='" & RS1(FName) & "'>" & RS1(Listfield) & "</OPTION>"
	RS1.MoveNext
    Wend
    echo "</SELECT>"
    RS1.Close
End Function

Function OptionList2 (SQL,FName,Listfield,BoundColumn,menusize)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    echo "<SELECT Name='" & FName & "' size='" & menusize & "' style='font-size: 9pt; font-family: 新細明體'>"
    If RS1.EOF then
	   echo "<OPTION>" & " " & "</OPTION>"
    End If
    if BoundColumn="" or IsNull(BoundColumn) then
       echo "<OPTION selected value=''>" & " " & "</OPTION>"
    end if    
    While Not RS1.EOF
	if Instr(BoundColumn,RS1(FName)) > 0 then      
	   echo "<OPTION " & strSelected & " value='" & RS1(FName) & "'>" & RS1(Listfield) & "</OPTION>"
	end if   
	RS1.MoveNext
    Wend
    echo "</SELECT>"
    RS1.Close
End Function

sub CheckBoxList (SQL,FName,Listfield,BoundColumn)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    session("FieldsetCount")=RS1.RecordCount
    Dim i
    I = 1
    While Not RS1.EOF
      	if Instr(BoundColumn,RS1(FName)) > 0 then
         	StrChecked="checked"
      	else
            StrChecked=""   
      	end if   
		echo "<Input Type='checkbox' " & StrChecked & " Name='" & FName &"' ID='" & FName & I & "' value='" & RS1(FName) & "'>" & RS1(Listfield) & "&nbsp;"
        I = I + 1
		RS1.MoveNext
    Wend
    RS1.Close
End sub

sub RadioBoxList (SQL,FName,Listfield,BoundColumn,NoChecked)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    session("FieldsetCount")=RS1.RecordCount
    Dim i
    I = 1
    While Not RS1.EOF
      if BoundColumn="" then
         if I = NoChecked then
            StrChecked="checked"
         else
            StrChecked=""   
         end if  
      else
         If RS1(FName)=BoundColumn then
    		StrChecked="checked"
    	 else
            StrChecked=""   
         end if
      end if   	
	  echo "<Input Type='radio' " & StrChecked & " Name='" & FName &"' ID='" & FName & I & "' value='" & RS1(FName) & "'>" & RS1(Listfield)
      I = I + 1
	RS1.MoveNext
    Wend
    RS1.Close
End sub

Sub CheckBoxData (SQL,FName,DataName,DataNum,StrChecked)
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    session("FieldsetCount")=RS1.RecordCount
    FieldsCount = RS1.Fields.Count-1
    Dim i, j
    j = 1
    K = FieldsCount - DataNum
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>選擇</span></font></td>"
    For i = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
        echo "<td><span style='font-size: 9pt; font-family: 新細明體'><Input Type='checkbox'" & StrChecked & " Name='" & FName & j & "' value='" & RS1(FName) & "'>" & "</span></td>"
	For i = 1 To FieldsCount
            if i > k then
	           echo "<td><span style='font-size: 9pt; font-family: 新細明體'><input type='text' name='" & DataName & i & j & "' size='4' style='font-size: 9pt; font-family: 新細明體' value='" & RS1(i) & "'></span></td>"
            else
               echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
            end if
	Next 
        j = j + 1   
        RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
End sub

function radioFun(data,data1)
	if data = data1 then radioFun = "checked" end if
end function

function checkFun(data,data1)
	if Instr(data,data1) > 0 then checkFun = "checked" end if
end function

Function AddSQL (SQL)
    On error resume next
    set RS=Server.CreateObject("ADODB.Recordset")
    RS.Open sql,conn,1,3
    conn.close
    select case err.number
      case 0 session("msg")="訊息 : 新增資料成功 !"
      case -2147217900 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
      case -2147217873 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
      case else
        session("msg")="錯誤 : " & err.number & "  " & err.description
    end select
    session("errnumber")=err.number
End Function

Function UpdateSQL (SQL)
    On error resume next
    set RS=Server.CreateObject("ADODB.Recordset")
    RS.Open sql,conn,1,3
    conn.close
    select case err.number
      case 0 session("msg")="訊息 : 異動資料成功 !"
      case -2147217873 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
      case else
        session("msg")="錯誤 : " & err.number & "  " & err.description
    end select
    session("errnumber")=err.number
End Function

Function ExecSQL (SQL)
    On error resume next
    Set RS=Conn.Execute(SQL)
    select case err.number
      case 0 session("msg")="訊息 : 異動資料成功 !"
      case -2147217900 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
      case -2147217873 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
      case else
        session("msg")="錯誤 : " & err.number & "  " & err.description
    end select
    session("errnumber")=err.number
End Function

Function QuerySQL (SQL,RS)
    set RS=Server.CreateObject("ADODB.Recordset")
    RS.Open sql,conn,1,1
End Function	

Function SPSQL (SpName,RS)
    Set cmd=Server.CreateObject("ADODB.Command")
    Set cmd.ActiveConnection=conn
    cmd.CommandText=SpName
    Set RS=cmd.Execute
End Function

Function SpParam (SpName,Param,SpType,SpLength,SpValue,RS)
    Set cmd=Server.CreateObject("ADODB.Command")
    Set cmd.ActiveConnection=conn
    cmd.CommandText=SpName
    cmd.Parameters.Append cmd.CreateParameter(Param,SpType,1,SpLength,SpValue)
    Set RS=cmd.Execute
End Function

Sub Warning (msg)
    echo "<script Language='JavaScript'> alert('" & msg & "')"
    echo "</script>"
End Sub 

Sub Message()
    if session("errnumber")=0 then
       echo "<center>"&session("msg")&"</center>"
    else
       echo "<script Language='JavaScript'> alert('" & session("msg")&"')"
       echo "</script>"
    end if
    session("msg")=""
    session("errnumber")=0
End Sub

Function CheckNumber (FName,ListField)
    echo "if Not IsNumeric(form." & FName & ".value) then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " 欄位必須為數字 !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
End Function 

Function CheckInt (FName,ListField)
    echo "if InStr(form." & FName & ".value,"&Chr(34)&"."&Chr(34)&")>0 or form." & FName & ".value<=0 then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " 欄位必須為大於0的整數 !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
End Function 

Function CheckString (FName,ListField)
    echo "if form." & FName & ".value="&Chr(34)&Chr(34)&" then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " 欄位不可為空白 !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
End Function 

Function CheckDate (FName,ListField)
    echo "if form." & FName & ".value<>"&Chr(34)&Chr(34)&" then " & Chr(13) & Chr(10)
    echo "if Not IsDate(form." & FName & ".value) or (left((form." & FName & ".value),1)<>"&Chr(34)&"2"&Chr(34)&" and left((form." & FName & ".value),1)<>"&Chr(34)&"1"&Chr(34)&") then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " 欄位必須為西元日期格式 ! (yyyy/mm/dd)"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
End Function  

Function CheckDateRange (FName1,FName2)
    echo "if form." & FName1 & ".value > form." & FName2 & ".value then " & Chr(13) & Chr(10)
    echo "   msgbox " & Chr(34) & "日期較大的, 不能放在前面 !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName1 &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
End Function

Function Checklen(FName,CLength,ListField)              '檢測中英文夾雜字串實際長度
    echo "x = form." & FName & ".value" & Chr(13) & Chr(10)
    echo "if blen(x) > " & CLength & " then" & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " 欄位長度超過限制 !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
End function

Sub SaveButton()
    echo "<button id='save' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/save.gif' width='19' height='20' align='absmiddle'>存檔</button>"
    echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/icon6.gif' width='20' height='15' align='absmiddle'>上一頁</button>"
End Sub

Sub Edit2Button()
    echo "<button id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/update.gif' width='19' height='20' align='absmiddle'> 修改</button>"
    echo "<button id='query' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/search.gif' width='19' height='20' align='absmiddle'>查詢</button>"
    echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/icon6.gif' width='20' height='15' align='absmiddle'>上一頁</button>"
End Sub

Sub EditButton()
    echo "<button id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/update.gif' width='19' height='20' align='absmiddle'> 修改</button>"
    echo "<button id='delete' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/delete.gif' width='19' height='20' align='absmiddle'>刪除</button>"
    echo "<button id='query' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/search.gif' width='19' height='20' align='absmiddle'>查詢</button>"
    echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/document.gif' width='19' height='20' align='absmiddle'>上一頁</button>"
End Sub 

Sub QueryButton()
    echo "<button id='query' style='position:relative;left:20;width:45;height:40;font-size:9pt'> <img src='../images/search.gif' width='19' height='20'><br>查詢</button>"
    echo "<button id='cancel' style='position:relative;left:30;width:45;height:40;font-size:9pt'> <img src='../images/document.gif' width='19' height='20'><br>上一頁</button>"
End Sub

Sub ReportButton()
    echo "<button id='report' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/print.gif' width='19' height='20' align='absmiddle'> 報表</button>"
    echo "<button id='export' style='position:relative;left:0;width:90;height:25;font-size:9pt' class='button3-bg'> <img src='../images/word.gif' width='19' height='19' align='absmiddle'> 匯出資料</button>"
End Sub

Sub Report2Button()
    echo "<button id='report' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/print.gif' width='19' height='20' align='absmiddle'> 報表</button>"
    echo "<button id='export' style='position:relative;left:0;width:90;height:25;font-size:9pt' class='button3-bg'> <img src='../images/excel.gif' width='20' height='19' align='absmiddle'> 匯出資料</button>" 
End Sub

Function GetChkNum (GuiNo)
    Dim ChkNum
    X=Array("A0","B1","C2","D3","E4","F5","G6","H7","I8","J9","K0","L1","M2","N3","O4","P5","Q6","R7","S8","T9","U0","V1","W2","X3","Y4","Z5")
    For i=0 to 25
      if Mid(GuiNo,1,1)=Left(X(i),1) then
         A1=CSng(Right(X(i),1))
      end if
      if Mid(GuiNo,2,1)=Left(X(i),1) then
         A2=CSng(Right(X(i),1))
      end if
    Next
    ChkNum=A1+A2*9+CSng(Mid(GuiNo,3,1))*8+CSng(Mid(GuiNo,4,1))*7+CSng(Mid(GuiNo,5,1))*6+CSng(Mid(GuiNo,6,1))*5+CSng(Mid(GuiNo,7,1))*4+CSng(Mid(GuiNo,8,1))*3+CSng(Mid(GuiNo,9,1))*2+CSng(Mid(GuiNo,10,1))
    GetChkNum = 9 - CSng(Right(CStr(ChkNum),1))
End Function

Function syslog (log_type,log_desc)
    sys_date=date()
    client_IP=Request.ServerVariables("REMOTE_ADDR")
    sql="insert into sys_log values (getdate(),'"&sys_date&"','"&session("user_id")&"','"&session("user_name")&"','"&session("dept_id")&"','"&log_type&"','"&log_desc&"','"&client_IP&"')"
    On error resume next
    Set RS=Conn.Execute(SQL)
end Function

Function hitlog (hit_menu,menu_type,hit_submenu)
    sys_date=date()
    client_IP=Request.ServerVariables("REMOTE_ADDR")
    sql="insert into hit values ('"&sys_date&"',getdate(),'"&hit_menu&"','"&menu_type&"','"&hit_submenu&"','"&client_IP&"')"
    On error resume next
    Set RSS=Conn.Execute(SQL)
End Function

Function xdate (dt)
    if year(dt) > 99 and year(dt) < 120 then
       xdate=CStr(year(dt)+1911)&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    elseif year(dt)>2000 and year(dt) < 2030 then
       xdate=CStr(year(dt)-89)&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    else       
       xdate=CStr(year(dt)+11)&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    end if   
End Function

Function sdate (dt)
    if Not IsNull(dt) then
       sdate=CStr((year(dt)-1911))&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    else
       sdate=""
    end if      
End Function

function FileUpLoad(FilePath,FName,Fsize,objUpload)
  	set objUpload = Server.CreateObject("Dundas.Upload")
	objUpload.MaxUploadSize = 10485760
	objUpload.UseUniqueNames = False
	objUpload.UseVirtualDir = True
	Set objNextFile = objUpload.GetNextFile()
   	objNextFile.Save(FilePath)
    FName = objNextFile.Filename
	For Each objUploadedFile in objUpload.Files  
		FSize = objUploadedFile.Size 
	Next
end function

Function ChineseMoney( lmoney )
sDallor = cstr( lMoney)
chDallor = array("", "拾", "佰", "仟", "萬","拾","佰", "仟","億","拾","佰", "仟","兆")
chB = array("", "萬","億","兆")
for i= 1 to len(sDallor) step 1
        if mid(sDallor, i, 1)<>"0" then
                xx = xx & mid(sDallor, i, 1) & chDallor(len(sDallor)-i) '&"萬"
        else
                if right(xx, 1)<>"零" then
                        If ((len(sDallor)-i) mod 4) = 0 then
                        xx = xx & chB( ( len(sDallor) - i) \ 4 )
                        else 
                        xx = xx & "零"
                        End If
                else
                        If ((len(sDallor)-i) mod 4) = 0 then
                        'msgbox "i = " & i & " xx=" & xx
                        xx= mid(xx, 1, len(xx)-1) & chB( ( len(sDallor) - i) \ 4 )
                        End If
                end if
        end if
next

        if right(xx, 1)="零" then xx = mid(xx,1,len(xx)-1)
        xx = replace( xx, "1", "壹")
        xx = replace( xx, "2", "貳")
        xx = replace( xx, "3", "參")
        xx = replace( xx, "4", "肆")
        xx = replace( xx, "5", "伍")
        xx = replace( xx, "6", "陸")
        xx = replace( xx, "7", "柒")
        xx = replace( xx, "8", "捌")
        xx = replace( xx, "9", "玖")

        ChineseMoney= xx & "元整"
End Function

Function GetDept()
    GetDept="0,,,"
    SQL="Select Client,PayName,Roturl,CheckCode From dept Where dept_id='C001'" 
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    If Not RS1.EOF Then 
      '商店代碼Client
      Client=RS1("Client")
      '連結URL
      PayName=RS1("PayName")
      '連結URL
      Roturl=RS1("Roturl")
      GetDept=Cstr(Client)&","&Cstr(PayName)&","&Cstr(Roturl)
    End If  
    RS1.Close
End Function

Function GetClose (gwsr,amount)
    GetClose=",,"
    SQL="Select Client,CheckCode,PayName From dept Where dept_id='C001'" 
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    If Not RS1.EOF Then 
      '商店代碼Client(6碼,靠右,不足左捕0)
      Client=Left("000000",6-Len(Cstr(RS1("Client")))) & Cstr(RS1("Client"))
      '商家檢查碼CkeckD
      CkeckD=Cstr(RS1("CheckCode"))
      '連結URL
      PayName=Cstr(RS1("PayName"))
    End If  
    RS1.Close
     
    If Client<>"" And CkeckD<>"" And PayName<>"" Then    
      If Csng(Client)<>3 Then
        '授權單號gwsrcode(10碼,靠右,不足左捕0)
        gwsrcode=Left("0000000000",10-Len(Cstr(gwsr))) & Cstr(gwsr)
        '金額money(8碼,靠右,不足左捕0)
        money=Left("00000000",8-Len(Cstr(amount))) & Cstr(amount)      
        '檢核碼CkeckE(9碼,靠右,不足左捕0)
        Ckeck=Client & gwsrcode & money
        CkeckA=""
        CkeckB=""
        For I = 1 To Len(Ckeck)
          If I>=5 Then
            If I Mod 5 = 0 Then
              If CkeckA<>"" Then
                CkeckA=CkeckA & Mid(Ckeck,I,1)
              Else
                CkeckA=Mid(Ckeck,I,1)
              End If
            End If  
          End If
          If I>=3 Then
            If I Mod 3 = 0 Then
              If CkeckB<>"" Then
                CkeckB=CkeckB & Mid(Ckeck,I,1)
              Else
                CkeckB=Mid(Ckeck,I,1)
              End If
            End If
          End If       
        Next
        '亂數碼CkeckC
        For I = 1 to 3
          Randomize
          CkeckC = CkeckC & Chr(int(10*Rnd)+48)
        Next
        CkeckE_Mod=(CkeckA*CkeckC+CkeckB) Mod CkeckD
        CkeckE=Left("000000000",9-Len(Cstr(CkeckE_Mod))) & Cstr(CkeckE_Mod)
        '關帳URL
        If PayName="ecpay" Then
          GetClose="https://ecpay.com.tw/g_get.php?" & "C" & Client & gwsrcode & money & CkeckE & CkeckC
        ElseIf PayName="gwpay" Then
          GetClose="https://gwpay.com.tw/close_get.php?" & "C" & Client & gwsrcode & money & CkeckE & CkeckC        
        End If
      Else
        GetClose="3"
      End If
      GetClose=GetClose
    End If 
End Function

Function RemoveHTML( strText )
    Dim RegEx
    Set RegEx = New RegExp
    RegEx.Pattern = "<[^>]*>"
    RegEx.Global = True
    If IsNull(strText) then
      RemoveHTML = ""
    Else
      RemoveHTML = RegEx.Replace(strText, "")
    End If
End Function
	
Function RQStr(s)
    RQStr = replace(s,"""","&quot;")
End Function
	
Sub DoEmailtoAdmin(MailTitle,MailBody)
    Set SPRec=Server.CreateObject("Adodb.Recordset")
    Sql="select * from dept where dept_id='KTA'"
    SPRec.Open Sql,Conn,1,1
    Set JMail = Server.CreateObject("JMail.Message")    
    JMail.Charset = "Big5"
    JMail.From = SPRec("email")
    JMail.FromName = SPRec("comp_shortname")
    JMail.MailServerUserName = "Webmaster@give.org.tw"
    JMail.MailServerPassWord = "TpicGIVE1679"
    JMail.Subject = MailTitle
    JMail.AddRecipient "elaine@himalaya.org.tw"
    JMail.Body = MailBody
    JMail.Priority = 3
    JMail.Send(SPRec("server_url"))
    Set JMail = Nothing
    SPRec.Close
    Set SPRec=Nothing
End Sub
	
Function GetDataValue(OutColumn,Condition,TableName,Conn)
    Set Fun12Rec = Server.CreateObject("ADODB.RecordSet") 
    Fun12Rec.Open "Select "&OutColumn&" from "&TableName&" where "&Condition, Conn, 1, 1
    If Fun12Rec.EOF then
      GetDataValue = "無"
    Else
      GetDataValue = Fun12Rec(OutColumn)
    End If
    Fun12Rec.Close
    Set Fun12Rec = Nothing
End Function

Function MediaPlay(data_url)
    echo "<object id='MediaPlayer' classid='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6' VIEWASTEXT>"
	echo "<param name='AllowChangeDisplaySize' value='1'>"
	echo "<PARAM name='autoStart' value='true'>"
	echo "<param name='AutoSize' value='0'>"
	echo "<param name='AnimationAtStart' value='1'>"
	echo "<param name='ClickToPlay' value='1'>"
	echo "<param name='EnableContextMenu' value='0'>"
	echo "<param name='EnablePositionControls' value='1'>"
	echo "<param name='EnableFullScreenControls' value='1'>"
	echo "<param name='URL' value='"&data_url&"'>"
	echo "<param name='ShowControls' value='1'>"
	echo "<param name='ShowAudioControls' value='1'>"
	echo "<param name='ShowDisplay' value='0'>"
	echo "<param name='ShowGotoBar' value='0'>"
	echo "<param name='ShowPositionControls' value='1'>"
	echo "<param name='ShowStatusBar' value='1'>"
	echo "<param name='ShowTracker' value='1'>"
	echo "<embed src='"&data_url&"' type='video/x-ms-wmv' width='1400' height='1050' autoStart='1' showControls='0' AutoSize='0' AnimationAtStart='1' ClickToPlay='1' EnableContextMenu='0' EnablePositionControls='1' EnableFullScreenControls='1' ShowControls='1' ShowAudioControls='1' ShowDisplay='0' ShowGotoBar='0' ShowPositionControls='1' ShowStatusBar='1' ShowTracker='1'></embed>"
	echo "</object>"
End Function

Function CheckSubmitJ (SubmitType)
  echo "document.form.action.value="""&SubmitType&""";" & Chr(13) & Chr(10)
  echo "document.form.submit();" & Chr(13) & Chr(10)
End Function

Function CheckEmailJ (FName)
  echo "if(document.form." & FName & ".value.indexOf(""@"")==-1||document.form." & FName & ".value.indexOf(""."")==-1){" & Chr(13) & Chr(10)
  echo "  alert('您輸入的電子郵件不合法！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function ChecklenJ(FName,CLength,ListField)'檢測中英文夾雜字串實際長度
  echo "var cnt=0;" & Chr(13) & Chr(10) 
  echo "var sName=document.form." & FName & ".value" & Chr(13) & Chr(10)
  echo "for(var i=0;i<sName.length;i++ ){" & Chr(13) & Chr(10)
  echo "  if (escape(sName.charAt(i)).length >= 4) cnt+=2;" & Chr(13) & Chr(10)   
  echo "  else cnt++;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "if(cnt>" & CLength & "){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位長度超過限制！');" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End function

Function CheckSubmit (SubmitType)
  echo "document.form.action.value="""&SubmitType&""";" & Chr(13) & Chr(10)
  echo "document.form.submit();" & Chr(13) & Chr(10)
End Function

Function CheckContentJ (FName,ListField)
  echo "var content=document.form." & FName & ".value.toLowerCase();" & Chr(13) & Chr(10)
  echo "var AryKey = new Array('script','Iframe','a href','url','drop','create','delete','table','""','1=1','--',';');" & Chr(13) & Chr(10)  
  echo "for(var i=0;i<=AryKey.length-1;i++){" & Chr(13) & Chr(10)
  echo "  if(content.indexOf(AryKey[i])!=-1){" & Chr(13) & Chr(10)
  echo "    alert('"& ListField & "  欄位請勿輸入 '+AryKey[i]+'  保留字元！');" & Chr(13) & Chr(10)
  echo "    return;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function 
?>
<SCRIPT language JavaScript>
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>