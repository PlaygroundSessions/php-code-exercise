<?php

namespace App\UseCases\DependencyInterfaces;

interface LessonCsvRowInterface
{
    /**
     * @return int
     */
    public function getLessonId(): int;

    /**
     * @return string
     */
    public function getLessonName(): string;

    /**
     * @return string
     */
    public function getLessonDescription(): string;

    /**
     * @return int
     */
    public function getLessonDifficulty(): int;

    /**
     * @return \DateTime
     */
    public function getLessonCreatedAt(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getLessonUpdatedAt(): \DateTime;

    /**
     * @return bool
     */
    public function isLessonPublished(): bool;

    /**
     * @return int
     */
    public function getSegmentId(): int;

    /**
     * @return int
     */
    public function getSegmentLessonId(): int;

    /**
     * @return string
     */
    public function getSegmentName(): string;

    /**
     * @return int
     */
    public function getSegmentOrder(): int;

    /**
     * @return \DateTime
     */
    public function getSegmentCreatedAt(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getSegmentUpdatedAt(): \DateTime;

    /**
     * @return int
     */
    public function getPracticeRecordId(): int;

    /**
     * @return int
     */
    public function getPracticeRecordSegmentId(): int;

    /**
     * @return int
     */
    public function getPracticeRecordUserId(): int;

    /**
     * @return string
     */
    public function getPracticeRecordSessionUuid(): string;

    /**
     * @return float
     */
    public function getPracticeRecordTempoMultiplier(): float;

    /**
     * @return \DateTime
     */
    public function getPracticeRecordCreatedAt(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getPracticeRecordUpdatedAt(): \DateTime;

    /**
     * @return int
     */
    public function getPracticeRecordScore(): int;
}
