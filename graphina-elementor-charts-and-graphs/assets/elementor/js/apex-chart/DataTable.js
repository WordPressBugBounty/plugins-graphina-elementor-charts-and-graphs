// Class specifically for Data table
export default class DataTable {
    constructor() {
        this.tableHandlers = {};
        this.init();
        this.observer = {}; // For IntersectionObserver
    }

    // Initialize the class by setting up handlers and events
    init() {
        this.setUpTableHandler();
        this.bindEventHandlers();
    }

    // Bind event listeners
    bindEventHandlers() {
        jQuery(window).on('elementor/frontend/init', this.handleElementorWidgetInit.bind(this));
        jQuery(window).on('elementor/editor/init', this.handleElementorWidgetInit.bind(this));
    }


    handleElementorWidgetInit() {
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', ($scope) => {
            const chartElement = $scope.find('.graphina-jquery-data-table');
            if (chartElement.length > 0) {
                this.initializeTables(chartElement);
            }
        });
    }

    initializeTables(chartElement) {
        const chartType = chartElement.data('chart_type');
        if (this.tableHandlers[chartType]) {
            this.tableHandlers[chartType](chartElement);
        }
    }



    setUpTableHandler() {
        this.tableHandlers = {
            data_table_lite: (element) => this.observeTableElement(element, 'data_table_lite'),
        };
    }

    // Setup IntersectionObserver to call setupTable when the element is in the viewport
    observeTableElement(element, dataTableType) {
        const elementID = element.data('element_id')
        if (gcfe_public_localize.view_port === 'off') {
            if (!this.observer[elementID]) {
                this.observer[elementID] = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Element is in viewport; initialize the chart
                            this.setupTable(jQuery(entry.target), dataTableType);
                            // Stop observing the element after initializing the chart
                            this.observer[elementID].unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 }); // Trigger when at least 10% of the element is visible
            }
            this.observer[elementID].observe(element[0]); // Start observing the chart element
        } else {
            this.setupTable(element, dataTableType);
        }
    }

    getDynamicData(settings, extraData, elementId) {
        
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action      : 'get_jquery_datatable_data',
                    nonce       : gcfe_public_localize.table_nonce,
                    chartType   : 'data_table_lite',
                    post_id     : extraData.current_post_id,
                    element_id  : elementId,
                    series_count: 0,
                    settings    : JSON.stringify(settings),
                    selected_field: []
                },
                success: (response) => {
                    jQuery('#data_table_lite_loading_' + elementId).hide();
                    jQuery('#data_table_lite_no_data_' + elementId).hide();
                    resolve(response);
                },
                error: (error) => {
                    console.error('AJAX Error:', error);
                    reject(new Error('AJAX request failed.'));
                },
            });
        });
    }

    async setupTable(element,dataTableType){
        const element_id = element.data('element_id')
        let chart_data = element.data('chart_data')
        const extraData = element.data('extra_data');
        const settings = element.data('settings');

        chart_data.fnInitComplete = () => {
            jQuery('.dataTables_scrollBody').css({
                'overflow': 'hidden',
                'border': '0'
            });
            jQuery(`#data_table_lite_${element_id} thead th`).addClass('all graphina-datatable-columns')

            jQuery(`#data_table_lite_${element_id} tbody td`).addClass('graphina-datatable-tbody-td')

            const tableScrollFoot = jQuery('.dataTables_scrollFoot');
            // Enable TFOOT scroll bars
            tableScrollFoot.css('overflow', 'auto');

            // Sync TFOOT scrolling with TBODY
            tableScrollFoot.on('scroll', function () {
                jQuery('.dataTables_scrollBody').scrollLeft(jQuery(this).scrollLeft());
            });
        }
        chart_data.rowCallback = function (row, data, index) {
            if (index % 2 === 0) {
                jQuery(row).addClass('odd');
            } else {
                jQuery(row).addClass('even');
            }
        }
        let datatable = jQuery('.data_table_lite_' + element_id).DataTable(chart_data);
        
        if(extraData.is_dynamic_table){
            const dynamicData = await this.getDynamicData(settings, extraData, element_id);
            let dynamicTableData = {}
            if(dynamicData.data.body.length !== 0 && dynamicData.data.header.length !== 0){
                dynamicTableData.data = dynamicData.data.body;
                dynamicTableData.columns = dynamicData.data.header;
                datatable.destroy();
                jQuery('#data_table_lite_loading_' + element_id).hide();
                datatable = jQuery('#data_table_lite_' + element_id).DataTable(dynamicTableData);;
            }else{
                jQuery('#data_table_lite_loading_' + element_id).show();
            }
        }else{
            if(chart_data.columns.length > 0){
                jQuery('#data_table_lite_loading_' + element_id).hide();
            }
        }
        if (extraData.table_footer) {
            jQuery(`#data_table_lite_${element_id}`).append('<tfoot><tr>' + chart_data.columns.map(column => `<th class=${extraData.header_class}>${column.title}</th>`).join('') + '</tr></tfoot>');
        }
        if (extraData.table_data_direct){
            datatable.destroy()
            jQuery('.data_table_lite_' + element_id).DataTable(chart_data);
        }
    }

}
// Initialize Data Table
new DataTable();
