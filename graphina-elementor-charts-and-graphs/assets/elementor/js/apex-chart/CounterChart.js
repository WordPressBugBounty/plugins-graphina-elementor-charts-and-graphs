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

    // Get chart options, including Counter chart configuration
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'counter') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize CounterChart
new CounterChart();
