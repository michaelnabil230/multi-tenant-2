<?php

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('project:init', function () {
    // if ($tenant = Tenant::first()) {
    //     $tenant->delete();
    // }
    Artisan::call('migrate:refresh');
    $this->info(Artisan::output());
    Artisan::call('db:seed');
    $this->info(Artisan::output());
    Artisan::call('storage:link');
    $this->info(Artisan::output());
    Artisan::call('debugbar:clear');
    $this->info(Artisan::output());
    Artisan::call('optimize:clear');
    $this->info(Artisan::output());
    Artisan::call('create:tenant', [
        'name' => 'shop1',
        'plan' => 'free',
    ]);
    $this->info(Artisan::output());
})->describe('Running commands');

Artisan::command('create:tenant {name} {plan}', function ($name, $plan) {

    $this->comment("Creating tenant $name ...");

    $premiumDomain = Str::replace(['https://', 'http://'], $name . '.', config('app.url'));
    $dashboardDomain = 'dashboard-' . $premiumDomain;

    $isExists = Domain::query()
        ->orWhere('domain', $premiumDomain)
        ->orWhere('domain', $dashboardDomain)
        ->exists();

    if ($isExists) {
        $this->error("Domain $premiumDomain already exists");

        return;
    }

    $tenant = Tenant::create([
        'data' => [
            'name' => $name,
            'plan' => $plan,
        ],
    ]);

    $tenant->domains()->createMany([
        ['domain' => $premiumDomain],
        ['domain' => $dashboardDomain],
    ]);

    $this->info("Tenant created $name successfully.");
})->describe('Create a new tenant');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
