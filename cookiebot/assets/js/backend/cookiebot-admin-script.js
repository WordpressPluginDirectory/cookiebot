/**
 * Load init function when the page is ready
 *
 * @since 4.2.10
 */
jQuery( document ).ready( cbInit );

function cbInit() {
    jQuery( document ).on( 'click', 'tr[data-slug="cookiebot"] .cb-deactivate-action', event => deactivateCookiebot( event ) );
    jQuery( document ).on( 'click', '#cb-review__close', event => closeSurveyPopup( event ) );
    jQuery( document ).on( 'submit', '#cb-review__form', event => submitSurveyPopup( event ) );
    jQuery( document ).on( 'change', 'input[name="cookiebot-review-option"]', event => showOptionalConsent( event ) )
    hideSubmitMessage();
    selectorListeners();
}

/**
 * Displays popup form.
 */
function deactivateCookiebot( e ) {
    e.preventDefault();

    let deactivationLink = e.target.href;

    jQuery( '#cb-review__skip' ).attr( 'href', deactivationLink );
    jQuery( '.cookiebot-popup-container' ).addClass( 'cb-opened' );
}

/**
 * Close popup form.
 */

function closeSurveyPopup(e) {
    const popup = jQuery(e.target).closest('.cookiebot-popup-container');
    popup.removeClass('cb-opened');
    jQuery('#cb-review__alert').removeClass('show-alert');
    document.getElementById('cb-review__form').reset();
}

/**
 * Shows optional consent.
 */

function showOptionalConsent(e) {
    const option = e.target.value;
    const optionalConsentBox = jQuery('.consent-item');
    const optionalConsent = jQuery('#cb-review__debug-reason');

    if(option!=='7'){
        optionalConsentBox.removeClass('show-consent');
        if(optionalConsent.checked){
            optionalConsent.checked = false;
        }
    }else{
        optionalConsentBox.addClass('show-consent');
    }
}

/**
 * Popup submit
 */
function submitSurveyPopup(e){
    e.preventDefault();
    const deactivateLink = jQuery( '#cb-review__skip' ).attr( 'href' );
    const button = jQuery('#cb-review__submit', '#cb-review__form');
    if (button.hasClass('disabled')) {
        return;
    }
    const option = jQuery('input[type="radio"]:checked', '#cb-review__form');
    if(0 === option.length){
        jQuery('#cb-review__alert').addClass('show-alert');
        return;
    }
    const otherReason = jQuery('#cb-review__other-description');
    const debugReason = jQuery('#cb-review__debug-reason');
    jQuery.ajax({
        url: cb_ajax.ajax_url,
        type: 'POST',
        data: {
            action: 'cb_submit_survey',
            reason_id: (0 === option.length) ? null : option.val(),
            reason_text: (0 === option.length) ? 'none' : option.closest('label').text(),
            reason_info: (0 !== otherReason.length) ? otherReason.val().trim() : '',
            reason_debug: (!debugReason) ? null : debugReason.val(),
            survey_nonce: cb_ajax.survey_nonce,
            survey_check: 'ODUwODA1'
        },
        beforeSend: function() {
            button.addClass('disabled');
        },
        complete: function(response) {
            const code = JSON.parse(response.responseText).code;
            const msg = JSON.parse(response.responseText).data;

            if(code===400||code===401){
                jQuery('#cb-review__alert').text(msg).addClass('show-alert');
                button.removeClass('disabled');
            }else{
                window.location.href = deactivateLink;
            }
        }
    });
}

function hideSubmitMessage(){
    let submitMsg = jQuery('.cb-submit__msg');
    if(submitMsg){
        setTimeout(function(){
            submitMsg.fadeOut();
        },2000)
    }
}

function selectorListeners(){
    openItemList();
    closeitemList();
    selectListItem();
    searchListItem();
}

function openItemList() {
    jQuery(document).on('click','.cb-settings__selector__container .cb-settings__selector-selector',function(){
        jQuery('.cb-settings__selector-list-container').addClass('hidden');
        jQuery(this).siblings('.cb-settings__selector-list-container').removeClass('hidden');
    });
}

function closeitemList() {
    jQuery(document).on('click','.cb-settings__selector__container .cb-settings__selector-veil',function(){
        jQuery(this).parent('.cb-settings__selector-list-container').addClass('hidden');
        jQuery(this).siblings('.cb-settings__selector-search').val('').trigger('keyup');
        jQuery(this).siblings('.cb-settings__selector-list').scrollTop(0);
    });
}

function selectListItem() {
    jQuery(document).on('click','.cb-settings__selector__container .cb-settings__selector-list-item',function(){
        const item = jQuery(this);
        const mainParent = item.closest('.cb-settings__selector__container');
        const itemList = item.parent('.cb-settings__selector-list');
        const itemValue = item.data('value');
        const itemAttr = 'cookiebot-tcf-disallowed['+itemValue+']';
        const itemName = item.text();

        if(!itemList.data('multiple')){
            itemList.find('.selected').removeClass('selected');
        }

        item.addClass('selected');
        mainParent.find('.cb-settings__selector-selector').text(itemName);
        mainParent.find('.cb-settings__selector__container-input').val(itemValue).attr('name',itemAttr).trigger('change');
        mainParent.find('.cb-settings__selector-search').val('').trigger('keyup');
        itemList.scrollTop(0);

        item.closest('.cb-settings__selector-list-container').addClass('hidden');
    });
}

function searchListItem() {
    jQuery(document).on('keyup','.cb-settings__selector-search',function(){
        const searchName = jQuery(this).val().toLowerCase();
        const itemList = jQuery(this).siblings('.search-list');

        itemList.children().each(function(){
            const item = jQuery(this);
            if(searchName.length>0) {
                const itemName = item.text().trim().toLowerCase();
                if(itemName.indexOf(searchName) != -1){
                    item.removeClass('hidden');
                }else{
                    item.addClass('hidden');
                }
            }else{
                item.removeClass('hidden');
            }
        });

    });
}