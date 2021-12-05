<?php

return array(

    'name' =>  env('APP_NAME', 'فروشگاه اینترنتی'),
    'description' => 'توضیحات فروشگاه در این قسمت قرار دارد',
    'phone' => '01735227072',
    'mobile' => '09198339405',
    'address' => '',
    'email' => 'limodshop@gmail.com',
    'telegram' => 'https://t.me/limod_ir',
    'instagram' => 'https://www.instagram.com/limod_shop',


    'home_title' => 'فروشگاه اینترنتی آکاد',
    'meta_title' => 'فروشگاه آکاد',
    'meta_description' => 'مجموعه آکاد با دو هدف بنیادی فعالیت خود را آغاز نموده در تمام پلتفرم های خود این دو را دنبال می کند. هدف اول، ایجاد اشتغال پایدار برای جامعه، و هدف دوم همواره کاهش هزینه های خانوار با ارائه محصولات با کیفیت در پایین ترین رنج قیمت بازار به مشتریان خود می باشد.',


    'view_lifetime' => 600, // lifetime in seconds

    'articles' => array(
        'can_rate' => true,
        'can_comment' => true
    ),

    'products' => array(
        'can_rate' => true,
        'can_comment' => true
    ),

    'payments' => array(
        'in_place' => false,
        'credit' => true,
        'online' => true
    )


);
