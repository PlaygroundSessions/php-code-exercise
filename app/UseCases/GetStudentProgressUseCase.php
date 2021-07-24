<?php
declare(strict_types=1);

namespace App\UseCases;

use App\UseCases\DependencyInterfaces\LessonCsvInterface;
use App\ViewModels\GetStudentProgress\LessonResponse;
use App\ViewModels\GetStudentProgress\PracticeRecord;
use App\ViewModels\GetStudentProgress\Segment;

class GetStudentProgressUseCase
{
    public function __construct(private LessonCsvInterface $csv)
    {
    }

    /** @return \App\ViewModels\GetStudentProgress\LessonResponse[] */
    public function getAllLessons(int $userId): array
    {
        $lessons = [];
        $currentLessonId = 0;
        $currentSegmentId = 0;
        $currentRow = $this->csv->getNextRow();
        $practiceRecordsForCurrentSegment = [];
        $segmentsForCurrentLesson = [];

        while ($nextRow = $this->csv->getNextRow()) {
            $isForCurrentUser = $nextRow->getPracticeRecordUserId() === $userId;

            if (!$isForCurrentUser) {
                continue;
            }

            $practiceRecordsForCurrentSegment[] = PracticeRecord::createPracticeRecordFromRow($currentRow);

            $isNewSegment = $nextRow->getSegmentOrder() !== $currentSegmentId;

            if ($isNewSegment) {
                $segmentsForCurrentLesson[] = Segment::getSegmentFromRow($currentRow, $practiceRecordsForCurrentSegment);
                $practiceRecordsForCurrentSegment = [];
            }

            $isNewLesson = $nextRow->getLessonId() !== $currentLessonId;

            if ($isNewLesson) {
                $lessons[] = LessonResponse::createLessonResponseFromRow($currentRow, $segmentsForCurrentLesson);
                $segmentsForCurrentLesson = [];
            }

            $currentRow = $nextRow;
        }

        return $lessons;
    }
}
