export const getElements = (selector, parentEl) => {
  parentEl = parentEl || document

  return [].concat(...parentEl.querySelectorAll(selector))
}