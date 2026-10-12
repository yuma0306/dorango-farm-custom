declare global {
	interface Window {
		dataLayer?: Record<string, unknown>[];
	}
}

const GTM_EVENT = 'ball_python_shindan';
const OUTCOME_ID_KEY = 'ball_python_shindan_outcome_id';

export function pushBallPythonShindan(outcomeId: string): void {
	const dataLayer = getDataLayer();
	dataLayer.push({
		event: GTM_EVENT,
		[OUTCOME_ID_KEY]: outcomeId,
	});
}

function getDataLayer(): Record<string, unknown>[] {
	if (!Array.isArray(window.dataLayer)) {
		window.dataLayer = [];
	}
	return window.dataLayer;
}
