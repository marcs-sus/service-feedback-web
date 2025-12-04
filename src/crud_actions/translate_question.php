<?php
require_once __DIR__ . '/../auth/auth_required.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../model/question_translation.php';

auth_required('../../public/admin/login_page.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = $_POST['question_id'];
    $locale = $_POST['locale'];

    try {
        // Get all supported locales
        require_once __DIR__ . '/../locales.php';
        $locale_manager = new LocaleManager($locale);
        $supported = $locale_manager->get_supported_locales();

        // Save/update translations for each locale
        foreach (array_keys($supported) as $locale_code) {
            $key = "translate_$locale_code";
            $text = $_POST[$key] ?? '';

            if (!empty(trim($text))) {
                // Check if translation exists
                $existing = QuestionTranslation::find_by_question_and_locale($question_id, $locale_code);

                if ($existing) {
                    QuestionTranslation::update($question_id, $locale_code, $text);
                } else {
                    QuestionTranslation::create($question_id, $locale_code, $text);
                }
            }
        }

        header('Location: ../../public/admin/crud/questions/list_questions.php?locale=' . $locale);
    } catch (Exception $ex) {
        die('Error: ' . $ex->getMessage());
    }

    exit;
}
