import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Bubble Charts
export default class BubbleChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver

    }

    // Setup handlers for bubble chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            bubble: (element) => this.observeChartElement(element, 'bubble'),
        };
    }

  
   
    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'bubble') {
            finalChartOptions.xaxis.categories = [] 
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize BubbleChart
new BubbleChart();
