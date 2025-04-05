<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZhyarCV;

class ZhyarCVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        ZhyarCV::truncate();

        // Create new CV entry
        ZhyarCV::create([
            'title' => 'Zhyar Muhammed Gharib - Web Developer & Creative Designer',
            'content' => "I'm Zhyar Muhammed Gharib from Sulaymaniyah. I'm a skilled web developer with over 5 years of experience in front-end and back-end development, specializing in Laravel, Node.js, Ajax, and React. I am a creative character and skilled animator, a graphic designer with a lot of experience in creating visually stunning designs for print or social media.",
            'file_path' => 'zhyar_cv.pdf',
            'is_active' => true,
            'skills' => json_encode([
                'Development' => ['Unreal Engine', 'Full Stack Development', 'Laravel', 'Node.js', 'React', 'C#', 'Ajax'],
                '3D & Design' => ['Blender 3D Arts', 'Character Creation', 'Character Animation', 'Motion Character'],
                'Design Software' => ['Adobe Photoshop', 'Adobe Premiere Pro', 'Adobe After Effects', 'Filmora'],
                'Office' => ['Microsoft Word', 'Microsoft PowerPoint', 'Microsoft Excel']
            ]),
            'education' => json_encode([
                [
                    'degree' => 'Diploma in Information Technology (IT)',
                    'institution' => 'National Institute of Technologies',
                    'location' => 'Sulaymaniyah',
                    'year_start' => '2020',
                    'year_end' => '2022',
                    'description' => 'IT education focusing on technical skills'
                ],
                [
                    'degree' => 'Social Media Graphic Design',
                    'institution' => 'Bazo Production',
                    'location' => 'Sulaymaniyah',
                    'year_start' => '2024',
                    'year_end' => '2024',
                    'description' => 'Adobe Photoshop specialization'
                ],
                [
                    'degree' => 'Certificate of Achievement in Video Editing',
                    'institution' => 'Global',
                    'location' => 'Sulaymaniyah',
                    'year_start' => '2023',
                    'year_end' => '2023',
                    'description' => 'Filmora video editing'
                ],
                [
                    'degree' => 'Advanced Computer and Mobile Repairing',
                    'institution' => 'Technical Institute',
                    'location' => 'Sulaymaniyah',
                    'year_start' => '2023-03-01',
                    'year_end' => '2023-05-01',
                    'description' => 'Hardware and Software repair'
                ],
                [
                    'degree' => 'Motion Capture',
                    'institution' => 'Hackasully',
                    'location' => 'Sulaymaniyah',
                    'year_start' => '2023-06-24',
                    'year_end' => '2023-06-24',
                    'description' => 'Motion capture techniques and implementation'
                ]
            ]),
            'experience' => json_encode([
                [
                    'position' => 'Character Designer & Animator',
                    'company' => 'FastXPlay',
                    'location' => 'Sulaymaniyah',
                    'year_start' => 'August 2023',
                    'year_end' => 'Present',
                    'responsibilities' => [
                        'Working with a group for over a year as a Game Developer',
                        'Character design and animation for games',
                        'Motion character development'
                    ]
                ],
                [
                    'position' => 'Web Developer',
                    'company' => 'My Office',
                    'location' => 'Sulaymaniyah',
                    'year_start' => 'January 2022',
                    'year_end' => 'Present',
                    'responsibilities' => [
                        'Three years\' experience in creating and publishing several different websites',
                        'Full-stack development using Laravel and React',
                        'Client consultation and website maintenance'
                    ]
                ],
                [
                    'position' => 'Website Developer',
                    'company' => 'Briar Ali Online Course',
                    'location' => 'Sulaymaniyah',
                    'year_start' => 'January 17, 2024',
                    'year_end' => 'April 4, 2024',
                    'responsibilities' => [
                        'Development of online learning platform',
                        'Integration of course materials and payment systems',
                        'User experience optimization'
                    ]
                ],
                [
                    'position' => 'Website Developer',
                    'company' => 'Harem Hospital',
                    'location' => 'Sulaymaniyah',
                    'year_start' => 'July 2022',
                    'year_end' => 'September 2022',
                    'responsibilities' => [
                        'Updating the hospital website',
                        'Creating PPID for patients',
                        'Integration of patient management systems'
                    ]
                ],
                [
                    'position' => 'Motion Capture Project',
                    'company' => 'Hackasuly',
                    'location' => 'Sulaymaniyah',
                    'year_start' => 'June 2023',
                    'year_end' => 'July 2023',
                    'responsibilities' => [
                        'Presented the Motion Capture project',
                        'Developed character movement systems',
                        'Technical implementation of motion capture technology'
                    ]
                ]
            ]),
            'certifications' => json_encode([
                [
                    'name' => 'Information Technology Diploma',
                    'issuer' => 'National Institute of Technologies',
                    'year' => '2022',
                    'description' => 'Comprehensive IT education'
                ],
                [
                    'name' => 'Social Media Graphic Design',
                    'issuer' => 'Bazo Production',
                    'year' => '2024',
                    'description' => 'Adobe Photoshop specialization'
                ],
                [
                    'name' => 'Video Editing',
                    'issuer' => 'Global',
                    'year' => '2023',
                    'description' => 'Certificate of achievement in Filmora'
                ],
                [
                    'name' => 'Advanced Computer and Mobile Repairing',
                    'issuer' => 'Technical Institute',
                    'year' => '2023',
                    'description' => 'Hardware and Software repair'
                ],
                [
                    'name' => 'Motion Capture',
                    'issuer' => 'Hackasully',
                    'year' => '2023',
                    'description' => 'Motion capture techniques'
                ]
            ])
        ]);
    }
} 