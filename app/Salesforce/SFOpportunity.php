<?php

namespace App\Salesforce;

use App\Helpers\ModelCache;
use App\Models\Campaign;
use Carbon\Carbon;

/**
 * Class SFOpportunity
 *
 * @property $Id
 * @property $Name
 * @property $Campaign__c
 * @property $Campaign_Link__c
 * @property $Estimated_Quantity__c
 * @property $Promocode__c
 * @property $CloseDate
 * @property $Campus_Manager_Name__c
 * @property $Campaign_Contact__c
 * @property $College_University__c
 * @property $Chapter__c
 * @property $Shipping_Address__c
 * @property $Shipping_City__c
 * @property $Zip_Code__c
 * @property $State__c
 * @property $Group_Shipping__c
 * @property $Individual_Shipping__c
 * @property $Shipment_Type__c
 * @property $Customer_Email__c
 * @property $Amount
 * @property $Amount_w_o_Tax__c
 * @property $Campus_Manager_Commission__c
 * @property $Sales_Rep_Comission_del__c
 * @property $Price_Per_Unit_with_Tax__c
 * @property $TotalOpportunityQuantity
 * @property $Printing_Cost__c
 * @property $Shipping_Cost__c
 * @property $Designer_Cost_Hour__c
 * @property $Total_Supplier_Cost__c
 * @property $Work_Order_Date__c
 * @property $Print_Date__c
 * @property $Ship_Date__c
 * @property $Total_of_Screens__c
 * @property $of_colors_on_front__c
 * @property $of_colors_on_back__c
 * @property $of_colors_on_left_sleeve__c
 * @property $of_colors_on_right_sleeve__c
 * @property $Embellishment__c
 * @property $Time_in_Awaiting_Design__c
 * @property $Time_in_Awaiting_Quote__c
 * @property $Time_in_Collecting_Payment__c
 * @property $Time_in_Fulfillment_Ready__c
 * @property $Time_in_F_Validation__c
 * @property $Time_in_Printing__c
 * @property $Time_in_Revisions_Requested__c
 * @property $Total_of_Revisions__c
 * @property $Design_Hours__c
 * @property $Designer_Name__c
 * @property $Decorator_Name__c
 * @property $StageName
 * @property $Garment_Arrival_Date__c
 * @property $Type
 * @property $Due_Date__c
 * @property $Flexible__c
 * @property $Rush__c
 * @property $Days_in_Transit__c
 * @property $Royalty__c
 * @property $Tracking__c
 * @property $Payment_Link__c
 * @property $Design_Gallery_Status__c
 * @property $Design_Code__c
 * @property $Trending__c
 * @property $Design_Gallery_Link__c
 * @property $General_Tags__c
 * @property $Themes__c
 * @property $Event__c
 * @property $College_University_Design_Tag__c
 * @property $Chapter_s_Design_Tag__c
 * @property $Product_Type_Design_Tag__c
 * @property $Product_SKU__c
 * @property $Product_Color__c
 * @property $Garment_Name__c
 * @property $Referred_Id__c
 * @property $Referred_By__c
 * @property $Design_Gallery_Image_Uploaded__c
 * @property $Print_Files_Uploaded__c
 * @property $Fulfillment_Notes__c
 * @property $Sizes_Collected_by__c
 * @property $Payment_Date_Type__c
 * @property $Polybag_and_Label__c
 */
class SFOpportunity extends SFModel
{
    /**
     * Salesforce Object Name
     *
     * @var string
     */
    protected static $object = 'Opportunity';

    /**
     * Salesforce Object Id
     *
     * @var string
     */
    protected static $objectId = 'Id';

    /**
     * Salesforce Object Synchronization Id
     *
     * @var string
     */
    protected static $synchronizationField = 'Campaign__c';

    /**
     * List of relevant Salesforce fields
     *
     * @var string[]
     */
    protected static $fields = [
        'Name',
        'Campaign__c',
        'Campaign_Link__c',
        'Estimated_Quantity__c',
        'Promocode__c',
        'CloseDate',
        'Campus_Manager_Name__c',
        'Campaign_Contact__c',
        'College_University__c',
        'Chapter__c',
        'Shipping_Address__c',
        'Shipping_City__c',
        'Zip_Code__c',
        'State__c',
        'Group_Shipping__c',
        'Individual_Shipping__c',
        'Shipment_Type__c',
        'Customer_Email__c',
        'Amount',
        'Amount_w_o_Tax__c',
        'Campus_Manager_Commission__c',
        'Sales_Rep_Comission_del__c',
        'Price_Per_Unit_with_Tax__c',
        'TotalOpportunityQuantity',
        'Printing_Cost__c',
        'Shipping_Cost__c',
        'Designer_Cost_Hour__c',
        'Print_Date__c',
        'Ship_Date__c',
        'Total_of_Screens__c',
        'of_colors_on_front__c',
        'of_colors_on_back__c',
        'of_colors_on_left_sleeve__c',
        'of_colors_on_right_sleeve__c',
        'Embellishment__c',
        'Time_in_Awaiting_Design__c',
        'Time_in_Awaiting_Quote__c',
        'Time_in_Collecting_Payment__c',
        'Time_in_Fulfillment_Ready__c',
        'Time_in_F_Validation__c',
        'Time_in_Printing__c',
        'Time_in_Revisions_Requested__c',
        'Total_of_Revisions__c',
        'Design_Hours__c',
        'Designer_Name__c',
        'Decorator_Name__c',
        'StageName',
        'Work_Order_Date__c',
        'Total_Supplier_Cost__c',
        'Garment_Arrival_Date__c',
        'Type',
        'Due_Date__c',
        'Flexible__c',
        'Rush__c',
        'Days_in_Transit__c',
        'Royalty__c',
        'Tracking__c',
        'Payment_Link__c',
        'Design_Gallery_Status__c',
        'Design_Code__c',
        'Trending__c',
        'Design_Gallery_Link__c',
        'General_Tags__c',
        'Themes__c',
        'Event__c',
        'College_University_Design_Tag__c',
        'Chapter_s_Design_Tag__c',
        'Product_Type_Design_Tag__c',
        'Product_SKU__c',
        'Product_Color__c',
        'Garment_Name__c',
        'Referred_Id__c',
        'Referred_By__c',
        'Design_Gallery_Image_Uploaded__c',
        'Print_Files_Uploaded__c',
        'Fulfillment_Notes__c',
        'Sizes_Collected_by__c',
        'Payment_Date_Type__c',
        'Polybag_and_Label__c',
    ];

    /**
     * Associates this Salesforce Object to a Campaign
     *
     * @param ModelCache $modelCache
     */
    public function associateInDatabase($modelCache = null)
    {
        $campaign = $modelCache ? $modelCache->getOrFetch((int) $this->Campaign__c) : campaign_repository()->find($this->Campaign__c);

        if ($campaign && $campaign->sf_id != $this->Id) {
            $campaign->update(['sf_id' => $this->Id]);
        }
    }

    public static function size($object)
    {
        $serializedFoo = serialize($object);
        if (function_exists('mb_strlen')) {
            $size = mb_strlen($serializedFoo, '8bit');
        } else {
            $size = strlen($serializedFoo);
        }

        return $size;
    }

    /**
     * Creates a Salesforce Object from a Campaign
     *
     * @param Campaign $campaign
     * @return SFOpportunity
     */
    public static function createFromCampaign(Campaign $campaign)
    {
        $productColor = $campaign->product_colors->first();
        $campaign->loadMissing(['success_orders.entries', 'authorized_success_orders.entries', 'designs.tags']);

        $opportunity = new SFOpportunity([
            'Id'                               => $campaign->sf_id,
            'Name'                             => trim(str_limit($campaign->name, 77)),
            'Campaign__c'                      => $campaign->id,
            'Campaign_Link__c'                 => route('dashboard::details', [$campaign->id], true),
            'Estimated_Quantity__c'            => estimated_quantity_by_code($campaign->getCurrentArtwork()->design_type, $campaign->estimated_quantity)->from,
            'Promocode__c'                     => $campaign->promo_code,
            'CloseDate'                        => $campaign->getCloseDate(),
            'Campus_Manager_Name__c'           => $campaign->user->account_manager ? $campaign->user->account_manager->getFullName(true) : null,
            'Campaign_Contact__c'              => $campaign->user->sf_id,
            'College_University__c'            => trim($campaign->contact_school),
            'Chapter__c'                       => trim($campaign->contact_chapter),
            'Shipping_Address__c'              => trim($campaign->address_line1.' '.$campaign->address_line2),
            'Shipping_City__c'                 => trim($campaign->address_city),
            'Zip_Code__c'                      => sanitize_zip_code($campaign->address_zip_code),
            'State__c'                         => trim($campaign->address_state),
            'Group_Shipping__c'                => $campaign->shipping_group ? 'Enabled' : 'Disabled',
            'Individual_Shipping__c'           => $campaign->shipping_group ? 'Enabled' : 'Disabled',
            'Customer_Email__c'                => trim(strtolower($campaign->contact_email)),
            'Amount_w_o_Tax__c'                => $campaign->getSubTotal(),
            'Amount'                           => $campaign->getTotal(),
            'Campus_Manager_Commission__c'     => $campaign->getManagerCommission(),
            'Sales_Rep_Comission_del__c'       => $campaign->getSalesRepCommission(),
            'Price_Per_Unit_with_Tax__c'       => $campaign->getPricePerUnitWithTax(),
            'TotalOpportunityQuantity'         => $campaign->getAuthorizedAndSuccessQuantity(),
            'Shipping_Cost__c'                 => $campaign->shipping_cost ? $campaign->shipping_cost : null,
            'Designer_Cost_Hour__c'            => $campaign->artwork_request->hourly_rate,
            'Print_Date__c'                    => $campaign->printing_date ? $campaign->printing_date->format('Y-m-d') : null,
            'Ship_Date__c'                     => $campaign->shipped_at ? $campaign->shipped_at->format('Y-m-d') : null,
            'Total_of_Screens__c'              => $campaign->getTotalScreens(),
            'of_colors_on_front__c'            => $campaign->getCurrentArtwork()->designer_colors_front,
            'of_colors_on_back__c'             => $campaign->getCurrentArtwork()->designer_colors_back,
            'of_colors_on_left_sleeve__c'      => $campaign->getCurrentArtwork()->designer_colors_sleeve_left,
            'of_colors_on_right_sleeve__c'     => $campaign->getCurrentArtwork()->designer_colors_sleeve_right,
            'Embellishment__c'                 => $campaign->getCurrentArtwork()->design_type == 'screen' ? 'Screenprint' : ($campaign->getCurrentArtwork()->design_type == 'embroidery' ? 'Embroidery' : null),
            'Time_in_Awaiting_Design__c'       => seconds_to_days($campaign->awaiting_design_time),
            'Time_in_Awaiting_Quote__c'        => seconds_to_days($campaign->awaiting_quote_time),
            'Time_in_Collecting_Payment__c'    => seconds_to_days($campaign->collecting_payment_time),
            'Time_in_Fulfillment_Ready__c'     => seconds_to_days($campaign->fulfillment_ready_time),
            'Time_in_F_Validation__c'          => seconds_to_days($campaign->fulfillment_validation_time),
            'Time_in_Printing__c'              => seconds_to_days($campaign->printing_time),
            'Time_in_Revisions_Requested__c'   => seconds_to_days($campaign->revision_requested_time),
            'Total_of_Revisions__c'            => $campaign->artwork_request->revision_count,
            'Design_Hours__c'                  => $campaign->getDesignHours(),
            'Designer_Name__c'                 => $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName(true) : null,
            'Decorator_Name__c'                => $campaign->decorator ? $campaign->decorator->getFullName(true) : null,
            'StageName'                        => campaign_state_to_salesforce_stage($campaign->state, $campaign),
            'Garment_Name__c'                  => $productColor->product->name,
            'Product_SKU__c'                   => $productColor->product->sku,
            'Product_Color__c'                 => $productColor->id,
            'Total_Supplier_Cost__c'           => $campaign->getTotalSupplierCost(),
            'Printing_Cost__c'                 => $campaign->invoice_total ?$campaign->invoice_total : 0,
            'Garment_Arrival_Date__c'          => $campaign->garment_arrival_date ? Carbon::parse($campaign->garment_arrival_date)->format('Y-m-d') : null,
            'Work_Order_Date__c'               => $campaign->assigned_decorator_date ? Carbon::parse($campaign->assigned_decorator_date)->format('Y-m-d') : null,
            'Type'                             => $campaign->user && $campaign->user->campaigns->first() && $campaign->user->campaigns->first()->id != $campaign->id ? 'Existing Business' : 'New Business',
            'Due_Date__c'                      => $campaign->date ? Carbon::parse($campaign->date)->format('Y-m-d') : null,
            'Flexible__c'                      => $campaign->flexible == 'yes' ? 'Yes' : 'No',
            'Rush__c'                          => $campaign->rush ? 'Yes' : 'No',
            'Days_in_Transit__c'               => $campaign->days_in_transit,
            'Royalty__c'                       => $campaign->getRoyalty(),
            'Tracking__c'                      => $campaign->tracking_code ? $campaign->tracking_code : null,
            'Payment_Link__c'                  => in_array($campaign->state, [
                'collecting_payment',
                'processing_payment',
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ]) ? route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) : null,
            'Design_Gallery_Status__c'         => campaign_design_gallery_status_to_salesforce($campaign),
            'Design_Code__c'                   => $campaign->designs->first() ? $campaign->designs->first()->code : null,
            'Trending__c'                      => campaign_design_gallery_trending_to_salesforce($campaign),
            'Design_Gallery_Link__c'           => route('home::design_gallery', [$campaign->designs->first()->id]),
            'General_Tags__c'                  => $campaign->designs->first() ? commafy_tags($campaign->designs->first()->getTags('general')) : null,
            'Themes__c'                        => $campaign->designs->first() ? commafy_tags($campaign->designs->first()->getTags('themes')) : null,
            'Event__c'                         => $campaign->designs->first() ? commafy_tags($campaign->designs->first()->getTags('event')) : null,
            'College_University_Design_Tag__c' => $campaign->designs->first() ? commafy_tags($campaign->designs->first()->getTags('college')) : null,
            'Chapter_s_Design_Tag__c'          => $campaign->designs->first() ? commafy_tags($campaign->designs->first()->getTags('chapter')) : null,
            'Product_Type_Design_Tag__c'       => $campaign->designs->first() ? commafy_tags($campaign->designs->first()->getTags('product_type')) : null,
            'Referred_Id__c'                   => $campaign->user->referred_by_id,
            'Referred_By__c'                   => $campaign->user->referred_by_id ? $campaign->user->referred_by->sf_id : null,
            'Design_Gallery_Image_Uploaded__c' => $campaign->designs->first() && $campaign->designs->first()->images->count() > 0 ? 'Yes' : 'no',
            'Print_Files_Uploaded__c'          => $campaign->artwork_request->print_files->count() > 0 ? 'Yes' : 'No',
            'Fulfillment_Notes__c'             => $campaign->fulfillment_notes,
            'Sizes_Collected_by__c'            => $campaign->sizes_collected_date ? $campaign->sizes_collected_date->format('Y-m-d') : null,
            'Payment_Date_Type__c'             => $campaign->payment_date_type,
            'Polybag_and_Label__c'             => $campaign->polybag_and_label ? 'Yes' : 'No',
        ]);

        unset($campaign->success_orders);
        unset($campaign->authorized_success_orders);
        unset($campaign->designs);

        return $opportunity;
    }
}