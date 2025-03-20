import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Radar Charts
export default class RadarChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Radar chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            radar: (element) => this.observeChartElement(element, 'radar'),
        };
    }
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'radar') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize RadarChart
new RadarChart();
