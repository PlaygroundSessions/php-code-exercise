<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;

class StudentProgressController extends Controller
{
    public function get(int $userId): JsonResponse
    {
        /** @var Lesson[] $lessons */
        $lessons = Lesson::with(['segments','segments.practiceRecords' => function(HasMany $query) use ($userId) {
            $query->where('user_id', $userId);
        }])
            ->where('is_published',true)
            ->get();

        $csv = new CsvFile();

        $firstLesson = $lessons[0];
        $lessonHeader = array_keys($firstLesson->attributesToArray());
        $firstSegment = $firstLesson->segments[0];
        $segmentHeader = array_keys($firstSegment->attributesToArray());
        $firstPracticeRecord = $firstSegment->practiceRecords[0];
        $practiceRecordHeader = array_keys($firstPracticeRecord->attributesToArray());

        $header = [];

        foreach ($lessonHeader as $headerValue) {
            $header[] = 'lesson_' . $headerValue;
        }

        foreach ($segmentHeader as $headerValue) {
            $header[] = 'segment_' . $headerValue;
        }

        foreach ($practiceRecordHeader as $headerValue) {
            $header[] = 'practice_record_' . $headerValue;
        }

        $csv->addRow($header);

        foreach ($lessons as $lesson) {
            foreach ($lesson->segments as $segment) {
                foreach ($segment->practiceRecords as $practiceRecord) {
                    $lessonValues = array_values($lesson->attributesToArray());
                    $segmentValues = array_values($segment->attributesToArray());
                    $practiceRecordValues = array_values($practiceRecord->attributesToArray());
                    $row = array_merge($lessonValues, $segmentValues, $practiceRecordValues);
                    $csv->addRow($row);
                }
            }
        }

        $csv->export('data.csv');
        exit;
    }
}

class CsvFile
{
    private $fp;

    public function __construct()
    {
        $this->fp = tmpfile();
    }

    public function addRow(array $columns = []): void
    {
        fputcsv($this->fp, $columns);
    }

    public function export($filename)
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fseek($this->fp, 0);
        fpassthru($this->fp);
        exit;
    }
}
