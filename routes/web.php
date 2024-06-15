<?php

use App\Http\Livewire\Batch\BatchCreate;
use App\Http\Livewire\Batch\BatchDashboard;
use App\Http\Livewire\Batch\BatchImport;
use App\Http\Livewire\Batch\BatchUpdate;
use App\Http\Livewire\Customer\CustomerCreate;
use App\Http\Livewire\Customer\CustomerDashboard;
use App\Http\Livewire\Customer\CustomerUpdate;
use App\Http\Livewire\CustomerType\CustomerTypeCreate;
use App\Http\Livewire\CustomerType\CustomerTypeDashboard;
use App\Http\Livewire\CustomerType\CustomerTypeUpdate;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\Employee\EmployeeCreate;
use App\Http\Livewire\Employee\EmployeeDashboard;
use App\Http\Livewire\Employee\EmployeeUpdate;
use App\Http\Livewire\Expense\ExpenseCreate;
use App\Http\Livewire\Expense\ExpenseDashboard;
use App\Http\Livewire\Expense\ExpenseUpdate;
use App\Http\Livewire\ExpenseType\ExpenseTypeCreate;
use App\Http\Livewire\ExpenseType\ExpenseTypeDashboard;
use App\Http\Livewire\ExpenseType\ExpenseTypeUpdate;
use App\Http\Livewire\Gender\GenderCreate;
use App\Http\Livewire\Gender\GenderDashboard;
use App\Http\Livewire\Gender\GenderUpdate;
use App\Http\Livewire\IdentityDocumentType\IdentityDocumentTypeCreate;
use App\Http\Livewire\IdentityDocumentType\IdentityDocumentTypeDashboard;
use App\Http\Livewire\IdentityDocumentType\IdentityDocumentTypeUpdate;
use App\Http\Livewire\Industry\IndustryCreate;
use App\Http\Livewire\Industry\IndustryDashboard;
use App\Http\Livewire\Industry\IndustryUpdate;
use App\Http\Livewire\Payment\PaymentCreate;
use App\Http\Livewire\Payment\PaymentDashboard;
use App\Http\Livewire\Payment\PaymentUpdate;
use App\Http\Livewire\Product\ProductCreate;
use App\Http\Livewire\Product\ProductDashboard;
use App\Http\Livewire\Product\ProductImport;
use App\Http\Livewire\Product\ProductUpdate;
use App\Http\Livewire\ProductCategory\ProductCategoryCreate;
use App\Http\Livewire\ProductCategory\ProductCategoryDashboard;
use App\Http\Livewire\ProductCategory\ProductCategoryImport;
use App\Http\Livewire\ProductCategory\ProductCategoryUpdate;
use App\Http\Livewire\ProductPresentation\ProductPresentationCreate;
use App\Http\Livewire\ProductPresentation\ProductPresentationDashboard;
use App\Http\Livewire\ProductPresentation\ProductPresentationImport;
use App\Http\Livewire\ProductPresentation\ProductPresentationUpdate;
use App\Http\Livewire\ReportProduct\ReportProductDashboard;
use App\Http\Livewire\ServiceOrder\ServiceOrderCreate;
use App\Http\Livewire\ServiceOrder\ServiceOrderDashboard;
use App\Http\Livewire\ServiceOrder\ServiceOrderInformation;
use App\Http\Livewire\ServiceOrder\ServiceOrderPrint;
use App\Http\Livewire\ServiceOrder\ServiceOrderUpdate;
use App\Http\Livewire\SaleCancelled\SaleCancelledDashboard;
use App\Http\Livewire\SaleExpense\SaleExpenseDashboard;
use App\Http\Livewire\Service\ServiceCreate;
use App\Http\Livewire\Service\ServiceDashboard;
use App\Http\Livewire\Service\ServiceUpdate;
use App\Http\Livewire\ExtraItem\ExtraItemCreate;
use App\Http\Livewire\ExtraItem\ExtraItemDashboard;
use App\Http\Livewire\ExtraItem\ExtraItemUpdate;
use App\Http\Livewire\ServiceOrder\ServiceOrderDashboardCompleted;
use App\Http\Livewire\Setting\UpdateSetting;
use App\Http\Livewire\Supplier\SupplierCreate;
use App\Http\Livewire\Supplier\SupplierDashboard;
use App\Http\Livewire\Supplier\SupplierUpdate;
use App\Http\Livewire\User\UserCreate;
use App\Http\Livewire\User\UserDashboard;
use App\Http\Livewire\User\UserUpdate;
use App\Http\Livewire\Warehouse\WarehouseCreate;
use App\Http\Livewire\Warehouse\WarehouseDashboard;
use App\Http\Livewire\Warehouse\WarehouseUpdate;
use App\Models\ExtraItem;
use Illuminate\Support\Facades\Route;


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
    return redirect()->route('login');
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    /*     Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); */

    Route::get('/dashboard', Dashboard::class, function () {
        return view('livewire.dashboard.dashboard');
    })->name('dashboard')->middleware('auth', 'role:admin|sales');

    ///superadmin
    Route::get('setting-update/{slug}', UpdateSetting::class)->name('setting.update')->middleware('auth', 'role:admin');
    //Admin User

    Route::get('product-category', ProductCategoryDashboard::class)->name('product-category.dashboard')->middleware('auth', 'role:admin');
    Route::get('product-category-create', ProductCategoryCreate::class)->name('product-category.create')->middleware('auth', 'role:admin');
    Route::get('product-category-update/{slug}', ProductCategoryUpdate::class)->name('product-category.update')->middleware('auth', 'role:admin');
    Route::get('product-category-import', ProductCategoryImport::class)->name('product-category.import')->middleware('auth', 'role:admin');

    Route::get('supplier', SupplierDashboard::class)->name('supplier.dashboard')->middleware('auth', 'role:admin');
    Route::get('supplier-create', SupplierCreate::class)->name('supplier.create')->middleware('auth', 'role:admin');
    Route::get('supplier-update/{slug}', SupplierUpdate::class)->name('supplier.update')->middleware('auth', 'role:admin');

    Route::get('industry', IndustryDashboard::class)->name('industry.dashboard')->middleware('auth', 'role:admin');
    Route::get('industry-create', IndustryCreate::class)->name('industry.create')->middleware('auth', 'role:admin');
    Route::get('industry-update/{slug}', IndustryUpdate::class)->name('industry.update')->middleware('auth', 'role:admin');

    Route::get('warehouse', WarehouseDashboard::class)->name('warehouse.dashboard')->middleware('auth', 'role:admin');
    Route::get('warehouse-create', WarehouseCreate::class)->name('warehouse.create')->middleware('auth', 'role:admin');
    Route::get('warehouse-update/{slug}', WarehouseUpdate::class)->name('warehouse.update')->middleware('auth', 'role:admin');

    Route::get('batch', BatchDashboard::class)->name('batch.dashboard')->middleware('auth', 'role:admin');
    Route::get('batch-create', BatchCreate::class)->name('batch.create')->middleware('auth', 'role:admin');
    Route::get('batch-update/{slug}', BatchUpdate::class)->name('batch.update')->middleware('auth', 'role:admin');
    Route::get('batch-import', BatchImport::class)->name('batch.import')->middleware('auth', 'role:admin');

    Route::get('user', UserDashboard::class)->name('user.dashboard')->middleware('auth', 'role:admin');
    Route::get('user-create', UserCreate::class)->name('user.create')->middleware('auth', 'role:admin');
    Route::get('user-update/{slug}', UserUpdate::class)->name('user.update')->middleware('auth', 'role:admin');

    //Admin ServiceOrder
    Route::get('service-order', ServiceOrderDashboard::class)->name('service-order.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('service-order-create', ServiceOrderCreate::class)->name('service-order.create')->middleware('auth', 'role:admin|sales');
    Route::get('service-order-update/{slug}', ServiceOrderUpdate::class)->name('service-order.update')->middleware('auth', 'role:admin|sales');
    Route::get('service-order-information/{slug}', ServiceOrderInformation::class)->name('service-order.information')->middleware('auth', 'role:admin|sales');
    Route::get('service-order-print/{slug}', ServiceOrderPrint::class)->name('service-order.print')->middleware('auth', 'role:admin|sales');
    Route::get('service-order-cancelled', SaleCancelledDashboard::class)->name('service-order-cancelled.dashboard')->middleware('auth', 'role:admin');
    Route::get('service-order-completed', ServiceOrderDashboardCompleted::class)->name('service-order-completed.dashboard')->middleware('auth', 'role:admin|sales');

    //Admin Payment
    Route::get('payment/{slug}', PaymentDashboard::class)->name('payment.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('payment-create/{slug}', PaymentCreate::class)->name('payment.create')->middleware('auth', 'role:admin|sales');
    Route::get('payment-update/{slug}', PaymentUpdate::class)->name('payment.update')->middleware('auth', 'role:admin|sales');

    //Admin IdentityDocumentType
    Route::get('indentity-document-type', IdentityDocumentTypeDashboard::class)->name('identity-document-type.dashboard')->middleware('auth', 'role:admin');
    Route::get('indentity-document-type-create', IdentityDocumentTypeCreate::class)->name('identity-document-type.create')->middleware('auth', 'role:admin');
    Route::get('indentity-document-type-update/{slug}', IdentityDocumentTypeUpdate::class)->name('identity-document-type.update')->middleware('auth', 'role:admin');

    //Admin customer
    Route::get('customer', CustomerDashboard::class)->name('customer.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('customer-create', CustomerCreate::class)->name('customer.create')->middleware('auth', 'role:admin|sales');
    Route::get('customer-update/{slug}', CustomerUpdate::class)->name('customer.update')->middleware('auth', 'role:admin|sales');


    //Admin employee
    Route::get('employee', EmployeeDashboard::class)->name('employee.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('employee-create', EmployeeCreate::class)->name('employee.create')->middleware('auth', 'role:admin|sales');
    Route::get('employee-update/{slug}', EmployeeUpdate::class)->name('employee.update')->middleware('auth', 'role:admin|sales');

    //Admin Gender
    Route::get('gender', GenderDashboard::class)->name('gender.dashboard')->middleware('auth', 'role:admin');
    Route::get('gender-create', GenderCreate::class)->name('gender.create')->middleware('auth', 'role:admin');
    Route::get('gender-update/{slug}', GenderUpdate::class)->name('gender.update')->middleware('auth', 'role:admin');

    //Admin customertype
    Route::get('customer-type', CustomerTypeDashboard::class)->name('customer-type.dashboard')->middleware('auth', 'role:admin');
    Route::get('customer-type-create', CustomerTypeCreate::class)->name('customer-type.create')->middleware('auth', 'role:admin');
    Route::get('customer-type-update/{slug}', CustomerTypeUpdate::class)->name('customer-type.update')->middleware('auth', 'role:admin');

    //product
    Route::get('product', ProductDashboard::class)->name('product.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('product-create', ProductCreate::class)->name('product.create')->middleware('auth', 'role:admin|sales');
    Route::get('product-update/{slug}', ProductUpdate::class)->name('product.update')->middleware('auth', 'role:admin|sales');
    Route::get('product-import', ProductImport::class)->name('product.import')->middleware('auth', 'role:admin|sales');

    //service
    Route::get('service', ServiceDashboard::class)->name('service.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('service-create', ServiceCreate::class)->name('service.create')->middleware('auth', 'role:admin|sales');
    Route::get('service-update/{slug}', ServiceUpdate::class)->name('service.update')->middleware('auth', 'role:admin|sales');

    //extra-item
    Route::get('extra-item', ExtraItemDashboard::class)->name('extra-item.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('extra-item-create', ExtraItemCreate::class)->name('extra-item.create')->middleware('auth', 'role:admin|sales');
    Route::get('extra-item-update/{slug}', ExtraItemUpdate::class)->name('extra-item.update')->middleware('auth', 'role:admin|sales');


    //Admin presentation type
    Route::get('product-presentation', ProductPresentationDashboard::class)->name('product-presentation.dashboard')->middleware('auth', 'role:admin');
    Route::get('product-presentation-create', ProductPresentationCreate::class)->name('product-presentation.create')->middleware('auth', 'role:admin');
    Route::get('product-presentation-update/{slug}', ProductPresentationUpdate::class)->name('product-presentation.update')->middleware('auth', 'role:admin');
    Route::get('product-presentation-import', ProductPresentationImport::class)->name('product-presentation.import')->middleware('auth', 'role:admin');

    //expense type
    Route::get('expense-type', ExpenseTypeDashboard::class)->name('expense-type.dashboard')->middleware('auth', 'role:admin');
    Route::get('expense-type-create', ExpenseTypeCreate::class)->name('expense-type.create')->middleware('auth', 'role:admin');
    Route::get('expense-type-update/{slug}', ExpenseTypeUpdate::class)->name('expense-type.update')->middleware('auth', 'role:admin');

    //expense
    Route::get('expense', ExpenseDashboard::class)->name('expense.dashboard')->middleware('auth', 'role:admin|sales');
    Route::get('expense-create', ExpenseCreate::class)->name('expense.create')->middleware('auth', 'role:admin|sales');
    Route::get('expense-update/{slug}', ExpenseUpdate::class)->name('expense.update')->middleware('auth', 'role:admin|sales');

    //service-order-expense
    Route::get('service-order-expense', SaleExpenseDashboard::class)->name('service-order-expense.dashboard')->middleware('auth', 'role:admin');
    //service_order-expense
    Route::get('report-product', ReportProductDashboard::class)->name('report-product.dashboard')->middleware('auth', 'role:admin');
});
