<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(IdendityDocumentTypeSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(IndustrySeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(ProductPresentationSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(BatchSeeder::class);
        $this->call(CustomerTypeSeeder::class);
        $this->call(ExpenseTypeSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SettingSeeder::class);

        //$this->call(CustomerChavezCallaSeeder::class);

        //\App\Models\Beneficiary::factory(7263)->update();
        //\App\Models\Beneficiary::factory()->update([
        //    'user_id' => 1
        //]);
        //
        //App\Models\Beneficiary::chunk(7263, function ($beneficiaries) {
        //    foreach ($beneficiaries as $beneficiary) {
        //        $beneficiary->user_id = 1;
        //        $beneficiary->save();
        //    }
        //});
    }
}
