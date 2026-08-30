import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const themeDir = path.resolve(
	__dirname,
	'wp-content/themes/dorango-farm-custom',
);
const assetsDir = path.join(themeDir, 'assets');

export default defineConfig({
	root: __dirname,
	base: '/wp-content/themes/dorango-farm-custom/assets/',
	publicDir: false,
	build: {
		outDir: assetsDir,
		emptyOutDir: false,
		cssMinify: true,
		minify: true,
		sourcemap: false,
		assetsInlineLimit: 0,
		watch: {
			exclude: [
				'wp-content/themes/dorango-farm-custom/assets/**',
				'sql/**',
			],
			chokidar: {
				ignored: [
					'**/wp-content/themes/dorango-farm-custom/assets/**',
					'**/sql/**',
				],
			},
		},
		rollupOptions: {
			input: {
				style: path.resolve(__dirname, 'src/scss/style.scss'),
				'front-page': path.resolve(__dirname, 'src/scss/front-page.scss'),
				contact: path.resolve(__dirname, 'src/scss/contact.scss'),
				common: path.resolve(__dirname, 'src/js/common.js'),
				front: path.resolve(__dirname, 'src/js/front.js'),
				'contact-form': path.resolve(__dirname, 'src/js/contact.js'),
			},
			output: {
				entryFileNames: (chunk) => {
					const name =
						chunk.name === 'contact-form' ? 'contact' : chunk.name;
					return `js/${name}.js`;
				},
				chunkFileNames: 'js/[name]-[hash].js',
				assetFileNames: (assetInfo) => {
					const fileName = assetInfo.names?.[0] || assetInfo.name || '';
					if (fileName.endsWith('.css')) {
						return 'css/[name][extname]';
					}
					if (/\.(ttf|woff2?|otf|eot)$/i.test(fileName)) {
						return 'font/[name][extname]';
					}
					return 'img/[name][extname]';
				},
			},
		},
	},
});
