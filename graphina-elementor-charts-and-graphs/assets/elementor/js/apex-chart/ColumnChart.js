import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Column Charts
export default class ColumnChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    
    // Setup handlers for column chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            column: (element) => this.observeChartElement(element, 'bar'),
        };
    }

    // Apply Y-axis label formatting
    applyYAxisFormatter(chartOptions, extraData, axisIndex = false) {
        const formatAxisLabels = (val, prefix, postfix, decimal, axisIndex) => {
            if (extraData.chart_yaxis_label_pointer) {
                return prefix + this.formatNumber(val, decimal) + postfix;
            } else if (extraData.yaxis_label_format && (axisIndex === 0 || axisIndex === false)) {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal,
                }).format(val) + postfix;
            } else if (extraData.chart_opposite_yaxis_format_number && axisIndex === 1) {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal,
                }).format(val) + postfix;
            }
            return prefix + val + postfix;
        };

        const updateYAxisLabels = (yaxis, prefix, postfix, decimal, axisIndex) => {
            if (!yaxis.labels) {
                yaxis.labels = {}; // Initialize yaxis.labels if it doesn't exist
            }
            yaxis.labels.formatter = (val) => formatAxisLabels(val, prefix, postfix, decimal, axisIndex);
        };

        if(extraData.is_chart_horizontal){

            if(extraData.yaxis_label_prefix_show){
                chartOptions.yaxis.labels.formatter = (val) => {
                    return extraData.yaxis_label_prefix + val + extraData.yaxis_label_postfix;
                } 
            }

            if (extraData.chart_xaxis_label_pointer) {
                chartOptions.xaxis.labels.formatter = (val) => {
                    return extraData.xaxis_label_prefix + this.formatNumber(val, extraData.xaxis_label_pointer_number) + extraData.xaxis_label_postfix;
                }
            }else if(extraData.chart_xaxis_format_number === true){
                chartOptions.xaxis.labels.formatter = (val) => {
                    return extraData.xaxis_label_prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.xaxis_label_pointer_number,
                        maximumFractionDigits: extraData.xaxis_label_pointer_number,
                    }).format(val) + extraData.xaxis_label_postfix;
                }
            }
        }else{
            if (axisIndex === false) {
                updateYAxisLabels(chartOptions.yaxis, extraData.yaxis_label_prefix, extraData.yaxis_label_postfix, extraData.decimal_in_float,axisIndex);
            } else if (axisIndex === 0 || axisIndex === 1) {
                let yaxis = chartOptions.yaxis[axisIndex];
                let prefix = axisIndex === 0 ? extraData.yaxis_label_prefix : extraData.chart_opposite_yaxis_label_prefix;
                let postfix = axisIndex === 0 ? extraData.yaxis_label_postfix : extraData.chart_opposite_yaxis_label_postfix;
                let decimal = extraData.decimal_in_float;
                updateYAxisLabels(yaxis, prefix, postfix, decimal, axisIndex);
            }
        }
    }


    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        finalChartOptions.responsive = responsive_options
        return finalChartOptions;
    }
}
// Initialize ColumnrChart
new ColumnChart();
