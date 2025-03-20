import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Heatmap Charts
export default class HeatmapChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for heatmap chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            heatmap: (element) => this.observeChartElement(element, 'heatmap'),
        };
    }

   

    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'heatmap') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize HeatmapChart
new HeatmapChart();
