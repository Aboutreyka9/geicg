<?php



/* HEADERS DE SÉCURITÉ */
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: frame-ancestors 'self'");
header("Permissions-Policy: geolocation=(), camera=()");

// header("Content-Security-Policy: default-src 'self'");

/* FIN HEADERS DE SÉCURITÉ */