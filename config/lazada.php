<?php

return [
    'USER_ID' => env('LAZADA_USER_ID'),
    'API_KEY' => env('LAZADA_API_KEY'),
    'ROOT_URL' => 'https://api.sellercenter.lazada.vn',
    'API_VERSION' => '1.0',
    'RETURN_FORMAT_DATA' => 'json',
    'APP_KEY' => env('LAZADA_APP_KEY'),
    'APP_SECRET' => env('LAZADA_APP_SECRET'),
    'AUTH_URL' => 'https://auth.lazada.com/oauth/authorize?response_type=code&redirect_uri=https%3A%2F%2Fproject-x-cms.herokuapp.com%2Fadmin%2Fexternal-api%2Flazada%2Fauth&client_id=104613',

    //product code
    //SINGLE
    'BDN001' => 'BDN01-B',
    'BDN002' => 'BDN01-W',
    'BDN003' => 'BDN01-P',

    'NQD01' => 'NDQ01-08',
    'NQD02' => 'NDQ01-09',
    'NQD03' => 'NDQ01-10',
    'NQD04' => 'NDQ01-11',
    'NQD05' => 'NDQ01-12',

    'VTC01' => 'VTC01-W',
    'VTC02' => 'VTC01-B',

    'VTC01-01' => 'VTV01-01',

    'OKH01' => 'OKH01-03',

    'MNE01-08' => 'MHE01-08',

    'NNA002-B10' => 'NNA02-B10',

    //PACKAGE
    'BDN010203-111' => 'BDN01-B&BDN01-W&BDN01-P',
    'VTC0102-11' => 'VTC01-W&VTC01-B'

];