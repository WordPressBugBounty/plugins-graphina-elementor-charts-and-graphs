import Swal from 'sweetalert2-neutral';

export default class Graphina_Admin_Dashboard{
    
    constructor(){
        this.init()
    }

    init(){
        this.eventHandlers();
        this.getDisabledWidget();
    }

    eventHandlers() {
        jQuery(document.body)
            .on('click', '.graphina-notice .notice-dismiss', this.handleIqonicNotice.bind(this))
            .on('click', '#graphina_setting_save_button', this.handleSettingSave.bind(this))
            .on('click', '#graphina_database_save_button', this.handleDatabaseSave.bind(this))
            .on('click', '#graphina-database-delete', this.handleDatabaseDelete.bind(this))
            .on('click', '#graphina_test_db_btn', this.handleDatabaseTest.bind(this))
            .on('change', '#enable_chart_filter', this.handleLoaderDisplay.bind(this))
            .on('click', '#graphina_upload_loader', this.handleLoaderUpload.bind(this))
            // Enable all toggles
            .on('click', '.graphina-enable-all-apex-chart', this.debounce(this.handleEnableAllChart.bind(this), 300))
            // Disable all toggles
            .on('click', '.graphina-disable-all-apex-chart', this.debounce(this.handleDisableAllChart.bind(this), 300))
            // Enable specific toggles
            .on('click', '.graphina-apex-toggle', this.debounce(this.handleDisableChart.bind(this), 300))
            // Chart type switching
            .on('click', '.graphina-chart-type', this.handleChartTypeSwitch.bind(this))
    }

    debounce = (func, delay) => {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    };

    handleIqonicNotice(e){
        e.preventDefault()
        let key = jQuery('.graphina-notice #graphina-notice-id').val();
        let nounce = jQuery('.graphina-notice #graphina-notice-nounce').val();
        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "GET",
            data: {
                action: 'graphina_dismiss_notice',
                nounce: nounce,
                key: key
            }
        })
        
    }

    getDisabledWidget(){
        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "GET",
            data: {
                action: 'graphina_get_disabled_widgets',
            },
            success: function (response) {
                document.querySelectorAll('.graphina-apex-toggle').forEach(label => {
                    // Get the value of the "data-widget" attribute
                    const widgetData = JSON.parse(label.getAttribute('data-widget'));
                    // Check if the "data-widget" value matches `["area_chart"]`
                    if (response.data.includes(widgetData[0])) {
                        // Find the input element inside the label and uncheck it
                        const input = label.querySelector('input[type="checkbox"]');
                        if (input) {
                            input.checked = false;
                        }
                    }
                });
                jQuery('.graphina-admin-loader').hide()
                jQuery('#graphina-apex-chart').show()
                jQuery('#graphina-google-chart').show()
                jQuery('#graphina-table').show()
                if(gcfe_localize.pro_active == '0'){
                    jQuery('#graphina-pro-elements').show()
                }
            }
        })
    }
    handleDisableChart(e){
        e.preventDefault();

        var action = 'graphina_save_enabled_widgets'
        let checkbox = jQuery(e.currentTarget).find('input');
        let isChecked = checkbox.prop('checked'); 
        if(!isChecked){
            action = 'graphina_save_disabled_widgets'
            jQuery(e.currentTarget).find('input').prop('checked',false)
        }else{
            jQuery(e.currentTarget).find('input').prop('checked', true)
        }
        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "POST",
            data: {
                action: action,
                widgets: JSON.stringify(jQuery(e.currentTarget).data('widget'))
            },
            success: function (response) {
                Swal.fire({
                    title: response.data.message,
                    text: response.data.subMessage,
                    confirmButtonText: gcfe_localize.i18n.swal_ok_text
                })
            }
        })
    }

    handleEnableAllChart(e) {
        e.preventDefault();
        jQuery('.toggle input').prop('checked', true);
        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "POST",
            data: {
                action: 'graphina_save_enabled_widgets',
                widgets: 1
            },
            success: function (response) {
                Swal.fire({
                    title: response.data.message,
                    text: response.data.subMessage,
                    confirmButtonText: gcfe_localize.i18n.swal_ok_text
                })
            }
        })
    }

    handleDisableAllChart(e) {
        e.preventDefault();
        jQuery('.toggle input').prop('checked', false);

        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "POST",
            data: {
                action: 'graphina_save_disabled_widgets',
                widgets: 1
            },
            success: function (response) {
                Swal.fire({
                    title: response.data.message,
                    text: response.data.subMessage,
                    confirmButtonText: gcfe_localize.i18n.swal_ok_text
                })
            }
        })
    }

    handleChartTypeSwitch(e) {
        e.preventDefault();
        const clickedType = jQuery(e.currentTarget);

        // Remove 'active' class from all chart types and add it to the clicked one
        jQuery('.graphina-chart-type').removeClass('active');
        clickedType.addClass('active');
    }

    handleDatabaseDelete(e) {
        e.preventDefault();
        const __this = jQuery(e.currentTarget);
        let selected_value = __this.attr("data-selected");
        Swal.fire({
            title: gcfe_localize.i18n.swal_are_you_sure_text,
            text: gcfe_localize.i18n.swal_revert_this_text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: gcfe_localize.i18n.swal_delete_text
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: gcfe_localize.ajaxurl,
                    type: "POST",
                    data: {
                        action: 'graphina_external_database',
                        type: 'delete',
                        value: selected_value,
                        nonce:gcfe_localize.nonce
                    },
                    success: function (response) {
                        if (response.status === true || response.status === 'true') {
                            window.location.reload()
                        }else{
                            Swal.fire(response.message)
                        }
                    }
                });
            }
        })
    }

    handleDatabaseTest(e) {
        e.preventDefault();
        jQuery(document).find('#graphina_external_database_action_type').val('con_test')
        jQuery(e.currentTarget).text('Connecting...')
        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "POST",
            data: jQuery('#graphina-settings-db-tab').serialize(),
            success: function (response) {
                jQuery(e.currentTarget).text('Test DB Setting ')
                Swal.fire({
                    title: response.message,
                    text: response.subMessage,
                    confirmButtonText: gcfe_localize.i18n.swal_ok_text
                }).then((result)=>{
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        })
    }

    handleDatabaseSave(e){
        e.preventDefault()
        if(jQuery(document).find('#graphina_external_database_action_type').val() == 'con_test'){
            jQuery(document).find('#graphina_external_database_action_type').val('save')
        }
        jQuery(e.currentTarget).text('Connecting...')
        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "POST",
            data: jQuery('#graphina-settings-db-tab').serialize(),
            success: function (response) {
                jQuery(e.currentTarget).text('Save Setting')
                Swal.fire({
                    title: response.message,
                    text: response.subMessage,
                    confirmButtonText: gcfe_localize.i18n.swal_ok_text
                }).then((result) => {
                    if(result.isConfirmed){
                        window.location.reload()
                    }
                });
            }
        })
    }

    handleLoaderUpload(e) {
        e.preventDefault();
        const frame = wp.media({
            title: 'Select or Upload Media',
            button: { text: 'Use this media' },
            multiple: false,
        });

        frame.on('select', () => {
            const attachment = frame.state().get('selection').first().toJSON();
            jQuery('#graphina_loader_hidden').val(attachment.url);
            jQuery('.graphina_upload_image_preview').attr('src', attachment.url);
        });

        frame.open();
    }

    handleLoaderDisplay(e) {
        e.preventDefault();
        const isChecked = jQuery(e.currentTarget).is(':checked');
        jQuery('#chart_filter_div').toggleClass('graphina-d-none', !isChecked);
    }

    handleSettingSave(e){
        e.preventDefault()

        jQuery.ajax({
            url: gcfe_localize.ajaxurl,
            type: "POST",
            data: jQuery('#graphina_settings_tab').serialize(),
            success: function (response) {
                if (response.status === true || response.status === 'true') {
                    Swal.fire({
                        title: response.message,
                        text: response.subMessage
                    })
                }else{
                    Swal.fire(response.message)
                }
            }
        })
    }

} 
