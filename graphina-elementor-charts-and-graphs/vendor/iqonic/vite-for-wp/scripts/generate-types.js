import { createBundle } from 'dts-buddy';

await createBundle( {
	include: [ 'src' ],
	output: 'types/index.d.ts',
	modules: {
		'@iqonic/vite-for-wp': 'src/exports/index.js',
		'@iqonic/vite-for-wp/plugins': 'src/exports/plugins/index.js',
		'@iqonic/vite-for-wp/utils': 'src/exports/utils/index.js',
	},
} );
