<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as CoreForm;

abstract class FormRequest extends CoreForm
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @origin LAR
     * @return array
     */
    public function rules()
    {
        return [
                    //define on children if required
        ];
    }

    /**
     * Eventualmente manipola i dati di SUBMIT prima di VALIDATE
     * Esempio classico:
     * una data potrebbe essere divisa in 3 campi /select/: giorno, mese, anno.
     * Ma il campo da validare è solo data_nascita, formato da anno-mese-giorno (tipico per SQL)
     * Quindi ["data_nascita" => sprintf("%d-%d-%d", $this->input("anno"), $this->input("mese"), $this->input("giorno"))
     *
     * @origin CST
     * @return array
     */
    protected function validationMutators(): array
    {
        return [
            //define on children if required
        ];
    }

    protected function getInRule(array $set): string
    {
        return "in:" . implode(",", $set);
    }
    
}