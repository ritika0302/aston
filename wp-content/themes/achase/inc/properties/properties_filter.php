<?php
/* function for filter option */

function Property_Filter_Option()
{
    if (isset($_GET['parea']) && $_GET['parea'] != '')
    {
        $search_key = preg_replace('/\\\\/i', '', $_GET['parea']);
    }
    else
    {
        $search_key = '';
    }
    $opt_html = '';
    $opt_html .= '<div class="search-wrapper">';
    $opt_html .= '<form id="filter_option" class="filter_option" name="filter_option">';
    $opt_html .= '<div class="input-holder">';
    $opt_html .= '<div class="searchfa" ><img src="' . get_template_directory_uri() . '/assets/images/search.svg" alt="search.svg"></div>';
    $opt_html .= '<label class="mobile-label">Search By Area, Street Or Postcode</label>';
    $opt_html .= '<input type="text" name="area_search" id="autocomplete" class="search-input search-autocomplete" placeholder="Search by area, street or postcode"  value="' . $search_key . '" />';

    $opt_html .= '</div>';
    $opt_html .= '<div class="search-filter">';

    $opt_html .= '<div class="filter-button">';
    $opt_html .= '<div class="filter">FILTERS</div>';
    $opt_html .= '<div class="filter-close">CLOSE</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row active-row">';
    $opt_html .= '<div class="filter-col">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<div class="filter-menu deptbox">';
    

    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && ($_GET['dpt'] == 'sale' || $_GET['dpt'] == 'new_home'))
    {
        $opt_html .= '<label class="material_radio_group checked" for="Buy">';
        $opt_html .= '<input type="radio" name="dp" id="Buy" class="material_radiobox" value="sale" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Buy';
        $opt_html .= '</label> ';
    }
    else if (!isset($_GET['dpt']))
    {
        $opt_html .= '<label class="material_radio_group checked" for="Buy">';
        $opt_html .= '<input type="radio" name="dp" id="Buy" class="material_radiobox" value="sale" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Buy';
        $opt_html .= '</label> ';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="Buy">';
        $opt_html .= '<input type="radio" name="dp" id="Buy" class="material_radiobox" value="sale">';
        $opt_html .= '<span class="material_check_radio"></span>Buy';
        $opt_html .= '</label> ';
    }

    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && $_GET['dpt'] == 'letting')
    {
        $opt_html .= '<label class="material_radio_group checked" for="Rent">';
        $opt_html .= '<input type="radio" name="dp" value="letting" id="Rent" class="material_radiobox" checked="checked">';
        $opt_html .= '<span class="material_check_radio"></span>Rent';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="Rent">';
        $opt_html .= '<input type="radio" name="dp" value="letting" id="Rent" class="material_radiobox">';
        $opt_html .= '<span class="material_check_radio"></span>Rent';
        $opt_html .= '</label>';
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-col">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label">Bedrooms</label>';
    $opt_html .= '<div class="filter-menu">';
    $opt_html .= '<select class="selectpicker selectbeds" name="bed">';
    $opt_html .= '<option value="" class="mob-min">no min</option>';
    $property_bedrooms_cnt = get_field("filter_property_bedrooms", "option");
    for ($i = 1;$i < $property_bedrooms_cnt;$i++)
    {
        if ((isset($_GET['bed']) && $_GET['bed'] != '') && $_GET['bed'] == $i)
        {
            $opt_html .= '<option value="' . $i . '" selected="selected">' . $i . '+</option>';
        }
        else
        {
            $opt_html .= '<option value="' . $i . '">' . $i . '+</option>';
        }

    }
    $opt_html .= '</select>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-col price-filter">';
    $opt_html .= '<div class="price-label">Price</div>';
    $opt_html .= '<div class="select-price">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label">Price Max</label>';
    $opt_html .= '<div class="filter-menu">';
    $opt_html .= '<select class="selectpicker maxprice sales" id="maxprice" >';
    $opt_html .= '<option value="" class="mob-max">no max</option>';
    if (get_field("filter_property_price", "option"))
    {
        while (has_sub_field("filter_property_price", "option"))
        {
            if ((isset($_GET['maxp']) && $_GET['maxp'] != '') && $_GET['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use", "option") . '" selected>£' . get_sub_field("filter_add_price_option", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use", "option") . '">£' . get_sub_field("filter_add_price_option", "option") . '</option>';
            }
        }
    }
    $opt_html .= '</select>';
    $opt_html .= '<select class="selectpicker maxprice rent" id="maxprice" >';
    $opt_html .= '<option value="" disabled class="rent_option">Per Week</option>';
    $opt_html .= '<option value="" class="mob-max">no max</option>';
    if (get_field("filter_property_price_rent", "option"))
    {
        while (has_sub_field("filter_property_price_rent", "option"))
        {
            if ((isset($_GET['maxp']) && $_GET['maxp'] != '') && $_GET['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use_rent", "option") . '" selected>£' . get_sub_field("filter_add_price_option_rent", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use_rent", "option") . '">£' . get_sub_field("filter_add_price_option_rent", "option") . '</option>';
            }
        }
    }
    $opt_html .= '</select>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row first-row hide">';

    $opt_html .= '<div class="filter-col">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label hide-label">Buy/Rent</label>';
    $opt_html .= '<div class="filter-menu deptbox">';
    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && ($_GET['dpt'] == 'sale' || $_GET['dpt'] == 'new_home'))
    {
        $opt_html .= '<label class="material_radio_group checked" for="radio1">';
        $opt_html .= '<input type="radio" name="dp" id="radio1" class="material_radiobox" value="' . $_GET['dpt'] . '" checked >';
        $opt_html .= '<span class="material_check_radio"></span>Buy';
        $opt_html .= '</label>';
    }
    else if (!isset($_GET['dpt']))
    {
        $opt_html .= '<label class="material_radio_group checked" for="radio1" >';
        $opt_html .= '<input type="radio" name="dp" id="radio1" class="material_radiobox" value="sale" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Buy';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="Buy">';
        $opt_html .= '<input type="radio" name="dp" id="Buy" class="material_radiobox" value="sale">';
        $opt_html .= '<span class="material_check_radio"></span>Buy';
        $opt_html .= '</label> ';
    }
    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && $_GET['dpt'] == 'letting')
    {
        $opt_html .= '<label class="material_radio_group checked" for="radio2" checked>';
        $opt_html .= '<input type="radio" name="dp" id="radio2" class="material_radiobox" value="letting" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Rent';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="radio2">';
        $opt_html .= '<input type="radio" name="dp" id="radio2" class="material_radiobox" value="letting" >';
        $opt_html .= '<span class="material_check_radio"></span>Rent';
        $opt_html .= '</label>';
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-col">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label">Bedrooms</label>';
    $opt_html .= '<div class="filter-menu">';
    $opt_html .= '<select class="selectpicker selectbeds" name="bed">';
    $opt_html .= '<option value="" class="mob-min">no min</option>';
    $property_bedrooms_cnt = get_field("filter_property_bedrooms", "option");
    for ($i = 1;$i < $property_bedrooms_cnt;$i++)
    {
        if ((isset($_GET['bed']) && $_GET['bed'] != '') && $_GET['bed'] == $i)
        {
            $opt_html .= '<option value="' . $i . '" selected="selected">' . $i . '+</option>';
        }
        else
        {
            $opt_html .= '<option value="' . $i . '">' . $i . '+</option>';
        }
    }
    $opt_html .= '</select>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-col price-filter min">';
    $opt_html .= '<div class="price-label">Price Min</div>';
    $opt_html .= '<div class="select-price">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label">Price Min:</label>';
    $opt_html .= '<div class="filter-menu">';
    $opt_html .= '<select class="selectpicker minprice sales" id="minprice" >';
    $opt_html .= '<option value="" class="mob-min">no min</option>';
    if (get_field("filter_property_price", "option"))
    {
        while (has_sub_field("filter_property_price", "option"))
        {
            if ((isset($_GET['minp']) && $_GET['minp'] != '') && $_GET['minp'] == get_sub_field("filter_add_price_option_use", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use", "option") . '" selected>£' . get_sub_field("filter_add_price_option", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use", "option") . '">£' . get_sub_field("filter_add_price_option", "option") . '</option>';
            }

        }
    }
    $opt_html .= '</select>';
    $opt_html .= '<select class="selectpicker minprice rent" id="minprice" >';
    $opt_html .= '<option value="" disabled class="rent_option">Per Week</option>';
    $opt_html .= '<option value="" class="mob-min">no min</option>';
    if (get_field("filter_property_price_rent", "option"))
    {
        while (has_sub_field("filter_property_price_rent", "option"))
        {
            if ((isset($_GET['maxp']) && $_GET['maxp'] != '') && $_GET['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use_rent", "option") . '" selected>£' . get_sub_field("filter_add_price_option_rent", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use_rent", "option") . '">£' . get_sub_field("filter_add_price_option_rent", "option") . '</option>';
            }
        }
    }
    $opt_html .= '</select>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '<div class="filter-col price-filter max">';
    $opt_html .= '<div class="price-label">Price Max</div>';
    $opt_html .= '<div class="select-price">';
    $opt_html .= '<div class="form-group max-grp">';
    $opt_html .= '<label class="label">Price Max:</label>';
    $opt_html .= '<div class="filter-menu">';
    $opt_html .= '<select class="selectpicker maxprice sales" id="maxprice" >';
    $opt_html .= '<option value="" class="mob-max">no max</option>';
    if (get_field("filter_property_price", "option"))
    {
        while (has_sub_field("filter_property_price", "option"))
        {
            if ((isset($_GET['maxp']) && $_GET['maxp'] != '') && $_GET['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use", "option") . '" selected>£' . get_sub_field("filter_add_price_option", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use", "option") . '">£' . get_sub_field("filter_add_price_option", "option") . '</option>';
            }
        }
    }
    $opt_html .= '</select>';
    $opt_html .= '<select class="selectpicker maxprice rent" id="maxprice" >';
    $opt_html .= '<option value="" disabled class="rent_option">Per Week</option>';
    $opt_html .= '<option value="" class="mob-max">no max</option>';
    if (get_field("filter_property_price_rent", "option"))
    {
        while (has_sub_field("filter_property_price_rent", "option"))
        {
            if ((isset($_GET['maxp']) && $_GET['maxp'] != '') && $_GET['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use_rent", "option") . '" selected>£' . get_sub_field("filter_add_price_option_rent", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_price_option_use_rent", "option") . '">£' . get_sub_field("filter_add_price_option_rent", "option") . '</option>';
            }
        }
    }
    $opt_html .= '</select>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-col price-filter">';
    $opt_html .= '<div class="price-label">ft<sup>2</sup>/m<sup>2</sup></div>';
    $opt_html .= '<div class="select-price">';
    $opt_html .= '<div class="form-group">';
    //$opt_html .='<label class="label">Sq</sup></label>';
    $opt_html .= '<div class="filter-menu">';

    if (!isset($_GET['psq_ft']) && !isset($_GET['psq_m']))
    {
        $opt_html .= '<label class="material_radio_group checked" for="size_radio1">';
        $opt_html .= '<input type="radio" name="sq_ft" id="size_radio1" class="material_radiobox" value="sq_ft" checked >';
        $opt_html .= '<span class="material_check_radio"></span>ft<sup>2</sup>';
        $opt_html .= '</label>';
    }
    else if (isset($_GET['psq_ft']) && $_GET['psq_ft'] != '')
    {
        $opt_html .= '<label class="material_radio_group checked" for="size_radio1">';
        $opt_html .= '<input type="radio" name="sq_ft" id="size_radio1" class="material_radiobox" value="sq_ft" checked >';
        $opt_html .= '<span class="material_check_radio"></span>ft<sup>2</sup>';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="size_radio1">';
        $opt_html .= '<input type="radio" name="sq_ft" id="size_radio1" class="material_radiobox" value="sq_ft" >';
        $opt_html .= '<span class="material_check_radio"></span>ft<sup>2</sup>';
        $opt_html .= '</label>';
    }
    if (isset($_GET['psq_m']) && $_GET['psq_m'] != '')
    {
        $opt_html .= '<label class="material_radio_group checked" for="size_radio2">';
        $opt_html .= '<input type="radio" name="sq_ft" id="size_radio2" class="material_radiobox" value="m2" checked>';
        $opt_html .= '<span class="material_check_radio"></span>
                                    m2<sup>2</sup>';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="size_radio2">';
        $opt_html .= '<input type="radio" name="sq_ft" id="size_radio2" class="material_radiobox" value="m2" >';
        $opt_html .= '<span class="material_check_radio"></span>
                                m<sup>2</sup>';
        $opt_html .= '</label>';
    }

    if (!isset($_GET['psq_ft']) && !isset($_GET['psq_m']))
    {
        $ftshowbox = "showft";
        $mshowbox = "hidem";
    }
    else if (isset($_GET['psq_ft']) && $_GET['psq_ft'] != '')
    {
        $ftshowbox = "showft";
        $mshowbox = "hidem";
    }
    else if (isset($_GET['psq_m']) && $_GET['psq_m'] != '')
    {
        $mshowbox = "showm";
        $ftshowbox = "hideft";
    }
    $opt_html .= '<select class="selectpicker property-size sq_ft ' . $ftshowbox . '">';

    $opt_html .= '<option value="" class="mob-min">no min</option>';
    if (get_field("filter_property_size", "option"))
    {
        while (has_sub_field("filter_property_size", "option"))
        {

            if ((isset($_GET['psq_ft']) && $_GET['psq_ft'] != '') && $_GET['psq_ft'] == get_sub_field("filter_add_property_size", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_property_size", "option") . '" selected>' . get_sub_field("filter_add_property_size", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_property_size", "option") . '">' . get_sub_field("filter_add_property_size", "option") . '</option>';
            }

        }
    }
    $opt_html .= '</select>';

    $opt_html .= '<select class="selectpicker property-size sq_m ' . $mshowbox . '" >';
    $opt_html .= '<option value="" class="mob-min">no min</option>';
    if (get_field("filter_property_size_m", "option"))
    {
        while (has_sub_field("filter_property_size_m", "option"))
        {

            if ((isset($_GET['psq_m']) && $_GET['psq_m'] != '') && $_GET['psq_m'] == get_sub_field("filter_add_property_size_m", "option"))
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_property_size_m", "option") . '" selected>' . get_sub_field("filter_add_property_size_m", "option") . '</option>';
            }
            else
            {
                $opt_html .= '<option value="' . get_sub_field("filter_add_property_size_m", "option") . '">' . get_sub_field("filter_add_property_size_m", "option") . '</option>';
            }

        }
    }
    $opt_html .= '</select>';

    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row hide">';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label label-col">Type</label>';
    $opt_html .= '<div class="filter-menu property_style">';
    $property_style = get_field("filter_property_style", "option");
    $s = 0;
    foreach ($property_style as $_p_style)
    {
        if (isset($_GET['ptype']) && $_GET['ptype'] != '')
        {
            $pstyles = explode(",", $_GET['ptype']);

            $opt_html .= '<div class="top-checkbox">';
            if (in_array($_p_style, $pstyles))
            {
                $opt_html .= '<input type="checkbox" name="pstyle[]" id="' . $_p_style . '" class="material_radiobox" value="' . $_p_style . '" checked>';
                $opt_html .= '<label class="material_radio_group" for="' . $_p_style . '">';
                $opt_html .= $_p_style;
                $opt_html .= '</label>';
            }
            else
            {
                $opt_html .= '<input type="checkbox" name="pstyle[]" id="' . $_p_style . '" class="material_radiobox" value="' . $_p_style . '">';
                $opt_html .= '<label class="material_radio_group" for="' . $_p_style . '">';
                $opt_html .= $_p_style;
                $opt_html .= '</label>';
            }

            $opt_html .= '</div>';

        }
        else
        {
            $opt_html .= '<div class="top-checkbox">';
            $opt_html .= '<input type="checkbox" name="pstyle[]" id="' . $_p_style . '" class="material_radiobox" value="' . $_p_style . '">';
            $opt_html .= '<label class="material_radio_group " for="' . $_p_style . '">';
            $opt_html .= $_p_style;
            $opt_html .= '</label>';
            $opt_html .= '</div>';
        }

        $s++;
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row hide">';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label label-col">Age</label>';
    $opt_html .= '<div class="filter-menu property_age">';
    $property_age = get_field("filter_property_age", "option");
    foreach ($property_age as $_p_age)
    {
        if (isset($_GET['ptage']) && $_GET['ptage'] != '')
        {
            $_p_ages = explode(",", $_GET['ptage']);
            $opt_html .= '<div class="top-checkbox">';
            if (in_array($_p_age, $_p_ages))
            {
                $opt_html .= '<input type="checkbox" name="prtage[]" id="' . $_p_age . '" class="material_radiobox" value="' . $_p_age . '" checked>';
                $opt_html .= '<label class="material_radio_group" for="' . $_p_age . '">';
                $opt_html .= $_p_age;
                $opt_html .= '</label>';
            }
            else
            {
                $opt_html .= '<input type="checkbox" name="prtage[]" id="' . $_p_age . '" class="material_radiobox" value="' . $_p_age . '">';
                $opt_html .= '<label class="material_radio_group" for="' . $_p_age . '">';
                $opt_html .= $_p_age;
                $opt_html .= '</label>';
            }
            $opt_html .= '</div>';
        }
        else
        {
            $opt_html .= '<div class="top-checkbox">';
            $opt_html .= '<input type="checkbox" name="prtage[]" id="' . $_p_age . '" class="material_radiobox" value="' . $_p_age . '">';
            $opt_html .= '<label class="material_radio_group" for="' . $_p_age . '">';
            $opt_html .= $_p_age;
            $opt_html .= '</label>';
            $opt_html .= '</div>';
        }
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row hide Furnishing-col" >';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label label-col">Furnishing</label>';
    $opt_html .= '<div class="filter-menu property_furnishing">';
    $property_furt = get_field("filter_property_furnishing", "option");
    foreach ($property_furt as $_p_furt)
    {
        if (isset($_GET['pfun']) && $_GET['pfun'] != '')
        {
            $_p_fun = explode(",", $_GET['pfun']);
            if (in_array($_p_furt, $_p_fun))
            {
                $opt_html .= '<div class="top-checkbox">';
                $opt_html .= '<input type="checkbox" name="furnishing[]" id="' . $_p_furt . '" class="material_radiobox" value="' . $_p_furt . '" checked>';
                $opt_html .= '<label class="material_radio_group checked" for="' . $_p_furt . '">';
                $opt_html .= $_p_furt;
                $opt_html .= '</label>';
                $opt_html .= '</div>';
            }
            else
            {
                $opt_html .= '<div class="top-checkbox">';

                $opt_html .= '<input type="checkbox" name="furnishing[]" id="' . $_p_furt . '" class="material_radiobox" value="' . $_p_furt . '">';
                $opt_html .= '<label class="material_radio_group" for="' . $_p_furt . '">';
                $opt_html .= $_p_furt;
                $opt_html .= '</label>';
                $opt_html .= '</div>';

            }
        }
        else
        {
            $opt_html .= '<div class="top-checkbox">';

            $opt_html .= '<input type="checkbox" name="furnishing[]" id="' . $_p_furt . '" class="material_radiobox" value="' . $_p_furt . '">';
            $opt_html .= '<label class="material_radio_group" for="' . $_p_furt . '">';
            $opt_html .= $_p_furt;
            $opt_html .= '</label>';
            $opt_html .= '</div>';
        }
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<label class="label label-col">Pet-Friendly</label>';
    $opt_html .= '<div class="filter-menu property_pet">';
    if ((isset($_GET['petfdy']) && $_GET['petfdy'] != '') && $_GET['petfdy'] == 'yes')
    {
        $opt_html .= '<label class="material_radio_group checked" for="Petyes">';
        $opt_html .= '<input type="radio" name="petfriendly" id="Petyes" class="material_radiobox" value="yes" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Yes';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="Petyes">';
        $opt_html .= '<input type="radio" name="petfriendly" id="Petyes" class="material_radiobox" value="yes" >';
        $opt_html .= '<span class="material_check_radio"></span>Yes';
        $opt_html .= '</label>';
    }
    if ((isset($_GET['petfdy']) && $_GET['petfdy'] != '') && $_GET['petfdy'] == 'no')
    {
        $opt_html .= '<label class="material_radio_group checked" for="PetNo">';
        $opt_html .= '<input type="radio" name="petfriendly" id="PetNo" class="material_radiobox" value="no" checked>';
        $opt_html .= '<span class="material_check_radio"></span>No';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="PetNo">';
        $opt_html .= '<input type="radio" name="petfriendly" id="PetNo" class="material_radiobox" value="no" >';
        $opt_html .= '<span class="material_check_radio"></span>No';
        $opt_html .= '</label>';
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row hide">';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<div class="checkboxrow hide">';
    $opt_html .= '<label class="label-col">Amenities</label>';
    $opt_html .= '<span class="arrow"><i class="fa fa-angle-down"></i></span>';
    $opt_html .= '<div class="checkbox-group">';
    $opt_html .= '<div class="checkbo-col">';
    $property_amty = get_field("filter_property_amenities", "option");
    $a = 1;
    foreach ($property_amty as $_p_amty)
    {
        $opt_html .= '<div class="material_checkbox_group">';

        if (isset($_GET['pamty']) && $_GET['pamty'] != '')
        {
            $pamty = explode(",", $_GET['pamty']);
            if (in_array($_p_amty, $pamty))
            {
                $opt_html .= '<input type="checkbox" value="' . $_p_amty . '" id="' . $_p_amty . '" name="pamity[]" class="material_checkbox material_checkbox_info" checked>';
                $opt_html .= '<label class="material_label_checkbox checked" for="' . $_p_amty . '">' . $_p_amty . '</label>';
            }
            else
            {
                $opt_html .= '<input type="checkbox" value="' . $_p_amty . '" id="' . $_p_amty . '" name="pamity[]" class="material_checkbox material_checkbox_info">';
                $opt_html .= '<label class="material_label_checkbox" for="' . $_p_amty . '">' . $_p_amty . '</label>';
            }
        }
        else
        {
            $opt_html .= '<input type="checkbox" value="' . $_p_amty . '" id="' . $_p_amty . '" name="pamity[]" class="material_checkbox material_checkbox_info">';
            $opt_html .= '<label class="material_label_checkbox" for="' . $_p_amty . '">' . $_p_amty . '</label>';
        }

        $opt_html .= '</div>';
        if ($a % 6 == 0)
        {
            $opt_html .= '</div><div class="checkbo-col">';
        }

        $a++;
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    
    $opt_html .= '<div class="filter-row">';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    $opt_html .= '<div class="checkboxrow">';
    $opt_html .= '<label class="label hide-label">Browse by areas<span class="browse-value">(Buy)</span></label>';
    $opt_html .= '<span class="arrow"><i class="fa fa-angle-down"></i></span>';
    $opt_html .= '<div class="checkbox-group ami-filter">';
    $opt_html .= '<div class="checkbo-col">';
    $property_area_ = get_field("property_areas", "option");
    $a = 1;
    // echo "<pre> ";
    // print_r($property_amty);
    // exit;

    if (property_area_){
        while (has_sub_field("property_areas", "option")){
            $opt_html .= '<div class="material_checkbox_group">';
            if (!isset($_GET['dpt']) && !isset($_GET['pstus']))
            {
                
               
                    $opt_html .= '<input type="checkbox" value="' . get_sub_field("filter_property_area", "option") . '" id="' . get_sub_field("filter_property_area", "option") . '" name="pareas[]" class="material_checkbox material_checkbox_info">';
                    $opt_html .= '<label class="material_label_checkbox" for="' . get_sub_field("filter_property_area", "option") . '">' . get_sub_field("filter_property_area", "option"). '</label>';
            
            }
            else
            {
                $opt_html .= '<input type="checkbox" value="' . get_sub_field("filter_property_area", "option") . '" id="' . get_sub_field("filter_property_area", "option") . '" name="pareas[]" class="material_checkbox material_checkbox_info">';
                $opt_html .= '<label class="material_label_checkbox" for="' . get_sub_field("filter_property_area", "option") . '">' . get_sub_field("filter_property_area", "option"). '</label>';
            }
            $opt_html .= '</div>';
            if ($a % 6 == 0)
            {
                $opt_html .= '</div><div class="checkbo-col">';
            }

            $a++;
        }
    }

    
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="filter-row hide">';
    $opt_html .= '<div class="filter-col full-width">';
    $opt_html .= '<div class="form-group">';
    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && $_GET['dpt'] == 'letting'){
        $opt_html .= '<label class="label label-col isl">Recently Let</label>';    
    }else{
        $opt_html .= '<label class="label label-col isl">Recent Sales</label>';    
    }
    
    $opt_html .= '<div class="filter-menu sold-filter">';
    if ((isset($_GET['pstus']) && $_GET['pstus'] != '') && $_GET['pstus'] == 'exclude')
    {
        $opt_html .= '<label class="material_radio_group checked" for="soldno">';
        $opt_html .= '<input type="radio" name="sold" id="soldno" class="material_radiobox" value="exclude" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Exclude';
        $opt_html .= '</label>';
    }
    else if (!isset($_GET['pstus']))
    {
        $opt_html .= '<label class="material_radio_group checked" for="soldno">';
        $opt_html .= '<input type="radio" name="sold" id="soldno" class="material_radiobox" value="exclude" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Exclude';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="soldno">';
        $opt_html .= '<input type="radio" name="sold" id="soldno" class="material_radiobox" value="exclude">';
        $opt_html .= '<span class="material_check_radio"></span>Exclude';
        $opt_html .= '</label>';
    }
    if ((isset($_GET['pstus']) && $_GET['pstus'] != '') && $_GET['pstus'] == 'include')
    {
        $opt_html .= '<label class="material_radio_group checked" for="soldyes">';
        $opt_html .= '<input type="radio" name="sold" id="soldyes" class="material_radiobox" value="include" checked>';
        $opt_html .= '<span class="material_check_radio"></span>Include';
        $opt_html .= '</label>';
    }
    else
    {
        $opt_html .= '<label class="material_radio_group" for="soldyes">';
        $opt_html .= '<input type="radio" name="sold" id="soldyes" class="material_radiobox" value="include">';
        $opt_html .= '<span class="material_check_radio"></span>Include';
        $opt_html .= '</label>';
    }
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';

    $opt_html .= '<div class="btn-group">';

    $opt_html .= '<button type="button" class="btn btn-default search-btn">search</button>';
    $opt_html .= '<button type="button" class="btn btn-default advanced-search-btn">Advanced search</button>';
    $opt_html .= '</div>';
    $opt_html .= '</div>';
    

    $opt_html .= '</form>';
    $opt_html .= '</div>';

    return $opt_html;

}

function Property_Filter_data($filter_opt)
{

    $psty = array();
    $pstus = '';
    $bed = '';
    $maxp = '';
    $minp = '';
    $psq_ft = '';
    $psq_m = '';
    $ptage = array();
    $pfun = array();
    $parea = '';
    $pamty = array();
    $_specialpamty = array();
    $pareasize = '';
    $petfdy = '';
    $area = array();
    $_area = array();
    $loc_name = '';
    $new_home = '';
    $no_disply_status_prt = array();
    $current_currency_price = '';
    $price_order_meta_key = '';
    $breadcum_text = '';
    $subplot = '';
    $mainproperty = '';
    if (get_current_user_id() != '')
    {
        $logged_user_id = get_current_user_id();
    }
    else
    {
        $logged_user_id = '';
    }

    if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
    {
        $_depname = "residential-sales";
        $subplot = array(
            'relation' => 'OR',
            array(
                'key' => '_IsSubPlot',
                'value' => 1,
                'compare' => '==',
            ) ,
            array(
                'key' => '_SubPlots',
                'compare' => 'NOT EXISTS',
            ) ,
        );

    }
    else if ($filter_opt['dpt'] == "letting")
    {
        $_depname = "residential-lettings";
        $subplot = array(
            'relation' => 'OR',
            array(
                'key' => '_IsSubPlot',
                'value' => 1,
                'compare' => '==',
            ) ,
            array(
                'key' => '_SubPlots',
                'compare' => 'NOT EXISTS',
            ) ,
        );
    }

    if (isset($filter_opt['ptype']))
    {
        $p_sty = array();
        $p_sty = explode(",", $filter_opt['ptype']);

        foreach ($p_sty as $_pstyle)
        {
            $psty['relation'] = 'OR';
            $psty[] = array(
                'relation' => 'OR',
                array(
                    'key' => '_property_style',
                    'value' => $_pstyle,
                    'compare' => 'Like',
                ) ,
                array(
                    'key' => '_property_type',
                    'value' => $_pstyle,
                    'compare' => '==',
                ) ,
            );
        }
    }
    if (isset($filter_opt['pstus']))
    {
        if ($filter_opt['pstus'] == "exclude")
        {
            if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
            {
                $no_disply_status_prt = array(
                    'For Sale - Unavailable',
                    'Completed - Available',
                    'Exchanged - Available',
                    'Sold',
                    'Completed',
                    'Exchanged'
                );
                $pstus = array(
                    'key' => '_InternalSaleStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );

            }
            else if ($filter_opt['dpt'] == "letting")
            {
                $no_disply_status_prt = array(
                    'Tenancy Current - Unavailable',
                    'To Let - Unavailable',
                    'Let by other agent',
                    'Sold'
                );

                $pstus = array(
                    'key' => '_InternalLettingStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );
            }

        }
        else if ($filter_opt['pstus'] == "include")
        {
            if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
            {
                $no_disply_status_prt = array(
                    'For Sale - Unavailable',
                    'Completed - Available',
                    'Exchanged - Available'
                );
                $pstus = array(
                    'key' => '_InternalSaleStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );

            }
            else if ($filter_opt['dpt'] == "letting")
            {
                $no_disply_status_prt = array(
                    'Tenancy Current - Unavailable',
                    'To Let - Unavailable',
                    'Let by other agent'
                );

                $pstus = array(
                    'key' => '_InternalLettingStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );
            }
        }
    }

    if (isset($filter_opt['bed']))
    {
        $bed = array(
            'key' => '_bedrooms',
            'value' => $filter_opt['bed'],
            'compare' => '>=',
        );
    }
    if (isset($filter_opt['maxp']))
    {
        if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
        {
            $maxp = array(
                'key' => '_price',
                'value' => $filter_opt['maxp'],
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }
        else if ($filter_opt['dpt'] == "letting")
        {
            $maxp = array(
                'key' => '_rent',
                'value' => $filter_opt['maxp'],
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        $_maxp = '';
        if (get_field("filter_property_price", "option"))
        {
            while (has_sub_field("filter_property_price", "option"))
            {
                if ($filter_opt['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
                {
                    $_maxp = '£' . get_sub_field("filter_add_price_option", "option");
                }
            }
        }
    }
    if (isset($filter_opt['minp']))
    {
        if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
        {
            $minp = array(
                'key' => '_price',
                'value' => $filter_opt['minp'],
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
        else if ($filter_opt['dpt'] == "letting")
        {
            $minp = array(
                'key' => '_rent',
                'value' => $filter_opt['minp'],
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }

        $_minp = '';
        if (get_field("filter_property_price", "option"))
        {
            while (has_sub_field("filter_property_price", "option"))
            {
                if ($filter_opt['minp'] == get_sub_field("filter_add_price_option_use", "option"))
                {
                    $_minp = '£' . get_sub_field("filter_add_price_option", "option");
                }
            }
        }
    }
    if (isset($filter_opt['psq_ft']))
    {
        $psq_ft = str_replace("Over", "", str_replace(",", "", $filter_opt['psq_ft']));
        $psq_ft = explode("-", $psq_ft);

        if (count($psq_ft) == 1 && $psq_ft[0] == 8000)
        {
            $pareasize = array(
                'key' => '_size',
                'value' => $psq_ft[0],
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
        else if (count($psq_ft) == 2)
        {
            $pareasize = array(
                'relation' => 'AND',
                array(
                    'key' => '_size',
                    'value' => $psq_ft[0],
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ) ,
                array(
                    'key' => '_size',
                    'value' => $psq_ft[1],
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                )
            );
        }
    }
    if (isset($filter_opt['psq_m']))
    {
        $psq_m = str_replace("Over", "", str_replace(",", "", $filter_opt['psq_m']));
        $psq_m = explode("-", $psq_m);

        if (count($psq_m) == 1 && $psq_m[0] == 750)
        {
            $pareasize = array(
                'key' => '_size_m',
                'value' => $psq_m[0],
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
        else if (count($psq_m) == 2)
        {
            $pareasize = array(
                'relation' => 'AND',
                array(
                    'key' => '_size_m',
                    'value' => $psq_m[0],
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ) ,
                array(
                    'key' => '_size_m',
                    'value' => $psq_m[1],
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                )
            );
        }
    }
    if (isset($filter_opt['ptage']))
    {
        $p_age = array();
        $p_age = explode(",", $filter_opt['ptage']);

        foreach ($p_age as $_p_age)
        {
            $_age = explode(" ", $_p_age);
            $ptage['relation'] = 'OR';
            $ptage[] = array(
                'key' => '_property_age',
                'value' => $_age[0],
                'compare' => 'Like',
            );
        }
    }
    if (isset($filter_opt['pfun']))
    {
        $pfun_arr = array();
        $pfun_arr = explode(",", $filter_opt['pfun']);

        foreach ($pfun_arr as $key => $_pfun)
        {

            $pfun['relation'] = 'AND';
            $pfun[] = array(
                'key' => '_furnishing',
                'value' => $_pfun,
                'compare' => 'Like',
            );
        }
    }
    if (isset($filter_opt['parea']))
    {
        $p_area = explode(",",$filter_opt['parea']);
        $breadcum_text = "in " . ucwords(preg_replace('/\\\\/i', '', $filter_opt['parea']));
        
        if($p_area[0] == "Regents Park" || $p_area[0] == "regents park")
        {
            $p_ser = "Regent&#039;s Park";    
        }else if(preg_replace('/\\\\/i', '',$p_area[0]) == "Queen's Park" || preg_replace('/\\\\/i', '',$p_area[0]) == "queen's park" )
        {
            $p_ser = "Queens Park";    
        }else if($p_area[0] == "St Johns Wood" || $p_area[0] == "st johns wood" || preg_replace('/\\\\/i', '',$p_area[0]) == "St. John's Wood")
        {
            $p_ser = "St John&#039;s Wood";    
        }else if($p_area[0] == "St Edmund’s Terrace" || $p_area[0] == "st edmund’s terrace" || $p_area[0] == "st edmunds terrace" || preg_replace('/\\\\/i', '',$p_area[0]) == "St Edmund’s Terrace")
        {
            $p_ser = "St Edmund&#039;s Terrace";    
        }else
        {
            $p_ser = str_replace("\'", "&#039;", ucwords(preg_replace('/\\\\/i', '',$p_area[0])));
            $p_ser = htmlentities($p_ser, ENT_QUOTES);
        }
        
        
        $parea = array(
            'relation' => 'OR',
             array(
                'key' => '_address_street',
                'value' => $p_ser,
                'compare' => 'Like',
            ) ,
            array(
                'key' => '_address_two',
                'value' => $p_ser,
                'compare' => 'Like',
            ) ,
            array(
                'key' => '_address_three',
                'value' => $p_ser,
                'compare' => 'Like',
            ) ,
            array(
                'key' => '_address_postcode',
                'value' => $p_ser,
                'compare' => 'Like',
            )
        );

    }
    if (isset($filter_opt['pamty']))
    {
        $pamty_arr = array();
        $pamty_arr = explode(",", $filter_opt['pamty']);
        $special_amty_arr = array();
        if (in_array("Garage/Parking", $pamty_arr))
        {
            array_push($special_amty_arr, "Resident Parking", "Off Street Parking", "Garage", "Double Garage", "Triple Garage");
            unset($pamty_arr[array_search('Garage/Parking', $pamty_arr) ]);
        }
        if (in_array("Concierge/Porterage", $pamty_arr))
        {
            array_push($special_amty_arr, "Porterage", "Concierge");
            unset($pamty_arr[array_search('Concierge/Porterage', $pamty_arr) ]);
        }
        if (in_array("Air Cooling System", $pamty_arr))
        {
            array_push($special_amty_arr, "Air Conditioning", "Comfort Cooling");
            unset($pamty_arr[array_search('Air Cooling System', $pamty_arr) ]);
        }
        if (in_array("Security System/CCTV", $pamty_arr))
        {
            array_push($special_amty_arr, "Security System", "CCTV");
            unset($pamty_arr[array_search('Security System/CCTV', $pamty_arr) ]);
        }
        //print_r($special_amty_arr);
        foreach ($pamty_arr as $key => $_amty)
        {

            $pamty['relation'] = 'AND';
            $pamty[] = array(
                'key' => '_property_all_keywords',
                'value' => $_amty,
                'compare' => 'Like',
            );
        }
        foreach ($special_amty_arr as $_special_amty)
        {
            $_specialpamty['relation'] = 'OR';
            $_specialpamty[] = array(
                'key' => '_property_all_keywords',
                'value' => $_special_amty,
                'compare' => 'Like',
            );
        }

    }
    if (isset($filter_opt['petfdy']))
    {
        if ($filter_opt['petfdy'] == 'yes')
        {
            $petfdy = array(
                'key' => '_property_amenities',
                'value' => "Pets",
                'compare' => 'Like',
            );
        }
        else if ($filter_opt['petfdy'] == 'no')
        {
            $petfdy = '';
        }
    }
    if (isset($filter_opt['area']))
    {
        $loc_name = "in " . '<strong>' . str_replace("\'", '&#039;', $filter_opt['area']) . '</strong>';

        $_area = str_replace("\'", "&#039;", ucwords($filter_opt['area']));
        $area = array(
            'relation' => 'OR',
            array(
                'key' => '_address_two',
                'value' => $_area,
                'compare' => '==',
            ) ,
            array(
                'key' => '_address_three',
                'value' => $_area,
                'compare' => '==',
            )
        );

    }
    if (isset($filter_opt['srtbyprice']))
    {
        if ($filter_opt['srtbyprice'] == "low" || $filter_opt['srtbyprice'] == "high")
        {
            if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
            {
                $price_order_meta_key = "_price";

            }
            else if ($filter_opt['dpt'] == "letting")
            {
                $price_order_meta_key = "_rent";

            }
            $orderby = "meta_value_num";
        }
        else
        {
            $orderby = "meta_value";
            $price_order_meta_key = '_TimeAmended';

        }
        if ($filter_opt['srtbyprice'] == "low")
        {
            $order = "ASC";
        }
        else if ($filter_opt['srtbyprice'] == "high")
        {

            $order = "DESC";
        }
        else if ($filter_opt['srtbyprice'] == "recent")
        {

            $order = "DESC";
        }

    }
    else
    {
        $orderby = "meta_value";
        $price_order_meta_key = '_TimeAmended';
        $order = "DESC";
    }

    if ($filter_opt['dpt'] == "new_home")
    {
        $new_home = array(
            'key' => '_is_new_home_property',
            'value' => "yes",
            'compare' => '==',
        );
    }
    if (isset($filter_opt['cur']))
    {
        $current_currency_price = currency_conveter($filter_opt['cur']);
    }
    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $_args = array(
        'paged' => $paged,
        'post_type' => 'property',
        'posts_per_page' => 39,
        'post_status' => 'publish',
        'meta_key' => $price_order_meta_key,
        'orderby' => $orderby,
        'order' => $order,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_department',
                'value' => $_depname,
                'compare' => '==',
            ) ,
            $bed,
            $parea,
            $pamty,
            $_specialpamty,
            $pfun,
            $ptage,
            $minp,
            $maxp,
            $pstus,
            $psty,
            $pareasize,
            $petfdy,
            $area,
            $_area,
            $new_home,
            $subplot,
        ) ,
    );

    add_filter('posts_where', 'title_filter', 10, 2);
    $_proty = new WP_Query($_args);
   /* echo "<pre>";
     print_r($_proty);*/

    remove_filter('posts_where', 'title_filter', 10);

    $filter_html = '';

    $filter_html .= '<section class="list_top_breadcrumb">';
    $filter_html .= '<div class="container-fluid">';
    $filter_html .= '<div class="row">';
    $filter_html .= '<div class="col-md-12">';
    if($_proty->found_posts == 1){ $home_txt = 'home'; }else{ $home_txt = 'homes'; }
    if ($filter_opt['dpt'] == "letting")
    {

        $filter_html .= '<h1>' . $_proty->found_posts . ' '.$home_txt.' for Rent ' . $loc_name . ' ' . $breadcum_text . '</h1>';
    }
    else if ($filter_opt['dpt'] == "sale")
    {
        $filter_html .= '<h1>' . $_proty->found_posts . ' '.$home_txt.' for ' . ucwords(str_replace("_", " ", $filter_opt['dpt'])) . ' ' . $loc_name . ' ' . $breadcum_text . '</h1>';
    }
    else if ($filter_opt['dpt'] == "new_home")
    {
        $filter_html .= '<h1>' . $_proty->found_posts . ' NEW '.$home_txt.' AVAILABLE</h1>';
    }
    $filter_html .= '</div>';
    $filter_html .= '</div>';
    $filter_html .= '</div>';
    $filter_html .= '</section>';

    /* Top Search */

    $filter_html .= '<section class="wow1 fadeInUp1" >';
    $filter_html .= '<div class="top_breadcrumb">';
    $filter_html .= '<div class="container-fluid">';
    $filter_html .= '<div class="row">';
    $filter_html .= '<div class="col-md-12">';
    $filter_html .= '<ul class="menu list-inline">';
    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && $_GET['dpt'] == 'letting'){
        $filter_html .= '<li><a href="javascript:void(0);">RECENTLY LET / <span>' . ucwords($filter_opt['pstus']) . '</span></a></li>';
    }
    else{
        $filter_html .= '<li><a href="javascript:void(0);">RECENT SALES / <span>' . ucwords($filter_opt['pstus']) . '</span></a></li>';    
    }
    
    if ((isset($_minp) && $_minp != '') && (isset($_maxp) && $_maxp != ''))
    {
        $filter_html .= '<li><a href="javascript:void(0);">PRICE / <span>' . strtoupper($_minp) . ' - ' . strtoupper($_maxp) . '</span></a></li>';
    }
    else if (isset($_minp) && $_minp != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">PRICE / <span>' . strtoupper($_minp) . '</span></a></li>';
    }
    else if (isset($_maxp) && $_maxp != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">PRICE / <span>' . strtoupper($_maxp) . '</span></a></li>';
    }
    if (isset($filter_opt['area']) && $filter_opt['area'] != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">LOCATION / <span>' . stripslashes($filter_opt['area']) . '</span></a></li>';
    }
    if (isset($filter_opt['ptype']) && $filter_opt['ptype'] != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">TYPE / <span>' . ucwords(str_replace(",",", ",$filter_opt['ptype'])) . '</span></a></li>';
    }
    if (isset($filter_opt['bed']) && $filter_opt['bed'] != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">BEDROOMS / <span>' . $filter_opt['bed'] . '+</span></a></li>';
    }

    if (isset($filter_opt['pfun']) && $filter_opt['pfun'] != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">FURNISHING / <span>' . $filter_opt['pfun'] . '</span></a></li>';
    }
    if (isset($filter_opt['petfdy']) && $filter_opt['petfdy'] != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">PET-FRIENDLY / <span>' . ucwords($filter_opt['petfdy']) . '</span></a></li>';
    }
    if (isset($filter_opt['ptage']) && $filter_opt['ptage'] != '')
    {
        $filter_html .= '<li><a href="javascript:void(0);">AGE / <span>' . str_replace(",",", ",$filter_opt['ptage']) . '</span></a></li>';
    }

    if (isset($filter_opt['pamty']))
    {
        $_amty_arr = explode(",", $filter_opt['pamty']);
        $filter_html .= '<li><a href="javascript:void(0);">AMENITIES / <span>' . count($_amty_arr) . '</span></a></li>';
    }

    if (isset($filter_opt['area']))
    {
        $_amty_arr = explode(",", $filter_opt['area']);
        $filter_html .= '<li><a href="javascript:void(0);">BROWSE BY AREAS / <span>' . stripslashes($filter_opt['area']) . '</span></a></li>';
    }

    $filter_html .= '</ul>';
    $filter_html .= '<ul class="list-inline map_cart_sort">';

    $filter_html .= '<li class="list_alert"><a href="javascript:void(0);" id="' . $logged_user_id . '" class="add_alert" ><img src="' . get_template_directory_uri() . '/assets/images/bell-icon.svg" alt="bell" title="bell">Save search</a></li>';
    if (!isset($filter_opt['style']))
    {
        $filter_html .= '<li><a class="mapsearch" href="javascript:void(0);" id="mapsearch" ><img src="' . get_template_directory_uri() . '/assets/images/location-icon.svg" alt="icon"  title="map">Map search</a></li>';
    }
    else
    {
        $filter_html .= '<li><a class="gridsearch" href="javascript:void(0);" id="grid" ><img src="' . get_template_directory_uri() . '/assets/images/gride.svg" alt="icon"  title="grid">Grid search</a></li>';
    }
    $filter_html .= '<li class="sortby-dropdown">';
    $filter_html .= '<img src="' . get_template_directory_uri() . '/assets/images/sort-by.svg" alt="sort" title="sort">';
    $filter_html .= '<select id="sortbyprice" name="sortbyprice" class="sortbyprice selectpicker" >';
    
    if ((isset($_GET['dpt']) && $_GET['dpt'] != '') && $_GET['dpt'] == 'letting'){
        if (isset($_GET['srtbyprice']) && $_GET['srtbyprice'] == 'high')
        {
            $filter_html .= '<option value="high" selected>High to Low</option>';
        }
        else
        {
            $filter_html .= '<option value="high">High to Low</option>';
        }
        
        if (isset($_GET['srtbyprice']) && $_GET['srtbyprice'] == 'low')
        {
            $filter_html .= '<option value="low" selected>Low to High</option>';
        }
        else
        {
            $filter_html .= '<option value="low">Low to High</option>';
        }
        
        if (isset($_GET['srtbyprice']) && $_GET['srtbyprice'] == 'recent')
        {
            $filter_html .= '<option value="recent" selected>Recently added</option>';
        }
        else
        {
            $filter_html .= '<option value="recent">Recently added</option>';
        }
    }else{
        if (isset($_GET['srtbyprice']) && $_GET['srtbyprice'] == 'recent')
        {
            $filter_html .= '<option value="recent" selected>Recently added</option>';
        }
        else
        {
            $filter_html .= '<option value="recent">Recently added</option>';
        }
    
        if (isset($_GET['srtbyprice']) && $_GET['srtbyprice'] == 'high')
        {
            $filter_html .= '<option value="high" selected>High to Low</option>';
        }
        else
        {
            $filter_html .= '<option value="high">High to Low</option>';
        }
        
        if (isset($_GET['srtbyprice']) && $_GET['srtbyprice'] == 'low')
        {
            $filter_html .= '<option value="low" selected>Low to High</option>';
        }
        else
        {
            $filter_html .= '<option value="low">Low to High</option>';
        }
    }
    
    
    $filter_html .= '</select>';
    $filter_html .= '</li>';

    if (isset($filter_opt['cur']) && $filter_opt['cur'] == 'USD')
    {
        $filter_html .= '<li class="currency">';
        $filter_html .= '<a href="javascript:void(0);" id="GBP" ><span class="black_text">£</span></a>
                                    <a href="javascript:void(0);" id="EUR" ><span class="black_text">€</span></a>
                                    <a href="javascript:void(0);" id="USD" ><span >$</span></a>';
        $filter_html .= '</li>';
    }
    else if (isset($filter_opt['cur']) && $filter_opt['cur'] == 'EUR')
    {
        $filter_html .= '<li class="currency">';
        $filter_html .= '<a href="javascript:void(0);" id="GBP" ><span class="black_text">£</span></a>
                                    <a href="javascript:void(0);" id="EUR" ><span>€</span></a>
                                    <a href="javascript:void(0);" id="USD" ><span class="black_text">$</span></a>';
        $filter_html .= '</li>';
    }
    else
    {
        $filter_html .= '<li class="currency">';
        $filter_html .= '<a href="javascript:void(0);" id="GBP" ><span>£</span></a>
                                    <a href="javascript:void(0);" id="EUR" ><span class="black_text">€</span></a>
                                    <a href="javascript:void(0);" id="USD" ><span class="black_text">$</span></a>';
        $filter_html .= '</li>';
    }
    
    $filter_html .= '</ul>';

    $filter_html .= '</div>';
    $filter_html .= '</div>';
    $filter_html .= '</div>';
    $filter_html .= '</div>';
    $filter_html .= '</section>';
    $filter_html .= '<input type="hidden" value="' . @$filter_opt['style'] . '" class="map_style" name="map_style">';
    $filter_html .= '<input type="hidden" value="' . @$logged_user_id . '" class="cur_user_id" name="cur_user_id">';
    $filter_html .= '<input type="hidden" value="' . @$filter_opt['cur'] . '" class="cur" name="cur">';
    $filter_html .= '<input type="hidden" value="' . @$filter_opt['dpt'] . '" class="dpt" name="dpt">';
    $filter_html .= '<input type="hidden" value="' . @$current_currency_price . '" class="current_currency_price" name="current_currency_price">';
    $filter_html .= '<input type="hidden" value="' . @$filter_opt['parea'] . '" class="parea" name="property_area">';

    if (!isset($filter_opt['style']))
    {

        /* Property Search Section */
        add_filter('posts_where', 'title_filter', 10, 2);
        $propty_seach_qry = new WP_Query($_args);
        remove_filter('posts_where', 'title_filter', 10);
        /*  echo "<pre>";
         print_r($propty_seach_qry);*/

        if ($propty_seach_qry->have_posts())
        {
            $filter_html .= '<section class="closely_related">';
            $filter_html .= '<div class="container">';
            $filter_html .= '<div class="row">';
            $filter_html .= '<div class="col-md-12">';
            $filter_html .= '<div class="properties-row ' . $filter_opt['dpt'] . '">';
            $filter_html .= '<div class="row">';
            $p = 1;
            $mk_block = 0;
            $seven_block = 1;
            $bool = true;

            while ($propty_seach_qry->have_posts())
            {
                $propty_seach_qry->the_post();
                $property = new PH_Property(get_the_ID());
                $ImageSlides = $property->get_gallery_attachment_ids();
                $_bathrooms = get_post_meta(get_the_ID() , '_bathrooms', true);
                $_bedrooms = get_post_meta(get_the_ID() , '_bedrooms', true);
                $_size_string = get_post_meta(get_the_ID() , '_size_string', true);
                $_SaleStatus = get_post_meta(get_the_ID() , '_SaleStatus', true);
                $_available = get_post_meta(get_the_ID() , '_available', true);
                $_currency = get_post_meta(get_the_ID() , '_currency', true);
                $_saved_prperty = get_post_meta(get_the_ID() , 'saved_prperty', true);
                $_prperty_user_id = get_post_meta(get_the_ID() , 'prperty_user_id', true);
                $_PriceString       = get_post_meta(get_the_ID(),'_price_qualifier',true);
                if ((isset($_saved_prperty) && $_saved_prperty == 1) && ($_prperty_user_id == $logged_user_id))
                {
                    $saved_cls = "active";
                    $faved_cls = 'faved';
                }
                else
                {
                    $saved_cls = "";
                    $faved_cls = '';
                }
                if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
                {
                    $_status = get_post_meta(get_the_ID() , '_InternalSaleStatus', true);
                }
                else if ($filter_opt['dpt'] == "letting")
                {
                    $_status = get_post_meta(get_the_ID() , '_InternalLettingStatus', true);
                }

                if ($_currency == "GBP")
                {
                    $currency = '£';
                }
                //echo get_post_meta(get_the_ID(), '_rent',true);
                if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
                {
                    if (isset($filter_opt['cur']))
                    {
                        if ($filter_opt['cur'] == 'EUR')
                        {
                            $cur_sybol = '€';
                        }
                        else if ($filter_opt['cur'] == 'USD')
                        {
                            $cur_sybol = '$';
                        }

                        $_price = get_post_meta(get_the_ID() , '_price', true);
                        $covert_price = $current_currency_price * $_price;
                        $property_price = $cur_sybol . number_format($covert_price, 2, get_option('propertyhive_price_decimal_separator', '.') , get_option('propertyhive_price_thousand_separator', ','));

                    }
                    else
                    {
                        $property_price = $property->get_formatted_price();
                    }

                }
                else if ($filter_opt['dpt'] == "letting")
                {
                    $_rent_frequency = get_post_meta(get_the_ID() , '_rent_frequency', true);
                    $_rent_price = str_replace("&#163;", "", get_post_meta(get_the_ID() , '_rent', true));

                    $r_frequency = '';
                    if ($_rent_frequency == "pd")
                    {
                        $r_frequency = "per day";
                    }
                    else if ($_rent_frequency == "pw")
                    {
                        $r_frequency = "per week";
                    }
                    else if ($_rent_frequency == "pq")
                    {
                        $r_frequency = "per quarter";
                    }
                    else if ($_rent_frequency == "pa")
                    {
                        $r_frequency = "per annum";
                    }
                    
                    if (isset($filter_opt['cur']))
                    {
                        if ($filter_opt['cur'] == 'EUR')
                        {
                            $cur_sybol = '€';
                        }
                        else if ($filter_opt['cur'] == 'USD')
                        {
                            $cur_sybol = '$';
                        }

                        $covert_price = $current_currency_price * $_rent_price;
                        $property_price = $cur_sybol . number_format($covert_price, 2, get_option('propertyhive_price_decimal_separator', '.') , get_option('propertyhive_price_thousand_separator', ',')) . " " . $r_frequency;

                    }
                    else
                    {
                        //$property_price = $property->get_formatted_price();
                        $property_price = $currency . number_format($_rent_price) . " " . $r_frequency;
                    }
                }
                
                if ($seven_block == 7)
                {

                    if ($bool)
                    {
                        $filter_html .= '</div><div class="row">';

                        $_propty_short_desc = get_the_excerpt();
                        $filter_html .= '<div class="col-sm-12">';
                        $filter_html .= '<div class="inner_grid">';
                        $filter_html .= '<div class="row">';
                        $filter_html .= '<div class="col-md-5 padding_r">';
                        $filter_html .= '<div class="savedproperties-col ' . $faved_cls . '">';
                        $filter_html .= '<div class="properties-image">';
                        if ($_available == 1 && $_status == "Under offer - Available")
                        {
                            $filter_html .= '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                        }
                        else if ($_status == "Arranging Tenancy - Unavailable")
                        {
                            $filter_html .= '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                        }

                        if ($_available == 0 && ($_status == "Completed" || $_status == "Exchanged" || $_status == "Sold"))
                        {
                            $filter_html .= '<a href="' . get_permalink() . '" class="sold">Sold</a>';
                        }
                        $filter_html .= '<a href="javascript:void(0);" class="heart ' . $saved_cls . '" date-attr="' . get_the_ID() . '" data-id="' . $logged_user_id . '"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                        $filter_html .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url(@$ImageSlides[0], "medium") . '" alt=""></a>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '<div class="col-md-7 left padding_l">';
                        $filter_html .= '<div class="row">';
                        $filter_html .= '<div class="col-md-6 middle">';
                        $filter_html .= '<ul class="four_hous">';
                        if (isset($ImageSlides[1]) && $ImageSlides[1] != '')
                        {
                            $filter_html .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[1], "medium") . '"></a></li>';
                        }
                        if (isset($ImageSlides[2]) && $ImageSlides[2] != '')
                        {
                            $filter_html .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[2], "medium") . '"></a></li>';
                        }
                        if (isset($ImageSlides[3]) && $ImageSlides[3] != '')
                        {
                            $filter_html .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[3], "medium") . '"></a></li>';
                        }
                        if (isset($ImageSlides[4]) && $ImageSlides[4] != '')
                        {
                            $filter_html .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[4], "medium") . '"></a></li>';
                        }
                        $filter_html .= '</ul>';
                        $filter_html .= '</div>';
                        $filter_html .= '<div class="col-md-6 middle">';
                        $filter_html .= '<div class="inner_content">';
                        $filter_html .= '<h5><a href="' . get_permalink() . '">' . get_the_title() . '</a></h5>';
                        $filter_html .= '<p>' . substr($_propty_short_desc, 0, 180) . ' (…)</p>';
                        $filter_html .= '<ul class="list-inline rooms_item">';
                        if(isset($_size_string) && $_size_string != '')
                        {
                            $filter_html .= '<li><img src="' . get_template_directory_uri() . '/assets/images/sq-ft.png" alt="sq-ft.png">' . $_size_string . '</li>';
                        }
                        $filter_html .= '<li><img src="' . get_template_directory_uri() . '/assets/images/bathrooms2.png" alt="bathrooms2">' . $_bedrooms . '</li>';
                        $filter_html .= '<li><img src="' . get_template_directory_uri() . '/assets/images/bathrooms.png" alt="bathrooms">' . $_bathrooms . '</li>';
                        $filter_html .= '</ul>';
                        $filter_html .= '<div class="listing-view-wrapper"><ul>';
                        if($_PriceString == "PA")
                        {   
                            $filter_html .= '<li>Price on Application</li>';    
                        }else
                        {
                            $filter_html .= '<li>'.$property_price.'</li>'; 
                        }
                        
                        $filter_html .= '<li><p class="sub-tenure">' . strtoupper($property->tenure) . '</p></li>';

                        $filter_html .= '</ul>';
                        $filter_html .= '<a class="btn btn-large btn-primary view-listing-btn" href="'.get_permalink().'">View listing</a>';
                        $filter_html .= '</div></div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';

                        $filter_html .= '</div><div class="row">';

                        $bool = false;

                        $seven_block = 1;
                    }
                    else
                    {
                        $filter_html .= '</div></div></div></div></div></section>';
                        $filter_html .= '<section class="market_property">';
                        $filter_html .= '<div class="container">';
                        $filter_html .= '<div class="col-md-8 mx-auto">';
                        if ($p <= 14)
                        {
                            $filter_html .= get_field("property_static_block_one", "option");
                        }
                        else
                        {
                            $filter_html .= get_field("property_static_block_two", "option");
                        }
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</section>';
                        $filter_html .= '<section class="closely_related">';
                        $filter_html .= '<div class="container">';
                        $filter_html .= '<div class="row">';
                        $filter_html .= '<div class="col-md-12">';
                        $filter_html .= '<div class="properties-row ' . $filter_opt['dpt'] . '">';
                        $filter_html .= '<div class="row">';

                        $filter_html .= '<div class="col-md-4 col-sm-6 col-xs-12">';
                        $filter_html .= '<div class="savedproperties-col">';
                        $filter_html .= '<div class="properties-image">';
                        if ($_available == 1 && $_status == "Under offer - Available")
                        {
                            $filter_html .= '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                        }
                        else if ($_status == "Arranging Tenancy - Unavailable")
                        {
                            $filter_html .= '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                        }
                        if ($_available == 0 && ($_status == "Completed" || $_status == "Exchanged" || $_status == "Sold"))
                        {
                            $filter_html .= '<a href="' . get_permalink() . '" class="sold">Sold</a>';
                        }
                        $filter_html .= '<div class="closely_slider">';
                        foreach ($ImageSlides as $_img_id)
                        {

                            $filter_html .= '<div class="">';
                            $filter_html .= '<div class="savedproperties-col ' . $faved_cls . '" >';
                            $filter_html .= '<a href="javascript:void(0);" class="heart ' . $saved_cls . '" date-attr="' . get_the_ID() . '" data-id="' . $logged_user_id . '"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                            $filter_html .= '<div class="properties-image">';
                            $filter_html .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($_img_id, "medium") . '" alt=""></a>';
                            $filter_html .= '</div>';
                            $filter_html .= '</div>';
                            $filter_html .= '</div>';
                        }
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '<div class="properties-content">';
                        $filter_html .= '<div class="address">';
                        $filter_html .= '<p><a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
                        $filter_html .= '</div>';
                        $filter_html .= '<div class="price">';
                        if($_PriceString == "PA")
                        {   
                            $filter_html .= '<a href="' . get_permalink() . '">' . strtoupper($property->tenure) . ' <span>Price on Application</span></a>';
                        }else
                        {
                            $filter_html .= '<a href="' . get_permalink() . '">' . strtoupper($property->tenure) . ' <span>' . $property_price . '</span></a>';
                        }


                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';

                        $bool = true;
                        $seven_block = 2;
                    }

                }
                else
                {
                    $filter_html .= '<div class="col-md-4 col-sm-6 col-xs-12">';
                    $filter_html .= '<div class="savedproperties-col">';
                    $filter_html .= '<div class="properties-image">';
                    if ($_available == 1 && $_status == "Under offer - Available")
                    {
                        $filter_html .= '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                    }
                    else if ($_status == "Arranging Tenancy - Unavailable")
                    {
                        $filter_html .= '<a href="' . get_permalink() . '" class="under_order">Under Offer</a>';
                    }
                    if ($_available == 0 && ($_status == "Completed" || $_status == "Exchanged" || $_status == "Sold"))
                    {
                        $filter_html .= '<a href="' . get_permalink() . '" class="sold">sold</a>';
                    }
                    $filter_html .= '<div class="closely_slider">';
                    foreach ($ImageSlides as $_img_id)
                    {

                        $filter_html .= '<div class="">';
                        $filter_html .= '<div class="savedproperties-col ' . $faved_cls . '" >';
                        $filter_html .= '<a href="javascript:void(0);" class="heart ' . $saved_cls . '" date-attr="' . get_the_ID() . '" data-id="' . $logged_user_id . '" ><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                        $filter_html .= '<div class="properties-image">';
                        $filter_html .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($_img_id, "medium") . '" alt=""></a>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                        $filter_html .= '</div>';
                    }
                    $filter_html .= '</div>';
                    $filter_html .= '</div>';
                    $filter_html .= '<div class="properties-content">';
                    $filter_html .= '<div class="address">';
                    $filter_html .= '<p><a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
                    $filter_html .= '</div>';
                    $filter_html .= '<div class="price">';
                    if($_PriceString == "PA")
                    {   
                        $filter_html .= '<a href="' . get_permalink() . '">' . strtoupper($property->tenure) . ' <span>Price on Application</span></a>';
                    }else
                    {
                        $filter_html .= '<a href="' . get_permalink() . '">' . strtoupper($property->tenure) . ' <span>' . $property_price . '</span></a>';
                    }
                    $filter_html .= '</div>';
                    $filter_html .= '</div>';
                    $filter_html .= '</div>';
                    $filter_html .= '</div>';

                    $seven_block++;
                }

                $p++;
            }
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</section>';

            $filter_html .= '<section class="pagination_">';
            $filter_html .= '<div class="container">';
            $filter_html .= '<div class="row">';
            $filter_html .= '<div class="col-md-12">';
            $filter_html .= '<div class="inner_pagination">';
            $big = 999999999; // need an unlikely integer
            $filter_html .= paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))) ,
                'format' => '?paged=%#%',
                'prev_text' => 'previous',
                'next_text' => 'next',
                'type' => 'list',
                'show_all' => true,
                'current' => max(1, get_query_var('paged')) ,
                'total' => $propty_seach_qry->max_num_pages
            ));
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</section>';
        }
        else
        {
            // $filter_html .= '<section class="closely_related properties-title-row">';
            $filter_html .= '<section class="pnf-details">';
            $filter_html .= '<div class="container">';
            $filter_html .= '<div class="row">';
            $filter_html .= '<div class="col-md-12 title">';
            if(get_field('pnf_message','option')){
                $filter_html .= '<h2 class="text-center">'.get_field("pnf_message","option").'</h2>';    
            }else{
                $filter_html .= '<h2 class="text-center">Property Not Found</h2>';
            }
            $filter_html .= '<a href="'.get_permalink(81).'#nc-section" class="a_btn">Contact Us</a>';
            $filter_html .= '<a href="javascript:void(0)" class="a_btn refine-search">Refine Search</a>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</section>';
        }
        wp_reset_postdata();
    }
    else
    {
        $filter_html .= '<section class="map-search-block">';
        $filter_html .= '<div class="wrap">';
        $filter_html .= '<div class="map-block" >';
        $filter_html .= '<div class="map" id="map"></div>';
        $filter_html .= '</div>';
        $filter_html .= '<div class="ms-listing">';
        $filter_html .= '<div class="closely_related">';
        $filter_html .= '<div class="row">';
        $filter_html .= '<div class="col-md-12">    ';
        $filter_html .= '<div class="properties-row map-record"></div>';
        $filter_html .= '</div>';
        $filter_html .= '</div>';
        $filter_html .= '</div>';
        $filter_html .= '</div>';

        $filter_html .= '</div>';
        $filter_html .= '</section>';

    }
    /* Featured Property Section*/

    if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
    {
        $featu_propty_qry = new WP_Query(array(
            'post_type' => 'property',
            'posts_per_page' => - 1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_department',
                    'value' => 'residential-sales',
                    'compare' => '==',
                ) ,
                array(
                    'key' => '_featured',
                    'value' => 'yes',
                    'compare' => '==',
                ) ,
            ) ,
        ));
    }
    else if ($filter_opt['dpt'] == "letting")
    {
        $featu_propty_qry = new WP_Query(array(
            'post_type' => 'property',
            'posts_per_page' => - 1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_department',
                    'value' => 'residential-lettings',
                    'compare' => '==',
                ) ,
                array(
                    'key' => '_featured',
                    'value' => 'yes',
                    'compare' => '==',
                ) ,
            ) ,
        ));
    }
    if ($featu_propty_qry->have_posts())
    {

        $filter_html .= '<section class="list_featured_properties">';
        $filter_html .= '<div class="container">';
        $filter_html .= '<div class="row">';
        $filter_html .= '<div class="col-md-12">';
        $filter_html .= '<h2 class="text-center">FEATURED properties</h2>';
        $filter_html .= '</div>';
        $filter_html .= '<div class="col-md-12">';
        $filter_html .= '<span class="pagingInfo"></span>';
        $filter_html .= '<div class="list_properties_slider properties-row ' . $filter_opt['dpt'] . '">';
        while ($featu_propty_qry->have_posts())
        {
            $featu_propty_qry->the_post();
            $property = new PH_Property(get_the_ID());
            $bannerSlides = $property->get_gallery_attachment_ids();
            $_currency = get_post_meta(get_the_ID() , '_currency', true);
            if ($_currency == "GBP")
            {
                $currency = '£';
            }
            if ($filter_opt['dpt'] == "sale" || $filter_opt['dpt'] == "new_home")
            {
                if (isset($filter_opt['cur']))
                {
                    if ($filter_opt['cur'] == 'EUR')
                    {
                        $cur_sybol = '€';
                    }
                    else if ($filter_opt['cur'] == 'USD')
                    {
                        $cur_sybol = '$';
                    }

                    $_price = get_post_meta(get_the_ID() , '_price', true);
                    $covert_price = $current_currency_price * $_price;
                    $property_price = $cur_sybol . number_format($covert_price, 2, get_option('propertyhive_price_decimal_separator', '.') , get_option('propertyhive_price_thousand_separator', ','));

                }
                else
                {
                    $property_price = $property->get_formatted_price();
                }

            }
            else if ($filter_opt['dpt'] == "letting")
            {
                $_rent_frequency = get_post_meta(get_the_ID() , '_rent_frequency', true);
                $_rent_price = str_replace("&#163;", "", get_post_meta(get_the_ID() , '_rent', true));

                if ($_rent_frequency == "pd")
                {
                    $r_frequency = "per day";
                }
                else if ($_rent_frequency == "pw")
                {
                    $r_frequency = "per week";
                }
                else if ($_rent_frequency == "pq")
                {
                    $r_frequency = "per quarter";
                }
                else if ($_rent_frequency == "pa")
                {
                    $r_frequency = "per annum";
                }

                if (isset($filter_opt['cur']))
                {
                    if ($filter_opt['cur'] == 'EUR')
                    {
                        $cur_sybol = '€';
                    }
                    else if ($filter_opt['cur'] == 'USD')
                    {
                        $cur_sybol = '$';
                    }
                    $covert_price = $current_currency_price * $_rent_price;

                    $property_price = $cur_sybol . number_format($covert_price, 2, get_option('propertyhive_price_decimal_separator', '.') , get_option('propertyhive_price_thousand_separator', ',')) . " " . $r_frequency;

                }
                else
                {
                    $property_price = $currency . number_format($_rent_price) . " " . $r_frequency;
                }

            }

            $_address_street = get_post_meta(get_the_ID() , '_address_street', true);
            $_address_two = get_post_meta(get_the_ID() , '_address_two', true);
            $_address_three = get_post_meta(get_the_ID() , '_address_three', true);
            $postcode = explode(" ", get_post_meta(get_the_ID() , '_address_postcode', true));
            $_saved_prperty = get_post_meta(get_the_ID() , 'saved_prperty', true);
            $_prperty_user_id = get_post_meta(get_the_ID() , 'prperty_user_id', true);
            $_PriceString = get_post_meta(get_the_ID(),'_price_qualifier',true);

            if ((isset($_saved_prperty) && $_saved_prperty == 1) && ($_prperty_user_id == $logged_user_id))
            {
                $saved_cls = "active";
                $faved_cls = "faved";
            }
            else
            {
                $saved_cls = "";
                $faved_cls = "";
            }

            $filter_html .= '<div class="">';
            $filter_html .= '<div class="savedproperties-col">';

            $filter_html .= '<div class="properties-image ' . $faved_cls . '">';
            $filter_html .= '<a href="javascript:void(0);" class="heart ' . $saved_cls . '" date-attr="' . $property->id . '" data-id="' . $logged_user_id . '"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
            $filter_html .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[0], "medium") . '" alt=""></a>';
            $filter_html .= '</div>';
            $filter_html .= '<div class="properties-content">';

            $filter_html .= '<div class="address">';
            $filter_html .= '<p><a href="' . get_permalink() . '">' . $_address_street . ', <br> ' . $_address_two . ' <br>' . $_address_three . ', ' . $postcode[0] . '</a></p>';
            $filter_html .= '</div>';
            $filter_html .= '<div class="price">';
            if($_PriceString == "PA")
            {
                $filter_html .= '<a href="'.get_permalink().'">'.strtoupper($property->tenure).'<span>Price on Application</span></a>';
            }else
            {
                $filter_html .= '<a href="'.get_permalink().'">'.strtoupper($property->tenure).'<span>'.$property_price.'</span></a>';
            }
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
            $filter_html .= '</div>';
        }
        $filter_html .= '</div>';
        $filter_html .= '</div>';
        $filter_html .= '</div>';
        $filter_html .= '</div>';
        $filter_html .= '</section>';

        /* End */

    }
    wp_reset_postdata();
    return $filter_html;

}

function title_filter($where, $wp_query)
{
    global $wpdb;
    // 2. pull the custom query in here:
    if ($parea = $wp_query->get('search_prod_title'))
    {
        //$where .= ' AND ' . $wpdb->posts . '.post_title LIKE "%' .$parea. '%"';
        $where .= 'AND  ' . $wpdb->posts . '.post_title like "%' . $parea . '%"';
    }
    return $where;
}

add_action('wp_ajax_property_title_autocomplete', 'fn_get_property_autocomplete_list');
add_action('wp_ajax_nopriv_property_title_autocomplete', 'fn_get_property_autocomplete_list');

function fn_get_property_autocomplete_list()
{
    global $wpdb;

    $autocomplete_result = array();
    $search_term = $_POST['search_term'];
    $dpt = $_POST['dpt'];
    $subplot = '';

    if (get_field("property_areas", "option"))
    {
        while (has_sub_field("property_areas", "option"))
        {
            $area_code = get_sub_field("filter_property_area", "option");
            array_push($autocomplete_result, $area_code);

        }
    }
    $all_p_data = get_posts(array('post_type'=> 'property','numberposts' => -1));
    $post_code = array();
    foreach ($all_p_data as $p_data) {
        $post_code = get_post_meta($p_data->ID,"_address_postcode",true);
        $first_code = explode(" ",get_post_meta($p_data->ID,"_address_postcode",true));
        
        if(!in_array($first_code[0], $autocomplete_result))
        {
             array_push($autocomplete_result,$first_code[0]);
        }

    }
    
    
    if ($dpt == "sale" || $dpt == "new_home" || $dpt == "undefined")
    {
        $_depname = "residential-sales";
        $no_disply_status_prt = array(
            'For Sale - Unavailable',
            'Completed - Available',
            'Exchanged - Available',
            'Sold',
            'Completed',
            'Exchanged'
        );
        $pstus = array(
            'key' => '_InternalSaleStatus',
            'value' => $no_disply_status_prt,
            'compare' => 'NOT IN',
        );
        $subplot = array(
            'relation' => 'OR',
            array(
                'key' => '_IsSubPlot',
                'value' => 1,
                'compare' => '==',
            ) ,
            array(
                'key' => '_SubPlots',
                'compare' => 'NOT EXISTS',
            ) ,
        );

    }
    else if (isset($dpt) && $dpt == "letting")
    {
        $_depname = "residential-lettings";
        $no_disply_status_prt = array(
            'Tenancy Current - Unavailable',
            'To Let - Unavailable',
            'Let by other agent',
            'Sold'
        );

        $pstus = array(
            'key' => '_InternalLettingStatus',
            'value' => $no_disply_status_prt,
            'compare' => 'NOT IN',
        );
        $subplot = array(
            'relation' => 'OR',
            array(
                'key' => '_IsSubPlot',
                'value' => 1,
                'compare' => '==',
            ) ,
            array(
                'key' => '_SubPlots',
                'compare' => 'NOT EXISTS',
            ) ,
        );
    }

    $_args = array(
        'post_type' => 'property',
        'post_status' => 'publish',
        'search_prod_title' => $search_term,
        'posts_per_page' => - 1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_department',
                'value' => $_depname,
                'compare' => '==',
            ) ,
            $pstus,
            $subplot,
        ) ,
    );

    add_filter('posts_where', 'title_filter', 10, 2);
    $search_query = new WP_Query($_args);
    remove_filter('posts_where', 'title_filter', 10);

    if ($search_query->have_posts())
    {
        while ($search_query->have_posts())
        {
            $new_const = '';
            $search_query->the_post();
            $post_title = strtolower(get_the_title());
            $post_title = esc_attr($post_title);
            $post_title = str_replace('&#039;', "'", $post_title);
            $post_title = str_replace('&amp;', "&", $post_title);

            array_push($autocomplete_result, $post_title);

        }
    }
    wp_reset_postdata();

    echo json_encode($autocomplete_result); //encode into JSON format and output
    exit;
}

/* Similar Property Shortcode*/

add_shortcode('single_similar_properties', 'Fn_similar_properties');
function Fn_similar_properties($atts)
{
    $property = new PH_Property(get_the_ID());

    $atts = shortcode_atts(array(
        'per_page' => '2',
        'columns' => '2',
        'orderby' => 'rand',
        'order' => 'asc',
        'price_percentage_bounds' => 10,
        'bedroom_bounds' => 0,
        'property_id' => '',
        'availability_id' => '',
        'no_results_output' => '',
    ) , $atts, 'Fn_similar_properties');
    if ($atts['property_id'] != '')
    {
        $department = get_post_meta($atts['property_id'], '_department', true);
        if ($department == "residential-sales")
        {
            $price = get_post_meta($atts['property_id'], '_price', true);
            $property_price = $property->get_formatted_price();
        }
        else if ($department == "residential-lettings")
        {
            $_rent_frequency = get_post_meta(get_the_ID() , '_rent_frequency', true);
            $currency = get_post_meta(get_the_ID() , '_currency', true);
            $price = str_replace(",", "", str_replace("&#163;", "", get_post_meta($atts['property_id'], '_rent', true)));
            $rent_price = str_replace("&#163;", "", get_post_meta($atts['property_id'], '_rent', true));
            $property_price = $currency . $rent_price . " " . $_rent_frequency;
        }

        $lower_price = $price;
        $higher_price = $price;
        $atts['price_percentage_bounds'] = str_replace("%", "", $atts['price_percentage_bounds']);
        if (isset($atts['price_percentage_bounds']) && $atts['price_percentage_bounds'] != '' && is_numeric($atts['price_percentage_bounds']) && $atts['price_percentage_bounds'] > 0)
        {
            $lower_price = $price - ($price * $atts['price_percentage_bounds'] / 100);
            $higher_price = $price + ($price * $atts['price_percentage_bounds'] / 100);
        }
        $bedrooms = get_post_meta($atts['property_id'], '_bedrooms', true);
        $lower_bedrooms = $bedrooms;
        $higher_bedrooms = $bedrooms;
        if (isset($atts['bedroom_bounds']) && $atts['bedroom_bounds'] != '' && is_numeric($atts['bedroom_bounds']) && $atts['bedroom_bounds'] > 0)
        {
            $lower_bedrooms = $bedrooms - $atts['bedroom_bounds'];
            $higher_bedrooms = $bedrooms + $atts['bedroom_bounds'];
        }
        $args = array(
            'post_type' => 'property',
            'post__not_in' => array(
                $atts['property_id']
            ) ,
            'post_status' => ((is_user_logged_in() && current_user_can('manage_propertyhive')) ? array(
                'publish',
                'private'
            ) : 'publish') ,
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $atts['per_page'],
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'has_password' => false,
        );
        $meta_query = array();

        $meta_query[] = array(
            'key' => '_department',
            'value' => $department,
        );

        $meta_query[] = array(
            'key' => '_on_market',
            'value' => 'yes',
        );

        if (isset($atts['bedroom_bounds']) && is_numeric($atts['bedroom_bounds']))
        {
            $meta_query[] = array(
                'key' => '_bedrooms',
                'value' => $lower_bedrooms,
                'compare' => '>=',
                'type' => 'NUMERIC'
            );

            $meta_query[] = array(
                'key' => '_bedrooms',
                'value' => $higher_bedrooms,
                'compare' => '<=',
                'type' => 'NUMERIC'
            );
        }

        if (isset($atts['price_percentage_bounds']) && is_numeric($atts['price_percentage_bounds']))
        {
            $meta_query[] = array(
                'key' => '_price_actual',
                'value' => $lower_price,
                'compare' => '>=',
                'type' => 'NUMERIC'
            );

            $meta_query[] = array(
                'key' => '_price_actual',
                'value' => $higher_price,
                'compare' => '<=',
                'type' => 'NUMERIC'
            );
        }

        $args['meta_query'] = $meta_query;

        $tax_query = array();

        if (isset($atts['availability_id']) && $atts['availability_id'] != '')
        {
            $tax_query[] = array(
                'taxonomy' => 'availability',
                'terms' => explode(",", $atts['availability_id']) ,
                'compare' => 'IN',
            );
        }

        if (!empty($tax_query))
        {
            $args['tax_query'] = $tax_query;
        }

        if (isset($atts['orderby']) && $atts['orderby'] == 'date')
        {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = '_on_market_change_date';
        }

        ob_start();
        $shortcode_output = '';
        $properties = new WP_Query(apply_filters('propertyhive_shortcode_similar_properties_query', $args, $atts));
        if ($properties->have_posts())
        {
            $shortcode_output .= '<section class="closely_related similar_properties">';
            $shortcode_output .= '<div class="container">';
            $shortcode_output .= '<div class="row">';
            $shortcode_output .= '<div class="col-md-12">';
            $shortcode_output .= ' <h2>Similar properties that may interest you</h2>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '<div class="row">';
            $shortcode_output .= '<div class="col-md-12">';
            $shortcode_output .= '<div class="properties-row">';
            $shortcode_output .= '<div class="row">';

            $i = 1;
            while ($properties->have_posts())
            {
                $properties->the_post();
                $similar_property = new PH_Property(get_the_ID());
                $similar_dept = get_post_meta(get_the_ID() , '_department', true);
                $_bathrooms = get_post_meta(get_the_ID() , '_bathrooms', true);
                $_bedrooms = get_post_meta(get_the_ID() , '_bedrooms', true);
                $_size_string = get_post_meta(get_the_ID() , '_size_string', true);
                $_SaleStatus = get_post_meta(get_the_ID() , '_SaleStatus', true);
                $_available = get_post_meta(get_the_ID() , '_available', true);
                $_cuny = get_post_meta(get_the_ID() , '_currency', true);
                if ($similar_dept == "residential-sales")
                {
                    $property_price = $similar_property->get_formatted_price();
                }
                else if ($similar_dept == "residential-lettings")
                {
                    $_rent_frequency = get_post_meta(get_the_ID() , '_rent_frequency', true);
                    $_rent_price = str_replace("&#163;", "", get_post_meta(get_the_ID() , '_rent', true));
                    //$property_price = $_cuny.$_rent_price." ".$_rent_frequency;
                    $property_price = $property->get_formatted_price();
                }
                $bannerSlides = $similar_property->get_gallery_attachment_ids();
                $_propty_short_desc = get_the_excerpt();
                if ($i == 4)
                {
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '<div class="row">';
                    $shortcode_output .= '<div class="col-sm-12">';
                    $shortcode_output .= '<div class="inner_grid"><div class="row">';
                    $shortcode_output .= '<div class="col-md-5 padding_r">';
                    $shortcode_output .= '<div class="savedproperties-col"> ';
                    $shortcode_output .= '<div class="properties-image">';
                    $shortcode_output .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[0], "medium") . '" alt=""></a>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '<div class="col-md-7 left padding_l">';
                    $shortcode_output .= '<div class="row">';
                    $shortcode_output .= '<div class="col-md-6 middle">';
                    $shortcode_output .= '<ul class="four_hous">';
                    if (isset($bannerSlides[1]) && $bannerSlides[1] != '')
                    {
                        $shortcode_output .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[1], "medium") . '"></a></li>';
                    }
                    if (isset($bannerSlides[2]) && $bannerSlides[2] != '')
                    {
                        $shortcode_output .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[2], "medium") . '"></a></li>';
                    }
                    if (isset($bannerSlides[3]) && $bannerSlides[3] != '')
                    {
                        $shortcode_output .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[3], "medium") . '"></a></li>';
                    }
                    if (isset($bannerSlides[4]) && $bannerSlides[4] != '')
                    {
                        $shortcode_output .= '<li><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[4], "medium") . '"></a></li>';
                    }
                    $shortcode_output .= '</ul>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '<div class="col-md-6 middle">';
                    $shortcode_output .= '<div class="inner_content">';
                    $shortcode_output .= '<h5><a href="' . get_permalink() . '">' . get_the_title() . '</a></h5>';
                    $shortcode_output .= '<p>' . substr($_propty_short_desc, 0, 180) . ' (…)</p>';
                    $shortcode_output .= '<ul class="list-inline rooms_item">';
                    if(isset($_size_string) && $_size_string != '')
                    {
                        $shortcode_output .= '<li><img src="' . get_template_directory_uri() . '/assets/images/sq-ft.png" alt="sq-ft.png">' . $_size_string . '</li>';
                    }
                    $shortcode_output .= '<li><img src="' . get_template_directory_uri() . '/assets/images/bathrooms2.png" alt="bathrooms2">' . $_bedrooms . '</li>';
                    $shortcode_output .= '<li><img src="' . get_template_directory_uri() . '/assets/images/bathrooms.png" alt="bathrooms">' . $_bathrooms . '</li>';
                    $shortcode_output .= '</ul>';
                    $shortcode_output .= '<ul>';
                    $shortcode_output .= '<li>' . $property_price . '</li>';
                    $shortcode_output .= '<li>' . strtoupper($property->tenure) . '</li>';

                    $shortcode_output .= '</ul>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '</div></div>';
                    $shortcode_output .= '</div>';
                    $shortcode_output .= '<div class="row">';

                }
                $shortcode_output .= '<div class="col-md-4 col-sm-6 col-xs-12">';
                $shortcode_output .= '<div class="savedproperties-col">';
                $shortcode_output .= '<div class="properties-image">';
                $shortcode_output .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($bannerSlides[0], "medium") . '" alt=""></a>';
                $shortcode_output .= '</div>';
                $shortcode_output .= '<div class="properties-content">';
                $shortcode_output .= '<div class="address">';
                $shortcode_output .= '<p><a href="' . get_permalink() . '">' . get_the_title() . ' </a></p>';
                $shortcode_output .= '</div>';
                $shortcode_output .= '<div class="price">';
                $shortcode_output .= '<a href="' . get_permalink() . '">' . strtoupper($similar_property->tenure) . ' <span>' . $property_price . '</span></a>';
                $shortcode_output .= '</div>';
                $shortcode_output .= '</div>';
                $shortcode_output .= '</div>';
                $shortcode_output .= '</div>';

                $i++;
            }

            $shortcode_output .= '</div>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '<div class="row">';
            $shortcode_output .= '<div class="col-md-12">';
            $shortcode_output .= '<a href="' . get_permalink(2914) . '?dpt=sale&pstus=exclude" class="cmn_btn">View all</a>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '</div>';
            $shortcode_output .= '</section>';

        }
        wp_reset_postdata();
        //$shortcode_output = $price;
        
    }

    return $shortcode_output;
}
add_action('wp_ajax_nopriv_fn_Saved_Properties', 'fn_Saved_Properties');
add_action('wp_ajax_fn_Saved_Properties', 'fn_Saved_Properties');

function fn_Saved_Properties()
{
    $status = false;
    $response = array();
    $response['code'] = 0;
    $response['alert'] = '';

    if (!wp_verify_nonce($_POST['saved_prperty_nonce'], 'saved_prperty_nonce'))
    {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    }
    else
    {
        $status = true;
    }
    if ($status)
    {
        if ($_POST['psaved_id'] != '')
        {
            if ($_POST['alreadysaved'] == 0)
            {
                update_post_meta($_POST['psaved_id'], "saved_prperty", "1");
                update_post_meta($_POST['psaved_id'], "prperty_user_id", $_POST['puser_id']);
                $response['code'] = 1;
            }
            else if ($_POST['alreadysaved'] == 1)
            {
                update_post_meta($_POST['psaved_id'], "saved_prperty", "0");
                $response['code'] = 2;
            }
        }
        else
        {
            $response['code'] = 0;
        }
    }
    echo json_encode($response);
    wp_die();
}
add_action('wp_ajax_nopriv_fn_Removed_Saved_Properties', 'fn_Removed_Saved_Properties');
add_action('wp_ajax_fn_Removed_Saved_Properties', 'fn_Removed_Saved_Properties');

function fn_Removed_Saved_Properties()
{
    $status = false;
    $response = array();
    $response['code'] = 0;
    $response['alert'] = '';

    if (!wp_verify_nonce($_POST['saved_prperty_nonce'], 'saved_prperty_nonce'))
    {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
    }
    else
    {
        $status = true;
    }
    if ($status)
    {
        if ($_POST['psaved_id'] != '')
        {
            $proty_html = '';
            update_post_meta($_POST['psaved_id'], "saved_prperty", "0");

            $_args = array(
                'post_type' => 'property',
                'posts_per_page' => - 1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'saved_prperty',
                        'value' => 1,
                        'compare' => '==',
                    ) ,
                    array(
                        'key' => 'prperty_user_id',
                        'value' => $_POST['puser_id'],
                        'compare' => '==',
                    ) ,
                ) ,
            );
            $saved_proty = new WP_Query($_args);
            if ($saved_proty->have_posts())
            {
                while ($saved_proty->have_posts())
                {
                    $saved_proty->the_post();
                    $property = new PH_Property(get_the_ID());
                    $ImageSlides = $property->get_gallery_attachment_ids();
                    $proty_html .= '<div class="submit-loder"><img src="' . get_template_directory_uri() . '/assets/images/ajax-loader.gif"></div>';
                    $proty_html .= '<div class="saved-alert"></div>';
                    $proty_html .= '<div class="col-sm-4">';
                    $proty_html .= '<div class="savedproperties-col">';
                    $proty_html .= '<a href="javascript:void(0);" id="' . get_the_ID() . '" data-id ="' . $_POST['puser_id'] . '" class="remove"><i class="fa fa-minus-circle"></i></a>';
                    $proty_html .= '<div class="properties-image">';
                    $proty_html .= '<a href="' . get_permalink() . '"><img src="' . wp_get_attachment_image_url($ImageSlides[0], 'medium') . '" alt="' . get_the_title() . '"></a>';
                    $proty_html .= '</div>';
                    $proty_html .= '<div class="properties-content">';
                    $proty_html .= '<div class="address">';
                    $proty_html .= '<p>' . get_the_title() . '</p>';
                    $proty_html .= '</div>';
                    $proty_html .= '<div class="price">';
                    $proty_html .= strtoupper($property->tenure) . '<span>' . $property->get_formatted_price() . '</span>';
                    $proty_html .= '</div>';
                    $proty_html .= '</div>';
                    $proty_html .= '</div>';
                    $proty_html .= '</div>';

                }
                wp_reset_postdata();
            }
            else
            {
                $proty_html .= '<div class="col-md-12">';
                $proty_html .= "You do not currently have any saved properties.";
                $proty_html .= '</div>';
            }
            $response['code'] = 1;
        }

    }
    $response['res_data'] = $proty_html;
    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_nopriv_fn_Delete_Search_Criteria', 'fn_Delete_Search_Criteria');
add_action('wp_ajax_fn_Delete_Search_Criteria', 'fn_Delete_Search_Criteria');

function fn_Delete_Search_Criteria()
{
    global $wpdb;
    $tbl_search = $wpdb->prefix . "saved_properties";

    $status = false;
    $response = array();
    $response['code'] = 0;
    $response['alert'] = '';

    if (!wp_verify_nonce($_POST['saved_search_nonce'], 'saved_search_nonce'))
    {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
        $response['code'] = 0;
    }
    else
    {
        $status = true;
        $response['code'] = 1;
    }
    if ($status)
    {
        $delete = $wpdb->query("delete from $tbl_search where id=" . $_POST['search_id']);
        $serch_html = '';
        if ($delete)
        {
            $search_res = $wpdb->get_results("select * from $tbl_search where user_id=" . $_POST['user_id']);

            $serch_html .= '<div class="headings text-center">';
            $serch_html .= '<h3>' . count($search_res) . ' Saved Searches</h3>';
            $serch_html .= '</div>';
            $serch_html .= '<input type="hidden" value="' . $_POST['user_id'] . '" id="user_id">';
            $serch_html .= '<div class="submit-loder"><img src="' . get_template_directory_uri() . '/assets/images/ajax-loader.gif"></div>';
            $serch_html .= '<div class="saved-alert"></div>';
            $i = 1;
            $search_title = '';
            foreach ($search_res as $_res)
            {

                if (strpos($_res->save_search_url, 'dpt=sale') !== false)
                {
                    $search_title = $i . ') Residential Properties to Buy';
                }
                else if (strpos($_res->save_search_url, 'dpt=letting') !== false)
                {
                    $search_title = $i . ') Residential Properties to Rent';
                }

                $serch_html .= '<div class="savelist-col">';
                $serch_html .= '<div class="savelist-row">';
                $serch_html .= '<h4>' . $search_title . '</h4>';
                $serch_html .= '<ul class="savelist-links">';
                $serch_html .= '<li><a href="' . $_res->save_search_url . '" target="_blank" ><em class="fa fa-street-view"></em>View Results</a></li>';
                if ($_res->email_alert == 1)
                {
                    $serch_html .= '<li><a href="javascript:void(0);" class="alert_status" id="' . $_res->id . '" data-id="1" ><em class="fa fa-envelope-o"></em><span>Stop Email Alerts</span></a></li>';
                }
                else
                {
                    $serch_html .= '<li><a href="javascript:void(0);" class="alert_status" id="' . $_res->id . '" data-id="0"><em class="fa fa-envelope-o"></em><span>Start Email Alerts</span></a></li>';
                }

                $serch_html .= '<li><a href="javascript:void(0);" class="delete_alert" id="' . $_res->id . '" ><em class="fa fa-trash-o"></em>Delete Search</a></li>';
                $serch_html .= '</ul>';
                $serch_html .= '</div>';
                $serch_html .= '</div>';
                $i++;
            }
            $response['res_data'] = $serch_html;
            $response['code'] = 1;
        }
        else
        {
            $response['code'] = 0;
        }

    }

    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_nopriv_fn_Saved_Search_Email_Alert', 'fn_Saved_Search_Email_Alert');
add_action('wp_ajax_fn_Saved_Search_Email_Alert', 'fn_Saved_Search_Email_Alert');

function fn_Saved_Search_Email_Alert()
{
    global $wpdb;
    $tbl_search = $wpdb->prefix . "saved_properties";

    $status = false;
    $response = array();
    $response['code'] = 0;
    $response['alert'] = '';

    if (!wp_verify_nonce($_POST['saved_search_nonce'], 'saved_search_nonce'))
    {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
        $response['code'] = 0;
    }
    else
    {
        $status = true;
        $response['code'] = 1;
    }
    if ($status)
    {
        if ($_POST['alert_status'] == 1)
        {
            $update = $wpdb->query("update $tbl_search set email_alert=0 where user_id='" . $_POST['user_id'] . "' and email_alert='" . $_POST['alert_status'] . "' and id=" . $_POST['id']);
            $response['alert_status'] = "Start Email Alerts";
            $response['alert_value'] = 0;
        }
        else if ($_POST['alert_status'] == 0)
        {
            $update = $wpdb->query("update $tbl_search set email_alert=1 where user_id='" . $_POST['user_id'] . "' and email_alert='" . $_POST['alert_status'] . "' and id=" . $_POST['id']);
            $response['alert_status'] = "Stop Email Alerts";
            $response['alert_value'] = 1;
        }
        if ($update)
        {
            $response['code'] = 1;
        }
        else
        {
            $response['alert'] = __('Something Problem. Please try again!', 'twentytwenty');
            $response['code'] = 0;
        }
    }
    echo json_encode($response);
    wp_die();
}
add_action('wp_ajax_nopriv_fn_Saved_Search_Criteria', 'fn_Saved_Search_Criteria');
add_action('wp_ajax_fn_Saved_Search_Criteria', 'fn_Saved_Search_Criteria');

function fn_Saved_Search_Criteria()
{
    global $wpdb;
    $tbl_search = $wpdb->prefix . "saved_properties";

    $status = false;
    $response = array();
    $response['code'] = 0;
    $response['alert'] = '';

    if (!wp_verify_nonce($_POST['saved_search_nonce'], 'saved_search_nonce'))
    {
        $status = false;
        $response['alert'] = __('Failed security check!', 'twentytwenty');
        $response['code'] = 0;
    }
    else
    {
        $status = true;
        $response['code'] = 1;
    }
    if ($status)
    {
        $paras = array();
        $dept = explode("?dpt=", $_POST['search_url']);
        $bed = '';
        $minp = '';
        $maxp = '';
        $psize = '';
        $psty = '';
        $ptage = '';
        $pfun = '';
        $petfdy = '';
        $pstus = '';
        $pamty = '';
        $area = '';
        $psq_ft = '';
        $psq_m = '';
        $ptype = '';
        if (isset($_POST['bed']))
        {
            $bed = $_POST['bed'];
            $paras = array_push_assoc($paras, 'bed', $_POST['bed']);
        }
        if (isset($_POST['minp']))
        {
            $minp = $_POST['minp'];
            $paras = array_push_assoc($paras, 'minp', $_POST['minp']);
        }
        if (isset($_POST['maxp']))
        {
            $maxp = $_POST['maxp'];
            $paras = array_push_assoc($paras, 'maxp', $_POST['maxp']);
        }
        if (isset($_POST['psq_ft']))
        {
            $psq_ft = $_POST['psq_ft'];
            $paras = array_push_assoc($paras, 'psq_ft', $_POST['psq_ft']);
        }
        if (isset($_POST['psq_m']))
        {
            $psq_m = $_POST['psq_m'];
            $paras = array_push_assoc($paras, 'psq_m', $_POST['psq_m']);
        }
        if (isset($_POST['psize']))
        {
            $psize = $_POST['psize'];
            $paras = array_push_assoc($paras, 'psize', $_POST['psize']);
        }

        if (isset($_POST['ptage']))
        {
            $ptage = $_POST['ptage'];
            $paras = array_push_assoc($paras, 'ptage', $_POST['ptage']);
        }
        if (isset($_POST['ptype']))
        {
            $ptype = $_POST['ptype'];
            $paras = array_push_assoc($paras, 'ptype', $_POST['ptype']);
        }
        if (isset($_POST['pfun']))
        {
            $pfun = $_POST['pfun'];
            $paras = array_push_assoc($paras, 'pfun', $_POST['pfun']);
        }
        if (isset($_POST['petfdy']))
        {
            $petfdy = $_POST['petfdy'];
            $paras = array_push_assoc($paras, 'petfdy', $_POST['petfdy']);
        }
        if (isset($_POST['pstus']))
        {
            $pstus = $_POST['pstus'];
            $paras = array_push_assoc($paras, 'pstus', $_POST['pstus']);
        }
        if (isset($_POST['parea']))
        {
            $paras = array_push_assoc($paras, 'parea', $_POST['parea']);
        }
        if (isset($_POST['pamty']))
        {
            $pamty = $_POST['pamty'];
            $paras = array_push_assoc($paras, 'pamty', $_POST['pamty']);
        }
        if (isset($_POST['area']))
        {
            $area = $_POST['area'];
            $paras = array_push_assoc($paras, 'area', $_POST['area']);
        }

        if (isset($_POST['style']))
        {
            $paras = array_push_assoc($paras, 'style', $_POST['style']);
        }
        if (isset($_POST['cur']))
        {
            $paras = array_push_assoc($paras, 'cur', $_POST['cur']);
        }
        if (isset($_POST['srtbyprice']))
        {
            $paras = array_push_assoc($paras, 'srtbyprice', $_POST['srtbyprice']);
        }

        $url = add_query_arg($paras, $_POST['search_url']);
        $exists_res = $wpdb->get_results("select * from $tbl_search where save_search_url='" . $url . "' and user_id=" . $_POST['puser_id']);
        //print_r($exists_res);exit;
        if (!empty($exists_res) && count($exists_res) > 0)
        {
            $response['code'] = 0;
            $response['alert'] = __('This search criteria already saved', 'twentytwenty');

        }
        else
        {
            $ins_search = $wpdb->query("insert into $tbl_search 
                (save_search_url,user_id,bed,min_price,max_price,status,age,ptype,amty,dept,pfun,petfdy,psq_ft,psq_m) 
                values 
                ('" . $url . "','" . $_POST['puser_id'] . "','" . $bed . "','" . $minp . "','" . $maxp . "','" . $pstus . "','" . $ptage . "','" . $ptype . "','" . $pamty . "','" . $area . "' ,'" . $dept[1] . "' ,'" . $pfun . "' ,'" . $petfdy . "','" . $psq_ft . "','" . $psq_m . "')");
            if ($ins_search)
            {
                $response['code'] = 1;
            }
            else
            {
                $response['code'] = 0;
                $response['alert'] = __('Search criteria not saved. Please try again!', 'twentytwenty');
            }
        }
    }
    echo json_encode($response);
    wp_die();
}
function array_push_assoc($array, $key, $value)
{
    $array[$key] = $value;
    return $array;
}

add_action('wp_ajax_nopriv_fn_Get_All_Properties', 'fn_Get_All_Properties');
add_action('wp_ajax_fn_Get_All_Properties', 'fn_Get_All_Properties');
function fn_Get_All_Properties()
{
    $psty = array();
    $pstus = '';
    $bed = '';
    $maxp = '';
    $minp = '';
    $psize = '';
    $ptage = array();
    $pfun = array();
    $parea = '';
    $pamty = array();
    $_specialpamty = array();
    $pareasize = '';
    $petfdy = '';
    $area = array();
    $_area = array();
    $loc_name = '';
    $new_home = '';
    $no_disply_status_prt = array();
    $response = array();
    $subplot = '';
    if (get_current_user_id() != '')
    {
        $_user_id = get_current_user_id();
    }
    else
    {
        $_user_id = '';
    }

    $search_url = explode("?dpt=", $_POST['search_url']);
    if ($search_url[1] == "sale" || $search_url[1] == "new_home")
    {
        $_depname = "residential-sales";
        $price_order_meta_key = "_price";
        $subplot = array(
            'relation' => 'OR',
            array(
                'key' => '_IsSubPlot',
                'value' => 1,
                'compare' => '==',
            ) ,
            array(
                'key' => '_SubPlots',
                'compare' => 'NOT EXISTS',
            ) ,
        );

    }
    else if ($search_url[1] == "letting")
    {
        $_depname = "residential-lettings";
        $price_order_meta_key = "_rent";

        $subplot = array(
            'relation' => 'OR',
            array(
                'key' => '_IsSubPlot',
                'value' => 1,
                'compare' => '==',
            ) ,
            array(
                'key' => '_SubPlots',
                'compare' => 'NOT EXISTS',
            ) ,
        );

    }
    if (isset($_POST['ptype']))
    {
        $p_sty = array();
        $p_sty = explode(",", $_POST['ptype']);

        foreach ($p_sty as $_pstyle)
        {
            $psty['relation'] = 'OR';
            $psty[] = array(
                'relation' => 'OR',
                array(
                    'key' => '_property_style',
                    'value' => $_pstyle,
                    'compare' => 'Like',
                ) ,
                array(
                    'key' => '_property_type',
                    'value' => $_pstyle,
                    'compare' => '==',
                ) ,
            );
        }
    }
    if (isset($_POST['pstus']))
    {
        if ($_POST['pstus'] == "exclude")
        {
            if ($search_url[1] == "sale" || $search_url[1] == "new_home")
            {
                $no_disply_status_prt = array(
                    'For Sale - Unavailable',
                    'Completed - Available',
                    'Exchanged - Available',
                    'Sold',
                    'Completed',
                    'Exchanged'
                );
                $pstus = array(
                    'key' => '_InternalSaleStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );

            }
            else if ($search_url[1] == "letting")
            {
                $no_disply_status_prt = array(
                    'Tenancy Current - Unavailable',
                    'To Let - Unavailable',
                    'Let by other agent',
                    'Sold'
                );

                $pstus = array(
                    'key' => '_InternalLettingStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );
            }

        }
        else if ($_POST['pstus'] == "include")
        {
            if ($search_url[1] == "sale" || $search_url[1] == "new_home")
            {
                $no_disply_status_prt = array(
                    'For Sale - Unavailable',
                    'Completed - Available',
                    'Exchanged - Available'
                );
                $pstus = array(
                    'key' => '_InternalSaleStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );

            }
            else if ($search_url[1] == "letting")
            {
                $no_disply_status_prt = array(
                    'Tenancy Current - Unavailable',
                    'To Let - Unavailable',
                    'Let by other agent'
                );

                $pstus = array(
                    'key' => '_InternalLettingStatus',
                    'value' => $no_disply_status_prt,
                    'compare' => 'NOT IN',
                );
            }
        }
    }

    if (isset($_POST['bed']))
    {
        $bed = array(
            'key' => '_bedrooms',
            'value' => $_POST['bed'],
            'compare' => '>=',
        );
    }
    if (isset($_POST['maxp']))
    {
        if ($search_url[1] == "sale" || $search_url[1] == "new_home")
        {
            $maxp = array(
                'key' => '_price',
                'value' => $_POST['maxp'],
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }
        else if ($search_url[1] == "letting")
        {
            $maxp = array(
                'key' => '_rent',
                'value' => $_POST['maxp'],
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }

        $_maxp = '';
        if (get_field("filter_property_price", "option"))
        {
            while (has_sub_field("filter_property_price", "option"))
            {
                if ($_POST['maxp'] == get_sub_field("filter_add_price_option_use", "option"))
                {
                    $_maxp = '£' . get_sub_field("filter_add_price_option", "option");
                }
            }
        }
    }
    if (isset($_POST['minp']))
    {
        if ($search_url[1] == "sale" || $search_url[1] == "new_home")
        {
            $minp = array(
                'key' => '_price',
                'value' => $_POST['minp'],
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
        else if ($search_url[1] == "letting")
        {
            $minp = array(
                'key' => '_rent',
                'value' => $_POST['minp'],
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
        $_minp = '';
        if (get_field("filter_property_price", "option"))
        {
            while (has_sub_field("filter_property_price", "option"))
            {
                if ($_POST['minp'] == get_sub_field("filter_add_price_option_use", "option"))
                {
                    $_minp = '£' . get_sub_field("filter_add_price_option", "option");
                }
            }
        }
    }
    if (isset($_POST['psize']))
    {
        $psize = str_replace("Over", "", str_replace(",", "", $_POST['psize']));
        $psize = explode("-", $psize);

        if (count($psize) == 1 && $psize[0] == 8000)
        {
            $pareasize = array(
                'key' => '_size',
                'value' => $psize[0],
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }
        else if (count($psize) == 2)
        {
            $pareasize = array(
                'relation' => 'AND',
                array(
                    'key' => '_size',
                    'value' => $psize[0],
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ) ,
                array(
                    'key' => '_size',
                    'value' => $psize[1],
                    'compare' => '<=',
                    'type' => 'NUMERIC'
                )
            );
        }
    }
    if (isset($_POST['ptage']))
    {
        $p_age = array();
        $p_age = explode(",", $_POST['ptage']);

        foreach ($p_age as $_p_age)
        {
            $_age = explode(" ", $_p_age);
            $ptage['relation'] = 'OR';
            $ptage[] = array(
                'key' => '_property_age',
                'value' => $_age[0],
                'compare' => 'Like',
            );
        }
    }
    if (isset($_POST['pfun']))
    {
        $pfun_arr = array();
        $pfun_arr = explode(",", $_POST['pfun']);

        foreach ($pfun_arr as $key => $_pfun)
        {

            $pfun['relation'] = 'AND';
            $pfun[] = array(
                'key' => '_furnishing',
                'value' => $_pfun,
                'compare' => 'Like',
            );
        }
    }
    if (isset($_POST['parea']))
    {
        $p_area = explode(",",$_POST['parea']);
        $breadcum_text = "in " . ucwords(preg_replace('/\\\\/i', '', $_POST['parea']));
        
        if($p_area[0] == "Regents Park" || $p_area[0] == "regents park")
        {
            $p_ser = "Regent&#039;s Park";    
        }else if(preg_replace('/\\\\/i', '',$p_area[0]) == "Queen's Park" || preg_replace('/\\\\/i', '',$p_area[0]) == "queen's park" )
        {
            $p_ser = "Queens Park";    
        }else if($p_area[0] == "St Johns Wood" || $p_area[0] == "st johns wood" || preg_replace('/\\\\/i', '',$p_area[0]) == "St. John's Wood")
        {
            $p_ser = "St John&#039;s Wood";    
        }else
        {
            $p_ser = str_replace("\'", "&#039;", ucwords(preg_replace('/\\\\/i', '',$p_area[0])));
            $p_ser = htmlentities($p_ser, ENT_QUOTES);
        }

        $parea = array(
            'relation' => 'OR',
             array(
                'key' => '_address_street',
                'value' => $p_ser,
                'compare' => 'Like',
            ) ,
            array(
                'key' => '_address_two',
                'value' => $p_ser,
                'compare' => 'Like',
            ) ,
            array(
                'key' => '_address_three',
                'value' => $p_ser,
                'compare' => 'Like',
            ) ,
            array(
                'key' => '_address_postcode',
                'value' => $p_ser,
                'compare' => 'Like',
            )
        );

    }
    if (isset($_POST['pamty']))
    {
        $pamty_arr = array();
        $pamty_arr = explode(",", $_POST['pamty']);
        $special_amty_arr = array();
        if (in_array("Garage/Parking", $pamty_arr))
        {
            array_push($special_amty_arr, "Resident Parking", "Off Street Parking", "Garage", "Double Garage", "Triple Garage");
            unset($pamty_arr[array_search('Garage/Parking', $pamty_arr) ]);
        }
        if (in_array("Concierge/Porterage", $pamty_arr))
        {
            array_push($special_amty_arr, "Porterage", "Concierge");
            unset($pamty_arr[array_search('Concierge/Porterage', $pamty_arr) ]);
        }
        if (in_array("Air Cooling System", $pamty_arr))
        {
            array_push($special_amty_arr, "Air Conditioning", "Comfort Cooling");
            unset($pamty_arr[array_search('Air Cooling System', $pamty_arr) ]);
        }
        if (in_array("Security System/CCTV", $pamty_arr))
        {
            array_push($special_amty_arr, "Security System", "CCTV");
            unset($pamty_arr[array_search('Security System/CCTV', $pamty_arr) ]);
        }
        //print_r($special_amty_arr);
        foreach ($pamty_arr as $key => $_amty)
        {

            $pamty['relation'] = 'AND';
            $pamty[] = array(
                'key' => '_property_all_keywords',
                'value' => $_amty,
                'compare' => 'Like',
            );
        }
        foreach ($special_amty_arr as $_special_amty)
        {
            $_specialpamty['relation'] = 'OR';
            $_specialpamty[] = array(
                'key' => '_property_all_keywords',
                'value' => $_special_amty,
                'compare' => 'Like',
            );
        }

    }

    if (isset($_POST['petfdy']))
    {
        if ($_POST['petfdy'] == 'yes')
        {
            $petfdy = array(
                'key' => '_property_amenities',
                'value' => "Pets",
                'compare' => 'Like',
            );
        }
        else if ($_POST['petfdy'] == 'no')
        {
            $petfdy = '';
        }
    }
    if (isset($_POST['area']))
    {
        $loc_name = "in " . '<strong>' . str_replace("\'", '&#039;', $_POST['area']) . '</strong>';
        alert($loc_name);
        $_area = str_replace("&#039;", "'", $_POST['area']);

        $area = array(
            'relation' => 'OR',
            array(
                'key' => '_address_two',
                'value' => $_area,
                'compare' => '==',
            ) ,
            array(
                'key' => '_address_three',
                'value' => $_area,
                'compare' => '==',
            )
        );
    }
    if (isset($_POST['srtbyprice']))
    {
        if ($_POST['srtbyprice'] == "low" || $_POST['srtbyprice'] == "high")
        {
            if ($search_url[1] == "sale" || $search_url[1] == "new_home")
            {
                $price_order_meta_key = "_price";

            }
            else if ($search_url[1] == "letting")
            {
                $price_order_meta_key = "_rent";

            }
            $orderby = "meta_value_num";
        }
        else
        {
            $orderby = "meta_value";
            $price_order_meta_key = '_TimeAmended';

        }
        if ($_POST['srtbyprice'] == "low")
        {
            $order = "ASC";
        }
        else if ($_POST['srtbyprice'] == "high")
        {

            $order = "DESC";
        }
        else if ($_POST['srtbyprice'] == "recent")
        {

            $order = "DESC";
        }

    }
    else
    {
        $orderby = "meta_value";
        $price_order_meta_key = '_TimeAmended';
        $order = "DESC";
    }

    if ($search_url[1] == "new_home")
    {
        $new_home = array(
            'key' => '_is_new_home_property',
            'value' => "yes",
            'compare' => '==',
        );
    }

    if (!wp_verify_nonce($_POST['map_search_nonce'], 'map_search_nonce'))
    {

        $response['alert'] = __('Failed security check!', 'twentytwenty');

    }
    else
    {
        $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $_args = array(
            'paged' => $paged,
            'post_type' => 'property',
            'posts_per_page' => - 1,
            'post_status' => 'publish',
            'meta_key' => $price_order_meta_key,
            'orderby' => $orderby,
            'order' => $order,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_department',
                    'value' => $_depname,
                    'compare' => '==',
                ) ,
                $bed,
                $parea,
                $pamty,
                $_specialpamty,
                $pfun,
                $ptage,
                $minp,
                $maxp,
                $pstus,
                $psty,
                $pareasize,
                $petfdy,
                $area,
                $_area,
                $new_home,
                $subplot,
            ) ,
        );
        add_filter('posts_where', 'title_filter', 10, 2);
        $propty_seach_qry = new WP_Query($_args);
        //echo $propty_seach_qry->found_posts;exit;
        remove_filter('posts_where', 'title_filter', 10);
        $_all_propery_arr = array();
        if ($propty_seach_qry->have_posts())
        {
            $i = 0;
            while ($propty_seach_qry->have_posts())
            {
                $propty_seach_qry->the_post();
                $property = new PH_Property(get_the_ID());
                $ImageSlides = $property->get_gallery_attachment_ids();
                $_bathrooms = get_post_meta(get_the_ID() , '_bathrooms', true);
                $_bedrooms = get_post_meta(get_the_ID() , '_bedrooms', true);
                $_size_string = get_post_meta(get_the_ID() , '_size_string', true);
                $_SaleStatus = get_post_meta(get_the_ID() , '_SaleStatus', true);
                $_available = get_post_meta(get_the_ID() , '_available', true);
                $_currency = get_post_meta(get_the_ID() , '_currency', true);
                $_latitude = get_post_meta(get_the_ID() , '_latitude', true);
                $_longitude = get_post_meta(get_the_ID() , '_longitude', true);
                $_saved_prperty = get_post_meta(get_the_ID() , 'saved_prperty', true);
                $_prperty_user_id = get_post_meta(get_the_ID() , 'prperty_user_id', true);
                $logged_user_id = $_POST['cur_user_id'];
                $_PriceString       = get_post_meta(get_the_ID(),'_price_qualifier',true);
                if ((isset($_saved_prperty) && $_saved_prperty == 1) && ($_prperty_user_id == $logged_user_id))
                {
                    $saved_cls = "active";
                    $faved_cls = "faved";
                }
                else
                {
                    $saved_cls = "";
                    $faved_cls = "";
                }

                if ($search_url[1] == "sale" || $search_url[1] == "new_home")
                {
                    $_status = get_post_meta(get_the_ID() , '_InternalSaleStatus', true);
                }
                else if ($search_url[1] == "letting")
                {
                    $_status = get_post_meta(get_the_ID() , '_InternalLettingStatus', true);
                }

                if ($_currency == "GBP")
                {
                    $currency = '£';
                }
                //echo get_post_meta(get_the_ID(), '_rent',true);
                if ($search_url[1] == "sale" || $search_url[1] == "new_home")
                {
                    if (isset($_POST['cur']))
                    {
                        if ($_POST['cur'] == 'EUR')
                        {
                            $cur_sybol = '€';
                        }
                        else if ($_POST['cur'] == 'USD')
                        {
                            $cur_sybol = '$';
                        }

                        $_price = get_post_meta(get_the_ID() , '_price', true);
                        $covert_price = $_POST['cur_conveter'] * $_price;
                        $property_price = $cur_sybol . number_format($covert_price, 2, get_option('propertyhive_price_decimal_separator', '.') , get_option('propertyhive_price_thousand_separator', ','));

                    }
                    else
                    {
                        $property_price = $property->get_formatted_price();
                    }
                }
                else if ($search_url[1] == "letting")
                {
                    $_rent_frequency = get_post_meta(get_the_ID() , '_rent_frequency', true);
                    $_rent_price = str_replace("&#163;", "", get_post_meta(get_the_ID() , '_rent', true));

                    if ($_rent_frequency == "pd")
                    {
                        $r_frequency = "per day";
                    }
                    else if ($_rent_frequency == "pw")
                    {
                        $r_frequency = "per week";
                    }
                    else if ($_rent_frequency == "pq")
                    {
                        $r_frequency = "per quarter";
                    }
                    else if ($_rent_frequency == "pa")
                    {
                        $r_frequency = "per annum";
                    }
                    if (isset($_POST['cur']))
                    {
                        if ($_POST['cur'] == 'EUR')
                        {
                            $cur_sybol = '€';
                        }
                        else if ($_POST['cur'] == 'USD')
                        {
                            $cur_sybol = '$';
                        }

                        $covert_price = $_POST['cur_conveter'] * $_rent_price;

                        $property_price = $cur_sybol . number_format($covert_price, 2, get_option('propertyhive_price_decimal_separator', '.') , get_option('propertyhive_price_thousand_separator', ',')) . " " . $r_frequency;

                    }
                    else
                    {
                        $property_price = $currency . number_format($_rent_price) . " " . $r_frequency;
                    }
                }
                $_imgs_url = array();
                foreach ($ImageSlides as $_img_id)
                {
                    $_imgs_url[] = wp_get_attachment_image_url($_img_id, "medium");
                }
                $static_block_one = get_field("property_static_block_one", "option");
                $static_block_two = get_field("property_static_block_two", "option");

                $tenure = strtoupper($property->tenure);
                if($_PriceString == "PA")
                {
                    $property_price = "Price on Application";
                }else
                {
                    $property_price = $property_price;
                }
                if ($_longitude != 0 && $_latitude != 0)
                {
                    $_all_propery_arr[$i]['title'] = get_the_title();
                    $_all_propery_arr[$i]['pid'] = get_the_ID();
                    $_all_propery_arr[$i]['ImageSlides'] = $_imgs_url;
                    $_all_propery_arr[$i]['thumbnailImageWithExt'] = @$_imgs_url[0];
                    $_all_propery_arr[$i]['bathrooms'] = $_bathrooms;
                    $_all_propery_arr[$i]['bedrooms'] = $_bedrooms;
                    $_all_propery_arr[$i]['tenure'] = $tenure;
                    $_all_propery_arr[$i]['status'] = $_status;
                    $_all_propery_arr[$i]['available'] = $_available;
                    $_all_propery_arr[$i]['currency'] = $currency;
                    $_all_propery_arr[$i]['property_price'] = $property_price;
                    $_all_propery_arr[$i]['longitude'] = $_longitude;
                    $_all_propery_arr[$i]['latitude'] = $_latitude;
                    $_all_propery_arr[$i]['property_url'] = get_permalink();
                    $_all_propery_arr[$i]['user_id'] = $_user_id;
                    $_all_propery_arr[$i]['saved_cls'] = $saved_cls;
                    $_all_propery_arr[$i]['faved_cls'] = $faved_cls;
                    $_all_propery_arr[$i]['aheart'] = '';
                    $_all_propery_arr[$i]['static_block_one'] = $static_block_one;
                    $_all_propery_arr[$i]['static_block_two'] = $static_block_two;

                    $i++;
                }

            }
        }
        wp_reset_postdata();
        $response['res_data'] = $_all_propery_arr;
    }
    //print_r($response);exit;
    echo json_encode($response);
    wp_die();
}

function currency_conveter($cur)
{
    $api_key = get_field("currency_api_key", "option");

    $currency1 = 'GBP';
    $currency2 = $cur;

    $url = "https://www.amdoren.com/api/currency.php?api_key=$api_key&from=$currency1&to=$currency2";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $json_string = curl_exec($ch);
    $parsed_json = json_decode($json_string);

    $error = $parsed_json->error;
    $error_message = $parsed_json->error_message;
    return $amount = $parsed_json->amount;
}

function Property_Email_Alert_To_User()
{
    global $wpdb, $post;
    $saved_proty_tbl = $wpdb->prefix . "saved_properties";
    $master_proty_tbl = $wpdb->prefix . "properties";
    $alert_saved_data = $wpdb->get_results("SELECT * FROM $saved_proty_tbl where email_alert = 1");
    $date = date('Y-m-d');

    $_today_proty_ids = $wpdb->get_results("SELECT property_post_id FROM $master_proty_tbl where created_date like '%$date%'");

    $rs_array = [];
    $_pid = [];

    foreach ($_today_proty_ids as $_ids)
    {
        $_pid[] = $_ids->property_post_id;
    }

    foreach ($alert_saved_data as $_data)
    {
        $rs_array[$_data->user_id][] = $_data;
    }

    if (!empty($_today_proty_ids))
    {
        $_match_proty = new WP_Query(array(
            'post_type' => 'property',
            'posts_per_page' => - 1,
            'post_status' => 'publish',
            'post__in' => $_pid,
        ));

        $_matched_proty_arr = [];

        if ($_match_proty->have_posts())
        {
            while ($_match_proty->have_posts())
            {
                $_match_proty->the_post();

                $property_url = site_url() . "/property/" . $post->post_name;
                $mail_property = new PH_Property(get_the_ID());
                $tenure_name = $mail_property->get_tenure();
                $property_price = $mail_property->get_formatted_price();
                $bannerSlides = $mail_property->get_gallery_attachment_ids();
                $_bedrooms = get_post_meta(get_the_ID() , '_bedrooms', true);
                $_size_ft = get_post_meta(get_the_ID() , '_size', true);
                $_size_m = get_post_meta(get_the_ID() , '_size_m', true);
                $_amity_keywords = get_post_meta(get_the_ID() , '_property_all_keywords', true);
                $_department = get_post_meta(get_the_ID() , '_department', true);
                $_prperty_user_id = get_post_meta(get_the_ID() , 'prperty_user_id', true);
                $_SaleStatus = get_post_meta(get_the_ID() , '_InternalSaleStatus', true);
                $_LettingStatus = get_post_meta(get_the_ID() , '_InternalLettingStatus', true);
                $_price = get_post_meta(get_the_ID() , '_price', true);
                $_rent_price = str_replace("&#163;", "", get_post_meta(get_the_ID() , '_rent', true));
                $_property_style = get_post_meta(get_the_ID() , '_property_style', true);
                $_property_age = get_post_meta(get_the_ID() , '_property_age', true);
                $_property_type = get_post_meta(get_the_ID() , '_property_type', true);
                $_furnishing = get_post_meta(get_the_ID() , '_furnishing', true);

                $re_bool = false;
                //$_property_amety1 = array_filter($_property_amety);
                /*echo "<pre>";
                 print_r($_amity_keywords);*/
                foreach ($rs_array as $key => $rs_value)
                {

                    foreach ($rs_value as $key1 => $rs_child_val)
                    {
                        $amty = explode(",", $rs_child_val->amty);
                        $amty = array_filter($amty);

                        $age = explode(",", $rs_child_val->age);
                        $age = array_filter($age);

                        $ptype = explode(",", $rs_child_val->ptype);
                        $ptype = array_filter($ptype);

                        //$_amity_keywords1 = array_filter($_amity_keywords);
                        if ($rs_child_val->bed != 0 && $_bedrooms >= $rs_child_val->bed)
                        {
                            $re_bool = true;
                        }

                        if ($rs_child_val->min_price != 0 && $rs_child_val->max_price != 0)
                        {
                            if ($_department == "residential-sales")
                            {
                                if ($_price >= $rs_child_val->min_price && $_price <= $rs_child_val->max_price)
                                {
                                    $re_bool = true;
                                }

                            }
                            else if ($_department == "residential-lettings")
                            {
                                if ($_rent_price >= $rs_child_val->min_price && $_rent_price <= $rs_child_val->max_price)
                                {
                                    $re_bool = true;
                                }
                            }
                        }
                        else if ($rs_child_val->min_price != 0)
                        {

                            if ($_department == "residential-sales")
                            {
                                if ($_price >= $rs_child_val->min_price)
                                {
                                    $re_bool = true;
                                }

                            }
                            else if ($_department == "residential-lettings")
                            {
                                if ($_rent_price >= $rs_child_val->min_price)
                                {
                                    $re_bool = true;
                                }
                            }
                        }
                        else if ($rs_child_val->max_price != 0)
                        {
                            if ($_department == "residential-sales")
                            {
                                if ($_price <= $rs_child_val->max_price)
                                {
                                    $re_bool = true;
                                }

                            }
                            else if ($_department == "residential-lettings")
                            {
                                if ($_rent_price <= $rs_child_val->max_price)
                                {
                                    $re_bool = true;
                                }
                            }
                        }
                        if (in_array(strtolower($_property_type) , $ptype) || in_array($_property_style, $ptype))
                        {
                            $re_bool = true;
                        }
                        if (in_array($_property_age, $age))
                        {
                            $re_bool = true;
                        }
                        if (!empty($_amity_keywords) && isset($_amity_keywords))
                        {

                            if (in_array("Garage/Parking", $amty))
                            {
                                array_push($amty, "Resident Parking", "Off Street Parking", "Garage", "Double Garage", "Triple Garage");
                            }
                            if (in_array("Concierge/Porterage", $amty))
                            {
                                array_push($amty, "Porterage", "Concierge");
                            }
                            if (in_array("Air Cooling System", $amty))
                            {
                                array_push($amty, "Air Conditioning", "Comfort Cooling");
                            }
                            if (in_array("Security System/CCTV", $amty))
                            {
                                array_push($amty, "Security System", "CCTV");
                            }

                            $_get_amty = array_intersect($amty, $_amity_keywords);
                            if (count($_get_amty) > 0)
                            {
                                $re_bool = true;
                            }
                        }

                        if (@in_array($rs_child_val->pfun, $_furnishing))
                        {
                            $re_bool = true;
                        }
                        if (@in_array($rs_child_val->petfdy, $_property_amety))
                        {
                            $re_bool = true;
                        }
                        if ($rs_child_val->status == "no")
                        {
                            if ($_department == "residential-sales")
                            {
                                $no_disply_status_prt = array(
                                    'For Sale - Unavailable',
                                    'Completed - Available',
                                    'Exchanged - Available',
                                    'Sold',
                                    'Completed',
                                    'Exchanged'
                                );
                                if (!in_array($_SaleStatus, $no_disply_status_prt))
                                {
                                    $re_bool = true;
                                }

                            }
                            else if ($_department == "residential-lettings")
                            {
                                $no_disply_status_prt = array(
                                    'Tenancy Current - Unavailable',
                                    'To Let - Unavailable',
                                    'Let by other agent',
                                    'Sold'
                                );
                                if (!in_array($_LettingStatus, $no_disply_status_prt))
                                {
                                    $re_bool = true;
                                }
                            }
                        }
                        else if ($rs_child_val->status == "yes")
                        {
                            if ($_department == "residential-sales")
                            {
                                $no_disply_status_prt = array(
                                    'For Sale - Unavailable',
                                    'Completed - Available',
                                    'Exchanged - Available'
                                );
                                if (!in_array($_SaleStatus, $no_disply_status_prt))
                                {
                                    $re_bool = true;
                                }

                            }
                            else if ($_department == "residential-lettings")
                            {
                                $no_disply_status_prt = array(
                                    'Tenancy Current - Unavailable',
                                    'To Let - Unavailable',
                                    'Let by other agent'
                                );
                                if (!in_array($_LettingStatus, $no_disply_status_prt))
                                {
                                    $re_bool = true;
                                }
                            }
                        }
                        if (isset($rs_child_val->psq_ft))
                        {
                            $psq_ft = str_replace("Over", "", str_replace(",", "", $rs_child_val->psq_ft));
                            $psq_ft = explode("-", $psq_ft);
                            if (count($psq_ft) == 1 && $psq_ft[0] == 8000)
                            {
                                if ($_size_ft >= $psq_ft[0])
                                {
                                    $re_bool = true;
                                }
                            }
                            else if (count($psq_ft) == 2)
                            {
                                if ($_size_ft >= $psq_ft[0] && $_size_ft <= $psq_ft[1])
                                {
                                    $re_bool = true;
                                }
                            }
                        }
                        if (isset($rs_child_val->psq_m))
                        {
                            $psq_m = str_replace("Over", "", str_replace(",", "", $rs_child_val->psq_m));
                            $psq_m = explode("-", $psq_m);
                            if (count($psq_m) == 1 && $psq_m[0] == 750)
                            {
                                if ($_size_m >= $psq_m[0])
                                {
                                    $re_bool = true;
                                }
                            }
                            else if (count($psq_m) == 2)
                            {
                                if ($_size_m >= $psq_m[0] && $_size_m <= $psq_m[1])
                                {
                                    $re_bool = true;
                                }
                            }
                        }

                    }
                    if ($re_bool)
                    {

                        $_matched_proty_arr[$key][] = array(
                            'p_title' => get_the_title() ,
                            'p_img' => wp_get_attachment_image_url($bannerSlides[0], "full") ,
                            'p_status' => $tenure_name,
                            'p_price' => $property_price,
                            'p_url' => $property_url,
                        );
                    }
                }
            }
        }
        wp_reset_postdata();

        $mail_middle_content = '';
        if (!empty($_matched_proty_arr))
        {
            foreach ($_matched_proty_arr as $m_key => $m_res)
            {
                $user_data = get_user_by('id', $m_key);
                $mail_header_content = make_email_template(get_field("matched_email_header_content", "option") , array(
                    'USERNAME' => $user_data->display_name
                ));
                $mail_footer_content = get_field("matched_email_footer_content", "option");

                foreach ($m_res as $key => $value)
                {
                    $mail_middle_content .= '<tr>';
                    $mail_middle_content .= '<td align="left" valign="top" style="padding: 45px 50px 0px 50px;">';
                    $mail_middle_content .= '<table width="100%" cellpadding="0" cellspacing="0">';
                    $mail_middle_content .= '<tr>';
                    $mail_middle_content .= '<td align="left" valign="top"><a href="' . $value['p_url'] . '"><img src="' . $value['p_img'] . '" alt="img" width="495" ></a></td>';
                    $mail_middle_content .= '</tr>';
                    $mail_middle_content .= '<tr>';
                    $mail_middle_content .= '<td align="left" valign="top">';
                    $mail_middle_content .= '<table width="100%" cellpadding="0" cellspacing="0">';
                    $mail_middle_content .= '<tr>';
                    $mail_middle_content .= '<td align="left" valign="top"><p style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: #000000;line-height: 26px;font-weight: 400;margin: 0 0 0 0;width: 78%;">' . $value['p_title'] . '</p></td>';
                    $mail_middle_content .= '<td align="right" valign="top">';
                    $mail_middle_content .= '<p style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: #000000;line-height: 26px;font-weight: 600;margin: 0 0 0 0;">' . $value['p_status'] . '</p>';
                    $mail_middle_content .= '<p style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: #000000;line-height: 26px;font-weight: 600;margin: 0 0 0 0;">' . $value['p_price'] . '</p>';

                    $mail_middle_content .= '</td>';
                    $mail_middle_content .= '</tr>';
                    $mail_middle_content .= '</table>';
                    $mail_middle_content .= '</td>';
                    $mail_middle_content .= '</tr>';

                    $mail_middle_content .= '</table>';
                    $mail_middle_content .= '</td>';
                    $mail_middle_content .= '</tr>';
                }
                //echo $mail_middle_content;
                $to = $user_data->user_email;
                $subject = get_field("matched_email_subject", "option");
                //$user_headers = array('Content-Type: text/html; charset=UTF-8');
                //$user_headers[] = 'From: '. get_bloginfo( 'name' ).'j' . '<'.get_option('admin_email').'>';
                $user_headers = "MIME-Version: 1.0" . "\r\n";
                $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $user_headers .= 'From: ' . get_bloginfo('name') . '<' . get_option('admin_email') . '>' . "\r\n";

                $mail_content = $mail_header_content . $mail_middle_content . $mail_footer_content;
                mail($to, $subject, $mail_content, $user_headers);
            }

        }
    }

}
?>
