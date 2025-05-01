import { v4wp } from '@kucrut/vite-for-wp';

export default {
    plugins: [
        v4wp({
            input: {
                adminMain: 'assets/admin/js/main.js',
                publicMain: 'assets/js/public-main.js',
                area: 'assets/elementor/js/apex-chart/AreaChart.js',
                area_google: 'assets/elementor/js/google-chart/AreaGoogleChart.js',
                line: 'assets/elementor/js/apex-chart/LineChart.js',
                line_google: 'assets/elementor/js/google-chart/LineGoogleChart.js',
                org_google: 'assets/elementor/js/google-chart/OrgGoogleChart.js',
                donut_google: 'assets/elementor/js/google-chart/DonutGoogleChart.js',
                column: 'assets/elementor/js/apex-chart/ColumnChart.js',
                column_google: 'assets/elementor/js/google-chart/ColumnGoogleChart.js',
                bar_google: 'assets/elementor/js/google-chart/BarGoogleChart.js',
                gantt_google: 'assets/elementor/js/google-chart/GanttGoogleChart.js',
                gauge_google: 'assets/elementor/js/google-chart/GaugeGoogleChart.js',
                bubble: 'assets/elementor/js/apex-chart/BubbleChart.js',
                timeline: 'assets/elementor/js/apex-chart/TimelineChart.js',
                donut: 'assets/elementor/js/apex-chart/DonutChart.js',
                radar: 'assets/elementor/js/apex-chart/RadarChart.js',
                brush: 'assets/elementor/js/apex-chart/BrushChart.js',
                counter: 'assets/elementor/js/apex-chart/CounterChart.js',
                radial: 'assets/elementor/js/apex-chart/RadialChart.js',
                pie: 'assets/elementor/js/apex-chart/PieChart.js',
                pie_google: 'assets/elementor/js/google-chart/PieGoogleChart.js',
                geo_google: 'assets/elementor/js/google-chart/GeoGoogleChart.js',
                Scatter: 'assets/elementor/js/apex-chart/ScatterChart.js',
                distributed_column_chart: 'assets/elementor/js/apex-chart/DistributeColumnChart.js',
                nestedcolumn: 'assets/elementor/js/apex-chart/NestedcolumnChart.js',
                polar: 'assets/elementor/js/apex-chart/PolarChart.js',
                candle: 'assets/elementor/js/apex-chart/CandleChart.js',
                heatmap: 'assets/elementor/js/apex-chart/HeatmapChart.js',
                mixed: 'assets/elementor/js/apex-chart/MixedChart.js',
                data_table: 'assets/elementor/js/apex-chart/DataTable.js',
                advance_data_table: 'assets/elementor/js/apex-chart/AdvanceDataTable.js',
            },
            outDir: 'dist', // Output directory for production
        }),
        {
            name: 'graphina-config',
            config: () => ({
                build: {
                    manifest: 'manifest.json',
                    assetsDir: '',
                    sourcemap: true,
                    rollupOptions: {
                        output: {
                            manualChunks: {
                                'vendor': ['jquery'],
                            }
                        }
                    }
                },
            }),
        },
    ],
    // Define global variable for jQuery
    define: {
        'window.jQuery': 'jQuery',
    },
};
