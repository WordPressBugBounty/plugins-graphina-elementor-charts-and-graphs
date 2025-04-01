import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Pie Charts
export default class PieChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Pie chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            pie: (element) => this.observeChartElement(element, 'pie'),
        };
    }
   

    applyDataLabelFormatter(chartOptions,extraData,forminatorPercentage=false){
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        } 
        if(extraData.chart_data_label_pointer){
            chartOptions.plotOptions.pie.donut.labels.total.formatter = (w) => {
                let total =   w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                }, 0) ;
                total = this.formatNumber(total, extraData.chart_datalabel_decimals_in_float);
                return datalabelPreFix + total + datalabelPostFix;
            }
            chartOptions.plotOptions.pie.donut.labels.value.formatter = (val) => {
                // Get the total sum of all values in the series
                val = this.formatNumber(val, extraData.chart_datalabel_decimals_in_float);
                return datalabelPreFix + val + datalabelPostFix;
            }
            chartOptions.tooltip.y = {
                formatter : (val ) => {
                    return datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix
                }
            };
        }else{
            chartOptions.tooltip.y = {
                formatter : (val ) => {
                    return datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val) + datalabelPostFix;
                }
            }
            chartOptions.plotOptions.pie.donut.labels.value.formatter = (val) => {
                // Get the total sum of all values in the series
                val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(val);
                return datalabelPreFix + val + datalabelPostFix;
            }
            chartOptions.plotOptions.pie.donut.labels.total.formatter = (w) => {
                // Get the total sum of all values in the series
                let total =   w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                }, 0) ;
                total = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(total);
                return datalabelPreFix + total + datalabelPostFix;
            };
            
        }

        if(chartOptions.dataLabels){
            chartOptions.dataLabels.formatter = (val,opts) => {
                if(forminatorPercentage){
                    let totals = opts.w.globals.seriesTotals.reduce((a, b) => {
                        return  a + b;
                    }, 0)
                    val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val/totals * 100)
                }
                if(extraData.chart_datalabels_format_showlabel){
                let label = opts.w.globals.labels[opts.seriesIndex];
                return label + "-" + datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(val) + datalabelPostFix ;
                }
                return datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(val) + "%"  + datalabelPostFix ;
            }
            if ( extraData.chart_datalabels_format_showValue) {
                chartOptions.dataLabels.formatter = (val, opts) => {
                    val = opts.w.globals.series[opts.seriesIndex]; 
                    if(extraData.chart_number_format_commas && !extraData.chart_data_label_pointer){
                        val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                            minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                            maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        }).format(val);
                    }
                    if (extraData.chart_data_label_pointer) {
                        return datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix;
                        }
                        if(extraData.chart_datalabels_format_showlabel){
                            let label = opts.w.globals.labels[opts.seriesIndex];
                            return label + "-" + datalabelPreFix + val + datalabelPostFix;
                            }
                    return datalabelPreFix + val + datalabelPostFix;
                };
            }
        }
    
    }
    
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'pie') {
            finalChartOptions.responsive = responsive_options
            finalChartOptions.labels = finalChartOptions.xaxis.categories
        }
        return finalChartOptions;
    }
}

// Initialize PieChart
new PieChart();
