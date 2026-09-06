<?php

/**
 * Hestens Learning - PHP Helper Functions & Data Utilities
 */

function get_curriculum_data()
{
    static $data = null;
    if ($data === null) {
        $jsonPath = __DIR__ . '/../data/curriculum-grades-homepage.json';
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $data = json_decode($json, true);
        } else {
            $data = ['grades' => []];
        }
    }
    return $data;
}

function get_all_grades()
{
    $curriculum = get_curriculum_data();
    return $curriculum['grades'] ?? [];
}

function get_subject_display_name($subKey, $fallbackTitle = '')
{
    $map = [
        'math' => 'Math',
        'ela' => 'ELA',
        'science' => 'Science',
        'social-studies' => 'Social Studies',
        'social_studies' => 'Social Studies',
        'ss' => 'Social Studies'
    ];
    $cleanKey = strtolower(trim((string)$subKey));
    return $map[$cleanKey] ?? ($fallbackTitle ?: ucfirst($subKey));
}

function get_lesson_standards($lesson, $subjectId = '', $gradeId = '')
{
    // 1. If explicitly defined in the lesson object
    if (!empty($lesson['standards']) && is_array($lesson['standards'])) {
        return $lesson['standards'];
    }
    if (!empty($lesson['standard'])) {
        if (is_array($lesson['standard'])) {
            return $lesson['standard'];
        }
        return [[
            'code' => (string)$lesson['standard'],
            'framework' => 'Standard',
            'description' => 'Aligned Educational Standard'
        ]];
    }

    // 2. Intelligent standard alignment based on subject and grade level
    $normGrade = normalize_grade_id($gradeId);
    $sub = strtolower(trim((string)$subjectId));
    $lessonTitle = strtolower($lesson['title'] ?? '');
    $badge = strtolower($lesson['badge'] ?? '');

    // Mathematics: Common Core State Standards (CCSS.MATH)
    if ($sub === 'math') {
        if ($normGrade === 'pre-k' || $normGrade === 'kindergarten') {
            $stdCode = 'CCSS.MATH.K.CC.A.1';
            $stdDesc = 'Know number names and the count sequence (1 to 20+)';
            if (strpos($lessonTitle, 'shape') !== false || strpos($badge, 'shape') !== false || strpos($lessonTitle, 'pattern') !== false) {
                $stdCode = 'CCSS.MATH.K.G.A.2';
                $stdDesc = 'Correctly name shapes regardless of their orientations or overall size';
            } elseif (strpos($lessonTitle, 'add') !== false || strpos($badge, 'add') !== false) {
                $stdCode = 'CCSS.MATH.K.OA.A.1';
                $stdDesc = 'Represent addition and subtraction with objects, fingers, and mental images';
            }
        } elseif ($normGrade === '1st') {
            $stdCode = 'CCSS.MATH.1.OA.C.6';
            $stdDesc = 'Add and subtract within 20, demonstrating fluency for addition and subtraction within 10';
        } elseif ($normGrade === '2nd') {
            $stdCode = 'CCSS.MATH.2.NBT.A.1';
            $stdDesc = 'Understand that the three digits of a three-digit number represent amounts of hundreds, tens, and ones';
        } elseif ($normGrade === '3rd') {
            $stdCode = 'CCSS.MATH.3.OA.A.1';
            $stdDesc = 'Interpret products of whole numbers (e.g., interpret 5 × 7 as the total number of objects in 5 groups of 7)';
            if (strpos($lessonTitle, 'fraction') !== false || strpos($badge, 'fraction') !== false) {
                $stdCode = 'CCSS.MATH.3.NF.A.1';
                $stdDesc = 'Understand a fraction 1/b as the quantity formed by 1 part when a whole is partitioned into b equal parts';
            }
        } elseif ($normGrade === '4th') {
            $stdCode = 'CCSS.MATH.4.NBT.B.4';
            $stdDesc = 'Fluently add and subtract multi-digit whole numbers using the standard algorithm';
        } elseif ($normGrade === '5th') {
            $stdCode = 'CCSS.MATH.5.NBT.B.7';
            $stdDesc = 'Add, subtract, multiply, and divide decimals to hundredths using concrete models or drawings';
        } elseif ($normGrade === '6th') {
            $stdCode = 'CCSS.MATH.6.RP.A.1';
            $stdDesc = 'Understand the concept of a ratio and use ratio language to describe a ratio relationship';
        } elseif ($normGrade === '7th') {
            $stdCode = 'CCSS.MATH.7.NS.A.1';
            $stdDesc = 'Apply and extend previous understandings of addition and subtraction to add and subtract rational numbers';
        } elseif ($normGrade === '8th') {
            $stdCode = 'CCSS.MATH.8.EE.B.5';
            $stdDesc = 'Graph proportional relationships, interpreting the unit rate as the slope of the graph';
        } elseif ($normGrade === '9th') {
            $stdCode = 'CCSS.MATH.HSA.CED.A.1';
            $stdDesc = 'Create equations and inequalities in one variable and use them to solve problems (Algebra I)';
        } elseif ($normGrade === '10th') {
            $stdCode = 'CCSS.MATH.HSG.CO.A.1';
            $stdDesc = 'Know precise definitions of angle, circle, perpendicular line, and parallel line (Geometry)';
        } elseif ($normGrade === '11th') {
            $stdCode = 'CCSS.MATH.HSA.APR.A.1';
            $stdDesc = 'Understand that polynomials form a system analogous to the integers and operate on polynomials (Algebra II)';
        } elseif ($normGrade === '12th') {
            $stdCode = 'CCSS.MATH.HSF.TF.A.1';
            $stdDesc = 'Understand radian measure of an angle as the length of the arc on the unit circle (Precalculus)';
        } else {
            $stdCode = 'CCSS.MATH.MP1';
            $stdDesc = 'Make sense of problems and persevere in solving them';
        }
        return [
            ['code' => $stdCode, 'framework' => 'CCSS.MATH', 'description' => $stdDesc]
        ];
    }

    // English Language Arts: Common Core State Standards (CCSS.ELA)
    if ($sub === 'ela') {
        if ($normGrade === 'pre-k' || $normGrade === 'kindergarten') {
            $stdCode = 'CCSS.ELA.RF.K.1';
            $stdDesc = 'Demonstrate understanding of the organization and basic features of print';
            if (strpos($lessonTitle, 'sound') !== false || strpos($badge, 'phon') !== false) {
                $stdCode = 'CCSS.ELA.RF.K.2';
                $stdDesc = 'Demonstrate understanding of spoken words, syllables, and sounds (phonemes)';
            }
        } elseif ($normGrade === '1st') {
            $stdCode = 'CCSS.ELA.RL.1.1';
            $stdDesc = 'Ask and answer questions about key details in a text';
        } elseif ($normGrade === '2nd') {
            $stdCode = 'CCSS.ELA.RL.2.3';
            $stdDesc = 'Describe how characters in a story respond to major events and challenges';
        } elseif ($normGrade === '3rd') {
            $stdCode = 'CCSS.ELA.RL.3.2';
            $stdDesc = 'Recount stories, including fables and folktales, and determine the central message, lesson, or moral';
        } elseif ($normGrade === '4th') {
            $stdCode = 'CCSS.ELA.RI.4.1';
            $stdDesc = 'Refer to details and examples in a text when explaining what the text says explicitly and when drawing inferences';
        } elseif ($normGrade === '5th') {
            $stdCode = 'CCSS.ELA.RL.5.2';
            $stdDesc = 'Determine a theme of a story, drama, or poem from details in the text, including how characters respond';
        } elseif ($normGrade === '6th') {
            $stdCode = 'CCSS.ELA.RL.6.1';
            $stdDesc = 'Cite textual evidence to support analysis of what the text says explicitly as well as inferences drawn';
        } elseif ($normGrade === '7th') {
            $stdCode = 'CCSS.ELA.RL.7.2';
            $stdDesc = 'Determine a theme or central idea of a text and analyze its development over the course of the text';
        } elseif ($normGrade === '8th') {
            $stdCode = 'CCSS.ELA.RI.8.8';
            $stdDesc = 'Delineate and evaluate the argument and specific claims in a text, assessing whether the reasoning is sound';
        } elseif ($normGrade === '9th') {
            $stdCode = 'CCSS.ELA.RL.9-10.1';
            $stdDesc = 'Cite strong and thorough textual evidence to support analysis of what the text says explicitly and implicitly';
        } elseif ($normGrade === '10th') {
            $stdCode = 'CCSS.ELA.RI.9-10.6';
            $stdDesc = 'Determine an author\'s point of view or purpose in a text and analyze how an author uses rhetoric';
        } elseif ($normGrade === '11th') {
            $stdCode = 'CCSS.ELA.RL.11-12.3';
            $stdDesc = 'Analyze the impact of the author\'s choices regarding how to develop and relate elements of a story';
        } elseif ($normGrade === '12th') {
            $stdCode = 'CCSS.ELA.RI.11-12.7';
            $stdDesc = 'Integrate and evaluate multiple sources of information presented in different media or formats';
        } else {
            $stdCode = 'CCSS.ELA.CCRA.R.1';
            $stdDesc = 'Read closely to determine what the text says explicitly and to make logical inferences';
        }
        return [
            ['code' => $stdCode, 'framework' => 'CCSS.ELA', 'description' => $stdDesc]
        ];
    }

    // Science: Next Generation Science Standards (NGSS)
    if ($sub === 'science') {
        if ($normGrade === 'pre-k' || $normGrade === 'kindergarten') {
            $stdCode = 'NGSS.K-LS1-1';
            $stdDesc = 'Use observations to describe patterns of what plants and animals (including humans) need to survive';
        } elseif ($normGrade === '1st') {
            $stdCode = 'NGSS.1-PS4-1';
            $stdDesc = 'Plan and conduct investigations to provide evidence that vibrating materials can make sound';
        } elseif ($normGrade === '2nd') {
            $stdCode = 'NGSS.2-LS4-1';
            $stdDesc = 'Make observations of plants and animals to compare the diversity of life in different habitats';
        } elseif ($normGrade === '3rd') {
            $stdCode = 'NGSS.3-PS2-1';
            $stdDesc = 'Plan and conduct an investigation to provide evidence of the effects of balanced and unbalanced forces on the motion of an object';
        } elseif ($normGrade === '4th') {
            $stdCode = 'NGSS.4-ESS2-1';
            $stdDesc = 'Make observations and/or measurements to provide evidence of the effects of weathering or the rate of erosion';
        } elseif ($normGrade === '5th') {
            $stdCode = 'NGSS.5-PS1-1';
            $stdDesc = 'Develop a model to describe that matter is made of particles too small to be seen';
        } elseif (in_array($normGrade, ['6th', '7th', '8th'])) {
            $stdCode = 'NGSS.MS-PS1-2';
            $stdDesc = 'Analyze and interpret data on the properties of substances before and after the substances interact to determine if a chemical reaction has occurred';
        } else {
            $stdCode = 'NGSS.HS-LS1-1';
            $stdDesc = 'Construct an explanation based on evidence for how the structure of DNA determines the structure of proteins';
        }
        return [
            ['code' => $stdCode, 'framework' => 'NGSS', 'description' => $stdDesc]
        ];
    }

    // Social Studies: College, Career, and Civic Life (C3) Framework
    if ($sub === 'social-studies' || $sub === 'social_studies' || $sub === 'ss') {
        if ($normGrade === 'pre-k' || $normGrade === 'kindergarten' || $normGrade === '1st' || $normGrade === '2nd') {
            $stdCode = 'C3.D2.Civ.2.K-2';
            $stdDesc = 'Explain how all people, not just official leaders, play important roles in a community and classroom';
        } elseif ($normGrade === '3rd' || $normGrade === '4th' || $normGrade === '5th') {
            $stdCode = 'C3.D2.His.1.3-5';
            $stdDesc = 'Create and use a chronological sequence of related events to compare perspectives in local and national history';
        } elseif (in_array($normGrade, ['6th', '7th', '8th'])) {
            $stdCode = 'C3.D2.Geo.2.6-8';
            $stdDesc = 'Use maps, satellite images, and other geospatial technologies to explain relationships between places and environments';
        } else {
            $stdCode = 'C3.D2.Civ.14.9-12';
            $stdDesc = 'Analyze historical, contemporary, and emerging constitutional issues in democratic societies and civic life';
        }
        return [
            ['code' => $stdCode, 'framework' => 'C3 Framework', 'description' => $stdDesc]
        ];
    }

    return [
        ['code' => 'STATE.GEN.1', 'framework' => 'State Standard', 'description' => 'Aligned with state curriculum guidelines']
    ];
}

function normalize_grade_id($gradeId)
{
    if (!$gradeId) return null;
    $g = strtolower(trim((string)$gradeId));
    $map = [
        'pre-k' => 'pre-k',
        'prek' => 'pre-k',
        'pk' => 'pre-k',
        '0' => 'pre-k',
        'early' => 'pre-k',
        'k' => 'kindergarten',
        'kinder' => 'kindergarten',
        'kindergarten' => 'kindergarten',
        '1' => '1st',
        '1st' => '1st',
        'first' => '1st',
        'grade-1' => '1st',
        'grade1' => '1st',
        '2' => '2nd',
        '2nd' => '2nd',
        'second' => '2nd',
        'grade-2' => '2nd',
        'grade2' => '2nd',
        '3' => '3rd',
        '3rd' => '3rd',
        'third' => '3rd',
        'grade-3' => '3rd',
        'grade3' => '3rd',
        '4' => '4th',
        '4th' => '4th',
        'fourth' => '4th',
        'grade-4' => '4th',
        'grade4' => '4th',
        '5' => '5th',
        '5th' => '5th',
        'fifth' => '5th',
        'grade-5' => '5th',
        'grade5' => '5th',
        '6' => '6th',
        '6th' => '6th',
        'sixth' => '6th',
        'grade-6' => '6th',
        'grade6' => '6th',
        '7' => '7th',
        '7th' => '7th',
        'seventh' => '7th',
        'grade-7' => '7th',
        'grade7' => '7th',
        '8' => '8th',
        '8th' => '8th',
        'eighth' => '8th',
        'grade-8' => '8th',
        'grade8' => '8th',
        '9' => '9th',
        '9th' => '9th',
        'ninth' => '9th',
        'freshman' => '9th',
        'grade-9' => '9th',
        'grade9' => '9th',
        '10' => '10th',
        '10th' => '10th',
        'tenth' => '10th',
        'sophomore' => '10th',
        'grade-10' => '10th',
        'grade10' => '10th',
        '11' => '11th',
        '11th' => '11th',
        'eleventh' => '11th',
        'junior' => '11th',
        'grade-11' => '11th',
        'grade11' => '11th',
        '12' => '12th',
        '12th' => '12th',
        'twelfth' => '12th',
        'senior' => '12th',
        'grade-12' => '12th',
        'grade12' => '12th',
    ];
    return $map[$g] ?? $g;
}

function get_grade($gradeId)
{
    $normalizedId = normalize_grade_id($gradeId);
    $grades = get_all_grades();
    return $grades[$normalizedId] ?? $grades[$gradeId] ?? null;
}

function get_lesson($gradeId, $subjectId, $lessonId)
{
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

function search_curriculum($query)
{
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

function get_assessments_data()
{
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

function get_user_font()
{
    return $_COOKIE['hestens_font'] ?? 'lexend';
}

function get_user_theme()
{
    return $_COOKIE['hestens_theme'] ?? 'dark';
}
