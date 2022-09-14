<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Http\Response;
use App\Http\Requests\CompanyRegistrationRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    

    public function index(Request $request)
    {
        $companies =Company::where('owner_id',auth()->user()->id)
        ->where('name', 'LIKE', '%' . $request->name . '%')
        ->get();

        return $this->success("success", $companies ,  Response::HTTP_OK);
    }

    public function store(CompanyRegistrationRequest $request)
    {
       
       
      $company = Company::where('owner_id',auth()->user()->id)
      ->where('name',$request->name)->get();

      if($company->count() > 0){

        return $this->failure("Company with name  '$request->name' already exist" , Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      if($company->count() > 2 ){

        return $this->failure("You can only register three companies" , Response::HTTP_UNPROCESSABLE_ENTITY);
      }
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->country = $request->country;
        $company->owner_id = auth()->user()->id;
        $company->save();

        return $this->success('Company Added Successfully', $company, Response::HTTP_CREATED);
    }


    public function update(UpdateCompanyRequest $request )
    {
       
      
        $company =  Company::where('id',$request->company_id)->first();

        if(empty($company)){
            return $this->failure('Company Not Found', Response::HTTP_NOT_FOUND);  
        }
        $company->name = $request->name;
        $company->email = $request->email;
        $company->country = $request->country;
        $company->owner_id = auth()->user()->id;
        $company->save();

        return $this->success('Company Added Successfully', $company, Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $company = Company::where('owner_id',auth()->user()->id)->first();

        if(empty($company)){

            return $this->failure('Company Not Found', Response::HTTP_NOT_FOUND);  
        }
        $company->delete();

        return $this->success("record deleted successfully" , Response::HTTP_OK);
    }
}
