<?php

// Created By @hoaaah * Copyright (c) 2020 belajararief.com
return [
    'useHttpBasicAuth' => true,
    'useHttpBearerAuth' => true,
    'useQueryParamAuth' => true,

    /**
     * use rate limiter for user
     * you must modified your UserIdentity class, follow this guidelines for complete guide
     * https://www.yiiframework.com/doc/guide/2.0/en/rest-rate-limiting
     */
    'useRateLimiter' => false,
];
