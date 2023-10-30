<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateBookshopTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshop:generate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tables, models, and controllers for Bookshop POS/Inventory system';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Generate migrations
        $this->call('make:migration', ['name' => 'create_stores_table']);
        $this->call('make:migration', ['name' => 'create_products_table']);
        $this->call('make:migration', ['name' => 'create_categories_table']);
        $this->call('make:migration', ['name' => 'create_suppliers_table']);
        $this->call('make:migration', ['name' => 'create_sales_table']);
        $this->call('make:migration', ['name' => 'create_customers_table']);
        $this->call('make:migration', ['name' => 'create_customer_groups_table']);
        $this->call('make:migration', ['name' => 'create_settings_table']);
        $this->call('make:migration', ['name' => 'create_payment_settings_table']);
        $this->call('make:migration', ['name' => 'create_tax_settings_table']);
        $this->call('make:migration', ['name' => 'create_email_settings_table']);
        $this->call('make:migration', ['name' => 'create_sms_settings_table']);
        $this->call('make:migration', ['name' => 'create_sales_settings_table']);
        

        // Generate models
        $this->call('make:model', ['name' => 'Store']);
        $this->call('make:model', ['name' => 'Product']);
        $this->call('make:model', ['name' => 'Category']);
        $this->call('make:model', ['name' => 'Supplier']);
        $this->call('make:model', ['name' => 'Sale']);
        $this->call('make:model', ['name' => 'Customer']);
        $this->call('make:model', ['name' => 'CustomerGroup']);
        $this->call('make:model', ['name' => 'Setting']);
        $this->call('make:model', ['name' => 'PaymentSetting']);
        $this->call('make:model', ['name' => 'TaxSetting']);
        $this->call('make:model', ['name' => 'EmailSetting']);
        $this->call('make:model', ['name' => 'SMSSetting']);
        $this->call('make:model', ['name' => 'SalesSetting']);


        // Generate controllers
        $this->call('make:controller', ['name' => 'Admin\StoresController']);
        $this->call('make:controller', ['name' => 'Admin\ProductsController']);
        $this->call('make:controller', ['name' => 'Admin\CategoriesController']);
        $this->call('make:controller', ['name' => 'Admin\SuppliersController']);
        $this->call('make:controller', ['name' => 'Admin\SalesController']);
        $this->call('make:controller', ['name' => 'Admin\CustomersController']);
        $this->call('make:controller', ['name' => 'Admin\CustomerGroupsController']);
        $this->call('make:controller', ['name' => 'Admin\SettingsController']);
        $this->call('make:controller', ['name' => 'Admin\PaymentSettingsController']);
        $this->call('make:controller', ['name' => 'Admin\TaxSettingsController']);
        $this->call('make:controller', ['name' => 'Admin\EmailSettingsController']);
        $this->call('make:controller', ['name' => 'Admin\SMSSettingsController']);
        $this->call('make:controller', ['name' => 'Admin\SalesSettingController']);


        $this->info('Tables, models, and controllers generated successfully!');

        // return Command::SUCCESS;
    }
}
