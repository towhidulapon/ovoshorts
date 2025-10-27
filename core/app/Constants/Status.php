<?php

namespace App\Constants;

class Status
{

    const ENABLE  = 1;
    const DISABLE = 0;
    const PENDING = 2;

    const YES = 1;
    const NO  = 0;

    const VERIFIED   = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    const TICKET_OPEN   = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY  = 2;
    const TICKET_CLOSE  = 3;

    const PRIORITY_LOW    = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING    = 2;
    const KYC_VERIFIED   = 1;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM  = 3;

    const SHORT_PENDING = 0;
    const SHORT_APPROVE = 1;
    const SHORT_REJECT  = 2;
    const SHORT_DRAFT   = 3;

    const EVERYONE = 1;
    const ONLY_ME  = 2;

    const IMAGE = 0;
    const VIDEO = 1;

    const UNPUBLISHED = 0;
    const PUBLISHED   = 1;
    const DRAFT       = 2;
    const SCHEDULE    = 3;
    const REJECTED    = 4;

    const RECHARGE_INITIATE = 0;
    const RECHARGE_SUCCESS  = 1;
    const RECHARGE_PENDING  = 2;
    const RECHARGE_REJECT   = 3;

    const VERIFICATION_UNVERIFIED = 0;
    const VERIFICATION_SUCCESS    = 1;
    const VERIFICATION_PENDING    = 2;
    const VERIFICATION_REJECTED   = 3;

    const FREE = 1;
    const PAID = 2;

}
