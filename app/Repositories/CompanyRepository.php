<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Traits\RespondsWithHttpStatus;
use Exception;
class CompanyRepository implements  CompanyRepositoryInterface 
{
  use RespondsWithHttpStatus;

    public function getAll(object $comapnyDetails) 
    {
        $companies =Company::where('owner_id',auth()->user()->id)
        ->where('name', 'LIKE', '%' . $comapnyDetails->name . '%')
        ->get();

        return $companies;
    }

    public function create(object $companyDetails) 
    {
        $company = Company::where('owner_id',auth()->user()->id)
        ->where('name',$companyDetails->name)->get();

      if($company->count() > 0){

        return $this->failure("Company with name  '$companyDetails->name' already exist" , Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      if($company->count() > 2 ){

        return $this->failure("You can only register three companies" , Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      try {
        $company = new Company();
        $company->name = $companyDetails->name;
        $company->email = $companyDetails->email;
        $company->country = $companyDetails->country;
        $company->owner_id = auth()->user()->id;
        $company->save();

        return  $company;

       } catch (Exception $e) {

          return $e->getMessage();
       }
       
    }

    

    public function update(object $companyDetails) 
    {
        $company =  Company::where('id',$companyDetails->company_id)->first();

        if(empty($company)){

            return $this->failure('Company Not Found', Response::HTTP_NOT_FOUND);  
        }

        try {
        $company->name = $companyDetails->name;
        $company->email = $companyDetails->email;
        $company->country = $companyDetails->country;
        $company->owner_id = auth()->user()->id;
        $company->save();

        return $company;

      } catch (Exception $e) {

        return $e->getMessage();
      }

    }


    public function destroy($id) 
    {
        $company = Company::where('owner_id',auth()->user()->id)->first();

        if(empty($company)){

            return $this->failure('Company Not Found', Response::HTTP_NOT_FOUND);  
        }
        $company->delete();

        return $company;
    }

   
}
