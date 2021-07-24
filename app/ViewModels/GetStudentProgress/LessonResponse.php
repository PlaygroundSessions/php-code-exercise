<?php
declare(strict_types=1);

namespace App\ViewModels\GetStudentProgress;

use App\ViewModels\LessonCsv\LessonCsvRow;

class LessonResponse implements \IteratorAggregate
{
    public array $segments;

    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public int $difficulty,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
        public bool $isPublished,
        array $segments,
    )
    {
        foreach ($segments as $segment) {
            $this->addSegment($segment);
        }
    }

    private function addSegment(Segment $segment): void
    {
        $this->segments[] = $segment;
    }

    public static function createLessonResponseFromRow(LessonCsvRow $row, array $segments): LessonResponse
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

    public function getIterator()
    {
        return new \ArrayIterator($this);
    }
}
