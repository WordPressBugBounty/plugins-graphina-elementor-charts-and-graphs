import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Radar Charts
export default class RadarChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Radar chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            radar: (element) => this.observeChartElement(element, 'radar'),
        };
    }
    applyDataLabelFormatter(chartOptions, extraData,forminatorPercentage=false) {
        const datalabelPreFix = extraData.chart_datalabel_prefix;
        const datalabelPostFix = extraData.chart_datalabel_postfix;
        if(chartOptions.dataLabels){
            if ( extraData.string_format) {
                chartOptions.dataLabels.formatter = (val) => {
                    val = datalabelPreFix + this.formatNumber(val, extraData.chart_label_pointer_number_for_label) + datalabelPostFix;
                    if(extraData.chart_datalabels_format_showlabel){
                        let label = opts.w.globals.labels[opts.seriesIndex];
                        return label + "-" + datalabelPreFix + val + datalabelPostFix;
                    }
                    return datalabelPreFix + val + datalabelPostFix;
                };
            }else{
                if(forminatorPercentage){
                    let totals = opts.w.globals.seriesTotals.reduce((a, b) => {
                        return  a + b;
                    }, 0)
                    val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_label_pointer_number_for_label,
                        maximumFractionDigits: extraData.chart_label_pointer_number_for_label,
                    }).format(val/totals * 100)
                }
                chartOptions.dataLabels.formatter = (val,opts) => {
                    if(extraData.chart_datalabels_format_showlabel){
                        let label = opts.w.globals.labels[opts.seriesIndex];
                        return label + "-" + datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                            minimumFractionDigits: extraData.chart_label_pointer_number_for_label,
                            maximumFractionDigits: extraData.chart_label_pointer_number_for_label,
                        }).format(val) + datalabelPostFix ;
                    }
                    return datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_label_pointer_number_for_label,
                        maximumFractionDigits: extraData.chart_label_pointer_number_for_label,
                    }).format(val)  + datalabelPostFix ;
                }    
            }
        }
    }
   
    
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'radar') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}

// Initialize RadarChart
new RadarChart();
