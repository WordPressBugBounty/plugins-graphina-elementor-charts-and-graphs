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

  
   
    getChartOptions(finalChartOptions, chartType,extraData,elementId) {
        if (chartType === 'bubble') {
            finalChartOptions.xaxis.categories = [] 
             // Add loaded event to remove fixed height
             finalChartOptions.chart.events = {
                mounted: (chartContext, config) => {
                    // More specific selector targeting only the chart container
                    const chartElement = document.querySelector(`.graphina-elementor-chart[data-element_id="${elementId}"]`);
                    if (chartElement) {
                        // Remove fixed height but keep min-height for proper rendering
                        chartElement.style.height = '';
                    }
                },
               
            };
        }
        return finalChartOptions;
    }
}

// Initialize BubbleChart
window.graphinaBubbleChart = new BubbleChart();
