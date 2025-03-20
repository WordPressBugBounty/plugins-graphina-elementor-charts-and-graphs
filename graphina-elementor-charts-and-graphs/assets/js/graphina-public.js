import $ from 'jquery'
export default class GraphinaPublic {

    constructor() {
        this.init();
    }

    init() {
        this.eventHandlers();
        this.graphinaFeatureRequest();
    }

    eventHandlers() {
        jQuery(document.body).on('submit', '.graphina-password-restricted-form', this.handleChartAccess.bind(this));
    }

    graphinaFeatureRequest(){
        // Graphina Feature Request For Elementor Panel
        if (parent.document.querySelector('.elementor-editor-active') !== null) {
            let _graphina_get_help = '';
            let _graphina_get_help_url = "https://iqonic.design/feature-request/?for_product=graphina";
            setInterval(function() {
                if (parent.document.querySelector('[class*=elementor-control-iq]') != null) {
                    _graphina_get_help = parent.document.querySelector('#elementor-panel__editor__help__link');
                    if (_graphina_get_help != null) {
                        if (_graphina_get_help.getAttribute("href") !== _graphina_get_help_url) {
                            _graphina_get_help.setAttribute("href", _graphina_get_help_url);
                            _graphina_get_help.innerHTML = "<b> Graphina Feature Request <i class='eicon-editor-external-link'></i> </b>";
                        }
                    }
                }
            }, 3000)
        }
    }

    handleChartAccess(e) {
        e.preventDefault(); // Prevent the form's default submission behavior

        // Create FormData object from the form and convert it to a plain object
        const formData = new FormData(e.currentTarget);
        const jsonData = Object.fromEntries(formData.entries());
    
        // Prepare data for the AJAX request in a more structured way
        const ajaxData = {
            chart_password: jsonData.chart_password,
            chart_type: jsonData.chart_type,
            chart_id: jsonData.chart_id,
            nonce: jsonData.nonce,
            action: jsonData.action,
            graphina_password: jsonData.graphina_password
        };

        // Send the Ajax request using jQuery
        jQuery.ajax({
            type: 'GET',
            url: gcfe_public_localize.ajaxurl,
            data: ajaxData, // Use the structured ajaxData
            dataType: "json",
            contentType: "application/json",
            success: function(response) {
                if (response.status === true) {
                    this.graphinasetCookie(response.chart, true, 1);
                    location.reload();
                }else{
                    jQuery(e.currentTarget).find('.elementor-alert-danger').show()
                }
            }.bind(this),
            error: function(xhr, status, error) {
                // Handle the error
                console.error('Ajax Request Failed:', status, error);
            }
        });
    }


    graphinasetCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
}
