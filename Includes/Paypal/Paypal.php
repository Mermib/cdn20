<?php

require_once(__DIR__ . '/../Config.php');
require_once(__DIR__ . '/../Helpers/Http.php');

class Paypal
{
    private static function GetToken()
    {
        $token = '';
        $byteArray = utf8_encode(sprintf('%s:%s', PAYPAL_ID, PAYPAL_SECRET));
        $response = HTTP::Post([
            'uri' => sprintf('%s/oauth2/token', PAYPAL_URL), 
            'data' => [ 'grant_type' => 'client_credentials' ], 
            'headers' => [ sprintf('Authorization: Basic %s', base64_encode($byteArray)) ], 
            'format' => 'urlencode'
        ]);

        if(!empty($response))
        {
            $object = json_decode($response);
            $token = $object->access_token;
        }
        return $token;
    }
    
    // Gets a random invoice number to be used with a sample request that requires an invoice number.
    // Returns a random invoice number in the range of 0 to 999999
    private static function GetRandomInvoiceNumber()
    {
        return strval(mt_rand(0, 999999));
    }

    private static function GetTransactionsList($amount)
    {
        $transactionList = [];
        $invoiceNumber = self::GetRandomInvoiceNumber();
        $products = [
            [
                'name' => 'Disco musical',
                'currency' => 'MXN',
                'price' => strval($amount),
                'quantity' => '1'
            ]
        ];

        $transaction = [
            'invoice_number' => $invoiceNumber,
            'amount' => [
                'currency' => 'MXN',
                'total' => strval($amount),
                'details' => [
                    'subtotal' => strval($amount),
                    'tax' => 0,
                    'shipping' => 0,
                    'handling_fee' => 0,
                    'shipping_discount' => 0,
                    'insurance' => 0
                ]
            ],
            'description' => 'This is the payment transaction description',
            'payment_options' => [ 'allowed_payment_method' => 'IMMEDIATE_PAY' ],
            'item_list' => [ 'items' => $products ]
        ];
        $transactionList[] = $transaction;
        return $transactionList;
    }

    public static function CreatePayment($amount)
    {
        $json = '';
        $urlPay = '';
        $token = self::GetToken();
        $transactionId = uniqid();
        $headers = [
            sprintf('Authorization: Bearer %s', $token),
            'Content-Type: application/json'
        ];
        $transactions = self::GetTransactionsList($amount);
        $data = [
            'intent' => 'sale',
            'payer' => [ 'payment_method' => 'paypal' ],
            'transactions' => $transactions,
            'redirect_urls' => [
                'return_url' => 'http://new.cdn20.com/thankyou.php',
                'cancel_url' => 'http://new.cdn20.com/'
            ]
        ];
        $response = HTTP::Post([
            'uri' => sprintf('%s/payments/payment', PAYPAL_URL),
            'data' => $data,
            'headers' => $headers,
            'errors' => true
        ]);

        if (!empty($response))
        {
            $object = json_decode($response);
            foreach ($object->links as $key => $value)
            {
                if ($value->rel == "approval_url")
                {
                    $urlPay = $value->href;
                    break;
                }
            }
        }
        return $urlPay;
    }

    public static function ExecutePayment($paymentId, $payerId)
    {
        $json = '';
        $token = self::GetToken();
        $autorizationCode = '';

        $headers = [
            sprintf('Authorization: Bearer %s', $token),
            'Content-Type: application/json', 
        ];

        $response = HTTP::Post([
            'uri' => sprintf('%s/payments/payment/%s/execute', PAYPAL_URL, $paymentId),
            'data' => [ 'payer_id' => $payerId ],
            'headers' => $headers,
            'errors' => true
        ]);

        if (!empty($response))
        {
            $object = json_decode($response);
            $exist = array_key_exists('state', json_decode($response, true));

            if($exist)
            {
                if($object->state == "approved")
                {
                    if ($object->transactions[0]->related_resources[0]->sale->state == "completed")
                    {
                        $autorizationCode = $object->transactions[0]->related_resources[0]->sale->id;
                    }
                }
            }
            else
            {
                $error = json_decode($response);
                $autorizationCode = $error->name == 'INSTRUMENT_DECLINED' || $error->name == 'TRANSACTION_REFUSED' ? $error->name : '';
            }
        }
        return $autorizationCode;
    }
}