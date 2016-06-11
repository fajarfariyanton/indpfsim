<?php
$keyword= 'volvo wiring diagram';
$html= GET_WOW_DATA($keyword);
//print_r($html);exit;

$konten='';
foreach($html as $item){
	$titles= $item['title'];
	$description= $item['description'];
	$slug= str_replace(' ', '-', $titles);
	$title= ucwords($titles);
	if(!empty($item['link'])){
		$lilink= '/'.$item['link'];
	}else{
		$lilink= '/'.$slug.'.pdf';
	}
	$konten .= '<article><h2><a href="http://'.$_SERVER['SERVER_NAME'].'/'.$slug.'.pdf">'.$title.'</a></h2>
	<h3>'.$lilink.'</h3>
	<p>'.$description.'</p></article><hr/>';
	$_meta[]= $title;
}

$file_id= substr(uniqid(),9,4);
$date= date('d M').', 2014';
$file_keyword= strtoupper($keyword);
$keyword_array= explode(' ', $keyword);
$category= strtoupper($keyword_array[0]);
$_meta= implode(' , ', $_meta);

$full_konten= '<html>
   <head>
      <title>'.$file_keyword.'</title>
	  <meta name="description" content="'.$_meta.'">
	  <meta name="keywords" content="'.$_meta.'">
<style>
header{ text-align: center;}
h2,h3,p{margin:0px;}
h3{color: #006d21;}
</style>	 
   </head>
   <body>
      <header>
         <h1>'.$file_keyword.'</h1>
         <p><time>'.$date.'</time> - Free Download '.$file_keyword.'</p>
      </header>	  
	 <section>
	 '.$konten.'	 
	 </section>
   </body>
</html>';

//echo $full_konten;exit;

echo to_pdf($full_konten, $keyword);









function to_pdf($html,$keyword){
	$posisi_file_pdf= str_replace(' ', '-', $keyword).'.pdf';
include("mpdf.php");
$mpdf=new mPDF('c', array(300, 700)); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetTitle($keyword);
$mpdf->SetSubject($_meta);
$mpdf->SetKeywords($_meta);
$mpdf->SetCreator($keyword);
$mpdf->SetAuthor($keyword);
/*
$mpdf->SetWatermarkText('GOOGLE Inc.');
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->showWatermarkText = true;
*/
$mpdf->WriteHTML($html);
$mpdf->Output($keyword.'.pdf', 'I');//render output
//$mpdf->Output($posisi_file_pdf, 'F');//simpan jadi file	
}








function GET_BING_DATA($keyword){
$keyword= potong_kata($keyword);	
    $data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.
	
         curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($data, CURLOPT_URL, 'http://www.bing.com:80/search?q='.urlencode($keyword).'&format=rss&count=50');
	 curl_setopt($data, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, 'https://www.google.com');
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 8);
	 curl_setopt($data, CURLOPT_TIMEOUT, 8);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 2);

     $hasil = @simplexml_load_string(curl_exec($data));
     curl_close($data);	
		if(empty($hasil)){return null;}
	 
	 if(!isset($hasil->channel->item)){
		 return null;
	 }
	 if(empty($hasil->channel->item)){
		 return null;
	 }

$has_arr= array();	 
foreach($hasil->channel->item as $item){
$clean_titleku= trim(preg_replace('![^a-z0-9]+!i', ' ', $item->title->__toString()));
$jumjum_title= str_word_count($clean_titleku);
	if($jumjum_title > 3){
$ass= trim(remove_tld($clean_titleku));
$ass= strtolower($ass);
$dedes= trim(preg_replace('![^a-z0-9]+!i', ' ', remove_tld($item->description->__toString())));
$hihi['title']= $ass;
$hihi['description']= $dedes;
$hihi['link']= preg_replace('/(.*)\//i', '', $item->link->__toString());
$has_arr[]= $hihi;
	}
}
return $has_arr;
}


function GET_WOW_DATA($keyword){
$keyword= potong_kata($keyword);	
    $data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.
	
         curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($data, CURLOPT_URL, 'http://us.wow.com/search?q='.urlencode($keyword));
	 curl_setopt($data, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, 'https://www.google.com/bot.html');
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 8);
	 curl_setopt($data, CURLOPT_TIMEOUT, 8);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 2);

     $hasil = curl_exec($data);
     curl_close($data);
libxml_use_internal_errors(true);
$dom_document = new DOMDocument();      
$dom_document->loadHTML($hasil);
$dom_xpath = new DOMXpath($dom_document);
	if($dom_xpath->query('//h3[@class="hac"]/a/@href') == null || $dom_xpath->query('//h3[@class="hac"]/a/@href') === null){
		return null;
	}
$data_a = $dom_xpath->query('//h3[@class="hac"]/a/@href');
$data_b = $dom_xpath->query('//h3[@class="hac"]');
$data_c = $dom_xpath->query('//p[@property="f:desc"]');

$i=0;
	foreach($data_a as $item){
		$items['title']= strtolower(trim(preg_replace('![^a-z0-9]+!i', ' ', remove_tld($data_b->item($i)->nodeValue))));
		$items['link']= preg_replace('/(.*)\//i', '', $data_a->item($i)->nodeValue);
		$items['description']= trim(preg_replace('![^a-z0-9]+!i', ' ', remove_tld($data_c->item($i)->nodeValue)));
		$hasilq[]= $items;
		++$i;
	}
return $hasilq;
}



function GET_DUCDUCK_DATA($keyword){
$keyword= potong_kata($keyword);	
    $data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.
	
         curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($data, CURLOPT_URL, 'https://duckduckgo.com/d.js?q='.urlencode($keyword).'&t=D&l=wt-wt&p=1&s=0&ct=US&ss_mkt=us&sp=0');
	 curl_setopt($data, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, 'https://www.google.com/bot.html');
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 8);
	 curl_setopt($data, CURLOPT_TIMEOUT, 8);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 2);

     $hasil = curl_exec($data);
     curl_close($data);
	 $array= explode('},{', $hasil);
	 array_shift($array);
	 array_pop($array);
	 foreach($array as $item){
		if(preg_match('/"t":"(.*)","/i', $item, $hasila)){
			$items['title']= strtolower(trim(preg_replace('![^a-z0-9]+!i', ' ', remove_tld(preg_replace('/<[^>]+>/i', ' ', $hasila[1])))));
		}
		if(preg_match('/"a":"(.*)","da"/i', $item, $hasilb)){
			$items['description']= strtolower(trim(preg_replace('![^a-z0-9]+!i', ' ', preg_replace('/<[^>]+>/i', '', $hasilb[1]))));
		}
		if(preg_match('/"u":"(.*)","h"/i', $item, $hasilc)){
			$items['link']= preg_replace('/(.*)\//i', '', $hasilc[1]);
		}
		
			if(!preg_match('/\.([a-z0-9\.]+)\//i', $items['title'])){
		$hasilq[]= $items;
			}
	 }
return $hasilq; 
}




function GET_AOL_DATA($keyword){
$keyword= potong_kata($keyword);	
    $data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.
	
         curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($data, CURLOPT_URL, 'http://search.aol.com/aol/search?s_it=sb-top&v_t=cs-port&q='.urlencode($keyword));
	 curl_setopt($data, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, 'https://www.google.com/bot.html');
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 8);
	 curl_setopt($data, CURLOPT_TIMEOUT, 8);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 2);

     $hasil = curl_exec($data);
     curl_close($data);
libxml_use_internal_errors(true);
$dom_document = new DOMDocument();      
$dom_document->loadHTML($hasil);
$dom_xpath = new DOMXpath($dom_document);
	if($dom_xpath->query('//h3[@class="hac"]/a/@href') == null || $dom_xpath->query('//h3[@class="hac"]/a/@href') === null){
		return null;
	}
$data_a = $dom_xpath->query('//h3[@class="hac"]/a/@href');
$data_b = $dom_xpath->query('//h3[@class="hac"]');
$data_c = $dom_xpath->query('//p[@property="f:desc"]');

$i=0;
	foreach($data_a as $item){
		$items['title']= strtolower(trim(preg_replace('![^a-z0-9]+!i', ' ', remove_tld($data_b->item($i)->nodeValue))));
		$items['link']= preg_replace('/(.*)\//i', '', $data_a->item($i)->nodeValue);
		$items['description']= trim(preg_replace('![^a-z0-9]+!i', ' ', remove_tld($data_c->item($i)->nodeValue)));
		$hasilq[]= $items;
		++$i;
	}
return $hasilq;
}





function CACHE_REQUEST($QUERY, $SE){
	//SE= BING,AOL,WOW,DUCKDUCK
$keyword= strtolower($QUERY);
$kslug= str_replace(' ', '-', $keyword);
$folder= substr(md5($kslug),0,2);
$nama_folder= 'SEARCH_CACHE/'.$SE.'/'.$folder;
	if(!file_exists($nama_folder)){
		$oldmask = umask(0);
		mkdir($nama_folder, 0777);
		umask($oldmask);
	}
$filename= $nama_folder.'/'.$kslug.'.'.$SE;
	if(file_exists($filename)){
		$cache = unserialize(file_get_contents($filename));
		return $cache;
	}
if($SE == 'BING'){
	$has_arr= GET_BING_DATA($QUERY);
}elseif($SE == 'AOL'){
	$has_arr= GET_AOL_DATA($QUERY);
}elseif($SE == 'WOW'){
	$has_arr= GET_WOW_DATA($QUERY);
}elseif($SE == 'DUCKDUCK'){
	$has_arr= GET_DUCDUCK_DATA($QUERY);
}
	
//cache it
			if($has_arr != null){
		$cache = fopen($filename,'w');
        fwrite($cache, serialize($has_arr));
		fclose($cache);
			}
//end cache it
	return $has_arr;
}


function potong_kata($s, $lenght=5) {
     $lenght= $lenght-1;
	 $count= str_word_count($s);
	  if($count > 5){
    return preg_replace('/((\w+\W*){'.$lenght.'}(\w+))(.*)/', '${1}', $s);    
	  }
	return $s;
}

function remove_tld($kl){
$rep = preg_replace('/(www\.|\.com|\.org|\.net|\.int|\.edu|\.gov|\.mil|\.ac|\.ad|\.ae|\.af|\.ag|\.ai|\.al|\.am|\.an|\.ao|\.aq|\.ar|\.as|\.at|\.au|\.aw|\.ax|\.az|\.ba|\.bb|\.bd|\.be|\.bf|\.bg|\.bh|\.bi|\.bj|\.bm|\.bn|\.bo|\.bq|\.br|\.bs|\.bt|\.bv|\.bw|\.by|\.bz|\.bzh|\.ca|\.cc|\.cd|\.cf|\.cg|\.ch|\.ci|\.ck|\.cl|\.cm|\.cn|\.co|\.cr|\.cs|\.cu|\.cv|\.cw|\.cx|\.cy|\.cz|\.dd|\.de|\.dj|\.dk|\.dm|\.do|\.dz|\.ec|\.ee|\.eg|\.eh|\.er|\.es|\.et|\.eu|\.fi|\.fj|\.fk|\.fm|\.fo|\.fr|\.ga|\.gb|\.gd|\.ge|\.gf|\.gg|\.gh|\.gi|\.gl|\.gm|\.gn|\.gp|\.gq|\.gr|\.gs|\.gt|\.gu|\.gw|\.gy|\.hk|\.hm|\.hn|\.hr|\.ht|\.hu|\.id|\.ie|\.il|\.im|\.in|\.io|\.iq|\.ir|\.is|\.it|\.je|\.jm|\.jo|\.jp|\.ke|\.kg|\.kh|\.ki|\.km|\.kn|\.kp|\.kr|\.krd|\.kw|\.ky|\.kz|\.la|\.lb|\.lc|\.li|\.lk|\.lr|\.ls|\.lt|\.lu|\.lv|\.ly|\.ma|\.mc|\.md|\.me|\.mg|\.mh|\.mk|\.ml|\.mm|\.mn|\.mo|\.mp|\.mq|\.mr|\.ms|\.mt|\.mu|\.mv|\.mw|\.mx|\.my|\.mz|\.na|\.nc|\.ne|\.nf|\.ng|\.ni|\.nl|\.no|\.np|\.nr|\.nu|\.nz|\.om|\.pa|\.pe|\.pf|\.pg|\.ph|\.pk|\.pl|\.pm|\.pn|\.pr|\.ps|\.pt|\.pw|\.py|\.qa|\.re|\.ro|\.rs|\.ru|\.rw|\.sa|\.sb|\.sc|\.sd|\.se|\.sg|\.sh|\.si|\.sj|\.sk|\.sl|\.sm|\.sn|\.so|\.sr|\.ss|\.st|\.su|\.sv|\.sx|\.sy|\.sz|\.tc|\.td|\.tf|\.tg|\.th|\.tj|\.tk|\.tl|\.tm|\.tn|\.to|\.tp|\.tr|\.tt|\.tv|\.tw|\.tz|\.ua|\.ug|\.uk|\.us|\.uy|\.uz|\.va|\.vc|\.ve|\.vg|\.vi|\.vn|\.vu|\.wf|\.ws|\.ye|\.yt|\.yu|\.za|\.zm|\.zr|\.zw|\.academy|\.accountants|\.active|\.actor|\.adult|\.aero|\.agency|\.airforce|\.app|\.archi|\.army|\.associates|\.attorney|\.auction|\.audio|\.autos|\.band|\.bar|\.bargains|\.beer|\.best|\.bid|\.bike|\.bio|\.biz|\.black|\.blackfriday|\.blog|\.blue|\.boo|\.boutique|\.build|\.builders|\.business|\.buzz|\.cab|\.camera|\.camp|\.cancerresearch|\.capital|\.cards|\.care|\.career|\.careers|\.cash|\.catering|\.center|\.ceo|\.channel|\.cheap|\.christmas|\.church|\.city|\.claims|\.cleaning|\.click|\.clinic|\.clothing|\.club|\.coach|\.codes|\.coffee|\.college|\.community|\.company|\.computer|\.condos|\.construction|\.consulting|\.contractors|\.cooking|\.cool|\.country|\.credit|\.creditcard|\.cricket|\.cruises|\.dad|\.dance|\.dating|\.day|\.deals|\.degree|\.delivery|\.democrat|\.dental|\.dentist|\.diamonds|\.diet|\.digital|\.direct|\.directory|\.discount|\.domains|\.eat|\.education|\.email|\.energy|\.engineer|\.engineering|\.equipment|\.esq|\.estate|\.events|\.exchange|\.expert|\.exposed|\.fail|\.farm|\.fashion|\.feedback|\.finance|\.financial|\.fish|\.fishing|\.fit|\.fitness|\.flights|\.florist|\.flowers|\.fly|\.foo|\.forsale|\.foundation|\.fund|\.furniture|\.gallery|\.garden|\.gift|\.gifts|\.gives|\.glass|\.global|\.gop|\.graphics|\.green|\.gripe|\.guide|\.guitars|\.guru|\.healthcare|\.help|\.here|\.hiphop|\.hiv|\.holdings|\.holiday|\.homes|\.horse|\.host|\.hosting|\.house|\.how|\.info|\.ing|\.ink|\.institute|\.insure|\.international|\.investments|\.jobs|\.kim|\.kitchen|\.land|\.lawyer|\.legal|\.lease|\.lgbt|\.life|\.lighting|\.limited|\.limo|\.link|\.loans|\.lotto|\.luxe|\.luxury|\.management|\.market|\.marketing|\.media|\.meet|\.meme|\.memorial|\.menu|\.mobi|\.moe|\.money|\.mortgage|\.motorcycles|\.mov|\.museum|\.name|\.navy|\.network|\.new|\.ngo|\.ninja|\.one|\.ong|\.onl|\.ooo|\.organic|\.partners|\.parts|\.party|\.pharmacy|\.photo|\.photography|\.photos|\.physio|\.pics|\.pictures|\.pink|\.pizza|\.place|\.plumbing|\.poker|\.porn|\.post|\.press|\.pro|\.productions|\.prof|\.properties|\.property|\.qpon|\.recipes|\.red|\.rehab|\.ren|\.rentals|\.repair|\.report|\.republican|\.rest|\.reviews|\.rich|\.rip|\.rocks|\.rodeo|\.rsvp|\.sale|\.science|\.services|\.sexy|\.shoes|\.singles|\.social|\.software|\.solar|\.solutions|\.space|\.supplies|\.supply|\.support|\.surf|\.surgery|\.systems|\.tattoo|\.tax|\.technology|\.tel|\.tips|\.tires|\.today|\.tools|\.top|\.town|\.toys|\.trade|\.training|\.travel|\.university|\.vacations|\.vet|\.video|\.villas|\.vision|\.vodka|\.vote|\.voting|\.voyage|\.wang|\.watch|\.webcam|\.website|\.wed|\.wedding|\.whoswho|\.wiki|\.work|\.works|\.world|\.wtf|\.xxx|\.xyz|\.yoga|\.zone)/i', '', $kl);
$rep = trim($rep, ' ');
return $rep;
}