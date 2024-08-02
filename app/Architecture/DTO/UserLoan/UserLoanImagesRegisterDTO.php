<?php

namespace App\Architecture\DTO\UserLoan;

class UserLoanImagesRegisterDTO {
    public function __construct(
        public string $image,
        public int $loanId,
    )
    {
    }
}
