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
        return <<<HTML
            <div class="ant-form-item">
                <label for="field{$key}">{$label}</label>
                <input type="text" name="{$key}" id="field{$key}" class="{$this->getInputClass($key)}" value="{$value}" required>
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
return "";
        
    }

    private function getValue(string $key): string{
        if(is_array($this->data)){
            $value = $this->data[$key] ?? null;
        } else {
            $method = 'get' . str_replace(' ','',ucwords(str_replace('_',' ',$key)));
            $value = method_exists($this->data, $method) ? $this->data->$method() : null;
            if($value instanceof \DateTimeInterface){
                return $value->format('Y-m-d H:i:s');
            }
        }
        return $value !== null ? (string) $value : '';
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
            return $invalidFeedback = '<div class="ant-form-item-explain">' . implode('<br>', $this->errors[$key]) . '</div>';
        }
        return '';
    }
}

?>