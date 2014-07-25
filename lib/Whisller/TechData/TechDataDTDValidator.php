<?php

namespace Whisller\TechData;

use DOMDocument;
use Whisller\TechData\Exceptions\TechDataException;

class TechDataDTDValidator
{
    protected $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function validate($xml)
    {
        set_error_handler([$this, 'onValidateError']);

        $document = new DOMDocument();
        $document->loadXML($xml);
        $document->validate();

        if (count($this->errors) > 0) {
            throw new TechDataException(sprintf("Your XML file is not valid: [%s]", implode("\n", $this->errors)));
        }
    }

    public function onValidateError($errno, $errstr, $errfile, $errline)
    {
        $this->errors[] = $errstr;
    }
}
