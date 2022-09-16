<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Http\Response;
use App\Http\Requests\CompanyRegistrationRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Interfaces\CompanyRepositoryInterface;

class CompanyController extends Controller
{
    
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository) 
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(Request $request)
    {
        $companies = $this->companyRepository->getAll($request);

        return $this->success("success", $companies ,  Response::HTTP_OK);
    }

    public function store(CompanyRegistrationRequest $request)
    {
        $company = $this->companyRepository->create($request);

        return $this->success('Company Added Successfully', $company, Response::HTTP_CREATED);
    }


    public function update(UpdateCompanyRequest $request )
    {
        $company = $this->companyRepository->update($request);

        return $this->success('Company Updated Successfully', $company, Response::HTTP_CREATED);
       
    }

    public function destroy($id)
    {
        $company = $this->companyRepository->destroy($id);

        return $this->success("record deleted successfully" , Response::HTTP_OK);
    }
}
