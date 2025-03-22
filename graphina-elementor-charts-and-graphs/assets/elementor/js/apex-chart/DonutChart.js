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

    applyDataLabelFormatter(chartOptions,extraData,forminatorPercentage=false){
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        } 
        if(chartOptions.dataLabels){
            chartOptions.dataLabels.formatter = (val,opts) => {
                if(forminatorPercentage){
                    let totals = opts.w.globals.seriesTotals.reduce((a, b) => {
                        console.log(totals);
                        return  a + b;
                    }, 0)
                    val =  parseFloat(val/totals * 100).toFixed(parseInt(forminatorDecimal));
                }
                if(extraData.chart_datalabels_format_showlabel){
                let label = opts.w.globals.labels[opts.seriesIndex];
                return label + "-" + datalabelPreFix + parseFloat(val).toFixed(1) + datalabelPostFix ;
                }
                return datalabelPreFix + parseFloat(val).toFixed(1) + "%"  + datalabelPostFix ;
            }
            if ( extraData.chart_datalabels_format_showValue) {
                chartOptions.dataLabels.formatter = (val, opts) => {
                    val = opts.w.globals.series[opts.seriesIndex]; 
                    if(extraData.chart_number_format_commas && !extraData.chart_data_label_pointer){
                        val = new Intl.NumberFormat(opts.w.globals.series[opts.seriesIndex], {
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
        if (chartType === 'donut') {
            finalChartOptions.labels = finalChartOptions.xaxis.categories
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize DonutChart
new DonutChart();
