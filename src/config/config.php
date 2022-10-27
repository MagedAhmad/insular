<?php

return [
    'snowflake' => [
        'data_center' => env('SNOWFLAKE_DATA_CENTER', 1),
        'worker_node' => env('SNOWFLAKE_WORKER', 1),
    ],
];
