<?php
namespace app\models;
// Created By @hoaaah * Copyright (c) 2020 belajararief.com

class Status {
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
    const STATUS_NO_CONTENT = 204;
    const STATUS_RESET_CONTENT = 205;

    const STATUS_MULTIPLE_CHOICES = 300;
    const STATUS_MOVED_PERMANENTLY = 301;
    const STATUS_FOUND = 302;
    const STATUS_TEMPORARY_REDIRECT = 307;
    const STATUS_PERMANENT_REDIRECT = 308;

    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_PAYMENT_REQUIRED = 402;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_METHOD_NOT_ALLOWED = 405;
    const STATUS_REQUEST_TIMEOUT = 408;

    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_HTTP_VERSION_NOT_SUPPORTED = 505;
}