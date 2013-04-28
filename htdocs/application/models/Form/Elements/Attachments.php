<?php
/**
 * @class Form_Elements_Attachments
 */
class Form_Elements_Attachments extends Form_Elements
{
    
    /**
     * 
     * @return Zend_Form_Element[]
     */
    public function getElements()
    {
        $elements = array();
        $labels = array();
        
        for ($i = 1; $i < 6; $i++)
        {
            $file = new Form_Element_File(ParamIdEnum::FILE . "_" . $i);
            $file->setLabel(str_replace("%%value%%", $i, $this->_getTranslator()->translate('label-photo')))
                ->addValidator(new Validate_File_Extension(array('jpg', 'jpeg','gif', 'png')))
                ->setDestination(APPLICATION_PATH . '/../public/uploads');
            
            $labels[$i] = $this->_getTranslator()->translate('caption-photo') . " " . $i;
            $elements[] = $file;
        }
        
        $radio = new Form_Element_Radio(FieldIdEnum::AUCTION_FILE_ID);
        $radio->setRequired()
            ->setLabel($this->_getTranslator()->translate('label-thumbnail'))
            ->setMultiOptions($labels);
        
        $elements[] = $radio;
        
        return $elements;
    }
}
