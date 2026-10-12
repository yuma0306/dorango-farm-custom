declare global {
	interface Window {
		dataLayer?: Record<string, unknown>[];
	}
}

const GTM_EVENT = 'ball_python_shindan';
const ACTION_KEY = 'ball_python_shindan_action';
const OUTCOME_ID_KEY = 'ball_python_shindan_outcome_id';

type ShindanAnswerPayload = Partial<
	Record<'sex' | 'breeding' | 'airConditioned' | 'layout' | 'thermometer', string>
>;

export function pushBallPythonShindan(payload: {
	outcomeId: string;
	answers: ShindanAnswerPayload;
}): void {
	const dataLayer = getDataLayer();
	const data: Record<string, string> = {
		event: GTM_EVENT,
		[ACTION_KEY]: 'result',
		[OUTCOME_ID_KEY]: payload.outcomeId,
	};
	if (payload.answers) {
		for (const [questionId, value] of Object.entries(payload.answers)) {
			if (value !== undefined && value !== '') {
				data[`ball_python_shindan_${questionId}`] = value;
			}
		}
	}
	dataLayer.push(data);
}

function getDataLayer(): Record<string, unknown>[] {
	if (!Array.isArray(window.dataLayer)) {
		window.dataLayer = [];
	}
	return window.dataLayer;
}
