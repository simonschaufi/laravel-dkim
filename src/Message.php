<?php
declare(strict_types=1);

namespace SimonSchaufi\LaravelDKIM;

use Swift_Signers_DKIMSigner;
use Swift_SwiftException;

class Message extends \Illuminate\Mail\Message
{
    /**
     * @param string $privateKey
     * @param string $domain
     * @param string $selector
     * @param string|null $passphrase
     *
     * @return $this
     * @throws Swift_SwiftException
     */
    public function attachDKIMSigner(
        string $privateKey,
        string $domain,
        string $selector,
        ?string $passphrase = ''
    ): self {
        $signer = new Swift_Signers_DKIMSigner($privateKey, $domain, $selector, $passphrase);
        $signer->setHashAlgorithm(config('dkim.algorithm'));

        $identity = config('dkim.identity');
        if ($identity) {
            $signer->setSignerIdentity($identity);
        }

        $this->swift->attachSigner($signer);

        return $this;
    }
}
