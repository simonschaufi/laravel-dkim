<?php
declare(strict_types=1);

namespace SimonSchaufi\LaravelDKIM;

use InvalidArgumentException;
use SimonSchaufi\LaravelDKIM\Exception\MissingConfigurationException;
use Swift_SwiftException;

class Mailer extends \Illuminate\Mail\Mailer
{
    /**
     * Create a new message instance.
     *
     * @return Message
     * @throws MissingConfigurationException
     * @throws Swift_SwiftException
     */
    protected function createMessage()
    {
        $message = new Message($this->swift->createMessage('message'));

        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (! empty($this->from['address'])) {
            $message->from($this->from['address'], $this->from['name']);
        }

        // When a global reply address was specified we will set this on every message
        // instance so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push this address.
        if (! empty($this->replyTo['address'])) {
            $message->replyTo($this->replyTo['address'], $this->replyTo['name']);
        }

        if (! empty($this->returnPath['address'])) {
            $message->returnPath($this->returnPath['address']);
        }

        // PATCH START
        $privateKey = config('dkim.private_key');
        $selector = config('dkim.selector');
        $domain = config('dkim.domain');
		$mailers = config('dkim.mailers');
        if (in_array($this->name, $mailers, true)) {
            if (empty($privateKey)) {
                throw new MissingConfigurationException('No private key set.', 1588115551);
            }
            if (!file_exists($privateKey)) {
                throw new InvalidArgumentException('Private key file does not exist.', 1588115609);
            }

            if (empty($selector)) {
                throw new MissingConfigurationException('No selector set.', 1588115373);
            }
            if (empty($domain)) {
                throw new MissingConfigurationException('No domain set.', 1588115434);
            }

            $message->attachDKIMSigner(
                file_get_contents($privateKey),
                $domain,
                $selector,
                config('dkim.passphrase')
            );
        }
        // PATCH END

        return $message;
    }
}
