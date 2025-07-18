// Base class to manage shared functionalities for Google Charts
export default class GraphinaGoogleChartBase {
    constructor() {
        this.chartHandlers = {};
        this.isGoogleChartsLoaded = false;
        this.init();
    }

    // Initialize the class
    init() {
        this.setUpChartsHandler();
        this.bindEventHandlers();
        this.bindElementorInit(); // Bind Elementor hooks separately
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
                    const chartElement = $scope.find('.graphina-google-chart');
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
                const chartElements = jQuery('.graphina-google-chart');
                if (chartElements.length > 0) {
                    chartElements.each((index, element) => {
                        this.initializeCharts(jQuery(element));
                    });
                }
            }
        });
    }
    

    // Bind event listeners (e.g., Elementor events)
    bindEventHandlers() {
        jQuery(document.body).on('change','.graphina-select-google-chart-type',this.debounce(this.handleChartTypeChange.bind(this), 300));
        jQuery(document.body).off('click','.graphina-filter-div-button.google')
        jQuery(document.body).on('click', '.graphina-filter-div-button.google', this.handleChartFilter.bind(this));
    }

    debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }


    // Change Chart Type Handler
    handleChartTypeChange(event) {
        const dropdown = jQuery(event.target);
        const newChartType = dropdown.val();
        const elementId = dropdown.data('element_id');
        const chartElement = jQuery(`.graphina-google-chart[data-element_id="${elementId}"]`);
        if (chartElement.length > 0) {
            this.updateChartType(chartElement, newChartType);
        }
    }

    updateChartType(chartElement, newChartType) {
        this.setupChart(chartElement, newChartType)
    }
    getGoogleChartTypeFromAlias(chartTypeAlias) {
        const typeMap = {
            'area_google': 'AreaChart',
            'bar_google': 'BarChart',
            'column_google': 'ColumnChart',
            'line_google': 'LineChart',
            'pie_google': 'PieChart',
            'donut_google': 'PieChart', 
            'geo_google': 'GeoChart',
            'gauge_google': 'Gauge',
            'gantt_google': 'Gantt',
            'org_google': 'OrgChart',
        };
        return typeMap[chartTypeAlias] || chartTypeAlias; 
    }

    handleChartFilter(event) {
        const currentElement = event.currentTarget
        const elementId = jQuery(currentElement).data('element_id');
        const chartElement = jQuery(`.graphina-google-chart[data-element_id="${elementId}"]`);
        const chartTypeAlias = chartElement.data('chart_type'); 
        const chartType = this.getGoogleChartTypeFromAlias(chartTypeAlias); 
        if (chartElement.length > 0) {
            this.setupChart(chartElement, chartType)
        }
    }

    // Setup handlers for various chart types (to be implemented by child classes)
    setUpChartsHandler() {
        throw new Error('setUpChartsHandler method must be implemented by subclasses');
    }

    // Handle Elementor widget initialization
    handleElementorWidgetInit() {

        elementorFrontend.hooks.addAction('frontend/element_ready/widget', ($scope) => {
            const chartElement = $scope.find('.graphina-google-chart');
            if (chartElement.length > 0) {
                this.initializeCharts(chartElement);
            }
        });
    }

    setupTableData(dynamicData,dataTable,googleChart,googleChartTexture,extraData){
        if(dynamicData?.google_chart_data?.title_array.length > 0 && dynamicData?.google_chart_data?.data.length > 0){
            dataTable.addColumn('string',dynamicData.google_chart_data.title)
            dynamicData.google_chart_data.title_array.forEach((col) => {
                dataTable.addColumn('number',col);
                if(dynamicData.google_chart_data.annotation_show){
                    dataTable.addColumn({type:'string',role:'annotation'});
                }
            });
            dynamicData.google_chart_data.data.forEach(row => dataTable.addRow(row));
            googleChart.show()
            googleChartTexture.hide()
        } else if(dynamicData?.columns.length > 0 && dynamicData.rows.length > 0){
            dynamicData.columns.forEach((col, index) => {
                dataTable.addColumn(col);
            });
            dynamicData.rows.forEach(row => dataTable.addRow(row));
        } else{
            googleChart.hide()
            googleChartTexture.show()
        }
    }

    // Initialize charts for a given element
    initializeCharts(chartElement) {

        const chartType = chartElement.data('chart_type');

        if (this.chartHandlers[chartType]) {
            this.chartHandlers[chartType](chartElement);
        }
    }

    setFieldsForCSV(settings, response, chartType, extraData) {
        // Determine the type of data source and select appropriate fields
        const isSQLBuilder = settings[`${extraData.graphina_prefix}${chartType}_chart_dynamic_data_option`] === 'sql-builder';
        const xFieldSelector = `[data-setting="${extraData.graphina_prefix}${chartType}_${isSQLBuilder ? 'chart_sql_builder_x_columns' : 'chart_csv_x_columns'}"]`;
        const yFieldSelector = `[data-setting="${extraData.graphina_prefix}${chartType}_${isSQLBuilder ? 'chart_sql_builder_y_columns' : 'chart_csv_y_columns'}"]`;

        const elementX = parent.document.querySelector(xFieldSelector);
        const elementY = parent.document.querySelector(yFieldSelector);
        // Exit if either element is not found
        if (!elementX || !elementY) return;

        // Clear existing options in the dropdowns
        elementX.innerHTML = '';
        elementY.innerHTML = '';

        // Determine the data source for options and extra data keys
        const options = isSQLBuilder ? response.extra.db_column : response.extra.column;
        const xExtraKey = isSQLBuilder ? extraData.chart_csv_x_columns_sql : extraData.chart_csv_x_columns;
        const yExtraKey = isSQLBuilder ? extraData.chart_csv_y_columns_sql : extraData.chart_csv_y_columns;

        // Populate the dropdown fields with options
        options.forEach((option) => {
            // Check for duplicates before adding options to dropdowns
            const optionExistsInX = Array.from(elementX.options).some(opt => opt.value === option);
            const optionExistsInY = Array.from(elementY.options).some(opt => opt.value === option);

            if (!optionExistsInX) {
                const isSelectedX = Array.isArray(xExtraKey) ? xExtraKey.includes(option) : xExtraKey === option;
                elementX.append(new Option(option, option, isSelectedX, isSelectedX));
            }

            if (!optionExistsInY) {
                const isSelectedY = Array.isArray(yExtraKey) ? yExtraKey.includes(option) : yExtraKey === option;
                elementY.append(new Option(option, option, isSelectedY, isSelectedY));
            }
        });
    }



    getDynamicData(settings, extraData, chartType, elementId, filterValue) {
        let post_id = jQuery(`[data-element_id="${elementId}"]`).closest('[data-elementor-id]').data('elementor-id');

        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'graphina_get_dynamic_data',
                    nonce: gcfe_public_localize.nonce,
                    chartType: chartType,
                    post_id: post_id,
                    element_id: elementId,
                    series_count: extraData.chart_data_series_count_dynamic,
                    settings: JSON.stringify(settings),
                    selected_field: filterValue
                },
                success: (response) => {
                    if (response.status) {
                        if ((extraData.chart_csv_column_wise_enable || extraData.chart_dynamic_data_option === 'sql-builder') && (extraData.chart_dynamic_data_option === 'csv' || extraData.chart_dynamic_data_option === 'remote-csv' || extraData.chart_dynamic_data_option === 'google-sheet' || extraData.chart_dynamic_data_option === 'sql-builder')) {
                            if (jQuery('body').hasClass("elementor-editor-active")) {
                                this.setFieldsForCSV(settings, response, chartType, extraData);
                            };
                        }
                        resolve(response);
                    } else {
                        console.error('Error:', response.message);
                        reject(new Error(response.message || 'Failed to fetch dynamic data.'));
                    }
                },
                error: (error) => {
                    console.error('AJAX Error:', error);
                    reject(new Error('AJAX request failed.'));
                },
            });
        });
    }


    getFinalChartOptions(finalChartOptions) {
        return finalChartOptions;
    }

    getFinalChartData(dataTable) {
        return dataTable
    }

    prepareGanttRowData(x) {
        return x.map(function (k, j) {
            if (j === 3 || j === 4) {
                if (/^\d{2}-\d{2}-\d{4}$/.test(k)) {
                    let [day, month, year] = k.split("-");
                    k = new Date(`${year}-${month}-${day}`); // Convert to "YYYY-MM-DD"
                } else if (/^\d{4}-\d{2}-\d{2}$/.test(k)) {
                    k = new Date(k); // Already in correct format
                } else {
                    k = null; // Invalid date
                }
            }
            if (j === 5) {
                k = null;
            }
            if (j === 7 && (k === 'null' || k === '0')) {
                k = null;
            } else if (j === 7 && k !== 'null') {
                k = k.toString()
            }
            if (j === 0) {
                k = k.toString()
            }
            if (j === 6) {
                k = parseInt(k)
            }
            return k;
        });
    }

    afterSetupChart(element, extraData,chart,dataTable,finalChartOptions){
        return true
    }

    // Setup and render Google Chart
    async setupChart(element, chartType) {

        const chartBox = element.closest('.chart-box');
        const googleChartTexture = chartBox ? chartBox.find('.google-chart-texture') : null;
        const googleChart = chartBox ? chartBox.find('.graphina-google-chart') : null;

        try {
            const elementId = element.data('element_id'); // Chart Element ID
            const chart_type = element.data('chart_type'); // Chart Type
            const chartData = element.data('chart_data'); // Chart data from element attributes
            const extraData = element.data('extra_data'); // Chart data from element attributes
            const settings = element.data('settings');   // Chart settings
            const chartOptions = element.data('chart_options') || {}; // Chart options


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
                    let filterValue = []
                    const totalFilter = jQuery(`#graphina_chart_filter_${elementId}`).data('total_filter');
                    for (let index = 0; index < totalFilter; index++) {
                        filterValue[index] = jQuery(`#graphina-start-date_${index}${elementId}`).val() ?? jQuery(`#graphina-drop_down_filter_${index}${elementId}`).val();

                    }
                    const dynamicData = await this.getDynamicData(settings, extraData, chart_type, elementId, filterValue);
                    this.setupTableData(dynamicData, dataTable, googleChart, googleChartTexture, extraData);


                } catch (error) {
                    googleChart.hide()
                    googleChartTexture.show()
                    console.error('Failed to get dynamic data:', error);
                }
                jQuery(document).find(`.graphina-${elementId}-loader`).hide()
            } else {

                const finalChartData = this.getFinalChartData(chartData);
                this.setupTableData(finalChartData, dataTable, googleChart, googleChartTexture, extraData);
            }

            if ('Gantt' === chartType) {
                this.setDependField(settings, extraData)
            }

            // Render the chart
            const chart = new google.visualization[chartType](element[0]);
            const finalChartOptions = this.getFinalChartOptions(chartOptions, elementId)

            chart.draw(dataTable, finalChartOptions);
            this.afterSetupChart(element[0], extraData, chart, dataTable, finalChartOptions);
            if (extraData.can_chart_reload_ajax && !jQuery('body').hasClass('elementor-editor-active')) {
                setInterval(async () => {
                    try {
                        let filterValue = []
                        const totalFilter = jQuery(`#graphina_chart_filter_${elementId}`).data('total_filter');
                        for (let index = 0; index < totalFilter; index++) {
                            filterValue[index] = jQuery(`#graphina-start-date_${index}${elementId}`).val() ?? jQuery(`#graphina-drop_down_filter_${index}${elementId}`).val();
                        }

                        const updatedData = await this.getDynamicData(settings, extraData, chart_type, elementId, filterValue);

                        if (updatedData) {
                            const newDataTable = new google.visualization.DataTable();
                            this.setupTableData(updatedData, newDataTable, googleChart, googleChartTexture, extraData);

                            const finalChartOptions = this.getFinalChartOptions(chartOptions, elementId);
                            chart.draw(newDataTable, finalChartOptions);
                        } else {
                            console.warn(`No data returned for ${chart_type} chart with ID ${elementId}.`);
                        }

                    } catch (error) {
                        console.warn(`Error fetching dynamic data for ${chart_type} chart with ID ${elementId}:`, error);
                    }
                }, extraData.interval_data_refresh * 1000);
            }

        } catch (error) {
            // googleChart.hide()
            // googleChartTexture.show()
            console.error(`Error initializing ${chartType} chart:`, error);
        }
    }


    // Dynamically load the Google Charts library
    async loadGoogleCharts() {

        if (this.isGoogleChartsLoaded) return; // Prevent loading multiple times

        return new Promise((resolve, reject) => {
            try {
                google.charts.load('current', { packages: ['corechart','geochart','gauge','gantt','orgchart'] });
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
