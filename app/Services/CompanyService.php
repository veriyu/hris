<?php

namespace App\Services;

use App\Models\Company;

class CompanyService
{
    public function createCompany(array $data): Company
    {
        return Company::create($data);
    }

    public function updateCompany(Company $company, array $data): bool
    {
        return $company->update($data);
    }

    public function deleteCompany(Company $company): bool
    {
        return $company->delete();
    }
}
