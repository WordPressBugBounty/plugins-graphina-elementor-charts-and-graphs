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
            chart_type: jsonData.chart_type,
            chart_id: jsonData.chart_id,
            post_id: jsonData.post_id,
            nonce: jsonData.nonce,
            action: jsonData.action,
            graphina_password: jsonData.graphina_password
        };

        // Send the Ajax request using jQuery. POST keeps the password out of URLs and server logs.
        jQuery.ajax({
            type: 'POST',
            url: gcfe_public_localize.ajaxurl,
            data: ajaxData, // Use the structured ajaxData
            dataType: "json",
            success: function(response) {
                if (response.status === true) {
                    // The server sets the signed access cookie; reload to render the chart.
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
}
