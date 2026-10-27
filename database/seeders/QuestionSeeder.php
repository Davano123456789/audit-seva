<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

/**
 * Mengisi pertanyaan kuesioner dari database/seeders/data/questions.php.
 * Aman dijalankan berulang: pertanyaan yang sudah ada tidak dibuat ganda.
 */
class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $data = require database_path('seeders/data/questions.php');

        foreach ($data as $levels) {
            foreach ($levels as $level => $practices) {
                foreach ($practices as $practiceCode => $questions) {
                    foreach ($questions as $text) {
                        Question::firstOrCreate([
                            'practice_code' => $practiceCode,
                            'level' => $level,
                            'question_text' => $text,
                        ]);
                    }
                }
            }
        }
    }
}
