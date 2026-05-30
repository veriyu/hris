<?php

namespace App\Actions;

use App\Models\Company;
use App\Services\CompanyService;

class CompanyAction
{
    public function __construct(protected CompanyService $companyService)
    {
    }

    public function executeCreate(array $data): Company
    {
        return $this->companyService->createCompany($data);
    }

    public function executeUpdate(Company $company, array $data): bool
    {
        return $this->companyService->updateCompany($company, $data);
    }

    public function executeDelete(Company $company): bool
    {
        return $this->companyService->deleteCompany($company);
    }
}
