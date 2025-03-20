import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Scatter Charts
export default class ScatterChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Scatter chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            scatter: (element) => this.observeChartElement(element, 'scatter'),
        };
    }
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'scatter') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize ScatterChart
new ScatterChart();
