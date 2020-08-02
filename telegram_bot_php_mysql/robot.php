<?php
    include_once('config/Database.php');
    
    $produk = false;

    $database = new Database();
    $connect = $database->koneksi();
    

    $token = '1113737282:AAEuG4JH5COxd4CbPYus6EcrftczI4z9XMo';
    $url = 'https://api.telegram.org/bot'.$token;
   $telegram = json_decode(file_get_contents("php://input"), TRUE);
    $chatId = $telegram['message']['chat']['id'];
    $message = $telegram['message']['text'];
    
    $kata = explode(' ', $message);
    $perintah = $kata[0]; //harga atau perintah
    $keyword = $kata[1];
    
    
	$str = '';

	if($perintah == '/produk'){
	    $stmt = $connect->prepare("SELECT * FROM produk");
        $stmt->execute();
        $produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($produk AS $row){
            $str .= $row['produk'] . "\n";
        }
	    
	}
	else if($perintah == '/harga'){
	    
	    if($keyword){
	         $stmt = $connect->prepare("SELECT * FROM produk WHERE keyword LIKE  :keyword");
             $stmt->execute(['keyword' => '%' . $keyword. '%']);
             $produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    }
	    else{
	        $stmt = $connect->prepare("SELECT * FROM produk");
            $stmt->execute();
            $produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    }
	    
	    if($produk){
        foreach($produk AS $row){
            $str .= $row['produk'] . "\n";
            
            $arrHarga = json_decode($row['harga'], true);
            foreach($arrHarga AS $ukuran => $harga){
                $str .= $ukuran . '=' . number_format($harga) . "\n";
            }
            
            $str .= "\n";
        }
	    
	}
	
	else{
	    $str .= 'Produk yang anda cari tidak di temukan, silahkan cari produk lainnya';
	}
	}
	else if($perintah == '/start'){
	    $str .= 'Assalamualaikum, selamat datang di bot Dapoer Rose Cake. ' . "\n" . 'Disini kami menyediakan beberapa perintah, yaitu: ' ."\n" . '/produk : Untuk melihat daftar produk' . "\n" . '/harga : untuk melihat harga' ."\n" . '/kontak: untuk melihat kontak yang dapat dihubungi' ."\n" . '/zona_order: wilayah yang dapat dijangkau' . "\n" . '/cara_order : mengetahui cara order';
	}
	else if($perintah == '/kontak'){
	    $str .= 'Berikut daftar kontak yang dapat dihubungi : ' ."\n". "\n".'WA/tlp = 081234681069'."\n".'IG =@ dapoerrosecake'."\n". 'telegram = @dapoerrosecake'."\n".'gofood = dapoer rose cake'."\n".'grab food = dapoer rose cake'."\n".'g-maps = dapoer rose cake Bandung'."\n";
	}
    else if($perintah == '/zona_order'){
	    $str .= 'Berikut jangkauan wilayah sementara : ' ."\n". "\n".'1. Seluruh wilayah Jawa Barat'."\n".'2. Wilayah JABODETABEK'."\n". '3. Wilayah Jawa Tengah'."\n"."\n".'Untuk saat ini pelayanan kami baru bisa menjangkau 3 wilayah tersebut, apabila ada perubahan jangkauan kami akan selalu update :)'."\n";
	}
	else if($perintah == '/cara_order'){
	    $str .= 'Cara order : ' ."\n". "\n".'1. Hubungi kontak yang dapat dihubungi'. "\n".'2. Silahkan bertanya-tanya terlebih dahulu :)'."\n".'3. Untuk kue box minimal pemesanan 30 box'."\n". '4. Untuk kue jibeuh minimal pemesanan 30 pcs'."\n"."\n".'Note : Untuk pemesanan maksimal H-1.'."\n";
	}
	else if($perintah == 'terimakasih'){
	    $str .= 'sama-sama, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'ok'){
	    $str .= 'terimakasih, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'thx'){
	    $str .= 'sama-sama, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'terimakasih'){
	    $str .= 'sama-sama, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'thanks'){
	    $str .= 'sama-sama, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'thank'){
	    $str .= 'sama-sama, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'okay'){
	    $str .= 'terimakasih, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}
	else if($perintah == 'oke'){
	    $str .= 'terimakasih, apabila anda tertarik silahkan kunjungi dan follow instagram kami. ig: @dapoerrosecake';
	}

	
    $reply = urlencode($str);
    
    file_get_contents($url . '/sendmessage?chat_id=' . $chatId . '&text=' . $reply);
    

