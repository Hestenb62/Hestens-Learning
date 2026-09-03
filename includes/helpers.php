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

function get_grade($gradeId) {
    $grades = get_all_grades();
    return $grades[$gradeId] ?? null;
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
