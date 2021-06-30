<?php

namespace TochkaApi\Utilities;

class TochkaPermissionsJWT
{
    /**
     * @param $consentId
     * @return string
     */
    public static function generateJWT($consentId, $host, $clientId, $redirectUri, $scopes)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'none']);

        $payload = json_encode([
            "iss" => "tochka",
            "aud" => $host,
            "response_type" => "code",
            "client_id" => $clientId,
            "redirect_uri" => $redirectUri,
            "scope" => $scopes,
            "max_age" => "86400",
            "claims" => [
                "userinfo" => [
                    "openbanking_intent_id" => [
                        "value" => $consentId,
                        "essential" => true
                    ]
                ],
                "id_token" => [
                    "openbanking_intent_id" => [
                        "value" => $consentId,
                        "essential" => true
                    ],
                    "acr" => [
                        "values" => [
                            "urn:rubanking:sca",
                            "urn:rubanking:ca"
                        ],
                        "essential" => true
                    ]
                ]
            ]
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, '', true);

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
}