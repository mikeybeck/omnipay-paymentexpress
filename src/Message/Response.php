<?php

namespace Omnipay\PaymentExpress\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PaymentExpress Response
 */
class Response extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return 1 === (int) $this->data->Success;
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        return empty($this->data->DpsTxnRef) ? null : (string) $this->data->DpsTxnRef;
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        return empty($this->data->TxnId) ? null : (string) $this->data->TxnId;
    }

    /**
     * @return string|null
     */
    public function getCardReference()
    {
        if (! empty($this->data->Transaction->DpsBillingId)) {
            return (string) $this->data->Transaction->DpsBillingId;
        } elseif (! empty($this->data->DpsBillingId)) {
            return (string) $this->data->DpsBillingId;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $message = (string) $this->data->HelpText;
        if (empty($message)) {
            $message = (string) $this->data->ResponseText;
        }

        return $message;
    }
}
