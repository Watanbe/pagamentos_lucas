<?php

namespace App\Architecture\DTO\UserLoan;

class UserLoanRegisterDTO {
    public string $loanImage;
    public string $value;
    public string $loanMaturity;
    public string $loanDescription;
    public int|null $userId = null;
    public int|null $loanModalityId = null;
}
