<?php
declare(strict_types=1);

namespace App\ViewModels\LessonCsv;

use App\UseCases\DependencyInterfaces\LessonCsvRowInterface;

class LessonCsvRow implements LessonCsvRowInterface
{
    public function __construct(
        private int $lessonId,
        private string $lessonName,
        private string $lessonDescription,
        private int $lessonDifficulty,
        private \DateTime $lessonCreatedAt,
        private \DateTime $lessonUpdatedAt,
        private bool $isLessonPublished,
        private int $segmentId,
        private int $segmentLessonId,
        private string $segmentName,
        private int $segmentOrder,
        private \DateTime $segmentCreatedAt,
        private \DateTime $segmentUpdatedAt,
        private int $practiceRecordId,
        private int $practiceRecordSegmentId,
        private int $practiceRecordUserId,
        private string $practiceRecordSessionUuid,
        private float $practiceRecordTempoMultiplier,
        private \DateTime $practiceRecordCreatedAt,
        private \DateTime $practiceRecordUpdatedAt,
        private int $practiceRecordScore,
    )
    {
    }

    /**
     * @return int
     */
    public function getLessonId(): int
    {
        return $this->lessonId;
    }

    /**
     * @return string
     */
    public function getLessonName(): string
    {
        return $this->lessonName;
    }

    /**
     * @return string
     */
    public function getLessonDescription(): string
    {
        return $this->lessonDescription;
    }

    /**
     * @return int
     */
    public function getLessonDifficulty(): int
    {
        return $this->lessonDifficulty;
    }

    /**
     * @return \DateTime
     */
    public function getLessonCreatedAt(): \DateTime
    {
        return $this->lessonCreatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getLessonUpdatedAt(): \DateTime
    {
        return $this->lessonUpdatedAt;
    }

    /**
     * @return bool
     */
    public function isLessonPublished(): bool
    {
        return $this->isLessonPublished;
    }

    /**
     * @return int
     */
    public function getSegmentId(): int
    {
        return $this->segmentId;
    }

    /**
     * @return int
     */
    public function getSegmentLessonId(): int
    {
        return $this->segmentLessonId;
    }

    /**
     * @return string
     */
    public function getSegmentName(): string
    {
        return $this->segmentName;
    }

    /**
     * @return int
     */
    public function getSegmentOrder(): int
    {
        return $this->segmentOrder;
    }

    /**
     * @return \DateTime
     */
    public function getSegmentCreatedAt(): \DateTime
    {
        return $this->segmentCreatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getSegmentUpdatedAt(): \DateTime
    {
        return $this->segmentUpdatedAt;
    }

    /**
     * @return int
     */
    public function getPracticeRecordId(): int
    {
        return $this->practiceRecordId;
    }

    /**
     * @return int
     */
    public function getPracticeRecordSegmentId(): int
    {
        return $this->practiceRecordSegmentId;
    }

    /**
     * @return int
     */
    public function getPracticeRecordUserId(): int
    {
        return $this->practiceRecordUserId;
    }

    /**
     * @return string
     */
    public function getPracticeRecordSessionUuid(): string
    {
        return $this->practiceRecordSessionUuid;
    }

    /**
     * @return float
     */
    public function getPracticeRecordTempoMultiplier(): float
    {
        return $this->practiceRecordTempoMultiplier;
    }

    /**
     * @return \DateTime
     */
    public function getPracticeRecordCreatedAt(): \DateTime
    {
        return $this->practiceRecordCreatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getPracticeRecordUpdatedAt(): \DateTime
    {
        return $this->practiceRecordUpdatedAt;
    }

    /**
     * @return int
     */
    public function getPracticeRecordScore(): int
    {
        return $this->practiceRecordScore;
    }
}
