<?php

/*
 *  @author Ilinca Dobre <>
 *  @author Haidu Bogdan <bogdan.haidu@evozon.com>
 */

class Evozon_Qa_Model_Answer extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_qa/answer');
    }

    public function getQuestionById($id)
    {
        $question = $this->getCollection();

        $question->getSelect()
                ->where('question_id = ?', $id);

        return $question;
    }

}
