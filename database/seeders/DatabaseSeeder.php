<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $backendCategory = SkillCategory::create(['name' => 'Back-end']);
        $frontendCategory = SkillCategory::create(['name' => 'Front-end']);
        $mobileCategory = SkillCategory::create(['name' => 'Mobile']);
        $machineLearningCategory = SkillCategory::create(['name' => 'Machine Learning']);
        $toolsCategory = SkillCategory::create(['name' => 'Tools & Platforms']);

        $skills = new Collection([
            Skill::create(['name' => 'PHP', 'category_id' => $backendCategory->id]),
            Skill::create(['name' => 'Laravel', 'category_id' => $backendCategory->id]),
            Skill::create(['name' => 'Node.js', 'category_id' => $backendCategory->id]),

            Skill::create(['name' => 'JavaScript', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'Vue.js', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'React', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'Tailwind CSS', 'category_id' => $frontendCategory->id]),

            Skill::create(['name' => 'MySQL', 'category_id' => $backendCategory->id]),
            Skill::create(['name' => 'PostgreSQL', 'category_id' => $backendCategory->id]),

            Skill::create(['name' => 'Flutter', 'category_id' => $mobileCategory->id]),
            Skill::create(['name' => 'Dart', 'category_id' => $mobileCategory->id]),

            Skill::create(['name' => 'TensorFlow', 'category_id' => $machineLearningCategory->id]),
            Skill::create(['name' => 'PyTorch', 'category_id' => $machineLearningCategory->id]),

            Skill::create(['name' => 'Git', 'category_id' => $toolsCategory->id]),
            Skill::create(['name' => 'Docker', 'category_id' => $toolsCategory->id]),
            Skill::create(['name' => 'AWS', 'category_id' => $toolsCategory->id]),
            Skill::create(['name' => 'Linux', 'category_id' => $toolsCategory->id]),
        ]);

        $webAppCategory = ProjectCategory::create(['name' => 'Web Application']);
        $mobileAppCategory = ProjectCategory::create(['name' => 'Mobile App']);
        $backendCategory = ProjectCategory::create(['name' => 'Backend']);
        $machineLearningCategory = ProjectCategory::create(['name' => 'Machine Learning']);
    }
}
