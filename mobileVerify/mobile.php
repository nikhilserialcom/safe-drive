<?php
header("content-type:application/json");
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

require 'vendor/autoload.php';

function validateMobileNumber($number,$countryCode)
{
    $phoneNumberUtil = PhoneNumberUtil::getInstance();

    try {
        $parsedNumber = $phoneNumberUtil->parse($number);
        return $phoneNumberUtil->isValidNumberForRegion($parsedNumber, $countryCode);
    } catch (\libphonenumber\NumberParseException $e) {
        return false;
    }
}
?>