<?php

use App\Models\Circuit;
use App\Models\CMC;
use App\Models\Organization;
use App\Models\RequestStatus;
use App\Models\School;
use App\Models\SchoolDistrict;
use App\Models\StockCategory;
use App\Models\StockItem;
use App\Models\ReplenishmentStatus;
use App\Models\SchoolLevel;
use App\Models\SchoolSnq;

//getting the list of all organization which is present in database 
function getListOfAllOrganization()
{
    return Organization::all();
}

//getting list of all schools which is present in database
function getListOfAllSchools()
{
    return School::all();
}

//getting list of all districts which is present in database
function getListOfAllDistricts()
{
    return SchoolDistrict::orderBy('district_office')->get();
}

//getting list of all Cmc which is present in database
function getListOfAllCmc()
{
    return CMC::orderBy('cmc_name')->get();
}

//getting list of all Cmc which is present in database
function getListOfAllCircuits()
{
    return Circuit::orderBy('circuit_name')->get();
}

//list of all stock categories
function getListOfAllCategories()
{
    return StockCategory::orderBy('name')->get();
}

//list of all stock items
function getListOfAllItems()
{
    return StockItem::orderBy('name')->get();
}

//list of all school snq
function getSchoolSnqList()
{
    return SchoolSnq::all();
}

//list of all school list
function getSchoolLevelList()
{
    return SchoolLevel::all();
}



//list of all furniture replacement status
function getStatusList()
{
    return RequestStatus::all();
}

//list of all replenishment status
function getreplenishmentstatus()
{
    return ReplenishmentStatus::all();
}