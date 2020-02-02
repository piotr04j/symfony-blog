<?php

namespace App\Services;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class FormViolationsHandler
{
    public function getViolationMessages(ConstraintViolationListInterface $errors): array
    {
        $numberOfViolations = $errors->count() - 1;
        $violationMessages = [];
        while ($numberOfViolations >= 0) {
            array_push($violationMessages, $errors->get($numberOfViolations)->getMessage());
            $numberOfViolations--;
        }

        return $violationMessages;
    }
}