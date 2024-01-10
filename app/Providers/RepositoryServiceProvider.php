<?php

namespace App\Providers;

use App\Interfaces\AnnexureRepositoryInterface;
use App\Interfaces\DashboardRepositoryInterface;
use App\Interfaces\SchoolLocation\DistrictRepositoryInterface;
use App\Interfaces\FileUploadRepositoryInterface;
use App\Interfaces\FurnitureRequest\CollectFurnitureRepositoryInterface;
use App\Interfaces\FurnitureRequest\CollectionRequestRepositoryInterface;
use App\Interfaces\FurnitureRequest\RepairFurnitureRepositoryInterface;
use App\Interfaces\Reports\ReportsRepositoryInterface;
use App\Interfaces\SchoolLocation\CircuitRepositoryInterface;
use App\Interfaces\SchoolLocation\CMCRepositoryInterface;
use App\Interfaces\SchoolLocation\SubplaceRepositoryInterface;
use App\Repositories\SchoolLocation\DistrictRepository;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\SearchRepositoryInterface;
use App\Interfaces\Stock\CategoryRepositoryInterface;
use App\Interfaces\Stock\ItemRepositoryInterface;
use App\Interfaces\User\ManageUserRepositoryInterface;
use App\Repositories\AnnexureRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\FileUploadRepository;
use App\Repositories\FurnitureRequest\CollectFurnitureRepository;
use App\Repositories\FurnitureRequest\CollectionRequestRepository;
use App\Repositories\FurnitureRequest\RepairFurnitureRepository;
use App\Repositories\Reports\ReportsRepository;
use App\Repositories\SchoolLocation\CircuitRepository;
use App\Repositories\SchoolLocation\CMCRepository;
use App\Repositories\SchoolLocation\SubplaceRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\SearchRepository;
use App\Repositories\Stock\CategoryRepository;
use App\Repositories\Stock\ItemRepository;
use App\Repositories\User\ManageUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //School  District repo binding
        $this->app->bind(DistrictRepositoryInterface::class, DistrictRepository::class);

        //School CMC repo binding 
        $this->app->bind(CMCRepositoryInterface::class, CMCRepository::class);

        //School Circuit repo binding 
        $this->app->bind(CircuitRepositoryInterface::class, CircuitRepository::class);

        //School Subplaces repo binding 
        $this->app->bind(SubplaceRepositoryInterface::class, SubplaceRepository::class);

        //Manage user bindng
        $this->app->bind(ManageUserRepositoryInterface::class, ManageUserRepository::class);

        //Admin Panel
        $this->app->bind(SchoolRepositoryInterface::class, SchoolRepository::class);

        //Stock Category Binding 
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        //stock item binding
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);

        //Furniture collection - reqesuet binding
        $this->app->bind(CollectionRequestRepositoryInterface::class, CollectionRequestRepository::class);

        //Furticture collect binding
        $this->app->bind(CollectFurnitureRepositoryInterface::class, CollectFurnitureRepository::class);

        //Annexure bindng
        $this->app->bind(AnnexureRepositoryInterface::class, AnnexureRepository::class);

        //Repair Furniture repo binding
        $this->app->bind(RepairFurnitureRepositoryInterface::class, RepairFurnitureRepository::class);

        //File upload repo binding
        $this->app->bind(FileUploadRepositoryInterface::class, FileUploadRepository::class);

        //search repository binding
        $this->app->bind(SearchRepositoryInterface::class, SearchRepository::class);

        //reports repository binding
        $this->app->bind(ReportsRepositoryInterface::class, ReportsRepository::class);

        //dashboard repository binding
        $this->app->bind(DashboardRepositoryInterface::class,DashboardRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
