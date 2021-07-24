<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class StudentProgressController extends Controller
{
    public function get(int $userId): JsonResponse
    {
        return response()->json((array)(new LessonCsv())->getAllLessons($userId));
    }
}

class LessonCsv
{
    const LARAVEL_DEFAULT_DATE_FORMAT = 'Y-m-d\TH:i:s\.uT';

    private $fp;

    public function __construct()
    {
        $this->fp = fopen('../data.csv', 'r');
        $this->discardRow(); // The header has column names, not data
    }

    private function discardRow(): void
    {
        fgetcsv($this->fp);
    }

    private function getRow(): ?LessonCsvRow
    {
        $row = fgetcsv($this->fp);

        if ($row === false) {
            return null;
        }

        return new LessonCsvRow(
            (int)$row[0],
            (string)$row[1],
            (string)$row[2],
            (int)$row[3],
            \DateTime::createFromFormat(self::LARAVEL_DEFAULT_DATE_FORMAT, (string)$row[4]),
            \DateTime::createFromFormat(self::LARAVEL_DEFAULT_DATE_FORMAT, (string)$row[5]),
            (bool)$row[6],
            (int)$row[7],
            (int)$row[8],
            (string)$row[9],
            (int)$row[10],
            \DateTime::createFromFormat(self::LARAVEL_DEFAULT_DATE_FORMAT, (string)$row[11]),
            \DateTime::createFromFormat(self::LARAVEL_DEFAULT_DATE_FORMAT, (string)$row[12]),
            (int)$row[13],
            (int)$row[14],
            (int)$row[15],
            (string)$row[16],
            (float)$row[17],
            \DateTime::createFromFormat(self::LARAVEL_DEFAULT_DATE_FORMAT, (string)$row[18]),
            \DateTime::createFromFormat(self::LARAVEL_DEFAULT_DATE_FORMAT, (string)$row[19]),
            (int)$row[20],
        );
    }

    /** @return LessonResponse[] */
    public function getAllLessons(int $userId): array
    {
        $lessons = [];
        $currentLessonId = 0;
        $currentSegmentId = 0;
        $currentRow = $this->getRow();
        $practiceRecordsForCurrentSegment = [];
        $segmentsForCurrentLesson = [];

        while ($nextRow = $this->getRow()) {
            $isForCurrentUser = $nextRow->practiceRecordUserId === $userId;

            if (!$isForCurrentUser) {
                continue;
            }

            $practiceRecordsForCurrentSegment[] = self::getPracticeRecordFromRow($currentRow);

            $isNewSegment = $nextRow->segmentId !== $currentSegmentId;

            if ($isNewSegment) {
                $segmentsForCurrentLesson[] = self::getSegmentFromRow($currentRow, $practiceRecordsForCurrentSegment);
                $practiceRecordsForCurrentSegment = [];
            }

            $isNewLesson = $nextRow->lessonId !== $currentLessonId;

            if ($isNewLesson) {
                $lessons[] = self::getLessonResponseFromRow($currentRow, $segmentsForCurrentLesson);
                $segmentsForCurrentLesson = [];
            }

            $currentRow = $nextRow;
        }

        return $lessons;
    }

    private static function getLessonResponseFromRow(LessonCsvRow $row, array $segments): LessonResponse
    {
        return new LessonResponse(
            $row->lessonId,
            $row->lessonName,
            $row->lessonDescription,
            $row->lessonDifficulty,
            $row->lessonCreatedAt,
            $row->lessonUpdatedAt,
            $row->isLessonPublished,
            $segments,
        );
    }

    private static function getSegmentFromRow(LessonCsvRow $row, array $practiceRecords): Segment
    {
        return new Segment(
            $row->segmentId,
            $row->segmentLessonId,
            $row->segmentName,
            $row->segmentOrder,
            $row->segmentCreatedAt,
            $row->segmentUpdatedAt,
            $practiceRecords,
        );
    }

    private static function getPracticeRecordFromRow(LessonCsvRow $row): PracticeRecord
    {
        return new PracticeRecord(
            $row->practiceRecordId,
            $row->practiceRecordSegmentId,
            $row->practiceRecordUserId,
            $row->practiceRecordSessionUuid,
            $row->practiceRecordTempoMultiplier,
            $row->practiceRecordCreatedAt,
            $row->practiceRecordUpdatedAt,
            $row->practiceRecordScore,
        );
    }
}

class LessonCsvRow
{
    public function __construct(
        public int $lessonId,
        public string $lessonName,
        public string $lessonDescription,
        public int $lessonDifficulty,
        public \DateTime $lessonCreatedAt,
        public \DateTime $lessonUpdatedAt,
        public bool $isLessonPublished,
        public int $segmentId,
        public int $segmentLessonId,
        public string $segmentName,
        public int $segmentOrder,
        public \DateTime $segmentCreatedAt,
        public \DateTime $segmentUpdatedAt,
        public int $practiceRecordId,
        public int $practiceRecordSegmentId,
        public int $practiceRecordUserId,
        public string $practiceRecordSessionUuid,
        public float $practiceRecordTempoMultiplier,
        public \DateTime $practiceRecordCreatedAt,
        public \DateTime $practiceRecordUpdatedAt,
        public int $practiceRecordScore,
    ) {}
}

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
    ) {
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
    ) {
        foreach ($practiceRecords as $practiceRecord) {
            $this->addPracticeRecord($practiceRecord);
        }
    }

    private function addPracticeRecord(PracticeRecord $practiceRecord): void
    {
        $this->practiceRecords[] = $practiceRecord;
    }
}

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
    ) {}
}
