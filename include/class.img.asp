<?php
Class IMAGE
	'���Φs���ܼ�
	Dim dataFile		'�p�ƾ������
	Dim imgType			'��X�ϧ�����
	Dim jpgQuality	'�~�� 0~100
	'�C���ݩ�
	Dim fgColor			'�e����
	Dim bgColor			'�I����
	Dim bdColor			'��ئ�
	Dim transparent	'�q�z��
	'�r���ݩ�
	Dim fontSize		'�r���j�p
	Dim fontColor		'�r���C��
	Dim fontFace		'�r��
	Dim fontBold		'����
	Dim fontItalic	'����
	'�e��
	Dim width				'�ϼe
	Dim height			'�ϰ�
	Dim width_plus	'�[�e�q
	Dim height_plus	'�[���q
	Dim bdSize			'��زʲ�

	'�����s���ݩ�,��k
	Private img			'�����Ϊ����ܼ�


  '�}�l�ɰ��檺�u�@
  Private Sub Class_Initialize()
		dataFile = "./counter.dat"
		imgType = 2
		jpgQuality = 100
		fontSize = 10
		fontColor = "#000000"
		bgColor = "#FFFFFF"
		fgColor = "#FFFFFF"
		bdSize = 1
		width_plus = 0
		height_plus = 0
		transparent = False
		set img = server.createobject("Overpower.ImageLib") 'Create�@�Ӫ��� 
  End Sub

  '�����ɰ��檺�u�@
  Private Sub Class_Terminate()
		'Nothing to do
		Set img = Nothing
  End Sub  

	'���ͼƦr
	Function Counter()		
		Dim cnt
		cnt = CStr(Read_Cnt_Data())
		ImageText(cnt)
	End Function

	'�ϧΦr
	Function ImageText(char)
		Dim imgwidth, imgheight
    SetFont() 
		imgwidth = img.GetTextWidth(char)+width_plus
		imgheight = img.GetTextHeight(char)+height_plus

		img.width = imgwidth '�]�w�����󪺼e�� 
		img.height = imgheight '�]�w�����󪺰��� 

		img.BrushColor = bgColor
		img.FillRect 0, 0, imgheight, imgwidth
		'(x1,y1) - (y2,x2)

		If bdColor<>Empty Then
			img.PenColor = bdColor
			img.PenWidth = bdSize
			pQty=1
			If bdSize Mod 2 = 1 Then pQty=0
			img.Box Int(bdSize/2), Int(bdSize/2), imgwidth-Int(bdSize/2)+pQty, imgheight-Int(bdSize/2)+pQty
			'(x1,y1) - (x2,y2)
		End If

		AddText char, width_plus/2, height_plus/2

		'��r, X, Y
		WriteImage("")
	End Function
 

	'��ܹϤ�
	Function ShowImage(imgFile, w, h)
		Dim imgwidth, imgheight
		'set img = server.createobject("Overpower.ImageLib") 'Create�@�Ӫ��� 
		GetImageSize(Server.MapPath(imgFile))

		imgwidth = w
		imgheight = height * w/width
		If h<>Empty Then imgheight=h
                
                If w<>"" Then 
		  imgwidth = w
		  imgheight = height * w/width
		  If h<>Empty Then imgheight=h
		Else
		  imgheight = h
		  imgwidth = width * h/height
		  If w<>Empty Then imgheight=w
		End If				
		img.width = imgwidth '�]�w�����󪺼e�� 
		img.height = imgheight '�]�w�����󪺰��� 

		FileName=Server.MapPath(imgFile)
		img.InsertPicture Filename, 0, 0, True, imgwidth, imgheight

		SetFont() 
		AddText text, 2, 2

		WriteImage("")
	End Function

	'�ഫ����
	Function TransImage(sf, df, w, h)
		Dim imgwidth, imgheight
		GetImageSize(Server.MapPath(sf))

                If w<>"" Then 
		  imgwidth = w
		  imgheight = height * w/width
		  If h<>Empty Then imgheight=h
		Else
		  imgheight = h
		  imgwidth = width * h/height
		  If w<>Empty Then imgheight=w
		End If
		img.width = imgwidth '�]�w�����󪺼e�� 
		img.height = imgheight '�]�w�����󪺰��� 

		FileName=Server.MapPath(sf)
		img.InsertPicture Filename, 0, 0, True, imgwidth, imgheight

		WriteImage(Server.MapPath(df))
	End Function
	
	'��X�Φs��
	Private Function WriteImage(df)
		Dim transColor
		transColor = ""
	  If transparent<>Empty Then
			transColor = bgColor
		End If

		If df<>Empty Then
			imgType = Right(df, 3)
			ImageType()
			img.SavePicture df, imgType, jpgQuality, transColor '������X����, ���s�� 
		Else
			ImageType()
			img.PictureBinaryWrite imgType, jpgQuality, transColor '������X����, ���s�� 
			'����.��k �ɮ�����, ���Y�~��, �ٲ��q�z�C��� 
		End IF

	End Function

	
	'�[��r
	Private Function AddText(char, x, y)
	  img.FontColor=fontColor
		img.TextOut char, x, y
	End Function
	
	'�ഫ�Ϥ����A���Ʀr
	Private Function ImageType()
    If LCase(imgType)="bmp" Then 
			imgType=1
		ElseIf LCase(imgType)="gif" Then 
			imgType=2
		ElseIf LCase(imgType)="jpg" Then 
			imgType=3
		End If
		ImageType = imgType
	End Function

  '�]�w�r���ݩ�
	Private Function setFont
		img.fontSize   = fontSize
		img.fontColor  = fontColor
		img.fontFace   = fontFace
		img.fontBold   = fontBold
		img.fontItalic = fontItalic
	End Function
	
	'Ū�Ʀr&�֥[
	Private Function Read_Cnt_Data()
			Dim fs, txtf, fileName, cnt
			fileName = Server.MapPath(dataFile)
			Set fs = Server.CreateObject("Scripting.FileSystemObject")
			
			Set txtf = fs.OpenTextFile(fileName, 1, True)
			If Not txtf.atEndOfStream Then cnt = txtf.ReadLine
			txtf.Close

			cnt = Clng(cnt)+1

			Set txtf = fs.OpenTextFile(fileName, 2, True)
			txtf.WriteLine cnt
			txtf.Close

			Set fs = Nothing
			Read_Cnt_Data = cnt
	End Function

	'���o���ɤؤo
	Private Function GetImageSize(imgFile)
		img.PictureSize imgFile, width, height
	End Function
End Class
?>