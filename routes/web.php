<?php

use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client as Client;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceTemplateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PaymentQrCodeController;
use App\Http\Controllers\Auth\ClientNewPasswordController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

Route::middleware(['xss'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return Redirect::to(getDashboardURL());
            }

            return Redirect::to(getClientDashboardURL());
        }

        return redirect(route('login'));
    });

    // client reset password routes
    Route::get('/client-onboard/{id}', [ClientNewPasswordController::class, 'create'])->name('client.password.reset')->middleware('setLanguageFront');
    Route::post('/client-reset-password', [ClientNewPasswordController::class, 'store'])->name('client.password.update')->middleware('setLanguageFront');
    // client reset password routes end

    Route::post('update-language', [UserController::class, 'updateLanguage'])->name('change-language');
    //Notification routes
    Route::get(
        '/notification/{notification}/read',
        [NotificationController::class, 'readNotification']
    )->name('read.notification');
    Route::post(
        '/read-all-notification',
        [NotificationController::class, 'readAllNotification']
    )->name('read.all.notification');
    //update darkMode Field
    Route::get('update-dark-mode', [UserController::class, 'updateDarkMode'])->name('update-dark-mode');

    Route::get('invoice/{invoiceId}', [InvoiceController::class, 'showPublicInvoice'])->name('invoice-show-url');
    Route::get('quote/{quoteId}', [QuoteController::class, 'showPublicQuote'])->name('quote-show-url');
    Route::get(
        'invoice/{invoiceId}/payment',
        [InvoiceController::class, 'showPublicPayment']
    )->name('invoices.public-payment');
    Route::get(
        'invoice-pdf/{invoice}',
        [InvoiceController::class, 'getPublicInvoicePdf']
    )->name('public-view-invoice.pdf');
    Route::get(
        'quote-pdf/{quote}',
        [QuoteController::class, 'getPublicQuotePdf']
    )->name('public-view-quote.pdf');
});

Route::prefix('admin')->middleware(['auth', 'xss', 'role:admin'])->group(function () {
    // View logs
    Route::redirect('logs', 'log-viewer');

    Route::get('generate-recurring-invoice', function () {
        Artisan::call('in:create-recurring-invoice');
    });

    // Admin dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('payment-overview', [DashboardController::class, 'paymentOverview'])->name('payment-overview');
    Route::get('invoices-overview', [DashboardController::class, 'invoiceOverview'])->name('invoices-overview');
    Route::get(
        'yearly-income-chart',
        [DashboardController::class, 'getYearlyIncomeChartData']
    )->name('yearly-income-chart');

    // User route
    Route::resource('users', UserController::class);

    // Client route
    Route::resource('clients', ClientController::class);
    Route::get('states-list', [ClientController::class, 'getStates'])->name('states-list');
    Route::get('cities-list', [ClientController::class, 'getCities'])->name('cities-list');

    //Category Route
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'category.index',
        'create' => 'category.create',
        'show' => 'category.show',
        'store' => 'category.store',
        'edit' => 'category.edit',
        'update' => 'category.update',
        'destroy' => 'category.destroy',
    ]);

    //Product Route
    Route::resource('products', ProductController::class);

    //Invoice
    Route::resource('invoices', InvoiceController::class);
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/{invoice}/pdf', [InvoiceController::class, 'convertToPdf'])->name('pdf');
        Route::get('/{productId}/product', [InvoiceController::class, 'getProduct'])->name('get-product');
        Route::get('/{currencyId}/currency', [InvoiceController::class, 'getInvoiceCurrency'])->name('get-currency');
        Route::post(
            '/turn-off-recurring/{invoice}',
            [InvoiceController::class, 'updateRecurring']
        )->name('update-recurring');
    });
    Route::post(
        'change-invoice-status/{invoice}/{status}',
        [InvoiceController::class, 'updateInvoiceStatus']
    )->name('send-invoice');
    Route::post(
        'invoice-payment-reminder/{invoiceId}',
        [InvoiceController::class, 'invoicePaymentReminder']
    )->name('invoice.payment-reminder');

    //Quote
    Route::resource('quotes', QuoteController::class);
    Route::get('quotes/{quote}/pdf', [QuoteController::class, 'convertToPdf'])->name('quotes.pdf');
    Route::get('convert-to-invoice', [QuoteController::class, 'convertToInvoice'])->name('quotes.convert-to-invoice');

    //Tax
    Route::resource('taxes', TaxController::class);
    Route::post('taxes/{tax}/default-status', [TaxController::class, 'defaultStatus'])->name('taxes.default-status');

    //Payment Qr-Codes
    Route::resource('payment-qr-codes', PaymentQrCodeController::class);
    Route::post('payment-qr-codes/{paymentQrCode}', [PaymentQrCodeController::class, 'update'])->name('payment-update');
    Route::post('payment-qr-codes/{paymentQrCode}/default-status', [PaymentQrCodeController::class, 'defaultStatus'])->name('payment-qr-codes.default-status');

    //Payment
    Route::get('transactions', [PaymentController::class, 'index'])->name('transactions.index');

    Route::resource('payments', AdminPaymentController::class);
    Route::get(
        'get-current-date-format',
        [AdminPaymentController::class, 'getCurrentDateFormat']
    )->name('get-current-date-format');

    // payment approved
    Route::get(
        'change-transaction-status/{id}',
        [PaymentController::class, 'changeTransactionStatus']
    )->name('change-transaction-status');

    //Setting Route
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('invoice-settings', [SettingController::class, 'invoiceUpdate'])->name('invoice-settings.settings');
    Route::get(
        'invoice-template/{key}',
        [SettingController::class, 'editInvoiceTemplate']
    )->name('invoice-template.edit');
    Route::post('payment-gateway/store', [PaymentGatewayController::class, 'store'])->name('payment-gateway.store');
    Route::get('payment-gateway', [PaymentGatewayController::class, 'show'])->name('payment-gateway.show');
    //invoice template
    Route::get('template-setting', [InvoiceTemplateController::class, 'invoiceTemplateView'])->name('invoiceTemplate');
    Route::post(
        'change-invoice-template',
        [InvoiceTemplateController::class, 'invoiceTemplateUpdate']
    )->name('invoiceTemplate.update');

    // Currency
    Route::resource('currencies', CurrencyController::class);

    Route::post('user/{user}/change-status', [UserController::class, 'changeUserStatus'])->name('users.change-status');

    //getInvoiceDueAmount
    Route::get(
        'payments.get-invoiceAmount/{id}',
        [AdminPaymentController::class, 'getInvoiceDueAmount']
    )->name('payments.get-invoiceAmount');

    //Export Invoices Excel admin route
    Route::get('/invoices-excel', [InvoiceController::class, 'exportInvoicesExcel'])->name('admin.invoicesExcel');
    // export quotes excel admin route
    Route::get('/quotes-excel', [QuoteController::class, 'exportQuotesExcel'])->name('admin.quotesExcel');
    // export quotes pdf admin route
    Route::get('quotes-pdf', [QuoteController::class, 'exportQuotesPdf'])->name('admin.quotes.pdf');
    Route::get(
        'transactions-excel',
        [paymentController::class, 'exportTransactionsExcel']
    )->name('admin.transactionsExcel');
    // export transactions pdf admin route
    Route::get(
        'transactions-pdf',
        [paymentController::class, 'exportTransactionsPdf']
    )->name('admin.export.transactions.pdf');

    // export payments excel admin route
    Route::get(
        'admin-payments-excel',
        [AdminPaymentController::class, 'exportAdminPaymentsExcel']
    )->name('admin.paymentsExcel');

    // export payments pdf admin route
    Route::get(
        'admin-payments-pdf',
        [AdminPaymentController::class, 'exportAdminPaymentsPDF']
    )->name('admin.payments.pdf');

    Route::get('invoices-pdf', [InvoiceController::class, 'exportInvoicesPdf'])->name('admin.invoices.pdf');

    //Clear cache
    Route::get('clear-cache', [DashboardController::class, 'clearCache'])->name('clear-cache');

    Route::get('invoice-settings/', [SettingController::class, 'invoiceSettings'])->name('settings.invoice-settings');

    // currency reports for invoices route
    Route::get('currency-reports', [DashboardController::class, 'currencyReports'])->name('currency.reports');
    Route::resource('/countries', CountryController::class);
    //state
    Route::resource('/states', StateController::class);
    //city
    Route::resource('/cities', CityController::class);
});

Route::prefix('client')->middleware(['auth', 'xss', 'role:client'])->group(function () {
    Route::get(
        'dashboard',
        [Client\DashboardController::class, 'index']
    )->name('client.dashboard');

    Route::get('transactions', [Client\PaymentController::class, 'index'])->name('client.transactions.index');

    //Invoice
    Route::get(
        'invoices',
        [Client\InvoiceController::class, 'index']
    )->name('client.invoices.index');
    Route::get(
        'invoices/{invoice}',
        [Client\InvoiceController::class, 'show']
    )->name('client.invoices.show');
    Route::get(
        'invoices/{invoice}/pdf',
        [Client\InvoiceController::class, 'convertToPdf']
    )->name('clients.invoices.pdf');

    //Quote
    Route::name('client.')->group(function () {
        Route::resource('quotes', Client\QuoteController::class);
    });
    Route::get(
        'quotes/{quote}/pdf',
        [Client\QuoteController::class, 'convertToPdf']
    )->name('client.quotes.pdf');

    //export quotes Excel file in client route
    Route::get('/quotes-excel', [Client\QuoteController::class, 'exportQuotesExcel'])->name('client.quotesExcel');
    // export quotes Pdf in client route
    Route::get('quotes-pdf', [Client\QuoteController::class, 'exportQuotesPdf'])->name('client.export.quotes.pdf');
    // export invoices Pdf in client route
    Route::get('/invoice-excel', [client\InvoiceController::class, 'exportInvoicesExcel'])->name('client.invoicesExcel');
    Route::get('invoice-pdf', [client\InvoiceController::class, 'exportInvoicesPdf'])->name('client.invoices.pdf');
    Route::get('transactions-excel', [client\PaymentController::class, 'exportTransactionsExcel'])->name('client.transactionsExcel');
    // export transactions Pdf in client route
    Route::get('transactions-pdf', [client\PaymentController::class, 'exportTransactionsPdf'])->name('client.export.transactions.pdf');

    // currency reports for invoices route
    Route::get('currency-reports', [DashboardController::class, 'currencyReports'])->name('client.currency.reports');
    Route::get('invoices/{invoice}/payment', [Client\PaymentController::class, 'show'])->name('clients.payments.show');
});

Route::prefix('client')->middleware('xss')->group(function () {
    //Payments
    Route::post('payments', [Client\PaymentController::class, 'store'])->name('clients.payments.store');
    Route::post('stripe-payment', [Client\StripeController::class, 'createSession'])->name('client.stripe-payment');
    Route::get('razorpay-onboard', [Client\RazorpayController::class, 'onBoard'])->name('razorpay.init');
    Route::get('paypal-onboard', [Client\PaypalController::class, 'onBoard'])->name('paypal.init');

    Route::get('payment-success', [Client\StripeController::class, 'paymentSuccess'])->name('payment-success');
    Route::get('failed-payment', [Client\StripeController::class, 'handleFailedPayment'])->name('failed-payment');

    Route::get('paypal-payment-success', [Client\PaypalController::class, 'success'])->name('paypal.success');
    Route::get('paypal-payment-failed', [Client\PaypalController::class, 'failed'])->name('paypal.failed');

    // razorpay payment
    Route::post('razorpay-payment-success', [Client\RazorpayController::class, 'paymentSuccess'])
        ->name('razorpay.success');
    Route::post('razorpay-payment-failed', [Client\RazorpayController::class, 'paymentFailed'])
        ->name('razorpay.failed');
    Route::get('razorpay-payment-webhook', [Client\RazorpayController::class, 'paymentSuccessWebHook'])
        ->name('razorpay.webhook');

    // Paystack Payment Route
    Route::get('/paystack-onboard', [Client\PaystackController::class, 'redirectToGateway'])->name('client.paystack.init');
    Route::any(
        '/paystack-payment-success',
        [Client\PaystackController::class, 'handleGatewayCallback']
    )->name('client.paystack.success');
});

Route::middleware(['auth', 'xss'])->group(function () {
    // Update profile
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.setting');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile.setting');
    Route::put('/change-user-password', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::get('get-all-language', [UserController::class, 'getLanguages'])->name('get-all-language');
    Route::get('quotes/{productId}/product', [QuoteController::class, 'getProduct'])->name('quotes.get-product');

    // Download Attachment
    Route::get('transactions-attachment/{id}', [PaymentController::class, 'downloadAttachment'])->name('transaction.attachment');

    Route::get('payment-notes/{paymentId}', [PaymentController::class, 'showPaymentNotes'])->name('payment-notes.show');

    // send invoice on whatsapp route
    Route::post('send-invoice-on-whatsapp', [InvoiceController::class, 'sendInvoiceOnWhatsapp'])->name('send.invoice.on.whatsapp');
});

Route::get('lang-js', function(){
    Artisan::call('lang:js');

    return redirect(route('login'));
});

require __DIR__ . '/auth.php';
require __DIR__ . '/upgrade.php';
