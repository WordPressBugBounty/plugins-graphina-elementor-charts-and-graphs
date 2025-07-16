class FilterBase {

    constructor() {
        this.chartHandlers = {};
        this.mainChart = {};
        this.isGoogleChartsLoaded = false;
        this.init();
    }

    init() {
        this.bindEventHandlers();
    }

    bindEventHandlers() {
        // Remove previous event listeners to prevent duplicates
        jQuery(document).off('click', '.graphina-filter-div-button.common');

        // Add event listener with proper selector
        jQuery(document).on('click', '.graphina-filter-div-button.common', (e) => {
            this.debounce(this.handleCommonChartUpdate.bind(this), 300)(e);
        });


    }

    debounce(func, wait) {
        let timeout;

        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    handleCommonChartUpdate(e) {
        e.preventDefault()

        const currentElement = e.currentTarget;

        // Store the original button text
        const originalText = currentElement.textContent;
        currentElement.dataset.originalText = originalText;

        // Get the localized loading text
        const loadingText = gcfe_public_localize.loading_btn;

        // Apply loading state to the button
        currentElement.textContent = loadingText;
        currentElement.classList.add('loading_btn');


        const elementId = jQuery(currentElement).data('element_id')
        const totalFilter = jQuery(`#graphina_chart_filter_${elementId}`).data('total_filter');
        let filterValue = []

        for (let index = 0; index < totalFilter; index++) {
            filterValue[index] = jQuery(`#graphina-start-date_${index}${elementId}`).val() ??
                jQuery(`#graphina-drop_down_filter_${index}${elementId}`).val();
        }
        // Find all chart elements on the page

        const apexChartElements = jQuery('.common-filter-chart');
        const googleChartElements = jQuery('.common-filter-google-chart');
        
        if (apexChartElements.length > 0) {
            jQuery(document).find('.graphina-loader').show();

            // Process ApexCharts
            apexChartElements.each((index, element) => {
                const chartElement = jQuery(element);
                const elementId = chartElement.data('element_id');
                const chartType = chartElement.data('chart_type');

                if (this.mainChart[elementId]) {
                    this.mainChart[elementId].destroy();
                } else {
                    ApexCharts.exec(elementId, 'destroy');
                }
                console.log(elementId);
                
                jQuery(document).find(`.graphina-${elementId}-loader`).show();
                this.updateChartWithCommonFilter(chartElement, chartType, filterValue);
            });
            
        }

        if (googleChartElements.length > 0) {
            // Show loader for all charts
            jQuery(document).find('.graphina-loader').show();

            // Process each chart
            googleChartElements.each((index, element) => {
                const chartElement = jQuery(element);
                const elementId = chartElement.data('element_id');
                const chartType = chartElement.data('chart_type_static');

                // Show individual chart loader
                jQuery(document).find(`.graphina-${elementId}-loader`).show();

                // Update the chart with common filter value
                this.UpdateGoogleChartWithCommonFilter(chartElement, chartType, filterValue);
            });
        }


    }

    getDynamicData(settings, extraData, chartType, elementId, filterValue) {

        let action = 'graphina_get_dynamic_data'
        let req_nonce = gcfe_public_localize.nonce
        if (chartType === 'counter') {
            action = 'get_jquery_datatable_data'
            req_nonce = gcfe_public_localize.table_nonce
        }
        let post_id = jQuery(`[data-element_id="${elementId}"]`).closest('[data-elementor-id]').data('elementor-id');
        let field_post_id = post_id;
        if (extraData.is_same_acf_field_id) {
            field_post_id = extraData.custom_post_id_for_acf_field;
        }

        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: action,
                    nonce: req_nonce,
                    chartType: chartType,
                    post_id: post_id,
                    field_post_id: field_post_id,
                    element_id: elementId,
                    series_count: extraData.chart_data_series_count_dynamic,
                    settings: JSON.stringify(settings),
                    selected_field: filterValue
                },
                success: (response) => {
                    if (response.status) {
                        if (jQuery('body').hasClass("elementor-editor-active")) {
                            if (chartType === 'counter') {
                                this.setFieldsForCounter(settings, response, chartType, extraData);
                            }
                            if ((extraData.chart_csv_column_wise_enable || extraData.chart_dynamic_data_option === 'sql-builder') && (extraData.chart_dynamic_data_option === 'csv' || extraData.chart_dynamic_data_option === 'remote-csv' || extraData.chart_dynamic_data_option === 'google-sheet' || extraData.chart_dynamic_data_option === 'sql-builder')) {
                                this.setFieldsForCSV(settings, response, chartType, extraData);
                            }
                            if (extraData.dynamic_type === 'forminator') {
                                this.setFieldForForminator(response, chartType, extraData);
                            }
                        };
                    }

                    jQuery('.graphina-filter-div-button.common')
                        .removeClass('loading_btn')
                        .prop('disabled', false)
                        .each(function () {
                            // Restore original text if it was stored
                            const originalText = jQuery(this).data('original-text');
                            if (originalText) {
                                jQuery(this).text(originalText);
                            } else {
                                // Fallback to default text if no original text was stored
                                jQuery(this).text(gcfe_public_localize.i18n.apply_filter || 'Apply Filter');
                            }
                        });

                    resolve(response);
                },
                error: (error) => {
                    console.error('AJAX Error:', error);
                    reject(new Error('AJAX request failed.'));
                },
            });
        });
    }

    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        return finalChartOptions;
    }

    setupTableData(dynamicData, dataTable, googleChart, googleChartTexture, extraData) {

        if (!dynamicData || !dataTable) {
            console.warn('Required parameters are missing');
            return;
        }

        try {
            // Handle Google Chart Data format
            if (dynamicData.google_chart_data?.title_array?.length > 0 &&
                dynamicData.google_chart_data?.data?.length > 0) {

                // Add title column
                if (typeof dynamicData.google_chart_data.title === 'string') {
                    dataTable.addColumn('string', dynamicData.google_chart_data.title);
                }

                // Add data columns
                dynamicData.google_chart_data.title_array.forEach((col) => {
                    if (col) {
                        dataTable.addColumn('number', String(col));

                        // Add annotation column if enabled
                        if (dynamicData.google_chart_data.annotation_show === true) {
                            dataTable.addColumn({ type: 'string', role: 'annotation' });
                        }
                    }
                });

                // Add data rows
                if (Array.isArray(dynamicData.google_chart_data.data)) {
                    dynamicData.google_chart_data.data.forEach(row => {
                        if (Array.isArray(row)) {
                            dataTable.addRow(row);
                        }
                    });
                }

                if (googleChart && googleChartTexture) {
                    googleChart.show();
                    googleChartTexture.hide();
                }

                // Handle regular column/row format
            } else if (Array.isArray(dynamicData.columns) &&
                Array.isArray(dynamicData.rows) &&
                dynamicData.columns.length > 0 &&
                dynamicData.rows.length > 0) {

                dynamicData.columns.forEach((col) => {
                    if (col) {
                        dataTable.addColumn(col);
                    }
                });

                dynamicData.rows.forEach(row => {
                    if (Array.isArray(row)) {
                        dataTable.addRow(row);
                    }
                });

                // Handle empty/invalid data case
            } else {
                if (googleChart && googleChartTexture) {
                    googleChart.hide();
                    googleChartTexture.show();
                }
            }
        } catch (error) {
            console.error('Error setting up table data:', error);
            if (googleChart && googleChartTexture) {
                googleChart.hide();
                googleChartTexture.show();
            }
        }

    }
    getFinalChartOptions(finalChartOptions) {
        return finalChartOptions;
    }
    
    // Method to update chart with common filter
    async updateChartWithCommonFilter(chartElement, chartType, commonFilterValue) {
        const elementId = chartElement.data('element_id');
        const chartOptions = chartElement.data('chart_options');
        const extraData = chartElement.data('extra_data');
        const settings = chartElement.data('settings');

        if (!chartOptions || !elementId || !chartType) {
            console.error('Missing required chart options or element ID.');
            jQuery(document).find(`.graphina-${elementId}-loader`).hide();
            return;
        }

        try {
            let filterValue = Array.isArray(commonFilterValue) ? commonFilterValue : [commonFilterValue];
            const dynamicData = await this.getDynamicData(settings, extraData, chartType, elementId, filterValue);

            // === Check for empty or missing data ===
            const seriesData = dynamicData?.extra?.series ?? [];
            const categoryData = dynamicData?.extra?.category ?? [];

            const isEmptyData = (
                !Array.isArray(seriesData) || seriesData.length === 0 ||
                (Array.isArray(seriesData[0]?.data) && seriesData[0].data.length === 0)
            );

            if (isEmptyData) {
                chartOptions.series = [];
                chartOptions.xaxis.categories = [];

                // Hide chart
                chartElement.hide();

                // Show No Data Found
                jQuery(`.graphina-${elementId}-notext`).show();
                jQuery(`.graphina-${elementId}-loader`).hide();
                return;
            } else {
                jQuery(`.graphina-${elementId}-notext`).hide();
            }

            // === If data is valid, update chart ===
            if (chartType === 'nested_column') {
                chartOptions.series = [{ data: seriesData }];
            } else if (chartType === 'column') {
                chartOptions.chart.type = 'bar';
                chartOptions.series = seriesData;
                chartOptions.xaxis.categories = categoryData;
            } else if (['polar', 'radialBar', 'radial', 'pie', 'donut'].includes(chartType)){

                chartOptions.series = seriesData;
                chartOptions.labels = categoryData;
            }else{
                chartOptions.series = seriesData;
                chartOptions.xaxis.categories = categoryData;
            }

            // Show chart container
            chartElement.show();
            if (chartType === 'column' || chartType === 'distributed_column') {
                chartOptions.chart.type = 'bar';
            } else if (chartType === 'polar') {
                chartOptions.chart.type = 'polarArea';
            }

            const finalChartOptions = this.getChartOptions(chartOptions, chartType, extraData, chartElement.data('responsive_options'), elementId);
            chartElement.empty();
            const chart = new ApexCharts(chartElement[0], finalChartOptions);

            try {
                await chart.render();
            } catch (error) {
                console.error('Error rendering chart:', error);
            }
            jQuery('.graphina-filter-div-button.common')
                .removeClass('loading_btn')
                .prop('disabled', false)
                .each(function () {
                    const originalText = jQuery(this).data('original-text');
                    if (originalText) {
                        jQuery(this).text(originalText);
                    } else {
                        jQuery(this).text(gcfe_public_localize.i18n.apply_filter || 'Apply Filter');
                    }
                });
            jQuery(document).find(`.graphina-${elementId}-loader`).hide();
        } catch (error) {
            console.error('Error updating chart with common filter:', error);
            jQuery(document).find(`.graphina-${elementId}-loader`).hide();
        }
    }

    // Setup and render Google Chart
    async UpdateGoogleChartWithCommonFilter(element, chartType, commonFilterValue) {

        const chartBox = element.closest('.chart-box');
        const googleChartTexture = chartBox ? chartBox.find('.google-chart-texture') : null;
        const googleChart = chartBox ? chartBox.find('.graphina-google-chart') : null;

        try {
            const elementId = element.data('element_id');
            const chart_type = element.data('chart_type');
            const chartData = element.data('chart_data');
            const extraData = element.data('extra_data');
            const settings = element.data('settings');
            const chartOptions = element.data('chart_options') || {};
            const noTextContainer = jQuery(`.graphina-${elementId}-notext`);

            // Ensure that Google Charts is loaded and only once
            await this.loadGoogleCharts();

            // Validate chartType
            if (!google.visualization[chartType]) {

                throw new Error(`Invalid chart type: ${chartType}`);
            }
            // Create a new DataTable
            const dataTable = new google.visualization.DataTable();

            if (extraData.chart_data_option) {
                try {
                    let filterValue = Array.isArray(commonFilterValue) ? commonFilterValue : [commonFilterValue];

                    const totalFilter = jQuery(`#graphina_chart_filter_${elementId}`).data('total_filter');
                    for (let index = 0; index < totalFilter; index++) {
                        let rawValue = jQuery(`#graphina-start-date_${index}${elementId}`).val() ?? jQuery(`#graphina-drop_down_filter_${index}${elementId}`).val();
                        filterValue[index] = typeof rawValue === 'string' ? rawValue.trim() : rawValue;
                    }

                    const dynamicData = await this.getDynamicData(settings, extraData, chart_type, elementId, filterValue);

                    const hasData =
                        (Array.isArray(dynamicData.google_chart_data?.data) && dynamicData.google_chart_data.data.length > 0) ||
                        (Array.isArray(dynamicData.rows) && dynamicData.rows.length > 0);

                    if (!hasData) {
                        // Show "No Data Found", hide chart
                        googleChart.hide();
                        googleChartTexture.hide(); // optional if you want to hide grey bg too
                        noTextContainer.show();
                        
                        jQuery(`.graphina-${elementId}-loader`).hide();
                        return;
                    } else {
                        noTextContainer.hide();
                    }
                    this.setupTableData(dynamicData, dataTable, googleChart, googleChartTexture, extraData);

                } catch (error) {
                    googleChart.hide();
                    googleChartTexture.show();
                    noTextContainer.show();
                    console.error('Failed to get dynamic data:', error);
                }
                jQuery(document).find(`.graphina-${elementId}-loader`).hide()
            } else {

                const finalChartData = this.getFinalChartData(chartData);

                const hasData =
                    (Array.isArray(finalChartData.google_chart_data?.data) && finalChartData.google_chart_data.data.length > 0) ||
                    (Array.isArray(finalChartData.rows) && finalChartData.rows.length > 0);

                if (!hasData) {
                    googleChart.hide();
                    googleChartTexture.hide();
                    noTextContainer.show();
                    jQuery(`.graphina-${elementId}-loader`).hide();
                    return;
                } else {
                    noTextContainer.hide();
                }

                this.setupTableData(finalChartData, dataTable, googleChart, googleChartTexture, extraData);
            }

            if ('Gantt' === chartType) {
                this.setDependField(settings, extraData);
            }

            const chart = new google.visualization[chartType](element[0]);
            const finalChartOptions = this.getFinalChartOptions(chartOptions, elementId);
            chart.draw(dataTable, finalChartOptions);
            
        } catch (error) {
            googleChart.hide();
            googleChartTexture.show();
            jQuery(`.graphina-${elementId}-notext`).show();
            console.error(`Error initializing ${chartType} chart:`, error);
        }
    }


    // Dynamically load the Google Charts library
    async loadGoogleCharts() {

        if (this.isGoogleChartsLoaded) return; // Prevent loading multiple times

        return new Promise((resolve, reject) => {
            try {
                google.charts.load('current', { packages: ['corechart', 'geochart', 'gauge', 'gantt', 'orgchart'] });
                google.charts.setOnLoadCallback(() => {
                    this.isGoogleChartsLoaded = true;
                    resolve();
                });
            } catch (error) {
                console.error('Error loading Google Charts:', error);
                reject(error);
            }
        });
    }
}
jQuery(() => {
    window.GraphinaFilterBase = new FilterBase();
});