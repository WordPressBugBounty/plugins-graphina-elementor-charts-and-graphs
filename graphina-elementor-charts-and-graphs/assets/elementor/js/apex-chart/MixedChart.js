import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Mixed Charts
export default class MixedChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for Mixed chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            mixed: (element) => this.observeChartElement(element, 'mixed'),
        };
    }
   
    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'mixed') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize MixedChart
new MixedChart();
