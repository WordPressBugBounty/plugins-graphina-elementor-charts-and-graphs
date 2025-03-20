import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Area Charts
export default class AreaChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for area chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            area: (element) => this.observeChartElement(element, 'area'),
        };
    }

    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'area') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize AreaChart
new AreaChart();
