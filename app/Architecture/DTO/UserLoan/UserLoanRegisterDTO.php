<?php

namespace App\Architecture\DTO\UserLoan;

class UserLoanRegisterDTO {
    public function __construct(
        public string $value,
        public string $loanMaturity,
        public string $loanDescription,
        public int $userId,
        public int $loanModalityId,
    )
    {
    }
}
