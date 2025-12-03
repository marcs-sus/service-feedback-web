// Locale management functions

function changeLocale(locale) {
  const currentParams = new URLSearchParams(window.location.search);
  currentParams.set("locale", locale);
  window.location.href =
    window.location.pathname + "?" + currentParams.toString();
}

function t(key, defaultValue = "") {
  return translations[key] ?? defaultValue ?? key;
}

function updatePageTranslations() {
  // Update all elements with data-i18n attribute
  document.querySelectorAll("[data-i18n]").forEach((element) => {
    const key = element.getAttribute("data-i18n");
    const translated = t(key);

    if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
      if (element.placeholder) {
        element.placeholder = translated;
      }
    } else {
      element.textContent = translated;
    }
  });

  // Update all elements with data-i18n-attr attribute for attributes
  document.querySelectorAll("[data-i18n-attr]").forEach((element) => {
    const attrs = element.getAttribute("data-i18n-attr").split(",");
    attrs.forEach((attr) => {
      const key = element.getAttribute(`data-i18n-${attr.trim()}`);
      if (key) {
        element.setAttribute(attr.trim(), t(key));
      }
    });
  });
}
