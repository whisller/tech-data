<?php

namespace Whisller\TechData;

use DOMDocument;
use Whisller\TechData\Exceptions\TechDataValidatorException;

class TechDataValidator
{
    protected $errors = [];

    public function validate($xml, $xsd)
    {
        set_error_handler([$this, 'onValidateError']);

        $document = new DOMDocument();
        $document->loadXML($xml);
        $document->schemaValidate($xsd);

        restore_error_handler();

        if (count($this->errors) > 0) {
            throw new TechDataValidatorException(sprintf("Your XML file is not valid: [%s]", implode("\n", $this->errors)));
        }
    }

    public function onValidateError($errno, $errstr, $errfile, $errline)
    {
        $this->errors[] = $errstr;
    }
}
