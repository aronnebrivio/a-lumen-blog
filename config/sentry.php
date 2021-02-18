<?php

return [
    'dsn' => 'https://2a3bab30e6c949bfaece9aaa31c47c22@sentry.io/1540621',
    'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),
    'error_types' => E_ALL ^ E_USER_NOTICE ^ E_USER_WARNING ^ E_USER_DEPRECATED ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED ^ E_STRICT,
];
