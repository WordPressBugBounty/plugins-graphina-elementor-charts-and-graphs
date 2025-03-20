import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Donut Charts
export default class DonutChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for Donut chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            donut: (element) => this.observeChartElement(element, 'donut'),
        };
    }

   
    applyDataLabelFormatter(chartOptions,extraData){
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        } 
        chartOptions.dataLabels.formatter = (val) => {
            if(extraData.chart_number_format_commas && !extraData.chart_data_label_pointer){
                val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(val);
            }
            if (extraData.chart_data_label_pointer) {
                return datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix;
            }
            return datalabelPreFix + val + datalabelPostFix
        }
    }

    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'donut') {
            finalChartOptions.labels = finalChartOptions.xaxis.categories
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize DonutChart
new DonutChart();
