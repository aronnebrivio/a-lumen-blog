<?php

return [
    'dsn' => 'https://72831e25c0ed4ed99962c17b90f00150@sentry.io/1338088',
    'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),
];