<?php

namespace Tests\Helpers;

use App\Models\Model;
use App\Models\Supplier;
use App\Models\SupplierEmbellishment;

class SupplierGenerator
{
    /**
     * @var Supplier $supplier
     */
    public $supplier;
    
    /**
     * @param Supplier $supplier
     */
    public function __construct($supplier)
    {
        $this->supplier = $supplier;
    }
    
    /**
     * @return SupplierGenerator
     */
    public static function create()
    {
        Model::disableEvents();
        
        $designTypes = design_type_repository()->options();
        $supplier = factory(Supplier::class)->create();
        
        foreach (design_type_repository()->options() as $designType => $designTypeCaption) {
            factory(SupplierEmbellishment::class)->create([
                'supplier_id'   => $supplier->id,
                'embellishment' => $designType,
            ]);
        }
        
        Model::enableEvents();
        
        return new SupplierGenerator($supplier);
    }
}
