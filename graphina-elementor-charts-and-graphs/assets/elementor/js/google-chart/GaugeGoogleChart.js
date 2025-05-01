import GraphinaGoogleChartBase from './GraphinaGoogleChartBase';

// Child class specifically for Gauge Charts
export default class GaugeChart extends GraphinaGoogleChartBase {
    constructor(settings) {
        super(settings);
        this.chart = null;
        this.data = null;
        this.options = {};
    }

    /**
     * Sets up the chart handlers for Google Gauge Chart.
     */
    setUpChartsHandler() {
        this.chartHandlers = {
            gauge_google: (element) => this.observeChartElement(element, 'Gauge'),
        };

    }

    /**
     * Observes the chart element and initializes it when in viewport.
     * @param {jQuery} element - The jQuery element reference.
     * @param {string} chartType - The type of chart to initialize.
     */
    observeChartElement(element, chartType) {
        if (gcfe_public_localize.view_port === 'off') {
            if (!this.observer) {
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Initialize chart when in viewport
                            this.setupChart(jQuery(entry.target), chartType);
                            this.observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
            }
            this.observer.observe(element[0]);
        } else {
            this.setupChart(element, chartType);
        }
    }


    // Customize chart options for Gantt Charts (if needed)
    getFinalChartOptions(chartOptions,elementId){
        // Customize options here if needed
        return chartOptions;

    }

    setupTableData(dynamicData, dataTable, googleChart, googleChartTexture, extraData) {
        if(dynamicData?.google_chart_data?.data.length > 0){
            dataTable.addColumn('string', 'Month');
            dataTable.addColumn('number', 'Sale');
            dynamicData.google_chart_data.data.forEach(row => dataTable.addRow(row));
            googleChart.show()
            googleChartTexture.hide()
        } else if(dynamicData?.columns.length > 0 && dynamicData.rows.length > 0){
            dynamicData.columns.forEach((col, index) => {
                dataTable.addColumn(col[0],col[1])
            });
            dynamicData.rows.forEach(row => dataTable.addRow(row));
        } else{
            googleChart.hide()
            googleChartTexture.show()
        }
        var formatter = new google.visualization.NumberFormat({
            prefix: extraData.prefix ?? '',
            suffix: extraData.suffix ?? '',
            fractionDigits: extraData.fractionDigits ?? 0
        });
        formatter.format(dataTable, 1);;
    }
    
    afterSetupChart(element, extraData) {
        // Define color mappings
        const circleColors = {
            "#4684ee": extraData.ballColor ?? "#4684ee",
            "#f7f7f7": extraData.innerCircleColor ?? "#f7f7f7",
            "#cccccc": extraData.outerCircleColor ?? "#cccccc"
        };
    
        const needleColor = extraData.needleColor ?? "#c63310";
    
        // Update circle colors
        element.querySelectorAll("circle").forEach(circle => {
            const fillColor = circleColors[circle.getAttribute("fill")];
            if (fillColor) circle.setAttribute("fill", fillColor);
        });
    
        // Update path colors
        element.querySelectorAll("path").forEach(path => {
            if (path.getAttribute("stroke") === "#c63310") {
                path.setAttribute("stroke", needleColor);
                path.setAttribute("fill", needleColor);
            }
        });
    }
    


}
// Initialize Gauge Chart
new GaugeChart();
