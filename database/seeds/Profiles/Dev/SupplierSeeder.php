<?php

class SupplierSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = include(database_path('seeds/Data/Seed/suppliers.php'));
        foreach ($suppliers as $supplier) {
            $embellishments = $supplier['embellishments'];
            unset($supplier['embellishments']);

            $model = factory(\App\Models\Supplier::class)->create($supplier);

            foreach ($embellishments as $embellishment) {
                factory(\App\Models\SupplierEmbellishment::class)->create([
                    'supplier_id'   => $model->id,
                    'embellishment' => $embellishment,
                ]);
            }
        }
    }
}