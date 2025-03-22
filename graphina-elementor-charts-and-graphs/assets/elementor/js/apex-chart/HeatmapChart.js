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

    applyDataLabelFormatter(chartOptions,extraData){
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        } 
        chartOptions.dataLabels.formatter =  (val) => {
            if(extraData.string_format){
                val = this.formatNumber(val, extraData.chart_label_pointer_number_for_label);
            }
            return datalabelPreFix + val + datalabelPostFix
        }
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
