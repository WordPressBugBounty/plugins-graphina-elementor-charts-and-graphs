import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Radial Charts
export default class RadialChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Radial chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            radial: (element) => this.observeChartElement(element, 'radial'),
        };
    }

    RadialChartDatalabelsFormat(chartOptions, extraData) {
        const prefix = extraData.chart_datalabel_prefix;
        const postfix = extraData.chart_datalabel_postfix;
     // Ensure plotOptions and radialBar exist before accessing datalabels
     chartOptions.plotOptions.radialBar.dataLabels.total.formatter = (w) => {
        // Get the total sum of all values in the series
        let total =   w.globals.seriesTotals.reduce((a, b) => {
            return a + b
        }, 0) ;
        
        return prefix + total + postfix;
        
         // Return total if you want to display it
        };
        chartOptions.plotOptions.radialBar.dataLabels.value.formatter = (val) => {
            // Get the total sum of all values in the series
            val = val;
            return prefix + val + postfix;
        }
    }
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'radial') {
            finalChartOptions.labels = finalChartOptions.xaxis.categories
            finalChartOptions.responsive = responsive_options
        }
        this.RadialChartDatalabelsFormat(finalChartOptions,extraData)
        return finalChartOptions;
    }
}

// Initialize RadialChart
new RadialChart();
