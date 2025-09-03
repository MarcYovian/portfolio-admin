<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
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
        User::create([
            'name' => 'Marcellinus Yovian Indrastata',
            'email' => 'marcellinusyovian@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $backendCategory = SkillCategory::create(['name' => 'Back-end']);
        $frontendCategory = SkillCategory::create(['name' => 'Front-end']);
        $mobileCategory = SkillCategory::create(['name' => 'Mobile']);
        $machineLearningCategory = SkillCategory::create(['name' => 'Machine Learning']);
        $toolsCategory = SkillCategory::create(['name' => 'Tools & Platforms']);

        $skills = new Collection([
            Skill::create(['name' => 'PHP', 'category_id' => $backendCategory->id]),
            Skill::create(['name' => 'Laravel', 'category_id' => $backendCategory->id]),
            Skill::create(['name' => 'Python', 'category_id' => $backendCategory->id]),
            Skill::create(['name' => 'MySQL', 'category_id' => $backendCategory->id]),

            Skill::create(['name' => 'Vue.js', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'JavaScript', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'JQuery', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'Tailwind CSS', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'Bootstrap', 'category_id' => $frontendCategory->id]),
            Skill::create(['name' => 'Livewire', 'category_id' => $frontendCategory->id]),

            Skill::create(['name' => 'Flutter', 'category_id' => $mobileCategory->id]),
            Skill::create(['name' => 'Dart', 'category_id' => $mobileCategory->id]),
            Skill::create(['name' => 'Firebase', 'category_id' => $mobileCategory->id]),

            Skill::create(['name' => 'TensorFlow', 'category_id' => $machineLearningCategory->id]),
            Skill::create(['name' => 'PyTorch', 'category_id' => $machineLearningCategory->id]),
            Skill::create(['name' => 'Scikit-Learn', 'category_id' => $machineLearningCategory->id]),
            Skill::create(['name' => 'Pandas', 'category_id' => $machineLearningCategory->id]),
            Skill::create(['name' => 'Numpy', 'category_id' => $machineLearningCategory->id]),
            Skill::create(['name' => 'Hugging Face', 'category_id' => $machineLearningCategory->id]),

            Skill::create(['name' => 'Git', 'category_id' => $toolsCategory->id]),
            Skill::create(['name' => 'GitHub', 'category_id' => $toolsCategory->id]),
        ]);

        $services = new Collection([
            Service::create([
                'title' => 'Web Development',
                'description' => 'Responsive and user-friendly websites with modern design and optimized performance.',
                'icon' => 'heroicon-o-globe-alt',
                'features' => [
                    ["feature_name" => "Responsive design"],
                    ["feature_name" => "Optimized performance"],
                    ["feature_name" => "User-friendly interface"],
                    ["feature_name" => "SEO-friendly"],
                ],
            ]),
            Service::create([
                'title' => 'Mobile App Development',
                'description' => 'Creating cross-platform mobile applications with seamless user experience and robust functionality.',
                'icon' => 'heroicon-o-device-phone-mobile',
                'features' => [
                    ["feature_name" => "Cross-platform compatibility"],
                    ["feature_name" => "Seamless user experience"],
                    ["feature_name" => "Robust functionality"],
                ],
            ]),
            Service::create([
                'title' => 'API Development',
                'description' => 'Building secure and scalable APIs to connect applications and services efficiently.',
                'icon' => 'heroicon-o-code',
                'features' => [
                    ["feature_name" => "Secure endpoints"],
                    ["feature_name" => "Scalable architecture"],
                    ["feature_name" => "Comprehensive documentation"],
                ],
            ]),
        ]);

        $experiences = new Collection([
            Experience::create([
                'role' => 'Web Developer (Internship)',
                'company' => 'PT Perkebunan Nusantara I Region V',
                'start_date' => '2024-07-01',
                'end_date' => '2024-12-31',
                'description' => 'Contributed to the development, maintenance, and modernization of several key internal web applications for operational efficiency, including systems for KPI monitoring, payment processing (Superman), and project management (SLA Dashboard).',
                'achievements' => [
                    ['achievement_text' => 'Successfully led the migration of three core internal applications (Superman, E-Sign, Akomodasi Regional) from legacy frameworks like Laravel 6 & CodeIgniter 3 to modern Laravel 10, enhancing system performance, security, and maintainability.'],
                    ['achievement_text' => 'Engineered and deployed multiple APIs to integrate key business systems with third-party platforms like Looker for data analytics and BSSN for digital signatures, as well as enabling real-time mobile notifications via Firebase.'],
                    ['achievement_text' => 'Developed and optimized critical features across various projects, including dynamic monitoring dashboards with Chart.js, server-side data processing to handle large datasets efficiently, and implemented the Service Repository Pattern to improve code structure.'],
                ],
            ])
                ->skills()
                ->attach($skills->whereIn('name', ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'JQuery', 'Bootstrap', 'Firebase'])
                    ->pluck('id')->toArray()),
        ]);

        $educations = new Collection([
            Education::create([
                'degree' => "Bachelor's Degree in Information Technology",
                'institution' => 'Telkom University Surabaya',
                'start_date' => '2021-09-01',
                'end_date' => '2025-08-31',
                'gpa' => 3.87,
                'max_gpa' => 4.00,
                'description' => 'Relevant coursework includes Mobile Programming, Databases, and Algorithms & Data Structures. Actively participated in various events, including the Innovillage Competition 2023 and the Telkom University Open House.',
            ]),
        ]);


        $webAppCategory = ProjectCategory::create(['name' => 'Web Application']);
        $mobileAppCategory = ProjectCategory::create(['name' => 'Mobile App']);
        $backendCategory = ProjectCategory::create(['name' => 'Backend API']);
        $machineLearningCategory = ProjectCategory::create(['name' => 'Machine Learning']);

        $projects = new Collection([
            Project::create([
                'title' => 'St. John the Apostle Chapel Information System',
                'description' => 'Full-stack organizational information system with event scheduling, asset borrowing, and intelligent document management.',
                'image_url' => 'projects/01K42RYW3ADZVYQ7G1BMG892PJ.png',
                'demo_url' => 'https://sinyora.my.id/',
                'github_url' => 'https://github.com/MarcYovian/sinyora-v2',
                'category_id' => $webAppCategory->id,
            ])->skills()->attach($skills->whereIn('name', ['PHP', 'Laravel', 'MySQL', 'Tailwind CSS', 'Livewire'])->pluck('id')->toArray()),
            Project::create([
                'title' => 'Document Processing API',
                'description' => 'Intelligent API for automated document processing, capable of performing OCR, document classification, named entity recognition (NER), and extracting structured information from various document types.',
                'image_url' => 'projects/01K42R1JVC9E6JQCJP1SMRGGCV.png',
                'demo_url' => null,
                'github_url' => 'https://github.com/MarcYovian/document-processing-api',
                'category_id' => $machineLearningCategory->id,
            ])->skills()->attach($skills->whereIn('name', ['Python', 'Flask', 'TensorFlow', 'OpenCV', 'PyTesseract', 'Hugging Face'])->pluck('id')->toArray()),
        ]);
    }
}
