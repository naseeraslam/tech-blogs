<?php

function validateDomain($domain) {
    return filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
}

function getSSLCertificateDetails($host) {
    $context = stream_context_create([
        'ssl' => [
            'capture_peer_cert' => true
        ]
    ]);

    $client = @stream_socket_client(
        "ssl://{$host}:443",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $context
    );

    if (!$client) {
        return ["error" => "Unable to connect to {$host}: $errstr ($errno)"];
    }

    $sslContext = stream_context_get_params($client);
    $certificate = openssl_x509_parse($sslContext['options']['ssl']['peer_certificate']);

    if (!$certificate) {
        return ["error" => "Failed to retrieve SSL certificate for {$host}"];
    }

    return [
        'validFrom' => date('Y-m-d H:i:s', $certificate['validFrom_time_t']),
        'validTo' => date('Y-m-d H:i:s', $certificate['validTo_time_t']),
        'issuer' => $certificate['issuer']['O'] ?? 'Unknown',
        'subject' => $certificate['subject']['CN'] ?? 'Unknown',
        'organization' => $certificate['subject']['O'] ?? 'Unknown',
        'org_unit' => $certificate['subject']['OU'] ?? 'Unknown',
        'email' => $certificate['subject']['emailAddress'] ?? 'Not Available',
        'serialNumber' => $certificate['serialNumberHex'] ?? 'Unknown'
    ];
}

$host = isset($argv[1]) ? $argv[1] : '';

if (!$host) {
    echo "Enter a domain name: ";
    $host = trim(fgets(STDIN));
}

if (!$host || !validateDomain($host)) {
    echo "Invalid or missing domain. Example usage:\n";
    echo "PHP CLI: php ssl-checker.php example.com\n";
    echo "URL: https://yoursite.com/script.php?domain=example.com\n";
    exit;
}

$result = getSSLCertificateDetails($host);

if (isset($result['error'])) {
    echo "Error: " . $result['error'] . PHP_EOL;
} else {
    echo "SSL Certificate Details for {$host}:\n";
    echo "Valid From: {$result['validFrom']}\n";
    echo "Valid To: {$result['validTo']}\n";
    echo "Issuer (CA): {$result['issuer']}\n";
    echo "Subject (CN): {$result['subject']}\n";
    echo "Organization: {$result['organization']}\n";
    echo "Organizational Unit: {$result['org_unit']}\n";
    echo "Email (if available): {$result['email']}\n";
    echo "Serial Number: {$result['serialNumber']}\n";
}

?>
