import { initSetDiagnosis } from './modules/set-diagnosis';

function boot(): void {
	document.querySelectorAll<HTMLElement>('[data-js-set-diagnosis]').forEach((root) => {
		initSetDiagnosis(root);
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', boot);
} else {
	boot();
}
