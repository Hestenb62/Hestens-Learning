<?php
/**
 * Hestens Learning - PHP Helper Functions & Data Utilities
 */

function get_curriculum_data() {
    static $data = null;
    if ($data === null) {
        $jsonPath = __DIR__ . '/../data/curriculum.json';
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $data = json_decode($json, true);
        } else {
            $data = ['grades' => []];
        }
    }
    return $data;
}

function get_all_grades() {
    $curriculum = get_curriculum_data();
    return $curriculum['grades'] ?? [];
}

function normalize_grade_id($gradeId) {
    if (!$gradeId) return null;
    $g = strtolower(trim((string)$gradeId));
    $map = [
        'pre-k' => 'pre-k', 'prek' => 'pre-k', 'pk' => 'pre-k', '0' => 'pre-k', 'early' => 'pre-k',
        'k' => 'kindergarten', 'kinder' => 'kindergarten', 'kindergarten' => 'kindergarten',
        '1' => '1st', '1st' => '1st', 'first' => '1st', 'grade-1' => '1st', 'grade1' => '1st',
        '2' => '2nd', '2nd' => '2nd', 'second' => '2nd', 'grade-2' => '2nd', 'grade2' => '2nd',
        '3' => '3rd', '3rd' => '3rd', 'third' => '3rd', 'grade-3' => '3rd', 'grade3' => '3rd',
        '4' => '4th', '4th' => '4th', 'fourth' => '4th', 'grade-4' => '4th', 'grade4' => '4th',
        '5' => '5th', '5th' => '5th', 'fifth' => '5th', 'grade-5' => '5th', 'grade5' => '5th',
        '6' => '6th', '6th' => '6th', 'sixth' => '6th', 'grade-6' => '6th', 'grade6' => '6th',
        '7' => '7th', '7th' => '7th', 'seventh' => '7th', 'grade-7' => '7th', 'grade7' => '7th',
        '8' => '8th', '8th' => '8th', 'eighth' => '8th', 'grade-8' => '8th', 'grade8' => '8th',
        '9' => '9th', '9th' => '9th', 'ninth' => '9th', 'freshman' => '9th', 'grade-9' => '9th', 'grade9' => '9th',
        '10' => '10th', '10th' => '10th', 'tenth' => '10th', 'sophomore' => '10th', 'grade-10' => '10th', 'grade10' => '10th',
        '11' => '11th', '11th' => '11th', 'eleventh' => '11th', 'junior' => '11th', 'grade-11' => '11th', 'grade11' => '11th',
        '12' => '12th', '12th' => '12th', 'twelfth' => '12th', 'senior' => '12th', 'grade-12' => '12th', 'grade12' => '12th',
    ];
    return $map[$g] ?? $g;
}

function get_grade($gradeId) {
    $normalizedId = normalize_grade_id($gradeId);
    $grades = get_all_grades();
    return $grades[$normalizedId] ?? $grades[$gradeId] ?? null;
}

function get_lesson($gradeId, $subjectId, $lessonId) {
    $grade = get_grade($gradeId);
    if (!$grade || !isset($grade['subjects'][$subjectId]['lessons'])) {
        return null;
    }

    foreach ($grade['subjects'][$subjectId]['lessons'] as $idx => $lesson) {
        if ($lesson['id'] === $lessonId) {
            $prevLesson = $grade['subjects'][$subjectId]['lessons'][$idx - 1] ?? null;
            $nextLesson = $grade['subjects'][$subjectId]['lessons'][$idx + 1] ?? null;
            return [
                'lesson' => $lesson,
                'grade' => $grade,
                'subject' => $grade['subjects'][$subjectId],
                'subjectId' => $subjectId,
                'prev' => $prevLesson,
                'next' => $nextLesson
            ];
        }
    }
    return null;
}

function search_curriculum($query) {
    $query = strtolower(trim($query));
    if (empty($query)) return [];

    $results = [];
    $grades = get_all_grades();

    foreach ($grades as $gradeId => $grade) {
        foreach ($grade['subjects'] as $subjectId => $subject) {
            // Check subject title/desc
            if (strpos(strtolower($subject['title']), $query) !== false || strpos(strtolower($subject['description']), $query) !== false) {
                $results[] = [
                    'type' => 'subject',
                    'title' => $grade['title'] . ' - ' . $subject['title'],
                    'snippet' => $subject['description'],
                    'url' => "grade.php?level={$gradeId}&tab={$subjectId}",
                    'grade' => $grade['title'],
                    'icon' => $subject['icon']
                ];
            }

            // Check lessons
            if (!empty($subject['lessons'])) {
                foreach ($subject['lessons'] as $lesson) {
                    $found = (
                        strpos(strtolower($lesson['title']), $query) !== false ||
                        strpos(strtolower($lesson['summary'] ?? ''), $query) !== false ||
                        strpos(strtolower($lesson['badge'] ?? ''), $query) !== false
                    );
                    if ($found) {
                        $results[] = [
                            'type' => 'lesson',
                            'title' => $lesson['title'],
                            'snippet' => $lesson['summary'] ?? $lesson['badge'],
                            'url' => "lesson.php?grade={$gradeId}&subject={$subjectId}&id={$lesson['id']}",
                            'grade' => $grade['title'],
                            'subject' => $subject['title'],
                            'icon' => $subject['icon']
                        ];
                    }
                }
            }
        }
    }
    return $results;
}

function get_assessments_data() {
    static $assessments = null;
    if ($assessments === null) {
        $jsonPath = __DIR__ . '/../data/assessments.json';
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $assessments = json_decode($json, true);
        } else {
            $assessments = ['gradeTiers' => [], 'subjects' => [], 'questions' => []];
        }
    }
    return $assessments;
}

function get_user_font() {
    return $_COOKIE['hestens_font'] ?? 'lexend';
}

function get_user_theme() {
    return $_COOKIE['hestens_theme'] ?? 'dark';
}
