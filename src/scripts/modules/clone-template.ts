export function cloneTemplateContent(template: HTMLTemplateElement): DocumentFragment {
	const cloned = template.content.cloneNode(true);
	if (!(cloned instanceof DocumentFragment)) {
		throw new Error('Template content clone failed');
	}
	return cloned;
}
