<?php

namespace App\HTML;

class Form{

    private $data;
    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
        
    }

    public function input(string $key, string $label): string{
        $value = $this->getValue($key);
        $type = "text";
        if($key === 'password'){
            $type = 'password';
        }
        return <<<HTML
            <div class="ant-form-item">
                <label for="field{$key}">{$label}</label>
                <input type="{$type}" name="{$key}" id="field{$key}" class="{$this->getInputClass($key)}" value="{$value}" required>
                {$this->getErrorFeedback($key)}
            </div>
HTML;
    }

    public function textarea(string $key, string $label): string{
        $value = $this->getValue($key);
        return <<<HTML
            <div class="ant-form-item">
                <label for="field{$key}">{$label}</label>
                <textarea type="text" name="{$key}" id="field{$key}" class="{$this->getInputClass($key)}" required>{$value}</textarea>
                {$this->getErrorFeedback($key)}
            </div>
HTML;   
    }

    public function select(string $key, string $label, array $options = []): ?string
    {
        $optionsHTML = [];
        $value = $this->getValue($key);
        //dd($value);
        foreach($options as $k => $option){
            $selected = in_array($k, $value) ? ' selected' : '';
            $optionsHTML[] = "<option value=\"$k\"$selected>$option</option>";
        }
        $optionsHTML = implode('', $optionsHTML);
        return <<<HTML
            <div class="ant-form-item">
                <label for="field{$key}">{$label}</label>
                <select type="text" name="{$key}[]" id="field{$key}" class="{$this->getInputClass($key)}" required multiple>{$optionsHTML}</select>
                {$this->getErrorFeedback($key)}
            </div>
HTML; 
    }

    private function getValue(string $key){
        if(is_array($this->data)){
            $value = $this->data[$key] ?? null;
        } else {
            $method = 'get' . str_replace(' ','',ucwords(str_replace('_',' ',$key)));
            $value = method_exists($this->data, $method) ? $this->data->$method() : null;
            if($value instanceof \DateTimeInterface){
                return $value->format('Y-m-d H:i:s');
            }
        }
        return $value;
    }

    private function getInputClass(string $key): string{
        $inputClass = 'ant-input';
        if(isset($this->errors[$key])){
            $inputClass .= ' ant-input-status-error';
        }
        return $inputClass;
    }
    private function getErrorFeedback(string $key): string{
        if(isset($this->errors[$key])){
            if(is_array($this->errors[$key])){
                $error = implode('<br>', $this->errors[$key]);
            }else{
                $error = $this->errors[$key];
            }
            return '<div class="ant-form-item-explain">'.$error.' </div>';
        }
        return '';
    }

    public function setError(string $error, string $key): void{
        $this->errors[$key] = $error;
    }
}

?>