<?php
    // Loại bỏ kí tự trắng
    $domain = trim(preg_replace('/\s+/',' ', $_POST['domain']));

    if(!$_POST['domain'] || !$domain){
        exit(json_encode(array(
                'code' => false,
                'status' => 'Không được để trống'
        )));  
    }

    $headers = array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5",
        "Cache-Control: max-age=0",
        "Connection: keep-alive",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.88 Safari/537.36"
    );
        
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://whois.inet.vn/api/whois/domainspecify/".$domain);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($data);

    if($json->code == 0){
        // tự code thêm các result khác
        exit(json_encode(array(
                'code' => true,
                'domain' => $domain,
                'status' => $json->status[0],
                'register' => $json->registrar
        )));  
    }else{
        exit(json_encode(array(
                'code' => false,
                'status' => $domain.' '.$json->message
        )));  
    }

?>
