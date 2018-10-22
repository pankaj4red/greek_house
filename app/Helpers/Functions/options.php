<?php

function budget_options($nullOption = [])
{
    return budget_repository()->options($nullOption);
}

function user_type_options($nullOption = [])
{
    return user_type_repository()->options($nullOption);
}

function decorator_options($printType = null, $nullOption = [])
{
    return user_repository()->decoratorOptions($printType, $nullOption);
}

function account_manager_options($nullOption = [])
{
    return user_repository()->optionsByType('account_manager', $nullOption);
}

function designer_options($nullOption = [])
{
    return user_repository()->optionsByType(['designer', 'junior_designer'], $nullOption);
}

function user_options($nullOption = [])
{
    return user_repository()->options($nullOption);
}

function product_options($nullOption = [])
{
    return product_repository()->options($nullOption);
}

function product_color_options($productId = null, $nullOption = [])
{
    return product_color_repository()->options($productId, $nullOption);
}

function product_size_options($productId = null, $nullOption = [])
{
    return product_size_repository()->options($productId, $nullOption);
}

function school_year_options($nullOption = [])
{
    return school_year_repository()->options($nullOption);
}

function chapter_position_options($nullOption = [])
{
    return chapter_position_repository()->options($nullOption);
}

function chapter_member_count_options($nullOption = [])
{
    return chapter_member_count_repository()->options($nullOption);
}

function yes_no_options($nullOption = [])
{
    return yes_no_repository()->options($nullOption);
}

function shipping_options($nullOption = [])
{
    return shipping_options_repository()->options($nullOption);
}

function country_options($nullOption = [])
{
    return country_repository()->options($nullOption);
}

function design_style_preference_options($nullOption = [])
{
    return design_style_preference_repository()->options($nullOption);
}

function design_type_options($nullOption = [])
{
    return design_type_repository()->options($nullOption);
}

function estimated_quantity_options($printType)
{
    return \App\Repositories\PrintType\PrintTypeRepository::getPrintType($printType)->getEstimatedRangeOptions();
}

function garment_brand_options($nullOption = [])
{
    return garment_brand_repository()->options($nullOption);
}

function garment_gender_options($nullOption = [])
{
    return garment_gender_repository()->options($nullOption);
}

function garment_category_options($nullOption = [])
{
    return garment_category_repository()->options($nullOption);
}

function additional_garment_category_options($nullOption = [])
{
    return garment_category_repository()->additionalOptions($nullOption);
}

function suggested_supplier_options($nullOption = [])
{
    return supplier_repository()->options($nullOption);
}

function active_options($nullOption = [])
{
    return active_repository()->options($nullOption);
}

function fulfillment_issue_reason_options($nullOption = [])
{
    return fulfillment_issue_reason_repository()->options($nullOption);
}

function garment_size_options($productId, $nullOption = [])
{
    return garment_size_repository()->options($productId, $nullOption);
}

function color_options($code, $nullOption = [], $includeZero = true)
{
    return color_repository()->options($code, $nullOption, $includeZero);
}

function on_hold_rejected_by_designer_reason_options($nullOption = [])
{
    return on_hold_rejected_by_designer_reason_repository()->options($nullOption);
}

function design_status_options($nullOption = null)
{
    return design_status_repository()->options($nullOption);
}

function campaign_state_options($nullOption = [])
{
    return campaign_state_repository()->options($nullOption);
}

function sleeve_options()
{
    return [
        'left'  => 'Left',
        'right' => 'Right',
        'both'  => 'Both',
    ];
}

function flexible_options()
{
    return [
        ''    => 'Please select an option',
        'no'  => 'I need this Order Delivered by a specific date',
        'yes' => 'I\'m okay with 10 business days',
    ];
}

function rush_options()
{
    return [
        ''    => 'Please select an option',
        'yes' => 'Yes',
        'no'  => 'No',
    ];
}

function wizard_options()
{
    return [
        'default' => 'Default',
        'show'    => 'Show',
        'hide'    => 'hide',
    ];
}

function address_options($addresses, $nullOption = [])
{
    $options = $nullOption;
    foreach ($addresses as $address) {
        $options[$address->id] = $address->name;
    }

    return $options;
}

function chapter_organization_options($nullOption = [])
{
    return chapter_organization_repository()->options($nullOption);
}

function graduation_year_options($nullOption = 'Select One')
{
    return [
        ''              => $nullOption,
        '2018'          => '2018',
        '2019'          => '2019',
        '2020'          => '2020',
        '2021'          => '2021',
        '2022'          => '2022',
        '2023'          => '2023',
        '2024'          => '2024',
        'Alumni'        => 'Alumni',
        'Not a Student' => 'Not a Student',
    ];
}
