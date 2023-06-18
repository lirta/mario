<?php

use Carbon\Carbon;
use Xendit\Xendit;
Xendit::setApiKey('xnd_development_VZ9zc3iqlXBstdTRqrr8o0402yeLxTvqlbR1skj9NhKRNM48wM4Hx1ESsDyYL');
// Xendit::setApiKey('xnd_production_n7FUl6x7Ece5dQGqU8vQMKPdSN875LvUokkk2aRvhFxHNTjSbF8J9EHoizEP4UO');
function xenditProdKey()
{
    // return 'xnd_development_VZ9zc3iqlXBstdTRqrr8o0402yeLxTvqlbR1skj9NhKRNM48wM4Hx1ESsDyYL';
    return 'xnd_production_n7FUl6x7Ece5dQGqU8vQMKPdSN875LvUokkk2aRvhFxHNTjSbF8J9EHoizEP4UO';
}

function addCustomer($user,$description=null)
{
    // Xendit::setApiKey(xenditProdKey());
    if(@$user->firstname or @$user->lastname){
        $name = @$user->firstname.' '.@$user->lastname;
    }else{
        $name = $user->member_id;
    }
    $customerParams = [
        'reference_id'  => '' . time(),
        'given_names'   => $name,
        'email'         => $user->email,
        'mobile_number' => '+'.$user->mobile_login,
        'description'   => $description,
        // 'middle_name' => 'middle',
        'surname' => @$user->member_id,
        'addresses' => [
          [
            'country' => 'ID',
            'street_line1' => 'Jl. 123',
            'street_line2' => 'Jl. 456',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'state' => '-',
            'postal_code' => '12345'
          ]
        ],
        'metadata' => [
          'meta' => 'data'
        ]
      ];
    $data = $createCustomerOld = \Xendit\Customers::createCustomer($customerParams);
    return $data;
}

function createInvoice()
{
    $params =
    [
    'external_id' => 'demo_147580196270',
    'payer_email' => 'sample_email@xendit.co',
    'description' => 'Trip to Bali',
    'amount'      => 5000
    ];
    $createInvoice = \Xendit\Invoice::create($params);
    return $createInvoice;
}

function createEWallet($user,$amount,$phone,$type,$callback_url,$redirect_url)
{
    $ovoParams = [
        'external_id'  => 'demo-' . time(),
        'amount'       => $amount,
        'phone'        => $phone,
        'ewallet_type' => $type,
        'callback_url' => $callback_url,
        'redirect_url' => $redirect_url,
    ];
    try {
        $createOvo = \Xendit\EWallets::create($ovoParams);
        return $createOvo;
    } catch (\Xendit\Exceptions\ApiException $exception) {
        return $exception;
    }
}
function createOvo($amount,$number)
{
    $ovoParams = [
        'external_id'  => 'ovo_' . time(),
        'amount'       => 5000,
        'phone'        => '081372823564',
        'ewallet_type' => 'OVO',
        'callback_url' => 'https://api.reliablewebhook.com/h/33sh3h2ueaqeitti',
        'redirect_url' => 'https://detik.com',
    ];
    $createOvo = \Xendit\EWallets::create($ovoParams);
    return $createOvo;
}
function createVirtual(){
    $params = ["external_id" => "VA_fixed-12341234",
        "bank_code" => "MANDIRI",
        "name"      => "Steve Wozniak"
    ];
    $createVA = \Xendit\VirtualAccounts::create($params);
    return $createVA;

}
function createQR()
{
    $params = [
        'external_id'  => 'demo_123456233',
        'type'         => 'STATIC',
        'callback_url' => 'https://webhook.site',
        'amount'       => 1200,
    ];

    $qr_code = \Xendit\QRCode::create($params);
    return $qr_code;
}
function createQRWallet($amount){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.xendit.co/payment_requests',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "amount": "'.$amount.'",
        "currency": "IDR",
        "payment_method": {
            "type": "QR_CODE",
            "reusability": "ONE_TIME_USE",
            "qr_code": {
                "channel_code": "DANA"
            }
        },
        "description": "sample description",
        "metadata": {
            "foo": "bar"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        //developement
        'Authorization: Basic eG5kX2RldmVsb3BtZW50X1ZaOXpjM2lxbFhCc3RkVFJxcnI4bzA0MDJ5ZUx4VHZxbGJSMXNrajlOaEtSTk00OHdNNEh4MUVTc0R5WUw6',

        //production
        // 'Authorization: Basic eG5kX3Byb2R1Y3Rpb25fbjdGVWw2eDdFY2U1ZFFHcVU4dlFNS1BkU044NzVMdlVva2trMmFSdmhGeEhOVGpTYkY4SjlFSG9pekVQNFVPOg==',
        'Content-Type: application/json',
        'Cookie: incap_ses_1561_2182539=bgeTVYfK7wLXFRqmecmpFbrO3WMAAAAAFzcTMcn66ql/VEZryyAhNA==; incap_ses_7259_2182539=hyZEfD5R23GkcxU1Qia9ZEIk3mMAAAAABYic0VxxFtPm0KI69Sf5AQ==; nlbi_2182539=BlXxOGnfGQ4LuP5rNAqKSgAAAAD7GyqxpJMmuET4SUzIvLiY; incap_ses_228_2523827=y4FQBhnoyWYDNQlj6wQqAzcb3mMAAAAAq3rW06j5x8nRQX/0nMwldg==; nlbi_2523827=nzdgC7cJDxmzKJ9p4hFhFgAAAADcmwXNBMDZhwViZ/FVa/yb'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}
function paymentRequestStatus($id){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.xendit.co/payment_requests/'.$id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        //developement
        'Authorization: Basic eG5kX2RldmVsb3BtZW50X1ZaOXpjM2lxbFhCc3RkVFJxcnI4bzA0MDJ5ZUx4VHZxbGJSMXNrajlOaEtSTk00OHdNNEh4MUVTc0R5WUw6',

        //production
        // 'Authorization: Basic eG5kX3Byb2R1Y3Rpb25fbjdGVWw2eDdFY2U1ZFFHcVU4dlFNS1BkU044NzVMdlVva2trMmFSdmhGeEhOVGpTYkY4SjlFSG9pekVQNFVPOg==',
        'Cookie: incap_ses_1561_2182539=bgeTVYfK7wLXFRqmecmpFbrO3WMAAAAAFzcTMcn66ql/VEZryyAhNA==; incap_ses_7259_2182539=aFgja7+zagAkChA1Qia9ZCYh3mMAAAAAwht/qCpuPEuWsVdb5doIPA==; nlbi_2182539=BlXxOGnfGQ4LuP5rNAqKSgAAAAD7GyqxpJMmuET4SUzIvLiY; incap_ses_228_2523827=y4FQBhnoyWYDNQlj6wQqAzcb3mMAAAAAq3rW06j5x8nRQX/0nMwldg==; nlbi_2523827=nzdgC7cJDxmzKJ9p4hFhFgAAAADcmwXNBMDZhwViZ/FVa/yb'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}

function paymentRequestVirtual($amount,$referensiid,$bank,$name){

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.xendit.co/payment_requests',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "currency": "IDR",
        "amount": '.$amount.',
        "payment_method": {
            "type": "VIRTUAL_ACCOUNT",
            "reusability": "ONE_TIME_USE",
            "reference_id": "pm-level-'.$referensiid.'",
            "virtual_account": {
                "channel_code": "'.$bank.'",
                "channel_properties": {
                    "customer_name": "'.$name.'"
                }
            }
        },
        "metadata": {
            "sku": "ABCDEFGH"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic eG5kX2RldmVsb3BtZW50X1ZaOXpjM2lxbFhCc3RkVFJxcnI4bzA0MDJ5ZUx4VHZxbGJSMXNrajlOaEtSTk00OHdNNEh4MUVTc0R5WUw6',

        //production
        // 'Authorization: Basic eG5kX3Byb2R1Y3Rpb25fbjdGVWw2eDdFY2U1ZFFHcVU4dlFNS1BkU044NzVMdlVva2trMmFSdmhGeEhOVGpTYkY4SjlFSG9pekVQNFVPOg==',
        'Content-Type: application/json',
        'Cookie: incap_ses_1561_2182539=bgeTVYfK7wLXFRqmecmpFbrO3WMAAAAAFzcTMcn66ql/VEZryyAhNA==; incap_ses_7259_2182539=32RlU0zWgm2H16M1Qia9ZOlz3mMAAAAA4bAGZXcGYXBC02A5yXodkA==; nlbi_2182539=BlXxOGnfGQ4LuP5rNAqKSgAAAAD7GyqxpJMmuET4SUzIvLiY; incap_ses_2105_2523827=f2xxaWNab1oCbYMEinY2HUNd3mMAAAAAjmHAOG4yaByJID8d8l4qMA==; incap_ses_228_2523827=y4FQBhnoyWYDNQlj6wQqAzcb3mMAAAAAq3rW06j5x8nRQX/0nMwldg==; nlbi_2523827=3fYyTwrrWnP7ngJl4hFhFgAAAABb+IBAmjDu4gYbjMdPGze7'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);

}

function _paymentRequestVirtual($amount,$bank,$name){
    $date = Carbon::parse(now()->addHour(7));
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.xendit.co/v2/payment_methods',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "type": "VIRTUAL_ACCOUNT",
        "virtual_account": {
            "amount": '.$amount.',
            "currency": "IDR",
            "channel_code": "'.$bank.'",
            "channel_properties": {
                "customer_name": "'.$name.'",
                "expires_at": "'.$date->format('c').'"
            }
        },
        "reusability": "ONE_TIME_USE",
        "metadata": {
            "branch_code": "ABC123"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        //developement
        'Authorization: Basic eG5kX2RldmVsb3BtZW50X1ZaOXpjM2lxbFhCc3RkVFJxcnI4bzA0MDJ5ZUx4VHZxbGJSMXNrajlOaEtSTk00OHdNNEh4MUVTc0R5WUw6',

        //production
        // 'Authorization: Basic eG5kX3Byb2R1Y3Rpb25fbjdGVWw2eDdFY2U1ZFFHcVU4dlFNS1BkU044NzVMdlVva2trMmFSdmhGeEhOVGpTYkY4SjlFSG9pekVQNFVPOg==',
        'Content-Type: application/json',
        'Cookie: incap_ses_1561_2182539=bgeTVYfK7wLXFRqmecmpFbrO3WMAAAAAFzcTMcn66ql/VEZryyAhNA==; incap_ses_7259_2182539=+qJEQ8a9dwgd5IY1Qia9ZJJi3mMAAAAAgUMbsEYnFSh7IHW+8ixDWg==; nlbi_2182539=BlXxOGnfGQ4LuP5rNAqKSgAAAAD7GyqxpJMmuET4SUzIvLiY; incap_ses_2105_2523827=f2xxaWNab1oCbYMEinY2HUNd3mMAAAAAjmHAOG4yaByJID8d8l4qMA==; incap_ses_228_2523827=y4FQBhnoyWYDNQlj6wQqAzcb3mMAAAAAq3rW06j5x8nRQX/0nMwldg==; nlbi_2523827=3fYyTwrrWnP7ngJl4hFhFgAAAABb+IBAmjDu4gYbjMdPGze7'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}

