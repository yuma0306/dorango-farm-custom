import { questions } from './shindan-questions';

const outcomeIds = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'] as const;

const outcomeMatchers: { id: OutcomeId; when: Partial<Record<QuestionId, string>> }[] = [
	{ id: 'A', when: { breeding: 'yes', airConditioned: 'yes' } },
	{ id: 'B', when: { breeding: 'yes', airConditioned: 'no', sex: 'male', layout: 'easy' } },
	{ id: 'C', when: { breeding: 'yes', airConditioned: 'no', sex: 'male', layout: 'natural' } },
	{ id: 'D', when: { breeding: 'yes', airConditioned: 'no', sex: 'female', layout: 'easy' } },
	{ id: 'E', when: { breeding: 'yes', airConditioned: 'no', sex: 'female', layout: 'natural' } },
	{ id: 'F', when: { breeding: 'no', sex: 'male', layout: 'easy', thermometer: 'basic' } },
	{ id: 'G', when: { breeding: 'no', sex: 'male', layout: 'easy', thermometer: 'advanced' } },
	{ id: 'H', when: { breeding: 'no', sex: 'male', layout: 'natural', thermometer: 'basic' } },
	{ id: 'I', when: { breeding: 'no', sex: 'male', layout: 'natural', thermometer: 'advanced' } },
	{ id: 'J', when: { breeding: 'no', sex: 'female', layout: 'easy', thermometer: 'basic' } },
	{ id: 'K', when: { breeding: 'no', sex: 'female', layout: 'easy', thermometer: 'advanced' } },
	{ id: 'L', when: { breeding: 'no', sex: 'female', layout: 'natural', thermometer: 'basic' } },
	{ id: 'M', when: { breeding: 'no', sex: 'female', layout: 'natural', thermometer: 'advanced' } },
];

const firstQuestionId: QuestionId = 'sex';

export function initShindan(): void {
	document.querySelectorAll<HTMLElement>('[data-js-shindan]').forEach((root) => {
		const ui = getUiElements(root);
		if (!ui) {
			return;
		}
		bindShindanUi(ui);
		renderQuestion(ui, firstQuestionId);
	});
}

function getUiElements(root: HTMLElement) {
	const quizEl = root.querySelector<HTMLElement>('[data-js-shindan-quiz]');
	const resultEl = root.querySelector<HTMLElement>('[data-js-shindan-result]');
	const outcomesEl = root.querySelector<HTMLElement>('[data-js-shindan-outcomes]');
	const outcomePanels = root.querySelectorAll<HTMLElement>('[data-js-shindan-outcome]');
	const retryBtn = root.querySelector<HTMLButtonElement>('[data-js-shindan-retry]');
	const questionTemplate = root.querySelector<HTMLTemplateElement>(
		'[data-js-shindan-question-template]',
	);
	const optionTemplate = root.querySelector<HTMLTemplateElement>(
		'[data-js-shindan-option-template]',
	);

	if (
		!quizEl ||
		!resultEl ||
		!outcomesEl ||
		!retryBtn ||
		!questionTemplate ||
		!optionTemplate ||
		outcomePanels.length !== outcomeIds.length
	) {
		return null;
	}

	return {
		quizEl,
		resultEl,
		outcomesEl,
		outcomePanels,
		retryBtn,
		questionTemplate,
		optionTemplate,
	};
}

type Ui = NonNullable<ReturnType<typeof getUiElements>>;

function bindShindanUi(ui: Ui): void {
	let answers: Answers = {};

	ui.quizEl.addEventListener('click', (event) => {
		const target = event.target;
		if (!(target instanceof Element)) {
			return;
		}
		const btn = target.closest<HTMLButtonElement>('[data-js-shindan-option]');
		if (!btn) {
			return;
		}
		const value = btn.dataset.shindanOptionValue;
		const field = btn.closest<HTMLElement>('[data-js-shindan-question]');
		const questionId = field?.getAttribute('data-js-shindan-question');
		if (!value || !questionId || !isQuestionId(questionId)) {
			return;
		}
		answers = pruneAnswers(withAnswer(answers, questionId, value));
		const flow = questionFlow(answers);
		const stepIndex = flow.indexOf(questionId);
		const nextId = flow[stepIndex + 1];
		if (!nextId) {
			showResult(ui, answers);
			return;
		}
		renderQuestion(ui, nextId);
	});

	ui.retryBtn.addEventListener('click', () => {
		answers = {};
		renderQuestion(ui, firstQuestionId);
		ui.resultEl.hidden = true;
		ui.quizEl.hidden = false;
		hideAllOutcomes(ui);
	});
}

function renderQuestion(ui: Ui, id: QuestionId): void {
	const def = questions[id];
	const fragment = ui.questionTemplate.content.cloneNode(true);
	if (!(fragment instanceof DocumentFragment)) {
		return;
	}
	const field = fragment.querySelector<HTMLElement>('[data-js-shindan-question]');
	const legend = fragment.querySelector<HTMLElement>('[data-js-shindan-question-text]');
	const optionsEl = fragment.querySelector<HTMLElement>('[data-js-shindan-question-options]');
	if (!field || !legend || !optionsEl) {
		return;
	}
	field.setAttribute('data-js-shindan-question', id);
	legend.textContent = def.question;
	for (const [value, label] of Object.entries(def.options)) {
		const optionFragment = ui.optionTemplate.content.cloneNode(true);
		if (!(optionFragment instanceof DocumentFragment)) {
			continue;
		}
		const btn = optionFragment.querySelector<HTMLButtonElement>('[data-js-shindan-option]');
		if (!btn) {
			continue;
		}
		btn.dataset.shindanOptionValue = value;
		btn.textContent = label;
		optionsEl.append(optionFragment);
	}
	ui.quizEl.replaceChildren(fragment);
}

function showResult(ui: Ui, answers: Answers): void {
	if (!isCompleteAnswers(answers)) {
		return;
	}
	ui.quizEl.hidden = true;
	ui.resultEl.hidden = false;
	hideAllOutcomes(ui);
	const outcomeId = resolveOutcomeId(answers);
	if (!outcomeId) {
		return;
	}
	const panel = ui.outcomesEl.querySelector<HTMLElement>(
		`[data-js-shindan-outcome="${outcomeId}"]`,
	);
	if (!panel) {
		return;
	}
	panel.hidden = false;
}

function hideAllOutcomes(ui: Ui): void {
	for (const panel of ui.outcomePanels) {
		panel.hidden = true;
	}
}

function resolveOutcomeId(answers: Answers): OutcomeId | null {
	for (const { id, when } of outcomeMatchers) {
		if (matchesWhen(answers, when)) {
			return id;
		}
	}
	return null;
}

function matchesWhen(answers: Answers, when: Partial<Record<QuestionId, string>>): boolean {
	return Object.entries(when).every(([key, value]) => {
		if (!isQuestionId(key)) {
			return false;
		}
		return answers[key] === value;
	});
}

function questionFlow(answers: Answers): QuestionId[] {
	const flow: QuestionId[] = ['sex', 'breeding'];
	if (answers.breeding === 'yes') {
		flow.push('airConditioned');
	}
	if (!isMujiBreedingRoute(answers)) {
		flow.push('layout');
	}
	if (answers.breeding === 'no') {
		flow.push('thermometer');
	}
	return flow;
}

function pruneAnswers(answers: Answers): Answers {
	const flow = questionFlow(answers);
	const pruned: Answers = {};
	for (const id of flow) {
		const value = answers[id];
		if (value !== undefined) {
			pruned[id] = value;
		}
	}
	return pruned;
}

function withAnswer(answers: Answers, id: QuestionId, value: string): Answers {
	if (!Object.hasOwn(questions[id].options, value)) {
		return answers;
	}
	return { ...answers, [id]: value };
}

function isCompleteAnswers(answers: Answers): boolean {
	const flow = questionFlow(answers);
	return flow.every((id) => {
		const value = answers[id];
		return value !== undefined && Object.hasOwn(questions[id].options, value);
	});
}

function isMujiBreedingRoute(answers: Answers): boolean {
	return answers.breeding === 'yes' && answers.airConditioned === 'yes';
}

function isQuestionId(id: string): id is QuestionId {
	return Object.hasOwn(questions, id);
}

type QuestionId = keyof typeof questions;
type OutcomeId = (typeof outcomeIds)[number];
type Answers = Partial<Record<QuestionId, string>>;
