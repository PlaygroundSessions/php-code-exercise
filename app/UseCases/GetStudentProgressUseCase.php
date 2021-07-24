<?php
declare(strict_types=1);

namespace App\UseCases;

use App\UseCases\DependencyInterfaces\LessonCsvInterface;
use App\UseCases\DependencyInterfaces\LessonCsvRowInterface;
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

            $practiceRecordsForCurrentSegment[] = self::createPracticeRecordFromRow($currentRow);

            $isNewSegment = $nextRow->getSegmentOrder() !== $currentSegmentId;

            if ($isNewSegment) {
                $segmentsForCurrentLesson[] = self::getSegmentFromRow($currentRow, $practiceRecordsForCurrentSegment);
                $practiceRecordsForCurrentSegment = [];
            }

            $isNewLesson = $nextRow->getLessonId() !== $currentLessonId;

            if ($isNewLesson) {
                $lessons[] = self::createLessonResponseFromRow($currentRow, $segmentsForCurrentLesson);
                $segmentsForCurrentLesson = [];
            }

            $currentRow = $nextRow;
        }

        return $lessons;
    }

    public static function createLessonResponseFromRow(LessonCsvRowInterface $row, array $segments): LessonResponse
    {
        return new LessonResponse(
            id: $row->getLessonId(),
            name: $row->getLessonName(),
            description: $row->getLessonDescription(),
            difficulty: $row->getLessonDifficulty(),
            createdAt: $row->getLessonCreatedAt(),
            updatedAt: $row->getLessonUpdatedAt(),
            isPublished: $row->isLessonPublished(),
            segments: $segments,
        );
    }

    public static function getSegmentFromRow(LessonCsvRowInterface $row, array $practiceRecords): Segment
    {
        return new Segment(
            id: $row->getSegmentId(),
            lessonId: $row->getSegmentLessonId(),
            name: $row->getSegmentName(),
            order: $row->getSegmentOrder(),
            createdAt: $row->getSegmentCreatedAt(),
            updatedAt: $row->getSegmentUpdatedAt(),
            practiceRecords: $practiceRecords,
        );
    }

    public static function createPracticeRecordFromRow(LessonCsvRowInterface $row): PracticeRecord
    {
        return new PracticeRecord(
            id: $row->getPracticeRecordId(),
            segmentId: $row->getPracticeRecordSegmentId(),
            userId: $row->getPracticeRecordUserId(),
            sessionUuid: $row->getPracticeRecordSessionUuid(),
            tempoMultiplier: $row->getPracticeRecordTempoMultiplier(),
            createdAt: $row->getPracticeRecordCreatedAt(),
            updatedAt: $row->getPracticeRecordUpdatedAt(),
            score: $row->getPracticeRecordScore(),
        );
    }
}
