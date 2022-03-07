<?php

return [
  'default_user' => [
      'password' => env('DEFAULT_USER_PASSWORD'),
      'name' => env('DEFAULT_USER_NAME'),
      'email' => env('DEFAULT_USER_EMAIL'),
      'password_profe' => env('DEFAULT_USER_PROFE_PASSWORD'),
      'name_profe' => env('DEFAULT_USER_PROFE_NAME'),
      'email_profe' => env('DEFAULT_USER_PROFE_EMAIL')
  ],
    'admins' => [
        'abrusca@iesebre.com',
        'sergiturbadenas@gmail.com'
    ]
];
