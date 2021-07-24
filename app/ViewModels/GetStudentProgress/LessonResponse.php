<?php
declare(strict_types=1);

namespace App\ViewModels\GetStudentProgress;

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

    public function getIterator()
    {
        return new \ArrayIterator($this);
    }
}
