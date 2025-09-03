import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Counter Charts
export default class CounterChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for Counter chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            counter: (element) => this.observeChartElement(element, 'counter'),
        };
    }
   

    afterManualLoad(dynamicData, elementId, extraData) {
        this.startCounterAnimation(elementId, false, dynamicData,extraData);
    }

    afterDynamicLoad(dynamicData, elementId, extraData) {
        // Add data processing specific to 'counter' charts if needed
        this.startCounterAnimation(elementId, true, dynamicData,extraData)
    }
    async renderChart(chart, elementId) {
        try {
            jQuery(document).find(`.graphina-${elementId}-loader`).hide();
            const element = jQuery(`[data-element_id="${elementId}"]`);
            const extraData = element.data('extra_data');
            
            if (chart.opts?.chart?.type !== 'counter' || extraData?.show_counter_chart) {
                await chart.render();
            }
        } catch (error) {
            console.warn(error);
        }
    }

    async setupChart(element, chartType) {
        try {
            const elementId = element.data('element_id');
            const chartOptions = element.data('chart_options');
            const responsive_options = element.data('responsive_options');
            const extraData = element.data('extra_data');
            const settings = element.data('settings');

            if (!chartOptions || !elementId) {
                console.error(`Missing required data attributes for ${chartType} chart.`);
                return;
            }

            // Apply formatting to chart options
            this.applyLegendTooltip(chartOptions, extraData, chartType);
            this.applyXAxisFormatter(chartOptions, extraData);
            this.applyDataLabelFormatter(chartOptions, extraData);

            const finalChartOptions = this.getChartOptions(chartOptions, chartType, extraData, elementId);

            // Only create and render chart if show_counter_chart is true
            if (extraData?.show_counter_chart) {
                if (this.mainChart[elementId]) {
                    this.mainChart[elementId].destroy();
                }
                const chart = new ApexCharts(jQuery(element)[0], finalChartOptions);
                await this.renderChart(chart, elementId);
                this.mainChart[elementId] = chart;
                this.afterRenderChart(chart, elementId, extraData);
            }

            // Handle dynamic data loading
            if (extraData.chart_data_option === true) {
                const dynamicData = await this.getDynamicData(settings, extraData, chartType, elementId);
                this.processDynamicData(dynamicData, elementId, extraData);
                this.afterDynamicLoad(dynamicData, elementId, extraData);
            } else {
                this.afterManualLoad([], elementId, extraData);
            }

        } catch (error) {
            console.error(`Error initializing ${chartType} chart:`, error);
        }
    }
    afterRenderChart(chart,elementId,extraData){

        if(extraData.color !== '' ) {
            document.querySelector(`.count_number-pre-postfix-${elementId}`).style.color = extraData.color
        }
 
        if(extraData.headingColor !== ''){
            document.querySelector(`.counter-title-${elementId}`).style.color = extraData.headingColor
        }
        if(extraData.subHeadingColor !== ''){
            document.querySelector(`.counter-description-${elementId}`).style.color = extraData.subHeadingColor
        }
        if(!extraData.show_counter_chart){
            chart.destroy()
        }
    }
    // Function to start the counter animation
    startCounterAnimation(element_id, is_dynamic = false, dynamicData = [],extraData) {
        const counter = document.querySelector(`.count_number-${element_id}`);

        let start = parseFloat(counter.getAttribute('data-start'));
        let end = parseFloat(counter.getAttribute('data-end'));
        let speed = parseInt(counter.getAttribute('data-speed'), 10);
        let decimals = parseInt(counter.getAttribute('data-decimals'), 10) || 0;
        if (is_dynamic) {
            end = dynamicData.extra.end;
            try {
                document.querySelector(`.counter-title-${element_id}`).innerHTML = dynamicData.extra.title
            } catch (error) {
                console.warn(error);
            }
        }

        const duration = speed || 2000;
        const increment = (end - start) / (duration / 50);

        let current = start;

        function formatNumber(number, thousandSeparator = '') {
            // Convert to string and split by decimal point if any
            const parts = number.toString().split('.');
            
            // Add thousand separators to the integer part
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);
            
            // Join back with decimal part if it exists
            return parts.join('.');
        }
        // counter.textContent = 0
        function updateCounter() {
            if (current < end) {
                current = Math.min(current + increment, end);
                counter.textContent = formatNumber(current.toFixed(decimals),extraData.seperator);
                requestAnimationFrame(updateCounter); // Continue animation
            } else {
                counter.textContent = formatNumber(end.toFixed(decimals),extraData.seperator); // Ensure we stop at the exact value
            }
        }

        updateCounter(); // Start the counter animation
    }

    setFieldsForCounter(settings,response, chartType,extraData){
         // Determine the type of data source and select appropriate fields
         const FieldSelector = `[data-setting="${extraData.graphina_prefix}${chartType}_element_column_no"]`;
         
         const element = parent.document.querySelector(FieldSelector);
     
         // Exit if either element is not found
         if (!element) return;
     
         // Clear existing options in the dropdowns
         element.innerHTML = '';
     
         // Determine the data source for options and extra data keys
         const options   = response.extra.columns;
         const xExtraKey = extraData.element_column_no;
         // Populate the dropdown fields with options
         options.forEach((option) => {
                 const isSelectedX = Array.isArray(xExtraKey) ? xExtraKey.includes(option) : xExtraKey === option;
                 element.append(new Option(option, option, isSelectedX, isSelectedX));
         });
    }
    processDynamicData(dynamicData,elementId,extraData){
        dynamicData.extra.category = ['element1']
    }
    // Get chart options, including Counter chart configuration
    getChartOptions(finalChartOptions, chartType, extraData, elementId) {
        if (chartType === 'counter') {
            
        }
        return finalChartOptions;
    }
    async renderChart(chart, elementId) {
        try {
            jQuery(document).find(`.graphina-${elementId}-loader`).hide();
            const element = jQuery(`[data-element_id="${elementId}"]`);
            const extraData = element.data('extra_data');
            
            if (chart.opts?.chart?.type !== 'counter' || extraData?.show_counter_chart) {
                await chart.render();
            }
        } catch (error) {
            console.warn(error);
        }
    }

    async setupChart(element, chartType) {
        try {
            const elementId = element.data('element_id');
            const chartOptions = element.data('chart_options');
            const responsive_options = element.data('responsive_options');
            const extraData = element.data('extra_data');
            const settings = element.data('settings');

            if (!chartOptions || !elementId) {
                console.error(`Missing required data attributes for ${chartType} chart.`);
                return;
            }

            // Apply formatting to chart options
            this.applyLegendTooltip(chartOptions, extraData, chartType);
            this.applyXAxisFormatter(chartOptions, extraData);
            this.applyDataLabelFormatter(chartOptions, extraData);

            const finalChartOptions = this.getChartOptions(chartOptions, chartType, extraData, elementId);

            // Only create and render chart if show_counter_chart is true
            const chart = new ApexCharts(jQuery(element)[0], finalChartOptions);
            if (extraData?.show_counter_chart) {
                if (this.mainChart[elementId]) {
                    this.mainChart[elementId].destroy();
                }
                await this.renderChart(chart, elementId);
                this.afterRenderChart(chart, elementId, extraData);
                this.mainChart[elementId] = chart;
            }
            this.afterManualLoad([], elementId, extraData);
            // Handle dynamic data loading
            if (extraData.chart_data_option === true) {
                
                const dynamicData = await this.getDynamicData(settings, extraData, chartType, elementId);
                this.processDynamicData(dynamicData, elementId, extraData);
                if(dynamicData.extra !== undefined && extraData?.show_counter_chart){
                    if(this.mainChart[elementId]){
                        chart.updateOptions({
                            series: dynamicData.extra.series,
                            labels: dynamicData.extra.category
                        });
                        chart.updateSeries(
                            dynamicData.extra.series,
                            true
                        );
                    }
                    
                    if(dynamicData.extra.series.length <= 0){
                        if(this.mainChart[elementId]){
                            chart.destroy()
                        }
                        jQuery(element).hide()
                        jQuery(`.graphina-${elementId}-notext`).show()
                    }
                }else{
                    if(dynamicData.extra.series.length <= 0){
                        if(this.mainChart[elementId]){
                            chart.destroy()
                        }
                        jQuery(element).hide()
                        jQuery(`.graphina-${elementId}-notext`).show()
                    }
                    if(this.mainChart[elementId]){
                        chart.updateOptions({
                            series: [],
                            labels: []
                        });
                        chart.updateSeries(
                            [],
                            true
                        );
                    }
                }
            } 
            if (extraData.can_chart_reload_ajax) {
                // Set up periodic data fetching using intervals
                setInterval(async () => {
                    try {
                        const dynamicDataLoad = await this.getDynamicData(settings, extraData, chartType, elementId);
                        if (dynamicDataLoad?.extra) {
                            this.afterDynamicLoad(dynamicDataLoad,elementId,extraData)
                            if(this.mainChart[elementId]){
                                chart.updateOptions({
                                    series: dynamicDataLoad.extra.series,
                                    labels: dynamicDataLoad.extra.category
                                });
                                chart.updateSeries(
                                    dynamicDataLoad.extra.series,
                                    true
                                );
                            }
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

// Initialize CounterChart
window.graphinaCounterChart = new CounterChart();
