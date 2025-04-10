<?php
  function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }

function base64url_decode($data) {
  $remainder = strlen($data) % 4;
  if ($remainder) {
    $pad_len = 4 - $remainder;
    $data .= str_repeat('=', $pad_len);
  }
  return base64_decode(strtr($data, '-_', '+/'));
}
  
  function create_jwt(array $payload, string $secret, string $alg = 'HS256'): string {
    $header = base64url_encode(json_encode([
      'alg' => $alg,
      'typ' => 'JWT'
    ]));
  
    $payload_encoded = base64url_encode(json_encode($payload));
  
    $signature = hash_hmac('sha256', "$header.$payload_encoded", $secret, true);
    $signature_encoded = base64url_encode($signature);
  
    return "$header.$payload_encoded.$signature_encoded";
  }


function verify_jwt(string $jwt, string $secret): array|false {
  $parts = explode('.', $jwt);
  if (count($parts) !== 3) return false;

  list($header_b64, $payload_b64, $signature_b64) = $parts;

  $signature_check = base64url_encode(
    hash_hmac('sha256', "$header_b64.$payload_b64", $secret, true)
  );

  if (!hash_equals($signature_b64, $signature_check)) {
    return false; // Invalid signature
  }

  $payload = json_decode(base64url_decode($payload_b64), true);

  if (isset($payload['exp']) && time() > $payload['exp']) {
    return false; // Token expired
  }

  return $payload;
}
?>
