// Class specifically for Data table
export default class DataTable {
    constructor() {
        this.tableHandlers = {};
        this.tableId = '';
        this.dataTable = {}
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
        jQuery(window).on('load', () => {
        jQuery('.graphina-jquery-data-table').each((i, el) => {
            this.initializeTables(jQuery(el));
        });
        });
        jQuery(document.body).off('click','.graphina-filter-div-button')
        jQuery(document.body).on('click','.graphina-filter-div-button', this.debounce(this.handleChartFilterTable.bind(this), 300));
 
    }

    debounce(func, wait) {
        let timeout;
    
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    handleChartFilterTable(e){
            const currentElement = e.currentTarget
            const elementId      = jQuery(currentElement).data('element_id');
            const chartElement   = jQuery(`.graphina-jquery-data-table[data-element_id="${elementId}"]`);
            if(chartElement.length > 0){
                this.setupTable(chartElement,[])
            }    
    }

    handleElementorWidgetInit() {
    elementorFrontend.hooks.addAction('frontend/element_ready/data_table_lite.default', ($scope) => {
        console.log('Initializing jQuery Data Table...');
        
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

    getDynamicData(settings, extraData, elementId,filterValue) {
        let post_id = jQuery(`[data-element_id="${elementId}"]`).closest('[data-elementor-id]').data('elementor-id');
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action      : 'get_jquery_datatable_data',
                    nonce       : gcfe_public_localize.table_nonce,
                    chartType   : 'data_table_lite',
                    post_id     : post_id,
                    element_id  : elementId,
                    series_count: 0,
                    settings    : JSON.stringify(settings),
                    selected_field: filterValue,
                },
                success: (response) => {
                    jQuery('#data_table_lite_loading_' + elementId).hide();
                    jQuery('#data_table_lite_no_data_' + elementId).hide();
                    resolve(response);
                },
                error: (error) => {
                    jQuery('#data_table_lite_loading_' + elementId).hide();
                    jQuery('#data_table_lite_no_data_' + elementId).hide();
                    console.error('AJAX Error:', error);
                    reject(new Error('AJAX request failed.'));
                },
            });
        });
    }

    async setupTable(element, dataTableType) {
        const element_id = element.data('element_id');
        this.tableId     = element_id;

        let chart_data      = element.data('chart_data');
        const extraData     = element.data('extra_data');
        const settings      = element.data('settings');
        const tableSelector = '.data_table_lite_' + element_id;
    
        if ( extraData.hide_column_header ) {
            chart_data.headerCallback = function(thead, data, start, end, display) {
                jQuery(thead).hide();
            }
        }
        chart_data.fnInitComplete = () => {
            jQuery('.dataTables_scrollBody').css({
                'overflow': 'hidden',
                'border': '0'
            });
            jQuery(`#data_table_lite_${element_id} thead th`).addClass('all graphina-datatable-columns');
            jQuery(`#data_table_lite_${element_id} tbody td`).addClass('graphina-datatable-tbody-td');
    
            const tableScrollFoot = jQuery('.dataTables_scrollFoot');
            tableScrollFoot.css('overflow', 'auto');
            tableScrollFoot.on('scroll', function () {
                jQuery('.dataTables_scrollBody').scrollLeft(jQuery(this).scrollLeft());
            });
        };
    
        chart_data.rowCallback = function (row, data, index) {
            if (index % 2 === 0) {
                jQuery(row).addClass('odd');
            } else {
                jQuery(row).addClass('even');
            }
        };
    
        // Destroy existing DataTable and clear table HTML.
        if (this.dataTable[element_id]) {
            this.dataTable[element_id].clear().destroy();
            jQuery(tableSelector).empty();
        }
    
        // Handle dynamic data fetching if applicable.
        if (extraData.is_dynamic_table) {
            let filterValue   = [];
            const totalFilter = jQuery(`#graphina_chart_filter_${element_id}`).data('total_filter');
    
            for (let index = 0; index < totalFilter; index++) {
                filterValue[index] =
                    jQuery(`#graphina-start-date_${index}${element_id}`).val() ??
                    jQuery(`#graphina-drop_down_filter_${index}${element_id}`).val();
            }
    
            const dynamicData = await this.getDynamicData(settings, extraData, element_id, filterValue);
    
            if (dynamicData.data.body.length !== 0 && dynamicData.data.header.length !== 0) {
                chart_data.data = dynamicData.data.body;
                chart_data.columns = dynamicData.data.header;
                jQuery('#data_table_lite_loading_' + element_id).hide();
            } else {
                jQuery('#data_table_lite_loading_' + element_id).show();
            }
        } else {
            if (chart_data.columns.length > 0) {
                jQuery('#data_table_lite_loading_' + element_id).hide();
            }
        }
    
        // Add thead before reinitializing
        if (chart_data.columns && chart_data.columns.length > 0) {
            const theadHTML = '<thead><tr>' +
                chart_data.columns.map(col => `<th>${col.title}</th>`).join('') +
                '</tr></thead>';
            jQuery(tableSelector).append(theadHTML);
        }

        // Initialize DataTable
        this.dataTable[element_id] = jQuery(tableSelector).DataTable(chart_data);
    
        // Add tfoot if required
        if (extraData.table_footer) {
            jQuery(`#data_table_lite_${element_id}`).append('<tfoot><tr>' +
                chart_data.columns.map(column => `<th class="${extraData.header_class}">${column.title}</th>`).join('') +
                '</tr></tfoot>');
        }
    
        // Re-init if direct data table override is enabled
        if (extraData.table_data_direct) {
            this.dataTable[element_id].destroy();
            jQuery(tableSelector).empty();
    
            const theadHTML = '<thead><tr>' +
                chart_data.columns.map(col => `<th>${col.title}</th>`).join('') +
                '</tr></thead>';
            jQuery(tableSelector).append(theadHTML);
    
            this.dataTable[element_id] = jQuery(tableSelector).DataTable(chart_data);
        }    
    }
    

}
// Initialize Data Table
window.graphinaDataTable = new DataTable();
