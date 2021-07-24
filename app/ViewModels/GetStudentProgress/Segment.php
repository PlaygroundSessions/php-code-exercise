<?php
declare(strict_types=1);

namespace App\ViewModels\GetStudentProgress;

class Segment
{
    public function __construct(
        public int $id,
        public int $lessonId,
        public string $name,
        public int $order,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
        public array $practiceRecords,
    )
    {
        foreach ($practiceRecords as $practiceRecord) {
            $this->addPracticeRecord($practiceRecord);
        }
    }

    private function addPracticeRecord(PracticeRecord $practiceRecord): void
    {
        $this->practiceRecords[] = $practiceRecord;
    }
}
