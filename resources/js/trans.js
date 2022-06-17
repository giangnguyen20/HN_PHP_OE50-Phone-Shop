export default function trans(key, replace = {}) {
    let translation = key.split('.').reduce((t, i) => t[i] || key, window.translations);

    if (translation == key) {
        translation = window.translationJsons[key] || key;
    }

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
}
