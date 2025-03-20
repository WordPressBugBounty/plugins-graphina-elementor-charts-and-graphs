import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Radial Charts
export default class RadialChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Radial chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            radial: (element) => this.observeChartElement(element, 'radial'),
        };
    }
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'radial') {
            finalChartOptions.labels = finalChartOptions.xaxis.categories
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize RadialChart
new RadialChart();
