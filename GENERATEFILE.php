<?php
include("MPDF/mpdf.php");
$get_title= $_GET['title'];
$get_id= $_GET['id'];
$keyword= $get_id.' '.str_replace('-', ' ', $get_title);

$html = '
<style>
.shadowtitle { 
	height: 8mm; 
	background-color: #EEDDFF; 
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
	padding: 0.8em; 
	padding-left: 3em;
	font-family:sans;
	font-size: 10pt; 
	font-weight: bold;
	border: 0.2mm solid white;
	border-radius: 0.2em;
	box-shadow: 0 0 1em 0.5em rgba(0,0,255,0.5);
	color: #AAAACC;
	text-shadow: 0.03em 0.03em #666, 0.05em 0.05em rgba(127,127,127,0.5), -0.015em -0.015em white;
}
h1{ text-align:center;}
font{font-weight:bold;}
.download {display:block; margin: 0px auto; text-align: center;}
</style>
<body style="background-gradient: linear #88FFFF #FFFF44 0 0.5 1 0.5;">
<pageheader name="myHeaderNoNum" content-left="'.$keyword.'" content-center="" content-right="GOOGLE BOOK OFFICIAL" header-style="font-family:sans-serif; font-size:8px; font-style:italic; color:#000000;" header-style-right="font-size:12px; font-weight:normal; font-style:italic; color:#000000;" line="on" />
<pagefooter name="myFooter1" content-left="'.$keyword.'" content-center="" content-right="GOOGLE BOOK OFFICIAL" footer-style="font-family:sans-serif; font-size:8pt; color:#000000;" footer-style-left="font-size:12px; font-weight:normal; font-style:italic; color:#000000;" line="on" />
<setpageheader name="myHeaderNoNum" page="O" value="on" show-this-page="1" />
<sethtmlpagefooter name="myFooter1" page="O" value="on" show-this-page="1" />

<div class="shadowtitle">'.$keyword.'</div>
<h1>'.strtoupper($keyword).'</h1>
<br>
<p class="text_content">
<strong>'.$keyword.'</strong> contains important information and a detailed explanation about '.$keyword.', 
its contents of the package, names of things and what they do, setup, and operation. Before using this
unit, we are encourages you to read this user guide in order for this unit to function properly.
This manuals E-books that published today as a guide. Our site has the following <em>'.$keyword.'</em>
available for free PDF download. You may find <u>'.$keyword.'</u> document other than just manuals as
we also make available many user guides, specifications documents, promotional details, setup documents and
more.</p>

<p>More importantly, you may have made a second hand purchase '.$keyword.' uwv and when the time
comes that you actually need it - something gets broken, or there is a feature you need to learn about - lo and
behold, said <i>'.$keyword.'</i> is nowhere to be found. However, there is still hope in this digital age of
internet information sharing, even if you are searching <b>'.$keyword.'</b> for that obscure out-of-print
ebooks.</p>

<p><i>'.$keyword.'</i> can be very useful guide, and <strong>'.$keyword.'</strong> play an important role in
your products. The problem is that once you have gotten your nifty new product, the <u>'.$keyword.'</u>
gets a brief glance, maybe a once over, but it often tends to get discarded or lost with the original packaging.
</p>

<br><br><br>
<div class="download"><a href="http://dafamediagroup.work/'.$get_title.'.pdf"><img src="http://i.imgur.com/V0jslJd.png"></a></div>
';


//==============================================================
//==============================================================
//==============================================================

$mpdf=new mPDF('c', array(350,300)); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetTitle($keyword);
$mpdf->SetSubject($keyword);
$mpdf->SetKeywords($keyword);
$mpdf->SetCreator($keyword);
$mpdf->SetAuthor($keyword);

$mpdf->SetWatermarkText('GOOGLE Inc.');
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->showWatermarkText = true;

$mpdf->WriteHTML($html);
$mpdf->Output($posisi_file_pdf, 'I');//render output
//$mpdf->Output($posisi_file_pdf, 'F');//simpan jadi file
$mpdf->close();
//==============================================================
//==============================================================
//==============================================================
?>