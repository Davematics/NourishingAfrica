<?php
namespace App\Interfaces;

interface CompanyRepositoryInterface 
{

    public function create(object $companyDetails);
    public function getAll(object $companyDetails);
    public function update(object $companyDetails);
    public function destroy(int $id);
    
}