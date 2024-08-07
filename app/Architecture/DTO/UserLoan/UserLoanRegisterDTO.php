<?php

namespace App\Architecture\DTO\UserLoan;

use InvalidArgumentException;
use DateTime;

class UserLoanRegisterDTO {
    public function __construct(
        public string $value,
        public string $loanMaturity,
        public int $installments,
        public string $loanDescription,
        public int $userId,
        public int $loanModalityId,
        public bool $paid
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (!is_numeric($this->value) || floatval($this->value) <= 0) {
            throw new InvalidArgumentException('Valor do empréstimo deve ser um número positivo');
        }

        if (!$this->isValidDate($this->loanMaturity)) {
            throw new InvalidArgumentException('Data de vencimento inválida (formato: YYYY-MM-DD)');
        }

        if ($this->installments < 0) {
            throw new InvalidArgumentException('Número de parcelas não deve ser menor que zero');
        }

        if (empty($this->loanDescription)) {
            throw new InvalidArgumentException('Descrição do empréstimo não pode ser vazia');
        }

        if ($this->userId <= 0) {
            throw new InvalidArgumentException('ID do usuário inválido');
        }

        if ($this->loanModalityId <= 0) {
            throw new InvalidArgumentException('ID da modalidade de empréstimo inválido');
        }

        if (!is_bool($this->paid)) {
            throw new InvalidArgumentException('O campo "pago" deve ser um booleano');
        }
    }

    private function isValidDate(string $date): bool
    {
        $format = 'd/m/Y';
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
