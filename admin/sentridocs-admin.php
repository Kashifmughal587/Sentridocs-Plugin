<?php
function sentridocs_admin_menu() {
    if (sentridocs_is_activated()) {
        add_menu_page(
            'Sentridocs Settings',
            'Sentridocs',
            'manage_options',
            'sentridocs_settings',
            'sentridocs_settings_page',
            'dashicons-admin-generic',
            20
        );
    }else{
        add_menu_page(
            'Sentridocs Settings',
            'Sentridocs',
            'manage_options',
            'sentridocs_settings',
            'sentridocs_show_license_key_form',
            'dashicons-admin-generic',
            20
        );
    }
    
}
add_action('admin_menu', 'sentridocs_admin_menu');

function sentridocs_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'url' => 'https://sentridocs.com/refinance.php', // Default URL if not provided
        'height' => '500px', // Default height
        'width' => '100%', // Default width
    ), $atts);

    // Sanitize attributes
    $url = esc_url($atts['url']);
    $height = esc_attr($atts['height']);
    $width = esc_attr($atts['width']);

    // Perform additional security checks
    if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
        // Return the iframe code for embedding the form
        return '<iframe src="' . $url . '" width="' . $width . '" height="' . $height . '" frameborder="0"></iframe>';
    } else {
        return '<p>Error: Invalid URL provided.</p>';
    }
}
add_shortcode('sentridocs', 'sentridocs_shortcode');

function sentridocs_shortcode_calculator() {?>
	<form action="" method="post" id="rmcForm">
        <table>
            <tbody>
                <tr>
                    <td class="width70"><span class="tooltip tooltipstered">Home's Appraised Value</span>
                    </td>
                    <td class="width20"><input type="text" name="appraised_value" id="appraised_value" value="$500,000"></td>
                    <td class="width20"></td>
                    <td class="width20"></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">HECM Eligible Amount</span>
                    </td>
                    <td class="nowrap"><input type="text" name="eligible_amount" id="eligible_amount" value="$500,000" readonly="" class="readonly"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">10-Year LIBOR Swap Rate</span>
                    </td>
                    <td class="nowrap"><input type="text" name="libor_swap_rate" id="libor_swap_rate" autocomplete="off" value="2.4%"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Lender's Margin</span>
                    </td>
                    <td class="nowrap"><input type="text" name="lenders_margin" id="lenders_margin" value="3.00%"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Monthly Insurance <a href="https://retirementresearcher.com/glossary/premium/" data-cmtooltip="<div class=glossaryItemTitle>Premium</div><div class=glossaryItemBody>A return difference between two assets or portfolios.</div>" class="glossaryLink ">Premium</a></span>
                    </td>
                    <td class="nowrap"><input type="text" name="monthly_insurance_premium" readonly="" class="readonly" id="monthly_insurance_premium" value="1.25%"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Age of Youngest Eligible (Borrower or Non-Borrower) Spouse
                        Note: Round age up if birthday falls within six months of the first day of the month that the loan will close</span>
                    </td>
                    <td class="nowrap"><input type="text" pattern="\d*" name="youngest_eligible_spouse" id="youngest_eligible_spouse" value="65"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right form-label"><span class="tooltip tooltipstered">Age</span>
                    </td>
                    <td class="text-right form-label"><span class="tooltip tooltipstered">Modified Expected Rate</span>
                    </td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Principal Limit Factor</span>
                    </td>
                    <td class="nowrap"><input type="text" readonly="" class="readonly" name="principal_limit_factor" id="principal_limit_factor" value="14.80%"></td>
                    <td class="nowrap"><input type="text" readonly="" class="readonly" id="age" name="age" value="65"></td>
                    <td class="nowrap"><input type="text" readonly="" class="readonly" id="modified_expected_rate" name="modified_expected_rate" value="10.00%"></td>
                </tr>
                <tr class="">
                    <td></td>
                    <td></td>
                    <td class="text-right form-label"><span class="tooltip tooltipstered">Maximum Possible Amount</span>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="capt"><span class="tooltip tooltipstered">Loan origination fee</span>
                    </td>
                    <td class="nowrap"><input type="text" name="loan_origination_fee" id="loan_origination_fee" value="$0"></td>
                    <td class="nowrap"><input type="text" name="loan_origination_fee_max" id="loan_origination_fee_max" readonly="" class="readonly" value="$6,000"></td>
                    <td></td>
                </tr>
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="capt"><span class="tooltip tooltipstered">Will You Borrow Less Than 60% of the Principal Limit in the First Year?</span>
                    </td>
                    <td class="nowrap">
                        <select name="will_you_borrow" id="will_you_borrow"><option value="1" selected="">Yes</option><option value="2">No</option></select></td>
                    <td></td>
                    <td></td>
                </tr><tr class="empty-row"><td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr><tr><td class="capt"><span class="tooltip tooltipstered">Initial mortgage insurance</span>
                    </td>
                    <td class="nowrap"><input type="text" name="initial_mortgage_insurance" id="initial_mortgage_insurance" readonly="" class="readonly" value="$1,500"></td>
                    <td></td>
                    <td></td>
                </tr><tr><td class="capt"><span class="tooltip tooltipstered">Other closing costs (appraisal, titling, etc.)</span>
                    </td>
                    <td class="nowrap"><input type="text" name="other_closing_costs" id="other_closing_costs" value="$2,500"></td>
                    <td></td>
                    <td></td>
                </tr><tr class="empty-row"><td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr><tr><td class="upper"><span class="tooltip tooltipstered"><strong>Total
                        Upfront Costs</strong></span></td>
                    <td class="nowrap"><input type="text" name="total_upfront_costs" id="total_upfront_costs" readonly="" class="readonly" value="$4,000"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Percentage of Upfront Costs to be Financed</span>
                    </td>
                    <td class="nowrap"><input type="text" name="upfront_costs_to_be_financed" id="upfront_costs_to_be_financed" value="0%"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Debt Repayment, Repairs, or Other Life-Expectancy Set-Aside (LESA) Requirements</span>
                    </td>
                    <td class="nowrap"><input type="text" name="lesa_requirements" id="lesa_requirements" value="$0"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="upper"><span class="tooltip tooltipstered"><strong>Net
                                Available HECM Credit</strong></span></td>
                    <td class="nowrap"><input type="text" name="available_hecm_credit" id="available_hecm_credit" readonly="" class="readonly" value="$44400"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="border-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-right form-label">Monthly</td>
                    <td class="text-right form-label">Annual</td>
                    <td class="text-right form-label"><span class="tooltip tooltipstered">Payout Rate</span>
                    </td>
                </tr>
                <tr>
                    <td class="upper"><span class="tooltip tooltipstered"><strong>Net
                                Available as a Tenure Payment</strong></span></td>
                    <td class="nowrap"><input type="text" name="tenure_payment_monthly" id="tenure_payment_monthly" readonly="" class="readonly" value="$421"></td>
                    <td class="nowrap"><input type="text" name="tenure_payment_annual" id="tenure_payment_annual" readonly="" class="readonly " value="$5049"></td>
                    <td class="nowrap"><input type="text" name="payout_rate" id="payout_rate" readonly="" class="readonly " value="11.37%"></td>
                </tr>
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="tooltip tooltipstered">Term Payment Calculator</span>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Desired Term Horizon (Years)</td>
                    <td class="nowrap"><input type="text" name="desired_term_horizon" id="desired_term_horizon" value="20"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="form-label text-right">Monthly</td>
                    <td class="form-label text-right">Annual</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="upper"><strong>Net Available as a Term Payment</strong></td>
                    <td class="nowrap"><input type="text" name="term_payment_monthly" id="term_payment_monthly" readonly="" class="readonly" value="$427"></td>
                    <td class="nowrap"><input type="text" name="term_payment_annual" id="term_payment_annual" readonly="" class="readonly " value="$5127"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>
    		<span>Note: Modified Expected Rate is rounded down to nearest 0.125% multiple. Also, this rate cannot be less than 5%
            or greater than 10%.</span>

        </p>
    </form>
<?php
	}
	add_shortcode( 'sentridocs_calculator', 'sentridocs_shortcode_calculator' );

function sentridocs_settings_page() {
    $is_activated = sentridocs_is_activated();
    echo '<div class="wrap">';
    echo '<h1>Sentridocs Settings</h1>';
    echo '<p>This is where you can configure Sentridocs plugin settings.</p>';
    echo '<p>Short code for Sentridocs form is : <strong>[sentridocs]</strong></p>';
    // echo do_shortcode('[sentridocs url="https://sentridocs.com/refinance.php" height="500px" width="100%"]');
    echo '<p>Short code for Sentridocs Calculator is : <strong>[sentridocs_calculator]<strong></p>';
    // echo do_shortcode('[sentridocs_calculator]');
    echo '</div>';
}
?>
