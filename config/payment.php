<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following gateway to use.
    | You can switch to a different driver at runtime.
    |
    */
    'default' => 'zarinpal',

    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers to use for this package.
    | You can change the name. Then you'll have to change
    | it in the map array too.
    |
    */
    'drivers' => [
        'asanpardakht' => [
            'apiPurchaseUrl' => 'https://services.asanpardakht.net/paygate/merchantservices.asmx?wsdl',
            'apiPaymentUrl' => 'https://asan.shaparak.ir',
            'apiVerificationUrl' => 'https://services.asanpardakht.net/paygate/merchantservices.asmx?wsdl',
            'apiUtilsUrl' => 'https://services.asanpardakht.net/paygate/internalutils.asmx?wsdl',
            'key' => '',
            'iv' => '',
            'username' => '',
            'password' => '',
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using asanpardakht',
        ],
        'behpardakht' => [
            'apiPurchaseUrl' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
            'apiPaymentUrl' => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
            'apiVerificationUrl' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
            'terminalId' => '',
            'username' => '',
            'password' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using behpardakht',
        ],
        'idpay' => [
            'apiPurchaseUrl' => 'https://api.idpay.ir/v1.1/payment',
            'apiPaymentUrl' => 'https://idpay.ir/p/ws/',
            'apiSandboxPaymentUrl' => 'https://idpay.ir/p/ws-sandbox/',
            'apiVerificationUrl' => 'https://api.idpay.ir/v1.1/payment/verify',
            'merchantId' => 'dff1d85f-b668-4587-bbf0-0942240c0674',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using idpay',
            'sandbox' => false, // set it to true for test environments
        ],
        'irankish' => [
            'apiPurchaseUrl' => 'https://ikc.shaparak.ir/XToken/Tokens.xml',
            'apiPaymentUrl' => 'https://ikc.shaparak.ir/TPayment/Payment/index/',
            'apiVerificationUrl' => 'https://ikc.shaparak.ir/XVerify/Verify.xml',
            'merchantId' => '',
            'sha1Key' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using irankish',
        ],
        'nextpay' => [
            'apiPurchaseUrl' => 'https://api.nextpay.org/gateway/token.http',
            'apiPaymentUrl' => 'https://api.nextpay.org/gateway/payment/',
            'apiVerificationUrl' => 'https://api.nextpay.org/gateway/verify.http',
            'merchantId' => '351eb5b6-47b4-42de-aa3e-333ada6cfe59',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using nextpay',
        ],
        'parsian' => [
            'apiPurchaseUrl' => 'https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl',
            'apiPaymentUrl' => 'https://pec.shaparak.ir/NewIPG/',
            'apiVerificationUrl' => 'https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?wsdl',
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using parsian',
        ],
        'pasargad' => [
            'apiPaymentUrl' => 'https://pep.shaparak.ir/payment.aspx',
            'apiGetToken' => 'https://pep.shaparak.ir/Api/v1/Payment/GetToken',
            'apiCheckTransactionUrl' => 'https://pep.shaparak.ir/Api/v1/Payment/CheckTransactionResult',
            'apiVerificationUrl' => 'https://pep.shaparak.ir/Api/v1/Payment/VerifyPayment',
            'merchantId' => '5056329',
            'terminalCode' => '2308075',
            'certificate' => '<RSAKeyValue><Modulus>yva+UXcE+sQ41OsWVqtRS53dfL089AwM3dn7skI2VgoT2S1Sjz9G1JeJPUxovyt2GW500ZTKd4YJGDoK4OBjj/DfoIU/4zQXYmkcpHGZloIYDeR/BnOGESqVfdMfgRhcX4uNMa+F6vhZHogaP3/eFn8eV3kG/ZdfrcbuJtZ1H7E=</Modulus><Exponent>AQAB</Exponent><P>1yPsXLDilFtgzmRLtPahLtNhsP44F6I7gshzmGPDzBUsV7LeBF3r5dECz+oLAn8RRjSfwEL2CucHWA9VB3Cgcw==</P><Q>8YLNVinAIw4+LEL22hUj1CTdGmh8gVlz7UzCGmddTPd1zI8gkcOD9LOi8iHeLVjNKNAcz77uFSbihZ6zAL/qSw==</Q><DP>MhCfCXb0U1fscDswzvzxx2bTfg+61+0d8jJZjCXzQ4PN3N64AcYlhkacY+vwAfW1/GN0pZYvkZvvvpNa0y9ndw==</DP><DQ>oKfuiD7FvYwf97mkFHazms/a9VJEYJds8pJ5HK9d9XE4P5eGhvCUuxc0cfXtoiTMdTXbtKbCIff4AAMN+JWx+Q==</DQ><InverseQ>reFVOPU13ZIJLdr7DSBk6voD9B9DqT+aewum+wET0w+kx0nfn6m7VkS4Fl307ld2fFIfZ+IV3DDAv1flQJu/NA==</InverseQ><D>rNPbUAdnSBnawwPEK90KBrfQqK2Dv9SbCDbcaviSyEUgjahYSv541AKNrJLqBw99Kz6xXt2yYoDSMb0LEl5AqAZ8HaE+8uC4HlhqwAVo+eGkNneKC/lqKLnlDoXpEy2WuxPAJy0SMPw/tu//uWO/R/H9u7l8zCiciZSPMyw1nhk=</D></RSAKeyValue>', // can be string (and set certificateType to xml_string) or an xml file path (and set cetificateType to xml_file)
            'certificateType' => 'xml_string', // can be: xml_file, xml_string
            'callbackUrl' => 'http://yoursite.com/path/to',
        ],
        'payir' => [
            'apiPurchaseUrl' => 'https://pay.ir/pg/send/',
            'apiPaymentUrl' => 'https://pay.ir/pg/',
            'apiVerificationUrl' => 'https://pay.ir/pg/verify/',
            'merchantId' => 'd86d94076544e91b2fb1321cc4668a24', // set it to `test` for test environments
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using payir',
        ],
        'paypal' => [
            /* normal api */
            'apiPurchaseUrl' => 'https://www.paypal.com/cgi-bin/webscr',
            'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
            'apiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',

            /* sandbox api */
            'sandboxApiPurchaseUrl' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
            'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
            'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',

            'mode' => 'normal', // can be normal, sandbox
            'currency' => '',
            'id' => '', // Specify the email of the PayPal Business account
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using paypal',
        ],
        'payping' => [
            'apiPurchaseUrl' => 'https://api.payping.ir/v1/pay/',
            'apiPaymentUrl' => 'https://api.payping.ir/v1/pay/gotoipg/',
            'apiVerificationUrl' => 'https://api.payping.ir/v1/pay/verify/',
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using payping',
        ],
        'paystar' => [
            'apiPurchaseUrl' => 'https://paystar.ir/api/create/',
            'apiPaymentUrl' => 'https://paystar.ir/paying/',
            'apiVerificationUrl' => 'https://paystar.ir/api/verify/',
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using paystar',
        ],
        'poolam' => [
            'apiPurchaseUrl' => 'https://poolam.ir/invoice/request/',
            'apiPaymentUrl' => 'https://poolam.ir/invoice/pay/',
            'apiVerificationUrl' => 'https://poolam.ir/invoice/check/',
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using poolam',
        ],
        'sadad' => [
            'apiPurchaseUrl' => 'https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest',
            'apiPaymentUrl' => 'https://sadad.shaparak.ir/VPG/Purchase',
            'apiVerificationUrl' => 'https://sadad.shaparak.ir/VPG/api/v0/Advice/Verify',
            'key' => 'rwLHpR5EWmZRtYGnPqU+/UOdP1rYveS/',
            'merchantId' => '000000140333627',
            'terminalId' => '24088999',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using sadad',
        ],
        'saman' => [
            'apiPurchaseUrl' => 'https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL',
            'apiPaymentUrl' => 'https://sep.shaparak.ir/payment.aspx',
            'apiVerificationUrl' => 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL',
            'merchantId' => '',
            'callbackUrl' => '',
            'description' => 'payment using saman',
        ],
        'yekpay' => [
            'apiPurchaseUrl' => 'https://gate.yekpay.com/api/payment/server?wsdl',
            'apiPaymentUrl' => 'https://gate.yekpay.com/api/payment/start/',
            'apiVerificationUrl' => 'https://gate.yekpay.com/api/payment/server?wsdl',
            'fromCurrencyCode' => 978,
            'toCurrencyCode' => 364,
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using yekpay',
        ],
        'zarinpal' => [
            /* normal api */
            'apiPurchaseUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
            'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
            'apiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',

            /* sandbox api */
            'sandboxApiPurchaseUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
            'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
            'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',

            /* zarinGate api */
            'zaringateApiPurchaseUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
            'zaringateApiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/:authority/ZarinGate',
            'zaringateApiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',

            'mode' => 'normal', // can be normal, sandbox, zaringate
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using zarinpal',
        ],
        'zibal' => [
            /* normal api */
            'apiPurchaseUrl' => 'https://gateway.zibal.ir/v1/request',
            'apiPaymentUrl' => 'https://gateway.zibal.ir/start/',
            'apiVerificationUrl' => 'https://gateway.zibal.ir/v1/verify',

            'mode' => 'normal', // can be normal, direct

            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using zibal',
        ],
        'sepehr' => [
            'apiPurchaseUrl' => 'https://sepehr.ir/api/v1/payment/request',
            'apiPaymentUrl' => 'https://sepehr.ir/api/v1/payment/start',
            'apiVerificationUrl' => 'https://sepehr.ir/api/v1/payment/verify',
            'merchantId' => '',
            'callbackUrl' => 'http://yoursite.com/path/to',
            'description' => 'payment using sepehr',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Maps
    |--------------------------------------------------------------------------
    |
    | This is the array of Classes that maps to Drivers above.
    | You can create your own driver if you like and add the
    | config in the drivers array and the class to use for
    | here with the same name. You will have to extend
    | Shetabit\Multipay\Abstracts\Driver in your driver.
    |
    */
    'map' => [
        'asanpardakht' => \Shetabit\Multipay\Drivers\Asanpardakht\Asanpardakht::class,
        'behpardakht' => \Shetabit\Multipay\Drivers\Behpardakht\Behpardakht::class,
        'idpay' => \Shetabit\Multipay\Drivers\Idpay\Idpay::class,
        'irankish' => \Shetabit\Multipay\Drivers\Irankish\Irankish::class,
        'nextpay' => \Shetabit\Multipay\Drivers\Nextpay\Nextpay::class,
        'parsian' => \Shetabit\Multipay\Drivers\Parsian\Parsian::class,
        'pasargad' => \Shetabit\Multipay\Drivers\Pasargad\Pasargad::class,
        'payir' => \Shetabit\Multipay\Drivers\Payir\Payir::class,
        'paypal' => \Shetabit\Multipay\Drivers\Paypal\Paypal::class,
        'payping' => \Shetabit\Multipay\Drivers\Payping\Payping::class,
        'paystar' => \Shetabit\Multipay\Drivers\Paystar\Paystar::class,
        'poolam' => \Shetabit\Multipay\Drivers\Poolam\Poolam::class,
        'sadad' => \Shetabit\Multipay\Drivers\Sadad\Sadad::class,
        'saman' => \Shetabit\Multipay\Drivers\Saman\Saman::class,
        'yekpay' => \Shetabit\Multipay\Drivers\Yekpay\Yekpay::class,
        'zarinpal' => \Shetabit\Multipay\Drivers\Zarinpal\Zarinpal::class,
        'zibal' => \Shetabit\Multipay\Drivers\Zibal\Zibal::class,
        'sepehr' => \Shetabit\Multipay\Drivers\Sepehr\Sepehr::class,
    ]
];
