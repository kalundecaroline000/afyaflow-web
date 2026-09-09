<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Receptionist\PatientController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Billing\InvoiceController;
use App\Http\Controllers\Nurse\VitalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Patient\MedicalRecordController;
use App\Http\Controllers\Patient\PaymentController;
use App\Http\Controllers\Patient\InvoiceController as PatientInvoiceController;
use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', function () {
        return view('doctor.dashboard');
    })->name('doctor.dashboard');

    Route::get('/doctor/appointments', [DoctorAppointmentController::class, 'index'])->name('doctor.appointments.index');
    Route::post('/doctor/appointments/{id}/confirm', [DoctorAppointmentController::class, 'confirm'])->name('doctor.appointments.confirm');
    Route::get('/doctor/appointments/{id}/diagnose', [DoctorAppointmentController::class, 'showDiagnosisForm'])->name('doctor.appointments.diagnose');
    Route::post('/doctor/appointments/{id}/diagnose', [DoctorAppointmentController::class, 'storeDiagnosis'])->name('doctor.appointments.diagnose.store');
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');

    Route::get('/patient/records', [MedicalRecordController::class, 'index'])->name('patient.records.index');
    Route::post('/patient/invoices/{id}/pay', [PaymentController::class, 'pay'])->name('patient.invoices.pay');

    Route::get('/patient/appointments/create', [AppointmentController::class, 'create'])->name('patient.appointments.create');
    Route::post('/patient/appointments', [AppointmentController::class, 'store'])->name('patient.appointments.store');
Route::get('/patient/invoices', [PatientInvoiceController::class, 'index'])->name('patient.invoices.index');
});

Route::middleware(['auth', 'role:nurse'])->group(function () {
    Route::get('/nurse/dashboard', function () {
        return view('nurse.dashboard');
    })->name('nurse.dashboard');

    Route::get('/nurse/vitals/create', [VitalController::class, 'create'])->name('nurse.vitals.create');
    Route::post('/nurse/vitals', [VitalController::class, 'store'])->name('nurse.vitals.store');
});

Route::middleware(['auth', 'role:billing_officer'])->group(function () {
    Route::get('/billing/dashboard', function () {
        return view('billing.dashboard');
    })->name('billing.dashboard');

    Route::get('/billing/invoices', [InvoiceController::class, 'index'])->name('billing.invoices.index');
    Route::get('/billing/invoices/create', [InvoiceController::class, 'create'])->name('billing.invoices.create');
    Route::post('/billing/invoices', [InvoiceController::class, 'store'])->name('billing.invoices.store');
    Route::post('/billing/invoices/{id}/mark-paid', [InvoiceController::class, 'markPaid'])->name('billing.invoices.markPaid');
});

Route::middleware(['auth', 'role:receptionist'])->group(function () {
    Route::get('/receptionist/dashboard', function () {
        return view('receptionist.dashboard');
    })->name('receptionist.dashboard');

    Route::get('/receptionist/patients/create', [PatientController::class, 'create'])->name('receptionist.patients.create');
    Route::post('/receptionist/patients', [PatientController::class, 'store'])->name('receptionist.patients.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{id}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
});

Route::post('/mpesa/callback', [PaymentController::class, 'callback'])->name('mpesa.callback');

require __DIR__.'/auth.php';