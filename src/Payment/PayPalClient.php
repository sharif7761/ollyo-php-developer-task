<?php

namespace Ollyo\Task\Payment; // Add namespace declaration

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient
{
    public static function client()
    {
        $clientId = 'Aai9Yu0W9aO6ZIsmdwkhGmwW6yZD1J_sMEpq5pEtEw2sxPtEyN29fP87R31Jh2I_3Tnbe5rOioM8WjNc';
        $clientSecret = 'EJ1HO3Zp-G_QoOlWrnEBtYZaY4R3glHB57UsSxvg1EtiJnAvosJyPAtI1qivt8VSruhYtmW83HMF925F';

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        return new PayPalHttpClient($environment);
    }
}