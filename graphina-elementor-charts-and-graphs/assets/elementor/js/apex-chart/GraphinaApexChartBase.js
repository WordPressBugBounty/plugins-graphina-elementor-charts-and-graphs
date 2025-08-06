// Parent class to manage shared functionalities for Graphina charts
export default class GraphinaApexChartBase {
    constructor() {
        
        this.chartHandlers = {};
        this.init();
        this.mainChart = {}
    }

    // Initialize the class by setting up handlers and events
    init() {
        this.setUpChartsHandler();
        this.bindEventHandlers();
        this.bindElementorInit(); // Bind Elementor hooks separately
    }

   
    // Bind event listeners
    bindEventHandlers() {
        jQuery(document.body).on('change', '.graphina-select-apex-chart-type', this.debounce(this.handleChartTypeChange.bind(this), 300));    
        jQuery(document.body).off('click','.graphina-filter-div-button.apex')
        jQuery(document.body).on('click','.graphina-filter-div-button.apex', this.debounce(this.handleChartFilter.bind(this), 300));
        jQuery(document.body).off('click','.graphina-filter-div-button.common')
    }

    bindElementorInit() {
        // Flag to track if our handler has been registered
        let elementorHookCalled = false;
        
        const runOnElementorReady = () => {
            if (elementorHookCalled) return;
            
            // Wait for Elementor modules to be ready
            if (window.elementorFrontend && window.elementorFrontend.elementsHandler) {
                elementorHookCalled = true;
                
                // Register the widget handler
                window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', ($scope) => {
                    const chartElement = $scope.find('.graphina-elementor-chart');
                    if (chartElement.length > 0) {
                        this.initializeCharts(chartElement);
                    }
                });
            }
        };

        // Case 1: Check if Elementor is already initialized
        if (window.elementorFrontend && window.elementorFrontend.elementsHandler) {
            runOnElementorReady();
        }

        // Case 2: Wait for Elementor to initialize
        jQuery(window).on('elementor/frontend/init', () => {
            // Add a small delay to ensure modules are loaded
            setTimeout(runOnElementorReady, 50);
        });

        // Case 3: Fallback for non-Elementor pages
        jQuery(document).ready(() => {
            if (!elementorHookCalled) {
                const chartElements = jQuery('.graphina-elementor-chart');
                if (chartElements.length > 0) {
                    chartElements.each((index, element) => {
                        this.initializeCharts(jQuery(element));
                    });
                }
            }
        });
    }
    

    debounce(func, wait) {
        let timeout;
    
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }



    // Setup IntersectionObserver to call setupChart when the element is in the viewport
    observeChartElement(element, chartType) {
        const elementId = element.data('element_id')
        if (gcfe_public_localize.view_port === 'off') {
            if (!this.observer[elementId]) {
                this.observer[elementId] = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Element is in viewport; initialize the chart
                            this.setupChart(jQuery(entry.target), chartType);
                            // Stop observing the element after initializing the chart
                            this.observer[elementId].unobserve(entry.target);
                            // this.observer[elementID].unobserve(entry.target);
                            this.observer[elementId].disconnect();
                            delete this.observer[elementId];
                        }
                    });
                }, { threshold: 0.1 }); // Trigger when at least 10% of the element is visible
            }
            this.observer[elementId].observe(element[0]); // Start observing the chart element
        } else {
            this.setupChart(element, chartType);
        }
    }
    
    // Change Chart Type Handler
    handleChartTypeChange(event){
        const dropdown = jQuery(event.target);
        const newChartType = dropdown.val();
        const elementId = dropdown.data('element_id');
        const chartElement = jQuery(`.graphina-elementor-chart[data-element_id="${elementId}"]`);

        if (chartElement.length > 0) {
            ApexCharts.exec(elementId, 'destroy');
            this.updateChartType(chartElement, newChartType);
        }
    }

    handleChartFilter(event){
        const currentElement = event.currentTarget
        const elementId      = jQuery(currentElement).data('element_id');
        const chartElement   = jQuery(`.graphina-elementor-chart[data-element_id="${elementId}"]`);
        let chartType        = jQuery(chartElement).data('chart_type');
        if(chartElement.length > 0){
            // Hide the no-data text right away before updating the chart
            jQuery(`.graphina-${elementId}-notext`).hide();
            // Destroy existing chart (if any)
            ApexCharts.exec(elementId, 'destroy');

            jQuery(document).find(`.graphina-${elementId}-loader`).show()
            this.updateChartType(chartElement, chartType,true);
        }
    }

    // Setup handlers for various chart types (to be implemented by child classes)
    setUpChartsHandler() {
        throw new Error('setUpChartsHandler method must be implemented by subclasses');
    }

    // Initialize charts for a given element
    initializeCharts(chartElement) {
        const chartType = chartElement.data('chart_type');
        if (this.chartHandlers[chartType]) {
            this.chartHandlers[chartType](chartElement);
        }
    }

    // Format large numbers with suffixes
    formatNumber(value, decimal) {
        const suffixes = ["", "K", "M", "B", "T"];
        let index = 0;
        while (value >= 1000 && index < suffixes.length - 1) {
            value /= 1000;
            index++;
        }
        return new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
            minimumFractionDigits: decimal,
            maximumFractionDigits: decimal,
        }).format(value) + suffixes[index];
    }

    // Apply legend tooltip formatting
    applyLegendTooltip(chartOptions, extraData,chart_type) {
        if (extraData.legend_show_series_value) {
            chartOptions.legend.tooltipHoverFormatter = (seriesName, opts) => {
                let value = opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex];
                seriesName = decodeURIComponent(seriesName);
                
                if(['polar','scatter','pie','donut','radial'].includes(chart_type)){
                    value = opts.w.globals.series[opts.seriesIndex];
                }
                return `<div class="legend-info"><span>${seriesName}</span>:<strong>${value}</strong></div>`;
            };
        }
    }

    // Apply X-axis label formatting
    applyXAxisFormatter(chartOptions, extraData) {
        if (extraData.xaxis_label_prefix_show) {
            chartOptions.xaxis.labels.formatter = (val) =>
                `${extraData.xaxis_label_prefix}${val}${extraData.xaxis_label_postfix}`;
        }
    }

    // Apply Y-axis label formatting

    applyYAxisFormatter(chartOptions, extraData, axisIndex = false, chart_type) {
        
        const formatAxisLabels = (val, prefix, postfix, decimal) => {
            if (extraData.chart_yaxis_label_pointer) {
                return prefix + this.formatNumber(val, decimal) + postfix;
            } else if (typeof decimal === 'number' && decimal > 0) {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal,
                }).format(val) + postfix;
            }
            return prefix + val + postfix;
        };

        const updateYAxisLabels = (yaxis, prefix, postfix, decimal) => {
            if (!yaxis.labels) {
                yaxis.labels = {};
            }
            yaxis.labels.formatter = (val) => formatAxisLabels(val, prefix, postfix, decimal);
        };

        // Default to single y-axis
        if (axisIndex === false) {
            const prefix = extraData.yaxis_label_prefix || '';
            const postfix = extraData.yaxis_label_postfix || '';
            let decimal = 0;
            if (extraData.chart_yaxis_label_pointer) {
                decimal = typeof extraData.chart_yaxis_label_pointer_number === 'number' ? extraData.chart_yaxis_label_pointer_number : 0;
            } else {
                decimal = typeof extraData.decimal_in_float === 'number' ? extraData.decimal_in_float : 0;
            }
            updateYAxisLabels(chartOptions.yaxis, prefix, postfix, decimal);
        }
        // Multiple y-axes: axisIndex 0 or 1
        else if (axisIndex === 0 || axisIndex === 1) {
            const yaxis = chartOptions.yaxis[axisIndex];
            const prefix = axisIndex === 0
                ? (extraData.yaxis_label_prefix || '')
                : (extraData.chart_opposite_yaxis_label_prefix || '');

            const postfix = axisIndex === 0
                ? (extraData.yaxis_label_postfix || '')
                : (extraData.chart_opposite_yaxis_label_postfix || '');

            let decimal = 0;
            if (axisIndex === 0) {
                if (extraData.chart_yaxis_label_pointer) {
                    decimal = typeof extraData.chart_yaxis_label_pointer_number === 'number' ? extraData.chart_yaxis_label_pointer_number : 0;
                } else {
                    decimal = typeof extraData.decimal_in_float === 'number' ? extraData.decimal_in_float : 0;
                }
            } else if (axisIndex === 1 && extraData.chart_opposite_yaxis_format_number === true) {
                if (extraData.chart_yaxis_label_pointer) {
                    decimal = typeof extraData.chart_yaxis_label_pointer_number === 'number' ? extraData.chart_yaxis_label_pointer_number : 0;
                } else {
                    decimal = typeof extraData.decimal_in_float === 'number' ? extraData.decimal_in_float : 0;
                }
            }
            updateYAxisLabels(yaxis, prefix, postfix, decimal);
        }
    }

    applyDataLabelFormatter(chartOptions, extraData, chart_type) {
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';

        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {};
        }

        // Arrow function to retain `this`
        chartOptions.dataLabels.formatter = (val) => {
            if (extraData.chart_number_format_commas) {
                val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float ?? 0,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float ?? 0,
                }).format(val);
            } else if (extraData.string_format) {
                const pointerDecimal = extraData.chart_label_pointer_number_for_label ?? 0;
                val = this.formatNumber(val, pointerDecimal); // uses `this` correctly
            }
            return datalabelPreFix + val + datalabelPostFix;
        };
    }


    applyTooltipFormatter(chartOptions, extraData, chartType) {
        const datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        const datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        const decimal = extraData.chart_datalabel_decimals_in_float ?? 0;

        if (!chartOptions.tooltip) {
            chartOptions.tooltip = {};
        }

        chartOptions.tooltip.y = {
            formatter: function (val) {
                let value = val;
                if (extraData.chart_number_format_commas) {
                    value = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: decimal,
                        maximumFractionDigits: decimal,
                    }).format(val);
                }
                return datalabelPreFix + value + datalabelPostFix;
            }
        };
    }


    async updateChartType(chartElement, newChartType, filter = false) {
        const elementId = chartElement.data('element_id');
        const chartOptions = chartElement.data('chart_options');
        const extraData = chartElement.data('extra_data');
        const settings = chartElement.data('settings');
        if (!chartOptions || !elementId || !newChartType) {
            console.error('Missing required chart options or element ID.');
            return;
        }

        // remove tooltip.shared if selected is column chart.
        if (newChartType === 'bar' && chartOptions.chart.type !== 'bar') {
            chartOptions.tooltip.shared = false
        }

        // Update the chart type in the options
        chartOptions.chart.type = newChartType;
        
        if(filter){
            // Filter Value
            let filterValue      = []
            const totalFilter    = jQuery(`#graphina_chart_filter_${elementId}`).data('total_filter');
            for (let index = 0; index < totalFilter; index++) {
                    filterValue[index] = jQuery(`#graphina-start-date_${index}${elementId}`).val() ?? jQuery(`#graphina-drop_down_filter_${index}${elementId}`).val()
            }
            const dynamicData = await this.getDynamicData(settings, extraData, newChartType, elementId,filterValue);
            
            if (dynamicData.extra !== undefined) {
                const seriesData = dynamicData.extra.series || [];
                const categories = dynamicData.extra.category || [];
                if ( seriesData.length <= 0 ){
                    chartOptions.noData.text = extraData.no_data_text
                }                
                chartOptions.series = seriesData;

                // Handle chart types that use `labels` instead of `xaxis.categories`
                if (['polar', 'radialBar', 'radial','pie','donut'].includes(newChartType)) {
                    chartOptions.labels = categories;
                } else {
                    chartOptions.xaxis.categories = categories;
                }

            } else {                
                chartOptions.series = [];
                chartOptions.xaxis.categories = [];
            }

        }
        if (newChartType === 'column'||newChartType === 'distributed_column') {
            chartOptions.chart.type = 'bar'
        } else if (chartOptions.chart.type == 'polar') {
            chartOptions.chart.type = 'polarArea'
        }
        else if (chartOptions.chart.type == 'radial') {
            chartOptions.chart.type = 'radialBar'
        }
        // Create and render the new chart
        const chart = new ApexCharts(chartElement[0], chartOptions);
        jQuery(chartElement).show()
        chart.render()
            .then(() => console.log(`Chart updated to ${newChartType}.`+JSON.stringify(chartOptions)))
            .catch((error) => console.error('Error updating chart:', error));
        jQuery(document).find(`.graphina-${elementId}-loader`).hide()

    }

    setFieldForForminator(response, chartType, extraData) {
        const isAggregate = extraData.section_chart_forminator_aggregate;
        const manualChartList = ['mixed', 'brush', 'gantt_google'];
        const options = manualChartList.includes(chartType) 
            ? response.forminator_columns 
            : response.extra.forminator_columns;
    
        if (isAggregate) {
            this.populateDropdownField(
                `[data-setting="${extraData.graphina_prefix}${chartType}_section_chart_forminator_aggregate_column"]`,
                options,
                extraData.section_chart_forminator_aggregate_column
            );
        } else {
            this.populateDropdownField(
                `[data-setting="${extraData.graphina_prefix}${chartType}_section_chart_forminator_x_axis_columns"]`,
                options,
                extraData.section_chart_forminator_x_axis_columns
            );
            this.populateDropdownField(
                `[data-setting="${extraData.graphina_prefix}${chartType}_section_chart_forminator_y_axis_columns"]`,
                options,
                extraData.section_chart_forminator_y_axis_columns
            );
        }
    }
    
    setFieldsForCSV(settings, response, chartType, extraData) {
        const isSQLBuilder = extraData.chart_dynamic_data_option === 'sql-builder';
        const options = isSQLBuilder ? response.extra.db_column : response.extra.column;
    
        this.populateDropdownField(
            `[data-setting="${extraData.graphina_prefix}${chartType}_${isSQLBuilder ? 'chart_sql_builder_x_columns' : 'chart_csv_x_columns'}"]`,
            options,
            isSQLBuilder ? extraData.chart_csv_x_columns_sql : extraData.chart_csv_x_columns
        );
    
        this.populateDropdownField(
            `[data-setting="${extraData.graphina_prefix}${chartType}_${isSQLBuilder ? 'chart_sql_builder_y_columns' : 'chart_csv_y_columns'}"]`,
            options,
            isSQLBuilder ? extraData.chart_csv_y_columns_sql : extraData.chart_csv_y_columns
        );
    }
    
    // Helper function to populate dropdown fields
    populateDropdownField(selector, options, selectedValues) {
        const element = parent.document.querySelector(selector);
        if (!element) return;
    
        element.innerHTML = ''; // Clear existing options
    
        try {
            options.forEach(option => {
                const isSelected = Array.isArray(selectedValues) 
                    ? selectedValues.includes(option) 
                    : selectedValues === option;
                element.append(new Option(option, option, isSelected, isSelected));
            });
        } catch (error) {
            console.log(error);
        }
    }
    
    setFieldsForCounter(settings,response, chartType,extraData){
        return true
    }

    getDynamicData(settings, extraData, chartType, elementId,filterValue) {

        let action = 'graphina_get_dynamic_data'
        let req_nonce  = gcfe_public_localize.nonce
        if(chartType === 'counter'){
            action = 'get_jquery_datatable_data'
            req_nonce  = gcfe_public_localize.table_nonce
        }
        let post_id = jQuery(`[data-element_id="${elementId}"]`).closest('[data-elementor-id]').data('elementor-id');
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action      : action,
                    nonce       : req_nonce,
                    chartType   : chartType,
                    post_id     : post_id,
                    element_id  : elementId,
                    series_count: extraData.chart_data_series_count_dynamic,
                    settings    :  JSON.stringify(settings),
                    selected_field: filterValue
                },
                success: (response) => {
                    if (response.status) {
                        if (jQuery('body').hasClass("elementor-editor-active")) {
                            if(chartType === 'counter'){
                                this.setFieldsForCounter(settings,response, chartType,extraData);
                            }
                            if((extraData.chart_csv_column_wise_enable || extraData.chart_dynamic_data_option === 'sql-builder') && (extraData.chart_dynamic_data_option === 'csv' || extraData.chart_dynamic_data_option === 'remote-csv' || extraData.chart_dynamic_data_option === 'google-sheet' || extraData.chart_dynamic_data_option === 'sql-builder')){
                                this.setFieldsForCSV(settings,response, chartType,extraData);
                            }
                            if(extraData.dynamic_type === 'forminator'){
                                this.setFieldForForminator(response,chartType,extraData);
                            }
                        };
                    }
                    resolve(response);
                },
                error: (error) => {
                    console.error('AJAX Error:', error);
                    reject(new Error('AJAX request failed.'));
                },
            });
        });
    }
    
    getChartOptions(finalChartOptions,chartType,extraData,responsive_options,elementId){
        return finalChartOptions;
    }

    afterRenderChart(chart,elementId,extraData){
        return chart
    }

    processDynamicData(dynamicData,elementId,extraData){
        return true;
    }

    afterManualLoad(dynamicData,elementId,extraData){
        return true
    }
    afterDynamicLoad(dynamicData,elementId,extraData){
        return true
    }
    
    
    // Generic setup for any chart type
    async setupChart(element, chartType) {
        try {
            const elementId = element.data('element_id');
            const chartOptions = element.data('chart_options');
            const responsive_options = element.data('responsive_options');
            const extraData = element.data('extra_data');
            const settings = element.data('settings');
            const chart_type = element.data('chart_type')
    
            if('nested_column' === chart_type){
                chartType = chart_type
            }else if('brush' === chart_type){
                chartType = chart_type
            }else if('column' === chart_type){
                chartType = chart_type
            }
            if (!chartOptions || !elementId) {
                console.error(`Missing required data attributes for ${chartType} chart.`);
                return;
            }

            // Apply formatting to chart options
            this.applyLegendTooltip(chartOptions, extraData,chart_type);
            this.applyXAxisFormatter(chartOptions, extraData);
            this.applyDataLabelFormatter(chartOptions, extraData, chart_type);
            this.applyTooltipFormatter(chartOptions, extraData, chart_type);
            this.applyTooltipFormatter(chartOptions, extraData);


            if (!extraData.chart_opposite_yaxis_title_enable) {
                this.applyYAxisFormatter(chartOptions, extraData, false, chart_type);
            } else {
                this.applyYAxisFormatter(chartOptions, extraData, 0, chart_type);
                this.applyYAxisFormatter(chartOptions, extraData, 1, chart_type);
            }

            // Finalize and render the chart
            const finalChartOptions = this.getChartOptions(chartOptions, chartType,extraData,responsive_options,elementId);
            if(this.mainChart[elementId]){
                this.mainChart[elementId].destroy()
            }
            
            const chart = new ApexCharts(jQuery(element)[0], finalChartOptions);
            try {
                jQuery(document).find(`.graphina-${elementId}-loader`).hide()
                await chart.render();
            } catch (error) {
                console.warn(error);
            }


            if(extraData.chart_data_option === true) {
                try {
                    let filterValue      = []
                    const totalFilter    = jQuery(`#graphina_chart_filter_${elementId}`).data('total_filter');
                    for (let index = 0; index < totalFilter; index++) {
                            filterValue[index] = jQuery(`#graphina-start-date_${index}${elementId}`).val() ?? jQuery(`#graphina-drop_down_filter_${index}${elementId}`).val()
                    }
                    const dynamicData = await this.getDynamicData(settings, extraData, chartType, elementId,filterValue);
                    this.processDynamicData(dynamicData,elementId,extraData);
                    if(dynamicData.extra !== undefined){
                        if('nested_column' === chart_type){    
                            chart.updateSeries(
                                [{data:dynamicData.extra.series}],
                                true
                            );
                        }else{
                            // FIX: Properly update both series and xaxis categories
                            const updateOptions = {
                                series: dynamicData.extra.series,
                            };

                            // Handle different chart types for categories/labels
                            if (['polar', 'radialBar', 'radial', 'pie', 'donut'].includes(chart_type)) {
                                updateOptions.labels = dynamicData.extra.category;
                            } else {
                                updateOptions.xaxis = {
                                    ...chartOptions.xaxis,
                                    categories: dynamicData.extra.category
                                };
                            }

                            chart.updateOptions(updateOptions, true);
                            chart.updateSeries(dynamicData.extra.series, true);
                            
                            if(dynamicData.extra.series.length <= 0){
                                chart.destroy()
                                jQuery(element).hide()
                                jQuery(`.graphina-${elementId}-notext`).show()
                            }
                        }
                    }else{
                        if(dynamicData.extra.series.length <= 0){
                            chart.destroy()
                            jQuery(element).hide()
                            jQuery(`.graphina-${elementId}-notext`).show()
                        }
                        chart.updateOptions({
                            series: [],
                            categories: []
                        });
                        chart.updateSeries(
                            [],
                            true
                        );
                    }
                    this.afterDynamicLoad(dynamicData,elementId,extraData);
                } catch (error) {
                    console.error('Failed to get dynamic data:', error);
                }
                jQuery(document).find(`.graphina-${elementId}-loader`).hide()
            }else{
                this.afterManualLoad([],elementId,extraData);
            }

            this.mainChart[elementId] = chart
            this.afterRenderChart(chart,elementId,extraData)
            if (extraData.can_chart_reload_ajax && !jQuery('body').hasClass('elementor-editor-active')) {
                // Set up periodic data fetching using intervals
                setInterval(async () => {
                    try {
                        const dynamicDataLoad = await this.getDynamicData(settings, extraData, chartType, elementId);
                        if (dynamicDataLoad?.extra) {
                            chart.updateSeries(dynamicDataLoad.extra.series);
                            chart.updateOptions(dynamicDataLoad.chart_option);
                        } else {
                            console.warn(`No data returned for ${chartType} chart with ID ${elementId}.`);
                        }
                    } catch (error) {
                        console.warn(`Error fetching dynamic data for ${chartType} chart with ID ${elementId}:`);
                    }
                }, extraData.interval_data_refresh * 1000);
            }

        } catch (error) {
            console.error(`Error initializing ${chartType} chart:`, error);
        }
    }
    
}
