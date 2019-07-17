<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Request\Order;
use RevenueMonster\SDK\Exceptions\ValidationException;

class QRPay implements JsonSerializable 
{
    // static $WALLET_WECHAT_MY = 'WECHATPAY_MY';
    // static $WALLET_WECHAT_CN = 'WECHATPAY_CN';
    // static $WALLET_PRESTO = 'PRESTO_MY';
    // static $WALLET_BOOST = 'BOOST_MY';

    // static $TYPE_WEB_PAYMENT = 'WEB_PAYMENT';
    // static $TYPE_MOBILE_PAYMENT = 'MOBILE_PAYMENT';

    private $currencyType = 'MYR';
    private $type = 'DYNAMIC';
    private $amount = 0;
    private $isPreFillAmount = true;
    private $method = [];
    public $order = 'WEB_PAYMENT';
    private $storeId = '';
    private $redirectUrl = '';
    // public $notifyUrl = '';

    public function __construct(array $arguments = []) 
    {
        // $this->order = new Order;
    }

    public function jsonSerialize()
    {
        $data = [
            'currencyType' => $this->currencyType,
            'amount' => $this->amount,
            'expiry' => [
                'type' => 'PERMANENT',
            ],
            'isPreFillAmount' => $this->isPreFillAmount,
            'method' => $this->method,
            'order' => [
                'title' => "服务费",
                'detail' => "test",
            ],
            'redirectUrl' => $this->redirectUrl,
            'storeId' => $this->storeId,
            'type' => $this->type,
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'currencyType' => 'required|in:MYR',
            'amount' => 'required',
            'isPreFillAmount' => 'required',
            'redirectUrl' => 'required|url',
            'storeId' => 'required',
            'type' => 'required|in:DYNAMIC,STATIC',
        ]);
        
        $validation->validate();
        
        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}