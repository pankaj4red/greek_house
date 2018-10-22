<?php

class SchoolChapterSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $schools = include(database_path('seeds/Data/Seed/schools.php'));
        $chapters = include(database_path('seeds/Data/Seed/chapters.php'));

        foreach ($schools as $schoolName) {
            $schoolModel = school_repository()->create([
                'name' => $schoolName,
            ]);
            foreach ($chapters as $chapterName) {
                chapter_repository()->create([
                    'name'      => $chapterName,
                    'school_id' => $schoolModel->id,
                ]);
            }
        }
    }
}