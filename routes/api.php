<?php

use App\Http\Controllers\Api\AnnexureController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\FurnitureRequest\CollectFurnitureController;
use App\Http\Controllers\Api\FurnitureRequest\CollectionRequestController;
use App\Http\Controllers\Api\Organization\OrganizationController;
use App\Http\Controllers\Api\Permission\PermissionController;
use App\Http\Controllers\Api\RequestStatus\StatusController;
use App\Http\Controllers\Api\ReplenishmentStatus\ReplenishmentStatusController;
use App\Http\Controllers\Api\Reports\ReportsController;
use App\Http\Controllers\Api\Reports\ReportSearchController;
use App\Http\Controllers\Api\School\SchoolCircuitController;
use App\Http\Controllers\Api\School\SchoolCMCController;
use App\Http\Controllers\Api\School\SchoolController;
use App\Http\Controllers\Api\School\SchoolDistrictController;
use App\Http\Controllers\Api\School\SchoolLevelController;
use App\Http\Controllers\Api\School\SchoolSubplaceController;
use App\Http\Controllers\Api\School\SNQController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\Stock\StockCategoryController;
use App\Http\Controllers\Api\Stock\StockItemController;
use App\Http\Controllers\Api\User\ManageUserController;
use App\Models\CollectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'cors'], function () {

    // Not protected routes
    Route::group([], function () {
        //Route for login
        Route::post('/login', [AuthController::class, 'login']);
        //Route for Forget password
        Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
        Route::get('/all-permissions', [PermissionController::class, 'index']);
    });


    // Auth Protected Routes 
    Route::group(['middleware' => 'auth-api'], function () {

        // Authenticated routes for users operations
        Route::group(['prefix' => 'user'], function () {

            // School District routes
            Route::resource("/school-district", SchoolDistrictController::class);
            Route::get("/get-all-school-district", [SchoolDistrictController::class, 'getAllDistrict']);

            //school district search api by district_office,director
            Route::get('/search/district', [SchoolDistrictController::class, 'search']);

            //school CMC routes 
            Route::resource("/school-cmc", SchoolCMCController::class);
            //school cmc search api by cmc_name
            Route::get('/search/school-cmc', [SchoolCMCController::class, 'search']);

            //school Circuits routes 
            Route::resource("/school-circuit", SchoolCircuitController::class);
            //school Circuits search api by circuit name
            Route::get('/search/school-circuit', [SchoolCircuitController::class, 'search']);

            //school Subplace routes 
            Route::resource("/school-subplace", SchoolSubplaceController::class);
            //school Subplace search api by subplace name
            Route::get('/search/school-subplace', [SchoolSubplaceController::class, 'search']);

            //School Routes
            Route::resource('/school', SchoolController::class);
            //school search api by name , principal and emis number
            Route::get('/search/school', [SchoolController::class, 'schoolSerach']);

            //Permissions routes 
            Route::resource('/permission', PermissionController::class);

            //Status list
            Route::get("/status/get-all-status", [StatusController::class, 'getAllStatus']);
            //Replenishment Status list
            Route::get("/status/get-all-replenishment-status", [ReplenishmentStatusController::class, 'getreplenishmentstatus']);

            //Organization Routes
            Route::resource('/organization', OrganizationController::class);

            //manage users
            Route::resource('/manage', ManageUserController::class);
            //school search api by name , principal and emis number
            Route::get('/search/query', [ManageUserController::class, 'userSearch']);

            //Stock Item Category Routes 
            Route::resource('/stock-category', StockCategoryController::class);
            Route::get('/search/stock-category', [StockCategoryController::class, 'stockCategorySearch']);

            //Stock Item routes 
            Route::resource('/stock-item', StockItemController::class);
            Route::get('/search/stock-item', [StockItemController::class, 'stockItemSearch']);

            // Furniture Collection Request
            Route::resource('/furniture-collection-request', CollectionRequestController::class);
            Route::get('/search/furniture-collection-request', [CollectionRequestController::class, 'searchRequest']);

            //Furniture manage Request
            Route::get('/furniture-manage-collection/list', [CollectionRequestController::class, 'getManageRequestList']);
            Route::get('/search/furniture-collection-manage', [CollectionRequestController::class, 'searchManageRequest']);

            // Furniture Repair Request
            Route::post('/furniture-collect/repair-submit', [CollectFurnitureController::class, 'storeRepair']);

            //Furniture collect 
            Route::resource('/furniture-collect', CollectFurnitureController::class);
            Route::post('/collection/deliver-collection', [FileUploadController::class, 'submitCollectionDelivery']); // Upload annexure - d
            //print Annexures
            Route::post('/download/annexure/a', [AnnexureController::class, 'printAnnexureA']); //print furniture collection slip
            Route::post('/download/annexure/b', [AnnexureController::class, 'printAnnexureB']); // print dispossal certificate
            Route::post('/download/annexure/c', [AnnexureController::class, 'printAnnexureC']); // print Replenish request
            Route::post('/download/annexure/d', [AnnexureController::class, 'printAnnexureD']); // print delivery notes

            //Files upload routes
            Route::post('/file/upload/proof-of-replenishment', [FileUploadController::class, 'proofOfReplenishment']); // Upload annexure -c
            Route::post('/file/upload/disposal-images',[FileUploadController::class,'disposalImages']);

            //get School snq list
            Route::get("/list/school-snq", [SNQController::class, 'getAllSNQ']);
            // get School level list
            Route::get("/list/school-level", [SchoolLevelController::class, 'getAllLevel']);


            //Routes for collection request search
            Route::group(['prefix' => 'collection-request/search'], function () {
                Route::get("get-search-list", [SearchController::class, 'index']);
                Route::post("reference-number", [SearchController::class, 'byReferenceNumber']);
                Route::post("date-range", [SearchController::class, 'byDateRange']);
            });

            //Routes for collection request search
            Route::group(['prefix' => 'reports'], function () {
                Route::post("replenishment-report", [ReportsController::class, 'getReplenishmentReport']);
                Route::post("disposal-report", [ReportsController::class, 'getDisposalReport']);
                Route::post("manufacturer-stock-management-report", [ReportsController::class, 'getManufacturerStockManagementReport']);
                Route::post("school-furniture-count-report", [ReportsController::class, 'getSchoolFurnitureCountReport']);
                Route::post("repairment-report", [ReportsController::class, 'getRepairmentReport']);
                Route::post("transaction-summary-report", [ReportsController::class, 'getTransactionSummaryReport']);
                Route::post("transaction-status-report", [ReportsController::class, 'getTransactionStatusReport']);
            });

            //Routes for dashboard

            Route::group(['prefix' => 'dashboard'], function () {
                Route::get("get-total-count", [DashboardController::class, 'getTotalCount']);
                Route::get("get-pending-collection", [DashboardController::class, 'getPandingCollection']);
                Route::get("get-ytd-status-count", [DashboardController::class, 'getYTDStatusCount']);
                Route::get("get-previous-year-status", [DashboardController::class, 'getPreviousYearStatus']);
                Route::get("get-progress-collection", [DashboardController::class, 'getProgressCollection']);

                //Download reports 
                Route::get("ytd-status-count/report-download",[DashboardController::class,'downloadYTDReport']);
                Route::get("previous-year-status/report-download",[DashboardController::class,'downloadPreviousYearReport']);

            });

            // Route for logout 
            Route::post('/logout', [AuthController::class, 'logout']);
            // Route for change password
            Route::post('/change-password', [AuthController::class, 'changePassword']);
        });
    });

    Route::get("test2", [ReportsController::class, 'downloadReplenishedReports']);
    Route::get("/test", function () {
        $customer_header = [
            "school_name", "school_emis", "district_office", "ref_number", "transaction_date", "furniture_category", "furniture_category", "replenished_count", "replenishment_status", "total_per_school"
        ];

        // foreach ($data as $key => $request) {
        //     foreach ($request->getBrokenItems as $key2 => $item) {
        //         $list["records"][$key2] = [
        //             "school_name" => $request->school_name,
        //             "school_emis" => $request->emis,
        //             "district_office" => $request->getSchoolDetails($request->emis)->getDistrict->district_office,
        //             "ref_number" => $request->ref_number,
        //             "transaction_date" => $request->created_at->toDateString(),
        //             "furniture_category" => $item->getCategoryDetails->name,
        //             "replenished_count" => $item->replenished_count,
        //             "replenishment_status" => $request->getReplenishStatus->name,
        //             "total_per_school" => "No data"
        //         ];
        //     }
        // }

        // $customer_data = CollectionRequest::where("replenishment_status", '!=', null)->get();
        $customer_data = [1, 2, 3, 4, 5, 6];
        $spreadSheet = new Spreadsheet();

        $aplha = range("A", "Z");
        foreach ($customer_header as $key => $value) {
            $spreadSheet->getActiveSheet()->setCellValue($aplha[$key] . 1, $value);
        }
        $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
        $x = 2;
        foreach ($customer_data as $key => $value) {
            $spreadSheet->getActiveSheet()->setCellValue("A" . $x, $value);
            $x++;
        }
        $Excel_writer = new Xls($spreadSheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Customer_ExportedData.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $Excel_writer->save('php://output');
    });
});
