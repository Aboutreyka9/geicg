<?php

namespace App\Helpers;

class HttpStatusCode
{

    // 2xx - Succès
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;


    // 4xx - Erreur Client
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const NOT_ACCEPTABLE = 406;
    public const REQUEST_TIMEOUT = 408;

    // 5xx - Erreur Serveur
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED = 501;
    public const BAD_GATEWAY = 502;
    public const SERVICE_UNAVAILABLE = 503;
    public const GATEWAY_TIMEOUT = 504;
}