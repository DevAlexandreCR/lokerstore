<?php

namespace App\Traits;

trait Authentication
{
    public function getNonce($decode = true)
    {
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        if ($decode) return base64_encode($nonce);

        return $nonce;
    }

    public function getSeed(): string
    {
        return date('c');
    }

    public function tranKey($nonce, $seed): string
    {
        $secretKey = config('placetopay.secretKey');

        $tanKey = sha1($nonce . $seed . $secretKey, true);

        return base64_encode($tanKey);
    }

    public function getAuth(): array
    {
        $seed = $this->getSeed();
        $nonce = $this->getNonce(false);
        return [
            'login'     => config('placetopay.authId'),
            'tranKey'   => $this->tranKey($nonce, $seed),
            'nonce'     => base64_encode($nonce),
            'seed'      => $seed
        ];
    }
}
