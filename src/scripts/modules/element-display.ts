export function hideElement(element: HTMLElement): void {
	element.style.display = 'none';
}

export function showElement(element: HTMLElement): void {
	element.style.display = '';
}

export function isElementHidden(element: HTMLElement): boolean {
	return element.style.display === 'none';
}
