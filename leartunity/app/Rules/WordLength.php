<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WordLength implements Rule
{
    protected $minWords;
    protected $maxWords;

    public function __construct($minWords, $maxWords)
    {
        $this->minWords = $minWords;
        $this->maxWords = $maxWords;
    }

    public function passes($attribute, $value)
    {
        $wordCount = str_word_count(trim($value)); // Count words in the string

        return $wordCount >= $this->minWords && $wordCount <= $this->maxWords;
    }

    public function message()
    {
        return "The :attribute must be between {$this->minWords} and {$this->maxWords} words.";
    }
}
