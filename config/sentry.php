<?php

return [
    'dsn' => 'https://72831e25c0ed4ed99962c17b90f00150@sentry.io/1338088',
    'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),
    'error_types' => E_ALL ^ E_USER_NOTICE ^ E_USER_WARNING ^ E_USER_DEPRECATED ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED ^ E_STRICT,
];
