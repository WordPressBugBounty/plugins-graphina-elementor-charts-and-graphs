import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Column Charts
export default class ColumnChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    
    // Setup handlers for column chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            column: (element) => this.observeChartElement(element, 'bar'),
        };
    }

   

    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        finalChartOptions.responsive = responsive_options
        return finalChartOptions;
    }
}
// Initialize ColumnrChart
new ColumnChart();
