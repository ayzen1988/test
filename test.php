<?php
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');

function transferData($data)
{
    if (empty($data)) {
        return [];
    }
    foreach ($data as $key => $itm) {
        $data[$key]['now_price_x0'] = calcPrice($itm['first_price'], $itm['first_pe'], $itm['now_pe'], 0);
        $data[$key]['now_price_x1'] = calcPrice($itm['first_price'], $itm['first_pe'], $itm['now_pe'], 1);
        $data[$key]['now_price_x2'] = calcPrice($itm['first_price'], $itm['first_pe'], $itm['now_pe'], 2);
    }
    return $data;
}

function calcPrice($price, $startPe, $endPe, $pow)
{
    if ($pow <= 0) {
        return $price;
    }
    // return bcmul(bcpow(bcdiv($startPe, $endPe, 5), $pow, 5), $price, 5);
    return pow($startPe / $endPe, $pow) * $price;
}

$data = [];
$data[] = [
    'code' => '001002',
    'name' => '有价值',
    'first_price' => 2500,
    'first_pe' => 10,
    'now_pe' => 7.9,
    'now_price_x0' => 0,
    'now_price_x1' => 0,
    'now_price_x2' => 0,
];
$data = transferData($data);

echo json_encode($data);
