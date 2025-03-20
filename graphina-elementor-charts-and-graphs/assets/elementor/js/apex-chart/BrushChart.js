import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Brush Charts
export default class BrushChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
        this.secondaryChart = [];
        this.secondaryChartData = [];
        this.dynamic_data  = []
    }

    // Setup handlers for brush chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            brush: (element) => this.observeChartElement(element, 'area'),
        };
    }
   
    afterRenderChart(chart, elementId,extra_data) {
        // Ensure secondary chart is initialized after primary chart is rendered
        if(chart){
        }
        this.initSChart(elementId,extra_data);
    }

    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'brush') {
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
    processDynamicData(dynamicData,elementId,extraData){
        if( (extraData.chart_data_option === true)){
            this.dynamic_data = dynamicData;
        }else{
            this.dynamic_data = {}
        }

    }

    initSChart(elementId,extra_data) {
        const chartEle = jQuery(`.graphina-brush-chart-${elementId}-2`)
        let primarychartOption = chartEle.data('second_chart_options')
        ApexCharts.exec(`brush-chart-${elementId}-2`, 'destroy');
        if (this.secondaryChart[elementId]) {
            this.secondaryChart[elementId].destroy()
        }
        if( this.dynamic_data.length > 0 && (this.dynamic_data.extra.series.length > 0) && (extra_data.chart_data_option === true)){
            primarychartOption.series = this.dynamic_data.extra.series
            primarychartOption.xaxis.categories = this.dynamic_data.extra.category
        }

        this.applyYAxisFormatter(primarychartOption,extra_data)
        this.applyXAxisFormatter(primarychartOption, extra_data);

        try {
            this.secondaryChart[elementId] = new ApexCharts(chartEle[0], primarychartOption);
            this.secondaryChart[elementId].render();
        } catch (error) {
            console.log(error);
        }
        
    }
}

// Initialize BrushChart
new BrushChart();
