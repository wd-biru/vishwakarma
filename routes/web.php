<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    if (Auth::guest()) {
        return view('auth.login');
    } else {
        $rolename = Auth::user()->user_type;
        //dd($rolename);
        switch ($rolename) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'portal':
                return redirect()->route('portal.dashboard');
                break;
            case 'company':
                return redirect()->route('company.dashboard');
                break;
            case 'employee':
                return redirect()->route('employee.dashboard');
                break;
            default:
                Session::flush();
                return redirect('/');
                break;
        }
    }
});

//Route::group(['middleware' => 'prevent-back-history'],function() {

Auth::routes();

//Route::resource('indentResorurce','IndentResourceController');
//
//Route::get('/getItems', 'IndentResourceController@getItemList')->name('getItemList');
//Route::get('/getOneItem', 'IndentResourceController@getOneItemList')->name('getOneItemList');


Route::group(['middleware' => ['auth', 'check_role']], function () {


    /***************** ADMIN MODULE *****************/
    Route::post('/passwordChange', 'HomeController@passwordChange')->name('login.passwordChange');
    Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {

        // admin/home
        Route::get('/Dashboard', 'DashboardAdmin@index')->name('admin.dashboard');
        Route::get('/Company-Management', 'DashboardAdmin@create')->name('master.comMgmt.index');
        Route::get('/Profile', 'DashboardAdmin@show')->name('admin.profile');
        Route::post('/Profile/Update', 'DashboardAdmin@update')->name('admin.profile.update');

        // admin/portals
        Route::group(['prefix' => 'portals', 'namespace' => 'portals'], function () {
            Route::get('/', 'PortalManagement@index')->name('portal');
            Route::get('/create', 'PortalManagement@create')->name('portalCreate');
            Route::get('/vendorGetStateCode', 'PortalManagement@vendorGetStateCode')->name('vendorGetStateCode');
            Route::post('/store', 'PortalManagement@store')->name('portalInfoStore');
            Route::get('/empShow/{id}', 'PortalManagement@empShow')->name('portalEmployeeShow');
            Route::get('/show/{id}', 'PortalManagement@show')->name('portalInfoShow');
            Route::post('/update', 'PortalManagement@update')->name('portalInfoUpdate');
            Route::get('/edit/{id}', 'PortalManagement@edit')->name('portalInfoEdit');
            Route::get('/destroy/{id}', 'PortalManagement@destroy')->name('portalDelete');
            Route::get('/portal_vendor_mapping', 'PortalManagement@portal_vendor_mapping')->name('portalVendorMapping');
            Route::get('/{id}/vendors', 'PortalManagement@Getvendoritem')->name('Getvendoritem');


            Route::post('/portalEmpStore/{id}', 'PortalManagement@EmpStore')->name('portalEmpStore');

            //select portal services
//            Route::get('/service', 'ServicesController@index')->name('portal.service');
//            Route::get('/servicecreate', 'ServicesController@create')->name('portal.service.create');

            //MENU PERMIOSION
            Route::get('/getMenu/{id}', 'MenuController@show')->name('portal.menu');
            Route::get('/store-menu', 'MenuController@store')->name('portal.menu.store');
        });


        // admin/master
        Route::group(['prefix' => 'master', 'namespace' => 'master'], function () {

            //admin/material mangement
            Route::group(['prefix' => 'matMgmt', 'namespace' => 'MatMgmt'], function () {
                Route::get('/', 'MaterialMangementController@index')->name('master.matMgmt');
                Route::get('/show', 'MaterialMangementController@show')->name('showmatMgmt');
                Route::post('/store', 'MaterialMangementController@store')->name('storematMgmt');
                Route::get('/{id}/delete', 'MaterialMangementController@destroy')->name('deleteMgmt');
                Route::post('/', 'MaterialMangementController@masterGroupUpdate')->name('masterGroupUpdate');
                Route::post('/{g_id}/addGroupItem', 'MaterialMangementController@addGroupItem')->name('addGroupItem');
                Route::get('/{id}/group', 'MaterialMangementController@Getgroupitem')->name('Getgroupitem');
                Route::get('/{id}/deleteGroupItem', 'MaterialMangementController@deleteGroupItem')->name('deleteGroupItem');
                Route::post('/updateGroupItem', 'MaterialMangementController@updateGroupItem')->name('updateGroupItem');
                Route::get('{id}/IsActive/', 'MaterialMangementController@GroupMaterialIsActive')->name('IsActive');
                Route::get('{id}/IsActiveItem/', 'MaterialMangementController@GroupMaterialIsActiveItem')->name('IsActiveItem');
            });

            Route::group(['namespace' => 'SrvcMgm'], function () {
                Route::resource('SrvcMgm', 'ServiceManagementController');
                Route::get('{id}/destroy/', 'ServiceManagementController@destroy')->name('SrvcMgm.destroy');
                Route::get('{id}/isActiveGroup/', 'ServiceManagementController@isActiveGroup')->name('isActiveGroup');
                Route::get('/{id}/group', 'ServiceManagementController@GetServiceItem')->name('GetServiceItem');
                Route::get('{id}/isActiveService/', 'ServiceManagementController@isActiveService')->name('isActiveService');
                Route::get('/{id}/deleteService', 'ServiceManagementController@deleteService')->name('deleteService');
                Route::put('/updateServiceGroupItem', 'ServiceManagementController@updateServiceGroupItem')->name('updateServiceGroupItem');
                Route::post('/', 'ServiceManagementController@masterServiceGroup')->name('masterServiceGroup');
                Route::post('/{id}/addServiceItem', 'ServiceManagementController@addServiceItem')->name('addServiceItem');

                //Service Listing Controller//
                Route::resource('SrvcList', 'ServiceUserController');
                Route::get('/moreinfo', 'ServiceUserController@moreInfo')->name('servicemoreinfo');
                Route::get('/projects', 'ServiceUserController@projectInfo')->name('projectmoreinfo');
                Route::get('/documents', 'ServiceUserController@documentInfo')->name('documentmoreinfo');
            });


            //master/department
            Route::group(['namespace' => 'department', 'prefix' => 'department'], function () {

                Route::get('/', 'DepartmentController@index')->name('department.master');
                Route::get('/checkUnique', 'DepartmentController@checkUnique')->name('checkUnique.department.master');
                Route::post('/store', 'DepartmentController@store')->name('department.master.store');

                Route::post('/update', 'DepartmentController@update')->name('department.master.update');
                Route::get('/show', 'DepartmentController@show')->name('department.master.show');
                Route::post('/destroy', 'DepartmentController@destroy')->name('delete.department');


                Route::post('/designationstore', 'DepartmentController@designationStore')->name('designation.master.store');
                Route::post('/designationupdate', 'DepartmentController@designationUpdate')->name('designation.master.update');
                Route::get('/checkUniquedesignation', 'DepartmentController@checkUniquedesignation')->name('checkUniquedesignation.department.master');
            });

        });

    });


    /***************** PMO MODULE *****************/
    Route::group(['namespace' => 'Projects'], function () {

        /************/
        Route::get('projects/{project}/delete', ['as' => 'projects.delete', 'uses' => 'ProjectsController@delete']);
        Route::patch('projects/{project}/status-update', ['as' => 'projects.status-update', 'uses' => 'ProjectsController@statusUpdate']);
        Route::resource('projects', 'ProjectsController');
        /*
         * Project Jobs Routes
         */

        Route::get('projects/{project}/jobs-export/{type?}', ['as' => 'projects.jobs-export', 'uses' => 'JobsController@jobsExport']);
        Route::get('projects/{project}/job-progress-export/{type?}', ['as' => 'projects.job-progress-export', 'uses' => 'JobsController@jobProgressExport']);
        Route::get('projects/{project}/jobs/create', ['as' => 'projects.jobs.create', 'uses' => 'JobsController@create']);
        Route::post('projects/{project}/jobs', ['as' => 'projects.jobs.store', 'uses' => 'JobsController@store']);
        Route::get('projects/{project}/jobs/add-from-other-project', ['as' => 'projects.jobs.add-from-other-project', 'uses' => 'JobsController@addFromOtherProject']);
        Route::post('projects/{project}/jobs/store-from-other-project', ['as' => 'projects.jobs.store-from-other-project', 'uses' => 'JobsController@storeFromOtherProject']);
        Route::get('projects/{project}/jobs', ['as' => 'projects.jobs.index', 'uses' => 'JobsController@index']);
        Route::post('projects/{project}/jobs-reorder', ['as' => 'projects.jobs-reorder', 'uses' => 'ProjectsController@jobsReorder']);


        /*******************************Project Estimation***********************/


        Route::get('projects/{project}/estimate', ['as' => 'projects.estimation.index', 'uses' => 'EstimateController@index']);
        Route::get('projects/{project}/store/create', ['as' => 'projects.store.create', 'uses' => 'StoreController@create']);

        Route::group(['prefix' => 'projects'], function () {

            Route::post('/getmatirialitem', 'EstimateController@Getmaterialitem')->name('estimate.getmatirialitem');
            Route::post('/indend', 'EstimateController@Indend')->name('estimate.indend');

            Route::get('/getmaterialitem', 'EstimateController@getmatrial')->name('getItemDataList');
            Route::post('/insertindent', 'EstimateController@insertindent')->name('estimate.Insertindent');
//            Route::post('/getindentdata', 'EstimateController@Getindentdata')->name('estimate.getindentdatas');

            Route::post('/downloadPDF', 'EstimateController@downloadPDF')->name('estimate.downloadPDF');


            /****Indent Controllers**/
//            Route::resource('/{project}/indentResorurce','IndentResourceController');
            Route::get('/{project}/indentResorurce', 'IndentResourceController@index')->name('indentResorurce.index');
            Route::post('/{project}/getItems', 'IndentResourceController@getItemList')->name('getItemList');
            Route::post('/{project}/deleteItem', 'IndentResourceController@deleteIndentItem')->name('indentResorurce.delete');
            Route::post('/{project}/geteditItems', 'IndentResourceController@getItemListIndent')->name('indentResorurce.chkItem');
            Route::get('projects/{project}/addindent', ['as' => 'indentResorurce.addindent', 'uses' => 'IndentResourceController@Addindent']);

            Route::get('projects/{project}/edit/{indent}', ['as' => 'indentResorurce.editIndent', 'uses' => 'IndentResourceController@edit']);
            Route::get('projects/{project}/delete/{item}', ['as' => 'indentResorurce.deleteIndent', 'uses' => 'IndentResourceController@delete']);
            Route::post('/{project}/getOneItem', 'IndentResourceController@getOneItemList')->name('getOneItemList');
            Route::post('/{project}/getindentList', 'IndentResourceController@Getindentdata')->name('indentResorurce.getindentdata');
            Route::post('/{project}/getindentPriceList', 'IndentResourceController@getindentPriceList')->name('getindentPriceList');
            Route::post('/{project}/storePurchase', 'IndentResourceController@storePurchase')->name('storePurchase');
            Route::post('generate-pdf', 'IndentResourceController@generatePDF')->name('indentResorurce.downloadPDF');
            Route::post('/{project}/getQuoteStore', 'IndentResourceController@getQuoteStore')->name('indentResorurce.getQuoteStore');

            Route::post('{project}/changeStatus/', 'IndentResourceController@changeStatus')->name('indent.workflow.change');
            Route::get('{project}/changeStatus/{indent}', 'IndentResourceController@changeStatus')->name('workflow.add');

            Route::post('/{project}/projectstore', 'IndentResourceController@store')->name('indentResorurce.store');
            Route::post('/{project}/projectupdate', 'IndentResourceController@updateIndent')->name('indentResorurce.update');
            Route::get('/{project}/storeInventory/{store}', 'StoreController@storeInventory')->name('storeInventory');
            Route::get('{project}/getItemsQuantity/{store}', 'StoreController@getItemsQuantity')->name('getItemsQuantity');
            Route::get('{project}/getCurrentItemsQuantity/{store}', 'StoreController@getCurrentItemsQuantity')->name('getCurrentItemsQuantity');
            // Route::get('{project}/import_excel/{store}', 'StoreController@indeximport')->name('indeximport');
            Route::post('{project}/import_excel/import/{store}', 'StoreController@import_excel')->name('initialStockImport');;
            Route::post('/{project}/Quantity/{store}', 'StoreController@storeQuantity')->name('storeQuantity');
            Route::get('/{project}/storeInword/{store}', 'StoreController@storeInword')->name('storeInword');
            Route::get('/{project}/outward-store/{store}', 'StoreController@storeoutwardstack')->name('storeoutwardstock');
            Route::get('/{project}/get-store/{store}', 'StoreController@getstore')->name('getstore');
            Route::get('/{project}/material-and-group-item/{store}', 'StoreController@getMaterialItemAndGroup')->name('getMaterialItemAndGroup');


            Route::get('/{project}/getItemsmaterial/{store}', 'StoreController@getItems')->name('getItems');
            Route::get('/{project}/getItemsmaterialforoutward/{store}', 'StoreController@getItemsforoutward')->name('getItemsmaterialforoutward');


            Route::get('/{project}/getItemsforstoretostore/{store}', 'StoreController@getItemsforstoretostore')->name('getItemsforstoretostore');


            Route::post('/{project}/getitemfromPriGodown/{store}', 'StoreController@getitemfromPriGodow')->name('getitemfromPriGodow');
            Route::post('/{project}/godowntransfer-store/{store}', 'StoreController@storeStore')->name('godowntransferstore');


            //shivam today
            Route::get('{project}/storeInventoryInvoiveCheck/{store}', 'StoreController@invoiveCheck')->name('storeInventoryInvoiveCheck');
            Route::post('/{project}/inword-store/{store}', 'StoreController@storeInwordStock')->name('storeInwordStock');
            Route::get('/{project}/updateinventry/{store}', 'StoreController@updateinventry')->name('updateinventry');
            Route::get('/{project}/currentItemStock/{store}', 'StoreController@currentItemStock')->name('currentItemStock');

            Route::get('/{project}/updateoutventry/{store}', 'StoreController@updateoutventry')->name('updateoutventry');

            Route::get('/{project}/updatestoretostorealter/{store}', 'StoreController@updatestoretostorealter')->name('updatestoretostorealter');


            Route::get('{project}/itemdeletelistinv/{store}', 'StoreController@Itemlistdel')->name('itemdeletelistinv');

            Route::get('{project}/storetostoreitemdel/{store}', 'StoreController@storetostoreitemdel')->name('storetostoreitemdel');


            Route::match(['get', 'post'], '{project}/getstoreitemlistinvalter/{store}', 'StoreController@getstoreitemlistinvalter')->name(
                'getstoreitemlistinvalter');

            Route::get('{project}/getstoreitemlistinv/{store}', 'StoreController@getstoreitemlistinv')->name('getstoreitemlistinv');
            Route::match(['get', 'post'], '{project}/viewandalteroutward/{store}', 'StoreController@viewandalteroutward')->name('viewandalteroutward');


            Route::get('/{project}/storeoutward/{store}', 'StoreController@storeoutward')->name('storeoutward');

            Route::get('/{project}/storetostore/{store}', 'StoreController@storetostore')->name('storetostore');
            Route::match(['get', 'post'], '/{project}/viewamdalterstoretransfer/{store}', 'StoreController@viewamdalterstoretransfer')->name('viewamdalterstoretransfer');

            Route::get('/{project}/getgodownitem/{store}', 'StoreController@getgodownItem')->name('getgodownItem');
            Route::get('{project}/chkitem-inprimary/{store}', 'StoreController@checkItemInPrimary')->name('checkItemInPrigodown');

//           /**************************Godown TranserController*********************/
//
//            Route::get('{project}/itemdeletelist/{store}', 'GodowntransferController@Itemlistdel')->name('godownItemdeletelist');
//            Route::get('getgodownitemlist', 'GodowntransferController@getgodownItemlist')->name('getgodownItemlist');
//            Route::get('godowntransfer', 'GodowntransferController@index')->name('godowntransfer');
//            Route::post('setsecondary', 'GodowntransferController@getsecondaryname')->name('setsecondary');
//
//
//            /**************************End Godown TranserController*********************/


            /*************************** Tower Module ****************************/

            Route::get('projects/{project}/Tower/create', ['as' => 'projects.Tower.create', 'uses' => 'TowerController@create']);
            Route::get('{project}/Tower', 'TowerController@index')->name('Tower.Index');
            Route::post('/projects/{project}/save', 'Towercontroller@store')->name('Tower.save');
            Route::post('/Tower/{project}/details', 'Towercontroller@getTowerDetails')->name('Tower.Details');
            Route::get('/Tower/{project}/DetailStore', 'Towercontroller@DetailStore')->name('Tower.DetailStore');


            /*************************** End Tower Module ****************************/

        });

        /*******************************Quality Check********************************/

        Route::resource('/projects/{project}/qualityCheck','QualityCheckController');
        Route::get('/projects/{project}/itemShowCheck/{challan_no}','QualityCheckController@itemShow')->name('qualityCheck.itemShow');

        /******************************End Q Check *********************************/



        Route::resource('/projects/{project}/allocation', 'AllocationResource');
        Route::get('/projects/{project}/allocation', 'AllocationResource@index')->name('allocation.index');
        Route::post('/projects/{project}/change_status', 'AllocationResource@change_status')->name('allocation.change_status');
        Route::post('projects/{project}/updateresourceallocation', 'AllocationResource@update')->name('allocationUpdate');
        Route::post('projects/{project}/store', 'AllocationResource@store')->name('allocation.store');
        Route::get('projects/{project}/destroy/{id}', 'AllocationResource@destroy')->name('allocationDelete');
        Route::post('/projects/{project}/save', 'storecontroller@store')->name('store.save');
        Route::post('/projects/{project}/update', 'storecontroller@storeUpdate')->name('store.update');
        Route::get('/projects/{project}/store', 'StoreController@index')->name('store.index');


        /*
         * Tasks Routes
         */
        Route::get('jobs/{job}/tasks/create', ['as' => 'tasks.create', 'uses' => 'TasksController@create']);
        Route::post('jobs/{job}/tasks', ['as' => 'tasks.store', 'uses' => 'TasksController@store']);
        Route::patch('tasks/{task}', ['as' => 'tasks.update', 'uses' => 'TasksController@update']);
        Route::delete('tasks/{task}', ['as' => 'tasks.destroy', 'uses' => 'TasksController@destroy']);

    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('jobs', ['as' => 'jobs.index', 'uses' => 'JobsController@index']);
        Route::get('jobs/{job}', ['as' => 'jobs.show', 'uses' => 'JobsController@show']);
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('jobs/{job}/edit', ['as' => 'jobs.edit', 'uses' => 'JobsController@edit']);
        Route::patch('jobs/{job}', ['as' => 'jobs.update', 'uses' => 'JobsController@update']);
        Route::get('jobs/{job}/delete', ['as' => 'jobs.delete', 'uses' => 'JobsController@delete']);
        Route::delete('jobs/{job}', ['as' => 'jobs.destroy', 'uses' => 'JobsController@destroy']);
        Route::post('jobs/{id}/tasks-reorder', ['as' => 'jobs.tasks-reorder', 'uses' => 'JobsController@tasksReorder']);
    });


    /***************** PORTAL MODULE *****************/
    Route::group(['namespace' => 'portal', 'prefix' => 'portal'], function () {

        // portal/home
        Route::get('/Dashboard', 'DashboardPortal@index')->name('portal.dashboard');
        Route::get('/Profile', 'DashboardPortal@show')->name('portal.profile');
        Route::get('/vendorGetCode', 'DashboardPortal@vendorGetCode')->name('vendorGetCode');
        Route::post('/Profile/Update', 'DashboardPortal@update')->name('portal.profile.update');

        //portal/config
        Route::get('outletconfig', 'OutletController@index')->name('outlet.config');

        // portal/company
        Route::group(['prefix' => 'company', 'namespace' => 'company'], function () {

            Route::get('/', 'CompanyManagementController@index')->name('company');
            Route::get('/getClientDataByStatus', 'CompanyManagementController@getClientDataByStatus')->name('getClientDataByStatus');
            Route::get('/create', 'CompanyManagementController@create')->name('companyCreate');
            Route::post('/store', 'CompanyManagementController@store')->name('companyStore');
            Route::get('/edit/{id}', 'CompanyManagementController@edit');
            Route::get('/show/{id}', 'CompanyManagementController@show')->name('companyShow');
            Route::post('/update/{id}', 'CompanyManagementController@update')->name('companyUpdate');
            Route::post('/update/', 'CompanyOtherInfoController@update')->name('companyOtherUpdate');


            Route::post('/feeUpdate/', 'CompanyFeesController@update')->name('companyFeesUpdate');
            Route::post('/auditStore/{id}', 'CompanyServiceAuditController@store')->name('companyAudit');
            Route::post('/auditEdit/', 'CompanyServiceAuditController@edit')->name('companyAuditEdit');
            Route::get('/auditUpdate/', 'CompanyServiceAuditController@index')->name('auditUpdate');
            Route::get('/formsUpdate/', 'CompanyServiceFormController@index')->name('formsUpdate');
            Route::post('/auditinfoupdate/', 'CompanyServiceAuditController@update')->name('companyAuditInfoUpdate');
            Route::post('/ServiceFormEdit/', 'CompanyServiceFormController@edit')->name('companyServiceFormEdit');
            Route::post('/ServiceFormUpdate/', 'CompanyServiceFormController@update')->name('companyServiceFormUpdate');
            Route::get('/getfile', 'CompanyServiceFormController@getFile')->name('getfile');
            Route::post('/ServiceAccounting/', 'CompanyServiceAccountingController@store')->name('companyServiceAccounting');

            Route::get('/formslist/{id}', 'CompanyServiceFormController@getClientFormsList')->name('formsList');
            Route::get('/auditinglist/{id}', 'CompanyServiceAuditController@getClientauditingList')->name('auditingList');
            Route::get('/accountingList/{id}', 'CompanyServiceAccountingController@getClientaccountingList')->name('accountingList');

            Route::get('/serviceForm/{id}', 'CompanyServiceFormController@formStore')->name('serviveFormAdd');
            Route::get('/clientServiceFormUpdate/', 'CompanyServiceFormController@formUpdate')->name('serviceFormUpdate');

            //form update
            Route::get('/formUpdate', 'CompanyServiceFormController@formUpdateData');
            Route::get('/checkUniqueUpdate', 'CompanyManagementController@checkUniqueUpdateValidation');

//            Route::get('/checkRegisterUniqueUpdate', 'CompanySecInfoController@checkRegisterUniqueValidation');


            Route::get('/addressList', 'CompanyAddressController@show')->name('getAddressList');
            Route::post('/addressStore', 'CompanyAddressController@store')->name('address.store');
            Route::get('/addressDelete/{id}', 'CompanyAddressController@destroy')->name('address.delete');
            Route::post('/addressUpdate', 'CompanyAddressController@update')->name('address.update');

            Route::group(['prefix' => 'employee', 'namespace' => 'Employee'], function () {
                Route::get('', 'EmployeeManagementController@index')->name('companyemployee');
                Route::get('/create', 'EmployeeManagementController@create')->name('companyemployeeCreate');
                Route::post('/store', 'EmployeeManagementController@store')->name('companyemployeeInfoStore');
                Route::post('/update', 'EmployeeManagementController@update')->name('companyemployeeInfoUpdate');
                Route::get('/edit/{id}', 'EmployeeManagementController@edit')->name('companyemployeeInfoEdit');
                Route::get('/destroy/{id}', 'EmployeeManagementController@destroy')->name('companyemployeeDelete');
                Route::get('/employee/json/{id}', 'EmployeeManagementController@getdesignationJSON');
                Route::get('/{id}/menus', 'EmployeeManagementController@modulesMenu')->name('employee.permission');
                Route::get('/menus', 'EmployeeManagementController@modulesMenuStore')->name('employee.permission.store');
                Route::get('/Clientmenus', 'EmployeeManagementController@modulesMenuStoreClient')->name('employee.client.permission.store');

                Route::get('/ClientAll', 'EmployeeManagementController@modulesMenuStoreClientAll')->name('employee.client.permission.storeAll');
                Route::get('/finddesig', 'EmployeeManagementController@findDesignationName')->name('findDesignationsData');

                Route::get('export', 'EmployeeManagementController@export')->name('export');
                Route::get('importExportView', 'EmployeeManagementController@importExportView');
                Route::post('import', 'EmployeeManagementController@import')->name('import');
            });

        });

        //portal leave
        Route::group(['prefix' => 'leave', 'namespace' => 'Leaves'], function () {
            Route::get('/leavetype', 'LeaveController@index')->name('employeeleavetype');
            Route::post('/storeleavetype', 'LeaveController@store')->name('employeeleavetype.store');
            Route::post('/updateleavetype', 'LeaveController@update')->name('employeeleavetype.update');
            Route::post('/deleteleavetype', 'LeaveController@destroy')->name('employeeleavetype.delete');
            Route::get('/leavestatus', 'LeaveController@leaveStatus')->name('employeeleavestatus');
            Route::get('/checkleave/{leave_type}/{no_of_leave}', 'LeaveController@checkleave')->name('employeecheckleave');

            Route::get('/checkleaves/{id}/{company_id}', 'LeaveController@checkleaves');
            Route::get('/check/{leavemaster}/{portal_id}', 'LeaveController@check');
        });

        //portal/documentManagemet
        Route::group(['prefix' => 'document', 'namespace' => 'document'], function () {
            Route::get('/', 'documentManagementController@index')->name('documentManagemet.index');
            Route::post('/document', 'documentManagementController@store')->name('documentManagemet.store');
            Route::get('/getShareList', 'documentManagementController@getShareList')->name('getShareList');
            Route::get('/getDocDetail', 'documentManagementController@getDocDetail')->name('getDocDetail');
            Route::get('/documentshow', 'documentManagementController@show')->name('documentManagemet.show');
            Route::get('/documentshare', 'documentManagementController@share')->name('documentManagemet.share');
            Route::post('/documentStatusupdate', 'documentManagementController@update')->name('documentManagemet.update');
            Route::get('/documentShareWithMe', 'documentManagementController@documentShareWithMe')->name('documentManagemet.documentShareWithMe');

//            Route::get('/student', 'AjaxdataController@index')->name('student.index');
//            Route::get('ajaxdata/getdata', 'AjaxdataController@getdata')->name('student.getdata');

        });

        //Portal/Time-keeping
        Route::group(['prefix' => 'time_keeping', 'namespace' => 'time_keeping'], function () {
            Route::get('/index', 'TimeSheetController@index')->name('timeSheet');
            Route::post('/store', 'TimeSheetController@store')->name('saveTimeSheet');
            Route::post('/search', 'TimeSheetController@show')->name('timeSheetShow');
            Route::post('/updateTimeSheet', 'TimeSheetController@update')->name('editTimeSheet');
            Route::get('/employee/Sheet', 'TimeSheetController@employeeIndex')->name('portal.employee.timeSheet');
        });


    });


    /***************** COMPANY MODULE *****************/

    Route::group(['namespace' => 'Vendor', 'prefix' => 'vendor'], function () {

        // company/home  
        route::get('/dashboard', 'DashboardVendor@index')->name('vendor.dashboard');
        Route::get('/Profile', 'DashboardVendor@show')->name('vendor.profile');
        Route::post('/Profile/Update', 'DashboardVendor@update')->name('vendor.profile.update');
        Route::group(['prefix' => 'VendorPrice'], function () {
            Route::get('/', 'VendorPriceController@index')->name('vendorPrice');
            Route::get('/vendorIndent', 'VendorPriceController@vedorIndent')->name('vedorIndent');
            Route::get('/{id}/IndentPrice', 'VendorPriceController@vendorIndentPrice')->name('vendorIndentPrice');
            Route::post('/getItems', 'VendorPriceController@getItemListPrice')->name('getItemListPrice');
            Route::get('/getEachVendorPrice', 'VendorPriceController@getEachVendorPrice')->name('getEachVendorPrice');
            Route::post('/', 'VendorPriceController@storeprice')->name('item.price.store');
            Route::post('/storeIndentyPrice', 'VendorPriceController@storeIndentyPrice')->name('storeIndentyPrice');
            Route::post('vendorgenerate-pdf', 'VendorPriceController@vendorgeneratePDF')->name('vendorgeneratePDF');
        });
    });


    /***************** EMPLOYEE MODULE *****************/
    Route::group(['namespace' => 'Employee', 'prefix' => 'employee'], function () {


        // employee/home
        Route::get('/Dashboard', 'DashboardEmployee@index')->name('employee.dashboard');
        Route::get('/Profile', 'DashboardEmployee@show')->name('employee.profile');
        Route::post('/Profile/Update/{id}', 'DashboardEmployee@update')->name('employee.profile.update');

        //employee/social
        Route::group(['prefix' => 'otherDetails', 'namespace' => 'Others'], function () {
            Route::post('/', 'EmployeeOtherDetails@store')->name('employeeOther.store');
            // Route::get('/{portal_id}/{employee_id}/show','EmployeeOtherDetails@show')->name('employeeOther.show');
            Route::post('/bankDetails', 'EmployeeBankDetails@store')->name('employeeBankDetail.store');
            Route::get('/{portal}/{employee}/show', 'EmployeeBankDetails@show')->name('employeeBankDetail.show');
            Route::get('/employee/json/{id}', 'EmployeeOtherDetails@getdesignationJSON');
        });

        // employee docs
        Route::group(['prefix' => 'document', 'namespace' => 'Document'], function () {

            Route::get('/', 'EmployeeDocumentsController@index')->name('employeedocument.index');
            Route::post('/', 'EmployeeDocumentsController@store')->name('employeedocument.store');
            Route::get('/getShareList', 'EmployeeDocumentsController@getShareList')->name('getShareListEmp');
            Route::get('/getDocDetail', 'EmployeeDocumentsController@getDocDetail')->name('getDocDetailEmp');
            Route::get('/show', 'EmployeeDocumentsController@show')->name('employeedocument.show');
            Route::get('/share', 'EmployeeDocumentsController@share')->name('employeedocument.share');
            Route::post('/Statusupdate', 'EmployeeDocumentsController@update')->name('employeedocument.update');
            Route::get('/ShareWithMe', 'EmployeeDocumentsController@documentShareWithMe')->name('employeedocument.documentShareWithMe');
        });

        //LEAVES
        Route::group(['prefix' => 'leave', 'namespace' => 'Leave'], function () {
            Route::get('/applyleave', 'EmployeeLeaveController@index')->name('employee.applyleave');
            Route::get('/leaveRequest', 'EmployeeLeaveController@leaveRequest')->name('employee.leave.request');
            Route::post('/leaveRequestStore', 'EmployeeLeaveController@leaveRequestStore')->name('employee.leave.request.store');
            Route::get('/myLeave', 'EmployeeLeaveController@myLeave')->name('employee.leave.myLeave');
            Route::post('/applyleaves', 'EmployeeLeaveController@store')->name('employee.applyleaves.store');
        });

        Route::group(['prefix' => 'timeSheet', 'namespace' => 'TimeSheet'], function () {
            Route::get('/', 'TimeSheetController@index')->name('employee.timeSheet');
            Route::post('/store', 'TimeSheetController@store')->name('employee.timeSheet.store');
            Route::post('/update', 'TimeSheetController@update')->name('employee.editTimeSheet');
        });

        Route::group(['prefix' => 'Attendence', 'namespace' => 'Attendence'], function () {
            Route::group(['prefix' => 'Office'], function () {
                Route::get('/', 'OfficeAttendenceController@index')->name('attendence-office');

            });

            Route::group(['prefix' => 'Site'], function () {
                Route::get('/', 'SiteAttendenceController@index')->name('attendence-site');
                Route::get('/approvedAttendence', 'SiteAttendenceController@approvedAttendence')->name('approvedAttendence');
            });
        });

    });


});


/****************************Config admin/portal **************************/

Route::group(['middleware' => ['auth', 'Config']], function () {
    Route::group(['prefix' => 'Config', 'namespace' => 'Config'], function () {
        Route::get('/Configuration', 'ConfigController@index')->name('admin.config');
        Route::post('/configstrore', 'ConfigController@store')->name('admin.config.store');
        Route::get('/configedit/{id}', 'ConfigController@edit')->name('config.edit');
        Route::post('/configupdate/', 'ConfigController@Update')->name('config.update');
        Route::get('/configportal/', 'ConfigController@ConfigPortal')->name('Config.portal');
        Route::get('/ConfigPortalWorkFlow/', 'ConfigController@ConfigPortalWorkFlow')->name('Config.portal.workFlow');
        Route::get('/stepprocess/', 'ConfigController@StepProcess')->name('Config.StepProcess');
        Route::post('/getdeptemployee/', 'ConfigController@GetDeptEmployee')->name('Config.GetDeptEmployee');
        Route::post('/stepprocessstore/', 'ConfigController@StepProcessStore')->name('Config.StepProcessStore');
        Route::post('/empstore/', 'ConfigController@Empstore')->name('Config.empstore');

        Route::group(['prefix' => 'workFlow'], function () {
            Route::post('/Add/{id?}', 'ConfigController@workflowAdd')->name('workflow.add');
            Route::get('/Edit/{id?}', 'ConfigController@workflowEdit')->name('workflow.edit');
            Route::post('/Update/{id?}', 'ConfigController@workflowUpdate')->name('workflow.update');

        });

    });


    /**************************** master vendor Registration  **************************/


    Route::group(['prefix' => 'VendorRegistration', 'namespace' => 'VendorRegistration'], function () {
        Route::get('/', 'VendorManagementController@index')->name('master.vendorReg');
        Route::get('/create', 'VendorManagementController@create')->name('vendorCreate');
        Route::post('/GetCity', 'VendorManagementController@GetCity')->name('vendorGetCity');
        Route::post('/vendorGetLatLong', 'VendorManagementController@vendorGetLatLong')->name('vendorGetLatLong');
        Route::post('/vendore_store', 'VendorManagementController@store')->name('vendorStore');
        Route::post('/update', 'VendorManagementController@update')->name('vendorUpdate');
        Route::get('/viewPrice', 'VendorManagementController@viewPrice')->name('viewPrice');
        Route::post('/vendorListPrice', 'VendorManagementController@vendorListPrice')->name('vendorListPrice');
        Route::get('/edit/{id}', 'VendorManagementController@edit')->name('vendorEdit');
        Route::get('/destroy/{id}', 'VendorManagementController@destroy')->name('vendorDelete');
        Route::post('/portal_vendor_mapping', 'VendorManagementController@portal_vendor_mapping')->name('vendorportalStore');

    });


    /****************************End  master vendor Registration  **************************/


});

/**************************** End Config admin/portal **************************/


/****************************Reports **************************/


Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'Reports', 'namespace' => 'Reports'], function () {
        Route::get('/', 'ReportsController@index')->name('Reports.index');
        Route::get('/getStore', 'ReportsController@getStore')->name('Reports.getStore');
        Route::post('/getReport', 'ReportsController@getReport')->name('Reports.getReport');
        Route::post('/getitemtran', 'ReportsController@getitemtransaction')->name('Reports.getitemtransaction');

    });
});

/***************** END Reports ****************/


/***************** Purchase order MODULE *****************/

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'Purchase', 'namespace' => 'Purchase'], function () {
        Route::get('/', 'PurchaseOrderController@index')->name('PurchaseOrder.index');
        Route::post('/getPurchaseData', 'PurchaseOrderController@getPurchaseData')->name('PurchaseOrder.getPurchaseData');
        Route::post('/getPurchaseDataNew', 'PurchaseOrderController@getPurchaseDataNew')->name('PurchaseOrder.getPurchaseDataNew');
        Route::post('/getChallanQuantity', 'PurchaseOrderController@getChallanQuantity')->name('PurchaseOrder.getChallanQuantity');
        Route::post('/getChallanDataItems', 'PurchaseOrderController@getChallanData')->name('getChallanData');
        Route::post('/getPurchaseItem', 'PurchaseOrderController@getPurchaseItem')->name('getPurchaseItem');
        Route::post('/ChallanItemGet', 'PurchaseOrderController@ChallanItemGet')->name('ChallanItemGet');
        Route::get('/getChallanindex', 'PurchaseOrderController@getChallanindex')->name('getChallanindex');
        Route::post('/vendorChallan', 'PurchaseOrderController@vendorChallan')->name('vendorChallan');
         Route::post('/vendorBill', 'PurchaseOrderController@vendorBill')->name('vendorBill');

        Route::get('/getChallanBased', 'PurchaseOrderController@getOrderBasedChallan')->name('getChallanBased');
        // Route::get('/ChallanDataFetch', 'PurchaseOrderController@getOrderBasedChallan')->name('ChallanDataFetch');
        
        

        Route::match(['get', 'post'], '/ChallanViewAndDownloadPDF', 'PurchaseOrderController@ChallanViewAndDownloadPDF')->name('ChallanViewAndDownloadPDF');
        Route::match(['get', 'post'], '/ChallanOrderNumber', 'PurchaseOrderController@ChallanOrderNumber')->name('ChallanOrderNumber');
        Route::match(['get', 'post'], '/ViewAndDownloadPDF', 'PurchaseOrderController@ViewAndDownloadPDF')->name('PurchaseOrder.ViewAndDownloadPDF');



    });
});

/***************** END Purchase order ****************/


/***************** Material Recipt MODULE *****************/

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'MaterialRecipt', 'namespace' => 'MaterialRecipt'], function () {
        Route::get('/', 'MaterialReciptController@index')->name('MaterialRecipt.index');
        Route::get('/getStore', 'MaterialReciptController@getStore')->name('MaterialRecipt.getStore');
        Route::get('/getvendor', 'MaterialReciptController@getvendor')->name('MaterialRecipt.getvendor');
        Route::get('/getChallan', 'MaterialReciptController@getChallan')->name('MaterialRecipt.getChallan');
        Route::post('/getChallanItem', 'MaterialReciptController@getChallanItem')->name('MaterialRecipt.getChallanItem');
        Route::post('/StoreToInward', 'MaterialReciptController@StoreToInward')->name('MaterialRecipt.StoreToInward');
        Route::get('/ReciptView', 'MaterialReciptController@ReciptView')->name('MaterialRecipt.ReciptView');
        Route::get('/MaterialRecieptData', 'MaterialReciptController@MaterialRecieptData')->name('MaterialRecipt.MaterialRecieptData');
        Route::post('/MaterialRecieptItem', 'MaterialReciptController@getMaterialRecieptItem')->name('MaterialRecipt.getMaterialRecieptItem');
        Route::post('/DownloadMaterialReciept', 'MaterialReciptController@DownloadMaterialReciept')->name('MaterialRecipt.DownloadMaterialReciept');


    });
});

/***************** Material Recipt end ****************/




         Route::get('/activity', 'ActivityGroups\ActivityGroupController@index');
         Route::post('/activityStore', 'ActivityGroups\ActivityGroupController@Store');
         Route::get('/activityShow', 'ActivityGroups\ActivityGroupController@activityShow');
         Route::get('/editActivity/{id}', 'ActivityGroups\ActivityGroupController@editActivity');
         Route::get('/deleteActivity/{id}', 'ActivityGroups\ActivityGroupController@deleteActivity');
         Route::post('/updateActivityGroup', 'ActivityGroups\ActivityGroupController@updateActivityGroup');



         Route::get('/subactivityworks', 'ActivityGroups\SubWorksController@index');
         Route::post('/subactivityworksStore', 'ActivityGroups\SubWorksController@subactivityworksStore');
         Route::get('/subactivityworksShow', 'ActivityGroups\SubWorksController@subactivityworksShow');
         Route::get('/subactivityworksEdit/{id}', 'ActivityGroups\SubWorksController@subactivityworksEdit');
         Route::get('/subactivityworksDelete/{id}', 'ActivityGroups\SubWorksController@subactivityworksDelete');
         Route::post('/subactivityworksUpdate', 'ActivityGroups\SubWorksController@subactivityworksUpdate');


         Route::get('/manPower', 'ActivityGroups\ManPowerController@index');
         Route::post('/manPowerStore', 'ActivityGroups\ManPowerController@manPowerStore');
         Route::get('/manPowerShow', 'ActivityGroups\ManPowerController@manPowerShow');
         Route::get('/manPowerEdit/{id}', 'ActivityGroups\ManPowerController@manPowerEdit');
         Route::get('/manPowerDelete/{id}', 'ActivityGroups\ManPowerController@manPowerDelete');
         Route::post('/manPowerUpdate', 'ActivityGroups\ManPowerController@manPowerUpdate');


         Route::get('/microactivityworks', 'ActivityGroups\MicroWorksController@index');
         Route::post('/microactivityworksStore', 'ActivityGroups\MicroWorksController@microactivityworksStore');
         Route::get('/microactivityworksShow', 'ActivityGroups\MicroWorksController@microactivityworksShow');
         Route::get('/microactivityworksEdit/{id}', 'ActivityGroups\MicroWorksController@microactivityworksEdit');
         Route::get('/microactivityworksDelete/{id}', 'ActivityGroups\MicroWorksController@microactivityworksDelete');
         Route::post('/microactivityworksUpdate', 'ActivityGroups\MicroWorksController@microactivityworksUpdate');

         Route::get('/subactivityworksList','ActivityGroups\MicroWorksController@subactivityworksList');


       







