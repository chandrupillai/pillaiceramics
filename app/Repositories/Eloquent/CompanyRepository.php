<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected Company $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    /**
     * Fetch the single company profile record.
     */
    public function getFirstCompany()
    {
        return $this->model->first();
    }

    /**
     * Update the existing company record or create a new one if none exists.
     */
    public function updateOrCreateCompany(array $data)
    {
        $company = $this->getFirstCompany();

        if ($company) {
            $company->update($data);
            return $company;
        }

        return $this->model->create($data);
    }

    public function getAll()
    {
        return $this->model->latest()->get();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $company = $this->findById($id);
        $company->update($data);
        return $company;
    }

    public function delete(int $id): bool
    {
        $company = $this->findById($id);
        return $company->delete();
    }
}