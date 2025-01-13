<?php

get_header();

// Fetch related "Pitanja" (questions) from the ACF Relationship field
$questions = get_field('select_questions'); // Adjust field name if different

if ($questions): ?>
    <div class="exam-questions">
        <?php foreach ($questions as $question): 
            setup_postdata($question); ?>
            <div class="question" data-type="<?php echo get_field('question_type', $question->ID); ?>">
                <h3><?php echo get_the_title($question->ID); ?></h3>
                <p><?php echo get_the_content(null, false, $question->ID); ?></p>

                <?php
                // Fetch answers from ACF
                $answers = [
                    ['text' => get_field('answer_1', $question->ID), 'correct' => get_field('answer_1_correct', $question->ID)],
                    ['text' => get_field('answer_2', $question->ID), 'correct' => get_field('answer_2_correct', $question->ID)],
                    ['text' => get_field('answer_3', $question->ID), 'correct' => get_field('answer_3_correct', $question->ID)],
                    ['text' => get_field('answer_4', $question->ID), 'correct' => get_field('answer_4_correct', $question->ID)],
                    ['text' => get_field('answer_5', $question->ID), 'correct' => get_field('answer_5_correct', $question->ID)],
                    ['text' => get_field('answer_text', $question->ID), 'correct' => get_field('answer_text_correct', $question->ID)],
                ];

                // Filter out empty answers for types that require them
                $answers = array_filter($answers, fn($answer) => !empty($answer['text']));
                ?>

                <form class="student-answers">
                    <?php if (get_field('question_type', $question->ID) === 'enter_text'): ?>
                        <!-- Enter Text Field (only one for this type) -->
                      <div>
                            <input 
                                type="text" 
                                name="question_<?php echo $question->ID; ?>_text" 
                                id="answer_<?php echo $question->ID . '_text'; ?>" 
                                placeholder="Enter your answer"
                                data-correct="<?php echo !empty($answers[0]['correct']) ? esc_attr($answers[0]['correct']) : 'false'; ?>" 
                                data-correct-answer="<?php echo !empty($answers[0]['text']) ? esc_attr($answers[0]['text']) : ''; ?>"
                            >
                        </div>
                    <?php else: ?>
                        <?php foreach ($answers as $index => $answer): ?>
                            <div>
                                <?php if (get_field('question_type', $question->ID) === 'true_false'): ?>
                                    <!-- True/False Radio Buttons -->
                                    <input type="radio" name="question_<?php echo $question->ID; ?>" value="<?php echo $index; ?>" id="answer_<?php echo $question->ID . '_' . $index; ?>" data-correct="<?php echo $answer['correct'] ? 'true' : 'false'; ?>">
                                    <label for="answer_<?php echo $question->ID . '_' . $index; ?>"><?php echo esc_html($answer['text']); ?></label>
                                <?php elseif (get_field('question_type', $question->ID) === 'multiple_choice'): ?>
                                    <!-- Multiple Choice Checkboxes -->
                                    <input type="checkbox" name="question_<?php echo $question->ID; ?>[]" value="<?php echo $index; ?>" id="answer_<?php echo $question->ID . '_' . $index; ?>" data-correct="<?php echo $answer['correct'] ? 'true' : 'false'; ?>">
                                    <label for="answer_<?php echo $question->ID . '_' . $index; ?>"><?php echo esc_html($answer['text']); ?></label>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </form>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <button id="submit-exam">Submit</button>
<?php else: ?>
    <p>No questions have been added to this exam yet.</p>
<?php endif; 

get_footer();
?>