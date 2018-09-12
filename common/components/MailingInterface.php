<?php

namespace common\components;


interface MailingInterface
{
    const MAILING_EMAIL = 1;
    const MAILING_SMS = 2;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DONE = 3;

    public function getAddress();

    public function setStatus($mailingId, $status);

    public function getStatus($mailingId);

    public function sendMailing($mailingId);

}