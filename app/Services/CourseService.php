<?php

namespace App\Services;

use App\Models\Course;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CourseService
{
    public function storeCourse(array $data)
    {
        return DB::transaction(function () use ($data) {

            // Upload files
            if (isset($data['feature_video']) && $data['feature_video'] instanceof UploadedFile) {
                $data['feature_video'] = $data['feature_video']->store('courses/videos', 'public');
            }

            if (isset($data['meta_image']) && $data['meta_image'] instanceof UploadedFile) {
                $data['meta_image'] = $data['meta_image']->store('courses/images', 'public');
            }

            //Create course
            $course = Course::create([
                'title'            => $data['title'],
                'description'      => $data['description'],
                'category'         => $data['category'],
                'feature_video'    => $data['feature_video'],
                'price'            => $data['price'],
                'meta_title'       => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords'    => $data['meta_keywords'] ?? null,
                'meta_image'       => $data['meta_image'] ?? null,
                'google_schema'    => $data['google_schema'] ?? null,
            ]);

            //Create modules and contents
            foreach ($data['modules'] as $moduleData) {
                $module = $course->modules()->create([
                    'title'       => $moduleData['title'],
                    'description' => $moduleData['description'],
                    'duration'    => $moduleData['duration'] ?? null,
                ]);

                foreach ($moduleData['contents'] as $contentData) {
                    $module->contents()->create([
                        'course_id'  => $course->id,
                        'title'      => $contentData['title'],
                        'type'       => $contentData['type'],
                        'video_url'  => $contentData['video_url'] ?? null,
                        'duration'   => $contentData['duration'] ?? null,
                    ]);
                }
            }

            return $course->load('modules.contents');
        });
    }
}