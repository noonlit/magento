<?php

Mage::log('Started data-install-0.1.0', null, 'scripts.log');
$questions = array(
    array(
        'text' => 'Question #3',
        'status' => 'approved',
        'product_id' => '448',
        'customer_id' => '24'
    ), 
    array(
        'text' => 'Question #6',
        'status' => 'approved',
        'product_id' => '450',
        'customer_id' => '25'
    ),
    array(
        'text' => 'Question #7',
        'status' => 'approved',
        'product_id' => '448',
        'customer_id' => '26'
    ),
    array(
        'text' => 'Question #8',
        'status' => 'approved',
        'product_id' => '450',
        'customer_id' => '26'
    ),
    array(
        'text' => 'Question #5',
        'status' => 'pending',
        'product_id' => '450',
        'customer_id' => '25'
    ),
    array(
        'text' => 'Question #1',
        'status' => 'new',
        'product_id' => '448',
        'customer_id' => '24'
    ),
    array(
        'text' => 'Question #2',
        'status' => 'pending',
        'product_id' => '448',
        'customer_id' => '24'
    ),
    array(
        'text' => 'Question #4',
        'status' => 'new',
        'product_id' => '450',
        'customer_id' => '25'
    ),
    
);
$answers = array(
    array(
        'answer' => 'Answer #1',
        'user_id' => '7'
    ),
    array(
        'answer' => 'Answer #2',
        'user_id' => '7'
    ),
    array(
        'answer' => 'Answer #3',
        'user_id' => '7'
    ),
);

$answersCount = 1;
foreach ($questions as $question) {
    $questionModel = Mage::getModel('evozon_qa/question');
    $product = $questionModel->getCollection()->addFieldToFilter('text', $question['text']);
    if ($product->getSize() == 0) {
        $questionModel->setData($question)
                ->save();
        $questionId = $questionModel->getData('question_id');
        if ($answersCount <= count($answers) - 1) {
            $answers[$answersCount]['question_id'] = $questionId;
            $answersCount++;
        }
        Mage::log("Question added!", null, "scripts.log");
    } else {
        Mage::log("Question exists!", null, "scripts.log");
    }
}

foreach ($answers as $answer) {
    $answerModel = Mage::getModel('evozon_qa/answer');
    $product = $answerModel->getCollection()->addFieldToFilter('answer', $answer['answer']);
    if ($product->getSize() == 0) {
        $answerModel->setData($answer)
                ->save();
        Mage::log("Answer added!", null, "scripts.log");
    } else {
        Mage::log("Answer exists!", null, "scripts.log");
    }
}

Mage::log('Ended data-install-0.1.0', null, 'scripts.log');
