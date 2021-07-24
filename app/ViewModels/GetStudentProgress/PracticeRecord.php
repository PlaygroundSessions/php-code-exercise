<?php
declare(strict_types=1);

namespace App\ViewModels\GetStudentProgress;

use App\UseCases\DependencyInterfaces\LessonCsvRowInterface;

class PracticeRecord
{
    public function __construct(
        public int $id,
        public int $segmentId,
        public int $userId,
        public string $sessionUuid,
        public float $tempoMultiplier,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
        public int $score,
    )
    {
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
