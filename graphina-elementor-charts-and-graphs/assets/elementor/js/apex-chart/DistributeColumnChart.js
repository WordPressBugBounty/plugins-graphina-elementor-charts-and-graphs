import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for DistributeColumn Charts
export default class DistributeColumnChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for DistributeColumn chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            distributed_column: (element) => this.observeChartElement(element, 'distributed_column'),
        };
    }

   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'distributed_column') {
            finalChartOptions.chart.type = 'bar'
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize DistributeColumnChart
new DistributeColumnChart();
