<?php

function address_repository()
{
    return App::make(\App\Repositories\Models\AddressRepository::class);
}

function cart_repository()
{
    return App::make(\App\Repositories\Models\CartRepository::class);
}

function campaign_lead_repository()
{
    return App::make(\App\Repositories\Models\CampaignLeadRepository::class);
}

function campaign_repository()
{
    return App::make(\App\Repositories\Models\CampaignRepository::class);
}

function campaign_supply_repository()
{
    return App::make(\App\Repositories\Models\CampaignSupplyRepository::class);
}

function campaign_supply_entry_repository()
{
    return App::make(\App\Repositories\Models\CampaignSupplyEntryRepository::class);
}

function campaign_file_repository()
{
    return App::make(\App\Repositories\Models\CampaignFileRepository::class);
}

function campaign_state_repository()
{
    return App::make(\App\Repositories\Models\CampaignStateRepository::class);
}

function order_repository()
{
    return App::make(\App\Repositories\Models\OrderRepository::class);
}

function order_entry_repository()
{
    return App::make(\App\Repositories\Models\OrderEntryRepository::class);
}

function comment_repository()
{
    return App::make(\App\Repositories\Models\CommentRepository::class);
}

function file_repository()
{
    return App::make(\App\Repositories\Models\FileRepository::class);
}

function artwork_request_repository()
{
    return App::make(\App\Repositories\Models\ArtworkRequestRepository::class);
}

function artwork_request_file_repository()
{
    return App::make(\App\Repositories\Models\ArtworkRequestFileRepository::class);
}

function artwork_repository()
{
    return App::make(\App\Repositories\Models\ArtworkRepository::class);
}

function artwork_file_repository()
{
    return App::make(\App\Repositories\Models\ArtworkFileRepository::class);
}

function user_repository()
{
    return App::make(\App\Repositories\Models\UserRepository::class);
}

function store_repository()
{
    return App::make(\App\Repositories\Models\StoreRepository::class);
}

function user_type_repository()
{
    return App::make(App\Repositories\Models\UserTypeRepository::class);
}

function school_repository()
{
    return App::make(\App\Repositories\Models\SchoolRepository::class);
}

function chapter_repository()
{
    return App::make(\App\Repositories\Models\ChapterRepository::class);
}

function garment_gender_repository()
{
    return App::make(\App\Repositories\Models\GarmentGenderRepository::class);
}

function garment_brand_repository()
{
    return App::make(\App\Repositories\Models\GarmentBrandRepository::class);
}

function garment_category_repository()
{
    return App::make(\App\Repositories\Models\GarmentCategoryRepository::class);
}

function garment_size_repository()
{
    return App::make(\App\Repositories\Models\GarmentSizeRepository::class);
}

function product_repository()
{
    return App::make(\App\Repositories\Models\ProductRepository::class);
}

function product_size_repository()
{
    return App::make(\App\Repositories\Models\ProductSizeRepository::class);
}

function product_color_repository()
{
    return App::make(\App\Repositories\Models\ProductColorRepository::class);
}

function supplier_repository()
{
    return App::make(\App\Repositories\Models\SupplierRepository::class);
}

function design_repository()
{
    return App::make(\App\Repositories\Models\DesignRepository::class);
}

function design_file_repository()
{
    return App::make(\App\Repositories\Models\DesignFileRepository::class);
}

function design_tag_group_repository()
{
    return App::make(\App\Repositories\Models\DesignTagGroupRepository::class);
}

function design_tag_repository()
{
    return App::make(\App\Repositories\Models\DesignTagRepository::class);
}

function budget_repository()
{
    return App::make(App\Repositories\Models\BudgetRepository::class);
}

function work_with_us_repository()
{
    return App::make(\App\Repositories\Models\WorkWithUsRepository::class);
}

function lob_repository()
{
    return \App::make(\App\Repositories\Address\LobRepository::class);
}

/**
 * @param string $provider
 * @return \App\Contracts\Billing\BillingRepository|null
 */
function billing_repository($provider = null)
{
    if ($provider) {
        switch ($provider) {
            case 'braintree':
                return \App::make(\App\Repositories\Billing\BrainTreeRepository::class);
            case 'AUTHORIZE':
                return \App::make(\App\Repositories\Billing\AuthorizeRepository::class);
            case 'manual':
                return \App::make(\App\Repositories\Billing\ManualRepository::class);
            case 'test':
                return new \App\Repositories\Billing\TestRepository();
        }

        return null;
    }

    if (\App::environment() == 'testing') {
        return new \App\Repositories\Billing\TestRepository();
    }

    if (config('greekhouse.billing..') == 'AUTHORIZE') {
        return \App::make(\App\Repositories\Billing\AuthorizeRepository::class);
    }

    if (config('greekhouse.billing.provider') == 'braintree') {
        return \App::make(\App\Repositories\Billing\BrainTreeRepository::class);
    }

    return null;
}

function log_repository()
{
    return \App::make(\App\Repositories\Models\LogRepository::class);
}

function email_repository()
{
    return \App::make(\App\Repositories\Models\EmailRepository::class);
}

function email_attachment_repository()
{
    return \App::make(\App\Repositories\Models\EmailAttachmentRepository::class);
}

function school_year_repository()
{
    return \App::make(\App\Repositories\Helpers\SchoolYearRepository::class);
}

function chapter_position_repository()
{
    return \App::make(\App\Repositories\Helpers\ChapterPositionRepository::class);
}

function chapter_member_count_repository()
{
    return \App::make(\App\Repositories\Helpers\ChapterMemberCountRepository::class);
}

function yes_no_repository()
{
    return \App::make(\App\Repositories\Helpers\YesNoRepository::class);
}

function enabled_disabled_repository()
{
    return \App::make(\App\Repositories\Helpers\EnabledDisabledRepository::class);
}

function on_off_repository()
{
    return \App::make(\App\Repositories\Helpers\OnOffRepository::class);
}

function shipping_options_repository()
{
    return \App::make(\App\Repositories\Helpers\ShippingOptionRepository::class);
}

function country_repository()
{
    return \App::make(\App\Repositories\Helpers\CountryRepository::class);
}

function design_style_preference_repository()
{
    return \App::make(\App\Repositories\Helpers\DesignStylePreferenceRepository::class);
}

function design_type_repository()
{
    return \App::make(\App\Repositories\Helpers\DesignTypeRepository::class);
}

function active_repository()
{
    return \App::make(\App\Repositories\Helpers\ActiveRepository::class);
}

function fulfillment_issue_reason_repository()
{
    return \App::make(\App\Repositories\Helpers\FulfillmentIssueReasonRepository::class);
}

function color_repository()
{
    return \App::make(\App\Repositories\Helpers\ColorRepository::class);
}

function on_hold_rejected_by_designer_reason_repository()
{
    return \App::make(\App\Repositories\Helpers\OnHoldRejectedByDesignerReasonRepository::class);
}

function design_status_repository()
{
    return \App::make(\App\Repositories\Helpers\DesignStatusRepository::class);
}

function transaction_repository()
{
    return \App::make(\App\Repositories\Models\TransactionRepository::class);
}

function ambassador_repository()
{
    return \App::make(\App\Repositories\Models\AmbassadorRepository::class);
}

function campus_manager_repository()
{
    return \App::make(\App\Repositories\Models\CampusManagerRepository::class);
}

function sf_contact_repository()
{
    return \App::make(\App\Repositories\Models\SFContactRepository::class);
}

function chapter_organization_repository()
{
    return \App::make(\App\Repositories\Models\ChapterOrganizationRepository::class);
}

function campaign_note_repository()
{
    return \App::make(\App\Repositories\Models\CampaignNoteRepository::class);
}

function campaign_quote_repository()
{
    return \App::make(\App\Repositories\Models\CampaignQuoteRepository::class);
}

function pms_color_repository()
{
    return \App::make(\App\Repositories\Helpers\PMSColorRepository::class);
}

function billing_transaction_repository()
{
    return \App::make(\App\Repositories\Models\BillingTransactionRepository::class);
}

function slider_image_repository()
{
    return \App::make(\App\Repositories\Models\SliderImageRepository::class);
}