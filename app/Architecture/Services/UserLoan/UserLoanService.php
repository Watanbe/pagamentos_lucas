<?php

namespace App\Architecture\Services\UserLoan;

use App\Architecture\DTO\UserLoan\UserLoanRegisterDTO;
use App\Models\UserLoan;
use Carbon\Carbon;

class UserLoanService {

    public function create(UserLoanRegisterDTO $userLoanRegisterDTO) {
        return UserLoan::create([
            'value' => $userLoanRegisterDTO->value,
            'loan_maturity' => Carbon::createFromFormat('d/m/Y', $userLoanRegisterDTO->loanMaturity)->format('Y-m-d'),
            'installments' => $userLoanRegisterDTO->installments,
            'loan_description' => $userLoanRegisterDTO->loanDescription,
            'user_id' => $userLoanRegisterDTO->userId,
            'loan_modality_id' => $userLoanRegisterDTO->loanModalityId
        ]);
    }

    public function getByUser(int $userId) {
        return UserLoan::with([
            'loanModality',
            'loanImages'
        ])
        ->where([
            ["user_id", "=", $userId]
        ])->get();
    }

    public function getById(int $id) {
        return UserLoan::with([
            'loanModality',
            'loanImages'
        ])->find($id);
    }
}
