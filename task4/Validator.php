<?php
/**
 * Class Validator
 *
 * A class that provides methods for validating form data using callback functions.
 */
class Validator
{
    private $validations = [];

    /**
     * Adds a validation rule for a specific field.
     *
     * @param string $field The name of the field to validate.
     * @param callable $callback The validation callback function.
     * @param string $errorMessage The error message to display if the validation fails.
     * @return void
     */
    public function addValidation($field, $callback, $errorMessage)
    {
        $this->validations[$field][] = ['callback' => $callback, 'errorMessage' => $errorMessage];
    }

    /**
     * Method for performing all validations for a given field.
     *
     * @param string $field The field to validate.
     * @param mixed $value The value to validate.
     * @return array An array of validation errors, if any.
     */
    public function validateField($field, $value)
    {
        $errors = [];
        if (isset($this->validations[$field])) {
            foreach ($this->validations[$field] as $validation) {
                if (!$validation['callback']($value)) {
                    $errors[$field][] = $validation['errorMessage'];
                }
            }
        }
        return $errors;
    }

    /**
     * Validates a form by iterating through the given data and validating each field.
     *
     * @param array $data The data to be validated.
     * @return array An array of validation errors, if any.
     */
    public function validateForm($data)
    {
        $errors = [];
        foreach ($data as $field => $value) {
            if ($error = $this->validateField($field, $value)) {
                $errors = array_merge($errors, $error);
            }
        }
        return $errors;
    }
}