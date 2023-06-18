<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Credit;
use App\Models\Wallet;
use App\Models\EmailLog;
use App\Models\Extension;
use App\Models\AdminToken;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

function check()
{
	return 'a';
}
function notif($mobile, $email)
{
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://graph.facebook.com/v16.0/109793408728806/messages',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => '{
        "messaging_product": "whatsapp",
        "to": "6281277967050",
        "type": "template",
        "template": {
        "name": "user_login",
        "language": {
            "code": "id"
        },
        "components": [
            {
                "type": "body",
                "parameters": [
                    {
                        "type": "text",
                        "text": "' . $email . '"
                    },
                    {
                        "type": "text",
                        "text": "' . $mobile . '"
                    }
                ]
            }
        ]
    }
    }',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer EAAK07QQQ1mMBALoNFqDGjIhJp8iWZBE2zVYgK9k2GHZB2ZBVGTKO9ClKIjBwm5Hr9ZBAR2MrUAafeiJSEqQ56O5BqVPsXXeZAOKVxEfUqWcOMSt2tdWi5GWtPhXY2kfKOrOXc6FdB7pVealHdW20g7PZBVAbgOsOw2vfdexPl2RPyDXqggZCcSg',
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);
	// dd($response);
	// echo $response;

	curl_close($curl);
}

function waRegister($mobile)
{
	$curl = curl_init();
	curl_setopt_array($curl, array(
		// CURLOPT_URL => 'https://graph.facebook.com/v16.0/105710885781444/messages',
		CURLOPT_URL => 'https://graph.facebook.com/v16.0/114279288296878/messages',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => '{
        "messaging_product": "whatsapp",
        "to": "' . $mobile . '",
        "type": "template",
        "template": {
            "name": "registrasi",
            "language": {
                "code": "id"
            }
        }
    }',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer EAAK07QQQ1mMBANSrUN0x5dG84vZCslXR17YeDDTQqGYofnDBpUS94sEwPRRKGLyWLOeBZA6vx2HlLN0C7zyTAhglZC3WOEDql2ZAhqQtrOKan6QzcHKYSwgiemSv5qtGZBCqT9zKaBruTiO8mPm3lIg8qWcJAN9joLG731nHXHLXPCC4HdiHAXUI2P0lawD5ccbZAB8vivHwZDZD',
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);
	// dd($response);
	echo $response;

	curl_close($curl);
}

function sendSMS($phone, $message)
{
	$to      = $phone;
	$text    = $message;
	$pecah   = explode(",", $to);
	$jumlah  = count($pecah);
	$from    = "MiningCloud";                                                          //Sender ID or SMS Masking Name, DO NOT LEAVE BLANK, sms will not be sent
	$apikey  = "b6855ac17868dfbf1bdfc613e36efbb6-4cd84372-7064-4c80-9385-d9bd000dae30";     //Get your API Key from our sms dashboard
	$postUrl = "https://api.smsviro.com/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS

	for ($i = 0; $i < $jumlah; $i++) {
		if (substr($pecah[$i], 0, 2) == "62" || substr($pecah[$i], 0, 3) == "+62") {
			$pecah = $pecah;
		} elseif (substr($pecah[$i], 0, 1) == "0") {
			$pecah[$i][0] = "X";
			$pecah = str_replace("X", "62", $pecah);
		} else {
			echo "Invalid mobile number format";
		}
		$destination = array("to" => $pecah[$i]);
		$message     = array(
			"from" => $from,
			"destinations" => $destination,
			"text" => $text,
			"smsCount" => 2
		);
		$postData           = array("messages" => array($message));
		$postDataJson       = json_encode($postData);
		$ch                 = curl_init();
		$header = array("Content-Type:application/json", "Accept:application/json", "Authorization: App " . $apikey);

		curl_setopt($ch, CURLOPT_URL, $postUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$responseBody = json_decode($response);
		curl_close($ch);
	}
	return $responseBody;
}
function smsBulkGate($phone, $message)
{
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_URL => 'https://portal.bulkgate.com/api/1.0/simple/transactional',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode([
			'application_id' => '4799',
			'application_token' => 'YswH91PAmk1OloRE5D1RpKqU9rp0uGDgZhPvTlcagzm1xTzJGH',
			'number' => '62' . trim($phone, '0'),
			// 'text' => 'Management Elexito mengucapkan selamat atas bonus anda tgl '.$datenew.' sebesar Rp. '.number_format($key->sum,0).'. Salam Sukses, Elexito',
			'text' => $message,
			'sender_id' => 'gText',
			'sender_id_value' => 'ELEXITO'
		]),
		CURLOPT_HTTPHEADER => [
			'Content-Type: application/json'
		],
	]);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}


function smsTwilio($phone, $message)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/AC98df75a2099487a93bafbae81b7caa36/Messages');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "Body=$message&From=12182756368&To=$phone");
	curl_setopt($ch, CURLOPT_USERPWD, 'AC98df75a2099487a93bafbae81b7caa36' . ':' . 'cd37c10796ccd89f3e025ddd459ec9f6');

	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	return $result;
}



//moveable
function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
	$path = makeDirectory($location);
	if (!$path) throw new Exception('File could not been created.');

	if ($old) {
		removeFile($location . '/' . $old);
		removeFile($location . '/thumb_' . $old);
	}
	$filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
	$image = Image::make($file);
	if ($size) {
		$size = explode('x', strtolower($size));
		$image->resize($size[0], $size[1]);
	}
	$image->save($location . '/' . $filename);

	if ($thumb) {
		$thumb = explode('x', $thumb);
		Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
	}

	return $filename;
}

function uploadFile($file, $location, $size = null, $old = null)
{
	$path = makeDirectory($location);
	if (!$path) throw new Exception('File could not been created.');

	if ($old) {
		removeFile($location . '/' . $old);
	}

	$filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
	$file->move($location, $filename);
	return $filename;
}

function makeDirectory($path)
{
	if (file_exists($path)) return true;
	return mkdir($path, 0755, true);
}


function removeFile($path)
{
	return file_exists($path) && is_file($path) ? @unlink($path) : false;
}



function str_limit($title = null, $length = 10)
{
	return \Illuminate\Support\Str::limit($title, $length);
}

//moveable
function getIpInfo()
{
	$ip = $_SERVER["REMOTE_ADDR"];

	//Deep detect ip
	if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}

	$xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


	$country = @$xml->geoplugin_countryName;
	$city = @$xml->geoplugin_city;
	$area = @$xml->geoplugin_areaCode;
	$code = @$xml->geoplugin_countryCode;
	$long = @$xml->geoplugin_longitude;
	$lat = @$xml->geoplugin_latitude;

	$data['country'] = $country;
	$data['city'] = $city;
	$data['area'] = $area;
	$data['code'] = $code;
	$data['long'] = $long;
	$data['lat'] = $lat;
	$data['ip'] = request()->ip();
	$data['time'] = date('d-m-Y h:i:s A');


	return $data;
}
function getIpDetail($ip)
{
	$xml     = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);
	$country = @$xml->geoplugin_countryName;
	$city    = @$xml->geoplugin_city;
	$area    = @$xml->geoplugin_areaCode;
	$code    = @$xml->geoplugin_countryCode;
	$long    = @$xml->geoplugin_longitude;
	$lat     = @$xml->geoplugin_latitude;

	$data['country'] = $country;
	$data['city']    = $city;
	$data['area']    = $area;
	$data['code']    = $code;
	$data['long']    = $long;
	$data['lat']     = $lat;
	$data['ip']      = $ip;
	$data['time']    = date('d-m-Y h:i:s A');

	return $data;
}
//moveable
function osBrowser()
{
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	$osPlatform = "Unknown OS Platform";
	$osArray = array(
		'/windows nt 10/i' => 'Windows 10',
		'/windows nt 6.3/i' => 'Windows 8.1',
		'/windows nt 6.2/i' => 'Windows 8',
		'/windows nt 6.1/i' => 'Windows 7',
		'/windows nt 6.0/i' => 'Windows Vista',
		'/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
		'/windows nt 5.1/i' => 'Windows XP',
		'/windows xp/i' => 'Windows XP',
		'/windows nt 5.0/i' => 'Windows 2000',
		'/windows me/i' => 'Windows ME',
		'/win98/i' => 'Windows 98',
		'/win95/i' => 'Windows 95',
		'/win16/i' => 'Windows 3.11',
		'/macintosh|mac os x/i' => 'Mac OS X',
		'/mac_powerpc/i' => 'Mac OS 9',
		'/linux/i' => 'Linux',
		'/ubuntu/i' => 'Ubuntu',
		'/iphone/i' => 'iPhone',
		'/ipod/i' => 'iPod',
		'/ipad/i' => 'iPad',
		'/android/i' => 'Android',
		'/blackberry/i' => 'BlackBerry',
		'/webos/i' => 'Mobile'
	);
	foreach ($osArray as $regex => $value) {
		if (preg_match($regex, $userAgent)) {
			$osPlatform = $value;
		}
	}
	$browser = "Unknown Browser";
	$browserArray = array(
		'/msie/i' => 'Internet Explorer',
		'/firefox/i' => 'Firefox',
		'/safari/i' => 'Safari',
		'/chrome/i' => 'Chrome',
		'/edge/i' => 'Edge',
		'/opera/i' => 'Opera',
		'/netscape/i' => 'Netscape',
		'/maxthon/i' => 'Maxthon',
		'/konqueror/i' => 'Konqueror',
		'/mobile/i' => 'Handheld Browser'
	);
	foreach ($browserArray as $regex => $value) {
		if (preg_match($regex, $userAgent)) {
			$browser = $value;
		}
	}

	$data['os_platform'] = $osPlatform;
	$data['browser'] = $browser;

	return $data;
}

function siteName()
{
	$general = GeneralSetting::first();
	$sitname = str_word_count($general->sitename);
	$sitnameArr = explode(' ', $general->sitename);
	if ($sitname > 1) {
		$title = "<span>$sitnameArr[0] </span> " . str_replace($sitnameArr[0], '', $general->sitename);
	} else {
		$title = "<span>$general->sitename</span>";
	}

	return $title;
}


function getPageSections($arr = false)
{

	$jsonUrl = resource_path('views/') .  'sections.json';
	$sections = json_decode(file_get_contents($jsonUrl));
	if ($arr) {
		$sections = json_decode(file_get_contents($jsonUrl), true);
		ksort($sections);
	}
	return $sections;
}


function getImage($image, $size = null)
{
	$clean = '';
	if (file_exists($image) && is_file($image)) {
		return asset($image) . $clean;
	}
	if ($size) {
		return route('placeholder.image', $size);
	}
	return asset('assets/images/default.png');
}

function notify($user, $type, $shortCodes = null)
{

	sendEmail($user, $type, $shortCodes);
	/** Disable For Error */
	// sendSms($user, $type, $shortCodes);
}


function getPaginate($paginate = 10)
{
	return $paginate;
}

function paginateLinks($data, $design = 'admin.partials.paginate')
{
	return $data->appends(request()->all())->links($design);
}

function imagePath()
{
	$data['gateway'] = [
		'path' => 'assets/images/gateway',
		'size' => '800x800',
	];
	$data['verify'] = [
		'withdraw' => [
			'path' => 'assets/images/verify/withdraw'
		],
		'deposit' => [
			'path' => 'assets/images/verify/deposit'
		]
	];
	$data['image'] = [
		'default' => 'assets/images/default.png',
	];
	$data['withdraw'] = [
		'method' => [
			'path' => 'assets/images/withdraw/method',
			'size' => '800x800',
		]
	];
	$data['ticket'] = [
		'path' => 'assets/support',
	];
	$data['language'] = [
		'path' => 'assets/images/lang',
		'size' => '64x64'
	];
	$data['logoIcon'] = [
		'path' => 'assets/images/logoIcon',
	];
	$data['slides'] = [
		'path' => 'assets/images/slides',
	];
	$data['promotions'] = [
		'path' => 'assets/images/promotions',
	];
	$data['frontweb'] = [
		'path' => 'assets/images/frontweb',
	];
	$data['favicon'] = [
		'size' => '128x128',
	];
	$data['extensions'] = [
		'path' => 'assets/images/extensions',
		'size' => '36x36',
	];
	$data['seo'] = [
		'path' => 'assets/images/seo',
		'size' => '600x315'
	];
	$data['profile'] = [
		'user' => [
			'path' => 'assets/images/user/profile',
			'size' => '350x300'
		],
		'admin' => [
			'path' => 'assets/admin/images/profile',
			'size' => '400x400'
		]
	];
	$data['game'] = [
		'path' => 'assets/images/game',
		'size' => '240x240'
	];
	$data['game_frontend'] = [
		'path' => 'assets/images/game',
		'size' => '252x230'
	];
	$data['membership'] = [
		'path' => 'assets/images/membership',
		'size' => '252x230'
	];
	$data['front_image'] = [
		'path' => 'assets/images/game',
		'size' => '400x312'
	];
	$data['lang'] = [
		'path' => 'assets/images/lang',
		'size' => '48x48'
	];
	return $data;
}

function diffForHumans($date)
{
	$lang = session()->get('lang');
	Carbon::setlocale($lang);
	return Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'd/M/Y , h:i A')
{
	$lang = session()->get('lang');
	Carbon::setlocale($lang);
	return Carbon::parse($date)->translatedFormat($format);
}
// function showDateTimeID($date, $format = 'Y-m-d h:i A')
// {
//     $lang = session()->get('lang');
//     Carbon::setlocale($lang);
//     return Carbon::parse($date)->translatedFormat($format);
// }
function _sendWARegister($id)
{
	$user = User::find($id);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://graph.facebook.com/v15.0/116715727996845/messages',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => '{
        "messaging_product": "whatsapp",
        "to": "' . $user->mobile_login . '",
        "type": "template",
        "template": {
            "name": "account_new",
            "language": {
                "code": "id"
            },
        "components": [
            {
            "type": "body",
            "parameters": [
                {
                    "type": "text",
                    "text": "kami ucapkan"
                },
                {
                    "type": "text",
                    "text": "' . @$user->member_id . '"
                },
                 {
                    "type": "text",
                    "text": "' . @$user->email . '"
                },
                    {
                    "type": "text",
                    "text": "' . @$user->password_confirmation . '"
                },
                {
                    "type": "text",
                    "text": "' . @$user->password_confirmation . '"
                }
            ]
            }
        ]
        }
    }',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer EAAMmUBZBV7cIBAOErr9gofDCzZBzRQ3x1411ix4drwyxysAUXCepG6zqz54l0UN01LHy5NMPMVaFftfsxn54EJHVcpVWbXp8zX1xUzhM64Tcm8LuDSHc2Ur3iXj12wkilrXOOvYS2UStMseOZCpqB1g9j8h4jl2LfJyTvNJ2Lry9IgOhwWqFeY10jQch4xYmJ3j0x1FdwZDZD',
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
function sendWARegister($id = null)
{
	$user = User::find($id);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://graph.facebook.com/v15.0/116715727996845/messages',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => '{
        "messaging_product": "whatsapp",
        "to": "' . $user->mobile_login . '",
        "type": "template",
        "template": {
            "name": "account_new",
            "language": {
                "code": "id",
                "policy": "deterministic"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "kami ucapkan"
                        },
                        {
                            "type": "text",
                            "text": "' . $user->member_id . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $user->email . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $user->password_confirmation . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $user->member_id . '"
                        }
                    ]
                }
            ]
        }
        }',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer EAAMmUBZBV7cIBAOErr9gofDCzZBzRQ3x1411ix4drwyxysAUXCepG6zqz54l0UN01LHy5NMPMVaFftfsxn54EJHVcpVWbXp8zX1xUzhM64Tcm8LuDSHc2Ur3iXj12wkilrXOOvYS2UStMseOZCpqB1g9j8h4jl2LfJyTvNJ2Lry9IgOhwWqFeY10jQch4xYmJ3j0x1FdwZDZD',
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return json_decode($response);
}

function getTrx($length = 12)
{
	$characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
function getBalance()
{
	$wallet    = Wallet::where('user_id', Auth::id())->where('type', 'Credit')->sum('amount');
	$walletOut = Wallet::where('user_id', Auth::id())->where('type', 'Debit')->sum('amount');
	return $wallet - $walletOut;
}
function getBalanceUser($userID)
{
	$wallet    = Wallet::where('user_id', $userID)->where('type', 'Credit')->sum('amount');
	$walletOut = Wallet::where('user_id', $userID)->where('type', 'Debit')->sum('amount');
	return $wallet - $walletOut;
}
function getCredit($userid)
{
	$wallet    = Credit::where('user_id', $userid)->where('type', 'In')->sum('amount');
	$walletOut = Credit::where('user_id', $userid)->where('type', 'Out')->sum('amount');
	return $wallet - $walletOut;
}
