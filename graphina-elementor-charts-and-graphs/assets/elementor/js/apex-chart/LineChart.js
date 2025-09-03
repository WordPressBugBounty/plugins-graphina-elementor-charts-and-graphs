import GraphinaApexChartBase from './GraphinaApexChartBase';

export default class LineChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {};
    }
    
    setUpChartsHandler() {
        this.chartHandlers = {
            line: (element) => this.observeChartElement(element, 'line'),
        };
    }

    getChartOptions(finalChartOptions, chartType, extraData, elementId) {
        if (chartType === 'line') {
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
window.graphinaLineChart = new LineChart();
