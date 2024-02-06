<?php

use App\Http\Controllers\ExcelSchoolController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/',  function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/updateTextbookSavedItem{ISBN}/{Price}', [\App\Http\Controllers\textbook_cat::class, 'updateTextbookItem'])->name('textbookItemUpdate');
// Routes for Funds and Procurement
Route::get('/Funds', [\App\Http\Controllers\Funds::class, 'index'])->name('Funds.index');
Route::get('/InboxSchool', [\App\Http\Controllers\inboxSchool::class, 'index'])->name('inboxSchool');
Route::get('/HistoryFunds', [\App\Http\Controllers\History_Requests::class, 'index'])->name('Request_History.index');
Route::post('/UpdateHistoryFunds', [\App\Http\Controllers\History_Requests::class, 'updateRequestCurrent'])->name('requestUpdate.funds');
Route::delete('/DeleteHistoryFunds{deleteId}', [\App\Http\Controllers\History_Requests::class, 'deleteRequestCurrent'])->name('requestDelete.funds');
Route::post('/InsertTextbookFunds', [\App\Http\Controllers\RequestFundsController::class, 'InsertTextbookFunds'])->name('request.funds');
Route::get('/download/{documentId}',  [\App\Http\Controllers\RequestFundsController::class, 'download'])->name('document.download');


// Routes choose suppliers

//Routes for Textbook Catalogue
Route::get('/textbookCat/{requestType}/{idInbox}', [\App\Http\Controllers\textbook_cat::class, 'index'])->name('textbookCat');
Route::post('/textbookCat/SavedItems', [\App\Http\Controllers\textbook_cat::class, 'saveCheckedItems'])->name('saveCheckedItems');
Route::get('/FilterTextbook', [\App\Http\Controllers\textbook_cat::class, 'filterCatalogue'])->name('filterTextbook');
Route::get('/update-session', [\App\Http\Controllers\textbook_cat::class, 'updateSession'])->name('updateSession'); 
Route::delete('/DeleteTextbookSavedItem{deleteId}', [\App\Http\Controllers\textbook_cat::class, 'deleteTextbookItem'])->name('textbookItemDelete');
Route::post('/SubmitSavedItemsFF', [\App\Http\Controllers\textbook_cat::class, 'submitSavedItems'])->name('submitSavedItemsFF');
Route::post('/generateQuote', [\App\Http\Controllers\textbook_cat::class, 'generatePdf'])->name('generateQuote');
Route::delete('/DeleteQuote', [\App\Http\Controllers\textbook_cat::class, 'quoteTextbookDelete'])->name('quoteTextbookDelete');

//Routes for Stationery Catalogue 
Route::get('/stationeryCat/{requestType}/{idInbox}', [\App\Http\Controllers\stationery_cat::class, 'index'])->name('stationeryCat');

Route::get('/StationeryAdd',[\App\Http\Controllers\stationery_cat::class, 'AddStationery'])->name('StationeryAddNew');
Route::post('/AddingStationery',[\App\Http\Controllers\SchoolStationery::class, 'addItemToCart'])->name('addItemToCart');

//For Creating new quote for editing the quantity
Route::get('/stationeryCatNew/{requestType}/{idInbox}', [\App\Http\Controllers\stationery_cat::class, 'indexNew'])->name('stationeryCatNew');

Route::get('/searchStationery',[\App\Http\Controllers\stationery_cat::class, 'searchStationery'])->name('searchStationery');

Route::get('/searchStationeryNew',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'searchStationeryNew'])->name('searchStationeryNew');


Route::post('/stationeryCat/SavedItems', [\App\Http\Controllers\stationery_cat::class, 'saveCheckedItemsStat'])->name('saveCheckedItemsStat');

Route::post('/stationeryCatNew/SavedItems', [\App\Http\Controllers\stationery_cat::class, 'saveCheckedItemsStatNew'])->name('saveCheckedItemsStatNew');


Route::post('/stationeryCat/SavedUnit', [\App\Http\Controllers\stationery_cat::class, 'SaveUnitPriceStationery'])->name('SaveUnitPriceStationery');


Route::post('/DeleteStationerySavedItem', [\App\Http\Controllers\stationery_cat::class, 'deleteStationeryItem'])->name('StationeryItemDelete');
Route::post('/SubmitSavedItems', [\App\Http\Controllers\stationery_cat::class, 'submitSavedItems'])->name('submitSavedItems');


Route::post('/SubmitSavedItemsNew', [\App\Http\Controllers\stationery_cat::class, 'submitSavedItemsNew'])->name('submitSavedItemsNew');


 
Route::post('/generateQuoteStationery', [\App\Http\Controllers\stationery_cat::class, 'generateQuoteStationery'])->name('generateQuoteStationery');
Route::delete('/DeleteQuoteStationery', [\App\Http\Controllers\stationery_cat::class, 'quoteTextbookDeleteStationery'])->name('quoteTextbookDeleteStationery');
Route::get('/viewQuotesStats',[\App\Http\Controllers\stationery_cat::class, 'viewQuotesStat'])->name('viewQuotesStats');
 


Route::get('/ApproveOrder',[\App\Http\Controllers\ApproveOrder::class, 'index'])->name('ApproveUploadOrderDistrict');

Route::post('/UploadOrderForm', [\App\Http\Controllers\ApproveOrder::class, 'UploadOrderForm'])->name('UploadOrderForm');

// routes/web.php
Route::post('/updateDeliveryDate', [\App\Http\Controllers\ApproveOrder::class, 'updateDeliveryDate'])->name('updateDeliveryDate');


//For District Of Inbox table downloadSignedEF58
Route::get('/InboxSchoolDistrict', [\App\Http\Controllers\InboxSchoolDistict::class, 'index'])->name('InboxSchoolDistrict');
Route::get('/Capture/{requestType}/{emis}/{fundsId}', [\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'Capture'])->name('AdminCaptureSupplierOrder');

Route::get('/CaptureUnit/{RequestTypes}/{Emis}/{fundsId}', [\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'CaptureStatUnitPrice'])->name('AdminCaptureStatUnitPrice');

Route::get('/viewSupplierDetails/{itemId}', [\App\Http\Controllers\ViewSupplierDetails::class, 'index'])->name('viewSupplierDetails');
Route::get('/downloadQuoteAdmin/{fileName}',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadQuoteAdmin'])->name('downloadQuoteAdmin');
Route::get('/downloadSBD4Admin/{fileName}',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadSBD4Admin'])->name('downloadSBD4Admin');
Route::get('/downloadTaxAdmin/{fileName}',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadTaxAdmin'])->name('downloadTaxAdmin');
Route::get('/downloadSignedEF58',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadSignedEF58'])->name('downloadSignedEF58');
 
Route::post('/ApproveDeclineRequest',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'ApproveDeclineRequest'])->name('ApproveDeclineRequest');
 
 
Route::post('/deleteTextbook', [\App\Http\Controllers\textbook_cat::class, 'deleteTextbook'])->name('deleteTextbook');

Route::get('/downloadCheckList/{emis}/{requestType}',[\App\Http\Controllers\InboxSchoolDistict::class, 'downloadCheckList'])->name('downloadCheckList');
Route::post('/DeclineRequest',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'DeclineRequest'])->name('DeclineRequest');
Route::post('/GenerateChecklistApprove',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'GenerateChecklistApprove'])->name('GenerateChecklistApprove');


Route::post('/deleteTextbook', [\App\Http\Controllers\textbook_cat::class, 'deleteTextbook'])->name('deleteTextbook');

Route::get('/view-quotes',[\App\Http\Controllers\textbook_cat::class, 'viewQuotes'])->name('viewQuotes');
Route::get('/ShowPdfs',[\App\Http\Controllers\textbook_cat::class, 'ShowPdf'])->name('ShowPdfs');
Route::get('/genpdfE',[\App\Http\Controllers\textbook_cat::class, 'genPdfExample'])->name('genPdfExample');



Route::get('/Supplier', [\App\Http\Controllers\SuppliyerController::class, 'add'])->name('Suppliyer.Add');
Route::get('/Suppliyer/schoolsupplier.edit/{id}', [\App\Http\Controllers\SuppliyerController::class, 'edit'])->name('schoolsupplier.edit');

Route::post('/suppliar/update/{id}', [\App\Http\Controllers\SuppliyerController::class, 'update'])->name('suppliar.update');

//   Route::get('/Funds/ViewFundsReques/edit-funds/{id}', [\App\Http\Controllers\AdminViewFundsRequest::class, 'edit'])->name('eidtFunds');



//for Supplier
Route::get('/Supplier/list', [\App\Http\Controllers\SuppliyerController::class, 'index'])->name('Suppliyer.list');

Route::post('/AddSuppliyer', [\App\Http\Controllers\SuppliyerController::class, 'AddSuppliyer'])->name('AddSuppliyer');
Route::post('/DelSuppliar', [\App\Http\Controllers\SuppliyerController::class, 'DeleteSuppliar'])->name('schoolsupplier.destroy');

Route::get('/SchoolSuppliyer/search', [\App\Http\Controllers\SuppliyerController::class, 'search'])->name('schoolsupplier.search');


//For Commitee COMMITTEE committee
Route::get('/Commitee/list', [\App\Http\Controllers\CommitteeMember::class, 'index'])->name('Member.list');

Route::get('/Member', [\App\Http\Controllers\CommitteeMember::class, 'add'])->name('Member.Add');
Route::post('/AddMember', [\App\Http\Controllers\CommitteeMember::class, 'AddMember'])->name('AddMember');

Route::get('/Member/schoolmember.edit/{id}', [\App\Http\Controllers\CommitteeMember::class, 'edit'])->name('schoolmember.edit');

Route::post('/DeleteMember', [\App\Http\Controllers\CommitteeMember::class, 'DeleteMember'])->name('schoolmember.destroy');
Route::post('/member/update/{id}', [\App\Http\Controllers\CommitteeMember::class, 'update'])->name('member.update');
Route::get('/Member/search', [\App\Http\Controllers\CommitteeMember::class, 'search'])->name('membersupplier.search');



//Routes for Request Quotes
Route::get('/chooseSupplier/{requestType}/{MinQuotes}', [\App\Http\Controllers\chooseSupplier::class, 'index'])->name('chooseSupplier');
Route::get('/download_comitee',[\App\Http\Controllers\chooseSupplier::class, 'downloadComitee'])->name('downloadComitee');
Route::get('/download_disclosure',[\App\Http\Controllers\chooseSupplier::class, 'downloadDisclosure'])->name('downloadDisclosure');
Route::post('/RequestQuote', [\App\Http\Controllers\chooseSupplier::class, 'requestQuote'])->name('requestQuote');


//Download Order letter
Route::get('/download_OrderLetter',[\App\Http\Controllers\ApproveOrder::class, 'OrderLetter'])->name('OrderLetter');


       //Delivery Note Process
       Route::get('/Delivery/list',[\App\Http\Controllers\DeliveryController::class, 'index'])->name('Delivery.list');
       Route::get('/Deliveries', [\App\Http\Controllers\DeliveryController::class, 'add'])->name('Deliverys.Add');
       Route::post('/AddDeliverys', [\App\Http\Controllers\DeliveryController::class, 'AddDelivery'])->name('AddDeliverys');
       Route::get('/Delivery/Delivery.edit/{id}', [\App\Http\Controllers\DeliveryController::class, 'edit'])->name('Delivery.edit');
       Route::post('/Delivery.update', [\App\Http\Controllers\DeliveryController::class, 'update'])->name('Delivery.update');
       Route::post('/DelDeliveryNote', [\App\Http\Controllers\DeliveryController::class, 'DeleteDeliveryNote'])->name('Delivery.destroy');


       //Admin Delivery Note Process searchStationeryAdmin
       Route::get('/searchStationeryAdmin',[\App\Http\Controllers\AdminDeliveryController::class, 'searchStationeryAdmin'])->name('searchStationeryAdmin');
       Route::get('/AdminDelivery/list',[\App\Http\Controllers\AdminDeliveryController::class, 'index'])->name('AdminDelivery.list');
       Route::get('/CaptureData/{delID}/{requestType}/{idInbox}/{emis_new}', [\App\Http\Controllers\AdminDeliveryController::class, 'CaptureData'])->name('CaptureData');


       Route::get('/CaptureDataDelivery/{refNo}/{requestType}/{idInbox}/{emis_new}', [\App\Http\Controllers\AdminDeliveryController::class, 'CaptureDataDelivery'])->name('CaptureDataDelivery');

       Route::get('/filterTextbookAdmin', [\App\Http\Controllers\AdminDeliveryController::class, 'filterTextbookAdmin'])->name('filterTextbookAdmin');
       Route::post('/textbookSavedItem', [\App\Http\Controllers\AdminDeliveryController::class, 'saveCheckedItemsForTextbook'])->name('saveCheckedItemsForTextbookQuantity');

       Route::delete('/textbookItemDeleteAdmins{deleteId}', [\App\Http\Controllers\AdminDeliveryController::class, 'deleteTextbookItem'])->name('textbookItemDeleteAdmins');
       Route::post('/saveCheckedItemsStatStionery', [\App\Http\Controllers\AdminDeliveryController::class, 'saveCheckedItemsStat'])->name('saveCheckedItemsStatStionery');
       Route::get('/stationeryCatAdmin/{requestType}/{idInbox}', [\App\Http\Controllers\AdminDeliveryController::class, 'CaptureStat'])->name('stationeryCatAdmin');
       Route::delete('/DeleteStationerySavedItem{deleteId}', [\App\Http\Controllers\AdminDeliveryController::class, 'deleteStationeryItem'])->name('StationeryItemDeleteNEW');


       Route::post('/submitSavedItemsForTextBook', [\App\Http\Controllers\AdminDeliveryController::class, 'submitSavedItemsForTextBook'])->name('submitSavedItemsForTextBook');
       Route::get('/downloadQuoteSupplier/{supplierID}',[\App\Http\Controllers\SuppliyerController::class, 'downloadQuoteSupplier'])->name('downloadQuoteSupplier');

       Route::get('/downloadSBD4Supplier/{supplierID}',[\App\Http\Controllers\SuppliyerController::class, 'downloadSBD4Supplier'])->name('downloadSBD4Supplier');
       // Recieve Quotes submitSuppliers CaptureSuppliers  
Route::get('/receiveQuotes/{requestType}', [\App\Http\Controllers\Receive_Quote::class, 'index'])->name('receiveQuotes');
Route::post('/RecieveQuotes/SubmitSuppliers', [\App\Http\Controllers\Receive_Quote::class, 'submitSuppliers'])->name('submitSuppliers');
Route::get('/captureSuppliersPage/{itemId}', [\App\Http\Controllers\captureSupplierDetails::class, 'index'])->name('captureSuppliersPage');
Route::post('/RecieveQuotes/updateRecommended', [\App\Http\Controllers\Receive_Quote::class, 'updateRecommended'])->name('updateRecommended');

Route::post('/updateDeviationReason', [\App\Http\Controllers\Receive_Quote::class, 'updateDeviationReason'])->name('updateDeviationReason');


Route::post('/RecieveQuotes/CaptureSuppliers', [\App\Http\Controllers\Receive_Quote::class, 'CaptureSuppliers'])->name('CaptureSuppliers');
Route::get('/download_EF58',[\App\Http\Controllers\Receive_Quote::class, 'downloadEF58'])->name('downloadEF58');

Route::get('/downloads_EF58',[\App\Http\Controllers\Receive_Quote::class, 'downloadEF58New'])->name('downloadEF58New');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect('home');
    });

    // Manage Users route
    Route::resource('users', \App\Http\Controllers\Admin\Users\ManageUserController::class);
    Route::get('users-search', [\App\Http\Controllers\Admin\Users\ManageUserController::class, 'search']);
    Route::get('/search', [\App\Http\Controllers\Admin\Users\ManageUserController::class, 'schoolsearch']);

    // Create collection request routes
    Route::resource('furniture-replacement', \App\Http\Controllers\Admin\Collection\CollectionRequestController::class);
    Route::get('furniture-replacement-search', [\App\Http\Controllers\Admin\Collection\CollectionRequestController::class, 'search']);


    Route::get('/TransactionSearch', [\App\Http\Controllers\AdminDeliveryController::class, 'searchRequest']);

    Route::get('/TransactionSearchView', [\App\Http\Controllers\AdminDeliveryController::class, 'searchRequestView']);

    //Route::get('/searchStationeryAdmin',[\App\Http\Controllers\AdminDeliveryController::class, 'searchStationeryAdmin'])->name('searchStationeryAdmin');



    //Route::delete('/DelNow', [\App\Http\Controllers\UploadController::class, 'destroy'])->name('DelNow');

    Route::post('/DelNow', [\App\Http\Controllers\UploadController::class, 'destroy'])->name('DelNow');


    Route::get('/Upload', [\App\Http\Controllers\UploadController::class, 'index'])->name('UploadR');

    Route::post('/Upload', [\App\Http\Controllers\UploadController::class, 'uploadData'])->name('upload-data');

    Route::post('/upload-catalogue', [\App\Http\Controllers\UploadController::class, 'uploadcat'])->name('upload-catalogue');

    Route::post('/upload-stationary', [\App\Http\Controllers\UploadController::class, 'uploadstat'])->name('upload-stationary');


    Route::post('/action2', [\App\Http\Controllers\UploadController::class, 'action2'])->name('action2');

    Route::post('/MarkAsRead', [\App\Http\Controllers\UploadController::class, 'MarkAsRead'])->name('MarkAsRead');

    Route::post('/DeleteMessage', [\App\Http\Controllers\UploadController::class, 'DeleteMessage'])->name('DeleteMessage');

   

   Route::get('/notification', [\App\Http\Controllers\Notification::class, 'index'])->name('notification');

   Route::get('/inbox-search', [\App\Http\Controllers\Notification::class, 'searches'])->name('inbox-search');

   


   //Route::post('/Funds', [\App\Http\Controllers\RequestFundsController::class, 'InsertTextbookFunds'])->name('request.funds');

   Route::get('/Funds/ViewFundsRequest', [\App\Http\Controllers\AdminViewFundsRequest::class, 'index'])->name('AdminViewFundRequest.index');


   Route::get('RequestFunds-search', [\App\Http\Controllers\AdminViewFundsRequest::class, 'search']);

   //    Route::get('furniture-replacement-search', [\App\Http\Controllers\Admin\Collection\CollectionRequestController::class, 'search']);


   Route::get('/Funds/ViewFundsReques/edit-funds/{id}', [\App\Http\Controllers\AdminViewFundsRequest::class, 'edit'])->name('eidtFunds');


   Route::post('/Funds/ViewFundsReques/edit-funds/', [\App\Http\Controllers\AdminViewFundsRequest::class, 'UpdateFundRequest'])->name('UpdateFundsRequest');


   Route::post('/ShowPdf', [\App\Http\Controllers\SchoolBasedProcController::class, 'showSchoolBasedProc'])->name('school-based-proc');

   Route::get('/ShowPdf', [\App\Http\Controllers\SchoolBasedProcController::class, 'showSchoolBasedProc'])->name('school-based-proc');

   Route::get('/generate-pdf', [\App\Http\Controllers\SchoolBasedProcController::class, 'generatePdf']);


   Route::get('/RequestPrecurement', [\App\Http\Controllers\RequestPrecurementController::class, 'index'])->name('request.index');

   Route::post('/RequestPrecurement', [\App\Http\Controllers\RequestPrecurementController::class, 'processSelection'])->name('process.selection');


//ApproveDeclineRequest
   Route::get('/orderform', [\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'CaputureOder'])->name('orderform');


       //For Roles
       Route::get('/Roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('Roles');

      Route::get('/Roles/edit', [\App\Http\Controllers\EditRoleController::class, 'index'])->name('editRoless');

      Route::get('/Roles/edit/EditNewRole/{id}', [\App\Http\Controllers\EditRoleController::class, 'edit'])->name('EditNewRole');

      Route::post('/Roles/edit/EditNewRole/', [\App\Http\Controllers\EditRoleController::class, 'update'])->name('EditNewRole.Update');


//   Route::get('/Funds/ViewFundsReques/edit-funds/{id}', [\App\Http\Controllers\AdminViewFundsRequest::class, 'edit'])->name('eidtFunds');



       Route::post('/AddRole', [\App\Http\Controllers\RoleController::class, 'AddRole'])->name('Add.Role');


//For District Of Inbox table downloadSignedEF58
Route::get('/InboxSchoolDistrict', [\App\Http\Controllers\InboxSchoolDistict::class, 'index'])->name('InboxSchoolDistrict');
Route::get('/viewSupplierDetails/{itemId}', [\App\Http\Controllers\ViewSupplierDetails::class, 'index'])->name('viewSupplierDetails');
Route::get('/downloadQuoteAdmin/{fileName}',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadQuoteAdmin'])->name('downloadQuoteAdmin');
Route::get('/downloadDisclosureAdmin/{fileName}',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadDisclosureAdmin'])->name('downloadDisclosureAdmin');




Route::get('/downloadTaxAdmin/{fileName}',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadTaxAdmin'])->name('downloadTaxAdmin');
Route::get('/downloadSignedEF58',[\App\Http\Controllers\AdminCaptureSupplierOderController::class, 'downloadSignedEF58'])->name('downloadSignedEF58');

      //For District Of Inbox table
      Route::get('/InboxSchoolDistrict', [\App\Http\Controllers\InboxSchoolDistict::class, 'index'])->name('InboxSchoolDistrict');
 


    Route::get('/search-manage-requests', [\App\Http\Controllers\Admin\Collection\ManageRequestController::class, 'search']);

    // Furniture Replacement - Collect Furniture routes
    Route::get('/furniture-replacement/collect/reference/{ref_no}', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'viewrequest']);
    Route::get('/furniture-replacement/accept/{id}', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'acceptrequest']);
    Route::post('/furniture-replacement/collect/store', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'store']);
    Route::get('/furniture-replacement/collect/printslip', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'annexurea']);

    // Furniture Replacement - Repair Furniture routes
    Route::get('/furniture-replacement/collect/printannexureb', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'annexureb']);
    Route::get('/furniture-replacement/collect/printemailannexurec', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'annexurecmail']);
    Route::post('/furniture-replacement/collect/disposalimages', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'uploadDisposalImages']);
    Route::post('/furniture-replacement/collect/uploadproof', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'uploadproof']);
    Route::post('/furniture-replacement/collect/submitrepair', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'submitrepair']);

    // Furniture Replacement - Deliver Furniture routes
    Route::get('/furniture-replacement/collect/printannexured', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'annexured']);
    Route::post('/furniture-replacement/collect/submitdelivery', [\App\Http\Controllers\Admin\Collection\CollectFurnitureController::class, 'submitdeliver']);

    // Search Module
    Route::get('/search/home', [\App\Http\Controllers\Admin\Search\SearchController::class, 'index']);
    Route::get('/search/reference', [\App\Http\Controllers\Admin\Search\SearchController::class, 'searchByReference']);
    Route::get('/search/date-range', [\App\Http\Controllers\Admin\Search\SearchController::class, 'searchByDateRange']);

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\Report\ReportController::class, 'reporthome']);

    Route::get('/reports/replenishment', [\App\Http\Controllers\Admin\Report\ReportController::class, 'replenishment']);

    Route::get('/reports/NOSTextbookReport', [\App\Http\Controllers\Admin\Report\ReportController::class, 'NOSTextbookReport']);

    Route::get('/reports/NOSStationeryReport', [\App\Http\Controllers\Admin\Report\ReportController::class, 'NOSStationeryReport']);


    
    Route::get('/reports/replenishment/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'replenishmentSearch']);
    Route::get('/reports/replenishment/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'replenishmentDownload']);
    
    Route::get('/reports/NOSTextbook/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'NOSTextbookDownload']);


    Route::get('/reports/disposal', [\App\Http\Controllers\Admin\Report\ReportController::class, 'disposal']);
    Route::get('/reports/disposal/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'disposalSearch']);
    Route::get('/reports/disposal/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'disposalDownload']);

    Route::get('/reports/stock', [\App\Http\Controllers\Admin\Report\ReportController::class, 'stock']);
    Route::get('/reports/stock/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'stockSearch']);
    Route::get('/reports/stock/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'stockDownload']);

    Route::get('/reports/furniture-count', [\App\Http\Controllers\Admin\Report\ReportController::class, 'furnitureCount']);
    Route::get('/reports/furniture-count/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'furnitureCountSearch']);
    Route::get('/reports/furniture-count/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'furnitureCountDownload']);

    Route::get('/reports/repairment', [\App\Http\Controllers\Admin\Report\ReportController::class, 'repairment']);
    Route::get('/reports/repairment/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'repairmentSearch']);
    Route::get('/reports/repairment/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'repairmentDownload']);

    Route::get('/reports/transaction-summary', [\App\Http\Controllers\Admin\Report\ReportController::class, 'transaction']);
    Route::get('/reports/transaction-summary/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'transactionSearch']);
    Route::get('/reports/transaction-summary/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'transactionDownload']);

    Route::get('/reports/transaction-status', [\App\Http\Controllers\Admin\Report\ReportController::class, 'transactionStatus']);
    Route::get('/reports/transaction-status/search', [\App\Http\Controllers\Admin\Report\ReportController::class, 'transactionStatusSearch']);
    Route::get('/reports/transaction-status/download', [\App\Http\Controllers\Admin\Report\ReportController::class, 'transactionStatusDownload']);

    //Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index']);
    Route::get('/dashboard/pending-collections', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'pendingCollectionsDownload']);
    Route::get('/dashboard/ytd-count', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'ytdStatusCountDownload']);
    Route::get('/dashboard/previous-count', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'previousYearCountDownload']);

    // School Maintenance - District routes
    Route::resource('schooldistricts', \App\Http\Controllers\Admin\School\SchoolDistrictController::class);
    Route::get('schooldistricts-search', [\App\Http\Controllers\Admin\School\SchoolDistrictController::class, 'search']);

    // School Maintenance - CMC routes
    Route::resource('schoolcmc', \App\Http\Controllers\Admin\School\CMCController::class);
    Route::get('schoolcmc-search', [\App\Http\Controllers\Admin\School\CMCController::class, 'search']);

    // School Maintenance - Circuit routes
    Route::resource('schoolcircuit', \App\Http\Controllers\Admin\School\CircuitController::class);
    Route::get('schoolcircuit-search', [\App\Http\Controllers\Admin\School\CircuitController::class, 'search']);

    // School Maintenance - Subplaces routes
    Route::resource('schoolsubplace', \App\Http\Controllers\Admin\School\SubPlaceController::class);
    Route::get('schoolsubplace-search', [\App\Http\Controllers\Admin\School\SubPlaceController::class, 'search']);

    // School Maintenance - School routes
    Route::resource('school', \App\Http\Controllers\Admin\School\SchoolController::class);
    Route::post('/getcmclist', [\App\Http\Controllers\Admin\School\SchoolController::class, 'getcmclist']);
    Route::post('/getcircuitlist', [\App\Http\Controllers\Admin\School\SchoolController::class, 'getcircuitlist']);
    Route::post('/getsubplacelist', [\App\Http\Controllers\Admin\School\SchoolController::class, 'getsubplacelist']);
    Route::get('school-search', [\App\Http\Controllers\Admin\School\SchoolController::class, 'search']);

    Route::get('/school-maintenance', [\App\Http\Controllers\Admin\School\SchoolController::class, 'schoolmaintenance'])->name('school-maintenance');

    // Stock Maintenance - Category routes
    Route::resource('stockcategories', \App\Http\Controllers\Admin\Stock\StockCategoryController::class);
    Route::get('stockcategories-search', [\App\Http\Controllers\Admin\Stock\StockCategoryController::class, 'search']);

    // Stock Maintenance - Items routes
    Route::resource('stockitems', \App\Http\Controllers\Admin\Stock\StockItemController::class);
    Route::get('stockitems-search', [\App\Http\Controllers\Admin\Stock\StockItemController::class, 'search']);

    Route::get('/stock-maintenance', [\App\Http\Controllers\Admin\Stock\StockItemController::class, 'stockmaintenance'])->name('stock-maintenance');

    Route::get('/getstockitems', [\App\Http\Controllers\Admin\Stock\StockItemController::class, 'getitems']);
});

Route::get("/excel/import", [ExcelSchoolController::class, 'AddressDetailsImport']);
Route::get("/excel/import/school-details", [ExcelSchoolController::class, 'SchoolDEtailsImport'])->name("school-details-import");
