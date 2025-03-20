import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Polar Charts
export default class PolarChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Polar chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            polar: (element) => this.observeChartElement(element, 'polar'),
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
        if (chartType === 'polar') {
            finalChartOptions.responsive = responsive_options
            finalChartOptions.labels = finalChartOptions.xaxis.categories

        }
        return finalChartOptions;
    }
}

// Initialize PolarChart
new PolarChart();
