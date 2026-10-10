import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';
import { defineConfig } from 'vite';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const themeDir = path.resolve(
	__dirname,
	'wp-content/themes/dorango-farm-custom',
);
const assetsDir = path.join(themeDir, 'assets');
const imgSrcDir = path.resolve(__dirname, 'src/img');
const imgOutDir = path.join(assetsDir, 'img');

async function isNewer(src, dest) {
	try {
		const [srcStat, destStat] = await Promise.all([
			fs.stat(src),
			fs.stat(dest),
		]);
		return srcStat.mtimeMs > destStat.mtimeMs;
	} catch {
		return true;
	}
}

function themeImages() {
	return {
		name: 'theme-images',
		async buildStart() {
			await fs.mkdir(imgOutDir, { recursive: true });
			const entries = await fs.readdir(imgSrcDir, { withFileTypes: true });
			for (const entry of entries) {
				if (!entry.isFile()) {
					continue;
				}
				const src = path.join(imgSrcDir, entry.name);
				this.addWatchFile(src);
				const ext = path.extname(entry.name).toLowerCase();
				if (ext === '.svg') {
					const dest = path.join(imgOutDir, entry.name);
					if (await isNewer(src, dest)) {
						await fs.copyFile(src, dest);
					}
					continue;
				}
				if (ext !== '.png' && ext !== '.jpg' && ext !== '.jpeg') {
					continue;
				}
				const dest = path.join(
					imgOutDir,
					`${path.basename(entry.name, path.extname(entry.name))}.webp`,
				);
				if (await isNewer(src, dest)) {
					await sharp(src).webp({ quality: 80 }).toFile(dest);
				}
			}
		},
	};
}

export default defineConfig({
	plugins: [themeImages()],
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
				contact: path.resolve(__dirname, 'src/scss/contact.scss'),
				common: path.resolve(__dirname, 'src/scripts/common.ts'),
				'contact-form': path.resolve(__dirname, 'src/scripts/contact.ts'),
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
