<?php

namespace App\Architecture\Services\UserLoan;

use App\Architecture\DTO\UserLoan\UserLoanImagesRegisterDTO;
use App\Models\LoanImages;
use Carbon\Carbon;

class UserLoanImageService {

    public function create(UserLoanImagesRegisterDTO $userLoanImagesRegisterDTO) {
        return LoanImages::create([
            'loan_image' => $userLoanImagesRegisterDTO->image,
            'user_loan_id' => $userLoanImagesRegisterDTO->loanId
        ]);
    }
}
